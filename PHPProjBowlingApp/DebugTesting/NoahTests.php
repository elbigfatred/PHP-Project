<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bowling Score Keeper</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.2/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-4">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2>Games List</h2>
            <select id="roundSelect" class="form-select" style="width: auto;">
                <option value="QUAL">Qualifying</option>
                <option value="SEED1">SEED1</option>
            </select>
        </div>
        
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>Game ID</th>
                    <th>Team Name</th>
                    <th>Game Number</th>
                    <th>Status</th>
                    <th>Score</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody id="gamesTableBody">
                <!-- Games will be populated here -->
            </tbody>
        </table>
    </div>

    <!-- Start Game Confirmation Modal -->
    <div class="modal fade" id="startGameModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Start Game</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <p>Are you sure you want to start scoring this game for <span id="teamNameSpan"></span>?</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="button" class="btn btn-primary" id="confirmStartGame">Start Game</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Scripts -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.2/js/bootstrap.bundle.min.js"></script>
    <script>
        // Configuration
        const API_BASE_URL = '../MiddleWare/ScoreKeeper.php';
        let startGameModal;
        let selectedGameData = null;

        // Fetch games for a specific round
async function fetchGames(roundId) {
    try {
        const response = await fetch(`${API_BASE_URL}?roundId=${roundId}`);
        if (!response.ok) {
            throw new Error(`HTTP error! status: ${response.status}`);
        }
        
        // Add this to debug the raw response
        const text = await response.text();
        try {
            const data = JSON.parse(text);
            if (data.error) {
                throw new Error(data.error);
            }
            return data.data;
        } catch (jsonError) {
            console.error('Raw PHP response:', text);
            throw new Error('Invalid JSON response from server');
        }
        
    } catch (error) {
        console.error('Error fetching games:', error);
        alert('Failed to load games. Please try again.');
        return [];
    }
}

        // Open start game modal
        function openStartGameModal(gameData) {
            selectedGameData = gameData;
            document.getElementById('teamNameSpan').textContent = gameData.teamName;
            startGameModal.show();
        }

       // Start a game
       async function startGame() {
    if (!selectedGameData) return;
    
    try {
        // Changed URL to use query parameters
        let response = await fetch(`${API_BASE_URL}?gameId=${selectedGameData.gameId}&action=start`, {
            method: 'PUT',
            headers: {
                'Content-Type': 'application/json'
            }
        });
        
        if (!response.ok) {
            throw new Error(`HTTP error! status: ${response.status}`);
        }
        
        let data = await response.json();
        
        if (data.error) {
            throw new Error(data.error);
        }
        
        startGameModal.hide();
        selectedGameData = null;
        loadGames();
        alert('Game started successfully!');
        
    } catch (error) {
        console.error('Error starting game:', error);
        alert('Failed to start game. Please try again.');
    }
}

        // Create a row for each game
        function createGameRow(game) {
            let row = document.createElement('tr');
            
            // Add status-based row coloring
            if (game.status === 'INPROGRESS') {
                row.classList.add('table-warning');
            } else if (game.status === 'COMPLETE') {
                row.classList.add('table-success');
            }
            
            row.innerHTML = `
                <td>${game.gameId}</td>
                <td>${game.teamName}</td>
                <td>${game.gameNumber}</td>
                <td>
                    <span class="badge ${getStatusBadgeClass(game.status)}">
                        ${game.status}
                    </span>
                </td>
                <td>${game.score || '-'}</td>
                <td>
                    ${getActionButton(game)}
                </td>
            `;
            
            return row;
        }

        // Get appropriate badge class for status
        function getStatusBadgeClass(status) {
            switch (status) {
                case 'AVAILABLE':
                    return 'bg-primary';
                case 'INPROGRESS':
                    return 'bg-warning';
                case 'COMPLETE':
                    return 'bg-success';
                default:
                    return 'bg-secondary';
            }
        }

        // Get appropriate action button/badge
        function getActionButton(game) {
            switch (game.status) {
                case 'AVAILABLE':
                    return `
                        <button 
                            class="btn btn-primary btn-sm"
                            onclick='openStartGameModal(${JSON.stringify(game).replace(/'/g, "&apos;")});'
                        >
                            Score Game
                        </button>`;
                case 'INPROGRESS':
                    return '<span class="badge bg-warning">In Progress</span>';
                case 'COMPLETE':
                    return '<span class="badge bg-success">Complete</span>';
                default:
                    return '';
            }
        }

        // Load and display games
        async function loadGames() {
            let tableBody = document.getElementById('gamesTableBody');
            let roundSelect = document.getElementById('roundSelect');
            tableBody.innerHTML = ''; // Clear existing rows
            
            let games = await fetchGames(roundSelect.value);
            
            if (games.length === 0) {
                let row = document.createElement('tr');
                row.innerHTML = `
                    <td colspan="6" class="text-center">
                        No games found for this round
                    </td>
                `;
                tableBody.appendChild(row);
                return;
            }
            
            games.forEach(game => {
                let row = createGameRow(game);
                tableBody.appendChild(row);
            });
        }

        // Set up event listeners
        document.addEventListener('DOMContentLoaded', () => {
            // Initialize Bootstrap modal
            startGameModal = new bootstrap.Modal(document.getElementById('startGameModal'));
            
            // Set up confirm button handler
            document.getElementById('confirmStartGame').addEventListener('click', startGame);
            
            // Set up round selection change handler
            document.getElementById('roundSelect').addEventListener('change', loadGames);
            
            // Initial load
            loadGames();
        });
    </script>
</body>
</html>