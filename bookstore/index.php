<?php
session_start();

// Initialize cart
if (!isset($_SESSION['cart'])) {
    $_SESSION['cart'] = [];
}

// Handle Add to Cart
$addedMessage = "";
if (isset($_GET['add'])) {
    $book_id = $_GET['add'];
    if (!isset($_SESSION['cart'][$book_id])) {
        $_SESSION['cart'][$book_id] = 1;
        $addedMessage = "Book added to cart!";
    } else {
        $addedMessage = "Book already in cart!";
    }
}

// Database connection
$conn = new mysqli("localhost", "root", "", "yourbooks_db");
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Check if admin is logged in
$isAdmin = isset($_SESSION['user_type']) && $_SESSION['user_type'] === 'admin';
?>

<!DOCTYPE html>
<html>
<head>
    <title>YourBooks | Online Bookstore</title>
    <style>
        body {
            margin: 0;
            font-family: Arial, sans-serif;
            background: #f4f4f4;
        }

        header {
            background-color: #2c3e50;
            color: white;
            padding: 10px 20px;
            position: sticky;
            top: 0;
            z-index: 1000;
        }

        header h1 {
            margin: 0;
            display: inline-block;
        }

        nav {
            float: right;
            margin-top: 10px;
        }

        nav a {
            color: white;
            margin: 0 15px;
            text-decoration: none;
            font-weight: bold;
        }

        nav a:hover {
            text-decoration: underline;
        }

        .book-row {
            display: flex;
            flex-wrap: wrap;
            justify-content: center;
            padding: 20px;
        }

        .book {
            background: white;
            width: 175px;
            margin: 15px;
            border-radius: 10px;
            box-shadow: 0 4px 10px rgba(0,0,0,0.1);
            transition: transform 0.3s;
        }

        .book:hover {
            transform: scale(1.05);
        }

        .book img {
            width: 100%;
            height: 280px;
            object-fit: cover;
            border-top-left-radius: 10px;
            border-top-right-radius: 10px;
        }

        .book-info {
            padding: 15px;
            text-align: center;
        }

        .book-info h3 {
            margin: 10px 0 5px;
        }

        .book-info p {
            margin: 5px 0;
        }

        .btn {
            display: inline-block;
            padding: 8px 12px;
            margin: 5px;
            color: white;
            border-radius: 5px;
            text-decoration: none;
            font-weight: bold;
        }

        .add-btn {
            background: #27ae60;
        }

        .buy-btn {
            background: #2980b9;
        }

        .btn:hover {
            opacity: 0.85;
        }

        .clearfix {
            clear: both;
        }
    </style>
</head>
<body>

<header>
    <h1>YourBooks</h1>
    <nav>
        <a href="index.php">Home</a>
       <a href="aboutus.php">About</a>
        <a href="track_order.php">Track Order</a>
        <?php if (!$isAdmin): ?>
            <a href="login.php">Admin Panel</a>
        <?php endif; ?>
        <?php if ($isAdmin): ?>
            <a href="admin.php">Admin Panel</a>
        <?php endif; ?>
       
    </nav>
    <div class="clearfix"></div>
</header>

<?php if ($addedMessage): ?>
    <script>
        alert("<?= $addedMessage ?>");
    </script>
<?php endif; ?>

<div class="book-row">
<?php
$sql = "SELECT * FROM books";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    while($book = $result->fetch_assoc()) {
        echo "<div class='book'>
                <img src='uploads/{$book['image']}' alt='Book Image'>
                <div class='book-info'>
                    <h3>{$book['title']}</h3>
                    <p><i>{$book['author']}</i></p>
                    <p><b>₹{$book['price']}</b></p>
                  
                    <a href='buy.php?id={$book['id']}' class='btn buy-btn'>Buy Now</a>
                </div>
              </div>";
    }
} else {
    echo "<p>No books found.</p>";
}
$conn->close();
?>
</div>

</body>
</html>
