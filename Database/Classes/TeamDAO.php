<?php

require_once 'Entities.php';

class TeamDAO
{
    //SQL statements for single insert, update, delete and select.
    //Placeholders set for replacement in CRUD functions.
    //Also to retrieve all entries in the table.
    private $getTeamsAllStatementString = "select * from TEAM";
    private $getTeamByIDStatementString = "select * from TEAM where teamID = :id";
    private $deleteTeamStatementString = "delete from TEAM where teamID = :id";
    private $addTeamStatementString = "insert into TEAM (teamID, teamName) values
                                    (:id, :name)";
    private $updateTeamStatementString = "update TEAM
                                      set teamName = :name
                                      where teamID = :id";

    private $getTeamAllStatement = null;
    private $getTeamByIDStatement = null;
    private $deleteTeamStatement = null;
    private $addTeamStatement = null;
    private $updateTeamStatement = null;

    public function __construct($conn)
    {
        if (is_null($conn)) {
            throw new Exception("no connection");
        }

        $this->getTeamAllStatement = $conn->prepare($this->getTeamsAllStatementString);
        if (is_null($this->getTeamAllStatement)) {
            throw new Exception("bad statement: '" . $this->getTeamsAllStatementString . "'");
        }

        $this->getTeamByIDStatement = $conn->prepare($this->getTeamByIDStatementString);
        if (is_null($this->getTeamByIDStatement)) {
            throw new Exception("bad statement: '" . $this->getTeamByIDStatementString . "'");
        }

        $this->deleteTeamStatement = $conn->prepare($this->deleteTeamStatementString);
        if (is_null($this->deleteTeamStatement)) {
            throw new Exception("bad statement: '" . $this->deleteTeamStatementString . "'");
        }

        $this->addTeamStatement = $conn->prepare($this->addTeamStatementString);
        if (is_null($this->addTeamStatement)) {
            throw new Exception("bad statement: '" . $this->addTeamStatementString . "'");
        }

        $this->updateTeamStatement = $conn->prepare($this->updateTeamStatementString);
        if (is_null($this->updateTeamStatement)) {
            throw new Exception("bad statement: '" . $this->updateTeamStatementString . "'");
        }
    }

    public function getAllTeams()
    {
        $results = [];

        try {
            $this->getTeamAllStatement->execute();
            $dbresults = $this->getTeamAllStatement->fetchAll(PDO::FETCH_ASSOC);

            foreach ($dbresults as $r) {
                $teamID = $r['teamID'];
                $name = $r['teamName'];
                
                $obj = new team($teamID, $name);
                array_push($results, $obj);
            }
        } catch (Exception $e) {
            $results = [];
        } finally {
            if (!is_null($this->getTeamAllStatement)) {
                $this->getTeamAllStatement->closeCursor();
            }
        }

        return $results;
    }

    public function getTeamByID($teamID)
    {
        $result = null;

        try {
            $this->getTeamByIDStatement->bindParam(":id", $teamID);
            $this->getTeamByIDStatement->execute();
            $dbresults = $this->getTeamByIDStatement->fetch(PDO::FETCH_ASSOC);
            
            if ($dbresults) {
                $teamID = $dbresults['teamID'];
                $name = $dbresults['teamName'];
                
                $result = new team($teamID, $name);
            }
        } catch (Exception $e) {
            $result = null;
        } finally {
            if (!is_null($this->getTeamByIDStatement)) {
                $this->getTeamByIDStatement->closeCursor();
            }
        }

        return $result;
    }

    //Function to check if an item exists in the DB.
    public function teamExists($teamID)
    {
        try {
            $teamExists = $this->getTeamByID($teamID);
            return $teamExists !== null;
        } catch (Exception $e) {
            return false;
        }
    }

    public function deleteTeam($team)
    {
        $teamID = $team->getTeamID();  // Get the teamID first
        
        if (!$this->teamExists($teamID)) {  // Use the teamID here
            return false;
        }
    
        $success = false;
    
        try {
            $this->deleteTeamStatement->bindParam(":id", $teamID);
            $success = $this->deleteTeamStatement->execute();
            $success = $success && $this->deleteTeamStatement->rowCount() === 1;
        } catch (PDOException $e) {
            $success = false;
        } finally {
            if (!is_null($this->deleteTeamStatement)) {
                $this->deleteTeamStatement->closeCursor();
            }
        }
        return $success;
    }

    public function addTeam($team)
    {
        $success = false;
        //Get the field info from the object.
        $teamID = $team->getTeamID();
        $name = $team->getTeamName();
        

        //bind the params and attempt to make the insert.
        try {
            $this->addTeamStatement->bindParam(":id", $teamID);
            $this->addTeamStatement->bindParam(":name", $name);
            $success = $this->addTeamStatement->execute();
            $success = $success && $this->addTeamStatement->rowCount() === 1;
            //Catch any error
        } catch (PDOException $e) {
            $success = false;
            //Close the connection
        } finally {
            if (!is_null($this->addTeamStatement)) {
                $this->addTeamStatement->closeCursor();
            }
        }
        return $success;
    }

    public function updateTeam($team)
    {
        $teamID = $team->getTeamID();  // Get the teamID first
        
        if (!$this->teamExists($teamID)) {  // Use the teamID here
            return false;
        }
    
        $success = false;
        $name = $team->getTeamName();
    
        try {
            $this->updateTeamStatement->bindParam(":id", $teamID);
            $this->updateTeamStatement->bindParam(":name", $name);
            $success = $this->updateTeamStatement->execute();
            $success = $success && $this->updateTeamStatement->rowCount() === 1;
        } catch (PDOException $e) {
            $success = false;
        } finally {
            if (!is_null($this->updateTeamStatement)) {
                $this->updateTeamStatement->closeCursor();
            }
        }
        return $success;
    }
}