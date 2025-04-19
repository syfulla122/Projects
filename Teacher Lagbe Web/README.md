Visit Site - https://syedalveahad.github.io/Teacher_Lagbe_Web

# Teacher Lagbe

Teacher Lagbe is an online platform designed to connect teachers and students. It allows teachers to create profiles, manage their teaching subjects and qualifications, and receive student hire requests. Students can search for teachers based on various criteria and send requests for hiring. The system includes features like user login, teacher/student dashboards, and notifications.

## Features

- Teacher Profile Management: Teachers can see the Teacher ID.
- Student Request: Students can search for teachers and send hire requests.
- Dashboard: Dynamic dashboards are available for teachers and students after login.
- Notifications: Teachers receive notifications for new requests from students.
- Search Functionality: Search for teachers based on name, qualification, experience, and subject.
- Image Upload: Teachers can upload their profile images.

## Table of Contents

1. [Installation Instructions](#installation-instructions)
2. [Usage](#usage)
3. [File Structure](#file-structure)
4. [Technologies Used](#technologies-used)
5. [Contributing](#contributing)
6. [License](#license)

## Installation Instructions

### Prerequisites

Before you begin, ensure that you have met the following requirements:

- **PHP** version 7.4 or above
- **MySQL** for the database
- **Apache** or **Nginx** web server

### Clone the repository

First, clone the repository to your local machine:

git clone https://github.com/syedalveahad/Teacher_Lagbe_Web.git
cd Teacher_Lagbe_We

Set up the Database

Create the Database: Log in to your MySQL/MariaDB server and create a database named teacher:

CREATE DATABASE teacher;

Import Database Schema: You will need to set up the tables for this project. Import the provided teacher.sql (or your own schema if it's different) into the database:

>> mysql -u root -p teacher < teacher.sql

This will create the necessary tables like add_teacher, student_requests, and notifications.

Configure Database Connection:

In config.php, update the database connection settings with your local or production database details.

$servername = "localhost";
$username = "root";
$password = "your-password";
$dbname = "teacher";  // your database name

Install Dependencies:

If you're using PHP with Composer, you may need to run:

>> composer install

Alternatively, for simple projects, this may not be necessary.

## File Structure

Here’s the structure of the project:

>> Teacher_Lagbe_Web
- img                   # Images used in the project
- css                   # Stylesheets
-- home.css
-- style.css
-- login.css
- js                    # JavaScript files
-- script.js
- php                   # PHP files
-- add_teacher.php
-- fetch_teacher.php
-- search_teacher.php
-- login.php
-- logout.php
-- teacher.php
-- student.php
-- config.php
-- home.php
- html                  # HTML files
-- home.html
-- teacher.html
-- student.html
-- index.html             # Landing page for the platform
- README.md              # Project documentation

## Usage:

- Launching the Project
- Start your local server (Apache/Nginx).
- Open your browser and navigate to http://localhost/Teacher_Lagbe_Web/index.html
- Log in as a teacher or student to access the platform.

Admin Instructions:
To test as an admin or teacher, log in using a predefined teacher account, or you can manually insert a teacher into the database.

Adding Teachers:
To add a teacher, go to the Teacher Dashboard after logging in, and fill in the Add Teacher form. You will be able to upload a photo and specify details like qualifications, hourly rate, and experience.

Searching for Teachers:
Use the Search Bar available on the homepage or in the teacher list to search for teachers by name, qualification, experience, or subject.

Notifications:
Teachers will receive notifications when a student sends a hire request. Notifications will be visible in the Notification Dropdown in the teacher dashboard.

Teacher/Student Dashboard:
Teacher Dashboard: Shows the teacher's profile and allows managing student hire requests.
Student Dashboard: Displays student-related information and allows browsing and hiring teachers.

## Technologies Used

- Frontend: HTML, CSS, JavaScript
- Backend: PHP
- Database: MySQL
- Server: Apache/Nginx (for local setup)
- Image Upload: Base64 encoding

## Contributing

We welcome contributions! If you find any bugs or have suggestions for improvements, feel free to fork the repository and make a pull request. Alternatively, open an issue in the GitHub repository.

Steps to contribute:

- Fork the repository.
- Create a new branch (git checkout -b feature-branch).
- Make and commit your changes (git commit -am 'Add feature').
- Push to the branch (git push origin feature-branch).
- Open a pull request.

## License
This project is open-source and available under the MIT License.

-----------------------------------------------------------------

Introduction:

Teacher Lagbe is an online platform designed for students and teachers by providing a simple, user-friendly environment where both can connect effortlessly. Through this site, teachers can create detailed profiles based on their subjects, preferred class, qualifications, and hourly rates. Students can sign up, search for teachers in specific subjects or topic, and hire them for online or offline sessions as needed. Our platform allows flexibility for both parties, enabling students to hire a teacher for a single hour for online or an entire month depending on their requirements for both online and offline, while teachers have the opportunity to earn based on their availability and expertise.

Objective:

Our main objective with Teacher Lagbe is to offer an accessible, flexible, and secure platform for both students and teachers. By enabling online tutoring sessions, students can receive high-quality instruction without having to travel, and teachers can provide their expertise remotely, broadening their reach. This platform is ideal for short-term, targeted tutoring, where students can hire a teacher for as little as one hour for specific topics or challenges, or commit to longer-term arrangements if needed. Students also have the freedom to choose teachers based on qualifications and reviews, ensuring quality and reliability. Teacher Lagbe not only simplifies the tutoring process but also empowers teachers to earn on their terms by making education accessible anytime, anywhere.
