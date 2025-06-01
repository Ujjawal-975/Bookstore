<?php
session_start();
if (!isset($_SESSION['user']) || $_SESSION['role'] != 'admin') {
    header("Location: login.php");
    exit();
}
$conn = new mysqli("localhost", "root", "", "yourbooks_db");

$msg = "";
if (isset($_POST['delete'])) {
    $id = $_POST['id'];
    $conn->query("DELETE FROM books WHERE id=$id");
    $msg = "Book deleted successfully!";
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Delete Book | Admin</title>
    <style>
        body { font-family: Arial; background: #f7f7f7; margin: 0; }
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
        .container {
            width: 700px;
            margin: 40px auto;
            background: white;
            padding: 20px;
            box-shadow: 0 0 10px gray;
        }
        h2 { text-align: center; color: red; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th, td { padding: 10px; border: 1px solid #ccc; text-align: center; }
        button { padding: 5px 10px; background: red; color: white; border: none; cursor: pointer; }
        .msg { color: green; text-align: center; }
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

<div class="container">
    <h2>Delete Book</h2>
    <div class="msg"><?= $msg ?></div>
    <table>
        <tr>
            <th>ID</th><th>Title</th><th>Price</th><th>Action</th>
        </tr>
        <?php
        $result = $conn->query("SELECT * FROM books");
        while ($row = $result->fetch_assoc()) {
            echo "<tr>
                <form method='POST'>
                    <td>{$row['id']}</td>
                    <td>{$row['title']}</td>
                    <td>₹{$row['price']}</td>
                    <td>
                        <input type='hidden' name='id' value='{$row['id']}'>
                        <button name='delete' onclick=\"return confirm('Are you sure?')\">Delete</button>
                    </td>
                </form>
            </tr>";
        }
        ?>
    </table>
</div>
</body>
</html>
