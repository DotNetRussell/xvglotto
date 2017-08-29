<?php
	//Load the config file
	$configFile = file_get_contents("/var/prison/config.json");
	$configJson = json_decode($configFile,true);

	//Get the payment address from the query string
	$paymentAddress = $_GET["paymentAddress"];

	//Open a db connection
 	$mysqli = new mysqli($configJson["database"]["host"], $configJson["database"]["user"],
		$configJson["database"]["pass"], $configJson["database"]["dbname"]);

	//Escape anyone doing hackery shit
	$pa = mysqli_real_escape_string($mysqli,$paymentAddress);

	//build the query
	$query = "SELECT ticketNumber FROM tickets WHERE paymentAddress = '".$pa."'";

	//make the call
	$result = $mysqli->query($query);

	$tickets = "";

	while($row = $result -> fetch_row()){
		//We concat it together just in case they bought more than one ticket
		$tickets = $tickets + " " + $row[0];
	}

	//Send the tickets back
	echo $tickets;

?>
