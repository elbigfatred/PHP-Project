/**
 * AddModalTemplates Class
 *
 * A utility class for generating modals that allow users to create new items for various entities
 * (such as players, teams, and games) in the application. Each static method returns
 * a Bootstrap modal template for the specified entity. The class also includes a method, submitCreateForm,
 * to handle the form submission by gathering form data and sending it to the server.
 */
class AddModalTemplates {
  // Add to the AddModalTemplates class

  static bowlingGame() {
    return `
      <div class="modal fade" id="createModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="createModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title" id="createModalLabel">Score Game</h5>
            </div>
            <div class="modal-body">
              <div class="container py-4">
                <div class="row g-1 mb-4 border border-2 border-dark">
                  <!-- Frames 1-10 -->
                  <div class="col">
                    <div class="position-relative text-center py-2 border">
                      <small class="position-absolute top-0 start-0 ms-1 text-muted">Frame 1</small>
                      <div class="d-flex justify-content-end gap-1 mt-4 px-1">
                        <div class="border d-flex align-items-center justify-content-center" style="width:20px; height:20px;"></div>
                        <div class="border d-flex align-items-center justify-content-center" style="width:20px; height:20px;"></div>
                      </div>
                      <div class="position-absolute bottom-0 start-50 translate-middle-x fw-bold"></div>
                    </div>
                  </div>
                  <div class="col">
                    <div class="position-relative text-center py-2 border">
                      <small class="position-absolute top-0 start-0 ms-1 text-muted">Frame 2</small>
                      <div class="d-flex justify-content-end gap-1 mt-4 px-1">
                        <div class="border d-flex align-items-center justify-content-center" style="width:20px; height:20px;"></div>
                        <div class="border d-flex align-items-center justify-content-center" style="width:20px; height:20px;"></div>
                      </div>
                      <div class="position-absolute bottom-0 start-50 translate-middle-x fw-bold"></div>
                    </div>
                  </div>
                  <div class="col">
                    <div class="position-relative text-center py-2 border">
                      <small class="position-absolute top-0 start-0 ms-1 text-muted">Frame 3</small>
                      <div class="d-flex justify-content-end gap-1 mt-4 px-1">
                        <div class="border d-flex align-items-center justify-content-center" style="width:20px; height:20px;"></div>
                        <div class="border d-flex align-items-center justify-content-center" style="width:20px; height:20px;"></div>
                      </div>
                      <div class="position-absolute bottom-0 start-50 translate-middle-x fw-bold"></div>
                    </div>
                  </div>
                  <div class="col">
                    <div class="position-relative text-center py-2 border">
                      <small class="position-absolute top-0 start-0 ms-1 text-muted">Frame 4</small>
                      <div class="d-flex justify-content-end gap-1 mt-4 px-1">
                        <div class="border d-flex align-items-center justify-content-center" style="width:20px; height:20px;"></div>
                        <div class="border d-flex align-items-center justify-content-center" style="width:20px; height:20px;"></div>
                      </div>
                      <div class="position-absolute bottom-0 start-50 translate-middle-x fw-bold"></div>
                    </div>
                  </div>
                  <div class="col">
                    <div class="position-relative text-center py-2 border">
                      <small class="position-absolute top-0 start-0 ms-1 text-muted">Frame 5</small>
                      <div class="d-flex justify-content-end gap-1 mt-4 px-1">
                        <div class="border d-flex align-items-center justify-content-center" style="width:20px; height:20px;"></div>
                        <div class="border d-flex align-items-center justify-content-center" style="width:20px; height:20px;"></div>
                      </div>
                      <div class="position-absolute bottom-0 start-50 translate-middle-x fw-bold"></div>
                    </div>
                  </div>
                  <div class="col">
                    <div class="position-relative text-center py-2 border">
                      <small class="position-absolute top-0 start-0 ms-1 text-muted">Frame 6</small>
                      <div class="d-flex justify-content-end gap-1 mt-4 px-1">
                        <div class="border d-flex align-items-center justify-content-center" style="width:20px; height:20px;"></div>
                        <div class="border d-flex align-items-center justify-content-center" style="width:20px; height:20px;"></div>
                      </div>
                      <div class="position-absolute bottom-0 start-50 translate-middle-x fw-bold"></div>
                    </div>
                  </div>
                  <div class="col">
                    <div class="position-relative text-center py-2 border">
                      <small class="position-absolute top-0 start-0 ms-1 text-muted">Frame 7</small>
                      <div class="d-flex justify-content-end gap-1 mt-4 px-1">
                        <div class="border d-flex align-items-center justify-content-center" style="width:20px; height:20px;"></div>
                        <div class="border d-flex align-items-center justify-content-center" style="width:20px; height:20px;"></div>
                      </div>
                      <div class="position-absolute bottom-0 start-50 translate-middle-x fw-bold"></div>
                    </div>
                  </div>
                  <div class="col">
                    <div class="position-relative text-center py-2 border">
                      <small class="position-absolute top-0 start-0 ms-1 text-muted">Frame 8</small>
                      <div class="d-flex justify-content-end gap-1 mt-4 px-1">
                        <div class="border d-flex align-items-center justify-content-center" style="width:20px; height:20px;"></div>
                        <div class="border d-flex align-items-center justify-content-center" style="width:20px; height:20px;"></div>
                      </div>
                      <div class="position-absolute bottom-0 start-50 translate-middle-x fw-bold"></div>
                    </div>
                  </div>
                  <div class="col">
                    <div class="position-relative text-center py-2 border">
                      <small class="position-absolute top-0 start-0 ms-1 text-muted">Frame 9</small>
                      <div class="d-flex justify-content-end gap-1 mt-4 px-1">
                        <div class="border d-flex align-items-center justify-content-center" style="width:20px; height:20px;"></div>
                        <div class="border d-flex align-items-center justify-content-center" style="width:20px; height:20px;"></div>
                      </div>
                      <div class="position-absolute bottom-0 start-50 translate-middle-x fw-bold"></div>
                    </div>
                  </div>
                  <div class="col">
                    <div class="position-relative text-center py-2 border">
                      <small class="position-absolute top-0 start-0 ms-1 text-muted">Frame 10</small>
                      <div class="d-flex justify-content-end gap-1 mt-4 px-1">
                        <div class="border d-flex align-items-center justify-content-center" style="width:20px; height:20px;"></div>
                        <div class="border d-flex align-items-center justify-content-center" style="width:20px; height:20px;"></div>
                      </div>
                      <div class="position-absolute bottom-0 start-50 translate-middle-x fw-bold"></div>
                    </div>
                  </div>
                  <!-- Bonus Frame -->
                  <div class="col">
                    <div class="position-relative text-center py-2 border">
                      <small class="position-absolute top-0 start-0 ms-1 text-muted">Bonus</small>
                      <div class="d-flex justify-content-end gap-1 mt-4 px-1">
                        <div class="border d-flex align-items-center justify-content-center" style="width:20px; height:20px;"></div>
                      </div>
                      <div class="position-absolute bottom-0 start-50 translate-middle-x fw-bold"></div>
                    </div>
                  </div>
                </div>
                <div class="text-center fs-4 fw-bold mb-4">TeamName</div>
                <div class="text-center fs-4 fw-bold mb-4">Total Score: <span id="totalScore">0</span></div>
                
                <div class="row justify-content-center">
                  <div class="col-md-6">
                    <div class="row g-2">
                      <!-- Number buttons -->
                      <div class="col-3"><button class="btn btn-light w-100" onclick="handleThrow(0)">0</button></div>
                      <div class="col-3"><button class="btn btn-light w-100" onclick="handleThrow(1)">1</button></div>
                      <div class="col-3"><button class="btn btn-light w-100" onclick="handleThrow(2)">2</button></div>
                      <div class="col-3"><button class="btn btn-light w-100" onclick="handleThrow(3)">3</button></div>
                      <div class="col-3"><button class="btn btn-light w-100" onclick="handleThrow(4)">4</button></div>
                      <div class="col-3"><button class="btn btn-light w-100" onclick="handleThrow(5)">5</button></div>
                      <div class="col-3"><button class="btn btn-light w-100" onclick="handleThrow(6)">6</button></div>
                      <div class="col-3"><button class="btn btn-light w-100" onclick="handleThrow(7)">7</button></div>
                      <div class="col-3"><button class="btn btn-light w-100" onclick="handleThrow(8)">8</button></div>
                      <div class="col-3"><button class="btn btn-light w-100" onclick="handleThrow(9)">9</button></div>
                      <!-- Special buttons -->
                      <div class="col-3"><button class="btn btn-light w-100" onclick="handleStrike()">X</button></div>
                      <div class="col-3"><button class="btn btn-light w-100" onclick="handleSpare()">/</button></div>
                    </div>
                  </div>
                </div>

  
              </div>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-success">Submit Game</button>
            </div>
          </div>
        </div>
      </div>`;
}
  // Player modal
  static player() {
    return `
      <div class="modal fade" id="createModal" tabindex="-1" aria-labelledby="createModalLabel" aria-hidden="true">
        <div class="modal-dialog">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title" id="createModalLabel">Create Player</h5>
              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
              <form id="createForm">
                <div class="mb-3"><label for="playerID" class="form-label">Player ID:</label><input type="text" class="form-control" id="playerID" name="playerID" required></div>
                <div class="mb-3"><label for="teamID" class="form-label">Team ID:</label><input type="text" class="form-control" id="teamID" name="teamID" required></div>
                <div class="mb-3"><label for="firstName" class="form-label">First Name:</label><input type="text" class="form-control" id="firstName" name="firstName" required></div>
                <div class="mb-3"><label for="lastName" class="form-label">Last Name:</label><input type="text" class="form-control" id="lastName" name="lastName" required></div>
                <div class="mb-3"><label for="hometown" class="form-label">Hometown:</label><input type="text" class="form-control" id="hometown" name="hometown" required></div>
                <div class="mb-3"><label for="provinceID" class="form-label">Province ID:</label><input type="text" class="form-control" id="provinceID" name="provinceID" required></div>
              </form>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
              <button type="button" class="btn btn-primary" onclick="AddModalTemplates.submitCreateForm('player')">Submit</button>
            </div>
          </div>
        </div>
      </div>`;
  }

