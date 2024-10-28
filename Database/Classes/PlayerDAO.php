<?php

require_once 'Entities.php';

class PLayerDAO
{
    //SQL statements for single insert, update, delete and select.
    //Placeholders set for replacement in CRUD functions.
    //Also to retrieve all entries in the table.
    private $getAllPlayersByTeamIDStatementString = "select * from PLAYER where teamID = :teamID";
    private $getPlayerByIDStatementString = "select * from PLAYER where playerID = :playerID";
    private $deletePlayerStatementString = "delete from PLAYER where playerID = :playerID";
    private $addPlayerStatementString = "insert into PLAYER (playerID, teamID, firstName, lastName, hometown, provinceID) values
                                    (:playerID, :teamID, :firstName, :lastName, :hometown, :provinceID)";
    private $updatePlayerStatementString = "update PLAYER
                                      set teamID = :teamID, firstName = :firstName, lastName = :lastName, hometown = :hometown, provinceID = :provinceID
                                      where playerID = :playerID";
    private $getPlayersByTeamIDStatement = null;
    private $getPlayerByIDStatement = null;
    private $deletePlayerStatement = null;
    private $addPlayerStatement = null;
    private $updatePlayerStatement = null;
    
    public function __construct($conn)
    {
        if (is_null($conn)) {
            throw new Exception("no connection");
        }

        $this->getPlayersByTeamIDStatement = $conn->prepare($this->getAllPlayersByTeamIDStatementString);
        if (is_null($this->getPlayersByTeamIDStatement)) {
            throw new Exception("bad statement: '" . $this->getAllPlayersByTeamIDStatementString . "'");
        }

        $this->getPlayerByIDStatement = $conn->prepare($this->getPlayerByIDStatementString);
        if (is_null($this->getPlayerByIDStatement)) {
            throw new Exception("bad statement: '" . $this->getPlayerByIDStatementString . "'");
        }

        $this->deletePlayerStatement = $conn->prepare($this->deletePlayerStatementString);
        if (is_null($this->deletePlayerStatement)) {
            throw new Exception("bad statement: '" . $this->deletePlayerStatementString . "'");
        }

        $this->addPlayerStatement = $conn->prepare($this->addPlayerStatementString);
        if (is_null($this->addPlayerStatement)) {
            throw new Exception("bad statement: '" . $this->addPlayerStatementString . "'");
        }

        $this->updatePlayerStatement = $conn->prepare($this->updatePlayerStatementString);
        if (is_null($this->updatePlayerStatement)) {
            throw new Exception("bad statement: '" . $this->updatePlayerStatementString . "'");
        }
    }

    public function getAllPLayersByTeamID($teamID)
    {
        $results = [];

        try {
            $this->getPlayersByTeamIDStatement->bindParam(":teamID", $teamID);
            $this->getPlayersByTeamIDStatement->execute();
            $dbresults = $this->getPlayersByTeamIDStatement->fetchAll(PDO::FETCH_ASSOC);

            foreach ($dbresults as $r) {
                $playerID = $r["playerID"];
                $teamID = $r['teamID'];
                $firstName = $r['firstName'];
                $lastName = $r['lastName'];
                $homeTown = $r['hometown'];
                $provinceID = $r['provinceID'];
                
                $player = new player($playerID, $teamID, $firstName, $lastName, $homeTown, $provinceID);
                array_push($results, $player);
            }
        } catch (Exception $e) {
            $results = [];
        } finally {
            if (!is_null($this->getPlayersByTeamIDStatement)) {
                $this->getPlayersByTeamIDStatement->closeCursor();
            }
        }

        return $results;
    }

