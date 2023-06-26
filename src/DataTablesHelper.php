<?php
namespace Michaelthedev\PhpDatatables;

/**
 * DataTablesHelper Class
 *
 * A helper class for managing DataTables in PHP.
 *
 * @category  Library
 * @package   Michaelthedev\PhpDatatables
 * @author    Michael Arawole <mycodemichael@gmail.com>
 * @version   0.1
 */
class DataTablesHelper
{
    /**
     * Store tables and callbacks
     * @var array
     */
    private array $tables = [];

    /**
     * Add a table and callback function.
     *
     * @param string   $tableId  The ID of the table.
     * @param callable $callback The callback function for the table.
     * @return void
     */

    /**
     * Process the request and return the table data as JSON.
     *
     * @param string $tableId The ID of the requested table.
     * @return void
     */
    final public function processTableRequest(string $tableId):void
    {
        if (isset($this->tables[$tableId])) {
            $callback = $this->tables[$tableId];
            $data = call_user_func($callback);

            // Convert data to JSON
            $jsonData = json_encode($data);

            // Return JSON response
            header('Content-Type: application/json');
            echo $jsonData;

            //todo: custom `table callback` handler
        } else {
            // Table not found
            http_response_code(404);
            echo "Table not found";

            //todo: custom `table not found` handler
        }
    }

    /**
     * Get the IDs of all the tables.
     *
     * @return array
     */
    final public function getTableIds(): array
    {
        return array_keys($this->tables);
    }
}
