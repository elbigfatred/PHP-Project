<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

require_once __DIR__ . '/../Database/Classes/ConnectionManager.php';
require_once __DIR__ . '/../Database/Classes/DatabaseConstants.php';

$stmt = null;
try {
    // Step 1: Establish a connection using ConnectionManager
    $cm = new ConnectionManager(
        DatabaseConstants::$MYSQL_CONNECTION_STRING,
        DatabaseConstants::$MYSQL_USERNAME,
        DatabaseConstants::$MYSQL_PASSWORD
    );

    $conn = $cm->getConnection();

    // Step 2: Execute the SQL script to rebuild the database
    $sql = file_get_contents(__DIR__ . '/../Database/scripts/rebuildTournamentDB.sql');
    $conn->exec($sql);

    // Step 3: Verify if key tables (like 'teams' and 'players') were created successfully
    $stmt = $conn->query("SHOW TABLES LIKE 'teams'");
    $teamTableExists = $stmt->rowCount() > 0;

    $stmt = $conn->query("SHOW TABLES LIKE 'players'");
    $playerTableExists = $stmt->rowCount() > 0;

    // Step 4: Check if both tables exist, meaning the rebuild was successful
    if ($teamTableExists && $playerTableExists) {
        // If successful, redirect to the index page with a success message
        header("Location: ../index.php?headermsg=Database rebuilt successfully");
        exit();
    } else {
        // If the tables weren't created, redirect with an error message via POST
        $errorMessage = "Failed to create key tables";
        //header("Location: ../errorPage.php", true, 307);  // Using 307 to allow POST
        echo "<form method='POST' action='../errorPage.php' id='errorForm'>
                <input type='hidden' name='err' value='$errorMessage'>
              </form>
              <script>document.getElementById('errorForm').submit();</script>";
        exit();
    }
} catch (PDOException $e) {
    // Redirect to an error page with the exception message via POST
    //$errorMessage = $e->getMessage();
    $errorMessage = "Fundamental error on rebuild.php";
    //header("Location: ../errorPage.php", true, 307);  // Using 307 to allow POST
    echo "<form method='POST' action='../errorPage.php' id='errorForm'>
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
