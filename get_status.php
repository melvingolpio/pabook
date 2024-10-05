<?php
// Database connection
$host = 'localhost';
$user = 'root';
$pass = '';
$dbname = 'parking_system';

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
