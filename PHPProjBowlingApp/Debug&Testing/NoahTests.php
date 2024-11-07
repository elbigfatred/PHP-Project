<!DOCTYPE html>
<html>

<head>
    <title>Score a Game</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
            padding: 20px;
        }

        .controls {
            margin-bottom: 20px;
        }

        select {
            padding: 5px;
            margin-right: 10px;
            font-size: 14px;
        }

        button {
            padding: 5px 15px;
            font-size: 14px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        th,
        td {
            padding: 12px;
            text-align: left;
            border: 1px solid #ddd;
        }

        th {
            background-color: #f4f4f4;
        }

        tr:nth-child(even) {
            background-color: #f9f9f9;
        }

        .status-badge {
            padding: 4px 8px;
            border-radius: 4px;
            font-size: 0.9em;
        }

        .status-COMPLETE {
            background-color: #4CAF50;
            color: white;
        }

        .status-INPROGRESS {
            background-color: #2196F3;
            color: white;
        }

        .status-AVAILABLE {
            background-color: #FFC107;
            color: black;
        }

        .status-UNASSIGNED {
            background-color: #9E9E9E;
            color: white;
        }

        .score-button {
            padding: 6px 12px;
            background-color: #4CAF50;
            color: white;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }

        .score-button:disabled {
            background-color: #cccccc;
            cursor: not-allowed;
        }

        .score-button:hover:not(:disabled) {
            background-color: #45a049;
        }

        .error {
            color: red;
            padding: 10px;
            margin: 10px 0;
            background-color: #fee;
            border-radius: 4px;
        }
    </style>
    <script src="../FrontEnd/ModalTemplates/AddModalTemplates.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</head>

<body>
    <h2>Score a Game</h2>

    <div class="controls">
        <select id="roundSelect">
            <option value="QUAL">Qualification</option>
            <option value="SEED1">Seed 1</option>
            <option value="SEED2">Seed 2</option>
            <option value="SEED3">Seed 3</option>
            <option value="SEED4">Seed 4</option>
            <option value="RAND1">Random 1</option>
            <option value="RAND1">Random 2</option>
            <option value="RAND3">Random 3</option>
            <option value="RAND4">Random 4</option>
            <option value="FINAL">Final</option>
        </select>
        <button onclick="fetchGames()">Get Games</button>
    </div>

    <div id="error" style="display:none" class="error"></div>
    <div id="tableContainer"></div>

    <script>
        //generate the table based on the games received from the system
        function createTable(games) {
            if (!games.length) {
                return '<p>No games found for this round.</p>';
            }

            let html = `
                <table>
                    <thead>
                        <tr>
                            <th>Game</th>
                            <th>Team</th>
                            <th>Status</th>
                            <th>Score</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
            `;

            games.forEach(game => {
                let isScoreable = game.status === 'AVAILABLE';
                html += `
                    <tr>
                        <td>Game ${game.gameId}</td>
                        <td>${game.teamName}</td>
                        <td><span class="status-badge status-${game.status}">${game.status}</span></td>
                        <td>${game.score || 0}</td>
                        <td>
                            <button 
                                onclick="scoreGame('${game.gameId}')"
                                class="score-button"
                                ${!isScoreable ? 'disabled' : ''}
                            >
                                Score Game
                            </button>
                        </td>
                    </tr>
                `;
            });

            html += '</tbody></table>';
            return html;
        }

        async function fetchGames() {
            let roundId = document.getElementById('roundSelect').value;
            let tableContainer = document.getElementById('tableContainer');

            try {
                let response = await fetch(`../UseCases/sck01.php?roundId=${roundId}`);
                let games = await response.json();

                tableContainer.innerHTML = createTable(games);
            } catch (e) {
                console.error('Fetch error:', e);
            }
        }

        async function scoreGame(gameId) {
            try {
                // Disable button while processing
                event.target.disabled = true;

                let response = await fetch('../UseCases/sck02.php', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json'
                    },
                    body: JSON.stringify({
                        gameId: gameId
                    })
                });

                let data = await response.json();
                //refresh the UI
                fetchGames(); 

                if (data.success) {
                    // Insert modal HTML using the correct case
                    document.body.insertAdjacentHTML('beforeend', AddModalTemplates.bowlingGame());

                    // Get the modal element
                    let modalElement = document.getElementById('createModal');

                    // Initialize the Bootstrap modal
                    let modal = new bootstrap.Modal(modalElement);

                    // Show the modal
                    modal.show();
                }
            } catch (e) {
                console.error('Error:', e);
            }
        }
        
        // Load games when page loads
        document.addEventListener('DOMContentLoaded', fetchGames);
    </script>
</body>

</html>