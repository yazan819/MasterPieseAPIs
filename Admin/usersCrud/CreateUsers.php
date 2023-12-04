<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: PUT, GET, POST, DELETE, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type");
header("Content-Type: application/json");
// Include the file with database connection details
include '../include/connect.php';

// Check if the request method is POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Assuming you receive JSON data from the client-side
    $data = json_decode(file_get_contents("php://input"), true);

    // Extract data from JSON
    $username = $data['username'];
    $password = $data['password'];
    $email = $data['email'];
    $rolesID = $data['rolesID']; // Assuming this is received in JSON

    try {
        // Your SQL query to insert a new user
        $query = "INSERT INTO Users (Username, PasswordHash, Email, RolesID) 
                  VALUES (:username, :password, :email, :rolesID)";

        // Prepare the SQL statement
        $stmt = $pdo->prepare($query);

        // Bind parameters
        $stmt->bindParam(':username', $username);
        $stmt->bindParam(':password', $password);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':rolesID', $rolesID);

        // Execute the query
        $stmt->execute();

        // Check if the query was successful
        if ($stmt->rowCount() > 0) {
            // User created successfully
            http_response_code(201); // Set response code to 201 (Created)
            echo json_encode(array("message" => "User created successfully"));
        } else {
            // If the user couldn't be added
            http_response_code(400); // Set response code to 400 (Bad Request)
            echo json_encode(array("message" => "Could not create user"));
        }
    } catch (PDOException $e) {
        http_response_code(500); // Set response code to 500 (Internal Server Error)
        echo json_encode(array("message" => "Error creating user: " . $e->getMessage()));
    }
} else {
    // If the request method is not POST
    http_response_code(405); // Set response code to 405 (Method Not Allowed)
    echo json_encode(array("message" => "Method not allowed"));
}
?>
