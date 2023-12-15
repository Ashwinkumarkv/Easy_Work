<?php
// Assuming you have already set up a database connection

// Retrieve the form data
$serviceProviderId = $_POST['service_provider_id'];
$name = $_POST['name'];
$email = $_POST['email'];
$phone = $_POST['phone'];
$date = $_POST['date'];
$time = $_POST['time'];

// Perform the necessary operations with the form data
// ... (e.g., store the booking information in the database)

// Close the database connection
mysqli_close($connection);
?>