  // Team modal
  static team() {
    return `
      <div class="modal fade" id="createModal" tabindex="-1" aria-labelledby="createModalLabel" aria-hidden="true">
        <div class="modal-dialog">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title" id="createModalLabel">Create Team</h5>
              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
              <form id="createForm">
                <div class="mb-3"><label for="teamID" class="form-label">Team ID:</label><input type="text" class="form-control" id="teamID" name="teamID" required></div>
                <div class="mb-3"><label for="teamName" class="form-label">Team Name:</label><input type="text" class="form-control" id="teamName" name="teamName" required></div>
              </form>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
              <button type="button" class="btn btn-primary" onclick="AddModalTemplates.submitCreateForm('team')">Submit</button>
            </div>
          </div>
        </div>
      </div>`;
  }

  // Province modal
  static province() {
    return `
      <div class="modal fade" id="createModal" tabindex="-1" aria-labelledby="createModalLabel" aria-hidden="true">
        <div class="modal-dialog">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title" id="createModalLabel">Create Province</h5>
              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
              <form id="createForm">
                <div class="mb-3"><label for="provinceID" class="form-label">Province ID:</label><input type="text" class="form-control" id="provinceID" name="provinceID" required></div>
                <div class="mb-3"><label for="provinceName" class="form-label">Province Name:</label><input type="text" class="form-control" id="provinceName" name="provinceName" required></div>
              </form>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
              <button type="button" class="btn btn-primary" onclick="AddModalTemplates.submitCreateForm('province')">Submit</button>
            </div>
          </div>
        </div>
      </div>`;
  }

