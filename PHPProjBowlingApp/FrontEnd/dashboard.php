<?php
session_start();

// Redirect back if no access level is set in the session
if (!isset($_SESSION['access_level'])) {
    header("Location: select_access.php");
    exit();
}

$access_level = $_SESSION['access_level'];
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet" />
    <style>
        /* Style for active nav item */
        .navbar-nav .nav-link.active {
            background-color: orangered;
            border-radius: 8px;
            color: #000;
            font-weight: bold;
            box-shadow: 0 4px 15px rgba(255, 140, 0, 0.5),
                inset 0 2px 8px rgba(255, 255, 255, 0.3);
            display: inline-block;
            /* ^ Limit background to text width, mainly for mobile */
        }

        /* Hover effect for inactive nav items */
        .navbar-nav .nav-link:not(.active):hover {
            font-weight: bold;
            transform: scale(1.05);
            transform-origin: left;
            /* ^ Grow to the right on hover, mainly for mobile */
            transition: transform 0.2s, font-weight 0.2s;
        }

        /* Adjust padding for collapsed navbar (accordion view) */
        @media (max-width: 991.98px) {
            .navbar-nav .nav-link {
                padding-left: 8px;
                padding-right: 8px;
            }
        }
    </style>
</head>

<body>

    <!-- Navigation bar for the dashboard -->
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <div class="container-fluid">
            <a class="navbar-brand" href="#">Bowling Tournament</a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav">

                    <!-- nav items based on access level -->
                    <?php if ($access_level == 'admin'): ?>
                        <li class="nav-item">
                            <a class="nav-link" href="#" onclick="showContent('admin-teams', this)">Teams</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#" onclick="showContent('admin-players', this)">Players</a>
                        </li>
                    <?php elseif ($access_level == 'scorekeeper'): ?>
                        <li class="nav-item">
                            <a class="nav-link" href="#" onclick="showContent('scorekeeper-scoring', this)">Scoring</a>
                        </li>
                    <?php elseif ($access_level == 'guest'): ?>
                        <li class="nav-item">
                            <a class="nav-link" href="#" onclick="showContent('guest-teams', this)">Teams</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#" onclick="showContent('guest-standings', this)">Standings</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#" onclick="showContent('guest-recap', this)">Recap</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#" onclick="showContent('guest-payout', this)">Payout</a>
                        </li>
                    <?php endif; ?>

                    <li class="nav-item ml-auto ">
                        <!-- ^ ml-auto means logout will be on the right -->
                        <a class="nav-link text-danger" href="logout.php">Logout</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <!-- Main content container where selected content is displayed -->
    <!-- These all exist, but are hidden by default -->
    <div class="container mt-5">
        <!-- Admin Content Sections -->
        <div id="admin-teams" class="content-section" style="display: none;">
            <h3>Teams - Admin</h3>
            <p>Awaiting content</p>
        </div>
        <div id="admin-players" class="content-section" style="display: none;">
            <h3>Players - Admin</h3>
            <p>Awaiting content</p>
        </div>

        <!-- Scorekeeper Content Section -->
        <div id="scorekeeper-scoring" class="content-section" style="display: none;">
            <h3>Scoring - Scorekeeper</h3>
            <p>Awaiting content</p>
        </div>

        <!-- Guest Content Sections -->
        <div id="guest-teams" class="content-section" style="display: none;">
            <h3>Teams - Guest</h3>
            <p>Awaiting content</p>
        </div>
        <div id="guest-standings" class="content-section" style="display: none;">
            <h3>Standings - Guest</h3>
            <p>Awaiting content</p>
        </div>
        <div id="guest-recap" class="content-section" style="display: none;">
            <h3>Recap - Guest</h3>
            <p>Awaiting content</p>
        </div>
        <div id="guest-payout" class="content-section" style="display: none;">
            <h3>Payout - Guest</h3>
            <p>Awaiting content</p>
        </div>
    </div>

</body>

<!-- Bootstrap stuff -->
<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.2/dist/js/bootstrap.bundle.min.js"></script>

<script>
    // Function to show the selected content section and highlight the active nav item
    function showContent(sectionId, element) {
        // Hide all content sections initially
        const contentSections = document.querySelectorAll('.content-section');
        contentSections.forEach(section => section.style.display = 'none');

        // Show the selected section by setting display to 'block'
        document.getElementById(sectionId).style.display = 'block';

        // Remove 'active' class from all nav links
        const navLinks = document.querySelectorAll('.navbar-nav .nav-link');
        navLinks.forEach(link => link.classList.remove('active'));

        // Add 'active' class to the clicked nav item
        element.classList.add('active');
    }

    // Automatically show the first content section based on access level when the page loads, this could be improved to just load the first item...
    window.onload = function() {
        <?php if ($access_level == 'admin'): ?>
            showContent('admin-teams', document.querySelector('#navbarNav .nav-link'));
        <?php elseif ($access_level == 'scorekeeper'): ?>
            showContent('scorekeeper-scoring', document.querySelector('#navbarNav .nav-link'));
        <?php elseif ($access_level == 'guest'): ?>
            showContent('guest-teams', document.querySelector('#navbarNav .nav-link'));
        <?php endif; ?>
    }
</script>

</html>