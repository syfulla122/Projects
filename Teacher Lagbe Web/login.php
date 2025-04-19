<?php
session_start();

// Database connection details for both databases
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

// Function to check credentials in the specified database
function checkCredentials($email, $password, $dbConfig) {
    $conn = new mysqli($dbConfig['servername'], $dbConfig['username'], $dbConfig['password'], $dbConfig['dbname']);
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $sql = "SELECT * FROM users WHERE email = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    $user = null;
    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();
        if (!password_verify($password, $user['password'])) {
            $user = null;  // Incorrect password
        }
    }

    $stmt->close();
    $conn->close();
    return $user;
}

// Check if login form data is set
if (isset($_POST['emailOrPhone'], $_POST['password']) && !empty($_POST['emailOrPhone']) && !empty($_POST['password'])) {
    $email = trim($_POST['emailOrPhone']);
    $password = trim($_POST['password']);

    // Check in the teacher database
    $user = checkCredentials($email, $password, $teacherDb);
    if (!$user) {
        // If not found in teacher database, check in the student database
        $user = checkCredentials($email, $password, $studentDb);
    }

    if ($user) {
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['user_type'] = $user['user_type'];

        // Store teacher ID if the user is a teacher
        if ($user['user_type'] == 'teacher') {
            $_SESSION['teacher_id'] = $user['teacher_id'];
        }

        // Redirect based on user type
        if ($user['user_type'] == 'student') {
            header('Location: student.html');
        } elseif ($user['user_type'] == 'teacher') {
            header('Location: teacher.html');
        } else {
            echo "Invalid user type";
        }
        exit;
    } else {
        echo "Invalid credentials";
    }
} else {
    echo "All fields are required.";
}
?>