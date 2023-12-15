<?php
// Start the session before any output
session_start();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <!-- Your meta tags and title here -->
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f8f8f8;
            margin: 0;
            padding: 0;
            display: flex;
        }

        .sidebar {
            width: 10%; /* 10% width */
            min-width: 160px;
            height: 100vh; /* Full height of the viewport */
            background-color: #4B0082;
            padding-top: 20px;
            display: flex;
            flex-direction: column;
            align-items: center;
            position: relative; /* Added position */
        }

        .content {
            width: 90%; /* 90% width */
            padding: 20px;
        }

        .sidebar-button {
            display: block;
            width: 100%;
            padding: 12px 0; /* Increased padding */
            text-align: center;
            color: white;
            text-decoration: none;
            background-color: transparent;
            border: none;
            cursor: pointer;
            transition: background-color 0.3s;
            font-size: 18px; /* Increased font size */
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; /* Different font */
        }

        .sidebar-button:hover,
        .sidebar-button.active {
            background-color: #555;
        }

        .menu-container {
            position: absolute;
            top: 10px;
            right: 10px; /* Add space at the right corner */
            display: inline-block;
            font-size: 24px;
            cursor: pointer;
        }

        .dropdown {
            position: relative;
            display: inline-block; /* Keep the dropdown inline */
            margin-bottom: 10px; /* Add space below the dropdown */
        }

        .menu-icon {
            color: white; /* Change to white */
            font-size: 24px; /* Adjust the size as needed */
            margin-bottom: 10px; /* Add space below the icon */
        }

        .dropdown-content {
            display: none;
            position: absolute;
            background-color: #f9f9f9;
            min-width: 160px;
            box-shadow: 0px 8px 16px 0px rgba(0, 0, 0, 0.2);
            z-index: 1;
            font-family: 'Inter', sans-serif;
            font-size: 14px;
            border-radius: 5px;
            right: 0; /* Position to the right */
        }

        .dropdown:hover .dropdown-content {
            display: block;
        }

        .dropdown-content a {
            color: black;
            padding: 12px 16px;
            text-decoration: none;
            display: block;
        }

        .dropdown-content a:hover {
            background-color: #ddd;
        }

        /* Style for the user box */
        .user-box {
            display: flex;
            flex-direction: column; /* Display items in a column */
            background-color: #fff;
            padding: 20px; /* Increased padding */
            border-radius: 10px;
            margin-bottom: 20px;
            align-items: left; /* Center items horizontally */
        }

        /* Style for the user image */
        .user-image {
            width: 120px; /* Increased size */
            height: 120px; /* Increased size */
            border-radius: 50%;
            object-fit: cover;
            margin-bottom: 20px; /* Add space below the image */
        }

        /* Style for the user details */
        .user-details {
            display: flex;
            flex-direction: column;
            align-items: left; /* Center items horizontally */
        }

        /* Style for the labels */
        .label {
            font-size: 14px;
            color: #999;
        }

        /* Style for the username */
        .username {
            font-size: 24px; /* Increased size */
            color: #4B0082;
            margin-bottom: 10px; /* Add space below the username */
        }

        /* Style for the email */
        .email {
            font-size: 18px; /* Increased size */
            color: #555;
        }

        /* Rest of your styles */

        /* Style for the box containing the table */
        .table-box {
            background-color: #fff;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            margin-bottom: 20px;
        }

        /* Style for the table */
        .styled-table {
            width: 100%;
            border-collapse: collapse;
            font-size: 16px;
        }

        .styled-table th,
        .styled-table td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }

        .styled-table th {
            background-color: #f2f2f2;
            font-size: 18px;
        }

        /* Style for the feedback form */
        .feedback-form {
            display: none;
            background-color: #fff;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            margin-bottom: 20px;
        }

        .feedback-form label {
            display: block;
            margin-bottom: 10px;
            color: #555;
        }

        .feedback-form textarea {
            width: 100%;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 4px;
            box-sizing: border-box;
            font-size: 14px;
            margin-bottom: 20px;
        }

        .feedback-form input[type="submit"] {
            background-color: #4CAF50;
            color: #fff;
            padding: 10px 20px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-size: 16px;
        }

        .feedback-form input[type="submit"]:hover {
            background-color: #45a049;
        }

        .feedback-form {
            display: none; /* Initially hide the form */
            margin-top: 20px; /* Add some space between the button and form */
        }

        .feedback-input {
            width: 100%;
            padding: 10px;
            margin-bottom: 10px;
        }

        .submit-feedback {
            background-color: #4CAF50;
            color: #fff;
            padding: 10px 20px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-size: 16px;
        }

        .submit-feedback:hover {
            background-color: #45a049;
        }
    </style>
