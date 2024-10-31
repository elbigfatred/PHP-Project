<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

header('Content-Type: application/json');

require_once dirname(__DIR__, 1) . '/Database/Classes/ConnectionManager.php';
require_once dirname(__DIR__, 1) . '/Database/Classes/DAO.php';
require_once dirname(__DIR__, 1) . '/Database/Classes/DatabaseConstants.php';

try {
    // Ensure the request method is POST
    if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
        throw new Exception("Invalid request method. POST required.");
    }

    // Retrieve and decode the JSON payload
    $input = json_decode(file_get_contents('php://input'), true);

    // Validate required parameters: table_name and data
    if (!isset($input["table_name"]) || !isset($input["data"])) {
        throw new Exception("Both table_name and data fields are required.");
    }

    // Sanitize table_name and retrieve data fields
    $tableName = htmlspecialchars($input["table_name"]);
    $data = $input["data"];

    // Initialize ConnectionManager and DAO
    $cm = new ConnectionManager(DatabaseConstants::$MYSQL_CONNECTION_STRING, DatabaseConstants::$MYSQL_USERNAME, DatabaseConstants::$MYSQL_PASSWORD);
    $dao = new DAO($cm->getConnection());

    // Call the addItem function
    $success = $dao->updateItem($tableName, $data);

    // Return a JSON response based on success or failure
    if ($success === true) {
        echo json_encode([
            "status" => "success",
            "message" => "Item successfully updated in $tableName."
        ]);
    } else {
        echo json_encode([
            "status" => "error",
            "message" => "Failed to update item in $tableName." . $success
        ]);
    }
} catch (Exception $e) {
    // Output JSON-formatted error message
    echo json_encode([
        "status" => "error",
        "message" => $e->getMessage()
    ]);
}
