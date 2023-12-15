<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Service Provider Page</title>
  <style>
    body {
      font-family: Arial, sans-serif;
      background-color: #f2f2f2;
      color: #333;
    }
    
    h1,
    h2 {
      color: #0077b5;
    }
    
    table {
      width: 100%;
      border-collapse: collapse;
      margin: 25px 0;
    }
    
    table,
    th,
    td {
      border: 1px solid #ccc;
    }
    
    th,
    td {
      padding: 15px;
      text-align: left;
    }
    
    th {
      background-color: #0077b5;
      color: #fff;
    }
    
    tr:nth-child(even) {
      background-color: #f2f2f2;
    }
  </style>
</head>
<body>
  <h1>Welcome, Service Provider!</h1>
  
  <?php
  session_start(); // Start the session (make sure to call this at the beginning of your script)

  if (isset($_SESSION)) {
      echo "<h2>Session Data:</h2>";
      echo "<pre>";
      print_r($_SESSION); // Print the entire session array
      echo "</pre>";
  } else {
      echo "Session data not found.";
  }

  // Assuming you have a database connection and a valid session
  // ...

  $servername = "localhost";
  $username = "root";
  $password = "";
  $dbname = "work";

  $connection = mysqli_connect($servername, $username, $password, $dbname);
  // Get the service provider's ID from the session
  $serviceProviderId = $_SESSION['service_provider_id']; // Replace with the actual session variable name

  // Query to retrieve incomplete bookings for the service provider
  $bookingsQuery = "SELECT * FROM bookings WHERE service_provider_id = $serviceProviderId AND order_status = 'incomplete'";

  // Execute the query
  $result = mysqli_query($connection, $bookingsQuery);

  if ($result) {
      echo "<h2>Booking Details:</h2>";
      echo "<table>";
      echo "<tr><th>User ID</th><th>Booking ID</th><th>User Name</th><th>User Email</th><th>Booking Time</th></tr>";

      while ($row = mysqli_fetch_assoc($result)) {
          $userId = $row['users_id'];
          $bookingId = $row['booking_id'];
          $bookingTime = $row['booking_time'];

          // Query to retrieve user details
          $userQuery = "SELECT * FROM users WHERE user_id = $userId";
          $userResult = mysqli_query($connection, $userQuery);
          
          if ($userResult) {
              $userData = mysqli_fetch_assoc($userResult);

              echo "<tr>";
              echo "<td>" . $userData['user_id'] . "</td>";
              echo "<td>" . $bookingId . "</td>";
              echo "<td>" . $userData['first_name'] . " " . $userData['last_name'] . "</td>";
              echo "<td>" . $userData['email'] . "</td>";
              echo "<td>" . $bookingTime . "</td>";
              echo "</tr>";

              // Free the user result set
              mysqli_free_result($userResult);
          } else {
              echo "Error: " . $userQuery . "<br>" . mysqli_error($connection);
          }
      }

      echo "</table>";

      // Free the booking result set
      mysqli_free_result($result);
  } else {
      echo "Error: " . $bookingsQuery . "<br>" . mysqli_error($connection);
  }

  // Close the database connection
  mysqli_close($connection);
  ?>
</body>
</html>