</head>

<body>
    <div class="sidebar">
        <!-- Your sidebar menu here -->
        <a class="sidebar-button" href="#">Feedbacks</a>
        <a class="sidebar-button" href="#">Messages</a>
        <a class="sidebar-button" href="#">Service_provider_performance_Checker</a>
    </div>

    <div class="content">
        <?php
        // Your PHP code for fetching data and other configurations
        $servername = "localhost";
        $username = "root";
        $password = "";
        $dbname = "work";

        $conn = mysqli_connect($servername, $username, $password, $dbname);

        if (isset($_SESSION)) {
            echo "<h2>Session Data:</h2>";
            echo "<pre>";
            print_r($_SESSION); // Print the entire session array
            echo "</pre>";
        } else {
            echo "Session data not found.";
        }
        ?>

        <!-- Display the table inside a box -->
        <div class="table-box">
            <table class="styled-table">
                <tr>
                    <!-- Your table headers -->
                    <th>Service Provider Name</th>
                    <th>Service Provider Email</th>
                    <th>Service Provider Mobile Number</th>
                    <th>Service Name</th>
                    <th>Feeds</th>
                    <th>Action</th>
                </tr>
                <?php
                // Counter variable to create unique IDs for feedback forms
                $counter = 0;

                // Your SQL query to fetch data and loop through rows
                $sql = "SELECT 
                            sp.service_provider_id,
                            sp.first_name AS service_provider_name, 
                            sp.email AS service_provider_email, 
                            sp.mobile_number AS service_provider_mobile_number, 
                            sp.service_name, 
                            sp.minimum_charge, 
                            f.feeds_id,
                            f.feeds 
                        FROM feedback AS f
                        INNER JOIN service_providers AS sp ON f.service_provider_id = sp.service_provider_id
                        WHERE f.reply IS NULL ";

                $stmt = $conn->prepare($sql);
                $stmt->execute();
                $result = $stmt->get_result();

                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        // Increment counter to create unique IDs for feedback forms
                        $counter++;
                        $feedbackFormId = "feedbackForm_" . $counter;
                ?>
                        <tr>
                            <!-- Display data in table rows -->
                            <td><?php echo $row["service_provider_name"]; ?></td>
                            <td><?php echo $row["service_provider_email"]; ?></td>
                            <td><?php echo $row["service_provider_mobile_number"]; ?></td>
                            <td><?php echo $row["service_name"]; ?></td>
                            <td><?php echo $row["feeds"]; ?></td>
                            <td>
                                <button type="button" class="complete-button" onclick="toggleFeedbackForm('<?php echo $feedbackFormId; ?>')">Reply</button>
                                <div class="feedback-form" id="<?php echo $feedbackFormId; ?>" style="display: none;">
                                    <!-- Your feedback form content -->
                                    <form method="POST" action="admin_feedback_process.php">
                                        <input type="hidden" name="feeds_id" value="<?php echo $row["feeds_id"]; ?>">
                                        <input type="hidden" name="service_provider_id" value="<?php echo $row["service_provider_id"]; ?>">
                                        <label for="reply" style="margin-bottom: 10px;">Reply:</label>
                                        <textarea class="feedback-input" name="reply"></textarea>
                                        <button type="submit" class="submit-feedback" name="submit_feedback">Submit Reply</button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                <?php
                    }
                } else {
                    echo "<tr><td colspan='6'>No pending orders found</td></tr>";
                }

                // Close the database connection
                $stmt->close();
                ?>
            </table>
        </div>
    </div>

    <script>
        function toggleFeedbackForm(feedbackFormId) {
            var feedbackForm = document.getElementById(feedbackFormId);
            feedbackForm.style.display = (feedbackForm.style.display === 'none') ? 'block' : 'none';
        }
    </script>
</body>

</html>
