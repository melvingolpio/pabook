<?php
$host = "us-cluster-east-01.k8s.cleardb.net";
$username = "b5f6a402460fa3";
$password = "83f06a6b"; 
$dbname = "heroku_706906bb621a740"; 

// Create connection
$conn = new mysqli($host, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die(json_encode(["success" => false, "message" => "Connection failed: " . $conn->connect_error]));
}

// Change the request method to POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get the raw POST data
    $rawData = file_get_contents("php://input");
    $data = json_decode($rawData, true);

    // Validate the incoming data
    if (isset($data['action']) && $data['action'] === 'update' && isset($data['slots'])) {
        $slots = $data['slots'];
        $success = true;

        // Prepare the statement for updating the parking slot status
        $sql_update_slot = "UPDATE parking_slots SET status = ? WHERE slot_id = ?";
        $stmt_update_slot = $conn->prepare($sql_update_slot);

        foreach ($slots as $slot) {
            if (isset($slot['slot_id']) && isset($slot['status'])) {
                $slot_id = intval($slot['slot_id']);
                $status = $slot['status'];

                $stmt_update_slot->bind_param('si', $status, $slot_id);
                
                if (!$stmt_update_slot->execute()) {
                    $success = false;
                    error_log("Error updating parking slot status for slot ID $slot_id: " . htmlspecialchars($stmt_update_slot->error));
                } else {
                    // If status is available, delete corresponding reservation
                    if ($status === 'available') {
                        // Log the attempt to delete
                        error_log("Attempting to delete reservation for slot ID: $slot_id\n");

                        // Check if there are any reservations for this slot
                        $sql_check_reservation = "SELECT id FROM reservations WHERE slot_id = ? AND status = 'reserved'";
                        $stmt_check_reservation = $conn->prepare($sql_check_reservation);
                        $stmt_check_reservation->bind_param('i', $slot_id);
                        $stmt_check_reservation->execute();
                        $result_check_reservation = $stmt_check_reservation->get_result();

                        if ($result_check_reservation->num_rows > 0) {
                            // Proceed to delete the reservation
                            $sql_delete_reservation = "DELETE FROM reservations WHERE slot_id = ? AND status = 'reserved'";
                            $stmt_delete_reservation = $conn->prepare($sql_delete_reservation);
                            $stmt_delete_reservation->bind_param('i', $slot_id);

                            if ($stmt_delete_reservation->execute()) {
                                if ($stmt_delete_reservation->affected_rows > 0) {
                                    error_log("Reservation deleted for slot ID: $slot_id\n");
                                } else {
                                    error_log("No reservation found for slot ID: $slot_id\n");
                                }
                            } else {
                                error_log("Error deleting reservation: " . htmlspecialchars($stmt_delete_reservation->error) . "\n");
                            }

                            $stmt_delete_reservation->close();
                        } else {
                            error_log("No reservations found for slot ID: $slot_id before deletion.\n");
                        }

                        $stmt_check_reservation->close();
                    }

                    error_log("Parking slot status updated to $status for slot ID: $slot_id\n");
                }
            } else {
                $success = false;
                error_log("Invalid slot data: " . json_encode($slot));
            }
        }

        $stmt_update_slot->close();

        if ($success) {
            echo json_encode(["success" => true, "message" => "Status updated"]);
        } else {
            echo json_encode(["success" => false, "message" => "Error updating some slots"]);
        }
    } else {
        echo json_encode(["success" => false, "message" => "Invalid request format"]);
    }
} else {
    echo json_encode(["success" => false, "message" => "Invalid request method"]);
}

$conn->close();
?>
