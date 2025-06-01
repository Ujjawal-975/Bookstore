<!DOCTYPE html>
<html>
<head>
    <title>Track Your Order - YourBooks</title>
    <style>
        body {
            font-family: 'Segoe UI', sans-serif;
            background-color: #f8f9fa;
            margin: 0;
            padding: 0;
        }

        .container {
            max-width: 600px;
            margin: 50px auto;
            background-color: white;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
        }

        h2, h3 {
            text-align: center;
            color: #2c3e50;
        }

        form p {
            text-align: center;
            font-size: 18px;
        }

        input[type="text"] {
            padding: 10px;
            width: 70%;
            font-size: 16px;
            border: 1px solid #ccc;
            border-radius: 6px;
        }

        button {
            padding: 10px 20px;
            background-color: #3498db;
            border: none;
            color: white;
            border-radius: 6px;
            font-size: 16px;
            cursor: pointer;
            margin-top: 10px;
        }

        button:hover {
            background-color: #2980b9;
        }

        .result {
            margin-top: 25px;
            font-size: 17px;
            line-height: 1.6;
        }

        .result p {
            margin: 10px 0;
        }

        .not-found {
            color: red;
            text-align: center;
            margin-top: 20px;
        }

        .back-home {
            display: block;
            text-align: center;
            margin-top: 30px;
            color: #2c3e50;
            text-decoration: none;
        }

        .back-home:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>

<div class="container">
    <h2>Track Your Order</h2>
    <form method="GET">
        <p>Enter Order Code:</p>
        <p><input type="text" name="code" required></p>
        <div style="text-align: center;">
            <button type="submit">Track</button>
        </div>
    </form>

    <?php
    if (isset($_GET['code'])) {
        $conn = new mysqli("localhost", "root", "", "yourbooks_db");
        $code = $conn->real_escape_string($_GET['code']); // Security

        $res = $conn->query("SELECT * FROM orders WHERE order_code='$code'");

        if ($res->num_rows > 0) {
            $row = $res->fetch_assoc();
            echo "<div class='result'>";
            echo "<h3>Status for Order Code <b>$code</b>:</h3>";
            echo "<p><strong>Status:</strong> {$row['status']}</p>";
            echo "<p><strong>Book:</strong> {$row['book_title']} (₹{$row['price']})</p>";
            echo "<p><strong>Buyer:</strong> {$row['buyer_name']}, {$row['address']}</p>";
            echo "</div>";
        } else {
            echo "<p class='not-found'>No order found with code <b>$code</b></p>";
        }

        $conn->close();
    }
    ?>

    <a href="index.php" class="back-home">← Back to Home</a>
</div>

</body>
</html>
