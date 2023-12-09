<?php
// header("Access-Control-Allow-Origin: *");
// header("Access-Control-Allow-Methods: POST, OPTIONS");
// header("Access-Control-Allow-Headers: Content-Type");
// header("Content-Type: application/json");

// include '../include/connect.php';

// // Ensure the request method is POST
// if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
//     http_response_code(405); // Method Not Allowed
//     echo json_encode(array("status" => "error", "message" => "Only POST requests are allowed"));
//     exit;
// }
// $json_data = file_get_contents('php://input');
// $data = json_decode($json_data, true);
// if (isset($data['RequestID'])) {
//     $request_id = $data['RequestID'];
//     $sql = "DELETE FROM skillswaprequests WHERE RequestID = :request_id";
//     $stmt = $pdo->prepare($sql);
//     $stmt->bindParam(':request_id', $request_id, PDO::PARAM_INT);
//     if ($stmt->execute()) {
//         $response = array("status" => "success", "message" => "Friend deleted from swap requests successfully");
//         echo json_encode($response);
//     } else {
//         $errorInfo = $stmt->errorInfo();
//         $response = array("status" => "error", "message" => "Error deleting friend from swap requests: " . $errorInfo[2]);
//         echo json_encode($response);
//     }
// } else {
//     $response = array("status" => "error", "message" => "Missing RequestID in JSON data");
//     echo json_encode($response);
// }



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

        if (isset($data['RequestID'])) {
            $query = "DELETE FROM skillswaprequests WHERE RequestID = ?;";
            $stmt = $pdo->prepare($query);
            $stmt->execute([$data['RequestID']]);

            echo json_encode(['message' => 'Friend deleted successfully']);
        } else {
            echo json_encode(['message' => 'Friend not provided']);
        }
    } catch (PDOException $e) {
        die("Error: " . $e->getMessage());
    }
} else {
    echo json_encode(['message' => 'Incorrect request method']);
}
?>
