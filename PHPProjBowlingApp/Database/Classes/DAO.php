<?php

require_once dirname(__DIR__, 2) . '/Database/Classes/Entities.php';
require_once dirname(__DIR__, 2) . '/Database/Classes/DatabaseConstants.php';

class DAO
{

    // Database connection
    private $conn;

    public function __construct($conn)
    {
        // Check if the connection is null
        if (is_null($conn)) {
            throw new Exception("No connection"); // Throw an exception if there's no connection
        }
        $this->conn = $conn;
    }

    /**
     * Get all items from the database table given by $tableName.
     *
     * Creates objects from the table's rows using the table's name as the class name.
     * The class must have a constructor with parameters that match the table's columns.
     * The function will return an array of objects where each object represents a row in the table.
     *
     * @param string $tableName The name of the table in the database.
     * @return array An array of objects where each object represents a row in the table.
     */
    public function getAllItems($tableName)
    {
        $results = []; // Initialize an empty array to store the fetched items

        try {
            // Construct the SQL query to select all items from the specified table
            $sql = "SELECT * FROM " . $tableName;
            $stmt = $this->conn->prepare($sql); // Prepare the SQL statement

            // Execute the query and fetch all results as an associative array
            $stmt->execute(); // Execute the statement
            $dbresults = $stmt->fetchAll(PDO::FETCH_ASSOC); // Fetch all rows from the result set

            // Convert the table name to lowercase to match the assumed class name
            $className = strtolower($tableName);

            // Check if a class exists with the same name as the table (in lowercase)
            if (!class_exists($className)) {
                throw new Exception("Class $className does not exist."); // Throw exception if class is missing
            }

            // Loop through each row in the database results to create an object
            foreach ($dbresults as $row) {
                $reflector = new ReflectionClass($className); // Use reflection to obtain the class based on $className

                // Retrieve the parameters expected by the class constructor
                $constructorParams = $reflector->getConstructor()->getParameters();

                // Initialize an array to store arguments for the constructor
                $constructorArgs = [];

                // Match each constructor parameter to a column in the row data
                foreach ($constructorParams as $param) {
                    $paramName = $param->getName(); // Get the name of the constructor parameter

                    // Check if the row contains a value for this parameter and add it to the constructor arguments, defaulting to null if missing
                    $constructorArgs[] = $row[$paramName] ?? null;
                }

                // Create an instance of the class, passing in the matched constructor arguments
                $item = $reflector->newInstanceArgs($constructorArgs);
                array_push($results, $item); // Add the instantiated object to the results array
            }
        } catch (PDOException $e) {
            // Handle any PDO-related errors, such as connection issues
            error_log("PDO Error: " . $e->getMessage()); // Log the error for debugging

            // If a PDO error occurs, reset results to an empty array
            $results = [];
        } catch (ReflectionException $e) {
            // Handle any reflection-related errors, such as missing classes or issues creating the object
            error_log("Reflection Error: " . $e->getMessage()); // Log the error for debugging
        } finally {
            // Ensure the cursor is closed to free up resources, if the statement was successfully initialized
            if (!is_null($stmt)) {
                $stmt->closeCursor();
            }
        }

        // Return the array of results, which may be empty if an error occurred
        return $results;
    }

    /**
     * Get a single item from the database table given by $tableName and $id.
     *
     * Creates an object from the table's row using the table's name as the class name.
     * The class must have a constructor with parameters that match the table's columns.
     * If the item exists, the function returns an object representing the row; otherwise, it returns null.
     *
     * @param string $tableName The name of the table in the database.
     * @param mixed $id The ID of the row to retrieve (integer or string).
     * @return object|null An object representing the row, or null if the item doesn't exist.
     */
    public function getItemById($tableName, $id)
    {
        $item = null; // Variable to store the result

        // Define a mapping of table names to their respective ID columns
        $idColumns = [
            'team' => 'teamID',
            'player' => 'playerID',
            'province' => 'provinceID',
            'tournamentround' => 'roundID',
            'matchup' => 'matchID',
            'game' => 'gameID',
            'gamestatus' => 'gameStatusID',
            'payout' => 'payoutID'
        ];

        try {
            // Check if the table has a defined ID column
            if (!isset($idColumns[$tableName])) {
                throw new Exception("ID column for table $tableName not defined.");
            }

            // Get the correct ID column name for the table
            $idColumn = $idColumns[$tableName];

            // SQL query to fetch the item with the specific ID
            $sql = "SELECT * FROM " . $tableName . " WHERE " . $idColumn . " = :id LIMIT 1";
            $stmt = $this->conn->prepare($sql);

            // Determine the ID data type and bind it accordingly
            if (is_int($id)) {
                $stmt->bindParam(':id', $id, PDO::PARAM_INT);
            } else {
                $stmt->bindParam(':id', $id, PDO::PARAM_STR);
            }

            // Execute the statement
            $stmt->execute();

            // Fetch the result
            $row = $stmt->fetch(PDO::FETCH_ASSOC);

            // If a row is found, proceed to create an object
            if ($row) {
                // Convert the table name to lowercase to match the class name
                $className = strtolower($tableName);

                // Check if the class exists
                if (!class_exists($className)) {
                    throw new Exception("Class $className does not exist.");
                }

                // Reflect the class and get its constructor parameters
                $reflector = new ReflectionClass($className);
                $constructorParams = $reflector->getConstructor()->getParameters();

                // Extract values from the row to match the constructor parameters
                $constructorArgs = [];
                foreach ($constructorParams as $param) {
                    $paramName = $param->getName();
                    $constructorArgs[] = $row[$paramName] ?? null;
                }

                // Create an instance of the class with the constructor arguments
                $item = $reflector->newInstanceArgs($constructorArgs);
            }
        } catch (PDOException $e) {
            // Log the error (optional)
            error_log("PDO Error: " . $e->getMessage());
        } catch (ReflectionException $e) {
            // Log reflection errors (optional)
            error_log("Reflection Error: " . $e->getMessage());
        } catch (Exception $e) {
            // Log any other errors (optional)
            error_log("Error: " . $e->getMessage());
        } finally {
            // Close the cursor if the statement is not null
            if (!is_null($stmt)) {
                $stmt->closeCursor();
            }
        }

        return $item; // Return the item or null if not found
    }

