<?php
require_once 'ConnectionManager.php';
require_once 'adminServices.php';
require_once 'DatabaseConstants.php';

try {
    //Create a connection manager.
    $cm = new ConnectionManager(DatabaseConstants::$MYSQL_CONNECTION_STRING, DatabaseConstants::$MYSQL_USERNAME, DatabaseConstants::$MYSQL_PASSWORD);
    //Create an item accessor and initialize with a connection to the database.
    $teamAcc = new adminServices($cm->getConnection());
    //Call the method that executes a select all from the db
    $results = $teamAcc->getAllTeams(); 
    //encode the results as JSON
    $results = json_encode($results, JSON_NUMERIC_CHECK);
    //send the response to the page.
    echo $results;
} catch (Exception $e) {
    echo "ERROR " . $e->getMessage();
}