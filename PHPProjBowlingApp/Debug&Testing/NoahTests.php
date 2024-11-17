<!DOCTYPE html>
<html>
<head>
    <title>Score a Game</title>
    <style>
        /* Your existing styles remain the same */
    </style>
    <script src="../FrontEnd/ModalTemplates/AddModalTemplates.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
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
            <option value="RAND2">Random 2</option>
            <option value="RAND3">Random 3</option>
            <option value="RAND4">Random 4</option>
            <option value="FINAL">Final</option>
        </select>
        <button onclick="fetchGames()">Get Games</button>
    </div>

    <div id="error" style="display:none" class="error"></div>
    <div id="tableContainer"></div>

    <script>
        function createTable(games) {
            if (!games || !games.length) {
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

        function showError(message) {
            const errorDiv = document.getElementById('error');
            errorDiv.textContent = message;
            errorDiv.style.display = 'block';
            setTimeout(() => errorDiv.style.display = 'none', 5000);
        }

        async function fetchGames() {
            let roundId = document.getElementById('roundSelect').value;
            let tableContainer = document.getElementById('tableContainer');

            try {
                let response = await fetch(`api/scorekeeper.php?roundId=${roundId}`);
                let result = await response.json();

                if (result.error) {
                    showError(result.error);
                    return;
                }

                tableContainer.innerHTML = createTable(result.data);
            } catch (e) {
                console.error('Fetch error:', e);
                showError('Failed to fetch games');
            }
        }

        async function scoreGame(gameId) {
            try {
                // Disable button while processing
                event.target.disabled = true;

                // Start the game
                let startResponse = await fetch(`api/scorekeeper.php?gameId=${gameId}&action=start`, {
                    method: 'PUT'
                });
                let startResult = await startResponse.json();

                if (startResult.error) {
                    showError(startResult.error);
                    event.target.disabled = false;
                    return;
                }

                // Insert modal HTML
                document.body.insertAdjacentHTML('beforeend', AddModalTemplates.bowlingGame());
                let modalElement = document.getElementById('createModal');
                let modal = new bootstrap.Modal(modalElement);

                // Handle modal submit
                modalElement.querySelector('form').onsubmit = async function(e) {
                    e.preventDefault();
                    
                    let balls = this.querySelector('[name="balls"]').value;
                    let score = this.querySelector('[name="score"]').value;

                    try {
                        let submitResponse = await fetch(`api/scorekeeper.php?gameId=${gameId}&action=submit`, {
                            method: 'PUT',
                            headers: {
                                'Content-Type': 'application/json'
                            },
                            body: JSON.stringify({ balls, score })
                        });

                        let submitResult = await submitResponse.json();

                        if (submitResult.error) {
                            showError(submitResult.error);
                        } else {
                            modal.hide();
                        }
                    } catch (e) {
                        showError('Failed to submit score');
                    }
                };

                // Handle modal close
                modalElement.addEventListener('hidden.bs.modal', function() {
                    modalElement.remove();
                    event.target.disabled = false;
                    fetchGames();
                });

                modal.show();
            } catch (e) {
                console.error('Error:', e);
                event.target.disabled = false;
                showError('Failed to start game');
            }
        }

        // Load games when page loads
        document.addEventListener('DOMContentLoaded', fetchGames);
    </script>
</body>
</html>