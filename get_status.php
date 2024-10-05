<?php
$host = 'us-cluster-east-01.k8s.cleardb.net';
$user = 'b045ef9e80a154';
$pass = 'de9cac97';
$dbname = 'heroku_8c20245ae7e92fd';

// Create connection
$conn = new mysqli($host, $user, $pass, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Retrieve slot statuses
$sql = "SELECT slot_id, status FROM parking_slots";
$result = $conn->query($sql);

$slots_html = '';
if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        $status_class = ($row["status"] == 'available') ? 'available' : 'occupied';
        $slots_html .= '<div class="slot ' . $status_class . '">Slot ' . $row["slot_id"] . '</div>';
    }
} else {
    $slots_html = '<div>No slots found</div>';
}

$conn->close();
echo $slots_html;
?>
