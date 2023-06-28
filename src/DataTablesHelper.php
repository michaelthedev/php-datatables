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
     * @var callable|null
     * @since 0.2
     */
    private $notFoundCallback;

    /**
     * @var callable|null
     * @since 0.2
     */
    private $customCallback;

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
    final public function set(string $tableId, callable $callback):void
    {
        $this->tables[$tableId] = $callback;
    }

    /**
     * Set a custom callback function.
     *
     * @param callable $callback The callback function.
     * @return void
     * @since 0.2
     */
    final public function setCustomCallback(callable $callback):void
    {
        $this->customCallback = $callback;
    }

    /**
     * Set a callback function for when a table is not found.
     *
     * @param callable $callback The callback function.
     * @return void
     * @since 0.2
     */
    final public function setNotFoundCallback(callable $callback):void
    {
        $this->notFoundCallback = $callback;
    }

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

            if (!is_null($this->customCallback)) {
                call_user_func($this->customCallback, $tableId, $data);
            } else {
                // Convert data to JSON
                $jsonData = json_encode($data);

                // Return JSON response
                header('Content-Type: application/json');
                echo $jsonData;
            }
        } else {
            // Table not found
            if (!is_null($this->notFoundCallback)) {
                call_user_func($this->notFoundCallback, $tableId);
            } else {
                http_response_code(404);
                echo "Table not found";
            }
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
