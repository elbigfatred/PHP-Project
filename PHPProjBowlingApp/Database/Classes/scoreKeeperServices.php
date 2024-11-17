<?php
 
 class ScoreKeeperServices {
    
    private $dao;

    //All game statuses
    const STATUS_UNASSIGNED = 'UNASSIGNED';
    const STATUS_AVAILABLE = 'AVAILABLE';
    const STATUS_INPROGRESS = 'INPROGRESS';
    const STATUS_COMPLETE = 'COMPLETE';
    

    public function __construct(DAO $dao) {
        $this->dao = $dao;
    }


    public function getGamesWithTeamInfo($roundId) {
        // Get all matchups for the round
        $matchups = $this->dao->getItemsFromTableByField('matchup', 'roundId', "'" . $roundId . "'");
        
        // Initialize results array
        $gamesWithTeamInfo = [];
        
        // Process each matchup
        foreach ($matchups as $matchup) {
            // Get the team information for this matchup
            $team = $this->dao->getItemById('team', $matchup->getTeamID());
            
            // Get all games for this matchup
            $games = $this->dao->getItemsFromTableByField('game', 'matchID', $matchup->getMatchID());
            
            // For each game in the matchup, create a comprehensive info object
            foreach ($games as $game) {
                $gameInfo = [
                    'gameId' => $game->getGameID(),
                    'matchId' => $game->getMatchID(),
                    'gameNumber' => $game->getGameNumber(),
                    'status' => $game->getGameStatusID(),
                    'score' => $game->getScore(),
                    'teamName' => $team->getTeamName()
                ];
                
                $gamesWithTeamInfo[] = $gameInfo;
            }
        }
        
        
        return $gamesWithTeamInfo;
    }

    //Not needed, made before getGamesWithTeamInfo
    public function getGamesByRound($roundId){
        $matchups = $this->dao->getItemsFromTableByField('matchup', 'roundId', "'" . $roundId . "'");

        $games = [];

        foreach ($matchups as $matchup) {
            $matchGames = $this->dao->getItemsFromTableByField('game', 'matchID', $matchup->getMatchID());
            $games = array_merge($games, $matchGames);
        }

        return $games;
    }

    //update the status to inprogress if game is available
    public function startGame($gameId) {
        $curGame = $this->dao->getItemById("game", $gameId);
        //Make sure current game is available
        if($curGame->getGameStatusID() === self::STATUS_AVAILABLE){
            $data = [
                'gameID' => $gameId,
                'gameStatusID' => self::STATUS_INPROGRESS
            ];
            return $this->dao->updateItem('game', $data);
        }

        return false;

    }

    //Might need this to flip game back to available if something goes wrong with modal
    public function returnGameToAvailable($gameId) {
        $curGame = $this->dao->getItemById("game", $gameId);
        if($curGame->getGameStatusID() === self::STATUS_INPROGRESS && $curGame->getScore() === null && $curGame->getBalls() === null){
            $data = [
                'gameID' => $gameId,
                'gameStatusID' => self::STATUS_AVAILABLE
            ];
            return $this->dao->updateItem('game', $data);
        }

        return false;
    }

    //submit required info to the system when scoring is finished
    public function submitGameResults($gameId, $balls, $score) {
       
        $curGame = $this->dao->getItemById("game", $gameId);
        //if no game found, or if the game isn't in progress return false
        if(!$curGame || $curGame->getGameStatusID() !== self::STATUS_INPROGRESS){
            return false;
        }

        //data to submit to the system
        $data = [
            'gameID' => $gameId,
            'balls' => $balls,
            'score' => $score,
            'gameStatusID' => self::STATUS_COMPLETE
        ];

        $success = $this->dao->updateItem('Game', $data);
    }
 }

 