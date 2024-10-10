const BowlingUtils = (function () {
  const SPARE_CHAR = "/";
  const STRIKE_CHAR = "X";
  const BALL_SEPARATOR_CHAR = " ";
  const BONUS_BALL_STRIKE_FREQUENCY = 0.5;

  /**
   * Generates ten frames of bowling scores.
   * If the inputs are invalid, returns all 0's.
   *
   * @param {number} strikes
   * @param {number} spares
   * @param {number} openFrames
   * @returns an array of size 10 where each element is a string containing
   * two ball scores separated by a space
   */

  const generateFrames = function (strikes, spares, openFrames) {
    if (
      strikes < 0 ||
      spares < 0 ||
      openFrames < 0 ||
      strikes + spares + openFrames !== 10
    ) {
      return [
        "0 0",
        "0 0",
        "0 0",
        "0 0",
        "0 0",
        "0 0",
        "0 0",
        "0 0",
        "0 0",
        "0 0",
      ];
    }
    let frames = [];
    let ball1, ball2, bonus;

    // generate the requested number of frames of each type
    for (let i = 0; i < strikes; i++) {
      frames.push(STRIKE_CHAR);
    }
    for (let i = 0; i < spares; i++) {
      ball1 = generateRandomBetween(0, 9);
      frames.push(ball1 + BALL_SEPARATOR_CHAR + SPARE_CHAR);
    }
    for (let i = 0; i < openFrames; i++) {
      ball1 = generateRandomBetween(0, 9);
      ball2 = generateRandomBetween(0, 9 - ball1);
      frames.push(ball1 + BALL_SEPARATOR_CHAR + ball2);
    }

    // shuffle the frames
    shuffle(frames);

    // generate one bonus ball if the tenth frame is a spare
    if (frames[9].indexOf(SPARE_CHAR) !== -1) {
      bonus = generateBonusBall(BONUS_BALL_STRIKE_FREQUENCY);
      frames.push(bonus);
    }

    // generate two bonus balls if the tenth frame is a strike
    if (frames[9] === STRIKE_CHAR) {
      ball1 = generateBonusBall(BONUS_BALL_STRIKE_FREQUENCY);
      if (ball1 === STRIKE_CHAR) {
        bonus =
          ball1 +
          BALL_SEPARATOR_CHAR +
          generateBonusBall(BONUS_BALL_STRIKE_FREQUENCY);
      } else {
        ball2 = generateRandomBetween(0, 10 - ball1); // might be a spare
        if (ball1 + ball2 === 10) {
          ball2 = SPARE_CHAR;
        }
        bonus = ball1 + BALL_SEPARATOR_CHAR + ball2;
      }
      frames.push(bonus);
    }

    return frames;
  };

  /**
   * Generates one bonus ball.
   *
   * @param {number} strikeFrequency a number between 0 and 1 indicating how often to generate a strike
   * @returns a single character: either a digit from 0-9 or an X indicating a strike
   */
  const generateBonusBall = function (strikeFrequency) {
    let res = "";
    if (Math.random() < strikeFrequency) {
      res = STRIKE_CHAR;
    } else {
      res = generateRandomBetween(0, 9);
    }
    return res;
  };

  /**
   * Generates a random integer in the specified range (inclusive).
   *
   * @param {number} min the minimum integer
   * @param {number} max the maximum integer
   * @returns an integer, N, such that min <= N <= max
   */
  const generateRandomBetween = function (min, max) {
    return min + Math.floor(Math.random() * (max - min + 1));
  };

  // The Fisher-Yates Shuffle
  const shuffle = function (frames) {
    for (let i = frames.length - 1; i > 0; i -= 1) {
      let j = Math.floor(Math.random() * (i + 1));
      let temp = frames[i];
      frames[i] = frames[j];
      frames[j] = temp;
    }
  };

  /**
   * Creates a string containing the ball scores from all ten frames.
   *
   * @param {array} frames an array of ten bowling frames
   * @returns a string that is the concatenation of the data in the array
   */
  const getBallsFromFrames = function (frames) {
    let res = frames[0];

    for (let i = 1; i < frames.length; i++) {
      res += BALL_SEPARATOR_CHAR + frames[i];
    }

    return res;
  };

  /**
   * Creates an HTML table displaying ten bowling frames.
   *
   * @param {array} frames an array of ten bowling frames
   * @returns a string representing a valid HTML <table> element
   */
  const formatFramesAsTable = function (frames) {
    let res = "<table>";
    res += "<tr>";
    for (i = 0; i < frames.length; i++) {
      if (i < 10) {
        res += "<th>" + (i + 1) + "</th>";
      } else {
        res += "<th>Bonus</th>";
      }
    }
    res += "</tr>";

    res += "<tr>";
    for (let i = 0; i < frames.length; i++) {
      res += "<td>" + frames[i] + "</td>";
    }
    res += "</tr>";

    res += "</table>";

    return res;
  };

  const formatScores = function (frames) {
    let res = "<table>";

    res += "<tr>";
    for (let i = 0; i < frames.length; i++) {
      res += "<td>" + frames[i] + "</td>";
    }
    res += "</tr>";

    res += "</table>";

    return res;
  };

  /**
   * Takes an array of ten bowling frames and returns an array of scores, one
   * for each frame. Frames are scored according to standard bowling rules.
   *
   * @param {array} frames an array of ten bowling frames, each string
   *   containing the result of a single frame, with a strike represented by
   *   "X", a spare represented by "S", and open frames represented by two
   *   numbers separated by a space.
   * @returns an array of ten scores, one for each frame
   */
  const getScoresFromFrames = function (frames) {
    console.log(frames);
    let res = [];

    // Handle frames 1-9
    for (let i = 0; i < 9; i++) {
      let frame = frames[i];

      // Check for an open frame (no strike or spare)
      if (
        frame.indexOf(SPARE_CHAR) === -1 &&
        frame.indexOf(STRIKE_CHAR) === -1
      ) {
        let splitFrame = frame.split(BALL_SEPARATOR_CHAR);
        res.push(+splitFrame[0] + +splitFrame[1]);
      }

      // Handle spare
      if (frame.indexOf(SPARE_CHAR) !== -1) {
        let nextFrame = frames[i + 1] || ""; // Prevent out-of-bounds
        let firstValue = nextFrame[0]; // Get the first character of the next frame
        res.push(10 + (firstValue === STRIKE_CHAR ? 10 : +firstValue));
      }

      // Handle strike
      if (frame.indexOf(STRIKE_CHAR) !== -1) {
        let accumulator = 10; // Strike counts as 10
        let nextFrame = frames[i + 1] || ""; // Prevent out-of-bounds access
        let nextNextFrame = frames[i + 2] || ""; // Handle the next-next frame

        // Check if the next frame is a strike
        if (nextFrame.indexOf(STRIKE_CHAR) !== -1) {
          accumulator += 10;
          // If next-next frame is a strike, add 10 again, otherwise add first ball from it
          accumulator +=
            nextNextFrame.indexOf(STRIKE_CHAR) !== -1
              ? 10
              : +nextNextFrame.split(BALL_SEPARATOR_CHAR)[0] || 0;
        } else {
          // Otherwise, add both balls from the next frame
          let splitFrame = nextFrame.split(BALL_SEPARATOR_CHAR);
          accumulator += +splitFrame[0];
          accumulator +=
            splitFrame[1] === SPARE_CHAR ? 10 - +splitFrame[0] : +splitFrame[1];
        }

        res.push(accumulator);
      }
    }

    // Handle the 10th frame (frame 9 in zero-indexed array)
    let finalFrame = frames[9];

    if (finalFrame.indexOf(STRIKE_CHAR) !== -1) {
      // If the 10th frame is a strike, we need two bonus balls
      let splitFrame = frames[10].split(BALL_SEPARATOR_CHAR);
      let firstBonus = splitFrame[0] || "0";
      //split frame 10 to get the second bonus ball
      let secondBonus = splitFrame[1] || "0";

      let accumulator = 10;

      // Add the first bonus ball (strike or regular value)
      if (firstBonus === STRIKE_CHAR || firstBonus === SPARE_CHAR) {
        accumulator += 10;
      } else {
        accumulator += +firstBonus;
      }

      // Add the second bonus ball (strike or regular value)
      if (secondBonus === STRIKE_CHAR || secondBonus === SPARE_CHAR) {
        accumulator += 10;
      } else {
        accumulator += +secondBonus;
      }

      res.push(accumulator);
    } else if (finalFrame.indexOf(SPARE_CHAR) !== -1) {
      // If the 10th frame is a spare, grab only the first bonus ball
      let bonusBall = frames[10] ? frames[10] : "0"; // The next ball after the spare
      console.log(bonusBall);
      res.push(10 + (bonusBall === STRIKE_CHAR ? 10 : +bonusBall));
    } else {
      // Normal scoring for the 10th frame
      let splitFrame = finalFrame.split(BALL_SEPARATOR_CHAR);
      res.push(+splitFrame[0] + +splitFrame[1]);
    }

    return res;
  };

  /**
   * Generates a random combination of strikes, spares, and open frames.
   *
   * Returns an object with the following properties:
   * - strikes: the number of strikes
   * - spares: the number of spares
   * - openFrames: the number of open frames
   */
  const generateRandomFrameCombination = function () {
    const totalFrames = 10;
    let strikes, spares, openFrames;

    // Helper function to generate a random integer between min and max (inclusive)
    function getRandomInt(min, max) {
      return Math.floor(Math.random() * (max - min + 1)) + min;
    }

    // Ensure the total number of frames adds up to 10
    strikes = getRandomInt(0, totalFrames); // Random number of strikes
    let remainingFrames = totalFrames - strikes;

    spares = getRandomInt(0, remainingFrames); // Random number of spares
    openFrames = remainingFrames - spares; // The rest will be open frames

    return {
      strikes: strikes,
      spares: spares,
      openFrames: openFrames,
    };
  };

  return {
    generateFrames: generateFrames,
    getBallsFromFrames: getBallsFromFrames,
    formatFramesAsTable: formatFramesAsTable,
    getScoresFromFrames: getScoresFromFrames,
    formatScores: formatScores,
    generateRandomFrameCombination: generateRandomFrameCombination,
  };
})();
