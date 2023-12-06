<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json");
include '../include/connect.php'; // Ensure this path is correct for database connection

if ($_SERVER["REQUEST_METHOD"] == "PUT") {
    try {
        $data = json_decode(file_get_contents("php://input"));

        // Extract necessary data from the request
        $messageID = $data->MessageID; // Assuming you have a MessageID to identify the message to update
        $newMessageText = $data->NewMessageText; // The updated message text

        // Prepare the query to update the message in the database
        $query = "UPDATE messages SET MessageText = :newMessageText WHERE MessageID = :messageID";
        $stmt = $pdo->prepare($query);
        $stmt->bindParam(':newMessageText', $newMessageText);
        $stmt->bindParam(':messageID', $messageID);
        $stmt->execute();

        // If the message is successfully updated, send a success response
        echo json_encode(['message' => 'Message updated successfully']);
    } catch (PDOException $e) {
        // If an error occurs during the database operation, handle the exception
        echo json_encode(['error' => 'Error updating message: ' . $e->getMessage()]);
    }
} else {
    // If the request method is not PUT, return an error message
    echo json_encode(['message' => 'Incorrect request method']);
}
?>
