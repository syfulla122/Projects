<?php
session_start();
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Database connection details for each user type
$teacherDb = [
    "servername" => "localhost",
    "username" => "root",
    "password" => "alve",
    "dbname" => "teacher_db"
];

$studentDb = [
    "servername" => "localhost",
    "username" => "root",
    "password" => "alve",
    "dbname" => "student_db"
];

// Determine the database based on user type
if (isset($_POST['email'], $_POST['password'], $_POST['userType']) && 
    !empty($_POST['email']) && !empty($_POST['password']) && !empty($_POST['userType'])) {

    $userType = $_POST['userType'];
    $dbConfig = $userType === 'teacher' ? $teacherDb : $studentDb;
    
    // Establish database connection based on the user type
    $conn = new mysqli($dbConfig['servername'], $dbConfig['username'], $dbConfig['password'], $dbConfig['dbname']);
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }
    
    $email = $conn->real_escape_string(trim($_POST['email']));
    $password = trim($_POST['password']);
    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
    $teacher_id = null;

    if ($userType === 'teacher') {
        $teacher_id = 'T' . rand(100000, 999999);
    }

    $sql = "INSERT INTO users (email, password, user_type, teacher_id) VALUES (?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);

    if ($stmt) {
        $stmt->bind_param("ssss", $email, $hashedPassword, $userType, $teacher_id);
        if ($stmt->execute()) {
            $_SESSION['user_id'] = $conn->insert_id;
            $_SESSION['user_type'] = $userType;
            $_SESSION['teacher_id'] = $teacher_id;
            header('Location: login.html');
            exit;
        } else {
            if ($stmt->errno === 1062) {
                echo "Email address already exists.";
            } else {
                echo "Error: " . $stmt->error;
            }
        }
        $stmt->close();
    } else {
        echo "Error preparing statement: " . $conn->error;
    }
    $conn->close();
} else {
    echo "All fields are required.";
}
?>
