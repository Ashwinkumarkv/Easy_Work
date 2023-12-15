<?php
session_start();

// Check if the form is submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

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

    // Get values from the form
    $ticket_no = $_POST['ticket_no'];
    $reply = $_POST['reply'];

    // Update data in feedback table
    $feedbackQuery = "UPDATE contacts SET reply = '$reply' WHERE ticket_no = $ticket_no";

    if (mysqli_query($connection, $feedbackQuery)) {
        header("Location: testing.php");}
    mysqli_close($connection);
} else {
    // Handle the case where the form is not submitted
    echo "Form not submitted.";
}
?>
