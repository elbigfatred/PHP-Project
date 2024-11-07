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

$qualGames = $scoreKeeper->getGamesWithTeamInfo('QUAL');

echo json_encode($qualGames);