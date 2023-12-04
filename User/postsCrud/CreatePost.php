<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Allow-Headers: Content-Type");
header("Content-Type: application/json");
include '../include/connect.php';

// {
//     "UserID": 1,
//     "YourNeed": "Web Development Help",
//     "YourProvide": "Graphic Design",
//     "Description": "Looking for assistance in front-end development"
// }

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    try {
        $json_data = file_get_contents('php://input');
        $data = json_decode($json_data, true);

        if (isset($data['UserID']) && isset($data['YourNeed']) && isset($data['YourProvide'])) {
            $query = "INSERT INTO posts (UserID, YourNeed, YourProvide, Description) VALUES (?, ?, ?, ?);";
            $stmt = $pdo->prepare($query);
            $stmt->execute([$data['UserID'], $data['YourNeed'], $data['YourProvide'], $data['Description']]);

            echo json_encode(['message' => 'Post created successfully']);
        } else {
            echo json_encode(['message' => 'Incomplete data provided']);
        }
    } catch (PDOException $e) {
        die("Error: " . $e->getMessage());
    }
} else {
    echo json_encode(['message' => 'Incorrect request method']);
}
