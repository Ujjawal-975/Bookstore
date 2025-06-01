<?php
$conn = new mysqli("localhost", "root", "", "yourbooks_db");
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$book_id = $_GET['id'];
$sql = "SELECT * FROM books WHERE id=$book_id";
$result = $conn->query($sql);
$book = $result->fetch_assoc();
?>

<!DOCTYPE html>
<html>
<head>
    <title>Buy Book - <?= htmlspecialchars($book['title']) ?></title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f6f8;
            padding: 20px;
        }

        .container {
            max-width: 600px;
            background: #fff;
            margin: 30px auto;
            padding: 30px 40px;
            border-radius: 10px;
            box-shadow: 0 4px 12px rgba(0,0,0,0.1);
        }

        h2 {
            text-align: center;
            color: #2c3e50;
            margin-bottom: 25px;
        }

        label {
            font-weight: bold;
            display: block;
            margin-top: 15px;
            color: #34495e;
        }

        input[type="text"],
        input[type="number"],
        textarea,
        select {
            width: 100%;
            padding: 10px;
            margin-top: 6px;
            border: 1px solid #ccc;
            border-radius: 6px;
            box-sizing: border-box;
        }

        textarea {
            resize: vertical;
        }

        #online_payment {
            margin-top: 15px;
            display: none;
            background: #f9f9f9;
            padding: 15px;
            border-radius: 6px;
            border: 1px solid #ddd;
        }

        button {
            margin-top: 25px;
            width: 100%;
            padding: 12px;
            background-color: #27ae60;
            border: none;
            border-radius: 6px;
            color: white;
            font-size: 16px;
            font-weight: bold;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        button:hover {
            background-color: #219150;
        }

        .readonly {
            background-color: #f0f0f0;
        }

        .qr-image {
            width: 150px;
            margin: 10px 0;
            display: block;
        }

        .highlight-box {
            margin-top: 15px;
            padding: 10px;
            background: #ecf0f1;
            border-radius: 6px;
        }
    </style>
</head>
<body>

<div class="container">
    <h2>Buy Now</h2>
    <form action="confirm_order.php" method="POST">
        <input type="hidden" name="book_id" value="<?= $book['id'] ?>">

        <label>Book Name:</label>
        <input type="text" name="book_title" value="<?= htmlspecialchars($book['title']) ?>" class="readonly" readonly>

        <label>Price (₹):</label>
        <input type="text" id="price" value="<?= $book['price'] ?>" class="readonly" readonly>

        <label>Quantity:</label>
        <input type="number" name="quantity" id="quantity" value="1" min="1" required>

        <div class="highlight-box">
            <p><strong>Delivery Charge:</strong> ₹<span id="delivery_charge">0</span></p>
            <p><strong>Total Price:</strong> ₹<span id="total_price"><?= $book['price'] ?></span></p>
        </div>

        <input type="hidden" name="price" value="<?= $book['price'] ?>">
        <input type="hidden" name="delivery_charge" id="delivery_charge_input" value="0">
        <input type="hidden" name="total_amount" id="total_amount_input" value="<?= $book['price'] ?>">

        <h3 style="margin-top:30px; color:#2c3e50;">Your Details:</h3>

        <label>Name:</label>
        <input type="text" name="buyer_name" required>

        <label>Address:</label>
        <textarea name="address" rows="4" required></textarea>

        <label>Phone:</label>
        <input type="text" name="phone" required>

        <label>Payment Type:</label>
        <select name="payment_type" id="payment_type" required>
            <option value="COD">Cash on Delivery</option>
            <option value="Online">Online</option>
        </select>

        <div id="online_payment">
            <label>Scan QR Code:</label>
            <img src="assets/qr.png" alt="QR Code" class="qr-image">

            <label>Or Use UPI ID:</label>
            <input type="text" value="yourbooks@upi" readonly class="readonly">

            <label>Enter Transaction ID:</label>
            <input type="text" name="transaction_id" id="transaction_id_field">
        </div>

        <button type="submit">Confirm Order</button>
    </form>
</div>

<script>
    const price = parseFloat(document.getElementById('price').value);
    const quantityInput = document.getElementById('quantity');
    const deliveryChargeSpan = document.getElementById('delivery_charge');
    const totalPriceSpan = document.getElementById('total_price');
    const deliveryChargeInput = document.getElementById('delivery_charge_input');
    const totalAmountInput = document.getElementById('total_amount_input');

    function updateTotal() {
        const quantity = parseInt(quantityInput.value);
        const subtotal = price * quantity;
        let deliveryCharge = 0;

        if (subtotal < 500) {
            deliveryCharge = 50;
        }

        const total = subtotal + deliveryCharge;
        deliveryChargeSpan.innerText = deliveryCharge;
        totalPriceSpan.innerText = total;
        deliveryChargeInput.value = deliveryCharge;
        totalAmountInput.value = total;
    }

    quantityInput.addEventListener('input', updateTotal);
    updateTotal(); // Initial call

    // Show/hide payment fields
    const paymentType = document.getElementById('payment_type');
    const onlinePaymentSection = document.getElementById('online_payment');
    const transactionInput = document.getElementById('transaction_id_field');

    paymentType.addEventListener('change', function () {
        if (this.value === 'Online') {
            onlinePaymentSection.style.display = 'block';
            transactionInput.required = true;
        } else {
            onlinePaymentSection.style.display = 'none';
            transactionInput.required = false;
        }
    });
</script>

</body>
</html>
