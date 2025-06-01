<?php


$conn = new mysqli("localhost", "root", "", "yourbooks_db");
$result = $conn->query("SELECT * FROM orders ORDER BY id DESC");
?>
<!DOCTYPE html>
<html>
<head>
    <title>Admin Panel - Orders</title>
    <style>
        body {
            font-family: 'Segoe UI', sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f0f2f5;
        }

        .navbar {
            background-color: #2c3e50;
            padding: 15px 30px;
            color: white;
            font-size: 20px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .navbar a {
            color: #ecf0f1;
            margin-left: 20px;
            text-decoration: none;
        }

        .container {
            padding: 30px;
        }

        h2 {
            color: #2c3e50;
            text-align: center;
            margin-bottom: 25px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            background-color: white;
            box-shadow: 0 2px 8px rgba(0,0,0,0.1);
        }

        th, td {
            padding: 12px 15px;
            border: 1px solid #ddd;
            text-align: center;
        }

        th {
            background-color: #3498db;
            color: white;
        }

        select, button {
            padding: 6px 10px;
            border: 1px solid #ccc;
            border-radius: 4px;
        }

        button {
            background-color: #2ecc71;
            color: white;
            cursor: pointer;
        }

        button:hover {
            background-color: #27ae60;
        }

        .logout-btn {
            background-color: #e74c3c;
            padding: 8px 15px;
            color: white;
            border-radius: 4px;
            text-decoration: none;
        }

        .logout-btn:hover {
            background-color: #c0392b;
        }
    </style>
</head>
<body>

<div class="navbar">
    <div>Admin Panel</div>
    <div>
        <a href="admin.php">Dashboard</a>
		
        <a href="logout.php" class="logout-btn">Logout</a>
    </div>
</div>

<div class="container">
    <h2>All Orders</h2>
    <table>
        <tr>
            <th>Order Code</th>
            <th>Book</th>
            <th>Buyer</th>
            <th>Phone</th>
            <th>Payment</th>
            <th>Status</th>
            <th>Action</th>
        </tr>
        <?php while($row = $result->fetch_assoc()): ?>
        <tr>
            <td><?= $row['order_code'] ?></td>
            <td><?= htmlspecialchars($row['book_title']) ?> (₹<?= $row['price'] ?>)</td>
            <td><?= htmlspecialchars($row['buyer_name']) ?>, <?= htmlspecialchars($row['address']) ?></td>
            <td><?= $row['phone'] ?></td>
            <td><?= $row['payment_type'] ?><?= $row['transaction_id'] ? ' - ' . htmlspecialchars($row['transaction_id']) : '' ?></td>
            <td><?= $row['status'] ?></td>
            <td>
                <form method="POST" action="update_status.php">
                    <input type="hidden" name="order_id" value="<?= $row['id'] ?>">
                    <select name="status">
                        <option<?= $row['status'] == 'Pending' ? ' selected' : '' ?>>Pending</option>
                        <option<?= $row['status'] == 'Accepted' ? ' selected' : '' ?>>Accepted</option>
                        <option<?= $row['status'] == 'Out for Delivery' ? ' selected' : '' ?>>Out for Delivery</option>
                        <option<?= $row['status'] == 'Delivered' ? ' selected' : '' ?>>Delivered</option>
                        <option<?= $row['status'] == 'Rejected' ? ' selected' : '' ?>>Rejected</option>
                    </select>
                    <button type="submit">Update</button>
                </form>
            </td>
        </tr>
        <?php endwhile; ?>
    </table>
</div>

</body>
</html>
