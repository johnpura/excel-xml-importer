<?php
/**
 * Imports data from an excel XML document into a MySQL table
 * 
 * @author John Pura <jepura@gmail.com>
 * @version 1.0.0
 * @license MIT
 */

 $log_file = "error.log";

 importXml();

 /**
  * Main funtion to import, extract and insert data from an excel XML document
  * 
  * @return void
  */
function importXml() {

    global $log_file;

    try {
        // first check if a file exists, then if it's an XML document
        //@TODO move validation to its own funtion
        if($_FILES['file']['error'] === 4) {
            header('Location: http://localhost/excel-xml-importer/index.php?alert=error&message=Please select a file to import.');
            throw new Exception("File was not selected");
        } elseif($_FILES['file']['type'] !== 'text/xml') {
            header('Location: http://localhost/excel-xml-importer/index.php?alert=error&message=Invalid file type');
            throw new Exception("The file must have an .xml extension");
        }

        $temp_file = $_FILES['file']['tmp_name'];
        $uploaded_file = dirname(__FILE__) . '/tmp/'. strtolower($_FILES['file']['name']);
        move_uploaded_file($temp_file, $uploaded_file);
        $xmlObject = simplexml_load_file($uploaded_file);
        $dataArray = extractXmlData($xmlObject);
        insertXmlData($dataArray);
        unlink($uploaded_file);

    } catch(Exception $e) {
        $message = date('d.m.Y h:i:s') . "   " .$e->getMessage()."\n";
        error_log($message, 3, $log_file);
        exit;
    }
}

/**
 * Extracts data from the Excel XML spreadsheet
 * 
 * @param   object  $xmlObject  the SimpleXMLElement object
 * @return  array   $dataArray  the rows of data
 */
function extractXmlData($xmlObject) {
    $dataArray = [];
    foreach($xmlObject->Worksheet->Table->Row as $row) {
        $data = array(
            "name" => (string) $row->Cell[0]->Data,
            "hourly_wage" => (int) $row->Cell[1]->Data,
            "years_of_service" => (int) $row->Cell[2]->Data,
        );
        array_push($dataArray, $data);
    }
    return $dataArray;
}

/**
 * Inserts data into a MySQL table
 * 
 * @param  array  $data  the rows of data
 */
function insertXmlData($data) {
    //@TODO dynamically get the table and column names from the worksheet
    $table = "employees";
    $cols = implode(", ", array_keys($data[0]));
    // connect to the database
    $mysqli = new mysqli("localhost", "store", "store", "store");
    if ($mysqli->connect_errno) {
        header('Location: http://localhost/excel-xml-importer/index.php?alert=error&message=Opps, something went wrong.');
        throw new Exception("Failed to connect to database: " . $mysqli->connect_error);
        exit;
    }
    // start with an empty table
    $stmt = 'TRUNCATE TABLE `' . $table . '`;';
    if (!$mysqli->query($stmt)) {
        $mysqli->close();
        header('Location: http://localhost/excel-xml-importer/index.php?alert=error&message=Opps, something went wrong.');
        throw new Exception("There was an issue truncating the table: " . $mysqli->error);

    }
    // insert the data
    for($i = 1; $i < count($data); $i++) {
        $values = implode("', '", array_values($data[$i]));
        $stmt = "INSERT INTO $table ($cols) VALUES ('".$values."');";
        if (!$mysqli->query($stmt)) {
            $mysqli->close();
            header('Location: http://localhost/excel-xml-importer/index.php?alert=error&message=Opps, something went wrong.');
            throw new Exception("There was an issue inserting data: " . $mysqli->error);
        }
    }
    // close the database connection
    $mysqli->close();
    header('Location: http://localhost/excel-xml-importer/index.php?alert=success&message=The spreadsheet data was imported successfully.');
}

?>