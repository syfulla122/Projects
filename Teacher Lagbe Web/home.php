<?php
session_start(); // Ensure session is started

// Check if the user is logged in and retrieve their role from the session
$user_role = isset($_SESSION['user_role']) ? $_SESSION['user_role'] : null;

// Redirect to the appropriate dashboard page if the 'dashboard' GET parameter is set
if (isset($_GET['dashboard'])) {
    if ($user_role == 'teacher') {
        header('Location: teacher.html');
        exit;
    } elseif ($user_role == 'student') {
        header('Location: student.html');
        exit;
    } else {
        // If no role is set, redirect to login or show an error
        header('Location: login.php');
        exit;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Teacher Lagbe</title>
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="home.css">
</head>
<body>
<header>
    <div class="logo">
        <h1>Teacher Lagbe</h1>
    </div>
    <nav>
        <ul id="menu">
            <li><a href="home.php">Home</a></li>
            <li><a href="#">About Us</a></li>
            <li><a href="#">Contact Us</a></li>
            <li><a href="student.html">Dashboard</a></li>
        
        </ul>
    </nav>
    <div id="teacherInfo">
        <!-- Display Teacher ID only for teachers -->
        <button class="logout-btn" onclick="window.location.href='logout.php'">Logout</button>
    </div>
</header>

<!-- Hero Section -->
<div class="containerslide">
    <div class="slider">
        <img src="img/teacher3.svg" alt="Image 3">
    </div>
    <div class="text-content">
        <h1>Join Our Platform</h1>
        <p>Become part of our growing community. Learn, grow, and achieve your goals with our platform.</p>
        <div class="buttons">
            <!-- Buttons for teachers and students -->
            <a href="teacher.html" class="signup-btn">Sign up for Student</a>
            <a href="teacher.html" class="learn-more-btn">Sign up for Teacher</a>
        </div>
    </div>
</div>

<section class="categories">
    <div class="container">
        <h2>Subjects</h2>
        <div class="buttons">
            <button>AI</button>
            <button>Machine Learning</button>
            <button>Statistics</button>
            <button>System Analysis</button>
            <button>Math</button>
            <button>Bangla</button>
            <button>Physics</button>
            <button>Chemistry</button>
            <button>English</button>
            <button>Ethics</button>
        </div>
    </div>
</section>

<div class="content">
    <div class="search-container">
        <input type="text" id="searchBar"
            placeholder="Search for a Teacher by Name, Qualification, or Experience...">
        <button onclick="searchTeacher()">Search</button>
    </div>

    <div class="teacher-list" id="teacherList">
    </div>

</div>

<footer>
    <p>&copy; Teacher Lagbe 2024</p>
</footer>

<script src="script.js"></script>


</body>
</html>
