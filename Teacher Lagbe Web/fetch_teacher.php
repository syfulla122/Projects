<?php
$servername = "localhost";
$username = "root";
$password = "alve";
$dbname = "teacher";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Query to fetch all teachers
$sql = "SELECT * FROM add_teacher"; // Ensure your table and column names are correct
$result = $conn->query($sql);

// Check if any records exist
$teachers = array();
if ($result->num_rows > 0) {
    // Output data for each teacher
    while ($row = $result->fetch_assoc()) {
        $teachers[] = [
            'teacher_id' => $row['teacher_id'],  // Include teacher_id
            'name' => $row['teacher_name'],  // Ensure the correct column name here
            'qualification' => $row['qualification'], // Adjust according to your DB
            'hourly_rate' => $row['hourly_rate'], // Adjust according to your DB
            'experience' => $row['experience'], // Adjust according to your DB
            'subject' => $row['subject'], // Adjust according to your DB
            'class' => $row['class'] // Adjust according to your DB
        ];
    }
} else {
    echo json_encode(["error" => "No teachers found"]);
    exit;
}

// Return the data as JSON
echo json_encode($teachers);

$conn->close();
?>
