<?php
$conn = new mysqli("localhost", "root", "", "yourbooks_db");
$id = $_POST['order_id'];
$status = $_POST['status'];

$conn->query("UPDATE orders SET status='$status' WHERE id=$id");
header("Location: admin_orders.php");
?>
