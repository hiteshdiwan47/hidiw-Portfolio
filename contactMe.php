<?php
// Database connection
$connection = mysqli_connect("localhost", "root", "", "myportfolio");

if (!$connection) {
    die("Database connection failed: " . mysqli_connect_error());
}

// Check if form submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = mysqli_real_escape_string($connection, $_POST['name']);
    $email = mysqli_real_escape_string($connection, $_POST['email']);
    $phone = mysqli_real_escape_string($connection, $_POST['phone']);
    $message = mysqli_real_escape_string($connection, $_POST['message']);

    // Insert query
    $query = "INSERT INTO contact (name, email, phone, message)
              VALUES ('$name', '$email', '$phone', '$message')";

    if (mysqli_query($connection, $query)) {
        echo "<script>alert('Message sent successfully!'); window.location.href='index.html';</script>";
    } else {
        echo "Error: " . mysqli_error($connection);
    }
}

mysqli_close($connection);
?>
