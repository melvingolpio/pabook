<?php
$host = 'us-cluster-east-01.k8s.cleardb.net';
$user = 'b045ef9e80a154';
$pass = 'de9cac97';
$dbname = 'heroku_8c20245ae7e92fd';

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Retrieve slot statuses
$sql = "SELECT slot_id, status FROM parking_slots";
$result = $conn->query($sql);

$slots = [];
if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        $slots[$row["slot_id"]] = $row["status"];
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Real-Time Parking Status</title>
    <style>
        .slot {
            width: 100px;
            height: 100px;
            border: 1px solid black;
            display: inline-block;
            text-align: center;
            vertical-align: middle;
            font-size: 20px;
        }
        .available { background-color: green; }
        .occupied { background-color: red; }
    </style>

    <script>
        function loadStatus() {
            var xhttp = new XMLHttpRequest();
            xhttp.onreadystatechange = function() {
                if (this.readyState == 4 && this.status == 200) {
                    document.getElementById("parkingSlots").innerHTML = this.responseText;
                }
            };
            xhttp.open("GET", "fetch_slots.php", true);
            xhttp.send();
        }

        setInterval(loadStatus, 1000);  // Refresh every 3 seconds
    </script>
</head>
<body onload="loadStatus()">
    <h1>Parking Slot Status</h1>
    <div id="parkingSlots">
        <!-- Slots will be loaded here -->
    </div>
</body>
</html>

