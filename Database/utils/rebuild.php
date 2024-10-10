<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Corrected path: go up one directory level to access the "Classes" folder
require_once __DIR__ . '/../Classes/ConnectionManager.php';
require_once __DIR__ . '/../Classes/DatabaseConstants.php';

// Path to the SQL script to rebuild the database
$sql = file_get_contents(__DIR__ . '/../scripts/rebuildTournamentDB.sql');
$file_path = '/Applications/XAMPP/xamppfiles/htdocs/tspencer/PHP-Project/Database/scripts/rebuildTournamentDB.sql';

echo __DIR__ . '/../scripts/rebuildTournamentDB.sql';
$stmt = null;
try {
    // Step 1: Establish a connection using ConnectionManager
    $cm = new ConnectionManager(
        DatabaseConstants::$MYSQL_CONNECTION_NO_DB,
        DatabaseConstants::$MYSQL_USERNAME,
        DatabaseConstants::$MYSQL_PASSWORD
    );

    $conn = $cm->getConnection();

    // Step 2: Execute the SQL script to rebuild the database
    //$sql = file_get_contents(__DIR__ . '/../Database/scripts/rebuildTournamentDB.sql');
    $conn->exec($sql);

    // Step 3: Verify if key tables (like 'teams' and 'players') were created successfully
    $stmt = $conn->query("SHOW TABLES LIKE 'teams'");
    $teamTableExists = $stmt->rowCount() > 0;

    $stmt = $conn->query("SHOW TABLES LIKE 'players'");
    $playerTableExists = $stmt->rowCount() > 0;

    // Step 4: Check if both tables exist, meaning the rebuild was successful
    if ($teamTableExists && $playerTableExists) {
        // If successful, redirect to the index page with a success message
        header("Location: ../../FrontEnd/main.php");
        exit();
    } else {
        // If the tables weren't created, redirect with an error message via POST
        $errorMessage = "Failed to create key tables";
        //header("Location: ../errorPage.php", true, 307);  // Using 307 to allow POST
        echo "<form method='POST' action='../../errorPage.php' id='errorForm'>
                <input type='hidden' name='err' value='$errorMessage'>
              </form>
              <script>document.getElementById('errorForm').submit();</script>";
        exit();
    }
} catch (PDOException $e) {
    // Redirect to an error page with the exception message via POST
    $errorMessage = $e->getMessage();
    //$errorMessage = "Fundamental error on rebuild.php";
    //header("Location: ../errorPage.php", true, 307);  // Using 307 to allow POST
    echo "<form method='POST' action='../../errorPage.php' id='errorForm'>
            <input type='hidden' name='err' value='$errorMessage'>
          </form>
          <script>document.getElementById('errorForm').submit();</script>";
    exit();
} finally {
    if (!is_null($stmt)) {
        $stmt->closeCursor();
    }
    $cm->closeConnection();
}
