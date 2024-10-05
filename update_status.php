
<?php
// Database connection (Make sure this part works)
$conn = new mysqli("us-cluster-east-01.k8s.cleardb.net", "b045ef9e80a154", "de9cac97", "heroku_8c20245ae7e92fd");

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Get the 'slots' parameter from the GET request
if (isset($_GET['slots'])) {
    $slots = $_GET['slots'];

    // Make sure the slots string is exactly 6 characters long
    if (strlen($slots) == 6) {
        // Update each slot in the database
        for ($i = 0; $i < 6; $i++) {
            $slot_status = $slots[$i]; // Get the status for this slot (0 or 1)
            $slot_number = $i + 1; // Assuming slot_number starts from 1

            // Update the status in the database
            $sql = "UPDATE parking_slots SET status = '$slot_status' WHERE slot_id = '$slot_number'";
            if (!$conn->query($sql)) {
                echo "Error updating slot $slot_number: " . $conn->error;
            }
        }

        echo "All slots updated successfully";
    } else {
        echo "Invalid slots data";
    }
} else {
    echo "No slots data provided";
}

$conn->close();
?>
