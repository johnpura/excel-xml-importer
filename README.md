# Excel XML Importer

Excel XML Importer is a PHP script to extract the data from an Excel spreadsheet with an .xml file extension into a single MySQL database table.

## Installation

Clone the project into your web root.

```
git clone git@github.com:johnpura/excel-xml-importer.git
```

Import the the `store.sql` SQL script through phpMyAdmin or the MySQL console.

```
mysql < store.sql
```


## Usage

Navigate to `http://localhost/excel-xml-importer/` in a browser to see the output.

Use `store.xml` for the input file.

## Contributing

Pull requests are welcome. For major changes, please open an issue first to discuss what you would like to change.

## License
[MIT](https://choosealicense.com/licenses/mit/)
