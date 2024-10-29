<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

header('Content-Type: application/json');

require_once dirname(__DIR__, 1) . '/Database/Classes/ConnectionManager.php';
require_once dirname(__DIR__, 1) . '/Database/Classes/DAO.php';
require_once dirname(__DIR__, 1) . '/Database/Classes/DatabaseConstants.php';

try {
    // Initialize ConnectionManager and DAO
    $cm = new ConnectionManager(DatabaseConstants::$MYSQL_CONNECTION_STRING, DatabaseConstants::$MYSQL_USERNAME, DatabaseConstants::$MYSQL_PASSWORD);
    $dao = new DAO($cm->getConnection());

    // Validate URL parameters
    if (!isset($_GET["table_name"]) || !isset($_GET["id"])) {
        throw new Exception('Both table_name and id parameters are required.');
    }

    // Sanitize parameters
    $tableName = htmlspecialchars($_GET["table_name"]);
    $id = htmlspecialchars($_GET["id"]);

    // Call the deleteItemById function
    $success = $dao->deleteItemById($tableName, $id);

    // Output the JSON response based on success or failure
    if ($success) {
        echo json_encode([
            "status" => "success",
            "message" => "Item successfully deleted from $tableName with ID $id."
        ]);
    } else {
        echo json_encode([
            "status" => "error",
            "message" => "Failed to delete item from $tableName with ID $id."
        ]);
    }
} catch (Exception $e) {
    // Output JSON-formatted error message
    echo json_encode([
        "status" => "error",
        "message" => $e->getMessage()
    ]);
}
