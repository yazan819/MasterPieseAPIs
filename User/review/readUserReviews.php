<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: PUT, GET, POST, DELETE, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type");
header("Content-Type: application/json");

include '../include/connect.php';



// read user reviews that made on him 


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Retrieve JSON data from the client
    $json_data = file_get_contents('php://input');
    $data = json_decode($json_data, true);

    // Check if the UserID is provided in the JSON payload
    if (!empty($data['UserID'])) {
        // Fetch reviews for the specific user
        $sql = "SELECT rr.ReviewID, rr.ReviewerID, rr.TargetUserID, rr.Rating, rr.ReviewText, 
                       rr.ReviewDate, reviewer.Username AS ReviewerUsername, target.Username AS TargetUsername
                FROM reviewsratings rr
                INNER JOIN users reviewer ON rr.ReviewerID = reviewer.UserID
                INNER JOIN users target ON rr.TargetUserID = target.UserID
                WHERE rr.TargetUserID = :userID";

        try {
            $stmt = $pdo->prepare($sql);
            $stmt->bindParam(':userID', $data['UserID']);
            $stmt->execute();

            $reviews = $stmt->fetchAll(PDO::FETCH_ASSOC);

            if ($reviews) {
                echo json_encode($reviews);
            } else {
                echo json_encode(array("message" => "No reviews found for this user"));
            }
        } catch (PDOException $e) {
            echo json_encode(array("error" => $e->getMessage()));
        }
    } else {
        echo json_encode(array("message" => "UserID not provided in the request"));
    }
} else {
    echo json_encode(array("message" => "Invalid request method"));
}
?>
