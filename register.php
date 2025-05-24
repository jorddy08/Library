<?php
require 'database.php';

$message = '';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = trim($_POST["email"]);
    $username = trim($_POST["username"]);
    $password = $_POST["password"];
    $confirm_password = $_POST["confirm_password"];
    $first_name = trim($_POST["first_name"]);
    $last_name = trim($_POST["last_name"]);
    $middle_initial = trim($_POST["middle_initial"]);

    // Basic validation for required fields
    if (empty($email) || empty($username) || empty($password) || empty($confirm_password) || empty($first_name) || empty($last_name)) {
        $message = "<span style='color: red;'>❌ Please fill in all required fields.</span>";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $message = "<span style='color: red;'>❌ Invalid email format.</span>";
    } elseif ($password !== $confirm_password) {
        $message = "<span style='color: red;'>❌ Passwords do not match.</span>";
    } else {
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);

        // Insert statement now includes first_name, last_name, middle_initial, email
        $stmt = $conn->prepare("INSERT INTO account (email, username, password, first_name, last_name, middle_initial) VALUES (?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("ssssss", $email, $username, $hashed_password, $first_name, $last_name, $middle_initial);

        if ($stmt->execute()) {
            $message = "<span style='color: #28a745;'>✅ Registration successful. <a href='login.php' style='color:#00aaff;'>Login here</a>.</span>";
        } else {
            $message = "<span style='color: red;'>❌ Error: " . htmlspecialchars($stmt->error) . "</span>";
        }

        $stmt->close();
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Register</title>
    <style>
        body {
            margin: 0;
            font-family: 'Segoe UI', sans-serif;
            background: url('images/Registration.jpg') no-repeat center center fixed;
            background-size: cover;
            display: flex;
            height: 100vh;
            align-items: center;
            justify-content: center;
            color: white;
        }

        .register-container {
            background: rgba(0, 0, 0, 0.75);
            padding: 40px;
            border-radius: 10px;
            width: 320px;
            box-shadow: 0 0 15px rgba(0,0,0,0.6);
            text-align: center;
        }

        .register-container h2 {
            margin-bottom: 20px;
            color: #fff;
        }

        .register-container input[type="text"],
        .register-container input[type="password"],
        .register-container input[type="email"] {
            width: 100%;
            padding: 10px;
            margin-top: 10px;
            border: none;
            border-bottom: 1px solid #ccc;
            background: transparent;
            color: white;
        }

        .password-wrapper {
            position: relative;
        }

        .toggle-visibility {
            position: absolute;
            right: 10px;
            top: 50%;
            transform: translateY(-50%);
            cursor: pointer;
            color: #ccc;
        }

        .name-row {
            display: flex;
            gap: 10px;
            justify-content: space-between;
        }

        .name-row input[type="text"] {
            flex: 1;
        }

        .name-row input[type="text"]:nth-child(3) {
            flex: 0.5;
        }

        .register-container button {
            width: 100%;
            padding: 10px;
            background: #28a745;
            color: white;
            border: none;
            margin-top: 20px;
            cursor: pointer;
            border-radius: 4px;
            font-weight: bold;
        }

        .register-container button:hover {
            background: #218838;
        }

        .register-container .login-link {
            margin-top: 15px;
            display: block;
            color: #00aaff;
            text-decoration: none;
        }

        .notification {
            margin-bottom: 15px;
            font-size: 0.95em;
            transition: opacity 0.5s ease;
        }
    </style>
</head>
<body>
    <div class="register-container">
        <?php if (!empty($message)) : ?>
            <div class="notification" id="notification"><?php echo $message; ?></div>
        <?php endif; ?>

        <h2>Register</h2>

        <form method="post" action="">
            <input type="email" name="email" placeholder="Email" required>
            <input type="text" name="username" placeholder="Username" required>

            <div class="name-row">
                <input type="text" name="last_name" placeholder="Last Name" required>
                <input type="text" name="first_name" placeholder="First Name" required>
                <input type="text" name="middle_initial" placeholder="Middle Initial (optional)" maxlength="1">
            </div>

            <div class="password-wrapper">
                <input type="password" name="password" id="password" placeholder="Password" required>
                <span class="toggle-visibility" onclick="toggleVisibility('password')">👁️</span>
            </div>

            <div class="password-wrapper">
                <input type="password" name="confirm_password" id="confirm_password" placeholder="Confirm Password" required>
                <span class="toggle-visibility" onclick="toggleVisibility('confirm_password')">👁️</span>
            </div>

            <button type="submit">Register</button>
        </form>

        <a class="login-link" href="login.php">Already have an account? Login</a>
    </div>

    <script>
        function toggleVisibility(fieldId) {
            const field = document.getElementById(fieldId);
            field.type = field.type === 'password' ? 'text' : 'password';
        }

        // Hide notification after 3 seconds
        window.onload = function() {
            const notif = document.getElementById('notification');
            if (notif) {
                setTimeout(() => {
                    notif.style.opacity = '0';
                    setTimeout(() => notif.remove(), 500);
                }, 3000);
            }
        }
    </script>
</body>
</html>
