<?php
require_once 'vendor/autoload.php';

use Michaelthedev\PhpDatatables\DataTablesHelper;

// Create an instance of the DataTablesHelper class
$helper = new DataTablesHelper();

// Table not found callback
$helper->setNotFoundCallback(function (string $tableId) {
    http_response_code(404);
    echo "Table `$tableId` not found";
});

// Custom callback
$helper->setCustomCallback(function (string $tableId, array $data) {
    // Do something with the data
    header('Content-Type: application/json');
    echo json_encode([
        'draw' => 1,
        'recordsTotal' => count($data),
        'recordsFiltered' => count($data),
        'data' => $data
    ]);
});

// Set table callbacks
$helper->set('employees', function () {
    // Your table data retrieval logic here
    return [
        ['id' => 1, 'name' => 'John Doe', 'position' => 'Developer', 'salary' => 5000],
        ['id' => 2, 'name' => 'Jane Smith', 'position' => 'Designer', 'salary' => 4500],
        ['id' => 3, 'name' => 'Mark Johnson', 'position' => 'Project Manager', 'salary' => 6000],
        // ...
    ];
});

$data['draw'] = 1;
$data['search']['value'] = '';
$helper->set('allUsers', function () use ($data) {
    return [
        'draw' => $data['draw'],
        'data' => [
            ['id' => 1, 'name' => 'John Doe', 'position' => 'Developer', 'salary' => 5000],
            ['id' => 2, 'name' => 'Jane Smith', 'position' => 'Designer', 'salary' => 4500],
            ['id' => 3, 'name' => 'Mark Johnson', 'position' => 'Project Manager', 'salary' => 6000]
        ]
    ];
});

// Process table request
if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    if (isset($_GET['tableId'])) {
        $tableId = $_GET['tableId'];
        $helper->processTableRequest($tableId);
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>DataTable Example</title>
    <link rel="stylesheet" type="text/css" href="//cdn.datatables.net/1.11.1/css/jquery.dataTables.min.css">
</head>
<body>
    <h1>Employee Data</h1>
    <table id="employeesTable">
        <thead>
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Position</th>
                <th>Salary</th>
            </tr>
        </thead>
        <tbody>
            <!-- Table body content will be dynamically loaded via DataTables -->
        </tbody>
    </table>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="//cdn.datatables.net/1.11.1/js/jquery.dataTables.min.js"></script>
    <script>
        $(document).ready(function() {
            // Initialize DataTables
            $('#employeesTable').DataTable({
                ajax: {
                    url: 'index.php',
                    type: 'GET',
                    data: { tableId: 'employees' },
                    dataSrc: ''
                },
                columns: [
                    { data: 'id' },
                    { data: 'name' },
                    { data: 'position' },
                    { data: 'salary' }
                ]
            });
        });
    </script>
</body>
</html>
