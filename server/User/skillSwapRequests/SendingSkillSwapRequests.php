<?php
// Include the file with database connection details
include '../include/connect.php';

// Check if the request method is POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Retrieve data from the request body
    $json_data = file_get_contents('php://input');
    $data = json_decode($json_data, true);

    // Check if required keys exist in the JSON data
    if (isset($data['senderID'], $data['receiverID'], $data['skillID'])) {
        // Retrieve data from JSON
        $senderID = $data['senderID'];
        $receiverID = $data['receiverID'];
        $skillID = $data['skillID'];

        try {
            // Your SQL query to insert a new skill swap request
            $query = "INSERT INTO SkillSwapRequests (SenderID, ReceiverID, SkillID, RequestStatus) 
                      VALUES (:senderID, :receiverID, :skillID, 'Pending')";

            // Prepare the SQL statement
            $stmt = $pdo->prepare($query);

            // Bind parameters
            $stmt->bindParam(':senderID', $senderID);
            $stmt->bindParam(':receiverID', $receiverID);
            $stmt->bindParam(':skillID', $skillID);

            // Execute the query
            $stmt->execute();

            // Check if the query was successful
            if ($stmt->rowCount() > 0) {
                // Request successfully added
                http_response_code(201); // Set response code to 201 (Created)
                echo json_encode(array("message" => "Skill swap request sent!"));
            } else {
                // If the request couldn't be added
                http_response_code(400); // Set response code to 400 (Bad Request)
                echo json_encode(array("message" => "Could not send skill swap request"));
            }
        } catch (PDOException $e) {
            // Error handling if the query fails
            http_response_code(500); // Set response code to 500 (Internal Server Error)
            echo json_encode(array("message" => "Error sending skill swap request: " . $e->getMessage()));
        }
    } else {
        // If required keys are not present in the JSON data
        http_response_code(400); // Set response code to 400 (Bad Request)
        echo json_encode(array("message" => "Invalid JSON data. Required keys are missing."));
    }
} else {
    // If the request method is not POST
    http_response_code(405); // Set response code to 405 (Method Not Allowed)
    echo json_encode(array("message" => "Method not allowed"));
}
?>