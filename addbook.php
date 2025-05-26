<?php
// Include database connection
include 'database.php'; // replace with the actual filename if different

$error = '';

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = $_POST['title'] ?? '';
    $author = $_POST['author'] ?? '';
    $location = $_POST['location'] ?? '';
    $category_id = $_POST['category_id'] ?? '';
    $description = $_POST['description'] ?? '';
    $image_path = '';

    // Handle image upload
    if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
        $uploadDir = 'uploads/';
        if (!is_dir($uploadDir)) {
            mkdir($uploadDir, 0755, true);
        }

        $fileTmpPath = $_FILES['image']['tmp_name'];
        $fileName = basename($_FILES['image']['name']);
        $fileExtension = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));
        $allowedExtensions = ['jpg', 'jpeg', 'png', 'gif'];

        if (in_array($fileExtension, $allowedExtensions)) {
            $newFileName = uniqid('img_', true) . '.' . $fileExtension;
            $destination = $uploadDir . $newFileName;

            if (move_uploaded_file($fileTmpPath, $destination)) {
                $image_path = $destination;
            } else {
                $error = 'Failed to move uploaded file.';
            }
        } else {
            $error = 'Invalid file type. Only JPG, PNG, and GIF are allowed.';
        }
    }

    if (!$error) {
        $stmt = $conn->prepare("INSERT INTO books (title, author, location, category_id, image_path, description) VALUES (?, ?, ?, ?, ?, ?)");
        if ($stmt) {
            $stmt->bind_param("ssssss", $title, $author, $location, $category_id, $image_path, $description);
            if ($stmt->execute()) {
                header('Location: success.php'); // Or display success message
                exit;
            } else {
                $error = "Database error: " . $stmt->error;
            }
            $stmt->close();
        } else {
            $error = "Prepare failed: " . $conn->error;
        }
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
        <input type="text" name="category_id" id="category_id" required style="width:100%; margin-bottom:10px;" placeholder="Enter category_id"><br>

        <label for="image">Image:</label><br>
        <input type="file" name="image" id="image" style="margin-bottom:10px;"><br>

        <label for="description">Description:</label><br>
        <textarea id="description" name="description" rows="4" required style="width:100%; margin-bottom:10px;"></textarea><br>

        <button type="submit" style="padding: 10px 20px; font-size: 1em;">Add Book</button>
    </form>
</body>
</html>
