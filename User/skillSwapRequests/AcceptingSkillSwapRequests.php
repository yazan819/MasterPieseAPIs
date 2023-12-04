<?php
// Include the file with database connection details
include "connect.php";

// Check if the request method is POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Retrieve data from the request
    $requestID = $_POST['requestID']; // Replace this with your method of obtaining the request ID

    try {
        // Your SQL query to update the request status to "Accepted"
        $query = "UPDATE SkillSwapRequests 
                  SET RequestStatus = 'Accepted' 
                  WHERE RequestID = :requestID";

        // Prepare the SQL statement
        $stmt = $pdo->prepare($query);

        // Bind parameters
        $stmt->bindParam(':requestID', $requestID);

        // Execute the query
        $stmt->execute();

        // Check if the query was successful
        if ($stmt->rowCount() > 0) {
            // Request status updated successfully
            http_response_code(200); // Set response code to 200 (OK)
            echo json_encode(array("message" => "Skill swap request accepted!"));
        } else {
            // If the request ID doesn't exist or update was unsuccessful
            http_response_code(404); // Set response code to 404 (Not Found)
            echo json_encode(array("message" => "Skill swap request not found or could not be accepted"));
        }
    } catch (PDOException $e) {
        // Error handling if the query fails
        http_response_code(500); // Set response code to 500 (Internal Server Error)
        echo json_encode(array("message" => "Error accepting skill swap request: " . $e->getMessage()));
    }
} else {
    // If the request method is not POST
    http_response_code(405); // Set response code to 405 (Method Not Allowed)
    echo json_encode(array("message" => "Method not allowed"));
}
?>
