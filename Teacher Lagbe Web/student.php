<?php
session_start();

// Database connection
$servername = "localhost";
$username = "root";
$password = "alve";
$dbname = "teacher";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Process form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $teacherId = $_POST['teacher_id'];
    $teacherName = $_POST['teacher_name'];
    $studentName = $_POST['student_name'];
    $studentPhone = $_POST['student_phone'];
    $message = isset($_POST['message']) ? $_POST['message'] : '';

    // Validate input
    if (empty($teacherId) || empty($teacherName) || empty($studentName) || empty($studentPhone)) {
        echo "<script>
                alert('Please fill in all required fields.');
                window.location.href='student.html';
              </script>";
        exit;
    }

    // Insert into student_requests table
    $sql = "INSERT INTO student_requests (teacher_id, teacher_name, student_name, student_phone, message) 
            VALUES (?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    
    if (!$stmt) {
        echo "<script>
                alert('Error preparing statement: " . $conn->error . "');
                window.location.href='student.html';
              </script>";
        exit;
    }

    // Bind parameters for student request
    $stmt->bind_param("sssss", $teacherId, $teacherName, $studentName, $studentPhone, $message);

    // Execute the student request insertion
    if ($stmt->execute()) {
        // Prepare the notification message
        $notificationMessage = "You have a new hire request from $studentName for the subject $message. Contact them at $studentPhone.";
        
        // Insert into notifications table
        $notifSql = "INSERT INTO notifications (student_name, student_phone, message, teacher_name, teacher_id) 
                     VALUES (?, ?, ?, ?, ?)";
        $notifStmt = $conn->prepare($notifSql);
        
        if ($notifStmt) {
            // Bind parameters for the notification
            $notifStmt->bind_param("sssss", $studentName, $studentPhone, $notificationMessage, $teacherName, $teacherId);
            $notifStmt->execute();
            $notifStmt->close();
        }

        // Success message
        echo "<script>
                alert('Hire request submitted successfully!');
                window.location.href='student.html';
              </script>";
    } else {
        echo "<script>
                alert('Error: " . $stmt->error . "');
                window.location.href='student.html';
              </script>";
    }

    $stmt->close();
}

$conn->close();
?>
