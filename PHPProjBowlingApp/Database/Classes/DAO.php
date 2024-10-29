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
}
