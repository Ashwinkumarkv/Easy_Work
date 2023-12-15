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
    $feeds_id = $_POST['feeds_id'];
    $reply = $_POST['reply'];

    // Update data in feedback table
    $feedbackQuery = "UPDATE feedback SET reply = '$reply' WHERE feeds_id = $feeds_id";

    if (mysqli_query($connection, $feedbackQuery)) {
        // Fetch user's email based on feeds_id
        $getUserEmailQuery = "SELECT u.email
                              FROM users u
                              INNER JOIN feedback f ON u.user_id = f.users_id
                              WHERE f.feeds_id = $feeds_id";

        $userEmailResult = mysqli_query($connection, $getUserEmailQuery);

        if ($userEmailResult) {
            $userData = mysqli_fetch_assoc($userEmailResult);
            $userEmail = $userData['email']; // This will contain the user's email associated with the feedback entry

            // Send an email notification to the user
            $to = $userEmail;
            $subject = 'Feedback Update Alert';
            $message = 'Your feedback has been updated successfully!'; // You can customize the message
            $headers = 'From: elijahbino2@gmail.com'; // Replace with your email address

            // Send the email
            if (mail($to, $subject, $message, $headers)) {
                $_SESSION['alert_message'] = 'Alert sent to the user via email.';
                // Redirect to pending_order.php or any other desired page
                header("Location: admin_feedback.php");
                exit();
            } else {
                $_SESSION['alert_message'] = 'Error sending alert via email.';
                header("Location: admin_feedback.php");
                exit();
            }
        } else {
            $_SESSION['alert_message'] = 'Error fetching user email.';
            header("Location: admin_feedback.php");
            exit();
        }
    } else {
        echo "Error updating feedback: " . mysqli_error($connection);
    }

    // Close the database connection
    mysqli_close($connection);
} else {
    // Handle the case where the form is not submitted
    echo "Form not submitted.";
}
?>
