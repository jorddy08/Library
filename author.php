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

// Fetch distinct authors
$authors = [];
$authorResult = $conn->query("SELECT DISTINCT author FROM book ORDER BY author");
if ($authorResult) {
    while ($row = $authorResult->fetch_assoc()) {
        $authors[] = $row['author'];
    }
}

$selectedAuthor = isset($_GET['author']) ? $_GET['author'] : null;
$books = [];

if ($selectedAuthor) {
    $stmt = $conn->prepare("SELECT * FROM book WHERE author = ?");
    $stmt->bind_param("s", $selectedAuthor);
    $stmt->execute();
    $result = $stmt->get_result();
    while ($row = $result->fetch_assoc()) {
        $books[] = $row;
    }
    $stmt->close();
}

$conn->close();
?>

<!DOCTYPE html>
<html>
<head>
    <title><?= $selectedAuthor ? htmlspecialchars($selectedAuthor) . " - Books" : "Authors List" ?></title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background: #222;
            color: #eee;
            margin: 0;
            height: 100vh;
            display: flex;
            overflow: hidden;
        }
        /* Sidebar (authors) */
        .sidebar {
            width: 250px;
            background: #333;
            padding: 20px;
            overflow-y: auto;
            box-sizing: border-box;
            border-right: 2px solid #444;
        }
        .sidebar h2 {
            margin-top: 0;
            margin-bottom: 15px;
        }
        .author-list {
            list-style: none;
            padding: 0;
            margin: 0;
        }
        .author-list li {
            margin-bottom: 10px;
        }
        .author-list a {
            color: #0af;
            text-decoration: none;
            font-weight: bold;
            padding: 8px 12px;
            border-radius: 6px;
            display: block;
            transition: background-color 0.3s ease;
        }
        .author-list a:hover,
        .author-list a.active {
            background-color: #444;
        }

        /* Main content (books) */
        .main-content {
            flex-grow: 1;
            padding: 20px;
            overflow-y: auto;
            box-sizing: border-box;
        }
        .main-content h2 {
            margin-top: 0;
            margin-bottom: 20px;
        }
        .book-list {
            list-style: none;
            padding: 0;
            margin: 0;
            display: flex;
            flex-wrap: wrap;
            gap: 20px;
        }
        .book-list li {
            background: #333;
            border-radius: 8px;
            width: 140px;
            padding: 10px;
            box-sizing: border-box;
            display: flex;
            flex-direction: column;
            align-items: center;
            text-align: center;
            transition: background-color 0.3s ease;
        }
        .book-list li:hover {
            background-color: #444;
        }
        .book-list img {
            width: 100px;
            height: 140px;
            object-fit: cover;
            border-radius: 6px;
            background-color: #555;
            margin-bottom: 10px;
        }
        .book-title {
            font-size: 1em;
        }
        .no-image {
            width: 100px;
            height: 140px;
            background: #555;
            color: #aaa;
            display: flex;
            justify-content: center;
            align-items: center;
            border-radius: 6px;
            font-size: 0.9em;
            margin-bottom: 10px;
        }

        /* Back button */
        a.back-button {
            display: inline-block;
            margin-bottom: 20px;
            padding: 10px 16px;
            background-color: #28a745;
            color: #fff;
            text-decoration: none;
            border-radius: 6px;
            transition: background-color 0.3s ease;
        }
        a.back-button:hover {
            background-color: #218838;
        }
    </style>
</head>
<body>

    <nav class="sidebar">
        <a href="dashboard.php" class="back-button" style="display: inline-block; margin-bottom: 20px;">← Back to Dashboard</a>
        <h2>Authors</h2>
        <ul class="author-list">
            <?php if (!empty($authors)): ?>
                <?php foreach ($authors as $author): ?>
                    <li>
                        <a href="?author=<?= urlencode($author) ?>" class="<?= $author === $selectedAuthor ? 'active' : '' ?>">
                            <?= htmlspecialchars($author) ?>
                        </a>
                    </li>
                <?php endforeach; ?>
            <?php else: ?>
                <li>No authors found.</li>
            <?php endif; ?>
        </ul>
    </nav>

    <main class="main-content">
        <?php if ($selectedAuthor): ?>
            <!-- Removed back button here as requested -->
            <h2>Books by <?= htmlspecialchars($selectedAuthor) ?></h2>
            <?php if (!empty($books)): ?>
                <ul class="book-list">
                    <?php foreach ($books as $book): ?>
                        <li>
                            <?php
                            $imagePath = 'uploads/' . $book['image'];
                            if (!empty($book['image']) && file_exists($imagePath)):
                            ?>
                                <img src="<?= $imagePath ?>" alt="<?= htmlspecialchars($book['title']) ?>">
                            <?php else: ?>
                                <div class="no-image">No Image</div>
                            <?php endif; ?>
                            <div class="book-title"><?= htmlspecialchars($book['title']) ?></div>
                        </li>
                    <?php endforeach; ?>
                </ul>
            <?php else: ?>
                <p>No books found for this author.</p>
            <?php endif; ?>
        <?php else: ?>
            <h2>Please select an author to see their books.</h2>
        <?php endif; ?>
    </main>

</body>

</html>