  // Tournament Round modal
  static tournamentround() {
    return `
      <div class="modal fade" id="createModal" tabindex="-1" aria-labelledby="createModalLabel" aria-hidden="true">
        <div class="modal-dialog">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title" id="createModalLabel">Create Tournament Round</h5>
              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
              <form id="createForm">
                <div class="mb-3"><label for="roundID" class="form-label">Round ID:</label><input type="text" class="form-control" id="roundID" name="roundID" required></div>
              </form>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
              <button type="button" class="btn btn-primary" onclick="AddModalTemplates.submitCreateForm('tournamentround')">Submit</button>
            </div>
          </div>
        </div>
      </div>`;
  }

  // Matchup modal
  static matchup() {
    return `
      <div class="modal fade" id="createModal" tabindex="-1" aria-labelledby="createModalLabel" aria-hidden="true">
        <div class="modal-dialog">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title" id="createModalLabel">Create Matchup</h5>
              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
              <form id="createForm">
                <div class="mb-3"><label for="matchID" class="form-label">Match ID:</label><input type="text" class="form-control" id="matchID" name="matchID" required></div>
                <div class="mb-3"><label for="roundID" class="form-label">Round ID:</label><input type="text" class="form-control" id="roundID" name="roundID" required></div>
                <div class="mb-3"><label for="matchGroup" class="form-label">Match Group:</label><input type="text" class="form-control" id="matchGroup" name="matchGroup" required></div>
                <div class="mb-3"><label for="teamID" class="form-label">Team ID:</label><input type="text" class="form-control" id="teamID" name="teamID" required></div>
                <div class="mb-3"><label for="score" class="form-label">Score:</label><input type="number" class="form-control" id="score" name="score" required></div>
                <div class="mb-3"><label for="ranking" class="form-label">Ranking:</label><input type="number" class="form-control" id="ranking" name="ranking" required></div>
              </form>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
              <button type="button" class="btn btn-primary" onclick="AddModalTemplates.submitCreateForm('matchup')">Submit</button>
            </div>
          </div>
        </div>
      </div>`;
  }

