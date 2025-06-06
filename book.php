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

// Handle form submission (Add Book)
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $title = trim($_POST['title']);
    $author = trim($_POST['author']);
    $location = trim($_POST['location']);
    $description = trim($_POST['description']);
    $category_name = trim($_POST['category_name']);
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
            $error = "Only JPG, JPEG, PNG, and GIF files are allowed for images.";
        }
    }

    if (!$error && $title && $author && $location) {
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

// Fetch books
$result = $conn->query("SELECT * FROM book ORDER BY id DESC");
$books = [];
if ($result && $result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $books[] = $row;
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Books List</title>
    <style>
        :root {
            --background: #1e1e2f;
            --foreground: #ffffff;
            --primary: #8e44ad;
            --secondary: #3498db;
            --accent: #e67e22;
            --muted: #555;
            --card-bg: #2c2c3c;
            --highlight: #3b3b4f;
        }

        body {
            font-family: 'Segoe UI', sans-serif;
            background-color: var(--background);
            margin: 0;
            padding: 20px;
            color: var(--foreground);
        }

        h1 {
            color: var(--foreground);
            margin-bottom: 15px;
        }

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

        form {
            background: var(--card-bg);
            padding: 20px;
            max-width: 400px;
            border-radius: 8px;
            box-shadow: 0 0 8px rgba(0,0,0,0.3);
            margin-bottom: 30px;
        }

        .error {
            color: var(--accent);
            margin-bottom: 15px;
        }

        /* Scrollable vertical list container */
        .book-list-wrapper {
            max-width: 90%;
            margin: 0 auto;
            height: 600px; /* fixed height for scroll */
            overflow-y: auto;
            padding-right: 10px; /* space for scrollbar */
            border-radius: 8px;
            background-color: var(--card-bg);
            box-shadow: 0 0 10px rgba(0,0,0,0.3);
        }

        /* Remove flex, use block for vertical stacking */
        .book-list {
            display: block;
            padding: 10px;
        }

        .book-box {
            background-color: var(--card-bg);
            color: var(--foreground);
            border-radius: 10px;
            padding: 15px 20px;
            font-weight: bold;
            font-size: 1.1em;
            cursor: pointer;
            box-shadow: 0 4px 8px rgb(0 0 0 / 0.15);
            display: flex;
            align-items: center;
            gap: 20px;
            margin-bottom: 15px;
            transition: background-color 0.3s ease, transform 0.3s ease-in-out;
            user-select: none;
        }

        .book-box:hover {
            background-color: var(--highlight);
            transform: translateX(5px);
        }

        .book-image {
            width: 120px;
            height: 100px;
            object-fit: cover;
            border-radius: 8px;
            background-color: #444;
            flex-shrink: 0;
        }

        .book-info {
            flex-grow: 1;
        }

        .book-info > div {
            margin-bottom: 6px;
        }

        .book-title {
            font-weight: bold;
            font-size: 1.2em;
        }

        .book-author, .book-location {
            font-weight: normal;
            font-size: 0.9em;
            opacity: 0.8;
        }

        /* Scrollbar styling for modern browsers */
        .book-list-wrapper::-webkit-scrollbar {
            width: 10px;
        }
        .book-list-wrapper::-webkit-scrollbar-thumb {
            background-color: var(--primary);
            border-radius: 10px;
        }
        .book-list-wrapper::-webkit-scrollbar-track {
            background-color: var(--card-bg);
        }

        #expandedView {
            position: fixed;
            top: 0;
            left: 0;
            width: 100vw;
            height: 100vh;
            background-color: rgba(0,0,0,0.85);
            display: none;
            z-index: 1000;
            padding: 20px;
            box-sizing: border-box;
            justify-content: center;
            align-items: center;
            gap: 20px;
            color: var(--foreground);
        }

        #expandedImage {
            width: 50%;
            max-height: 80vh;
            object-fit: contain;
            border-radius: 12px;
            box-shadow: 0 0 20px #000;
            background-color: #222;
        }

        #expandedDescription {
            width: 50%;
            overflow-y: auto;
            max-height: 80vh;
            background-color: var(--card-bg);
            border-radius: 12px;
            padding: 20px;
            box-sizing: border-box;
            box-shadow: 0 0 20px #000;
        }

        #expandedDescription h2 {
            margin-top: 0;
            font-size: 2em;
        }

        #expandedDescription h4 {
            margin-top: 5px;
            font-weight: normal;
            opacity: 0.8;
        }

        #expandedDescription p {
            margin-top: 15px;
            line-height: 1.5;
            font-size: 1.1em;
        }

        #expandedDescription button {
            margin-top: 20px;
            background-color: var(--foreground);
            color: var(--background);
            border: none;
            padding: 10px 20px;
            font-size: 1em;
            border-radius: 6px;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        #expandedDescription button:hover {
            background-color: #ddd;
        }
    </style>
