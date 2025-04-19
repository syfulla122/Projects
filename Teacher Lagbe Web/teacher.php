<?php
session_start();

$response = [
    'teacherName' => $_SESSION['user_name'] ?? 'Teacher',
    'teacherId' => $_SESSION['teacher_id'] ?? '' // Include teacher ID
];

$servername = "localhost";
$username = "root";
$password = "alve";
$dbname = "teacher"; // Main database

header('Content-Type: application/json');

if (!isset($_SESSION['user_type']) || $_SESSION['user_type'] !== 'teacher') {
    http_response_code(401);
    echo json_encode(['error' => 'Unauthorized']);
    exit;
}

$response = [
    'teacherName' => $_SESSION['user_name'] ?? 'Teacher',
    'teacherId' => $_SESSION['teacher_id'] ?? ''
];
echo json_encode($response);
?>
