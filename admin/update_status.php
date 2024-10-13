<?php
$host = "us-cluster-east-01.k8s.cleardb.net";
$username = "b5f6a402460fa3";
$password = "83f06a6b"; 
$dbname = "heroku_706906bb621a740"; 

$conn = new mysqli($host, $username, $password, $dbname);

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get the raw POST data
    $data = json_decode(file_get_contents('php://input'), true);

    // Check if the data contains the expected keys
    if (isset($data['action']) && $data['action'] == 'update' && isset($data['slots'])) {
        $slots = $data['slots']; // Get the slots JSON data

        if (json_last_error() === JSON_ERROR_NONE) {
            foreach ($slots as $slot) {
                $slot_id = intval($slot['slot_id']);
                $status = $slot['status'];

                // Prepare the statement for updating the parking slot status
                $sql_update_slot = "UPDATE parking_slots SET status = ? WHERE slot_id = ?";
                $stmt_update_slot = $conn->prepare($sql_update_slot);
                $stmt_update_slot->bind_param('si', $status, $slot_id);

                if ($stmt_update_slot->execute()) {
                    // If status is available, delete corresponding reservation
                    if ($status === 'available') {
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
                            $stmt_delete_reservation->execute();
                            $stmt_delete_reservation->close();
                        }

                        $stmt_check_reservation->close();
                    }
                }

                $stmt_update_slot->close();
            }
            echo json_encode(["success" => true, "message" => "Status updated"]);
        } else {
            echo json_encode(["success" => false, "message" => "Error decoding JSON"]);
        }
    } else {
        echo json_encode(["success" => false, "message" => "Invalid request"]);
    }
} else {
    echo json_encode(["success" => false, "message" => "Invalid request"]);
}

$conn->close();
