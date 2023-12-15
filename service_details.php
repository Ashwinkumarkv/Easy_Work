<!DOCTYPE html>
<html>
<head>
  <title>Service Details</title>
  <style>
    body {
      font-family: Arial, sans-serif;
      background-color: black;
      margin: 0;
      padding: 0;
      display: flex;
      align-items: center;
      justify-content: center;
      min-height: 100vh;
    }

    .service-card {
      background-color: #c10e0e;
      padding: 20px;
      margin-bottom: 20px;
      border-radius: 10px;
      flex-basis: calc(33.33% - 20px);
      box-sizing: border-box;
      position: relative;
      overflow: hidden;
      animation: pop-up 0.5s ease forwards;
      height: 100vh;

    }

    @keyframes pop-up {
      0% {
        transform: scale(0);
        opacity: 0;
      }
      100% {
        transform: scale(1);
        opacity: 1;
      }
    }

    .service-card h2{
      margin-top: 0;
      color: #fff;
      font-family: "Arial", sans-serif;
      font-weight: bold;
      text-align: center;
    }
    .service-card h1{
      margin-top: 0;
      color: #fff;
      font-family: "Arial", sans-serif;
      font-weight: bold;
      text-align: center;
      color: #ccc;
    }
    .service-card p {
      margin-bottom: 10px;
      font-family: unset;
      font-weight: bolder;
      font-size: larger;
      color: #ccc;
    }

    .service-card img {
      display: block;
      margin: 0 auto;
      width: 200px;
      height: 200px;
      border-radius: 50%;
    }
  </style>
</head>
<body>
  <div class="service-card">
    <?php
    // Assuming you have already set up a database connection

    // Get the selected service provider details from the database
    $serviceProviderId = $_GET['service_provider_id'];
    // Query the database to retrieve the service provider details
    // Modify this query according to your database structure
    $query = "SELECT * FROM service_providers WHERE service_provider_id = $serviceProviderId";
    $result = mysqli_query($connection, $query);

    if (mysqli_num_rows($result) > 0) {
      $serviceProvider = mysqli_fetch_assoc($result);
      ?>
      
      <img src="<?php echo $serviceProvider['image']; ?>" alt="Profile Image">
      <h2><?php echo $serviceProvider['first_name'] . " " . $serviceProvider['last_name']; ?></h2>
      <h1><?php echo $serviceProvider['company_name']; ?></h1>
      <p>Email:<?php echo $serviceProvider['email']; ?></p>
      <p>Mobile Number: <?php echo $serviceProvider['mobile_number']; ?></p>
      <p>Location: <?php echo $serviceProvider['location']; ?></p>
      
      <p>Service Name: <?php echo $serviceProvider['service_name']; ?></p>
      <p>Working Hours: <?php echo $serviceProvider['working_start_time'] . " - " . $serviceProvider['working_end_time']; ?></p>
      <p>About Me: <?php echo $serviceProvider['about_me']; ?></p>
      <p>Experience: <?php echo $serviceProvider['experience']; ?></p>
      <p>Minimum Charge: <?php echo $serviceProvider['minimum_charge']; ?></p>
      <?php
    } else {
      echo "No service provider found.";
    }

    // Close the database connection
    mysqli_close($connection);
    ?>
  </div>
</body>
</html>
