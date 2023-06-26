<br />
<div align="center">

  <h1 align="center">PHP DataTablesHelper</h1>
</div>

<!-- ABOUT THE PROJECT -->

## About The Project
PHP DataTablesHelper is a library that provides a helper class for managing DataTables in PHP. It allows you to set table callbacks and process requests to retrieve table data as JSON.

### Installation

_How to install._

1. Using composer
   ```javascript
   composer require michaelthedev/php-datatables
   ```
3. Include the generated autoload in your file, See index.php for example


## Usage

To use the DataTablesHelper class, follow these steps:

1. Include the DataTablesHelper class in your PHP file:

    ```php
    use Michaelthedev\PhpDatatables\DataTablesHelper;
    ```

2. Create an instance of the DataTablesHelper class:

    ```php
    $helper = new DataTablesHelper();
    ```

3. Set table callbacks using the `set` method. The table ID is a string identifier for your table, and the callback function should return the table data:

    ```php
    $helper->set('tableIdHere', function () {
        // Your table data retrieval logic here
        return [
            ['col1' => 'val1', 'col2' => 'val2'],
            ['col1' => 'val3', 'col2' => 'val4'],
            // ...
        ];
    });
    ```

4. Process requests to retrieve table data by calling the `processTableRequest` method with the table ID:

    ```php
    $helper->processTableRequest('tableIdHere');
    ```

    This will return the table data as JSON.

5. Optionally, you can retrieve the IDs of all the tables using the `getTableIds` method:

    ```php
    $tableIds = $helper->getTableIds();
    ```

    This will return an array of table IDs that have been set.

## Contributing

Contributions are what make the open source community such an amazing place to learn, inspire, and create. Any contributions you make are **greatly appreciated**.

If you have a suggestion that would make this better, please fork the repo and create a pull request. You can also simply open an issue with the tag "enhancement".
Don't forget to give the project a star! Thanks again!

1. Fork the Project
2. Create your Feature Branch
3. Commit your Changes
4. Push to the Branch
5. Open a Pull Request

### Built With

- [PHP](https://php.net/)

## License

This project is licensed under the [MIT License](LICENSE).