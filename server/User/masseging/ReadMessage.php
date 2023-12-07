<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json");
header("Access-Control-Allow-Headers: Content-Type");
include '../include/connect.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    try {
        $data = json_decode(file_get_contents("php://input"));

        $senderID = $data->SenderID;
        $receiverID = $data->ReceiverID;

        $query = "SELECT m.*, sender.Username AS SenderUsername, receiver.Username AS ReceiverUsername
                  FROM messages m
                  JOIN users sender ON m.SenderID = sender.UserID
                  JOIN users receiver ON m.ReceiverID = receiver.UserID
                  WHERE (m.SenderID = :senderID AND m.ReceiverID = :receiverID)
                  OR (m.SenderID = :receiverID AND m.ReceiverID = :senderID)
                  ORDER BY m.Timestamp DESC";
        
        $stmt = $pdo->prepare($query);
        $stmt->bindParam(':senderID', $senderID);
        $stmt->bindParam(':receiverID', $receiverID);
        $stmt->execute();
        $messages = $stmt->fetchAll(PDO::FETCH_ASSOC);

        echo json_encode($messages);
    } catch (PDOException $e) {
        die("Error: " . $e->getMessage());
    }
} else {
    echo json_encode(['message' => 'Incorrect request method']);
}
