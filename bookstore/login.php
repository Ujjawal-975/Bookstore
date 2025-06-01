<?php
session_start();
$conn = new mysqli("localhost", "root", "", "yourbooks_db");
$msg = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email'];
    $pass = $_POST['password'];

    $res = $conn->query("SELECT * FROM users WHERE email='$email' AND password='$pass'");
    if ($res->num_rows > 0) {
        $user = $res->fetch_assoc();
        $_SESSION['user'] = $user['email'];
        $_SESSION['role'] = $user['role'];

        if ($user['role'] == "admin") {
            header("Location: admin.php");
        } else {
            header("Location: index.php");
        }
    } else {
        $msg = "Invalid login details!";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Login | YourBooks</title>
    <style>
        body {
            font-family: Arial;
            background: #e3e3e3;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }
        .form-box {
            background: white;
            padding: 30px;
            width: 350px;
            border-radius: 10px;
            box-shadow: 0 0 10px gray;
        }
        h2 {
            text-align: center;
        }
        input {
            width: 100%;
            margin: 10px 0;
            padding: 10px;
        }
        button {
            width: 100%;
            background: #2980b9;
            color: white;
            padding: 10px;
            border: none;
        }
        button:hover {
            background: #1f618d;
        }
        .msg {
            color: red;
            text-align: center;
        }
    </style>
</head>
<body>
<div class="form-box">
    <h2>Login</h2>
    <form method="post">
        <input type="email" name="email" placeholder="Enter Email" required>
        <input type="password" name="password" placeholder="Enter Password" required>
        <button type="submit">Login</button>
        <p class="msg"><?php echo $msg; ?></p>
        <p style="text-align:center">No account? <a href="register.php">Register</a></p>
		<p style="text-align:center">Back to  <a href="index.php">Home</a></p>
    </form>
</div>
</body>
</html>
