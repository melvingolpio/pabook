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
            margin: 5px;
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
            xhttp.open("GET", "get_status.php", true);
            xhttp.send();
        }

        setInterval(loadStatus, 1000);  // Refresh every second
    </script>
</head>
<body onload="loadStatus()">
    <h1>Parking Slot Status</h1>
    <div id="parkingSlots">
        <!-- Slots will be loaded here -->
    </div>
</body>
</html>
