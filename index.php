<html>
	<head>
		
		<script>
			// Set the date we're counting down to
			var countDownDate = new Date("SEP 10, 2017 17:00:00 GMT-4").getTime();
		
			// Update the count down every 1 second
			var x = setInterval(function() {
		
  			// Get todays date and time
  			var now = new Date().getTime();
		
  			// Find the distance between now an the count down date
  			var distance = countDownDate - now;
		
  			// Time calculations for days, hours, minutes and seconds
  			var days = Math.floor(distance / (1000 * 60 * 60 * 24));
  			var hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
  			var minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
  			var seconds = Math.floor((distance % (1000 * 60)) / 1000);
			
  			// Display the result in the element with id="demo"
  			document.getElementById("demo").innerHTML = days + "d " + hours + "h "
  			+ minutes + "m " + seconds + "s ";
			
  			// If the count down is finished, write some text 
  			if (distance < 0) {
    			clearInterval(x);
    			document.getElementById("demo").innerHTML = "EXPIRED";
  			}
			}, 1000);
			
		</script>
			
	
	</head>
	
	<body style="margin:100" bgcolor="e6f7ff">
		<img src="https://vergecurrency.com/vergelogo.svg"/>
		</br>
		</br>
		<h1>Welcome to the (unofficial) XVG Lotto!</h1>
		<h3>Hosted and operated by <a href="https://twitter.com/DotNetRussell">@DotNetRussell</a></h2>
		</br>
		
		<table cellpadding="50" border="1">
			<tr>
				<th>
					<h1>Buy a Ticket</h1>
					<img src="https://d30y9cdsu7xlg0.cloudfront.net/png/936-200.png" width="80"/>
				</th>
				<th>
					<h1>Redeem a Ticket</h1>
					<img src="https://image.flaticon.com/icons/png/512/8/8817.png" width="50"/>
				</th>
			</tr>
			<tr>
				<td>
					<h3>How it works:</h2>
					<ol>
					<li>Enter the wallet address for your winnings</li>
					<li>Buy a ticket <span style="color:red"><b>(COPY DOWN YOUR PAYMENT ID)</b></span> </br>The purchase takes about 10-30 min, be patient</li>
					<li>Trade your Payment ID for a lotto ticket number</li>
					<li>Wait for the drawing!</li>
					</ol>
					<p>The drawing will take place in the <a href="https://discordapp.com/channels/325024453065179137/325024453065179137">vergecurrency discord channel</a></p>
		
					<form target="_blank"  action="https://www.coinpayments.net/index.php" method="post">

						<input type="hidden" name="on1" value="PayoutAddress">
						<h3>Payout Address:
						<input type="text" name="ov1" value="" >	
						<p style="color:red">This is where your winnings go so make sure it's correct</p>
					
						</h3>
					
						</br></br>
						<input type="hidden" name="first_name" value="anonymous">
						<input type="hidden" name="last_name" value="anonymous">
						<input type="hidden" name="email" value="anonymous@anon.com">
						<input type="hidden" name="cmd" value="_pay_simple">
						<input type="hidden" name="reset" value="1">
						<input type="hidden" name="merchant" value="9451460c93a94f23465c9c21d35ab5e6">
						<input type="hidden" name="item_name" value="Lotto Ticket">
						<input type="hidden" name="item_desc" value="1 XVG Lotto Ticket">
						<input type="hidden" name="currency" value="XVG">
						<input type="hidden" name="amountf" value="20.00000000">
						<input type="hidden" name="want_shipping" value="0">
						<input type="hidden" name="success_url" value="https://dotnetrussell.com/xvglotto/tickets.php" >
						<input type="image" src="https://www.coinpayments.net/images/pub/buynow-wide-yellow.png" alt="Buy Now with CoinPayments.net">
						<h3>PLEASE ALLOW UP TO 10-30 MIN FOR THE PAYMENT TO PROCESS.</br>DO NOT FORGET TO COVER TRANSACTION FEES</h3>
					</form>
				</td>

				<td>

					<h3>Make your payment already?</br>Trade your Payment ID for your number here!</h3>
					
					<script>
						function getTicket(){
							document.getElementById("ticketStatus").style.display="";
							document.getElementById("ticketStatus").innerText = "Checking...";
							var xhttp = new XMLHttpRequest();
							var paymentId = document.getElementById("paymentId").value;
							xhttp.onreadystatechange = function() {
  								if (this.readyState == 4 && this.status == 200) {
    									document.getElementById("ticketStatus").innerText = this.responseText.trim();
  								}
							}
							xhttp.open("GET", "confirmPayment.php?paymentId="+paymentId, true);
							xhttp.send();
						}
					</script>
					<input type="text" id="paymentId" value="">
					<button size="20" onclick="getTicket()">Get Ticket Number</button>
					</br>
					<p><b>Ticket#</b> 
					<span id="ticketStatus" style="display:none">Checking...</span>
					</br>
					</br>
					</br>
					
					<script>
					
						function findTicket(){
							document.getElementById("ticketStatus").style.display="";
							document.getElementById("ticketStatus").innerText = "Checking...";
							var xhttp = new XMLHttpRequest();
							var walletAddress = document.getElementById("paymentAddr").value;
							xhttp.onreadystatechange = function() {
  								if (this.readyState == 4 && this.status == 200) {
    									document.getElementById("ticketStatus").innerText = this.responseText.trim();
  								}
							}
							xhttp.open("GET", "retrieveNumber.php?paymentAddress="+walletAddress, true);
							xhttp.send();
					
						}
					</script>
					<p>Lose your ticket number?</br>No problem. Enter your payout address here</p>
					<input type="text" id="paymentAddr" value=""/>
					<button size="20" onclick="findTicket()">Lookup ticket by payout address</button>
					</p>
					
					<h2>Current Lotto Stats</h2>
					<?php
					
					
					
						function getRow($label,$data){
							$trO = "<tr>";
							$trC = "</tr>";
							$tdO = "<td>";
							$tdC = "</td>";
					
							$row = $trO . $tdO . $label . $tdC . $tdO . $data . $tdC . $trC;
					
							return $row;
						}
					
					
						$configFile = file_get_contents("/var/prison/config.json");
						$configJson = json_decode($configFile,true);
					
 						$mysqli = new mysqli($configJson["database"]["host"], $configJson["database"]["user"], $configJson["database"]["pass"], $configJson["database"]["dbname"]); 
						$query = "SELECT * FROM potinfo  WHERE id='1'";
						$results=$mysqli->query($query);
						$currentStatsRows=$results->fetch_all(MYSQLI_ASSOC);
						$currentStats = $currentStatsRows[0];
						$totalSold = $currentStats["ticketsSold"];
						$ratio="";
						if($totalSold<1000){
							$ratio="1:1000";
						}
						else{
							$ratio = "1:".$totalSold;
						}
						$seedAmount = $currentStats["seedAmount"];
						$ticketPrice = $currentStats["ticketPrice"];
						$potAmount = (($ticketPrice*.69)*$totalSold)+$seedAmount;
						$marketingAmount =(($ticketPrice*.2)*$totalSold)+$seedAmount;
					
						$rowOne=getRow("<b>Total tickets sold:</b>",$totalSold);
						$rowTwo=getRow("<b>Win ratio:</b>",$ratio);
						$rowThree=getRow("<b>Current Pot:</b>","<span style='color:green'><b>".$potAmount." XVG </b></span>");
						$rowFour=getRow("<b>Raised for Marketing Verge:</b>",$marketingAmount." XVG");
						$tableOpen="<table cellpadding='10' border=1>";
						$tableClose="</table>";
					
						echo $tableOpen;
					
						echo $rowOne;
						echo $rowTwo;
						echo $rowThree;
						echo $rowFour;
						echo $tableClose;
					?>
					


				</td>
			</tr>
		</table>


		</hr>


		<center>
		<div style="border-radius:25px;border:1;width:550;background:#47d147;color:white">
		<table>
			<tr>
				<td>
					<img src="https://image.flaticon.com/icons/png/512/8/8817.png" width=100/>
				</td>
				<td>
					<center>
					<h1 style="color:white"> NEXT DRAWING: <p id="demo"></p> </h1></div>
					</center>
				</td>
				<td>
					<img src="https://image.flaticon.com/icons/png/512/8/8817.png" width=100/>
				</td>
			</tr>
		</table>
		</center>


		<hr/>

		<table cellpadding="50">
			<tr>
				<td>
					<h2>About:</h2>
					<p>This lotto was created to help fund advertising of Verge Currency. I don't have any affiliation with XVG. 
					</br>
					</br>Currently, each ticket sale will pay for the following:
					</br>1%  - Server|Site fee
					</br>10% - Seed the following weeks lotto pot
					</br>20% - XVG Marketing Team
					</br>69% - Added to this weeks lotto pot
					</br>
					<h4>TICKET SALES WILL BE STOPPED 2 HOURS PRIOR TO DRAWING TO ALLOW ALL TICKETS TO CLEAR</h4>
					</p>
					<p><b>Drawings will take place once a week on Sunday 5pm EST</b></p>
				</td>
			</tr>
		</table>
		<center>
			<img src="https://media.tenor.com/images/20a7813c6c5913b7112e992e0566c809/tenor.gif" width="200"/>
		</center>
		<hr/>
	</body>
</html>
