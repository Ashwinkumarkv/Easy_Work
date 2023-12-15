<?php
session_start();

// Assuming you have already set up a database connection
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "work";

// Create a new connection
$connection = mysqli_connect($servername, $username, $password, $dbname);

// Check the connection
if (!$connection) {
  die("Connection failed: " . mysqli_connect_error());
}

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
  // Retrieve form data
  $email = $_POST['email'];
  $password = $_POST['password'];

  // Query the users table to check if the user exists
 $query = "SELECT * FROM users WHERE email = '$email'";
  $result = mysqli_query($connection, $query);

  if (mysqli_num_rows($result) == 1) {
    $user = mysqli_fetch_assoc($result);
    // Verify the password
    if ($user['password']) {
      // Password is correct, set session variables and redirect based on user type
      $_SESSION['user_id'] = $user['user_id'];
      $_SESSION['email'] = $user['email'];
      $_SESSION['user_type'] = 'customer';
      header("Location: services.php"); // Replace with the actual services page URL for customers
      exit();
    }
  }

  // Query the service_provider table to check if the user exists as a service provider
  $query = "SELECT * FROM service_providers WHERE email = '$email'";
  $result = mysqli_query($connection, $query);

  if (mysqli_num_rows($result) == 1) {
    $user = mysqli_fetch_assoc($result);
    // Verify the password
    if ($user['password']) {
      // Password is correct, set session variables and redirect based on user type
      $_SESSION['service_provider_id'] = $user['service_provider_id'];
      $_SESSION['email'] = $user['email'];
      $_SESSION['user_type'] = 'service_provider';
      header("Location: service_provider.php"); 
      exit();
    }
  }

  // If the user does not exist or the password is incorrect, set an error flag
  $error = true;
}

// Close the database connection
mysqli_close($connection);
?>