</head>
<body>

<a href="dashboard.php" class="back-button">← Back to Dashboard</a>

<h1>Books</h1>

<?php if ($error): ?>
    <div class="error"><?= htmlspecialchars($error) ?></div>
<?php endif; ?>

<div class="book-list-wrapper">
    <div class="book-list" id="bookList">
        <?php foreach ($books as $book): ?>
            <?php $imagePath = 'uploads/' . $book['image']; ?>
            <div class="book-box" title="<?= htmlspecialchars($book['title']) ?>"
                onclick="openExpandedView(
                    '<?= htmlspecialchars($imagePath, ENT_QUOTES) ?>',
                    '<?= htmlspecialchars($book['title'], ENT_QUOTES) ?>',
                    '<?= htmlspecialchars($book['author'], ENT_QUOTES) ?>',
                    '<?= htmlspecialchars($book['location'], ENT_QUOTES) ?>',
                    '<?= htmlspecialchars($book['description'] ?? '', ENT_QUOTES) ?>',
                    '<?= htmlspecialchars($book['category_name'] ?? '', ENT_QUOTES) ?>'
                )">
                <?php if (!empty($book['image']) && file_exists($imagePath)): ?>
                    <img src="<?= $imagePath ?>" alt="Book Image" class="book-image">
                <?php else: ?>
                    <div class="book-image" style="display:flex;justify-content:center;align-items:center;color:#aaa;">No Image</div>
                <?php endif; ?>
                <div class="book-info">
                    <div class="book-title"><?= htmlspecialchars($book['title']) ?></div>
                    <div class="book-author">By: <?= htmlspecialchars($book['author']) ?></div>
                    <div class="book-location">Location: <?= htmlspecialchars($book['location']) ?></div>
                </div>
            </div>
        <?php endforeach; ?>

        <?php if (empty($books)): ?>
            <p style="color: var(--foreground); padding: 10px;">No books found.</p>
        <?php endif; ?>
    </div>
</div>

<div id="expandedView" onclick="closeExpandedView()">
    <img id="expandedImage" src="" alt="Expanded Book Image" onclick="event.stopPropagation()">
    <div id="expandedDescription" onclick="event.stopPropagation()">
        <h2 id="descTitle"></h2>
        <h4 id="descAuthor"></h4>
        <p id="descLocation"></p>
        <p id="descDescription"></p>
        <p id="desccategory_name"></p>
        <button onclick="closeExpandedView()">Close</button>
    </div>
</div>

<script>
    function openExpandedView(imageSrc, title, author, location, description, category_name) {
        document.getElementById('expandedImage').src = imageSrc;
        document.getElementById('descTitle').textContent = title;
        document.getElementById('descAuthor').textContent = 'By: ' + author;
        document.getElementById('descLocation').textContent = 'Location: ' + location;
        document.getElementById('descDescription').textContent = 'Description: ' + description;
        document.getElementById('desccategory_name').textContent = 'Category name: ' + category_name;
        document.getElementById('expandedView').style.display = 'flex';
        document.body.style.overflow = 'hidden';
    }

    function closeExpandedView() {
        document.getElementById('expandedView').style.display = 'none';
        document.body.style.overflow = 'auto';
    }
</script>

</body>
</html>
