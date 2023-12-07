<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: PUT, GET, POST, DELETE, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type");
header("Content-Type: application/json");
// Include the file with database connection details
include '../include/connect.php';


if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(200);
    exit();
}

// Check if the request method is GET
if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    try {
        // Your SQL query to retrieve all users
        $query = "SELECT * FROM Users";

        // Prepare the SQL statement
        $stmt = $pdo->query($query);

        // Fetch all users as an associative array
        $users = $stmt->fetchAll(PDO::FETCH_ASSOC);

        // Check if users exist
        if ($users) {
            // Users found
            http_response_code(200); // Set response code to 200 (OK)
            echo json_encode($users);
        } else {
            // If no users found
            http_response_code(404); // Set response code to 404 (Not Found)
            echo json_encode(array("message" => "No users found"));
        }
    } catch (PDOException $e) {
        // Error handling if the query fails
        http_response_code(500); // Set response code to 500 (Internal Server Error)
        echo json_encode(array("message" => "Error fetching users: " . $e->getMessage()));
    }
} else {
    // If the request method is not GET
    http_response_code(405); // Set response code to 405 (Method Not Allowed)
    echo json_encode(array("message" => "Method not allowed"));
}
?>
