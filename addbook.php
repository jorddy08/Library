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

// Fetch only the specified 5 categories
$categories = [];
$catResult = $conn->query("
    SELECT * FROM categories 
    WHERE name IN ('Classic Fiction', 'Science Fiction/Dystopian', 'Fantasy', 'Historical Fiction', 'Others')
");
if ($catResult) {
    while ($row = $catResult->fetch_assoc()) {
        $categories[] = $row;
    }
}

// Fetch books (all or by category)
$books = [];
$selectedCategoryName = "All Books";
if (isset($_GET['category_id'])) {
    $category_id = intval($_GET['category_id']);
    $stmt = $conn->prepare("
        SELECT book.*, categories.name AS category_name 
        FROM book 
        JOIN categories ON book.category_id = categories.id 
        WHERE category_id = ?
    ");
    $stmt->bind_param("i", $category_id);
    $stmt->execute();
    $result = $stmt->get_result();
    while ($row = $result->fetch_assoc()) {
        $books[] = $row;
    }
    $stmt->close();

    if (!empty($books)) {
        $selectedCategoryName = $books[0]['category_name'];
    }
} else {
    $result = $conn->query("
        SELECT book.*, categories.name AS category_name 
        FROM book 
        JOIN categories ON book.category_id = categories.id 
        ORDER BY book.id DESC
    ");
    while ($row = $result->fetch_assoc()) {
        $books[] = $row;
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Categories</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background: #333;
            color: #fff;
            padding: 20px;
        }
        h1, h2 {
            margin-bottom: 20px;
        }
        .back-button {
            display: inline-block;
            margin-bottom: 20px;
            padding: 10px 16px;
            background-color: #28a745;
            color: #fff;
            text-decoration: none;
            border-radius: 6px;
            transition: background-color 0.3s ease;
        }
        .back-button:hover {
            background-color: #218838;
        }
        .categories {
            margin-bottom: 30px;
        }
        .category-link {
            background: #555;
            color: #fff;
            padding: 10px 15px;
            margin-right: 10px;
            border-radius: 5px;
            text-decoration: none;
            display: inline-block;
            margin-bottom: 10px;
        }
        .category-link:hover {
            background: #777;
        }
        .category-container {
            display: flex;
            flex-wrap: wrap;
            gap: 25px;
        }
        .category-box {
            background: #555;
            border-radius: 10px;
            width: 180px;
            text-align: center;
            padding: 15px;
            transition: background 0.3s;
        }
        .category-box:hover {
            background: #777;
        }
        .category-image {
            width: 100%;
            height: 140px;
            object-fit: cover;
            border-radius: 8px;
            margin-bottom: 12px;
            background-color: #999;
        }
        .category-title {
            font-size: 1.1em;
            font-weight: bold;
        }
    </style>
</head>
<body>

<a href="dashboard.php" class="back-button">← Back to Dashboard</a>

<h1>Library</h1>

<div class="categories">
    <strong>Filter by Category:</strong><br>
    <a href="?" class="category-link">All</a>
    <?php foreach ($categories as $cat): ?>
        <a href="?category_id=<?= $cat['id'] ?>" class="category-link">
            <?= htmlspecialchars($cat['name']) ?>
        </a>
    <?php endforeach; ?>
</div>

<h2><?= htmlspecialchars($selectedCategoryName) ?></h2>

<div class="category-container">
    <?php
    if (!empty($books)) {
        foreach ($books as $row) {
            $imagePath = 'uploads/' . $row['image'];
            ?>
            <div class="category-box" title="<?= htmlspecialchars($row['title']) ?>">
                <?php if (!empty($row['image']) && file_exists($imagePath)) : ?>
                    <img src="<?= $imagePath ?>" alt="<?= htmlspecialchars($row['title']) ?>" class="category-image">
                <?php else : ?>
                    <div class="category-image" style="display:flex;align-items:center;justify-content:center;color:#222;background:#ccc;">No Image</div>
                <?php endif; ?>
                <div class="category-title"><?= htmlspecialchars($row['title']) ?></div>
            </div>
            <?php
        }
    } else {
        echo "<p>No books found in this category.</p>";
    }
    ?>
</div>

</body>
</html>
