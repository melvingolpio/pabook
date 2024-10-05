<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Parking Management System</title>
    <style>
        .slot {
            width: 100px;
            height: 100px;
            display: inline-block;
            margin: 10px;
            border: 2px solid black;
            text-align: center;
            line-height: 100px;
            font-size: 20px;
            font-weight: bold;
            color: white;
        }
        .available { background-color: green; }
        .reserved { background-color: yellow; color: black; }
        .occupied { background-color: red; }
    </style>
    <script>
        // Function to refresh the parking slot status every 2 seconds
        function refreshSlotStatus() {
            var xhr = new XMLHttpRequest();
            xhr.open('GET', 'get_parking_status.php', true);
            xhr.onload = function () {
                if (this.status == 200) {
                    let slots = JSON.parse(this.responseText);
                    for (let i = 0; i < 6; i++) {
                        let slotElement = document.getElementById('slot' + (i+1));
                        if (slots[i] === 'available') {
                            slotElement.className = 'slot available';
                        } else if (slots[i] === 'reserved') {
                            slotElement.className = 'slot reserved';
                        } else if (slots[i] === 'occupied') {
                            slotElement.className = 'slot occupied';
                        }
                    }
                }
            };
            xhr.send();
        }

        setInterval(refreshSlotStatus, 2000); // Refresh every 2 seconds
    </script>
</head>
<body onload="refreshSlotStatus()">
    <h1>Parking Slot Status</h1>
    <div id="slot1" class="slot">1</div>
    <div id="slot2" class="slot">2</div>
    <div id="slot3" class="slot">3</div>
    <div id="slot4" class="slot">4</div>
    <div id="slot5" class="slot">5</div>
    <div id="slot6" class="slot">6</div>
</body>
</html>

