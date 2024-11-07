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

    public function getAllRounds() {
        return $this->dao->getAllbyTableName('TournamentRound');
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

    public function getGamesByRound($roundId){
        $matchups = $this->dao->getItemsFromTableByField('matchup', 'roundId', "'" . $roundId . "'");

        $games = [];

        foreach ($matchups as $matchup) {
            $matchGames = $this->dao->getItemsFromTableByField('game', 'matchID', $matchup->getMatchID());
            $games = array_merge($games, $matchGames);
        }

        return $games;
    }

    public function startGame($gameId) {
        $data = [
            'gameId' => $gameId,
            'gameStatusId' => self::STATUS_INPROGRESS
        ];
        return $this->dao->updateItem('Game', $data);
    }

    public function submitGameResults($gameId, $balls, $score) {
       
        $data = [
            'gameId' => $gameId,
            'balls' => $balls,
            'score' => $score,
            'gameStatusId' => self::STATUS_COMPLETE
        ];

        $success = $this->dao->updateItem('Game', $data);
    }
 }

 