  // Game modal
  static game() {
    return `
      <div class="modal fade" id="createModal" tabindex="-1" aria-labelledby="createModalLabel" aria-hidden="true">
        <div class="modal-dialog">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title" id="createModalLabel">Create Game</h5>
              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
              <form id="createForm">
                <div class="mb-3"><label for="gameID" class="form-label">Game ID:</label><input type="text" class="form-control" id="gameID" name="gameID" required></div>
                <div class="mb-3"><label for="matchID" class="form-label">Match ID:</label><input type="text" class="form-control" id="matchID" name="matchID" required></div>
                <div class="mb-3"><label for="gameNumber" class="form-label">Game Number:</label><input type="number" class="form-control" id="gameNumber" name="gameNumber" required></div>
                <div class="mb-3"><label for="gameStatusID" class="form-label">Game Status ID:</label><input type="text" class="form-control" id="gameStatusID" name="gameStatusID" required></div>
                <div class="mb-3"><label for="balls" class="form-label">Balls:</label><input type="number" class="form-control" id="balls" name="balls" required></div>
                <div class="mb-3"><label for="score" class="form-label">Score:</label><input type="number" class="form-control" id="score" name="score" required></div>
              </form>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
              <button type="button" class="btn btn-primary" onclick="AddModalTemplates.submitCreateForm('game')">Submit</button>
            </div>
          </div>
        </div>
      </div>`;
  }

  // Game Status modal
  static gamestatus() {
    return `
      <div class="modal fade" id="createModal" tabindex="-1" aria-labelledby="createModalLabel" aria-hidden="true">
        <div class="modal-dialog">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title" id="createModalLabel">Create Game Status</h5>
              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
              <form id="createForm">
                <div class="mb-3"><label for="gameStatusID" class="form-label">Game Status ID:</label><input type="text" class="form-control" id="gameStatusID" name="gameStatusID" required></div>
              </form>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
              <button type="button" class="btn btn-primary" onclick="AddModalTemplates.submitCreateForm('gamestatus')">Submit</button>
            </div>
          </div>
        </div>
      </div>`;
  }

