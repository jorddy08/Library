<?php
session_start();

if (!isset($_SESSION["username"])) {
    header("Location: login.php");
    exit();
}

require 'database.php';

$username = $_SESSION["username"];

$stmt = $conn->prepare("SELECT email, first_name, last_name, middle_initial FROM account WHERE username = ?");
$stmt->bind_param("s", $username);
$stmt->execute();
$stmt->bind_result($email, $first_name, $last_name, $middle_initial);
$stmt->fetch();
$stmt->close();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Profile - <?php echo htmlspecialchars($username); ?></title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600&display=swap" rel="stylesheet">
    <style>
        * {
            box-sizing: border-box;
        }

        body {
            margin: 0;
            font-family: 'Inter', sans-serif;
            background: #e8f5e9; /* soft green */
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            padding: 20px;
            position: relative;
        }

        .back-link {
            position: absolute;
            top: 20px;
            left: 20px;
            color: #2e7d32;
            font-weight: 600;
            text-decoration: none;
            font-size: 0.95em;
            background: #ffffff;
            padding: 8px 14px;
            border-radius: 6px;
            box-shadow: 0 2px 6px rgba(0, 0, 0, 0.06);
            transition: background 0.2s ease, color 0.2s ease;
        }

        .back-link:hover {
            background: #c8e6c9;
            color: #1b5e20;
        }

        .card {
            background: #e3f2fd; /* light blue */
            border-radius: 16px;
            padding: 40px;
            max-width: 550px;
            width: 100%;
            box-shadow: 0 15px 40px rgba(0, 0, 0, 0.08);
        }

        .card h1 {
            text-align: center;
            margin-bottom: 30px;
            font-size: 1.8em;
            color: #2e2e2e;
        }

        .profile-item {
            margin-bottom: 20px;
        }

        .profile-label {
            font-size: 0.95em;
            font-weight: 600;
            color: #1565c0;
            margin-bottom: 6px;
        }

        .profile-value {
            font-size: 1.1em;
            font-weight: 500;
            color: #2e2e2e;
            padding: 12px 16px;
            background: #ffffff;
            border-left: 5px solid #90caf9;
            border-radius: 8px;
        }

        @media (max-width: 600px) {
            .card {
                padding: 25px;
            }
        }
    </style>
</head>
<body>

<a href="dashboard.php" class="back-link">&larr; Return to Dashboard</a>

<div class="card">
    <h1>Profile Overview</h1>

    <div class="profile-item">
        <div class="profile-label">Username</div>
        <div class="profile-value"><?php echo htmlspecialchars($username); ?></div>
    </div>

    <div class="profile-item">
        <div class="profile-label">Email</div>
        <div class="profile-value"><?php echo htmlspecialchars($email); ?></div>
    </div>

    <div class="profile-item">
        <div class="profile-label">First Name</div>
        <div class="profile-value"><?php echo htmlspecialchars($first_name); ?></div>
    </div>

    <div class="profile-item">
        <div class="profile-label">Last Name</div>
        <div class="profile-value"><?php echo htmlspecialchars($last_name); ?></div>
    </div>

    <div class="profile-item">
        <div class="profile-label">Middle Initial</div>
        <div class="profile-value"><?php echo htmlspecialchars($middle_initial ?: '-'); ?></div>
    </div>
</div>

</body>
</html>
