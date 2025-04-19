<?php
// Database connection details
$servername = "localhost";
$username = "root";
$password = "alve";
$main_dbname = "teacher"; // Main teacher database

// Create connection to the main database
$conn = new mysqli($servername, $username, $password, $main_dbname);

// Check if the connection is successful
if ($conn->connect_error) {
    error_log("Connection failed: " . $conn->connect_error);  // Log error
    die(json_encode(["error" => "Connection to main database failed: " . $conn->connect_error]));
}

// Set header for JSON response
header('Content-Type: application/json');

// Get the search query from the GET request
$query = isset($_GET['query']) ? $_GET['query'] : '';

// Debugging: Log the received query to check if it's correct
error_log("Search Query: " . $query);

// If no query is provided, return an empty array
if (empty($query)) {
    echo json_encode([]);
    exit;
}

// Add wildcards for partial matching
$searchTerm = '%' . $query . '%';

// Function to search the `add_teacher` table in a given database
function searchTeachers($servername, $username, $password, $dbname, $searchTerm) {
    $connection = new mysqli($servername, $username, $password, $dbname);

    if ($connection->connect_error) {
        // Return an error for this database but allow the script to continue
        return ["error" => "Connection to $dbname failed: " . $connection->connect_error];
    }

    $sql = "SELECT * FROM add_teacher WHERE teacher_name LIKE ? OR qualification LIKE ? OR experience LIKE ? OR subject LIKE ? OR class LIKE ?";
    $stmt = $connection->prepare($sql);

    if ($stmt === false) {
        $connection->close();
        return ["error" => "Failed to prepare query in $dbname: " . $connection->error];
    }

    $stmt->bind_param("sssss", $searchTerm, $searchTerm, $searchTerm, $searchTerm, $searchTerm);
    $stmt->execute();
    $result = $stmt->get_result();

    $teachers = [];
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $teachers[] = $row;
        }
    }

    $stmt->close();
    $connection->close();

    return $teachers;
}

// Array to store all results
$allTeachers = [];

// Search the main database
$mainResults = searchTeachers($servername, $username, $password, $main_dbname, $searchTerm);
if (!isset($mainResults['error'])) {
    $allTeachers = array_merge($allTeachers, $mainResults);
}

// Return the combined results as a JSON response
echo json_encode($allTeachers);

// Close the main database connection
$conn->close();
?>
