<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Interactive Bowling Scorer</title>
  <style>
    body {
      font-family: Arial, sans-serif;
      display: flex;
      align-items: center;
      flex-direction: column;
      margin-top: 20px;
    }

    #scoreboard {
      display: flex;
      justify-content: center;
      margin-bottom: 20px;
    }

    .frame {
      border: 1px solid #000;
      padding: 10px;
      width: 60px;
      text-align: center;
      margin-right: 5px;
    }

    .roll {
      display: block;
      font-size: 12px;
    }

    .score {
      font-size: 16px;
      font-weight: bold;
      margin-top: 5px;
    }

    #buttons {
      display: flex;
      flex-wrap: wrap;
      justify-content: center;
      gap: 5px;
      margin-bottom: 20px;
    }

    .score-btn {
      padding: 10px;
      font-size: 16px;
      width: 40px;
    }

    #total-score-display,
    #pure-rolls-display {
      margin-top: 10px;
      font-size: 18px;
    }

    #new-game {
      margin-top: 20px;
      padding: 10px 20px;
      font-size: 16px;
    }
  </style>
</head>

<body>
  <div id="scoreboard">
    <!-- Ten frames for the bowling scoreboard -->
    <div id="frames-table"></div>
  </div>

  <div id="buttons">
    <!-- Buttons for entering scores -->
    <button class="score-btn" value="0" onclick="sendScore(0)">0</button>
    <button class="score-btn" value="1" onclick="sendScore(1)">1</button>
    <button class="score-btn" value="2" onclick="sendScore(2)">2</button>
    <button class="score-btn" value="3" onclick="sendScore(3)">3</button>
    <button class="score-btn" value="4" onclick="sendScore(4)">4</button>
    <button class="score-btn" value="5" onclick="sendScore(5)">5</button>
    <button class="score-btn" value="6" onclick="sendScore(6)">6</button>
    <button class="score-btn" value="7" onclick="sendScore(7)">7</button>
    <button class="score-btn" value="8" onclick="sendScore(8)">8</button>
    <button class="score-btn" value="9" onclick="sendScore(9)">9</button>
    <button class="score-btn" value="/" onclick="sendScore('/')" disabled>/</button>
    <button class="score-btn" value="X" onclick="sendScore('X')">X</button>
  </div>

  <div id="sentScoreDisplay"></div>

  <div id="rolls-string-display"></div>
  <div id="frames-array-display"></div>
  <div id="scores-array-display"></div>
  <div id="current-Frame"></div>
  <div id="onFirstOfFrame"></div>
  <div id="bonusShotsDisplay"></div>

  <div id="total-score-display">
    Total Score: <span id="total-score">0</span>
  </div>

  <script>
    //initial variables
    let score = 0;
    let rollsString = '';
    let rollsArray = [
      [],
      [],
      [],
      [],
      [],
      [],
      [],
      [],
      [],
      [],
      []
    ];
    let scoresArray = [];
    //some controls
    let onFirstOfFrame = true;
    let selectededFrame = 0;
    let bonusRoundShots = 0;
    updateScoreboard();


    //functions
    function updateScoreboard() {
      let rollsStringDisplay = document.getElementById('rolls-string-display');
      let framesArrayDisplay = document.getElementById('frames-array-display');
      let scoresArrayDisplay = document.getElementById('scores-array-display');
      let totalScoreDisplay = document.getElementById('total-score');
      let currentFrameDisplay = document.getElementById('current-Frame');
      let onFirstOfFrameDisplay = document.getElementById('onFirstOfFrame');
      let bonusShotsDisplay = document.getElementById('bonusShotsDisplay');
      rollsStringDisplay.textContent = "Rolls String: " + rollsString;
      framesArrayDisplay.textContent = "Rolls Array: " + rollsArray.join(' || ');
      totalScoreDisplay.textContent = score;
      scoresArrayDisplay.textContent = "Scores Array: " + scoresArray;
      currentFrameDisplay.textContent = "Current Frame: " + (selectededFrame + 1);
      onFirstOfFrameDisplay.textContent = "onFirstRollofFrame?: " + onFirstOfFrame;
      bonusShotsDisplay.textContent = "Bonus Shots: " + bonusRoundShots;

      console.log(rollsArray);
    }

    function sendScore(value) {
      document.getElementById('sentScoreDisplay').textContent = "Sent Score:" + value;
      if (selectededFrame == 10 && bonusRoundShots > 0) {
        alert("You submitted a Bonus round shot!");
        rollsArray[selectededFrame].push(value);
        updateUIforFirstRoll();
        bonusRoundShots--;
      } else {
        if (value === "X") {
          onFirstOfFrame = true;
          rollsArray[selectededFrame].push(value);
          selectededFrame++;
          updateUIforFirstRoll();
          if (selectededFrame == 10) {
            bonusRoundShots = 2;
          }
        } else if (value === "/") {
          onFirstOfFrame = true;
          rollsArray[selectededFrame].push(value);
          selectededFrame++;
          updateUIforFirstRoll();
          if (selectededFrame == 10) {
            bonusRoundShots = 1;
          }
        } else {
          rollsArray[selectededFrame].push(value);
          if (!onFirstOfFrame) {
            selectededFrame++;
            updateUIforFirstRoll();
          } else {
            updateUIforSecondRoll(value);
          }
          onFirstOfFrame = !onFirstOfFrame;
        }
      }
      rollsString += value;
      updateScoreboard();
      if (selectededFrame == 10 && bonusRoundShots == 0) {
        KillAllUI();
      }
    }

    function updateUIforSecondRoll(value) {
      //get all buttons
      document.querySelectorAll('.score-btn').forEach(button => {
        //if buttons value plus value passed in is less than or equal to 10, disable it
        if (parseInt(button.value) + parseInt(value) >= 10) {
          button.disabled = true;
        }
      });

      // disable the strike button
      document.querySelector('.score-btn[value="X"]').disabled = true;
      // enable the spare button
      document.querySelector('.score-btn[value="/"]').disabled = false;
    }

    function updateUIforFirstRoll() {
      //get all buttons
      document.querySelectorAll('.score-btn').forEach(button => {
        //enable all buttons
        button.disabled = false;
      });
      //disable the spare button
      document.querySelector('.score-btn[value="/"]').disabled = true;
      //enable the strike button
      document.querySelector('.score-btn[value="X"]').disabled = false;

    }

    function KillAllUI() {
      //get all buttons
      document.querySelectorAll('.score-btn').forEach(button => {
        button.disabled = true; //
      });
    }


    updateScoreboard();
  </script>
</body>

</html>