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

// Iterate through slots 1 to 6 and update each slot status
for ($i = 1; $i <= 6; $i++) {
    if (isset($_GET['slot' . $i])) {
        $status = $_GET['slot' . $i];

        // Validate the status value to avoid SQL injection or bad input
        if (in_array($status, ['available', 'reserved', 'occupied'])) {
            // Update the slot status in the database
            $sql = "UPDATE parking_slots SET status='$status' WHERE slot_id=$i";

            if ($conn->query($sql) !== TRUE) {
                echo "Error updating slot $i: " . $conn->error;
            }
        }
    }
}

echo "All slots updated successfully";

$conn->close();
?>
