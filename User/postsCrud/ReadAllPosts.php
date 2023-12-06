<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json");
header("Access-Control-Allow-Headers: Content-Type");
include '../include/connect.php';

if ($_SERVER["REQUEST_METHOD"] == "GET") {
    try {
        $query = "SELECT posts.* , users.Username ,users.ProfilePictureURL AS profile_picture FROM posts JOIN users on users.UserID = posts.UserID;";
        $stmt = $pdo->query($query);
        $posts = $stmt->fetchAll(PDO::FETCH_ASSOC);

        echo json_encode($posts);
    } catch (PDOException $e) {
        die("Error: " . $e->getMessage());
    }
} else {
    echo json_encode(['message' => 'Incorrect request method']);
}
