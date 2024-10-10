DROP DATABASE IF EXISTS bowling_tournament;

CREATE DATABASE IF NOT EXISTS bowling_tournament;
USE bowling_tournament;

CREATE TABLE IF NOT EXISTS teams (
    team_id INT AUTO_INCREMENT PRIMARY KEY,
    team_name VARCHAR(255) NOT NULL,
    total_score INT DEFAULT 0,
    rank INT DEFAULT NULL
);

CREATE TABLE IF NOT EXISTS players (
    player_id INT AUTO_INCREMENT PRIMARY KEY,
    team_id INT,
    player_name VARCHAR(255) NOT NULL,
    player_address VARCHAR(255),
    FOREIGN KEY (team_id) REFERENCES teams(team_id) ON DELETE CASCADE
);

CREATE TABLE IF NOT EXISTS games (
    game_id INT AUTO_INCREMENT PRIMARY KEY,
    team_id INT,
    opponent_team_id INT,
    round_type ENUM('qualification', 'seeded', 'random') NOT NULL,
    scorekeeper_id INT,
    status ENUM('scheduled', 'in_progress', 'complete') DEFAULT 'scheduled',
    FOREIGN KEY (team_id) REFERENCES teams(team_id) ON DELETE CASCADE,
    FOREIGN KEY (opponent_team_id) REFERENCES teams(team_id) ON DELETE SET NULL
);

CREATE TABLE IF NOT EXISTS scores (
    score_id INT AUTO_INCREMENT PRIMARY KEY,
    game_id INT,
    player_id INT,
    frame_number INT NOT NULL,
    ball1_score INT DEFAULT 0,
    ball2_score INT DEFAULT 0,
    bonus_ball_score INT DEFAULT 0,
    FOREIGN KEY (game_id) REFERENCES games(game_id) ON DELETE CASCADE,
    FOREIGN KEY (player_id) REFERENCES players(player_id) ON DELETE CASCADE
);

CREATE TABLE IF NOT EXISTS payouts (
    payout_id INT AUTO_INCREMENT PRIMARY KEY,
    team_id INT,
    round_number INT NOT NULL,
    amount DECIMAL(10, 2) NOT NULL,
    FOREIGN KEY (team_id) REFERENCES teams(team_id) ON DELETE CASCADE
);

CREATE TABLE IF NOT EXISTS rankings (
    ranking_id INT AUTO_INCREMENT PRIMARY KEY,
    team_id INT,
    round_number INT NOT NULL,
    rank INT NOT NULL,
    FOREIGN KEY (team_id) REFERENCES teams(team_id) ON DELETE CASCADE
);