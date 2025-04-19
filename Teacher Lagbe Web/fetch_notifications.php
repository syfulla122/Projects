<?php
session_start();

$teacherId = $_GET['teacher_id']; // Assuming teacher_id is passed as a query parameter

// Database connection
$servername = "localhost";
$username = "root";
$password = "alve";
$dbname = "teacher";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Debugging: Check if the teacher_id is received correctly
error_log("Fetching notifications for Teacher ID: " . $teacherId);

// Fetch notifications for the teacher
$sql = "SELECT * FROM notifications WHERE teacher_id = ? AND is_read = 0 ORDER BY created_at DESC";
$stmt = $conn->prepare($sql);

if (!$stmt) {
    error_log("SQL error: " . $conn->error);  // Log the error if the query fails to prepare
    echo json_encode(["error" => "Failed to prepare the SQL query"]);
    exit;
}

$stmt->bind_param("s", $teacherId); // Bind teacher_id as a string
$stmt->execute();
$result = $stmt->get_result();

$notifications = [];
while ($row = $result->fetch_assoc()) {
    $notifications[] = $row;
}

$stmt->close();
$conn->close();

// Debugging: Log the fetched notifications
error_log("Fetched notifications: " . json_encode($notifications));

// Return notifications as JSON
echo json_encode($notifications);
?>
