<?php
// Start the session before any output
session_start();
$users_id = $_SESSION['user_id'];
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Notification Page</title>
    <style>
       body {
  font-family: 'Open Sans', sans-serif;
  background-color: #f1f5f9; 
  color: #4b5156;
}

.container {
  background-color: #fff;
  box-shadow: 0 0 50px rgba(0,0,0,0.1);
  border-radius: 8px;
  padding: 30px;
  max-width: 500px;
  margin: 50px auto;  
}

h1 {
  text-align: center; 
  font-size: 32px;
  color: #3bbdbe;   
}

.notification-item {
  padding: 20px;
  background-color: #fff; 
  box-shadow: 0 3px 10px rgba(0,0,0,0.1);
  border-radius: 8px;
  margin-bottom: 20px;
  cursor: pointer;
  transition: transform 0.2s ease-out;  
}

.notification-item:hover {
  transform: translateY(-5px);
}

.notification-content {
  color: #4b5156;
} 

.notification-date {
  font-size: 0.85em;
  color: #aaa;  
}

/* Popup styles */
.popup {
  /* Popup styles here */  
} 
    </style>
</head>

<body>
    <div class="container">
        <h1>Notification Page</h1>

        <?php
        $servername = "localhost";
        $username = "root";
        $password = "";
        $dbname = "work";

        // Create connection
        $conn = mysqli_connect($servername, $username, $password, $dbname);

        // Check connection
        if (!$conn) {
            die("Connection failed: " . mysqli_connect_error());
        }

        // Get the users_id from the session (Replace this with your session retrieval method)
        //$users_id = 1001;

        // Fetch messages and replies from contacts table
        $contacts_query = "SELECT ticket_no, name, email, message, reply
                           FROM contacts
                           WHERE users_id = $users_id AND reply IS NOT NULL";
        $contacts_result = mysqli_query($conn, $contacts_query);
        $contacts_data = array();
while ($row = mysqli_fetch_assoc($contacts_result)) {
  $contacts_data[] = $row;
}


        // Fetch feeds and replies from feedback table
        $feedback_query = "SELECT feeds_id, feeds, reply
                           FROM feedback
                           WHERE users_id = $users_id AND reply IS NOT NULL";
        $feedback_result = mysqli_query($conn, $feedback_query);
        $feedback_data = array();
while ($row = mysqli_fetch_assoc($feedback_result)) {
  $feedback_data[] = $row;  
}

       // Display notification items for contacts
       foreach ($contacts_data as $contact) {
        echo '<div class="notification-item" onclick="displayPopup(`' . $contact['reply'] . '`)">';
        echo '<div class="notification-content">' . $contact['message'] . '</div>';
        //echo '<div class="notification-date">' . date("Y-m-d H:i:s") . '</div>';
        echo '</div>';
    }

    // Display notification items for feedback
    foreach ($feedback_data as $feedback) {
        echo '<div class="notification-item" onclick="displayPopup(`' . $feedback['reply'] . '`)">';
        echo '<div class="notification-content">' . $feedback['feeds'] . '</div>';
        //echo '<div class="notification-date">' . date("Y-m-d H:i:s") . '</div>';
        echo '</div>';
    }

        mysqli_close($conn);
        ?>

        <!-- Popup box for displaying message or feeds -->
        <div id="popup" class="popup">
            <div class="popup-close" onclick="closePopup()">X</div>
            <div class="popup-content">
                <h2>Reply</h2>
                <p id="content">Content will appear here...</p>
            </div>
        </div>
    </div>

    <script>
        // Function to display the popup with content
        function displayPopup(content) {
            const contentArea = document.getElementById('content');
            contentArea.innerText = content;
            document.getElementById('popup').style.display = 'block';
        }

        // Function to close the popup
        function closePopup() {
            document.getElementById('popup').style.display = 'none';
        }

    </script>
</body>

</html>
