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
    $phone = trim($_POST['phone']);
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

