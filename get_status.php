<?php
// Database connection
$host = 'us-cluster-east-01.k8s.cleardb.net';
$user = 'b045ef9e80a154';
$pass = 'de9cac97';
$dbname = 'heroku_8c20245ae7e92fd';

$conn = new mysqli($host, $user, $pass, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Fetch parking slots status from the database
$sql = "SELECT status FROM parking_slots ORDER BY slot_id";
$result = $conn->query($sql);

$slots = [];
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $slots[] = $row['status'];
    }
}

// Return the slots status as JSON
echo json_encode($slots);

$conn->close();
?>
