<?php
$hostname = 'localhost';
$username = 'root';
$db_password = '';
$database = 'thesis';

// Create connection
$conn = new mysqli($hostname, $username, $db_password, $database);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$email = isset($_POST['email']) ? $_POST['email'] : '';
$password = isset($_POST['password']) ? $_POST['password'] : '';

$loginStatus = null;

if (!empty($email) && !empty($password)) {
    // SQL query to check if the email and password exist in the database
    $sql = "SELECT * FROM thesis_trial WHERE email_address='$email' AND password='$password'";
    $result = $conn->query($sql);

    if ($result->num_rows == 0) {
        // Login failed
        // Set the flag variable to indicate the login failure
        $loginStatus = false;
    } else {
        // Login successful
        // Redirect the user to the next page
        header("Location: overview.php");
        exit();
    }
}

$conn->close();
?>