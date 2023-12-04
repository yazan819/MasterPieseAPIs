<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json");
header("Access-Control-Allow-Headers: Content-Type");
include '../include/connect.php';

if ($_SERVER["REQUEST_METHOD"] == "GET") {
    try {
        $query = "SELECT * FROM posts;";
        $stmt = $pdo->query($query);
        $posts = $stmt->fetchAll(PDO::FETCH_ASSOC);

        echo json_encode($posts);
    } catch (PDOException $e) {
        die("Error: " . $e->getMessage());
    }
} else {
    echo json_encode(['message' => 'Incorrect request method']);
}
