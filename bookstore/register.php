<?php
$conn = new mysqli("localhost", "root", "", "yourbooks_db");
$msg = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email'];
    $pass = $_POST['password'];
    $role = (str_ends_with($email, "@yourbook.com")) ? "admin" : "user";

    $check = $conn->query("SELECT * FROM users WHERE email='$email'");
    if ($check->num_rows > 0) {
        $msg = "User already exists!";
    } else {
        $conn->query("INSERT INTO users (email, password, role) VALUES ('$email', '$pass', '$role')");
        $msg = "Registration successful! Please login.";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Register | YourBooks</title>
    <style>
        body {
            font-family: Arial;
            background: #f4f4f4;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }
        .form-box {
            background: white;
            padding: 30px;
            box-shadow: 0 0 10px gray;
            width: 350px;
            border-radius: 8px;
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
            background: green;
            color: white;
            padding: 10px;
            border: none;
        }
        button:hover {
            background: darkgreen;
        }
        .msg {
            color: red;
            text-align: center;
        }
    </style>
</head>
<body>
<div class="form-box">
    <h2>Register</h2>
    <form method="post" onsubmit="return validate()">
        <input type="email" name="email" id="email" placeholder="Enter Email" required>
        <input type="password" name="password" id="password" placeholder="Enter Password" required>
        <button type="submit">Register</button>
        <p class="msg"><?php echo $msg; ?></p>
        <p style="text-align:center">Already have an account? <a href="login.php">Login</a></p>
		<p style="text-align:center">Back to  <a href="index.php">Home</a></p>
    </form>
</div>

<script>
    function validate() {
        const email = document.getElementById("email").value;
        if (!email.includes("@")) {
            alert("Please enter a valid email");
            return false;
        }
        return true;
    }
</script>
</body>
</html>
