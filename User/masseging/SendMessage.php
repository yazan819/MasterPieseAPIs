<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: PUT, GET, POST, DELETE, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type");
header("Content-Type: application/json");
include '../include/connect.php'; // Ensure this path is correct for database connection

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    try {
        $data = json_decode(file_get_contents("php://input"));

        // Extract necessary data from the request
        $senderID = $data->SenderID;
        $receiverID = $data->ReceiverID;
        $messageText = $data->MessageText;

        // Prepare the query to insert a new message into the database
        $query = "INSERT INTO messages (SenderID, ReceiverID, MessageText) VALUES (:senderID, :receiverID, :messageText)";
        $stmt = $pdo->prepare($query);
        $stmt->bindParam(':senderID', $senderID);
        $stmt->bindParam(':receiverID', $receiverID);
        $stmt->bindParam(':messageText', $messageText);
        $stmt->execute();

        // If the message is successfully sent, you might want to send a success response
        echo json_encode(['message' => 'Message sent successfully']);
    } catch (PDOException $e) {
        // If an error occurs during the database operation, handle the exception
        echo json_encode(['error' => 'Error sending message: ' . $e->getMessage()]);
    }
} else {
    // If the request method is not POST, return an error message
    echo json_encode(['message' => 'Incorrect request method']);
}
?>
