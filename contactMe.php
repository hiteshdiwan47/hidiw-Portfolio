<?php
$connection = mysqli_connect("localhost", "root", "", "myportfolio");

if (!$connection) {
    die("Database connection failed: " . mysqli_connect_error());
}

$success = "";
$error = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = trim($_POST['name']);
    $email = trim($_POST['email']);
    $phone = trim($_POST['Phone']);
    $message = trim($_POST['message']);

    if (empty($name) || empty($email) || empty($message)) {
        $error = "Please fill in all required fields.";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error = "Please enter a valid email address.";
    } else {
        $stmt = mysqli_prepare($connection, "INSERT INTO contact (name, email, phone, message) VALUES (?, ?, ?, ?)");
        mysqli_stmt_bind_param($stmt, "ssss", $name, $email, $phone, $message);

        if (mysqli_stmt_execute($stmt)) {
            $success = "✅ Your message has been sent successfully!";
        } else {
            $error = "❌ Something went wrong. Please try again.";
        }

        mysqli_stmt_close($stmt);
    }
}

mysqli_close($connection);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Contact Form</title>
    <style>
        body {font-family: Arial; background: #f4f4f4; display:flex;justify-content:center;align-items:center;height:100vh;}
        .box {background:#fff; padding:20px 30px; border-radius:10px; box-shadow:0 0 10px rgba(0,0,0,0.1);}
        input, textarea {width:100%; margin:10px 0; padding:10px;}
        .btn {background:#007bff; color:white; border:none; padding:10px; cursor:pointer;}
        .msg {text-align:center; font-weight:bold;}
        .success{color:green;}
        .error{color:red;}
    </style>
</head>
<body>

<div class="box">
    <h2>Contact Form</h2>

    <?php if ($success): ?>
        <p class="msg success"><?php echo $success; ?></p>
    <?php elseif ($error): ?>
        <p class="msg error"><?php echo $error; ?></p>
    <?php endif; ?>

    <form action="contactMe1.php" method="POST">
        <input type="text" name="name" placeholder="Your Name">
        <input type="text" name="email" placeholder="Your Email">
        <input type="text" name="Phone" placeholder="Your Phone">
        <textarea name="message" placeholder="Your Message"></textarea>
        <button class="btn" type="submit">Send Message</button>
    </form>
</div>

</body>
</html>
