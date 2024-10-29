<?php

require_once dirname(__DIR__, 2) . '/Database/Classes/Entities.php';


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
        $results = []; // Array to store the results

        try {
            // SQL query to fetch all items from the table
            $sql = "SELECT * FROM " .  $tableName;
            $stmt = $this->conn->prepare($sql);

            // Execute the getAllStatement and fetch all the results
            $stmt->execute(); // Execute the statement
            $dbresults = $stmt->fetchAll(PDO::FETCH_ASSOC); // Fetch all the results

            // Convert the table name to lowercase to match the class name
            $className = strtolower($tableName);

            // Check if the class exists (preventing reflection issues)
            if (!class_exists($className)) {
                throw new Exception("Class $className does not exist.");
            }

            // Loop through the results and create objects for each row
            foreach ($dbresults as $row) {
                $reflector = new ReflectionClass($className); // Get the class based on the table name

                // Get the constructor parameters
                $constructorParams = $reflector->getConstructor()->getParameters();

                // Extract values from the db row that match the constructor parameters
                $constructorArgs = []; // Array to store the constructor arguments

                foreach ($constructorParams as $param) {
                    $paramName = $param->getName(); // Get the parameter name, e.g. id

                    // Check if the value exists in the row or set it to null if it doesn't
                    $constructorArgs[] = $row[$paramName] ?? null;
                }

                // Finally, create the object using the arguments
                $item = $reflector->newInstanceArgs($constructorArgs);
                array_push($results, $item);
            }
        } catch (PDOException $e) {
            // Log the error (optional)
            error_log("PDO Error: " . $e->getMessage());

            // If there's an error, set the results to an empty array
            $results = [];
        } catch (ReflectionException $e) {
            // Log reflection errors (optional)
            error_log("Reflection Error: " . $e->getMessage());
        } finally {
            // Close the cursor if the statement is not null
            if (!is_null($stmt)) {
                $stmt->closeCursor();
            }
        }

        return $results; // Return the results array
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

        // Check if the table has a defined ID column
        if (!isset($idColumns[$tableName])) {
            throw new Exception("ID column for table $tableName not defined.");
        }

        // Get the correct ID column name for the table
        $idColumn = $idColumns[$tableName];

        try {
            // Prepare the SQL delete statement
            $sql = "DELETE FROM " . $tableName . " WHERE " . $idColumn . " = :id";
            error_log("Executing SQL: $sql with ID: $id"); // Log SQL query and ID for debugging
            $stmt = $this->conn->prepare($sql);

            // Bind the ID parameter based on its type (integer or string)
            if (is_int($id)) {
                $stmt->bindParam(':id', $id, PDO::PARAM_INT);
            } else {
                $stmt->bindParam(':id', $id, PDO::PARAM_STR);
            }

            // Execute the delete statement
            $executeResult = $stmt->execute();
            $affectedRows = $stmt->rowCount(); // Get the number of affected rows
            error_log("Delete affected rows: " . $affectedRows); // Log affected rows

            // Return true if at least one row was deleted, otherwise false
            return $executeResult && $affectedRows > 0;
        } catch (PDOException $e) {
            // Log the error
            error_log("PDO Error: " . $e->getMessage());
            return false;
        }
    }
}
