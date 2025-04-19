<?php
// Database connection
$host = "localhost";
$user = "root";
$password = "alve";
$dbname = "teacher";

$conn = new mysqli($host, $user, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Get form data
$teacher_id = $_POST['teacher_id'];
$student_name = $_POST['student_name'];
$message = $_POST['message'];

// Insert request into the student_requests table
$sql = "INSERT INTO student_requests (teacher_id, student_name, message) 
        VALUES ('$teacher_id', '$student_name', '$message')";
if ($conn->query($sql) === TRUE) {
    // Optional: Insert notification into the notifications table
    $notification = "New request from $student_name: $message";
    $sql_notification = "INSERT INTO notifications (teacher_id, content) 
                         VALUES ('$teacher_id', '$notification')";
    $conn->query($sql_notification);

    echo "Request sent successfully!";
} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}

$conn->close();
?>