    public function getPlayerByID($playerID) // Expect a playerID, not a player object
    {
        $result = null;

        try {
            // Bind playerID correctly
            $this->getPlayerByIDStatement->bindParam(":playerID", $playerID);
            $this->getPlayerByIDStatement->execute();
            $dbresults = $this->getPlayerByIDStatement->fetch(PDO::FETCH_ASSOC);
            
            if ($dbresults) {
                $playerID = $dbresults["playerID"];
                $teamID = $dbresults['teamID'];
                $firstName = $dbresults['firstName'];
                $lastName = $dbresults['lastName'];
                $homeTown = $dbresults['hometown'];
                $provinceID = $dbresults['provinceID'];
                
                // Create a new player object based on the retrieved data
                $result = new player($playerID, $teamID, $firstName, $lastName, $homeTown, $provinceID);
            }
        } catch (Exception $e) {
            $result = null;
        } finally {
            if (!is_null($this->getPlayerByIDStatement)) {
                $this->getPlayerByIDStatement->closeCursor();
            }
        }

        return $result;
    }

public function playerExists($playerID)
{
    try {
        // Directly check by playerID
        $playerExists = $this->getPlayerByID($playerID);
        return $playerExists !== null;
    } catch (Exception $e) {
        return false;
    }
}

    public function deletePlayer($player)
    {
        if (!$this->playerExists($player->getPlayerID())) {
            return false;
        }

        $success = false;
        

        try {
            $playerID = $player->getPlayerID();
            $this->deletePlayerStatement->bindParam(":playerID", $playerID);
            $success = $this->deletePlayerStatement->execute();
            $success = $success && $this->deletePlayerStatement->rowCount() === 1;
        } catch (PDOException $e) {
            $success = false;
        } finally {
            if (!is_null($this->deletePlayerStatement)) {
                $this->deletePlayerStatement->closeCursor();
            }
        }
        return $success;
    }

    public function addPlayer($player)
    {
        $success = false;
        //Get the field info from the object.
        $playerID = $player->getPlayerID();
        $teamID = $player->getTeamID();
        $firstName = $player->getFirstName();
        $lastName = $player->getLastName();
        $homeTown = $player->getHomeTown();
        $provinceID = $player->getProvinceID();
        

        //bind the params and attempt to make the insert.
        try {
            $this->addPlayerStatement->bindParam(":playerID", $playerID);
            $this->addPlayerStatement->bindParam(":teamID", $teamID);
            $this->addPlayerStatement->bindParam(":firstName", $firstName);
            $this->addPlayerStatement->bindParam(":lastName", $lastName);
            $this->addPlayerStatement->bindParam(":hometown", $homeTown);
            $this->addPlayerStatement->bindParam(":provinceID", $provinceID);
            $success = $this->addPlayerStatement->execute();
            $success = $success && $this->addPlayerStatement->rowCount() === 1;
            //Catch any error
        } catch (PDOException $e) {
            $success = false;
            //Close the connection
        } finally {
            if (!is_null($this->addPlayerStatement)) {
                $this->addPlayerStatement->closeCursor();
            }
        }
        return $success;
    }

    public function updatePlayer($player)
    {   //Check if the item doesn't exist.
        if (!$this->playerExists($player->getPlayerID())) {
            return false;
        }

        $success = false;
        //Check if the item already exists in the db.
        $playerID = $player->getPlayerID();
        $teamID = $player->getTeamID();
        $firstName = $player->getFirstName();
        $lastName = $player->getLastName();
        $homeTown = $player->getHomeTown();
        $provinceID = $player->getProvinceID();
        //Bind the params and attempt the update.
        try {
            $this->updatePlayerStatement->bindParam(":playerID", $playerID);
            $this->updatePlayerStatement->bindParam(":teamID", $teamID);
            $this->updatePlayerStatement->bindParam(":firstName", $firstName);
            $this->updatePlayerStatement->bindParam(":lastName", $lastName);
            $this->updatePlayerStatement->bindParam(":hometown", $homeTown);
            $this->updatePlayerStatement->bindParam(":provinceID", $provinceID);
            $success = $this->updatePlayerStatement->execute();
            $success = $success && $this->updatePlayerStatement->rowCount() === 1;
            //Catch any exceptions
        } catch (PDOException $e) {
            $success = false;
            //Close to connection.
        } finally {
            if (!is_null($this->updatePlayerStatement)) {
                $this->updatePlayerStatement->closeCursor();
            }
        }
        return $success;
    }

}