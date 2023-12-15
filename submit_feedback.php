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

    $user_id = $_SESSION['user_id'];
    // Get values from the form
    
    $service_provider_id = $_POST['service_provider_id'];
    $booking_id = $_POST['booking_id'];
    $feedback = $_POST['feedback'];
    $rating = $_POST['rating'];

    // Insert data into feedback table
    $feedbackQuery = "INSERT INTO feedback (users_id, service_provider_id, booking_id, feeds, rating) VALUES ($user_id, $service_provider_id, $booking_id, '$feedback', $rating)";

    if (mysqli_query($connection, $feedbackQuery)) {
        // Update status in service_provider table
        $updateStatusQuery = "UPDATE service_providers SET status = 'active' WHERE service_provider_id = $service_provider_id";

        if (mysqli_query($connection, $updateStatusQuery)) {
            // Update order status in bookings table
            $updateOrderStatusQuery = "UPDATE bookings SET order_status = 'complete' WHERE booking_id = $booking_id";

            if (mysqli_query($connection, $updateOrderStatusQuery)) {
                // Calculate average rating for the service provider
                $averageRatingQuery = "SELECT AVG(rating) AS avg_rating FROM feedback WHERE service_provider_id = $service_provider_id";
                $averageRatingResult = mysqli_query($connection, $averageRatingQuery);

                if ($averageRatingResult) {
                    $averageRatingData = mysqli_fetch_assoc($averageRatingResult);
                    $averageRating = $averageRatingData['avg_rating'];

                    // Update the average rating in the service_providers table
                    $updateRatingQuery = "UPDATE service_providers SET rating = $averageRating WHERE service_provider_id = $service_provider_id";

                    if (mysqli_query($connection, $updateRatingQuery)) {
                        // Redirect to temp.php
                        header("Location: pending_order.php");
                        exit(); // Ensure that the script stops executing after the redirection header
                    } else {
                        echo "Error updating service provider rating: " . mysqli_error($connection);
                    }
                } else {
                    echo "Error calculating average rating: " . mysqli_error($connection);
                }
            } else {
                echo "Error updating order status: " . mysqli_error($connection);
            }
        } else {
            echo "Error updating service provider status: " . mysqli_error($connection);
        }
    } else {
        echo "Error submitting feedback: " . mysqli_error($connection);
    }

    // Close the database connection
    mysqli_close($connection);
} else {
    // Handle the case where the form is not submitted
    echo "Form not submitted.";
}
?>
