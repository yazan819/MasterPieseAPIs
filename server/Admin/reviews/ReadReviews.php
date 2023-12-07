<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: PUT, GET, POST, DELETE, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type");
header("Content-Type: application/json");

include '../include/connect.php';

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    $sql = "SELECT rr.ReviewID, rr.ReviewerID, rr.TargetUserID, rr.Rating, rr.ReviewText, 
                   rr.ReviewDate, reviewer.Username AS ReviewerUsername, target.Username AS TargetUsername
            FROM reviewsratings rr
            INNER JOIN users reviewer ON rr.ReviewerID = reviewer.UserID
            INNER JOIN users target ON rr.TargetUserID = target.UserID";

    try {
        $stmt = $pdo->prepare($sql);
        $stmt->execute();

        $reviews = $stmt->fetchAll(PDO::FETCH_ASSOC);

        if ($reviews) {
            echo json_encode($reviews);
        } else {
            echo json_encode(array("message" => "No reviews found"));
        }
    } catch (PDOException $e) {
        echo json_encode(array("error" => $e->getMessage()));
    }
} else {
    echo json_encode(array("message" => "Invalid request method"));
}

