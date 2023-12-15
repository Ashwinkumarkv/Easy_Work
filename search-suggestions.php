<!-- search-suggestions.php -->
<?php
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

if (isset($_GET['query'])) {
    $searchQuery = mysqli_real_escape_string($connection, $_GET['query']);
    
    // Modify your query to search for service names based on the entered query
    $searchQuery = '%' . $searchQuery . '%';
    $query = "SELECT DISTINCT service_name FROM service_providers WHERE service_name LIKE '$searchQuery'";
    $result = mysqli_query($connection, $query);

    // Display suggestions
    while ($row = mysqli_fetch_assoc($result)) {
        echo '<div>' . ucfirst(str_replace('_', ' ', $row['service_name'])) . '</div>';
    }
}

// Close the database connection
mysqli_close($connection);
?>
