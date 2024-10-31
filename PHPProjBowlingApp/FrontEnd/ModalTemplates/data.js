const bowlingData = {
    teams: [],
    players: [],
    matchups: [],
    games: []
};

async function fetchTable(tableName) {
    try {
        const response = await fetch(`/api?table_name=${tableName}`);
        
        if (!response.ok) {
            throw new Error(`HTTP error! status: ${response.status}`);
        }
        
        const data = await response.text();
        
        if (data.startsWith('ERROR')) {
            throw new Error(data);
        }
        
        return JSON.parse(data);
    } catch (error) {
        console.error(`Error fetching ${tableName}:`, error);
        throw error;
    }
}

async function loadAllData() {
    try {
        // Fetch all tables in parallel
        const [teams, players, matchups, games] = await Promise.all([
            fetchTable('team'),
            fetchTable('player'),
            fetchTable('matchup'),
            fetchTable('game')
        ]);

        // Store in our data object
        bowlingData.teams = teams;
        bowlingData.players = players;
        bowlingData.matchups = matchups;
        bowlingData.games = games;

        console.log('All data loaded:', bowlingData);
        return bowlingData;
    } catch (error) {
        console.error('Error loading data:', error);
        throw error;
    }
}