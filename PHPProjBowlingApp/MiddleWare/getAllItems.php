<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

header('Content-Type: application/json');

//echo $_GET["table_name"];

require_once dirname(__DIR__, 1) . '/Database/Classes/ConnectionManager.php';
require_once dirname(__DIR__, 1) . '/Database/Classes/DAO.php';
require_once dirname(__DIR__, 1) . '/Database/Classes/DatabaseConstants.php';


try {
    // Create a new ConnectionManager instance using database credentials from DatabaseConstants
    $cm = new ConnectionManager(DatabaseConstants::$MYSQL_CONNECTION_STRING, DatabaseConstants::$MYSQL_USERNAME, DatabaseConstants::$MYSQL_PASSWORD);

    // Create a new watchAccessor instance for interacting with the watches table
    $dao = new DAO($cm->getConnection());

    // Check if model_number is passed as a URL parameter
    if (!isset($_GET["table_name"])) {
        throw new Exception('table_name is not present.'); // Throw an exception if model_number is not present
    }

    // Fetch the watch item by model number, passed via the URL query string (GET request)
    $tableName = $_GET["table_name"];
    $results = $dao->getAllbyTableName($tableName);

    // Convert the watchItem object into JSON format
    $results = json_encode($results);

    // Output the JSON-encoded watch data
    echo $results;
} catch (Exception $e) {
    // If an error occurs (e.g., model number not provided or database failure), output an error message
    echo "ERROR " . $e->getMessage();
}
