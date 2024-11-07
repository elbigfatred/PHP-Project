<?php
// UseCases/sck01.php

// Set JSON header
header('Content-Type: application/json');

require_once dirname(__DIR__, 1) . '/Database/Classes/ConnectionManager.php';
require_once dirname(__DIR__, 1) . '/Database/Classes/DAO.php';
require_once dirname(__DIR__, 1) . '/Database/Classes/DatabaseConstants.php';
require_once dirname(__DIR__, 1) . '/Database/Classes/scoreKeeperServices.php';

try {
    // Get roundId from query parameter
    $roundId = $_GET['roundId'] ?? 'QUAL';

    // Create service instances
    $cm = new ConnectionManager(
        DatabaseConstants::$MYSQL_CONNECTION_STRING, 
        DatabaseConstants::$MYSQL_USERNAME, 
        DatabaseConstants::$MYSQL_PASSWORD
    );
    
    $dao = new DAO($cm->getConnection());
    $scoreKeeper = new ScoreKeeperServices($dao);

    // Get games
    $games = $scoreKeeper->getGamesWithTeamInfo($roundId);

    // Return JSON response
    echo json_encode($games);

} catch (Exception $e) {
    http_response_code(500);
    echo json_encode([
        'error' => true,
        'message' => $e->getMessage()
    ]);
}