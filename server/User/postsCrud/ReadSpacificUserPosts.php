<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json");
header("Access-Control-Allow-Headers: Content-Type");
include '../include/connect.php';



if ($_SERVER["REQUEST_METHOD"] == "POST") {
    try {
        $json_data = file_get_contents('php://input');
        $data = json_decode($json_data, true);

        if (isset($data['UserID'])) {
            $UserID = $data['UserID'];
            $query = "SELECT posts.* , users.Username , users.ProfilePictureURL FROM posts JOIN users on users.UserID = posts.UserID WHERE posts.UserID = ? ;";
            $stmt = $pdo->prepare($query);
            $stmt->execute([$UserID]);
            $posts = $stmt->fetchAll(PDO::FETCH_ASSOC);

            if ($posts) {
                echo json_encode($posts);
            } else {
                echo json_encode(['message' => 'Post not found']);
            }
        } else {
            echo json_encode(['message' => 'Post ID not provided']);
        }
    } catch (PDOException $e) {
        die("Error: " . $e->getMessage());
    }
} else {
    echo json_encode(['message' => 'Incorrect request method']);
}

