<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: PUT, GET, POST, DELETE, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type");
header("Content-Type: application/json");

include '../include/connect.php';

if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(200);
    exit();
}

// Check if the request method is POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Assuming you receive JSON data from the client-side
    $data = json_decode(file_get_contents("php://input"), true);

    // Extract data from JSON
    $rolesID = $data['RolesID'];
    $username = $data['Username'];
    $passwordHash = $data['PasswordHash'];
    $email = $data['Email'];
    $profilePictureURL = isset($data['ProfilePictureURL']) ? $data['ProfilePictureURL'] : null;
    $location = isset($data['Location']) ? $data['Location'] : null;
    $bio = isset($data['Bio']) ? $data['Bio'] : null;

    try {
        // Your SQL query to insert a new user
        $query = "INSERT INTO users (RolesID, Username, PasswordHash, Email, ProfilePictureURL, Location, Bio) 
                  VALUES (:rolesID, :username, :passwordHash, :email, :profilePictureURL, :location, :bio)";

        // Prepare the SQL statement
        $stmt = $pdo->prepare($query);

        // Bind parameters
        $stmt->bindParam(':rolesID', $rolesID);
        $stmt->bindParam(':username', $username);
        $stmt->bindParam(':passwordHash', $passwordHash);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':profilePictureURL', $profilePictureURL);
        $stmt->bindParam(':location', $location);
        $stmt->bindParam(':bio', $bio);

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