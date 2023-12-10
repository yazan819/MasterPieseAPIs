<?php
// Include the file with database connection details
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: PUT, GET, POST, DELETE, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type");
header("Content-Type: application/json");
include '../include/connect.php';



if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(200);
    exit();
}
if ($_SERVER['REQUEST_METHOD'] === 'PUT') {
    // Retrieve data from the request body
    $json_data = file_get_contents('php://input');
    $data = json_decode($json_data, true);

    // Check if the 'requestID' key exists in the JSON data
    if (isset($data['requestID'])) {
        // Retrieve the request ID from the JSON data
        $requestID = $data['requestID'];

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
        // If 'requestID' key is not present in the JSON data
        http_response_code(400); // Set response code to 400 (Bad Request)
        echo json_encode(array("message" => "Invalid JSON data. 'requestID' key not found."));
    }
} else {
    // If the request method is not POST
    http_response_code(405); // Set response code to 405 (Method Not Allowed)
    echo json_encode(array("message" => "Method not allowed"));
}
?>