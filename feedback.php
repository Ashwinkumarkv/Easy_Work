<html>
  <head>
    <style>
      
    </style>
  </head>





<div class="feedback">
      <h2>Feedbacks</h2>
        <?php
        // Query to retrieve feedbacks for the service provider
        $feedbackQuery = "SELECT * FROM feedback WHERE service_provider_id = $serviceProviderId";
        $feedbackResult = mysqli_query($connection, $feedbackQuery);

        if ($feedbackResult) {
            if (mysqli_num_rows($feedbackResult) > 0) {
                while ($feedback = mysqli_fetch_assoc($feedbackResult)) {
                    ?>
                    <p>User ID: <?php echo $feedback['users_id']; ?></p>
                    <p>Booking ID: <?php echo $feedback['booking_id']; ?></p>
                    <p>Feedback: <?php echo $feedback['feeds']; ?></p>
                    <!-- You can display other feedback details as needed -->
                    <?php
                }
            } else {
                echo "<p>No feedback available.</p>";
            }
        } else {
            echo "Error retrieving feedback: " . mysqli_error($connection);
        }
        ?>
      </div>
</html>