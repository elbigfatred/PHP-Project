<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Bowling Tournament Dashboard</title>
  <link
    href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css"
    rel="stylesheet" />
  <style>
    body {
      padding-top: 4rem;
    }

    .tab-content {
      padding: 20px;
      display: none;
    }

    .tab-content.active {
      display: block;
    }

    .nav-link.active {
      background-color: #ff6600;
      color: white;
    }
  </style>
</head>

<body>
  <!-- Navigation Bar -->
  <!-- button to go to testing page -->
  <a href="../Debug&Testing/Steve's Bowling Game Generator/BasicGameGenerator.html">Testing Page</a>
  <nav class="navbar navbar-expand-lg navbar-light bg-light fixed-top">
    <a class="navbar-brand" href="#">Tournament Dashboard</a>
    <button
      class="navbar-toggler"
      type="button"
      data-toggle="collapse"
      data-target="#navbarNav"
      aria-controls="navbarNav"
      aria-expanded="false"
      aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarNav">
      <ul class="navbar-nav">
        <li class="nav-item">
          <a class="nav-link active" href="#overview" data-section="overview">Overview</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="#teams" data-section="teams">Teams</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="#standings" data-section="standings">Standings</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="#bracket" data-section="bracket">Bracket</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="#admin" data-section="admin">Admin</a>
        </li>
      </ul>
    </div>
  </nav>

  <!-- Main Content Area (Tab Content) -->
  <div class="container">
    <div id="overview" class="tab-content active">
      <h2>Tournament Overview</h2>
      <p>
        Welcome to the Bowling Tournament. Here you can view teams, track
        standings, and score games.
      </p>
    </div>

    <div id="teams" class="tab-content">
      <h2>Teams</h2>
      <table class="table table-hover">
        <thead>
          <tr>
            <th>Team Name</th>
            <th>Total Score</th>
            <th>Rank</th>
            <th>View Details</th>
          </tr>
        </thead>
        <tbody>
          <tr>
            <td>Team Alpha</td>
            <td>2456</td>
            <td>1</td>
            <td>
              <button
                class="btn btn-sm btn-info"
                data-toggle="modal"
                data-target="#teamDetails">
                Details
              </button>
            </td>
          </tr>
        </tbody>
      </table>
    </div>

    <div id="standings" class="tab-content">
      <h2>Standings</h2>
      <table class="table table-striped">
        <thead>
          <tr>
            <th>Team</th>
            <th>Score</th>
            <th>Rank</th>
          </tr>
        </thead>
        <tbody>
          <!-- Dynamically load standings from backend; to be implemented -->
        </tbody>
      </table>
    </div>

    <div id="bracket" class="tab-content">
      <h2>Tournament Bracket</h2>
      <div id="tournamentTree"><!-- Placeholder for bracket; idk how this is going to work --></div>
    </div>

    <div id="admin" class="tab-content">
      <h2>Admin Panel</h2>
      <button
        class="btn btn-primary"
        data-toggle="modal"
        data-target="#resetModal">
        Reset Tournament
      </button>
      <p>
        Use the panel to manage teams and players before the tournament
        begins.
      </p>
    </div>
  </div>

  <!-- Team Details Modal -->
  <div
    class="modal fade"
    id="teamDetails"
    tabindex="-1"
    role="dialog"
    aria-labelledby="teamDetailsLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="teamDetailsLabel">Team Details</h5>
          <button
            type="button"
            class="close"
            data-dismiss="modal"
            aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <p>Player 1: John Doe</p>
          <p>Player 2: Jane Smith</p>
          <p>Player 3: Bob White</p>
          <p>Player 4: Sarah Jones</p>
        </div>
      </div>
    </div>
  </div>

  <!-- Tournament Reset Modal -->
  <div
    class="modal fade"
    id="resetModal"
    tabindex="-1"
    role="dialog"
    aria-labelledby="resetModalLabel"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="resetModalLabel">Reset Tournament</h5>
          <button
            type="button"
            class="close"
            data-dismiss="modal"
            aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          Are you sure you want to reset the tournament? This action cannot be
          undone.
        </div>
        <div class="modal-footer">
          <button
            type="button"
            class="btn btn-secondary"
            data-dismiss="modal">
            Cancel
          </button>
          <button
            type="button"
            class="btn btn-danger"
            onclick="resetTournament()">
            Reset
          </button>
        </div>
      </div>
    </div>
  </div>

  <!-- Include JS for Bootstrap and custom logic -->
  <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.2/dist/js/bootstrap.bundle.min.js"></script>
  <script>
    // Function to handle tab switching
    $(document).ready(function() {
      $("a.nav-link").click(function(e) {
        e.preventDefault();

        // Remove 'active' class from all nav links and hide all tab content
        $("a.nav-link").removeClass("active");
        $(".tab-content").removeClass("active");

        // Add 'active' class to the clicked nav link
        $(this).addClass("active");

        // Show the corresponding tab content based on the clicked link
        let section = $(this).attr("data-section");
        $("#" + section).addClass("active");
      });
    });

    function resetTournament() {
      // JavaScript logic for resetting tournament (via AJAX/PHP backend); to be implemented
      alert("Tournament reset!");
    }
  </script>
</body>

</html>