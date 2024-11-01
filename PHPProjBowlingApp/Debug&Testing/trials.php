<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Document</title>
  <script src="./Steve's Bowling Game Generator/BowlingUtils.js"></script>
  <script src="../FrontEnd/ModalTemplates/AddModalTemplates.js"></script>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</head>

<body>
  <h1>Testing Page</h1>

  <div>
    <h2>Build a table from table name</h2>
    <label for="tableInput">Table Name: </label>
    <input type="text" id="tableInput" name="tableInput">
    <label for="idInput">ID: </label>
    <input type="text" id="idInput" name="idInput" placeholder="1">
    <button type="button" id="tableButton">Get Full Table</button>
    <button type="button" id="idButton">Get Item By ID</button>
    <button type="button" onclick="openCreateModal('player')" class="btn btn-success mb-2">Create Player</button>
    <button type="button" onclick="openCreateModal('team')" class="btn btn-success mb-2">Create Team</button>
    <button type="button" onclick="openCreateModal('tournamentround')" class="btn btn-success mb-2">Create Tournament Round</button>
    <button type="button" onclick="openCreateModal('province')" class="btn btn-success mb-2">Create Province</button>
    <button type="button" onclick="createTeams()" class="btn btn-success mb-2">View Teams</button>
    <button type="button" id="updateButton" class="btn btn-success mb-2">update record</button>

    <div id="modalContent"></div>
  </div>

  <div id="tableOutput"></div>

  <script>
    document.getElementById("tableButton").addEventListener("click", getTable);
    document.getElementById("idButton").addEventListener("click", getItemById);
    document.getElementById("updateButton").addEventListener("click", updateRecord);


    async function createTeams() {
      try {
        // Construct the URL with the table name
        let url = "../MiddleWare/getAllItems.php?table_name=team";
        console.log("Request URL:", url);

        // Fetch the data from the server
        let response = await fetch(url);

        console.log("Response:", response);
        // Check if the response is OK (status code 200)
        if (!response.ok) {
          throw new Error(`HTTP error! status: ${response.status}`);
        }

        // Parse the JSON response
        let data = await response.text();
        let json = JSON.parse(data);
        console.log(json); // contains all the objects in an array!

        BuildTeamTable(json);

      } catch (error) {
        console.error("Error fetching data:", error);
        output.innerHTML = "Error fetching data: " + error;
      }
    }


    function BuildTeamTable(data) {
      console.log("data passed into BuildTeamTable:", data);
      let outputArea = document.getElementById("tableOutput"); // Get the output element to display results
      outputArea.innerHTML = ''; // Clear previous content

      if (!Array.isArray(data)) {
        data = [data]; // Wrap data in an array if it's not already one
      }

      if (data.length === 0) {
        outputArea.innerHTML = 'No data available.';
        return;
      }

      // Create the table
      let table = document.createElement('table');
      table.setAttribute('border', '1');

      // Build the table headers using the keys from the first object in the array
      let headers = Object.keys(data[0]);
      let thead = document.createElement('thead');
      let headerRow = document.createElement('tr');

      // Add the headers to the header row
      headers.forEach(header => {
        let th = document.createElement('th');
        th.textContent = header;
        headerRow.appendChild(th);
      });

      // Add an extra header for the "Actions" column
      let actionHeader = document.createElement('th');
      actionHeader.textContent = "Actions";
      headerRow.appendChild(actionHeader);

      thead.appendChild(headerRow);
      table.appendChild(thead);

      // Build the table body by looping through the data array
      let tbody = document.createElement('tbody');

      data.forEach(item => {
        let row = document.createElement('tr');

        // Loop through each key (column) in the object
        headers.forEach(header => {
          let td = document.createElement('td');
          td.textContent = item[header];
          row.appendChild(td);
        });

        // Create a cell for the "View Players" button
        let actionCell = document.createElement('td');
        let viewPlayersButton = document.createElement('button');
        viewPlayersButton.textContent = "View Players";

        // Dynamically determine the ID key (assumes ID is the first key ending in 'ID')
        let idKey = headers.find(header => header.toLowerCase().endsWith('id'));
        if (idKey) {
          let idValue = item[idKey];

          // Add event listener to handle viewing players for the team with the given ID
          viewPlayersButton.addEventListener('click', () => {
            obtainPlayers(idValue); // Pass the team ID to the viewPlayers function
          });
        }

        // Add the button to the cell
        actionCell.appendChild(viewPlayersButton);
        row.appendChild(actionCell);

        // Add the row to the table
        tbody.appendChild(row);
      });

      table.appendChild(tbody);
      outputArea.appendChild(table);
    }

    async function obtainPlayers(teamID) {
      console.log(`Fetching players for team ID: ${teamID}`);

      try {
        // Fetch all players from the getAllItems.php endpoint
        let url = "../MiddleWare/getAllItems.php?table_name=player";
        let response = await fetch(url);

        if (!response.ok) {
          throw new Error(`HTTP error! status: ${response.status}`);
        }

        // Parse the JSON response
        let data = await response.json();
        console.log("All players fetched:", data);

        // Filter players by teamID
        const playersForTeam = data.filter(player => player.teamID === teamID);
        console.log(`Players for team ${teamID}:`, playersForTeam);

        // Build and show the modal with the filtered players
        displayPlayersModal(playersForTeam, teamID);

      } catch (error) {
        console.error("Error fetching players:", error);
        alert("Error fetching players: " + error.message);
      }
    }

    function displayPlayersModal(players, teamID) {
      // Check if there are players to display
      if (players.length === 0) {
        alert(`No players found for team ID: ${teamID}`);
        return;
      }

      // Build the modal HTML
      const modalHTML = `
    <div class="modal fade" id="playersModal" tabindex="-1" aria-labelledby="playersModalLabel" aria-hidden="true">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="playersModalLabel">Players for Team ID: ${teamID}</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <div class="modal-body">
            <table class="table table-bordered">
              <thead>
                <tr>
                  <th>Player ID</th>
                  <th>Team ID</th>
                  <th>First Name</th>
                  <th>Last Name</th>
                  <th>Hometown</th>
                  <th>Province ID</th>
                </tr>
              </thead>
              <tbody>
                ${players.map(player => `
                  <tr>
                    <td>${player.playerID}</td>
                    <td>${player.teamID}</td>
                    <td>${player.firstName}</td>
                    <td>${player.lastName}</td>
                    <td>${player.hometown}</td>
                    <td>${player.provinceID}</td>
                  </tr>
                `).join('')}
              </tbody>
            </table>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
          </div>
        </div>
      </div>
    </div>`;

      // Insert the modal HTML into the modalContent div
      document.getElementById("modalContent").innerHTML = modalHTML;

      // Show the modal using Bootstrap's JavaScript API
      const playersModal = new bootstrap.Modal(document.getElementById('playersModal'));
      playersModal.show();
    }

    async function getTable() {
      let table = document.getElementById("tableInput").value; // Get the input value (table name)

      try {
        // Construct the URL with the table name
        let url = "../MiddleWare/getAllItems.php?table_name=" + table;
        console.log("Request URL:", url);

        // Fetch the data from the server
        let response = await fetch(url); // Await the fetch call

        console.log("Response:", response);
        // Check if the response is OK (status code 200)
        if (!response.ok) {
          throw new Error(`HTTP error! status: ${response.status}`);
        }

        // Parse the JSON response
        let data = await response;

        // Convert the data to a string
        data = await data.text();
        let json = JSON.parse(data, table);
        console.log(json); // contains all the objects in an array!

        BuildTable(json, table);


      } catch (error) {
        console.error("Error fetching data:", error);
        output.innerHTML = "Error fetching data: " + error;
      }
    }

    async function getItemById() {
      let table = document.getElementById("tableInput").value; // Get the input value (table name)
      let id = document.getElementById("idInput").value; // Get the input value (table name)

      try {
        // Construct the URL with the table name
        let url = "../MiddleWare/getItembyID.php?table_name=" + table + "&id=" + id;
        console.log("Request URL:", url);

        // Fetch the data from the server
        let response = await fetch(url); // Await the fetch call

        console.log("Response:", response);
        // Check if the response is OK (status code 200)
        if (!response.ok) {
          throw new Error(`HTTP error! status: ${response.status}`);
        }

        // Parse the JSON response
        let data = await response;

        // Convert the data to a string
        data = await data.text();
        let json = JSON.parse(data, table);
        console.log(json); // contains all the objects in an array!

        BuildTable(json);


      } catch (error) {
        console.error("Error fetching data:", error);
        output.innerHTML = "Error fetching data: " + error;
      }
    }

    function BuildTable(data, tableName) { // Accept tableName as an argument
      console.log("data passed into BuildTable:", data);
      let outputArea = document.getElementById("tableOutput"); // Get the output element to display results
      outputArea.innerHTML = ''; // Clear previous content

      if (!Array.isArray(data)) { // Check if data is an array; if not, wrap it in an array
        data = [data];
      }
      if (data.length === 0) {
        outputArea.innerHTML = 'No data available.';
        return;
      }

      // Create the table
      let table = document.createElement('table'); // Create a table
      table.setAttribute('border', '1'); // Add border to table for visibility

      // Build the table headers using the keys from the first object in the array
      let headers = Object.keys(data[0]); // Get the keys of the first object in the array
      let thead = document.createElement('thead'); // Create a table header
      let headerRow = document.createElement('tr'); // Create a header row

      // Add the headers to the header row
      headers.forEach(header => {
        let th = document.createElement('th'); // Create a table header
        th.textContent = header; // Set the header text
        headerRow.appendChild(th); // Add the header to the header row
      });

      // Add an extra header for the "Delete" button column
      let actionHeader = document.createElement('th'); // Create a table header
      actionHeader.textContent = "Actions"; // Set the header text
      headerRow.appendChild(actionHeader); // Add the header to the header row

      // Add the header row to the table
      thead.appendChild(headerRow);
      table.appendChild(thead);

      // Build the table body by looping through the data array
      let tbody = document.createElement('tbody');

      // Loop through each object in the array
      data.forEach(item => {
        let row = document.createElement('tr'); // Create a table row

        // Loop through each key (column) in the object
        headers.forEach(header => {
          let td = document.createElement('td'); // Create a table cell
          td.textContent = item[header]; // Add the value for each key (column)
          row.appendChild(td); // Add the cell to the row
        });

        // Create a cell for the delete button
        let actionCell = document.createElement('td'); // Create a table cell
        let deleteButton = document.createElement('button'); // Create a button

        // Dynamically determine the ID key (assumes ID is the first key ending in 'ID')
        let idKey = headers.find(header => header.toLowerCase().endsWith('id')); // Find the ID key
        if (idKey) {
          let idValue = item[idKey];
          deleteButton.textContent = `Delete item with ID: ${idValue}`;

          // Add event listener to handle deletion with table name and ID
          deleteButton.addEventListener('click', () => {
            deleteItem(tableName, idValue); // Pass tableName as an argument to deleteItem
          });
        } else {
          deleteButton.textContent = "Delete"; // Fallback if no ID key is found
        }

        // Add the button to the cell
        actionCell.appendChild(deleteButton);
        row.appendChild(actionCell);

        // Add the row to the table
        tbody.appendChild(row);
      });

      // Add the table body to the table
      table.appendChild(tbody);

      // Append the table to the output area
      outputArea.appendChild(table);
    }

    // Updated deleteItem function to accept both id and tableName
    async function deleteItem(tableName, id) {
      console.log(`Attempting to delete item with ID: ${id} from table: ${tableName}`);

      console.log("To delete -- table:", tableName, "id:", id);

      try {
        // Construct the URL with the table name and ID
        let url = `../MiddleWare/deleteItemByID.php?table_name=${tableName}&id=${id}`;
        console.log("Request URL:", url);

        // Send DELETE request to the server
        let response = await fetch(url, {
          method: 'DELETE'
        });

        console.log("Response:", response);

        // Check if the response is OK (status code 200)
        if (!response.ok) {
          throw new Error(`HTTP error! status: ${response.status}`);
        }

        // Parse the JSON response
        let data = await response.json();

        // Check for success status in the returned data
        if (data.status === 'success') {
          console.log(`Item with ID: ${id} successfully deleted from ${tableName}.`);
          alert(`Item with ID: ${id} successfully deleted from ${tableName}.`);

        } else {
          console.error(`Failed to delete item: ${data.message}`);
          alert(`Failed to delete item: ${data.message}`);
        }

      } catch (error) {
        console.error("Error deleting item:", error);
        alert("Error deleting item: " + error.message);
      }
    }

    // Function to open and create the modal dynamically
    function openCreateModal(tableName) {
      // Create the modal structure
      // Determine which modal template to use based on the tableName
      let modalHTML = '';
      switch (tableName) {
        case 'player':
          modalHTML = AddModalTemplates.player();
          break;
        case 'team':
          modalHTML = AddModalTemplates.team();
          break;
        case 'province':
          modalHTML = AddModalTemplates.province();
          break;
        case 'tournamentround':
          modalHTML = AddModalTemplates.tournamentround();
          break;
        case 'matchup':
          modalHTML = AddModalTemplates.matchup();
          break;
        case 'game':
          modalHTML = AddModalTemplates.game();
          break;
        case 'gamestatus':
          modalHTML = AddModalTemplates.gamestatus();
          break;
        case 'payout':
          modalHTML = AddModalTemplates.payout();
          break;
        default:
          console.error(`No modal template found for table: ${tableName}`);
          return;
      }
      // Append the modal HTML to the modalContent div
      document.getElementById("modalContent").innerHTML = modalHTML;

      // Initialize and show the modal using Bootstrap's JavaScript API
      const createModal = new bootstrap.Modal(document.getElementById('createModal'));
      createModal.show();
    }

    async function updateRecord() {
      let table = document.getElementById("tableInput").value.toLowerCase(); // Get the input value (table name)
      console.log(table);
      openCreateModal(table);
      let id = document.getElementById("idInput").value; // Get the input value (table name)


      try {
        // Construct the URL with the table name
        let url = "../MiddleWare/getItembyID.php?table_name=" + table + "&id=" + id;
        console.log("Request URL:", url);

        // Fetch the data from the server
        let response = await fetch(url); // Await the fetch call

        console.log("Response:", response);
        // Check if the response is OK (status code 200)
        if (!response.ok) {
          throw new Error(`HTTP error! status: ${response.status}`);
        }

        // Parse the JSON response
        let data = await response;

        // Convert the data to a string
        data = await data.text();
        let json = JSON.parse(data, table);
        console.log(json); // contains all the objects in an array!
        let modal = document.getElementById("modalContent");
        let inputs = modal.querySelectorAll("input");
        inputs.forEach(input => {
          input.value = json[input.id];
        });
      } catch (error) {
        console.error("Error fetching data:", error);
        output.innerHTML = "Error fetching data: " + error;
      }

    }
  </script>
</body>

</html>