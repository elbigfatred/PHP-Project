<?php

class team implements JsonSerializable
{
    private $teamID;
    private $teamName;

    public function __construct($teamID, $teamName)
    {
        $this->teamID = $teamID;
        $this->teamName = $teamName;
    }

    public function getTeamID()
    {
        return $this->teamID;
    }

    public function setTeamID($teamID)
    {
        $this->teamID = $teamID;
    }

    public function getTeamName()
    {
        return $this->teamName;
    }

    public function setTeamName($teamName)
    {
        $this->teamName = $teamName;
    }

    public function jsonSerialize(): mixed
    {
        return get_object_vars($this);
    }
}

class player implements JsonSerializable
{
    private $playerID;
    private $teamID;
    private $firstName;
    private $lastName;
    private $hometown;
    private $provinceID;

    public function __construct($playerID, $teamID, $firstName, $lastName, $hometown, $provinceID)
    {
        $this->playerID = $playerID;
        $this->teamID = $teamID;
        $this->firstName = $firstName;
        $this->lastName = $lastName;
        $this->hometown = $hometown;
        $this->provinceID = $provinceID;
    }

    public function getPlayerID()
    {
        return $this->playerID;
    }

    public function setPlayerID($playerID)
    {
        $this->playerID = $playerID;
    }

    public function getTeamID()
    {
        return $this->teamID;
    }

    public function setTeamID($teamID)
    {
        $this->teamID = $teamID;
    }

    public function getFirstName()
    {
        return $this->firstName;
    }

    public function setFirstName($firstName)
    {
        $this->firstName = $firstName;
    }

    public function getLastName()
    {
        return $this->lastName;
    }

    public function setLastName($lastName)
    {
        $this->lastName = $lastName;
    }

    public function getHometown()
    {
        return $this->hometown;
    }

    public function setHometown($hometown)
    {
        $this->hometown = $hometown;
    }

    public function getProvinceID()
    {
        return $this->provinceID;
    }

    public function setProvinceID($provinceID)
    {
        $this->provinceID = $provinceID;
    }

    public function jsonSerialize(): mixed
    {
        return get_object_vars($this);
    }
}

class province implements JsonSerializable
{
    private $provinceID;
    private $provinceName;

    public function __construct($provinceID, $provinceName)
    {
        $this->provinceID = $provinceID;
        $this->provinceName = $provinceName;
    }

    public function getProvinceID()
    {
        return $this->provinceID;
    }

    public function setProvinceID($provinceID)
    {
        $this->provinceID = $provinceID;
    }

    public function getProvinceName()
    {
        return $this->provinceName;
    }

    public function setProvinceName($provinceName)
    {
        $this->provinceName = $provinceName;
    }

    public function jsonSerialize(): mixed
    {
        return get_object_vars($this);
    }
}

class tournamentround implements JsonSerializable
{
    private $roundID;

    public function __construct($roundID)
    {
        $this->roundID = $roundID;
    }

    public function getRoundID()
    {
        return $this->roundID;
    }

    public function setRoundID($roundID)
    {
        $this->roundID = $roundID;
    }

    public function jsonSerialize(): mixed
    {
        return get_object_vars($this);
    }
}

class matchup implements JsonSerializable
{
    private $matchID;
    private $roundID;
    private $matchGroup;
    private $teamID;
    private $score;
    private $ranking;

    public function __construct($matchID, $roundID, $matchGroup, $teamID, $score, $ranking)
    {
        $this->matchID = $matchID;
        $this->roundID = $roundID;
        $this->matchGroup = $matchGroup;
        $this->teamID = $teamID;
        $this->score = $score;
        $this->ranking = $ranking;
    }

    public function getMatchID()
    {
        return $this->matchID;
    }

    public function setMatchID($matchID)
    {
        $this->matchID = $matchID;
    }

    public function getRoundID()
    {
        return $this->roundID;
    }

    public function setRoundID($roundID)
    {
        $this->roundID = $roundID;
    }

    public function getMatchGroup()
    {
        return $this->matchGroup;
    }

    public function setMatchGroup($matchGroup)
    {
        $this->matchGroup = $matchGroup;
    }

    public function getTeamID()
    {
        return $this->teamID;
    }

    public function setTeamID($teamID)
    {
        $this->teamID = $teamID;
    }

    public function getScore()
    {
        return $this->score;
    }

    public function setScore($score)
    {
        $this->score = $score;
    }

    public function getRanking()
    {
        return $this->ranking;
    }

    public function setRanking($ranking)
    {
        $this->ranking = $ranking;
    }

    public function jsonSerialize(): mixed
    {
        return get_object_vars($this);
    }
}

class game implements JsonSerializable
{
    private $gameID;
    private $matchID;
    private $gameNumber;
    private $gameStatusID;
    private $balls;
    private $score;

    public function __construct($gameID, $matchID, $gameNumber, $gameStatusID, $balls, $score)
    {
        $this->gameID = $gameID;
        $this->matchID = $matchID;
        $this->gameNumber = $gameNumber;
        $this->gameStatusID = $gameStatusID;
        $this->balls = $balls;
        $this->score = $score;
    }

    public function getGameID()
    {
        return $this->gameID;
    }

    public function setGameID($gameID)
    {
        $this->gameID = $gameID;
    }

    public function getMatchID()
    {
        return $this->matchID;
    }

    public function setMatchID($matchID)
    {
        $this->matchID = $matchID;
    }

    public function getGameNumber()
    {
        return $this->gameNumber;
    }

    public function setGameNumber($gameNumber)
    {
        $this->gameNumber = $gameNumber;
    }

    public function getGameStatusID()
    {
        return $this->gameStatusID;
    }

    public function setGameStatusID($gameStatusID)
    {
        $this->gameStatusID = $gameStatusID;
    }

    public function getBalls()
    {
        return $this->balls;
    }

    public function setBalls($balls)
    {
        $this->balls = $balls;
    }

    public function getScore()
    {
        return $this->score;
    }

    public function setScore($score)
    {
        $this->score = $score;
    }

    public function jsonSerialize(): mixed
    {
        return get_object_vars($this);
    }
}

class gamestatus implements JsonSerializable
{
    private $gameStatusID;

    public function __construct($gameStatusID)
    {
        $this->gameStatusID = $gameStatusID;
    }

    public function getGameStatusID()
    {
        return $this->gameStatusID;
    }

    public function setgameStatusID($gameStatusID)
    {
        $this->gameStatusID = $gameStatusID;
    }

    public function jsonSerialize(): mixed
    {
        return get_object_vars($this);
    }
}

class payout implements JsonSerializable
{
    private $payoutID;
    private $roundID;
    private $teamID;
    private $amount;

    public function __construct($payoutID, $roundID, $teamID, $amount)
    {
        $this->payoutID = $payoutID;
        $this->roundID = $roundID;
        $this->teamID = $teamID;
        $this->amount = $amount;
    }

    public function getPayoutID()
    {
        return $this->payoutID;
    }

    public function setPayoutID($payoutID)
    {
        $this->payoutID = $payoutID;
    }

    public function getRoundID()
    {
        return $this->roundID;
    }

    public function setRoundID($roundID)
    {
        $this->roundID = $roundID;
    }

    public function getTeamID()
    {
        return $this->teamID;
    }

    public function setTeamID($teamID)
    {
        $this->teamID = $teamID;
    }

    public function getAmount()
    {
        return $this->amount;
    }

    public function setAmount($amount)
    {
        $this->amount = $amount;
    }

    public function jsonSerialize(): mixed
    {
        return get_object_vars($this);
    }
}
