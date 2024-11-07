<?php

require_once dirname(__DIR__, 1) . '/Database/Classes/ConnectionManager.php';
require_once dirname(__DIR__, 1) . '/Database/Classes/DAO.php';
require_once dirname(__DIR__, 1) . '/Database/Classes/DatabaseConstants.php';
require_once dirname(__DIR__, 1) . '/Database/Classes/scoreKeeperServices.php';
// Create a new ConnectionManager instance using database credentials from DatabaseConstants
$cm = new ConnectionManager(DatabaseConstants::$MYSQL_CONNECTION_STRING, DatabaseConstants::$MYSQL_USERNAME, DatabaseConstants::$MYSQL_PASSWORD);
// Create a databaseAccessorObject to interact with the Database.
$dao = new DAO($cm->getConnection());
$scoreKeeper = new ScoreKeeperServices($dao);

try{
    $json = file_get_contents('php://input');
    $data = json_decode($json, true);
    $gameId = $data['gameId'];
    if(!$gameId){
        throw new Exception("Game ID is required");
    }
    // Create a new ConnectionManager instance using database credentials from DatabaseConstants
    $cm = new ConnectionManager(DatabaseConstants::$MYSQL_CONNECTION_STRING, DatabaseConstants::$MYSQL_USERNAME, DatabaseConstants::$MYSQL_PASSWORD);
    // Create a databaseAccessorObject to interact with the Database.
    $dao = new DAO($cm->getConnection());
    $scoreKeeper = new ScoreKeeperServices($dao);

    $result = $scoreKeeper->startGame($gameId);

    echo json_encode([
        'success' => $result,
        'gameId' => $gameId,
        'message' => $result ? 'Game started successfully' : 'Failed to start game'
    ]);

} catch(Exception $e){
    http_response_code(400);
    echo json_encode([
        'success' => false,
        'error' => true,
        'message' => $e->getMessage()

    ]);
}