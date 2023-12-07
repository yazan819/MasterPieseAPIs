<?php

// // {
// //     "username": "testuser",
// //     "email": "testuser@example.com",
// //     "password": "testpassword"
// // }


// // {
// //     "success": true
// // }


// if the user already exists
// {
//     "error": "User with this email already exists."
// }

header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: PUT, GET, POST, DELETE, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type");
header("Content-Type: application/json");

class Database {
    private $servername = "localhost";
    private $username = "root";
    private $password = "";
    private $dbname = "abodmaster";
    private $conn;

    public function __construct() {
        $this->connect();
    }

    private function connect() {
        $this->conn = new mysqli($this->servername, $this->username, $this->password, $this->dbname);
        if ($this->conn->connect_error) {
            die("Connection failed: " . $this->conn->connect_error);
        }
    }

    public function insertUser($username, $email, $password) {
        $insert_query = "INSERT INTO users (Username, Email, passwordHash) VALUES (?, ?, ?)";
        $stmt = $this->conn->prepare($insert_query);
        $stmt->execute([$username, $email, $password]);
        if ($stmt) {
            return true;
        } else {
            return $stmt->error;
        }
    }

    public function userExists($email) {
        $query = "SELECT COUNT(*) as count FROM users WHERE Email = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param('s', $email);
        $stmt->execute();
        $result = $stmt->get_result();
        $row = $result->fetch_assoc();
        return $row['count'] > 0;
    }

    public function close() {
        $this->conn->close();
    }
}

class UserRegistration {
    private $db;

    public function __construct(Database $db) {
        $this->db = $db;
    }

    public function register() {
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $data = json_decode(file_get_contents('php://input'), true);

            if ($data && isset($data["username"]) && isset($data["email"]) && isset($data["password"])) {
                $username = $data["username"];
                $email = $data["email"];
                $password = $data["password"];

                // Check if user already exists
                if ($this->db->userExists($email)) {
                    $response = array('error' => "User with this email already exists.");
                    echo json_encode($response);
                    return;
                }

                // Proceed with user registration if user doesn't exist
                $result = $this->db->insertUser($username, $email, $password);

                if ($result === true) {
                    $response = array('success' => true);
                    echo json_encode($response);
                } else {
                    $response = array('error' => "Error: " . $result);
                    echo json_encode($response);
                }
            } else {
                $response = array('error' => "Invalid JSON data.");
                echo json_encode($response);
            }
        } else {
            echo "REQUEST_METHOD is not correct please use POST";
        }
    }
}

$db = new Database();
$userRegistration = new UserRegistration($db);
$userRegistration->register();
$db->close();


