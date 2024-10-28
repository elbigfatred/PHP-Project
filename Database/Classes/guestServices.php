<?php

require_once 'Entities.php';
require_once 'PlayerDAO.php';
require_once 'TeamDAO.php';

class guestServices
{
    private $teamDAO;
    private $playerDAO;

    public function __construct($conn)
    {
        $this->teamDAO = new TeamDAO($conn);
        $this->playerDAO = new PlayerDAO($conn);
    }

    public function getAllTeams()
    {
        try {
            return $this->teamDAO->getAllTeams();
        } catch (Exception $ex) {
            return [];
        }
    }

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

}