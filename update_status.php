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
