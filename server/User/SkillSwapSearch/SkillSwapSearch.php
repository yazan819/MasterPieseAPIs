<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Allow-Headers: Content-Type");
header("Content-Type: application/json");
include '../include/connect.php';


// {
//     "user_need": "Illustrations",
//     "user_provide": ""
// }



if ($_SERVER["REQUEST_METHOD"] == "POST") {
    try {
        $json_data = file_get_contents('php://input');
        $data = json_decode($json_data, true);

        if (isset($data['I_need'])) {
            $userProvide = '%' . $data['I_need'] . '%';
            
            if (isset($data['I_knew']) && !empty($data['I_knew'])) {
                $userNeed = '%' . $data['I_knew'] . '%';

                $query = "SELECT posts.* , users.Username ,users.ProfilePictureURL AS profile_picture FROM posts JOIN users on users.UserID = posts.UserID WHERE posts.YourProvide LIKE ? AND posts.YourNeed LIKE ?;";
                $stmt = $pdo->prepare($query);
                $stmt->execute([$userProvide, $userNeed]);
                $matchingPosts = $stmt->fetchAll(PDO::FETCH_ASSOC);
            } else {
                $query = "SELECT * FROM posts WHERE YourProvide LIKE ?;";
                $stmt = $pdo->prepare($query);
                $stmt->execute([$userProvide]);
                $matchingPosts = $stmt->fetchAll(PDO::FETCH_ASSOC);
            }

            if ($matchingPosts) {
                echo json_encode($matchingPosts);
            } else {
                echo json_encode(['message' => 'No matching posts found']);
            }
        } else {
            echo json_encode(['message' => 'Incomplete data provided']);
        }
    } catch (PDOException $e) {
        die("Error: " . $e->getMessage());
    }
} else {
    echo json_encode(['message' => 'Incorrect request method']);
}
