<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

require_once __DIR__ . '/Database/Classes/ConnectionManager.php';
require_once __DIR__ . '/Database/Classes/DatabaseConstants.php';

// Modify the connection string to not include a specific database for the check
$noDBConnectionString = str_replace(';dbname=bowling_tournament', '', DatabaseConstants::$MYSQL_CONNECTION_STRING);

try {
    // Create a ConnectionManager instance without the dbname (just the host)
    $connectionManager = new ConnectionManager($noDBConnectionString, DatabaseConstants::$MYSQL_USERNAME, DatabaseConstants::$MYSQL_PASSWORD);
    $conn = $connectionManager->getConnection();

    // Check if the 'bowling_tournament' database exists
    $query = "SHOW DATABASES LIKE 'bowling_tournament'";
    $stmt = $conn->query($query);

    if ($stmt->rowCount() > 0) {
        // If the database exists, redirect to the main application page
        header('Location: ./FrontEnd/main.php');
        exit();
    } else {
        // If the database doesn't exist, redirect to errorPage.php with a message via POST
        $errorMessage = "Database does not exist";
        //header("Location: ./errorPage.php", true, 307);  // Using 307 to allow POST
        echo "<form method='POST' action='./errorPage.php' id='errorForm'>
                <input type='hidden' name='err' value='" . $errorMessage . "'>
              </form>
              <script>document.getElementById('errorForm').submit();</script>";
        exit();

        //We'll fix this to just try to rebuild the database if it doesn't exist!
    }
} catch (PDOException $e) {
    // If there's a database connection error, pass the exception via POST to the error page
    //$errorMessage = $e->getMessage();
    $errorMessage = "Fundamental error on index.php";
    //header("Location: ./errorPage.php", true, 307);  // Using 307 to allow POST
    echo "<form method='POST' action='./errorPage.php' id='errorForm'>
            <input type='hidden' name='err' value='" . $errorMessage . "'>
          </form>
          <script>document.getElementById('errorForm').submit();</script>";
    exit();
}

// basic page showing INDEX.php
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Index</title>
</head>

<body>
    <h1>Index</h1>
    <p>The index page should be used to redirect to the main application page.</p>
</body>

</html>