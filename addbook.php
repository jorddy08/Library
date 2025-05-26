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
</head>
<body>
    <h1>Add a New Book</h1>
    <form method="post" enctype="multipart/form-data">
        <?php if ($error): ?>
            <div class="error" style="color: red;"><?= htmlspecialchars($error) ?></div>
        <?php endif; ?>

        <label for="title">Title:</label><br>
        <input type="text" name="title" id="title" required style="width:100%; margin-bottom:10px;"><br>

        <label for="author">Author:</label><br>
        <input type="text" name="author" id="author" required style="width:100%; margin-bottom:10px;"><br>

        <label for="location">Location:</label><br>
        <input type="text" name="location" id="location" required style="width:100%; margin-bottom:10px;"><br>

        <label for="category_id">Category:</label><br>
        <input type="text" name="category_id" id="category_id" required style="width:100%; margin-bottom:10px;"><br>

        <label for="image">Image:</label><br>
        <input type="file" name="image" id="image" style="margin-bottom:10px;"><br>

        <label for="description">Description:</label><br>
        <textarea id="description" name="description" rows="4" required style="width:100%; margin-bottom:10px;"></textarea><br>

        <button type="submit" style="padding: 10px 20px; font-size: 1em;">Add Book</button>
    </form>
</body>
</html>
