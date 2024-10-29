<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

header('Content-Type: application/json');

require_once dirname(__DIR__, 1) . '/Database/Classes/ConnectionManager.php';
require_once dirname(__DIR__, 1) . '/Database/Classes/DAO.php';
require_once dirname(__DIR__, 1) . '/Database/Classes/DatabaseConstants.php';

try {
    // Initialize the ConnectionManager using database credentials from DatabaseConstants
    $cm = new ConnectionManager(DatabaseConstants::$MYSQL_CONNECTION_STRING, DatabaseConstants::$MYSQL_USERNAME, DatabaseConstants::$MYSQL_PASSWORD);

    // Initialize the DAO instance for database interaction
    $dao = new DAO($cm->getConnection());

    // Check if table_name and id are provided as URL parameters
    if (!isset($_GET["table_name"]) || !isset($_GET["id"])) {
        throw new Exception('Both table_name and id parameters are required.');
    }

    // Sanitize the table_name and id parameters
    $tableName = htmlspecialchars($_GET["table_name"]);
    $id = htmlspecialchars($_GET["id"]);

    // Retrieve the item from the specified table and ID
    $result = $dao->getItemById($tableName, $id);

    // Check if the result is null, indicating no item found
    if ($result === null) {
        echo json_encode([
            "status" => "error",
            "message" => "Item not found in table $tableName with ID $id."
        ]);
    } else {
        // Output the JSON-encoded item data
        echo json_encode($result);
    }
} catch (Exception $e) {
    // Output JSON-formatted error message
    echo json_encode([
        "status" => "error",
        "message" => $e->getMessage()
    ]);
}
