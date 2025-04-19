<?php
session_start();

// Database credentials
$servername = "localhost";
$username = "root";
$password = "alve";

// Main database
$main_dbname = "teacher";

// Process the form submission
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Get data from the form
    $teacher_id = isset($_POST['teacher_id']) ? $_POST['teacher_id'] : uniqid("TCHR-");
    $teacher_name = isset($_POST['teacher_name']) ? $_POST['teacher_name'] : null;
    $qualification = isset($_POST['qualification']) ? $_POST['qualification'] : null;
    $hourly_rate = isset($_POST['hourly_rate']) ? $_POST['hourly_rate'] : null;
    $experience = isset($_POST['experience']) ? $_POST['experience'] : null;
    $subject = isset($_POST['subject']) ? strtolower(str_replace(' ', '_', $_POST['subject'])) : null;
    $class = isset($_POST['class']) ? $_POST['class'] : null;

    // Check for missing fields (excluding experience if it's 0)
    $missing_fields = [];
    if (!$teacher_name) $missing_fields[] = "Teacher Name";
    if (!$qualification) $missing_fields[] = "Qualification";
    if (!$hourly_rate) $missing_fields[] = "Hourly Rate";
    if ($experience === null) $missing_fields[] = "Experience"; // Allow 0 as valid
    if (!$subject) $missing_fields[] = "Subject";
    if (!$class) $missing_fields[] = "Class";

    // If any field is missing, show an error message in a pop-up and stop execution
    if (count($missing_fields) > 0) {
        $missing_fields_str = implode(", ", $missing_fields);
        echo "<script>
                alert('Please fill in the following fields: $missing_fields_str');
                window.location.href = 'teacher.html'; // Redirect to the teacher form page
              </script>";
        exit; // Stop further processing
    }

    // Handle image upload (if applicable)
    $imagePath = null;
    if (isset($_FILES['teacher_image']) && $_FILES['teacher_image']['error'] === UPLOAD_ERR_OK) {
        $imageTmpName = $_FILES['teacher_image']['tmp_name'];
        $imageName = uniqid() . '-' . basename($_FILES['teacher_image']['name']); // Generate a unique filename
        $imagePath = 'uploads/' . $imageName;

        // Ensure the uploads directory exists
        if (!is_dir('uploads')) {
            mkdir('uploads', 0777, true);
        }

        if (!move_uploaded_file($imageTmpName, $imagePath)) {
            die("Failed to upload image.");
        }
    }

    // Connect to the main database
    $conn = new mysqli($servername, $username, $password, $main_dbname);
    if ($conn->connect_error) {
        die("Connection to main database failed: " . $conn->connect_error);
    }

    // Insert data into the main database
    $sql = "INSERT INTO add_teacher (teacher_id, teacher_name, qualification, hourly_rate, experience, subject, class, image_path)
            VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    if ($stmt === false) {
        die("Error preparing query for main database: " . $conn->error);
    }
    $stmt->bind_param("sssissss", $teacher_id, $teacher_name, $qualification, $hourly_rate, $experience, $subject, $class, $imagePath);

    if ($stmt->execute()) {
        // Connect to the subject-specific database
        $subject_dbname = $subject; // e.g., "math", "science"
        $subject_conn = new mysqli($servername, $username, $password, $subject_dbname);

        if ($subject_conn->connect_error) {
            die("Connection to subject-specific database failed: " . $subject_conn->connect_error);
        }

        // Insert data into the subject-specific database
        $subject_sql = "INSERT INTO add_teacher (teacher_id, teacher_name, qualification, hourly_rate, experience, subject, class, image_path)
                        VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
        $subject_stmt = $subject_conn->prepare($subject_sql);
        if ($subject_stmt === false) {
            die("Error preparing query for subject database: " . $subject_conn->error);
        }

        $subject_stmt->bind_param("sssissss", $teacher_id, $teacher_name, $qualification, $hourly_rate, $experience, $subject, $class, $imagePath);

        if ($subject_stmt->execute()) {
            // JavaScript to show pop-up notification and redirect
            echo "<script>
                    alert('Teacher added successfully !');
                    window.location.href = 'teacher.html'; // Redirect to teacher.html
                  </script>";
        } else {
            echo "Error inserting into subject database: " . $subject_stmt->error;
        }

        // Close connections
        $subject_stmt->close();
        $subject_conn->close();
    } else {
        echo "Error inserting into main database: " . $stmt->error;
    }

    // Close the main database connection
    $stmt->close();
    $conn->close();
} else {
    echo "Invalid request method.";
}
?>
