<?php
require_once 'ConnectionManager.php';
require_once 'adminServices.php';
require_once 'DatabaseConstants.php';
require_once 'Entities.php';  

// Database connection
try {
    $cm = new ConnectionManager(DatabaseConstants::$MYSQL_CONNECTION_STRING, DatabaseConstants::$MYSQL_USERNAME, DatabaseConstants::$MYSQL_PASSWORD);
    $admin = new adminServices($cm->getConnection());

    // Testing the Team functionality
    echo "Testing Team Functions:\n";

    // Create a new team
    $newTeam = new Team(3000, "Fighting Cool Guys");
    
    // Add the new team
    if ($admin->addTeam($newTeam)) {
        echo "Team added successfully.\n";
    } else {
        echo "Failed to add team.\n";
    }

    // Retrieve the team by ID
    $retrievedTeam = $admin->getTeamByID(3000);
    if ($retrievedTeam) {
        echo "Retrieved team: " . $retrievedTeam->getTeamName() . "\n";
    } else {
        echo "Failed to retrieve team.\n";
    }

    // Update the team
    $newTeam->setTeamName("Fighting Champs");
    if ($admin->updateTeam($newTeam)) {
        echo "Team updated successfully.\n";
    } else {
        echo "Failed to update team.\n";
    }

    // Retrieve the team by ID
    $retrievedTeam = $admin->getTeamByID(3000);
    if ($retrievedTeam) {
        echo "Retrieved team: " . $retrievedTeam->getTeamName() . "\n";
    } else {
        echo "Failed to retrieve team.\n";
    }

    // Delete the team
   

    // Testing Player functionality
    echo "\nTesting Player Functions:\n";

    // Create a new player
    $newPlayer = new Player(1002, 3000, "Noah", "Ritcey", "Saint John", "NB"); 
    if ($admin->addPlayer($newPlayer)) {
        echo "Player added successfully.\n";
    } else {
        echo "Failed to add player.\n";
    }

    // Retrieve the player by ID
    $retrievedPlayer = $admin->getPlayerByID(1002);
    if ($retrievedPlayer) {
        echo "Retrieved player: " . $retrievedPlayer->getFirstName() . "\n";
    } else {
        echo "Failed to retrieve player.\n";
    }

    try {
        $updatePlayer = new Player(1002, 3000, "BOOOoah", "Ritcey", "Saint John", "NB");
        if ($admin->updatePlayer($updatePlayer)) {
            echo "Player updated successfully.\n";
        } else {
            echo "Failed to update player.\n";
        }
    } catch (Exception $e) {
        echo "Error: " . $e->getMessage() . "\n";
    }

     // Retrieve the player by ID
     $retrievedPlayer = $admin->getPlayerByID(1002);
     if ($retrievedPlayer) {
         echo "Retrieved player: " . $retrievedPlayer->getFirstName() . "\n";
     } else {
         echo "Failed to retrieve player.\n";
     }

    // Delete the player
    $deletePlayer = new Player(1002, 3000, "Joah", "Ritcey", "Saint John", "NB");
    if ($admin->deletePlayer($updatePlayer)) {
        echo "Player deleted successfully.\n";
    } else {
        echo "Failed to delete player.\n";
    }

       // Delete the team
    if ($admin->deleteTeam($newTeam)) {
        echo "Team deleted successfully.\n";
    } else {
        echo "Failed to delete team.\n";
    }

} catch (Exception $e) {
    echo "ERROR: " . $e->getMessage();
}