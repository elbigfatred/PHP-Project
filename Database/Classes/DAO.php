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
            $sql = "SELECT * FROM " .  $tableName; // SQL query to fetch all items from the table
            $stmt = $this->conn->prepare($sql);
            // Execute the getAllStatement and fetch all the results
            $stmt->execute(); // Execute the statement
            $dbresults = $stmt->fetchAll(PDO::FETCH_ASSOC); // Fetch all the results

            $className = strtolower($tableName); // Convert the table name to lowercase to match the class name

            // Loop through the results and create an objects for each row
            foreach ($dbresults as $row) {
                $reflector = new ReflectionClass($className); // Get the class, based on the table name
                $constructorParams = $reflector->getConstructor()->getParameters(); // Get the constructor parameters

                //Extract values from the db row that match the constructor parameters
                $constructorArgs = []; // Array to store the constructor arguments
                foreach ($constructorParams as $param) {
                    $paramName = $param->getName(); // Get the parameter name, e.g. id
                    if (isset($row[$paramName])) {
                        $constructorArgs[] = $row[$paramName]; // Add the value to the constructor arguments
                    } else {
                        throw new Exception("No value for $paramName");
                    }
                }

                //finally, create the object
                $item = $reflector->newInstanceArgs($constructorArgs);
                array_push($results, $item);
            }
        } catch (PDOException $e) {
            // If there's an error, set the results to an empty array
            $results = [];
        } finally {
            // Close the cursor if the statement is not null
            if (!is_null($stmt)) {
                $stmt->closeCursor();
            }
        }
        return $results; // Return the results array
    }
}
