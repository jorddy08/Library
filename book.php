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
            $error = "Only JPG, JPEG, PNG, and GIF files are allowed for images.";
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
    <title>Books Scrollable</title>
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
            max-width: 600px;
            border-radius: 8px;
            box-shadow: 0 0 8px rgba(0,0,0,0.3);
            margin-bottom: 30px;
        }

        .error {
            color: var(--accent);
            margin-bottom: 15px;
        }

        /* Removed arrow buttons styles */

        .carousel-wrapper {
            max-width: 90%;
            margin: 0 auto;
            overflow: hidden;
            padding: 20px 0;
        }

        .carousel {
            display: flex;
            gap: 20px;
            overflow-x: auto;
            scroll-behavior: smooth;
            padding-bottom: 10px;
            -webkit-overflow-scrolling: touch; /* smooth scrolling on iOS */
        }

        .carousel::-webkit-scrollbar {
            display: none;
        }

        .book-box {
            flex: 0 0 220px;
            background-color: var(--card-bg);
            color: var(--foreground);
            border-radius: 10px;
            padding: 20px;
            font-weight: bold;
            font-size: 1.1em;
            cursor: pointer;
            box-shadow: 0 4px 8px rgb(0 0 0 / 0.15);
            display: flex;
            flex-direction: column;
            align-items: center;
            text-align: center;
            transition: transform 0.3s ease-in-out;
            user-select: none;
        }

        .book-box:hover {
            transform: scale(1.05);
            background-color: var(--highlight);
        }

        .book-image {
            width: 100%;
            height: 150px;
            object-fit: cover;
            border-radius: 8px;
            margin-bottom: 15px;
            background-color: #444;
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
<div class="carousel-wrapper">
    <!-- Removed arrow buttons -->
    <div class="carousel" id="carousel">
        <?php foreach ($books as $book): ?>
            <?php $imagePath = 'uploads/' . $book['image']; ?>
            <div class="book-box" title="<?= htmlspecialchars($book['title']) ?>"
                onclick="openExpandedView(
                    '<?= htmlspecialchars($imagePath, ENT_QUOTES) ?>',
                    '<?= htmlspecialchars($book['title'], ENT_QUOTES) ?>',
                    '<?= htmlspecialchars($book['author'], ENT_QUOTES) ?>',
                    '<?= htmlspecialchars($book['location'], ENT_QUOTES) ?>',
                    '<?= htmlspecialchars($book['description'] ?? '', ENT_QUOTES) ?>',
                    '<?= htmlspecialchars($book['category_id'] ?? '', ENT_QUOTES) ?>'
                )">
                <?php if (!empty($book['image']) && file_exists($imagePath)): ?>
                    <img src="<?= $imagePath ?>" alt="Book Image" class="book-image">
                <?php else: ?>
                    <div class="book-image" style="display:flex;justify-content:center;align-items:center;color:#aaa;">No Image</div>
                <?php endif; ?>
                <div><?= htmlspecialchars($book['title']) ?></div>
                <div style="font-weight:normal; font-size:0.9em; margin-top:6px;"><?= htmlspecialchars($book['author']) ?></div>
                <div style="font-weight:normal; font-size:0.85em; margin-top:4px; opacity:0.8;"><?= htmlspecialchars($book['location']) ?></div>
            </div>
        <?php endforeach; ?>

        <?php if (empty($books)): ?>
            <p style="color: var(--foreground);">No books found.</p>
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
        <p id="desccategory_id"></p>
        <button onclick="closeExpandedView()">Close</button>
    </div>
</div>

<script>
    // Removed scrollCarousel function and arrow buttons

    function openExpandedView(imageSrc, title, author, location, description, category_id) {
        document.getElementById('expandedImage').src = imageSrc;
        document.getElementById('descTitle').textContent = title;
        document.getElementById('descAuthor').textContent = 'By: ' + author;
        document.getElementById('descLocation').textContent = 'Location: ' + location;
        document.getElementById('descDescription').textContent = 'Description: ' + description;
        document.getElementById('desccategory_id').textContent = 'Category_id: ' + category_id;
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
