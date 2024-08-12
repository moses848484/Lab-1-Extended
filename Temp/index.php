<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link rel="stylesheet" href="temp.css">
	<title>Temperature & Humidity To Web Server</title>
</head>

<body>

	<li class="list">
		<img src="humidity.png" class="humidity">
		<h1 class="temptitle">Temperature & Humidity <br> To Web Server Upload Lab</h1>
		<h1 class="temptxt">Temperature: <span id="temperature" class="temptext">0 °C</span></h1>
		<h1 class="temptxt">Humidity: <span id="humidity" class="temptext">0 </span></h1>
		<button id="ledButton" class="submitbtn" onclick="toggle()">OFF</button>
	</li>



	<script>
		//REPLACE WITH YOUR COMPUTER IP ADDRESS WHERE THE WEBSOCKET SERVER IS RUNNING
		var socket = new WebSocket('ws://192.168.43.189:81');

		socket.onmessage = function (event) {
			console.log(event.data);
			const data = event.data.split(":");

			const msg = data[0] || "";
			const sensor = data[1] || "";

			if (sensor == "led") {
				var button = document.getElementById("ledButton");
				button.innerHTML = msg == "1" ? "ON" : "OFF";
			}
			else if (sensor == "dht") {
				var parts = msg.split(",");
				var temperature = parts[0];
				var himidity = parts[1];

				document.getElementById("temperature").innerHTML = temperature + " °C";
				document.getElementById("humidity").innerHTML = himidity + " %";
			}
		};

		function toggle() {
			var button = document.getElementById("ledButton");
			var status = button.innerHTML === "OFF" ? "1" : "0";
			socket.send(status + ":led:esp:localhost");
		}
	</script>

</body>

</html>