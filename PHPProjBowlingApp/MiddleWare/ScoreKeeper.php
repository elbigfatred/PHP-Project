<?php
require_once dirname(__DIR__, 1) . '/Database/Classes/ConnectionManager.php';
require_once dirname(__DIR__, 1) . '/Database/Classes/DAO.php';
require_once dirname(__DIR__, 1) . '/Database/Classes/DatabaseConstants.php';
require_once dirname(__DIR__, 1) . '/Database/Classes/scoreKeeperServices.php';

$method = $_SERVER['REQUEST_METHOD'];

// MAIN PROGRAM
try {
    $cm = new ConnectionManager(
        DatabaseConstants::$MYSQL_CONNECTION_STRING,
        DatabaseConstants::$MYSQL_USERNAME,
        DatabaseConstants::$MYSQL_PASSWORD
    );
    $dao = new DAO($cm->getConnection());
    $scoreKeeper = new ScoreKeeperServices($dao);

    if ($method === "GET") {
        doGet($scoreKeeper);
    } else if ($method === "PUT") {
        doPut($scoreKeeper);
    } else {
        sendResponse(405, null, "Method not allowed");
    }
} catch (Exception $e) {
    sendResponse(500, null, "Could not connect to database!");
} finally {
    if (!is_null($cm)) {
        $cm->closeConnection();
    }
}

// GET - Retrieve games
function doGet($scoreKeeper) {
    // Get games for a round
    if (isset($_GET['roundId'])) {
        try {
            $games = $scoreKeeper->getGamesWithTeamInfo($_GET['roundId']);
            sendResponse(200, $games, null);
        } catch (Exception $e) {
            sendResponse(500, null, "Could not retrieve games");
        }
    } else {
        sendResponse(400, null, "Round ID is required");
    }
}

// PUT - Update game status
function doPut($scoreKeeper) {
    if (!isset($_GET['gameId'])) {
        sendResponse(400, null, "Game ID is required");
        return;
    }

    $gameId = $_GET['gameId'];
    $action = $_GET['action'] ?? '';

    try {
        switch ($action) {
            case 'start':
                $result = $scoreKeeper->startGame($gameId);
                if ($result) {
                    sendResponse(200, true, null);
                } else {
                    sendResponse(400, null, "Failed to start game");
                }
                break;

            case 'submit':
                $input = file_get_contents("php://input");
                $data = json_decode($input, true);

                if (!$data || !isset($data['balls']) || !isset($data['score'])) {
                    sendResponse(400, null, "Balls and score are required");
                    return;
                }

                $result = $scoreKeeper->submitGameResults(
                    $gameId,
                    $data['balls'],
                    $data['score']
                );

                if ($result !== false) {
                    sendResponse(200, true, null);
                } else {
                    sendResponse(400, null, "Failed to submit game results");
                }
                break;

            case 'reset':
                $result = $scoreKeeper->returnGameToAvailable($gameId);
                if ($result) {
                    sendResponse(200, true, null);
                } else {
                    sendResponse(400, null, "Failed to reset game");
                }
                break;

            default:
                sendResponse(400, null, "Invalid action");
        }
    } catch (Exception $e) {
        sendResponse(500, null, "Server error occurred");
    }
}

function sendResponse($statusCode, $data, $error)
{
    header("Content-Type: application/json");
    http_response_code($statusCode);
    $resp = ['data' => $data, 'error' => $error];
    echo json_encode($resp, JSON_NUMERIC_CHECK);
}
