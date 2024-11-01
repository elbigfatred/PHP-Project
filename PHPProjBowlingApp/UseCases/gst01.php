<?php

require_once dirname(__DIR__, 1) . '/Database/Classes/ConnectionManager.php';
require_once dirname(__DIR__, 1) . '/Database/Classes/DAO.php';
require_once dirname(__DIR__, 1) . '/Database/Classes/DatabaseConstants.php';
// Create a new ConnectionManager instance using database credentials from DatabaseConstants
$cm = new ConnectionManager(DatabaseConstants::$MYSQL_CONNECTION_STRING, DatabaseConstants::$MYSQL_USERNAME, DatabaseConstants::$MYSQL_PASSWORD);

// Create a databaseAccessorObject to interact with the Database.
$dao = new DAO($cm->getConnection());
// use the dba to get all records in the team table.
$teams = $dao->getAllbyTableName("team");
// create an array to hold our output.
$out = [];
// loop through all teams
foreach ($teams as $team) {
    // chose fields to keep
    $t["teamName"] = $team->getTeamName();
    // use dba to get all records from the player table associated with the current team
    $players = $dao->getItemFromTableByID("player", "teamID", $team->getTeamID());
    // create a player list in our team object
    $t["players"] = [];
    // loop through all players
    foreach ($players as $player) {
        // chose fields to keep
        $p["playerName"] = $player->getFirstName() . " " . $player->getLastName();
        $p["homeTown"] = $player->getHometown();
        // add to our player list in our team object
        array_push($t["players"], $p);
    }
    // use dba to get all records from the matchup table associated with the current team
    $matchups = $dao->getItemFromTableByID("matchup", "teamID", $team->getTeamID());
    // create a matchup list in our team object
    $t["matchup"] = [];
    // loop through all matchups
    foreach ($matchups as $matchup) {
        // chose fields to keep
        $m["roundID"] = $matchup->getRoundID();
        $m["matchGroup"] = $matchup->getMatchGroup();
        $m["score"] = $matchup->getScore();
        $m["ranking"] = $matchup->getRanking();
        // add to our matchup list in our team object
        array_push($t["matchup"], $m);
    }
    array_push($out, $t);
}

$out = json_encode($out);
echo $out;
