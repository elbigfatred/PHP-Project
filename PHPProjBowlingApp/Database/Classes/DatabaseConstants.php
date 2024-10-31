<?php
class DatabaseConstants
{
    public static $MYSQL_CONNECTION_STRING = "mysql:host=localhost;dbname=bowling_tournament";
    public static $MYSQL_CONNECTION_NO_DB = "mysql:host=localhost";
    public static $MYSQL_USERNAME = "Bowling";
    public static $MYSQL_PASSWORD = "Bowling";
    public static $idColumns = [
        'team' => 'teamID',
        'player' => 'playerID',
        'province' => 'provinceID',
        'tournamentround' => 'roundID',
        'matchup' => 'matchID',
        'game' => 'gameID',
        'gamestatus' => 'gameStatusID',
        'payout' => 'payoutID'
    ];
}
