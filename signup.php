<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Signup</title>
  <style>
    body {
      background-color: #141e30;
      color: white;
      margin: 0;
      font-family: sans-serif;
    }

    .container {
      max-width: 600px;
      margin: 0 auto;
    }

    .signup-form {
      position: absolute;
      top: 50%;
      left: 50%;
      width: 400px;
      padding: 40px;
      transform: translate(-50%, -50%);
      background: rgba(0, 0, 0, .5);
      box-sizing: border-box;
      box-shadow: 0 15px 25px rgba(0, 0, 0, .6);
      border-radius: 10px;
    }

    .signup-form h2 {
      margin: 0 0 30px;
      padding: 0;
      color: #fff;
      text-align: center;
    }

    .signup-form label {
      display: block;
      margin-bottom: 10px;
    }

    .signup-form input[type="text"],
    .signup-form input[type="email"],
    .signup-form input[type="password"],
    .signup-form select,
    .signup-form input[type="time"],
    .signup-form textarea,
    .signup-form input[type="number"] {
      width: 100%;
      padding: 5px;
      margin-bottom: 10px;
      border: none;
      border-bottom: 1px solid #fff;
      outline: none;
      background: transparent;
      color: #fff;
    }

    .signup-form button {
      position: relative;
      display: inline-block;
      padding: 10px 20px;
      color: #03e9f4;
      font-size: 16px;
      text-decoration: none;
      text-transform: uppercase;
      overflow: hidden;
      transition: .5s;
      margin-top: 40px;
      letter-spacing: 4px;
      background-color: transparent;
      border: 2px solid #03e9f4;
      border-radius: 5px;
      cursor: pointer;
    }

    .signup-form button:hover {
      background: #03e9f4;
      color: #fff;
      border-radius: 5px;
      box-shadow: 0 0 5px #03e9f4, 0 0 25px #03e9f4, 0 0 50px #03e9f4, 0 0 100px #03e9f4;
    }

    .signup-form .additional-fields {
      display: none;
    }

    .signup-form .additional-fields label,
    .signup-form .additional-fields input,
    .signup-form .additional-fields select {
      width: 100%;
      padding: 5px;
      margin-bottom: 10px;
    }
  </style>

  <script>
    function toggleServiceProviderFields() {
      var serviceProviderFields = document.getElementById("service_provider_fields");
      var imageField = document.getElementById("image_field");
      var customerRadio = document.getElementById("customer");

      if (customerRadio.checked) {
        serviceProviderFields.style.display = "none";
        imageField.style.display = "none";
        document.getElementById("company_name").required = false;
        document.getElementById("service_type").required = false;
      } else {
        serviceProviderFields.style.display = "block";
        imageField.style.display = "block";
        document.getElementById("company_name").required = true;
        document.getElementById("service_type").required = true;
      }
    }

  </script>
</head>
<body>
  <section class="signup-form">
    <div class="container">
      <h2>Signup</h2>
      <form action="process_signup.php" method="POST" enctype="multipart/form-data">
        <label for="first_name">First Name:</label>
        <input type="text" id="first_name" name="first_name" required>

        <label for="last_name">Last Name:</label>
        <input type="text" id="last_name" name="last_name" required>

        <label for="email">Email:</label>
        <input type="email" id="email" name="email" required>

        <label for="password">Password:</label>
        <input type="password" id="password" name="password" required>

        <label for="mobile_number">Mobile Number:</label>
        <input type="text" id="mobile_number" name="mobile_number" required>

        <label for="location">Location:</label>
        <input type="text" id="location" name="location" required>

        <label for="user_type">User Type:</label>
        <input type="radio" id="customer" name="user_type" value="customer" checked onclick="toggleServiceProviderFields()">
        <label for="customer">Customer</label>
        <input type="radio" id="service_provider" name="user_type" value="service_provider" onclick="toggleServiceProviderFields()">
        <label for="service_provider">Service Provider</label>

        <div id="service_provider_fields" style="display: none;">
          <label for="company_name">Company Name:</label>
          <input type="text" id="company_name" name="company_name">

          <label for="service_type">Service Type:</label>
          <select id="service_type" name="service_type">
            <option value="plumbing">Plumbing</option>
            <option value="electrician">Electrician</option>
            <option value="mechanic">Mechanic</option>
            <option value="car_wash">Car Wash</option>
            <option value="servant">Servant</option>
            <option value="home_nurse">Home Nurse</option>
            <option value="gardener">Gardener</option>
            <option value="carpenter">Carpenter</option>
          </select>

          <div id="image_field" style="display: none;">
            <label for="image">Image:</label>
            <input type="file" id="image" name="image">
          </div>

          <label for="working_start_time">Working Start Time:</label>
          <input type="time" id="working_start_time" name="working_start_time">

          <label for="working_end_time">Working End Time:</label>
          <input type="time" id="working_end_time" name="working_end_time">

          <label for="about_me">About Me:</label>
          <textarea id="about_me" name="about_me"></textarea>

          <label for="experience">Experience:</label>
          <input type="text" id="experience" name="experience">

          <label for="minimum_charge">Minimum Charge (in Rupees):</label>
          <input type="number" id="minimum_charge" name="minimum_charge">
        </div>

        <button type="submit">Submit</button>
      </form>
    </div>
  </section>
</body>
</html>
