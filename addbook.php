<?php
session_start();
if (!isset($_SESSION["username"])) {
    header("Location: login.php");
    exit();
}

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "lms";

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$error = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $title = trim($_POST['title']);
    $author = trim($_POST['author']);
    $location = trim($_POST['location']);
    $description = trim($_POST['description']);
    $category_id = trim($_POST['category_id']);
    $imageFileName = null;

    if (isset($_FILES['image']) && $_FILES['image']['error'] == 0) {
        $allowed = ['jpg', 'jpeg', 'png', 'gif'];
        $fileName = $_FILES['image']['name'];
        $fileTmp = $_FILES['image']['tmp_name'];
        $fileExt = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));

        if (in_array($fileExt, $allowed)) {
            $imageFileName = uniqid() . '.' . $fileExt;
            if (!is_dir('uploads')) {
                mkdir('uploads', 0755);
            }
            move_uploaded_file($fileTmp, 'uploads/' . $imageFileName);
        } else {
            $error = "Only JPG, JPEG, PNG, and GIF files are allowed.";
        }
    }

    if (!$error && $title && $author && $location) {
        $stmt = $conn->prepare("INSERT INTO book (title, author, location, description, image, category_id) VALUES (?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("ssssss", $title, $author, $location, $description, $imageFileName, $category_id);
        $stmt->execute();
        $stmt->close();
        header("Location: book.php");
        exit();
    } elseif (!$error) {
        $error = "Please fill in all required fields.";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Add Book</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #1e1e2f;
            color: white;
            margin: 0;
            padding: 40px;
        }

        .form-container {
            max-width: 700px;
            margin: 0 auto;
            background-color: #2c2c3c;
            padding: 30px;
            border-radius: 12px;
            box-shadow: 0 0 10px rgba(0,0,0,0.5);
        }

        .form-container h2 {
            text-align: center;
            margin-bottom: 25px;
            color: #ffffff;
        }

        .back-button {
            display: inline-block;
            margin-bottom: 20px;
            background-color: #95a5a6;
            color: white;
            padding: 10px 18px;
            text-decoration: none;
            border-radius: 6px;
            font-weight: bold;
            transition: background-color 0.3s ease;
        }

        .back-button:hover {
            background-color:rgb(8, 243, 55);
        }

        table {
            width: 100%;
        }

        td {
            padding: 10px;
        }

        input[type="text"], textarea {
            width: 100%;
            padding: 10px;
            border: none;
            border-radius: 5px;
            background-color: #444;
            color: white;
        }

        input[type="file"] {
            color: white;
        }

        button[type="submit"] {
            background-color: #8e44ad;
            color: white;
            padding: 12px 25px;
            border: none;
            border-radius: 6px;
            cursor: pointer;
            font-size: 1em;
        }

        button[type="submit"]:hover {
            background-color: #732d91;
        }

        .error {
            background-color: #e74c3c;
            color: white;
            padding: 10px;
            margin-bottom: 15px;
            border-radius: 5px;
            text-align: center;
        }
    </style>
</head>
<body>

<div class="form-container">
    <a href="dashboard.php" class="back-button">← Back to Dashboard</a>

    <h2>Add a New Book</h2>

    <?php if ($error): ?>
        <div class="error"><?= htmlspecialchars($error) ?></div>
    <?php endif; ?>

    <form method="post" enctype="multipart/form-data">
        <table>
            <tr>
                <td><label for="title">Title:</label></td>
                <td><input type="text" name="title" id="title" required></td>
            </tr>
            <tr>
                <td><label for="author">Author:</label></td>
                <td><input type="text" name="author" id="author" required></td>
            </tr>
            <tr>
                <td><label for="location">Location:</label></td>
                <td><input type="text" name="location" id="location" required></td>
            </tr>
            <tr>
                <td><label for="category_id">Category ID:</label></td>
                <td><input type="text" name="category_id" id="category_id" placeholder="Enter category_id" required></td>
            </tr>
            <tr>
                <td><label for="image">Image:</label></td>
                <td><input type="file" name="image" id="image"></td>
            </tr>
            <tr>
                <td><label for="description">Description:</label></td>
                <td><textarea name="description" id="description" rows="4" required></textarea></td>
            </tr>
            <tr>
                <td colspan="2" style="text-align:center;">
                    <button type="submit">Add Book</button>
                </td>
            </tr>
        </table>
    </form>
</div>

</body>
</html>
