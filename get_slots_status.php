<?php
// Database connection details
$host = 'us-cluster-east-01.k8s.cleardb.net';
$user = 'b045ef9e80a154';
$pass = 'de9cac97';
$dbname = 'heroku_8c20245ae7e92fd';

// Create the database connection
$conn = new mysqli($host, $user, $pass, $dbname);

// Check if the connection was successful
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// SQL query to get the slot statuses
$sql = "SELECT status FROM parking_slots ORDER BY slot_id ASC";
$result = $conn->query($sql);

// Prepare an array to hold the statuses
$statuses = [];

// Check if there are any results
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        // Store each status in the array
        $statuses[] = $row['status'];
    }
}

// Output the response as JSON
header('Content-Type: application/json');
echo json_encode($statuses);

// Close the database connection
$conn->close();
?>
