<?php
// Contact form PHP processing
$success = '';
$error = '';

// Connect to database
$conn = new mysqli("localhost", "root", "", "yourbooks_db");
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = htmlspecialchars(trim($_POST["name"]));
    $email = htmlspecialchars(trim($_POST["email"]));
    $message = htmlspecialchars(trim($_POST["message"]));

    if (!empty($name) && !empty($email) && !empty($message)) {
        $stmt = $conn->prepare("INSERT INTO contact_messages (name, email, message) VALUES (?, ?, ?)");
        $stmt->bind_param("sss", $name, $email, $message);
        if ($stmt->execute()) {
            $success = "Thank you! Your message has been sent.";
        } else {
            $error = "Something went wrong. Please try again later.";
        }
        $stmt->close();
    } else {
        $error = "All fields are required.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>About Us - YourBooks</title>
    <style>
        body {
            margin: 0;
            font-family: Arial, sans-serif;
            background: #f4f6f8;
            color: #2c3e50;
        }

        header {
            background-color: #34495e;
            color: white;
            padding: 20px 40px;
            text-align: center;
        }

        .container {
            max-width: 1000px;
            margin: 40px auto;
            padding: 20px 40px;
            background-color: white;
            border-radius: 10px;
            box-shadow: 0 4px 12px rgba(0,0,0,0.1);
        }

        h2 {
            color: #27ae60;
            margin-top: 0;
        }

        p {
            line-height: 1.7;
            margin: 15px 0;
        }

        .contact-section {
            margin-top: 50px;
        }

        .contact-form label {
            font-weight: bold;
            display: block;
            margin: 15px 0 5px;
        }

        .contact-form input,
        .contact-form textarea {
            width: 100%;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 6px;
            box-sizing: border-box;
        }

        .contact-form textarea {
            resize: vertical;
        }

        .contact-form button {
            margin-top: 20px;
            padding: 12px 20px;
            background-color: #27ae60;
            border: none;
            color: white;
            font-size: 16px;
            font-weight: bold;
            border-radius: 6px;
            cursor: pointer;
        }

        .contact-form button:hover {
            background-color: #219150;
        }

        .message {
            margin-top: 20px;
            padding: 12px;
            border-radius: 6px;
        }

        .success {
            background-color: #d4edda;
            color: #155724;
        }

        .error {
            background-color: #f8d7da;
            color: #721c24;
        }

        footer {
            margin-top: 40px;
            background-color: #34495e;
            color: white;
            text-align: center;
            padding: 20px;
        }

        @media (max-width: 600px) {
            .container {
                padding: 20px;
            }
        }
    </style>
</head>
<body>

<header>
    <h1>YourBooks</h1>
    <p>Your Online Bookstore for Every Reader</p>
</header>

<div class="container">
    <h2>About Us</h2>
    <p>Welcome to <strong>YourBooks</strong>, your one-stop online bookstore for all kinds of books – academic, fiction, non-fiction, competitive exams, and more.</p>

    <p>We started with a simple vision: to make book shopping easy, affordable, and accessible for everyone in India.</p>

    <p>Our mission is to connect readers with their favorite books and authors, support learning and growth, and bring the bookstore experience online with ease and trust.</p>

    <div class="contact-section">
        <h2>Contact Us</h2>
        <p>If you have any questions, suggestions, or need help, feel free to reach out using the form below:</p>

        <?php if ($success): ?>
            <div class="message success"><?= $success ?></div>
        <?php elseif ($error): ?>
            <div class="message error"><?= $error ?></div>
        <?php endif; ?>

        <form class="contact-form" action="" method="POST">
            <label>Your Name:</label>
            <input type="text" name="name" required>

            <label>Your Email:</label>
            <input type="email" name="email" required>

            <label>Message:</label>
            <textarea name="message" rows="5" required></textarea>

            <button type="submit">Send Message</button>
        </form>
    </div>
</div>

<footer>
    &copy; 2025 YourBooks. All Rights Reserved.
</footer>

</body>
</html>
