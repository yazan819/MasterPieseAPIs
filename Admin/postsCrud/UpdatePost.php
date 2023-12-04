<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: PUT");
header("Access-Control-Allow-Headers: Content-Type");
header("Content-Type: application/json");
include '../include/connect.php';


// {
//     "PostID": 2,
//     "YourNeed": "Updated Need Description",
//     "YourProvide": "Updated Provide Description",
//     "Description": "Updated post description"
// }


if ($_SERVER["REQUEST_METHOD"] == "PUT") {
    try {
        $json_data = file_get_contents('php://input');
        $data = json_decode($json_data, true);

        if (isset($data['PostID'])) {
            $valid_columns = ['YourNeed', 'YourProvide', 'Description']; // Add all valid columns here

            $query = "UPDATE posts SET ";
            $params = [];

            foreach ($data as $key => $value) {
                if (in_array($key, $valid_columns)) {
                    $query .= "$key = ?, ";
                    $params[] = $value;
                }
            }

            $query = rtrim($query, ', ');
            $query .= " WHERE PostID = ?;";
            $params[] = $data['PostID'];

            $stmt = $pdo->prepare($query);
            $stmt->execute($params);

            $affectedRows = $stmt->rowCount();

            if ($affectedRows > 0) {
                echo json_encode(['message' => 'Post updated successfully']);
            } else {
                echo json_encode(['message' => 'No matching records found for the provided PostID']);
            }
        } else {
            echo json_encode(['message' => 'No PostID provided for updating']);
        }
    } catch (PDOException $e) {
        die("Error: " . $e->getMessage());
    }
} else {
    echo json_encode(['message' => 'Incorrect request method']);
}
?>
