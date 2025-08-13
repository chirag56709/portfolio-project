<?php
// contact_process.php

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "chirag_portfolio";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: Please try again later.");
}

function test_input($data) {
    return htmlspecialchars(stripslashes(trim($data)));
}

$name = test_input($_POST['name'] ?? '');
$email = test_input($_POST['email'] ?? '');
$message = test_input($_POST['message'] ?? '');

if (empty($name) || empty($email) || empty($message)) {
    die("Please fill all the required fields.");
}

if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    die("Invalid email format.");
}

$stmt = $conn->prepare("INSERT INTO contact_messages (name, email, message) VALUES (?, ?, ?)");
$stmt->bind_param("sss", $name, $email, $message);

if ($stmt->execute()) {
    header("Location: contact.html?success=1");
    exit();
} else {
    echo "Error: " . $stmt->error;
}

$stmt->close();
$conn->close();
?>
