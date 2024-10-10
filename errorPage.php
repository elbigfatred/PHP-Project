<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
// Check if the request method is POST and if the 'err' field is set
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['err'])) {
    // Safely retrieve the error message from the POST data
    $errorMessage = htmlspecialchars($_POST['err'], ENT_QUOTES);
} else {
    // Fallback message if no error was passed via POST
    $errorMessage = "An unknown error occurred.";
}
print_r($_POST);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Error Page</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f2f2f2;
            color: #333;
            padding: 20px;
        }

        .error-container {
            background-color: #fff;
            border: 1px solid #ddd;
            border-radius: 5px;
            padding: 20px;
            max-width: 600px;
            margin: 0 auto;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        }

        h1 {
            color: #e74c3c;
            font-size: 24px;
        }

        p {
            font-size: 18px;
        }

        a {
            display: inline-block;
            margin-top: 20px;
            padding: 10px 15px;
            background-color: #3498db;
            color: #fff;
            text-decoration: none;
            border-radius: 5px;
        }

        a:hover {
            background-color: #2980b9;
        }
    </style>
</head>

<body>

    <div class="error-container">
        <h1>An Error Occurred</h1>
        <p><?php echo $errorMessage; ?></p>
        <a href="./index.php">Go back to Home</a>
    </div>

</body>

</html>