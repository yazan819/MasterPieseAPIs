<?php
// Include the file with database connection details
include "connect.php";

// Check if the request method is POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Retrieve data from the request
    $senderID = $_POST['senderID']; // Replace this with your method of obtaining sender ID
    $receiverID = $_POST['receiverID']; // Replace this with your method of obtaining receiver ID
    $skillID = $_POST['skillID']; // Replace this with your method of obtaining skill ID

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
    // If the request method is not POST
    http_response_code(405); // Set response code to 405 (Method Not Allowed)
    echo json_encode(array("message" => "Method not allowed"));
}
?>
