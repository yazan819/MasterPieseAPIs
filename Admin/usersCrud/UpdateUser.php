<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: PUT, GET, POST, DELETE, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type");
header("Content-Type: application/json");
include '../include/connect.php';

if ($_SERVER["REQUEST_METHOD"] == "PUT") {
    try {
        $json_data = file_get_contents('php://input');
        $data = json_decode($json_data, true);

        // Check if the data is not empty and if 'UserID' is provided
        if (!empty($data['UserID'])) {
            $valid_columns = ['RolesID', 'Username', 'PasswordHash', 'Email', 'ProfilePictureURL', 'Location', 'Bio', 'RegistrationDate'];

            $query = "UPDATE Users SET ";
            $params = [];

            foreach ($data as $key => $value) {
                if (in_array($key, $valid_columns)) {
                    $query .= "$key = ?, ";
                    $params[] = $value;
                }
            }

            $query = rtrim($query, ', ');

            $query .= " WHERE UserID = ?;";
            $params[] = $data['UserID'];

            $stmt = $pdo->prepare($query);
            $stmt->execute($params);

            $affectedRows = $stmt->rowCount();

            if ($affectedRows > 0) {
                echo json_encode(['message' => 'Update successful']);
            } else {
                echo json_encode(['message' => 'No matching records found for the provided UserID']);
            }
        } else {
            echo json_encode(['message' => 'No UserID provided for updating']);
        }
    } catch (PDOException $e) {
        die("Error: " . $e->getMessage());
    }
} else {
    echo json_encode(['message' => 'Incorrect request method']);
}
?>