  // Payout modal
  static payout() {
    return `
      <div class="modal fade" id="createModal" tabindex="-1" aria-labelledby="createModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title" id="createModalLabel">Score Game</h5>
              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
              <div class="container">
                <div class="scorecard" id="scorecard">
                  <!-- Frames 1-10 -->
                  <div class="frame">
                    <div class="frame-number">Frame 1</div>
                    <div class="throws">
                      <div class="throw-box"></div>
                      <div class="throw-box"></div>
                    </div>
                    <div class="frame-score"></div>
                  </div>
                  <div class="frame">
                    <div class="frame-number">Frame 2</div>
                    <div class="throws">
                      <div class="throw-box"></div>
                      <div class="throw-box"></div>
                    </div>
                    <div class="frame-score"></div>
                  </div>
                  <div class="frame">
                    <div class="frame-number">Frame 3</div>
                    <div class="throws">
                      <div class="throw-box"></div>
                      <div class="throw-box"></div>
                    </div>
                    <div class="frame-score"></div>
                  </div>
                  <div class="frame">
                    <div class="frame-number">Frame 4</div>
                    <div class="throws">
                      <div class="throw-box"></div>
                      <div class="throw-box"></div>
                    </div>
                    <div class="frame-score"></div>
                  </div>
                  <div class="frame">
                    <div class="frame-number">Frame 5</div>
                    <div class="throws">
                      <div class="throw-box"></div>
                      <div class="throw-box"></div>
                    </div>
                    <div class="frame-score"></div>
                  </div>
                  <div class="frame">
                    <div class="frame-number">Frame 6</div>
                    <div class="throws">
                      <div class="throw-box"></div>
                      <div class="throw-box"></div>
                    </div>
                    <div class="frame-score"></div>
                  </div>
                  <div class="frame">
                    <div class="frame-number">Frame 7</div>
                    <div class="throws">
                      <div class="throw-box"></div>
                      <div class="throw-box"></div>
                    </div>
                    <div class="frame-score"></div>
                  </div>
                  <div class="frame">
                    <div class="frame-number">Frame 8</div>
                    <div class="throws">
                      <div class="throw-box"></div>
                      <div class="throw-box"></div>
                    </div>
                    <div class="frame-score"></div>
                  </div>
                  <div class="frame">
                    <div class="frame-number">Frame 9</div>
                    <div class="throws">
                      <div class="throw-box"></div>
                      <div class="throw-box"></div>
                    </div>
                    <div class="frame-score"></div>
                  </div>
                  <div class="frame">
                    <div class="frame-number">Frame 10</div>
                    <div class="throws">
                      <div class="throw-box"></div>
                      <div class="throw-box"></div>
                    </div>
                    <div class="frame-score"></div>
                  </div>
                  <!-- Bonus Frame -->
                  <div class="frame">
                    <div class="frame-number">Bonus</div>
                    <div class="throws">
                      <div class="throw-box"></div>
                    </div>
                    <div class="frame-score"></div>
                  </div>
                </div>

                <div class="total-score">Total Score: <span id="totalScore">0</span></div>
                
                <div class="controls" id="controls">
                  <!-- Number buttons -->
                  <button onclick="handleThrow(0)">0</button>
                  <button onclick="handleThrow(1)">1</button>
                  <button onclick="handleThrow(2)">2</button>
                  <button onclick="handleThrow(3)">3</button>
                  <button onclick="handleThrow(4)">4</button>
                  <button onclick="handleThrow(5)">5</button>
                  <button onclick="handleThrow(6)">6</button>
                  <button onclick="handleThrow(7)">7</button>
                  <button onclick="handleThrow(8)">8</button>
                  <button onclick="handleThrow(9)">9</button>
                  <!-- Special buttons -->
                  <button onclick="handleStrike()">X</button>
                  <button onclick="handleSpare()">/</button>
                </div>

                <!-- Hidden form fields for game data -->
                <form id="createForm" class="d-none">
                  <input type="text" id="gameID" name="gameID">
                  <input type="text" id="matchID" name="matchID">
                  <input type="number" id="gameNumber" name="gameNumber">
                  <input type="text" id="gameStatusID" name="gameStatusID">
                  <input type="number" id="score" name="score">
                </form>
              </div>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
              <button type="button" class="btn btn-success" onclick="AddModalTemplates.submitCreateForm('bowlingGame')">Submit Game</button>
            </div>
          </div>
        </div>
      </div>`;
  }

  /**
   * submitCreateForm(tableName)
   *
   * Gathers form data from the modal, constructs a JSON object, and sends it to the server.
   * Displays success or failure messages based on server response.
   *
   * @param {string} tableName - The name of the table (or entity) to which the new item will be added.
   */
  static async submitCreateForm(tableName) {
    // Get all input elements within the form
    const form = document.getElementById("createForm");
    const inputs = form.querySelectorAll("input");

    // Dynamically collect form data based on input fields in the form
    const formData = {}; // Object to store form data as key-value pairs
    inputs.forEach((input) => {
      formData[input.name] = input.value; // Assign each input's value to formData using input's name as key
    });

    try {
      // Send form data to the server with a POST request
      const response = await fetch(`../MiddleWare/addItem.php`, {
        method: "POST",
        headers: {
          "Content-Type": "application/json",
        },
        body: JSON.stringify({
          table_name: tableName, // Include table name to indicate the target entity
          data: formData, // Include the collected form data
        }),
      });

      const result = await response; // Parse the server response as JSON

      // Check if the item was created successfully and display appropriate message
      if (result.status === 200) {
        alert(`${tableName} created successfully!`); // Success message

        // Close the modal on successful creation
        const createModalInstance = bootstrap.Modal.getInstance(
          document.getElementById("createModal")
        );
        createModalInstance.hide();
      } else {
        alert(`Failed to create ${tableName}: ${result.message}`); // Failure message with server feedback
      }
    } catch (error) {
      // Handle any network or server error
      console.error(`Error creating ${tableName}:`, error); // Log error details
      alert(`Error creating ${tableName}: ` + error.message); // Display error message to user
    }
  }
}
