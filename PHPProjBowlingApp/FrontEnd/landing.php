<?php
session_start(); // Start the session to store the access level

// Check if form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['access_level'])) {
        $_SESSION['access_level'] = $_POST['access_level']; // Store access level in session
        header("Location: dashboard.php"); // Redirect to the main landing page
        exit();
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Select Access Level</title>
    <link
        href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css"
        rel="stylesheet" />
</head>

<body class="d-flex align-items-center justify-content-center vh-100">
    <div class="container text-center">
        <h1>Select Your Access Level</h1>

        <!-- The form sends a POST request to the same page when submitted -->
        <form method="POST">
            <!-- Button for Guest access level -->
            <button type="submit" name="access_level" value="guest" class="btn btn-outline-primary m-2">
                Guest
            </button>

            <!-- Button for Admin access level -->
            <button type="submit" name="access_level" value="admin" class="btn btn-outline-secondary m-2">
                Admin
            </button>

            <!-- Button for Scorekeeper access level -->
            <button type="submit" name="access_level" value="scorekeeper" class="btn btn-outline-success m-2">
                Scorekeeper
            </button>
        </form>
    </div>

</body>

<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.2/dist/js/bootstrap.bundle.min.js"></script>

</html>