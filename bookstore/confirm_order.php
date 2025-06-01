<?php
$conn = new mysqli("localhost", "root", "", "yourbooks_db");

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Collect form data
$book_id = $_POST['book_id'];
$book_title = $_POST['book_title'];
$price = $_POST['price'];
$buyer_name = $_POST['buyer_name'];
$address = $_POST['address'];
$phone = $_POST['phone'];
$payment_type = $_POST['payment_type'];
$transaction_id = $_POST['transaction_id'] ?? '';
$status = 'Pending';
$order_code = strtoupper(uniqid('ORDER'));

// Save to orders table
$sql = "INSERT INTO orders (book_id, book_title, price, buyer_name, address, phone, payment_type, transaction_id, status, order_code)
        VALUES ('$book_id', '$book_title', '$price', '$buyer_name', '$address', '$phone', '$payment_type', '$transaction_id', '$status', '$order_code')";

// HTML starts here
?>
<!DOCTYPE html>
<html>
<head>
    <title>Order Confirmation</title>
    <style>
        body {
            font-family: 'Segoe UI', sans-serif;
            background-color: #f5f7fa;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }

        .confirmation-box {
            background-color: #ffffff;
            padding: 40px;
            border-radius: 12px;
            box-shadow: 0 6px 20px rgba(0,0,0,0.1);
            max-width: 500px;
            text-align: center;
        }

        .confirmation-box h2 {
            color: #2ecc71;
            margin-bottom: 20px;
        }

        .confirmation-box p {
            font-size: 16px;
            margin: 10px 0;
            color: #333;
        }

        .order-code {
            font-size: 18px;
            font-weight: bold;
            color: #2980b9;
            margin-top: 10px;
        }

        .back-btn {
            display: inline-block;
            margin-top: 25px;
            padding: 12px 25px;
            background-color: #3498db;
            color: white;
            text-decoration: none;
            border-radius: 6px;
            transition: background-color 0.3s ease;
        }

        .back-btn:hover {
            background-color: #2980b9;
        }
    </style>
</head>
<body>
    <div class="confirmation-box">
        <?php
        if ($conn->query($sql) === TRUE) {
            echo "<h2>Order Confirmed!</h2>";
            echo "<p>Thank you, <strong>" . htmlspecialchars($buyer_name) . "</strong>, for your purchase.</p>";
            echo "<p>Your order for <strong>" . htmlspecialchars($book_title) . "</strong> (₹$price) has been placed.</p>";
            echo "<p class='order-code'>Order Code: $order_code</p>";
            echo "<p>Use this code to track your order status.</p>";
        } else {
            echo "<h2 style='color:red;'>Order Failed!</h2>";
            echo "<p>Error: " . htmlspecialchars($conn->error) . "</p>";
        }
        $conn->close();
        ?>
        <a href="index.php" class="back-btn">Go to Home</a>
    </div>
</body>
</html>
