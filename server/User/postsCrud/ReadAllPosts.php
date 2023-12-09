<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json");
header("Access-Control-Allow-Headers: Content-Type");
include '../include/connect.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    try {
        $data = json_decode(file_get_contents("php://input"), true);

        if(isset($data['userID'])) {
            $userID = $data['userID'];

            $query = "SELECT posts.*, users.Username, users.ProfilePictureURL AS profile_picture FROM posts JOIN users ON users.UserID = posts.UserID WHERE posts.UserID != ?;";
            $stmt = $pdo->prepare($query);

            $stmt->execute([$userID]);
            $posts = $stmt->fetchAll(PDO::FETCH_ASSOC);

            echo json_encode($posts);
        } else {
            echo json_encode(['message' => 'userID not provided']);
        }
    } catch (PDOException $e) {
        die("Error: " . $e->getMessage());
    }
} else {
    echo json_encode(['message' => 'Incorrect request method']);
}
?>
