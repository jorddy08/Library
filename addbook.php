<?php
session_start();
if (!isset($_SESSION["username"])) {
    header("Location: login.php");
    exit();
}

// DB connection
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "lms";

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$error = "";

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] === "POST") {
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

    if (!$error && $title && $author && $location && $description && $category_id) {
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
            background-color: #f4f4f4;
            margin: 0;
            padding: 40px;
        }

        .form-container {
            width: 600px;
            margin: 0 auto;
            background-color: #fff;
            padding: 25px;
            border-radius: 10px;
            box-shadow: 0 0 15px rgba(0,0,0,0.1);
        }

        table {
            width: 100%;
        }

        td {
            padding: 10px 5px;
            vertical-align: top;
        }

        input[type="text"],
        textarea {
            width: 100%;
            padding: 8px;
            border-radius: 4px;
            border: 1px solid #ccc;
        }

        input[type="file"] {
            padding: 4px;
        }

        button {
            padding: 10px 20px;
            font-size: 1em;
            background-color: #3498db;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }

        button:hover {
            background-color: #2980b9;
        }

        .error {
            color: red;
            margin-bottom: 15px;
            text-align: center;
        }

        h1 {
            text-align: center;
        }
    </style>
</head>
<body>

<div class="form-container">
    <h1>Add a New Book</h1>

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
                <td><input type="text" name="category_id" id="category_id" required></td>
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
