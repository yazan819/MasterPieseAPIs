<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: PUT, GET, POST, DELETE, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type");
header("Content-Type: application/json");
include '../include/connect.php';



if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(200);
    exit();
}
// Check if the request method is POST
if ($_SERVER['REQUEST_METHOD'] === 'PUT') {
    // Get JSON data from the request body
    $json = file_get_contents('php://input');

    // Decode JSON to an associative array
    $data = json_decode($json, true);

    // Check if the data was successfully decoded
    if ($data !== null) {
        // Retrieve data from the decoded JSON
        $requestID = $data['requestID']; // Extracting requestID from JSON

        try {
            // Your SQL query to update the request status to "Rejected"
            $query = "UPDATE SkillSwapRequests 
                      SET RequestStatus = 'Rejected' 
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
                echo json_encode(array("message" => "Skill swap request rejected!"));
            } else {
                // If the request ID doesn't exist or update was unsuccessful
                http_response_code(404); // Set response code to 404 (Not Found)
                echo json_encode(array("message" => "Skill swap request not found or could not be rejected"));
            }
        } catch (PDOException $e) {
            // Error handling if the query fails
            http_response_code(500); // Set response code to 500 (Internal Server Error)
            echo json_encode(array("message" => "Error rejecting skill swap request: " . $e->getMessage()));
        }
    } else {
        // If the JSON data is invalid
        http_response_code(400); // Set response code to 400 (Bad Request)
        echo json_encode(array("message" => "Invalid JSON data"));
    }
} else {
    // If the request method is not POST
    http_response_code(405); // Set response code to 405 (Method Not Allowed)
    echo json_encode(array("message" => "Method not allowed"));
}
?>
