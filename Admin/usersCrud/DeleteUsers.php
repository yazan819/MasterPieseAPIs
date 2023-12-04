<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: PUT, GET, POST, DELETE, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type");
header("Content-Type: application/json");
// Include the file with database connection details
include '../include/connect.php';

// Check if the request method is DELETE
if ($_SERVER['REQUEST_METHOD'] === 'DELETE') {
    // Assuming you receive JSON data from the client-side
    $data = json_decode(file_get_contents("php://input"), true);

    // Extract data from JSON
    $userID = $data['userID']; // UserID of the user to be deleted

    try {
        // Your SQL query to delete a user
        $query = "DELETE FROM Users WHERE UserID = :userID";

        // Prepare the SQL statement
        $stmt = $pdo->prepare($query);

        // Bind parameters
        $stmt->bindParam(':userID', $userID);

        // Execute the query
        $stmt->execute();

        // Check if the query was successful
        if ($stmt->rowCount() > 0) {
            // User deleted successfully
            http_response_code(200); // Set response code to 200 (OK)
            echo json_encode(array("message" => "User deleted successfully"));
        } else {
            // If the user couldn't be deleted (probably UserID doesn't exist)
            http_response_code(404); // Set response code to 404 (Not Found)
            echo json_encode(array("message" => "User not found or could not be deleted"));
        }
    } catch (PDOException $e) {
        // Error handling if the query fails
        http_response_code(500); // Set response code to 500 (Internal Server Error)
        echo json_encode(array("message" => "Error deleting user: " . $e->getMessage()));
    }
} else {
    // If the request method is not DELETE
    http_response_code(405); // Set response code to 405 (Method Not Allowed)
    echo json_encode(array("message" => "Method not allowed"));
}
?>
