<?php
session_start();
if (!isset($_SESSION["username"])) {
    header("Location: login.php");
    exit();
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>About - Library Management System</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #1e1e2f;
            color: #ffffff;
            margin: 0;
            padding: 40px;
        }

        .container {
            max-width: 800px;
            margin: auto;
            background-color: #2c2c3c;
            padding: 30px;
            border-radius: 12px;
            box-shadow: 0 0 10px rgba(0,0,0,0.5);
        }

        h1 {
            text-align: center;
            margin-bottom: 25px;
            color: #10f425;
        }

        h2 {
            color: #8e44ad;
            margin-top: 30px;
        }

        p, ul {
            line-height: 1.7;
        }

        ul {
            padding-left: 20px;
        }

        .back-button {
            display: inline-block;
            margin-bottom: 25px;
            background-color: rgb(10, 244, 37);
            color: white;
            padding: 10px 18px;
            text-decoration: none;
            border-radius: 6px;
            font-weight: bold;
            transition: background-color 0.3s ease;
        }

        .back-button:hover {
            background-color: rgb(8, 243, 55);
        }
    </style>
</head>
<body>

<div class="container">
    <a href="dashboard.php" class="back-button">← Back to Dashboard</a>

    <h1>About the Library Management System</h1>

    <p>
        The <strong>Library Management System (LMS)</strong> is a web-based application designed to streamline and simplify the process of managing a library. It offers essential features for both librarians and members, making it easier to catalog books, manage user sessions, track borrowing records, and display books with images and details.
    </p>

    <h2>Key Features</h2>
    <ul>
        <li>User authentication and session management</li>
        <li>Add, update, and delete books</li>
        <li>Upload and display book cover images</li>
        <li>Book carousel with interactive popups</li>
        <li>Category and location tracking for books</li>
        <li>Responsive and dark-themed user interface</li>
    </ul>

    <h2>Technologies Used</h2>
    <ul>
        <li><strong>PHP</strong> – Server-side scripting</li>
        <li><strong>MySQL</strong> – Relational database management</li>
        <li><strong>HTML5/CSS3</strong> – Frontend layout and styling</li>
        <li><strong>JavaScript</strong> – Dynamic interactions (e.g., book carousel)</li>
    </ul>

    <h2>Purpose</h2>
    <p>
        This system helps libraries manage their inventory and improves access for readers. It can be customized for schools, colleges, or public libraries looking to digitize their catalog and operations.
    </p>

    <h2>Developer Note</h2>
    <p>
        This project was developed to demonstrate core concepts of web development, database integration, and UI/UX best practices. It can be extended with features like user roles, book reservations, overdue reminders, and analytics.
    </p>
</div>

</body>
</html>
