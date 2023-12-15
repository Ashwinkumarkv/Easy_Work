<?php
// Start the session before any output
session_start();

?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Booking Form</title>
  <style>
    body {
      font-family: Arial, sans-serif;
      background-color: #f2f2f2;
      margin: 0;
      padding: 20px;
    }

    .container {
      max-width: 400px;
      margin-top: 15px;
      margin-left: 30px;
      background-color: #fff;
      border-radius: 8px;
      box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
      padding: 20px;
    }

    h2 {
      color: #333;
      font-size: 24px;
      margin-bottom: 20px;
    }

    label {
      display: block;
      margin-bottom: 10px;
      color: #555;
    }

    input[type="text"],
    input[type="time"] {
      width: 100%;
      padding: 10px;
      border: 1px solid #ccc;
      border-radius: 4px;
      box-sizing: border-box;
      font-size: 14px;
      margin-bottom: 20px;
    }

    input[type="submit"] {
      background-color: #4CAF50;
      color: #fff;
      padding: 10px 20px;
      border: none;
      border-radius: 4px;
      cursor: pointer;
      font-size: 16px;
    }

    input[type="submit"]:hover {
      background-color: #45a049;
    }
  </style>
</head>

<body>


  

  <div class="container">

  <fieldset >
  <h2>Feedbacks</h2>
<?php
include('db_connection.php');

// Query to retrieve feedbacks for the service provider with user names
$feedbackQuery = "SELECT feedback.*, users.first_name 
                  FROM feedback 
                  JOIN users ON feedback.users_id = users.user_id
                  WHERE feedback.service_provider_id = $serviceProviderId";

$feedbackResult = mysqli_query($connection, $feedbackQuery);

if ($feedbackResult) {
    if (mysqli_num_rows($feedbackResult) > 0) {
        while ($feedback = mysqli_fetch_assoc($feedbackResult)) {
            ?>
            <h4 style="color:green"><?php echo $feedback['first_name']; ?></h4>
            <p><?php echo $feedback['feeds']; ?></p>
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
</fieldset>


    <h2>Booking Form</h2>

    <?php
    // Check if the form is submitted
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
      // Get the form data
      $serviceProviderId = $_POST['service_provider_id'];
      $selectedTime = $_POST['time'];

      //session_start();
      $userId =  $_SESSION['user_id']; // Replace with the actual user ID, you can retrieve it from your session

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

      // Query the service provider's working hours
      $workingHoursQuery = "SELECT working_start_time, working_end_time FROM service_providers WHERE service_provider_id = $serviceProviderId";
      $workingHoursResult = mysqli_query($connection, $workingHoursQuery);

      if ($workingHoursResult) {
        $workingHoursData = mysqli_fetch_assoc($workingHoursResult);
        $workingStartTime = $workingHoursData['working_start_time'];
        $workingEndTime = $workingHoursData['working_end_time'];

        // Check if the selected time is within working hours
        if (strtotime($selectedTime) >= strtotime($workingStartTime) && strtotime($selectedTime) <= strtotime($workingEndTime)) {
            // Insert the booking into the database
            $queryInsertBooking = "INSERT INTO bookings (service_provider_id, booking_time, users_id) VALUES ($serviceProviderId, '$selectedTime', $userId)";
            
            if (mysqli_query($connection, $queryInsertBooking)) {
              // Update the status of the service provider to "inactive"
              $queryUpdateStatus = "UPDATE service_providers SET status = 'inactive' WHERE service_provider_id = $serviceProviderId";
              
              if (mysqli_query($connection, $queryUpdateStatus)) {
                echo "<p>Thank you for your booking!</p>";
              } else {
                echo "Error updating service provider status: " . mysqli_error($connection);
              }
            } else {
              echo "Error inserting booking: " . mysqli_error($connection);
            }
          } else {
            echo "<p>The selected time is not within the working hours of the service provider.</p>";
          }

      // Close the database connection
      mysqli_close($connection);
    }
    }
    ?>

    <form action="#" method="post">
      <input type="hidden" name="service_provider_id" value="<?php echo $serviceProviderId; ?>">
      
      <label for="time">Select Time:</label>
      <input type="time" id="time" name="time" required placeholder="Please choose within the working hours">
      
      <input type="submit" value="Submit">
    </form>
  </div>
</body>
</html>
