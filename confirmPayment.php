	

<?php 

	// NOTE: This is from the coinpayments api website. 
	function coinpayments_api_call($cmd, $req = array()) { 
		
		//First we need to load our config json
    		$configFile = file_get_contents("/var/prison/config.json");
    		$configJson = json_decode($configFile,true);
		
		
    		// Fill these in from your API Keys page 
    		$public_key = $configJson["coinpayments"]["publickey"]; 
    		$private_key = $configJson["coinpayments"]["privatekey"]; 
		
     		
    		// Set the API command and required fields 
    		$req['version'] = 1; 
    		$req['cmd'] = $cmd; 
    		$req['key'] = $public_key; 
    		$req['format'] = 'json'; //supported values are json and xml 
     		
    		// Generate the query string 
    		$post_data = http_build_query($req, '', '&'); 
     		
    		// Calculate the HMAC signature on the POST data 
    		$hmac = hash_hmac('sha512', $post_data, $private_key); 
    		// Create cURL handle and initialize (if needed) 
    		static $ch = NULL; 
    		if ($ch === NULL) { 
        		$ch = curl_init('https://www.coinpayments.net/api.php'); 
        		curl_setopt($ch, CURLOPT_FAILONERROR, TRUE); 
        		curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE); 
        		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0); 
    		} 
		
		
    		curl_setopt($ch, CURLOPT_HTTPHEADER, array('HMAC: '.$hmac)); 
    		curl_setopt($ch, CURLOPT_POSTFIELDS, $post_data); 
     		
    		// Execute the call and close cURL handle      
    		$data = curl_exec($ch);                 
    		// Parse and return data if successful. 
    		if ($data !== FALSE) { 
        		if (PHP_INT_SIZE < 8 && version_compare(PHP_VERSION, '5.4.0') >= 0) { 
            		// We are on 32-bit PHP, so use the bigint as string option. If you are using any API calls with Satoshis it is highly NOT recommended to use 32-bit PHP 
            		$dec = json_decode($data, TRUE, 512, JSON_BIGINT_AS_STRING); 
        		} else { 
            		$dec = json_decode($data, TRUE); 
        		} 
        		if ($dec !== NULL && count($dec)) { 
            		return $dec; 
        		} else { 
            		// If you are using PHP 5.5.0 or higher you can use json_last_error_msg() for a better error message 
            		return array('error' => 'Unable to parse JSON result ('.json_last_error().')'); 
        		} 
    		} 
		else { 
        		return array('error' => 'cURL error: '.curl_error($ch)); 
    		} 
	} 
	
	//Setup our post data
	$commands=array("full"=>"1","txid"=>$_GET['paymentId']);
	
	//Make call to coinpayments
	$result = coinpayments_api_call("get_tx_info",$commands);

	//Status code of the payment
	$statusCode = $result["result"]["status"];

	//If the code is 100 or more, then the payment is compelted
	//If the code is 2 then it's completed and set for nightly withdraw
	if($statusCode >= 100  || $statusCode == 2){

		//load the config again because aparently when I did it outside of the api call everything freaked and there was a scoping issue
    		$configFile = file_get_contents("/var/prison/config.json");
		$configJson = json_decode($configFile,true);
	
		//Retrieve the payout addrress from the api response
		$payoutAddress = $result["result"]["checkout"]["ov1"];
		$refId = $result["result"]["checkout"]["ov2"];
		
		//Open the db connection
		$mysqli = new mysqli($configJson["database"]["host"], $configJson["database"]["user"], 
			     	$configJson["database"]["pass"], $configJson["database"]["dbname"]);

		//Exit if there's an error
		if (mysqli_connect_errno()) {
    			exit();
		}

		//Escape the paymentId in case of hackery
		$idEscaped=mysqli_real_escape_string($mysqli,$_GET['paymentId']);
		
		//Build the query to check to see if this payment id was already used
		$repeat = "SELECT * FROM paymentIds WHERE id='".$idEscaped."'";

		//make the call
		$repeatResults = $mysqli->query($repeat);

		//Someone is trying to reuse a code
		if($repeatResults->num_rows>0){
			echo "ID already redeemed!";
			return;
		}
		//Add the new code to the db
		else{
			//prevent payment id reuse
			$burnId = "INSERT INTO paymentIds (id) values('".$idEscaped."')";
			$mysqli->query($burnId);
		}
	
		$referalId = mysqli_real_escape_string($mysqli,$refId);

		if(strlen($referalId) > 0){

			$query = "INSERT INTO referals (payoutAddress,referals) values('".$referalId."',1);";
			$mysqli->query($query);
		}


		//Find all lotto numbers that haven't been assigned
		$query = "SELECT * FROM tickets WHERE PaymentAddress = ''";

		$result = $mysqli->query($query);
		$availableTickets = $result->fetch_all(MYSQLI_ASSOC);

		//If we have rows, then we good
		if (count($availableTickets)>0) {
			//choose a random ticket
			$ticketId = array_rand($availableTickets,1);

			//extract the number from the ticket
			$ticketNumber = $availableTickets[$ticketId]["ticketNumber"];

			//Sell the ticket
			$query = "UPDATE tickets SET paymentAddress = '".$payoutAddress."' WHERE ticketNumber = '".$ticketNumber."'";
			$mysqli->query($query);
	
			//Update the stats info table
			$query = "UPDATE potinfo SET ticketsSold = ticketsSold + 1 WHERE id = 1";
			$mysqli->query($query);
	
			echo $ticketNumber;
    			$result->close();
		}
		//else we need to make some new rows
		else {
			//add new ticket
			$insert = "INSERT INTO tickets (paymentAddress) values('')";
			$mysqli->query($insert);

			$get = "SELECT * FROM tickets WHERE PaymentAddress = ''";
			if($result = $mysqli->query($get)){
				$availableTickets = $result->fetch_all(MYSQLI_ASSOC);
				$ticketNumber = $availableTickets[0]["ticketNumber"];
				$sell = "UPDATE tickets SET paymentAddress = '".$payoutAddress."' WHERE ticketNumber = '".$ticketNumber."'";
				$mysqli->query($sell);
				$update = "UPDATE potinfo SET ticketsSold = ticketsSold + 1 WHERE id = 1";
				$mysqli->query($update);

				echo $ticketNumber;
				$result->close();
			}

		}

		$query = "SELECT * FROM potinfo";
		if($result = $mysqli->query($query)){
			$potInfoRow = $result->fetch_all(MYSQLI_ASSOC);
			$ticketsSold = $potInfoRow[0]["ticketsSold"];
			$ticketPrice = $potInfoRow[0]["ticketPrice"];
			$ticketSeed = $potInfoRow[0]["seedAmount"];

			$potAmount = (($ticketsSold * $ticketPrice)*.69)+$ticketSeed;
			$marketing = (($ticketsSold * $ticketPrice)*.2);

			$url = "https://discordapp.com/api/webhooks/361631366389039117/OX8wRtxFtgPShskTWx1SEArMGajP0XhlcO7V8oYyStvjsxtgXQAGjoIjeWvjvJbXsi2H";
			$message = "Ticket Purchased!\r\nTotal Tickets Sold: ".$ticketsSold."\r\nTicket Price: ".$ticketPrice."\r\n\r\nCurrent Pot: ".$potAmount."\r\nRaised For Marketing: ".$marketing."\r\nGet your tickets at https://www.XvgLotto.com";

			$data = array('content' => $message);
			$json = json_encode($data);
			

			$curl = curl_init($url);
			curl_setopt($curl, CURLOPT_HEADER, false);
			curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
			curl_setopt($curl, CURLOPT_HTTPHEADER, array("Content-type: application/json"));
			curl_setopt($curl, CURLOPT_POST, true);
			curl_setopt($curl, CURLOPT_POSTFIELDS, $json);

			curl_exec($curl);

		}
	}
	//Don't let the get a lotto ticket
	else if($statusCode === 0){
		echo "Waiting for funds to transfer";
	}
	//Really don't let them get a lotto ticket
	else if($statusCode < 0){
		echo "Error while processing transaction";
	}
	//They haven't paid yet
	else{
		echo "Payment is pending";
	}
	
?>

