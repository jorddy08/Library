<?php
session_start();

$conn = new mysqli("localhost", "root", "", "lms");

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$success = false;
     
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = trim($_POST["username"]);
    $password = $_POST["password"];

    $stmt = $conn->prepare("SELECT password FROM account WHERE username = ?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows > 0) {
        $stmt->bind_result($hashed_password);
        $stmt->fetch();

        if (password_verify($password, $hashed_password)) {
            $_SESSION["username"] = $username;
            $success = true;
        } else {
            $error = "Invalid password!";
        }
    } else {
        $error = "No such user!";
    }

    $stmt->close();
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Library Login</title>
    <style>
        body {
            margin: 0;
            font-family: 'Segoe UI', sans-serif;
            background: url('images/library.jpg') no-repeat center center fixed;
            background-size: cover;
            height: 100vh;
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 0 50px;
            color: white;
            position: relative;
        }

        .success-message, .error-message {
            padding: 15px 20px;
            width: 100%;
            /* Removed max-width so it fits container */
            margin-top: 15px;
            text-align: center;
            font-weight: bold;
            border-radius: 5px;
            box-sizing: border-box;
        }

        .success-message {
            background-color: #28a745;
            color: white;
        }

        .error-message {
            background-color: #dc3545;
            color: white;
        }

        .left-text {
            position: absolute;
            top: 5%;
            left: 50px;
            max-width: 40%;
            text-align: left;
        }

        .left-text h1 {
            font-size: 3em;
            margin-bottom: 10px;
        }

        .left-text p {
            font-size: 1.2em;
        }

        .login-container {
            background: rgba(72, 77, 96, 0.7);
            padding: 40px;
            border-radius: 10px;
            width: 300px;
            color: #fff;
            margin-left: auto;
        }

        .login-container h2 {
            margin-bottom: 20px;
            text-align: center;
        }

        .login-container input[type="text"],
        .login-container input[type="password"] {
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

        .toggle-password {
            position: absolute;
            right: 10px;
            top: 50%;
            transform: translateY(-50%);
            cursor: pointer;
            color: white;
            font-size: 18px;
            user-select: none;
        }

        .login-container button {
            width: 100%;
            padding: 10px;
            background: #007BFF;
            color: white;
            border: none;
            margin-top: 20px;
            cursor: pointer;
            border-radius: 4px;
            font-weight: bold;
        }

        .login-container button:hover {
            background: #0056b3;
        }

        .login-container .signup {
            margin-top: 15px;
            text-align: center;
        }

        .login-container .signup a {
            color: #00aaff;
            text-decoration: none;
        }
    </style>
</head>
<body>

    <div class="left-text">
        <h1>Welcome to the Library System</h1>
        <p>Log in to continue...</p>
    </div>

    <div class="login-container">
        <h2>Log in</h2>

        <form method="post" action="">
            <input type="text" name="username" placeholder="Username" required>

            <div class="password-wrapper">
                <input type="password" name="password" id="password" placeholder="Password" required>
                <span class="toggle-password" onclick="togglePassword()">👁️</span>
            </div>

            <button type="submit">Log in »</button>
        </form>

        <div class="signup">
            Don’t have an account? <a href="register.php">Sign up now</a>
        </div>

        <?php if ($success): ?>
            <div class="success-message">
                Login successful! Redirecting to dashboard...
            </div>
            <script>
                setTimeout(function () {
                    window.location.href = 'dashboard.php';
                }, 3000);
            </script>
        <?php elseif (isset($error)): ?>
            <div class="error-message"><?php echo htmlspecialchars($error); ?></div>
        <?php endif; ?>
    </div>

    <script>
        function togglePassword() {
            const passwordField = document.getElementById("password");
            passwordField.type = passwordField.type === "password" ? "text" : "password";
        }
    </script>
</body>
</html>
