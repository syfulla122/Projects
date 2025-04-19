<?php
session_start();
$servername = "localhost";
$username = "root";
$password = "alve";
$dbname = "teacher";

// Check if the user is logged in and is a teacher
if (isset($_SESSION['user_id'])) {
    $user_id = $_SESSION['user_id'];

    // Fetch the teacher_id from the users table based on user_id
    $sql = "SELECT teacher_id FROM users WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $user_id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        echo json_encode(['teacher_id' => $row['teacher_id']]);
    } else {
        http_response_code(404);
        echo json_encode(['error' => 'Teacher ID not found']);
    }
    $stmt->close();
    $conn->close();
} else {
    http_response_code(401);
    echo json_encode(['error' => 'Unauthorized']);
}
?>