    /**
     * Delete an item from the specified table by its ID.
     *
     * @param string $tableName The name of the table in the database.
     * @param mixed $id The ID of the item to delete (can be an integer or a string).
     * @return bool True if the deletion was successful, false otherwise.
     * @throws Exception If the table name or ID column is invalid.
     */
    public function deleteItemById($tableName, $id)
    {
        // Define a mapping of table names to their respective ID columns, using a constant from DatabaseConstants
        $idColumns = DatabaseConstants::$idColumns;

        // Verify if the specified table has a defined ID column in the mapping
        if (!isset($idColumns[$tableName])) {
            throw new Exception("ID column for table $tableName not defined."); // Throw an exception if no ID column is defined for the table
        }

        // Retrieve the ID column name for the given table
        $idColumn = $idColumns[$tableName];

        try {
            // Construct the SQL 'DELETE' statement dynamically based on the table and ID column
            $sql = "DELETE FROM " . $tableName . " WHERE " . $idColumn . " = :id";
            error_log("Executing SQL: $sql with ID: $id"); // Log the constructed SQL query and the ID for tracking and debugging

            // Prepare the SQL statement using the database connection
            $stmt = $this->conn->prepare($sql);

            // Bind the ID parameter to the statement, with data type checking to ensure correct parameter binding
            if (is_int($id)) {
                $stmt->bindParam(':id', $id, PDO::PARAM_INT); // Bind ID as integer if $id is of integer type
            } else {
                $stmt->bindParam(':id', $id, PDO::PARAM_STR); // Bind ID as string if $id is a string
            }

            // Execute the prepared SQL statement
            $executeResult = $stmt->execute();

            // Capture the number of rows affected by the delete operation for verification
            $affectedRows = $stmt->rowCount();
            error_log("Delete affected rows: " . $affectedRows); // Log the number of rows affected for confirmation

            // Return true if at least one row was deleted, otherwise return false
            return $executeResult && $affectedRows > 0;
        } catch (PDOException $e) {
            // Log any PDO exceptions encountered during the deletion process
            error_log("PDO Error: " . $e->getMessage());
            return false; // Return false to indicate deletion failure in case of an error
        }
    }


    /**
     * Insert a new item into the specified table with the given associative array of values.
     *
     * @param string $tableName The name of the table in the database.
     * @param array $data An associative array where the keys are the column names and the values are the values to be inserted.
     * @return bool True if the insertion was successful, false otherwise.
     * @throws Exception If $data is not a non-empty associative array.
     */
    public function addItem($tableName, $data)
    {
        // Validate input: Ensure $data is a non-empty associative array
        if (!is_array($data) || empty($data)) {
            throw new Exception("Data must be a non-empty associative array."); // Throw exception if $data is invalid
        }

        // Extract column names from $data keys to construct the SQL statement
        $columns = array_keys($data); // Columns will hold an array of column names
        $placeholders = array_map(fn($col) => ":$col", $columns); // Map each column name to a named placeholder (e.g., ":column_name")

        // Construct the SQL 'INSERT' statement using the table name, columns, and placeholders
        $sql = "INSERT INTO " . $tableName . " (" . implode(", ", $columns) . ") VALUES (" . implode(", ", $placeholders) . ")";
        error_log("Executing SQL: $sql with data: " . json_encode($data)); // Log the constructed SQL query and data for debugging

        try {
            // Prepare the SQL statement
            $stmt = $this->conn->prepare($sql); // Prepares the query with placeholders for later binding

            // Bind each value in $data to the corresponding named placeholder in the SQL statement
            foreach ($data as $column => $value) {
                $stmt->bindValue(":$column", $value); // Bind each column's value to its placeholder
            }

            // Execute the prepared statement
            return $stmt->execute(); // Returns true if successful, false otherwise
        } catch (PDOException $e) {
            // Log PDO error message for debugging if execution fails
            error_log("PDO Error: " . $e->getMessage());
            return false; // Return false to indicate failure
        }
    }
}
