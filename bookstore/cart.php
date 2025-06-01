<?php
session_start();
if (!isset($_SESSION['user'])) {
    header("Location: login.php");
    exit();
}

if (!isset($_SESSION['cart'])) {
    $_SESSION['cart'] = [];
}

if (isset($_GET['remove'])) {
    $remove_id = $_GET['remove'];
    unset($_SESSION['cart'][$remove_id]);
}

include "db.php";
?>

<!DOCTYPE html>
<html>
<head>
    <title>YourBooks - My Cart</title>
    <style>
        body {
            font-family: Arial;
            background: #f5f5f5;
            margin: 0;
        }
        .navbar {
            background-color: #333;
            padding: 10px;
            color: white;
            display: flex;
            justify-content: space-between;
        }
        .navbar a {
            color: white;
            text-decoration: none;
            margin-left: 20px;
        }
        .container {
            padding: 30px;
        }
        .book {
            background: white;
            margin-bottom: 20px;
            display: flex;
            padding: 20px;
            box-shadow: 0px 2px 5px rgba(0,0,0,0.2);
        }
        .book img {
            width: 100px;
            height: 140px;
            object-fit: cover;
        }
        .book-info {
            margin-left: 20px;
        }
        .remove-btn {
            margin-top: 20px;
            display: inline-block;
            padding: 6px 12px;
            background: red;
            color: white;
            text-decoration: none;
            border-radius: 5px;
        }
        .empty {
            text-align: center;
            font-size: 20px;
            color: gray;
        }
    </style>
</head>
<body>

<div class="navbar">
    <div><strong>YourBooks</strong></div>
    <div>
        <a href="index.php">Home</a>
        <a href="cart.php">My Cart (<?= count($_SESSION['cart']); ?>)</a>
        <a href="logout.php">Logout</a>
    </div>
</div>

<div class="container">
    <h2>My Cart</h2>

    <?php
    if (empty($_SESSION['cart'])) {
        echo "<div class='empty'>Your cart is empty.</div>";
    } else {
        $ids = implode(',', array_map('intval', array_keys($_SESSION['cart'])));
        $sql = "SELECT * FROM books WHERE id IN ($ids)";
        $result = mysqli_query($conn, $sql);

        while ($row = mysqli_fetch_assoc($result)) {
            echo "<div class='book'>
                    <img src='uploads/{$row['image']}' alt='Book Image'>
                    <div class='book-info'>
                        <h3>{$row['title']}</h3>
                        <p><strong>Author:</strong> {$row['author']}</p>
                        <p><strong>Price:</strong> ₹{$row['price']}</p>
                        <a class='remove-btn' href='cart.php?remove={$row['id']}'>Remove</a>
                    </div>
                </div>";
        }
    }
    ?>
</div>

</body>
</html>
