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
    <title>Dashboard</title>
    <style>
        body {
            margin: 0;
            font-family: 'Segoe UI', sans-serif;
            background-color: #f4f4f4;
        }

        .sidebar {
            height: 100vh;
            width: 200px;
            position: fixed;
            background-color: #343a40;
            color: white;
            padding-top: 20px;
        }

        .sidebar h2 {
            text-align: center;
            margin-bottom: 30px;
            font-size: 1.4em;
        }

        .sidebar a {
            padding: 12px 20px;
            display: block;
            color: white;
            text-decoration: none;
            transition: 0.3s;
        }

        .sidebar a:hover {
            background-color: #495057;
        }

        .main {
            margin-left: 200px;
            padding: 20px;
        }

        .dashboard-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .welcome-text {
            font-size: 30px;
            font-weight: bold;
        }

        .profile-icon {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            overflow: hidden;
            border: 2px solid #007bff;
            cursor: pointer;
        }

        .profile-icon img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .dashboard-boxes {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(220px, 1fr));
            gap: 20px;
            margin-top: 30px;
        }

        .dashboard-boxes a {
            text-decoration: none;
            color: white;
        }

        .box {
            position: relative;
            overflow: hidden;
            display: flex;
            justify-content: center;
            align-items: center;
            padding: 0;
            height: 150px;
            border-radius: 10px;
            font-size: 1.2em;
            font-weight: bold;
            transition: transform 0.2s ease-in-out;
            text-align: center;
        }

        .box:hover {
            transform: scale(1.05);
            cursor: pointer;
        }

        .box img {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            object-fit: cover;
            opacity: 1;
            z-index: 0;
        }

        .box span {
            position: relative;
            z-index: 1;
        }

        .bottom-right-container {
            position: fixed;
            bottom: 20px;
            right: 20px;
            width: 300px;
            height: 300px;
            background-color: #f4f4f4; /* Match dashboard background */
            border-radius: 10px;
            overflow: hidden;
            box-shadow: 0 4px 12px rgba(0,0,0,0.1); /* Softer shadow */
        }

        .bottom-right-container img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }
    </style>
</head>
<body>

    <div class="sidebar">
        <h2>Library System</h2>
        <a href="category.php">Category</a>
        <a href="author.php">Author</a>
        <a href="book.php">Library</a>
        <a href="addbook.php">Add Book</a>
        <a href="about.php">About</a>
        <a href="#" onclick="delayedLogout(event)">Logout</a>
    </div>

    <div class="main">
        <div class="dashboard-header">
            <div class="welcome-text">
                Welcome, <?php echo htmlspecialchars($_SESSION["username"]); ?>
            </div>
            <a href="profile.php" class="profile-icon" title="View Profile">
                <img src="images/proficon.jpg" alt="Profile">
            </a>
        </div>

        <div class="dashboard-boxes">
            <a href="category.php" class="box bg-blue">
                <img src="images/category.jpg" alt="Category">
                <span>Category</span>
            </a>
            <a href="author.php" class="box bg-green">
                <img src="images/author.jpg" alt="Author">
                <span>Author</span>
            </a>
            <a href="book.php" class="box bg-red">
                <img src="images/book.webp" alt="Library">
                <span>Library</span>
            </a>
            <a href="addbook.php" class="box bg-purple">
                <img src="images/addbook.png" alt="Add Book">
                <span>Add Book</span>
            </a>
            <a href="about.php" class="box bg-yellow">
                <img src="images/about.png" alt="About">
                <span>About</span>
            </a>
        </div>
    </div>

    <div class="bottom-right-container">
        <!-- Replace with your image -->
        <img src="images/bird.gif" alt="Library Icon">
    </div>

    <script>
        function delayedLogout(event) {
            event.preventDefault(); // Prevent immediate navigation
            const confirmLogout = confirm("Are you sure you want to logout?");
            if (confirmLogout) {
                setTimeout(() => {
                    window.location.href = "logout.php";
                }, 1500); // 1.5 second delay
            }
        }
    </script>

</body>
</html>
