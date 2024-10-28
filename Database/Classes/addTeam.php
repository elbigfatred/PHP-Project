<?php
require_once 'ConnectionManager.php';
require_once 'adminServices.php';
require_once 'DatabaseConstants.php';



    $newTeam = new Team(2700, "Fighting Cool Guys");

    try {
        $cm = new ConnectionManager(DatabaseConstants::$MYSQL_CONNECTION_STRING, DatabaseConstants::$MYSQL_USERNAME, DatabaseConstants::$MYSQL_PASSWORD);
        $admin = new adminServices($cm->getConnection());

        //Error message for attempting to add a duplicate ID.
        if($admin->getTeamByID($newTeam->getTeamID())){
            echo "team with ID " . $newTeam->getTeamID() . " already exists.";
        } else{
            if($admin->addTeam($newTeam)) {
                echo "Team with ID " . $newTeam->getTeamID() . " added successfully.";
            } else {
                echo "Failed to add team with ID " . $newTeam->getTeamID() . ".";
            }
        }
        
    } catch (Exception $e) {
        echo "ERROR " . $e->getMessage();
    }
