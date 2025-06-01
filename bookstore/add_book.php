<?php
session_start();
if (!isset($_SESSION['user']) || $_SESSION['role'] != 'admin') {
    header("Location: login.php");
    exit();
}
$conn = new mysqli("localhost", "root", "", "yourbooks_db");
$msg = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $title = $_POST["title"];
    $author = $_POST["author"];
    $price = $_POST["price"];
    $category = $_POST["category"];

    $imageName = $_FILES["image"]["name"];
    $imageTmp = $_FILES["image"]["tmp_name"];
    $uploadPath = "uploads/" . $imageName;

    if (move_uploaded_file($imageTmp, $uploadPath)) {
        $conn->query("INSERT INTO books (title, author, price, category, image) VALUES ('$title', '$author', '$price', '$category', '$imageName')");
        $msg = "Book added successfully!";
    } else {
        $msg = "Failed to upload image.";
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Add Book | Admin</title>
    <style>
        body { font-family: Arial; margin: 0; background-color: #f7f7f7; }
        .navbar {
            background-color: #2c3e50;
            padding: 10px 20px;
            display: flex;
            justify-content: space-between;
        }
        .navbar a {
            color: white;
            text-decoration: none;
            margin: 0 15px;
            font-weight: bold;
        }
        .navbar a:hover {
            color: #f1c40f;
        }
        .form-container {
            width: 500px;
            margin: 40px auto;
            background: white;
            padding: 25px;
            box-shadow: 0 0 10px gray;
        }
        h2 { text-align: center; color: #2980b9; }
        input, select {
            width: 100%;
            margin: 10px 0;
            padding: 10px;
        }
        button {
            background: #2980b9;
            color: white;
            border: none;
            padding: 10px 20px;
            cursor: pointer;
        }
        button:hover {
            background: #3498db;
        }
        .msg { text-align: center; color: green; }
    </style>
</head>
<body>

<div class="navbar">
    <div>
		<a href="admin.php">Home</a>
        <a href="add_book.php">Add Book</a>
        <a href="update_book.php">Update Book</a>
        <a href="delete_book.php">Delete Book</a>
    </div>
    <div><a href="logout.php">Logout</a></div>
</div>

<div class="form-container">
    <h2>Add New Book</h2>
    <form method="POST" enctype="multipart/form-data">
        <input type="text" name="title" placeholder="Book Title" required>
        <input type="text" name="author" placeholder="Author Name" required>
        <input type="number" step="0.01" name="price" placeholder="Price" required>
        <select name="category">
            <option value="Fiction">Fiction</option>
            <option value="Textbook">Textbook</option>
            <option value="Novel">Novel</option>
            <option value="Other">Other</option>
        </select>
        <input type="file" name="image" required>
        <button type="submit">Add Book</button>
    </form>
    <div class="msg"><?= $msg ?></div>
</div>

</body>
</html>
