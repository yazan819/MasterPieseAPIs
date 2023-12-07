<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: PUT, GET, POST, DELETE, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type");
header("Content-Type: application/json");

include '../include/connect.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $data = json_decode(file_get_contents('php://input'), true);

    if (isset($data['ReviewID'])) {
        $sql = "DELETE FROM reviewsratings WHERE ReviewID = :review_id";

        try {
            $stmt = $pdo->prepare($sql);
            $stmt->bindParam(':review_id', $data['ReviewID']);
            $stmt->execute();

            echo json_encode(array("message" => "Review deleted successfully"));
        } catch (PDOException $e) {
            echo json_encode(array("error" => $e->getMessage()));
        }
    } else {
        echo json_encode(array("error" => "ReviewID not provided"));
    }
} else {
    echo json_encode(array("error" => "Invalid request method"));
}