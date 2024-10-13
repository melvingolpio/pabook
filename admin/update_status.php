<?php
$host = "us-cluster-east-01.k8s.cleardb.net";
$username = "b5f6a402460fa3";
$password = "83f06a6b"; 
$dbname = "heroku_706906bb621a740"; 

$conn = new mysqli($host, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    error_log("Connection failed: " . $conn->connect_error);
    echo json_encode(["success" => false, "message" => "Database connection failed"]);
    exit();
}

// Check if the request method is POST and the expected fields are present
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['action']) && $_POST['action'] == 'update' && isset($_POST['slots'])) {
    $slotsJson = $_POST['slots']; // Get the slots JSON data
    $slots = json_decode($slotsJson, true); // Decode the JSON into an associative array

    if (json_last_error() === JSON_ERROR_NONE) {
        foreach ($slots as $slot) {
            $slot_id = intval($slot['slot_id']);
            $status = $slot['status'];

            // Prepare the statement for updating the parking slot status
            $sql_update_slot = "UPDATE parking_slots SET status = ? WHERE slot_id = ?";
            $stmt_update_slot = $conn->prepare($sql_update_slot);
            $stmt_update_slot->bind_param('si', $status, $slot_id);

            if ($stmt_update_slot->execute()) {
                error_log("Parking slot status updated to $status for slot ID: $slot_id");
            } else {
                error_log("Error updating parking slot status: " . htmlspecialchars($stmt_update_slot->error));
                echo json_encode(["success" => false, "message" => "Error updating status"]);
                exit();
            }

            $stmt_update_slot->close();
        }
        echo json_encode(["success" => true, "message" => "Status updated"]);
    } else {
        error_log("Error decoding JSON: " . json_last_error_msg());
        echo json_encode(["success" => false, "message" => "Error decoding JSON"]);
    }
} else {
    error_log("Invalid request.");
    echo json_encode(["success" => false, "message" => "Invalid request"]);
}

$conn->close();
?>
