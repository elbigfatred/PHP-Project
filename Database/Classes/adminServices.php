<?php

require_once 'Entities.php';
require_once 'PlayerDAO.php';
require_once 'TeamDAO.php';

class adminServices
{
    private $teamDAO;
    private $playerDAO;

    public function __construct($conn)
    {
        $this->teamDAO = new TeamDAO($conn);
        $this->playerDAO = new PlayerDAO($conn);
    }

    //Team functions
    public function getAllTeams()
    {
        try {
            return $this->teamDAO->getAllTeams();
        } catch (Exception $ex) {
            return [];
        }
    }

    public function getTeamByID($teamID)
    {
        try{
            return $this->teamDAO->getTeamByID($teamID);
        }catch(Exception $ex){
            return null;
        }
    }

    public function addTeam($team) 
    {
        try {
            // Check if the team exists by passing the team ID
            if($this->teamDAO->teamExists($team->getTeamID())) {
                throw new Exception("Team already exists.");
            }
            return $this->teamDAO->addTeam($team);
        } catch (Exception $ex) {
            return false;
        }
    }

    public function updateTeam($team)
    {
        try {
            if(!$this->teamDAO->teamExists($team->getTeamID())) {
                throw new Exception("Team does not exist.");
            }
            return $this->teamDAO->updateTeam($team);
        } catch (Exception $ex) {
            return false;
        }
    }

    public function deleteTeam($team)
    {
        $players = $this->playerDAO->getAllPLayersByTeamID($team->getTeamID());

        if(count($players) > 0) {
            throw new Exception("Cannot delete team with assigned players.");
        } else {
            
            return $this->teamDAO->deleteTeam($team);       
        }
    }

    //Player functions

    public function getAllPlayers($teamID)
    {
        if($this->teamDAO->teamExists($teamID)) {
            try {
                return $this->playerDAO->getAllPLayersByTeamID($teamID);
            } catch(Exception $ex) {
                return [];
            }
        } else {
            return [];
        }
        
    }

    public function getPlayerByID($playerID)
    {
        try {
            // Attempt to retrieve the player by playerID directly
            return $this->playerDAO->getPlayerByID($playerID);
        } catch (Exception $ex) {
            // In case of any exception, return null
            return null;
        }
    }

    public function addPlayer($player)
    {
        return $this->playerDAO->addPlayer($player);
    }

    public function updatePlayer($player)
    {
        // Proceed with update logic
        try {
            return $this->playerDAO->updatePlayer($player); 
        } catch (Exception $ex) {
            return false; 
        }
    }

    public function deletePlayer($player)
    {
        $playerID = $player->getPlayerID();
        if(!$this->playerDAO->playerExists($playerID)) {
            throw new Exception("Player does not exist in the system");
        }

        return $this->playerDAO->deletePlayer($player);
    }

}
