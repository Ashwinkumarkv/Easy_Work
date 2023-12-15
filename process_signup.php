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

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
  // Retrieve form data
  $first_name = $_POST['first_name'];
  $last_name = $_POST['last_name'];
  $email = $_POST['email'];
  $password = $_POST['password'];
  $mobile_number = $_POST['mobile_number'];
  $location = $_POST['location'];
  $user_type = $_POST['user_type'];

  // Generate a unique user ID
  $user_id = uniqid();

  // Hash the password
  //$hashed_password = password_hash($password, PASSWORD_DEFAULT);

  // Check the user type and store data accordingly
  if ($user_type == 'service_provider') {
    $company_name = $_POST['company_name'];
    $service_name = $_POST['service_type'];
    $working_start_time = $_POST['working_start_time'];
    $working_end_time = $_POST['working_end_time'];
    $about_me = $_POST['about_me'];
    $experience = $_POST['experience'];
    $minimum_charge = $_POST['minimum_charge'];
    
    // Handle image upload
    $target_dir = "uploads/";
    $target_file = $target_dir . basename($_FILES["image"]["name"]);
    $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
    
    // Check if the file is an actual image
    $check = getimagesize($_FILES["image"]["tmp_name"]);
    if ($check !== false) {
      // Move the uploaded file to the target directory
      if (move_uploaded_file($_FILES["image"]["tmp_name"], $target_file)) {
        // Insert data into service_providers table
        $query = "INSERT INTO service_providers (user_id, first_name, last_name, email, password, mobile_number, location, company_name, service_name, working_start_time, working_end_time, about_me, experience, minimum_charge, image) 
                  VALUES ('$user_id', '$first_name', '$last_name', '$email', '$hashed_password', '$mobile_number', '$location', '$company_name', '$service_name', '$working_start_time', '$working_end_time', '$about_me', '$experience', '$minimum_charge', '$target_file')";
        
        if (mysqli_query($connection, $query)) {
          // Success message
          echo "Thank you for signing up!";
        } else {
          // Error message
          echo "Sorry, an error occurred. Please try again later.";
        }
      } else {
        // Error message if file upload failed
        echo "Sorry, there was an error uploading your image.";
      }
    } else {
      // Error message if the file is not an image
      echo "Please upload a valid image file.";
    }
  } else {
    // Insert data into users table
    $query = "INSERT INTO users (user_id, first_name, last_name, email, password, mobile_number, location) 
              VALUES ('$user_id', '$first_name', '$last_name', '$email', '$password', '$mobile_number', '$location')";
    
    if (mysqli_query($connection, $query)) {
      // Success message
      echo "Thank you for signing up!";
    } else {
      // Error message
      echo "Sorry, an error occurred. Please try again later.";
    }
  }
}

// Close the database connection
mysqli_close($connection);
?>
