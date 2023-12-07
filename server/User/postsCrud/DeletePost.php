<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: DELETE");
header("Access-Control-Allow-Headers: Content-Type");
header("Content-Type: application/json");
include '../include/connect.php';

// {
//     "PostID": 1
// }


if ($_SERVER["REQUEST_METHOD"] == "DELETE") {
    try {
        $json_data = file_get_contents('php://input');
        $data = json_decode($json_data, true);

        if (isset($data['PostID'])) {
            $query = "DELETE FROM posts WHERE PostID = ?;";
            $stmt = $pdo->prepare($query);
            $stmt->execute([$data['PostID']]);

            echo json_encode(['message' => 'Post deleted successfully']);
        } else {
            echo json_encode(['message' => 'PostID not provided']);
        }
    } catch (PDOException $e) {
        die("Error: " . $e->getMessage());
    }
} else {
    echo json_encode(['message' => 'Incorrect request method']);
}
?>
