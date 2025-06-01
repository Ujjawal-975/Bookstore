<?php
session_start();
if (!isset($_SESSION['user']) || $_SESSION['role'] != 'admin') {
    header("Location: login.php");
    exit();
}
$conn = new mysqli("localhost", "root", "", "yourbooks_db");
?>

<!DOCTYPE html>
<html>
<head>
    <title>Admin Dashboard | YourBooks</title>
    <style>
        body {
            font-family: Arial;
            margin: 0;
            background-color: #f9f9f9;
        }
        .navbar {
            background-color: #2c3e50;
            padding: 15px;
            display: flex;
            justify-content: space-around;
        }
        .navbar a {
            color: white;
            text-decoration: none;
            font-weight: bold;
        }
        .navbar a:hover {
            text-decoration: underline;
        }
        .container {
            padding: 20px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            background: white;
            box-shadow: 0 0 10px gray;
        }
        th, td {
            border: 1px solid #ccc;
            padding: 10px;
        }
        th {
            background-color: #2980b9;
            color: white;
        }
        tr:hover {
            background-color: #ecf0f1;
        }
    </style>
</head>
<body>

<div class="navbar">
	<a href="admin_orders.php">Orders</a>
    <a href="add_book.php">Add Book</a>
    <a href="update_book.php">Update Book</a>
    <a href="delete_book.php">Delete Book</a>
    <a href="logout.php">Logout</a>
</div>

<div class="container">
    <h2>All Books in Store</h2>
    <table>
        <tr>
            <th>ID</th>
            <th>Title</th>
            <th>Author</th>
            <th>Price</th>
            <th>Category</th>
            <th>Image</th>
        </tr>

        <?php
        $result = $conn->query("SELECT * FROM books");
        while ($row = $result->fetch_assoc()) {
            echo "<tr>
                <td>{$row['id']}</td>
                <td>{$row['title']}</td>
                <td>{$row['author']}</td>
                <td>₹{$row['price']}</td>
                <td>{$row['category']}</td>
                <td><img src='uploads/{$row['image']}' width='50'></td>
            </tr>";
        }
        ?>
    </table>
</div>

</body>
</html>
