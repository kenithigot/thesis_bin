<?php
session_start();

// Connection variables
$hostname = 'localhost';
$username = 'root';
$password = '';
$database = 'thesis';

// Connect to MySQL database
$connection = new mysqli($hostname, $username, $password, $database);
if ($connection->connect_error) {
    die("Connection failed: " . $connection->connect_error);
}

// Retrieve user input
$email = $_POST['email_address'];
$password = $_POST['password'];

// Prepare the SQL statement
$stmt = $connection->prepare("SELECT * FROM thesis_trial WHERE email_address = ?");
$stmt->bind_param("s", $email);
$stmt->execute();
$result = $stmt->get_result();

// Check if the user exists
if ($result->num_rows === 1) {
    $user = $result->fetch_assoc();
    
    // Verify the password
    if ($password === $user['password']) {
        // Login successful
        $_SESSION['success_message'] = "Login successful!";
        header("Location: index.html"); // Redirect to success page if login is successful
        exit();
    } else {
        // Incorrect password
        $_SESSION['error_message'] = "Incorrect password!";
        header("Location: signin.php"); // Redirect back to the sign-in page
        exit();
    }
} else {
    // User not found
    $_SESSION['error_message'] = "User not found!";
    header("Location: signin.php"); // Redirect back to the sign-in page
    exit();
}

// Close the database connection
$stmt->close();
$connection->close();
?>
