<?php

// Start the session
session_start();

// Check if 'access_level' exists, then unset it
if (isset($_SESSION['access_level'])) {
    unset($_SESSION['access_level']);
}

// redirect back to landing page
header("Location: landing.php");
exit();
