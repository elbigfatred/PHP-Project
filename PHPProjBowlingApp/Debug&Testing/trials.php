<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Document</title>
  <script src="./Steve's Bowling Game Generator/BowlingUtils.js"></script>
</head>

<body>
  <h1>Testing Page</h1>

  <div>
    <h2>Build a table from table name</h2>
    <label for="tableInput">Table Name: </label>
    <input type="text" id="tableInput" name="tableInput">
    <button type="button" id="tableButton">Get Table</button>
  </div>

  <div id="tableOutput"></div>

  <script>
    document.getElementById("tableButton").addEventListener("click", getTable);



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
        let json = JSON.parse(data);
        console.log(json); // contains all the objects in an array!

        BuildTable(json);


      } catch (error) {
        console.error("Error fetching data:", error);
        output.innerHTML = "Error fetching data: " + error;
      }
    }

    function BuildTable(data) {
      let outputArea = document.getElementById("tableOutput"); // Get the output element to display results
      outputArea.innerHTML = ''; // Clear previous content

      if (data.length === 0) {
        outputArea.innerHTML = 'No data available.';
        return;
      }

      // Create the table
      let table = document.createElement('table');
      table.setAttribute('border', '1'); // Optional: Add border to table for visibility

      // Build the table headers using the keys from the first object in the array
      let headers = Object.keys(data[0]); // Get the keys of the first object in the array
      let thead = document.createElement('thead');
      let headerRow = document.createElement('tr');

      headers.forEach(header => {
        let th = document.createElement('th');
        th.textContent = header; // Set the header text
        headerRow.appendChild(th);
      });

      thead.appendChild(headerRow);
      table.appendChild(thead);

      // Build the table body by looping through the data array
      let tbody = document.createElement('tbody');

      data.forEach(item => {
        let row = document.createElement('tr');

        headers.forEach(header => {
          let td = document.createElement('td');
          td.textContent = item[header]; // Add the value for each key (column)
          row.appendChild(td);
        });

        tbody.appendChild(row);
      });

      table.appendChild(tbody);

      // Append the table to the output area
      outputArea.appendChild(table);
    }
  </script>
</body>

</html>