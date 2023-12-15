<?php
// Start the session before any output
session_start();

?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Booking</title>
  <style>
    body {
      background-color: black;
      margin: 0;
      padding: 0;
    }

    #left-frame {
      flex: 1 1 60%;
      background-color: black;
    }

    #right-frame {
      flex: 1 1 40%;
      background-color: black;
      width: 100vh;
      height: 100vh;
    }
  </style>
</head>

<body style="background-color: black;">
  <?php
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

  // Get the selected service provider details from the database
  $serviceProviderId = $_GET['service_provider_id'];
  $query = "SELECT * FROM service_providers WHERE service_provider_id = $serviceProviderId";
  $result = mysqli_query($connection, $query);
  $serviceProvider = mysqli_fetch_assoc($result);
  ?>

  <div id="left-frame">
    <?php include('service_details.php'); ?> <!-- its not testing.php instead its service_details.php -->
  </div>

  <div id="right-frame">
    <?php include('booking_form.php'); ?> 
  </div>



</body>

</html>
