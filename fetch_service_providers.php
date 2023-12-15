<?php
// Retrieve service providers based on selected service type
$serviceType = $_GET['serviceType'];

// Implement your database connection and query logic here
// Execute the query to retrieve service providers with the selected service type
// Fetch the results as an associative array

// Example response with dummy data
$serviceProviders = [
  ['name' => 'John Doe', 'company' => 'ABC Company', 'location' => 'City A', 'experience' => '5 years', 'minimumCharge' => '50'],
  ['name' => 'Jane Smith', 'company' => 'XYZ Services', 'location' => 'City B', 'experience' => '10 years', 'minimumCharge' => '75']
];

// Send the response as JSON
header('Content-Type: application/json');
echo json_encode($serviceProviders);
?>
