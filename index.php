<!DOCTYPE html>
<html>
    <head>
        <title>Excel XML Importer</title>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" href="css/uikit.min.css" />
        <script src="js/uikit.min.js"></script>
        <script src="js/uikit-icons.min.js"></script>
    </head>
    <body>
        <?php if(isset($_GET['alert']) && $_GET['alert'] === 'error') {
        echo '
        <div class="uk-alert-danger" uk-alert>
            <a class="uk-alert-close" uk-close></a>
            <p>'.$_GET['message'].'</p>
        </div>';
        } elseif (isset($_GET['alert']) && $_GET['alert'] === 'success'){
        echo '
        <div class="uk-alert-success" uk-alert>
            <a class="uk-alert-close" uk-close></a>
            <p>'.$_GET['message'].'</p>
        </div>';
        }
        ?>
        <main class="uk-container uk-margin-top">
            <h1>Excel XML Importer</h1>
            <h3>Imports data from an Excel XML spreadsheet into a MySQL database table</h3>
            <p>Instructions:
                <ol>
                    <li>Save the spreadsheel as an XML spreadsheet. (File -> Save As -> Excel 2004 XML Spreadsheet)</li>
                    <li>Click inside the "Click to select file" text box to select the XML file you just saved.</li>
                    <li>Click "Import" to import the data into the database.</li>
                </ol>
            </p>
            <form class="uk-form-stacked" method="post" action="import_xml.php" enctype="multipart/form-data" >
                <div class="uk-margin" uk-margin>
                    <div uk-form-custom="target: true">
                        <input type="file" name="file">
                        <input class="uk-input uk-form-width-medium" type="text" placeholder="Click to select file" disabled>
                    </div>
                    <button class="uk-button uk-button-primary">Import</button>
                </div>
            </form>
        </main>
    </body>
</html>
