<?php

$host = 'us-cluster-east-01.k8s.cleardb.net';
$user = 'b045ef9e80a154';
$pass = 'de9cac97';
$dbname = 'heroku_8c20245ae7e92fd';

// Establishing connection to the database
$conn = new mysqli($host, $user, $pass, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// SQL query to fetch the statuses of parking slots
$sql = "SELECT status FROM parking_slots ORDER BY slot_id ASC";
$result = $conn->query($sql);

$statuses = [];

if ($result->num_rows > 0) {
    // Loop through the results and store them in an array
    while ($row = $result->fetch_assoc()) {
        $statuses[] = $row['status'];
    }
} else {
    echo json_encode(["error" => "No data found"]);
    exit();
}

// Output the statuses as a JSON array
echo json_encode($statuses);

// Close the database connection
$conn->close();
?>
