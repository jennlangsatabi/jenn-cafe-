<?php
$servername = "localhost";
$username = "root";              
$password = "jenn022004";     
$dbname = "cafe_loyalty";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("<p style='color:#AB886D; font-family: Arial, sans-serif;'>Connection failed: " . $conn->connect_error . "</p>");
}

$name = trim($_POST['name'] ?? '');
$email = trim($_POST['email'] ?? '');

if (empty($name) || empty($email)) {
    echo "<p style='color:#AB886D; font-family: Arial, sans-serif;'>Please fill in all required fields.</p>";
    exit;
}

if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    echo "<p style='color:#AB886D; font-family: Arial, sans-serif;'>Invalid email format.</p>";
    exit;
}

// Prepare and bind to prevent SQL injection
$stmt = $conn->prepare("INSERT INTO members (name, email) VALUES (?, ?)");
if ($stmt) {
    $stmt->bind_param("ss", $name, $email);

    if ($stmt->execute()) {
        echo "<p style='color:#AB886D; font-family: Arial, sans-serif;'>
                Thank you, <strong>" . htmlspecialchars($name) . "</strong>, for joining our Café Loyalty Program!
              </p>";
        echo '<p><a href="index.html" style="color:#493628; text-decoration:none;">&larr; Go back to homepage</a></p>';
    } else {
        echo "<p style='color:#AB886D; font-family: Arial, sans-serif;'>Error while saving your info. Please try again later.</p>";
    }

    $stmt->close();
} else {
    echo "<p style='color:#AB886D; font-family: Arial, sans-serif;'>Database error. Please contact the administrator.</p>";
}

$conn->close();
?>

