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

// ✅ Fetch category options from DB
$categories = [];
$result = $conn->query("SELECT name FROM categories WHERE name IN (
    'Classic Fiction',
    'Science Fiction / Dystopian',
    'Fantasy',
    'Historical Fiction',
    'Others'
)");
while ($row = $result->fetch_assoc()) {
    $categories[] = $row;
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $title = trim($_POST['title']);
    $author = trim($_POST['author']);
    $location = trim($_POST['location']);
    $description = trim($_POST['description']);
    $category_name = trim($_POST['category_name']); // Now as string
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

    if (!$error && $title && $author && $location && $category_name) {
        $stmt = $conn->prepare("INSERT INTO book (title, author, location, description, image, category_name) VALUES (?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("ssssss", $title, $author, $location, $description, $imageFileName, $category_name);
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
        /* your existing CSS styles */
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
                <td><label for="category_name">Category:</label></td>
                <td>
                    <select name="category_name" id="category_name" required>
                        <option value="">-- Select Category --</option>
                        <?php foreach ($categories as $cat): ?>
                            <option value="<?= htmlspecialchars($cat['name']) ?>"><?= htmlspecialchars($cat['name']) ?></option>
                        <?php endforeach; ?>
                    </select>
                </td>
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
