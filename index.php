<html>
	<head>
    <meta charset="utf-8" />
    <link rel="apple-touch-icon" sizes="76x76" href="./assets/img/apple-icon.png">
    <link rel="icon" type="image/png" href="./assets/img/favicon.png">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
    <title>XVG Lotto</title>
    <meta content='width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0, shrink-to-fit=no' name='viewport' />
    
    <!-- Open Graph Tags --> 
    <meta property="og:title" content="XVG Lotto" /> 
    <meta property="og:type" content="website" />
    <meta property="og:url" content="https://xvglotto.com" />
    <meta property="og:image" content="https://xvglotto.com/assets/img/og.jpg" />
    <meta property="og:description" content="Buy a lotto ticket, win XVG, and support Verge Currency"/>

    <!-- Twitter Open Graph -->
    <meta name="twitter:card" content="summary" />
    <meta name="twitter:site" content="@xvglotto" />
    <meta name="twitter:creator" content="@dotnetrussell" />
    <meta property="og:url" content="https://xvglotto.com" />
    <meta property="og:title" content="XVG Lotto" />
    <meta property="og:description" content="Buy a lotto ticket, win XVG, and support Verge Currency" />
    <meta property="og:image" content="https://xvglotto.com/assets/img/og.jpg" />

    <!-- Fonts and icons -->
    <link href="https://fonts.googleapis.com/css?family=Montserrat:400,700,200" rel="stylesheet" />
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/latest/css/font-awesome.min.css" />
    <!-- CSS Files -->
    <link href="./assets/css/bootstrap.min.css" rel="stylesheet" />
    <link href="./assets/css/now-ui-kit.css?v=1.1.0" rel="stylesheet" />
    <link href="./assets/css/styles.css" rel="stylesheet" />
    <!-- JS --> 
		<script src="./assets/js/html5shiv.js"></script>
		<script src="./assets/js/respond.min.js"></script>
		<script src="./js/bootstrap.min.js"></script>
		<script>
			// Set the date we're counting down to
			var countDownDate = new Date("SEP 25, 2017 17:00:00 GMT-4").getTime();
		
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
  			var elements = document.getElementsByClassName("countdown");
			Array.prototype.forEach.call(elements,function(element)
				{
					element.innerHTML = days + "d " + hours + "h " + minutes + "m " + seconds + "s ";
				});
			
  			// If the count down is finished, write some text 
  			if (distance < 0) {
    			clearInterval(x);
    			document.getElementsByClassName("countdown").innerHTML = "EXPIRED";
  			}
			}, 1000);
			
		</script>
			
	
	</head>
<body class="index-page">
<nav class="navbar navbar-expand-lg bg-primary">
  <div class="container">
      <div class="navbar-translate">
          <div class="navbar-brand">Next drawing in: <a class="navbar-brand countdown" href="#"></a></div>
      </div>
      <div class="collapse navbar-collapse justify-content-end" id="example-navbar-primary" data-nav-image="./assets/img/blurred-image-1.jpg">
          <ul class="navbar-nav">
              <li class="nav-item active">
                  <a class="nav-link" href="#ticket-container">
                      <i class="now-ui-icons shopping_tag-content"></i>
                      <p>Buy A Ticket</p>
                  </a>
              </li>
              <li class="nav-item">
                  <a class="nav-link" href="#ticket-container">
                      <i class="now-ui-icons business_money-coins"></i>
                      <p>Redeem A Ticket</p>
                  </a>
              </li>
              <li class="nav-item">
                  <a class="nav-link" href="https://twitter.com/DotNetRussell">
                      <i class="fa fa-twitter"></i>
                      <p>Tweet Me</p>
                  </a>
              </li>
          </ul>
      </div>
  </div>
</nav>




  <div class="page-header clear-filter" filter-color="purpish">
      <div class="page-header-image" data-parallax="true" style="background-image: url(&quot;https://i.imgur.com/93MQjPN.jpg&quot;); transform: translate3d(0px, 0px, 0px);">
      </div>

      <div class="container">
          <div class="content-center brand">
            </br>
            </br>
            <div class="jumbotron">
            <h1>Welcome to the XVG Lotto!</h1>
            <h1>NEXT DRAWING:</h1>
            <h2 class="countdown"> 1d 22h 41m 50s </h2>
            <button class="btn btn-primary btn-lg">
              <a class="buy-ticket" href="#ticket-container">
                <i class="now-ui-icons business_money-coins"></i>
                  Buy A Ticket
              </a>
            </button>
            </div>
            </br>  
          </div>
          <h5 class="category category-absolute">Hosted and operated by
            <a href="https://twitter.com/DotNetRussell" target="_blank">
                @DotNetRussell
            </a> for 
            <a href="https://www.vergecurrency.com" target="_blank">
                <img src="./assets/img/verge-logo.png" class="verge-logo"> 
            Verge.</a></h5>
      </div>
  </div>

<?php
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
		$marketingAmount =(($ticketPrice*.2)*$totalSold);

		echo "<input type='hidden' id='totalSold' value='".$totalSold."' />";
		echo "<input type='hidden' id='winRatio' value='".$ratio."' />";
		echo "<input type='hidden' id='seedAmount' value='".$seedAmount."' />";
		echo "<input type='hidden' id='ticketPrice' value='".$ticketPrice."' />";
		echo "<input type='hidden' id='potAmount' value='".$potAmount."' />";
		echo "<input type='hidden' id='marketingAmount' value='".$marketingAmount."' />";
	?>

<section id="stats-container" data-background-color="gray">
    <div class="container">
      <h4> Current Lotto Stats </h4>

      <div class="row text-center">
        <div class="col-lg-3">
          <i class="now-ui-icons shopping_tag-content"></i>
          <p>Total tickets sold: <br>
          <p id="totalTicketsSold"></p></p>
        </div>
        <div class="col-lg-3">
          <i class="now-ui-icons business_chart-bar-32"></i>
          <p>Win ratio: <p id="winRatioText"> </p></p>
        </div>
        <div class="col-lg-3">
          <i class="now-ui-icons business_money-coins"></i>
          <p>Current Pot: <p id="currentPotInfo"></p><p>$XVG</p>
        </div>
        <div class="col-lg-3">
          <i class="now-ui-icons business_bulb-63"></i>
          <p>Raised for Marketing: <p id="marketingAmountTag"></p></p>
        </div>
    </div>
  </div>
</section>
<script>
	document.getElementById("totalTicketsSold").innerText = document.getElementById("totalSold").value;
	document.getElementById("winRatioText").innerText = document.getElementById("winRatio").value;
	document.getElementById("currentPotInfo").innerText = document.getElementById("potAmount").value;
	document.getElementById("marketingAmountTag").innerText = document.getElementById("marketingAmount").value;
</script>

<section id="ticket-container" data-background-color="gray">
    <div class="container">
        <div class="row">
            <div class="col-lg-6 col-sm-12">
                <div class="card" data-background-color="black">
                    <div class="card-block content-danger">
                        <h3> <i class="now-ui-icons shopping_tag-content"></i> Buy A Ticket </h3>
                        <h4 class="card-title">How It Works:</h4>
                        <ol>
                          <li><p>Enter the wallet address for your winnings</p></li>
                          <li><p>Buy a ticket <span class="attention">(COPY DOWN YOUR PAYMENT ID)</span><br>
                          The purchase takes about 10-30 min, be patient </p></li>
                          <li><p>Trade your Payment ID for a lotto ticket number</p></li>
                          <li><p>Wait for the drawing!</p></li>
                          <li><p>The drawing will take place in the <a href="https://discordapp.com/channels/325024453065179137/325024453065179137">vergecurrency discord channel</a></p></li>
                        </ol>
                        <div class="card-footer">
                          <h4><a href="#">Payout Address:</a></h4>  
                            <form class="form-group" target="_blank"  action="https://www.coinpayments.net/index.php" method="post">
                              <input type="hidden" name="on1" value="PayoutAddress">
                              <input type="text" placeholder="Payout Address" id="poaddress" name="ov1" class="form-control" value="" required>  
                              
                              <p class="winnings">This is where your winnings go so make sure it's correct</p>
                              
                              <?php
                                $referralId = $_GET['referralId'];
                                echo '<input type="hidden" name="on2" value="referalId"/>';
                                echo '<input type="hidden" name="ov2" value="'.$referralId.'"/>';
                              ?>
                              
                              <input type="hidden" name="first_name" value="anonymous">
                              <input type="hidden" name="last_name" value="anonymous">
                              <input type="hidden" name="email" value="anonymous@anon.com">
                              <input type="hidden" name="cmd" value="_pay_simple">
                              <input type="hidden" name="reset" value="1">
                              <input type="hidden" name="merchant" value="9451460c93a94f23465c9c21d35ab5e6">
                              <input type="hidden" name="item_name" value="Lotto Ticket">
                              <input type="hidden" name="item_desc" value="1 XVG Lotto Ticket">
                              <input type="hidden" name="currency" value="XVG">
                              <input id="ticketPriceButton" type="hidden" name="amountf" value="300.00000000">
                              <input type="hidden" name="want_shipping" value="0">
                              <input type="hidden" name="success_url" value="https://www.xvglotto.com" >
                              <input class="btn btn-lg btn-success" type="submit" value="Purchase ticket with CoinPayments">
                              </br>
                                <p class="text-warning last">
                                  PLEASE ALLOW UP TO 10-30 MIN FOR THE PAYMENT TO PROCESS.</br>DO NOT FORGET TO COVER TRANSACTION FEES
                                 </p>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
<script>
	var ticketPrice = document.getElementById("ticketPrice").value;
	document.getElementById("ticketPriceButton").value = ticketPrice;
</script>
            <div class="col-lg-6 col-sm-12">
                <div class="card" data-background-color="black">
                    <div class="card-block content-danger">
                        <h3> <i class="now-ui-icons business_money-coins"></i> Redeem A Ticket </h3>
                        <h4 class="card-title">Make Your Payment Already?</h4>
                        <p class="card-description">
                            Trade your Payment ID for your number here! 
                        </p>

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
                          <input type="text" placeholder="Payout ID" class="form-control" id="paymentId" value="">
                          <button class="btn btn-lg btn-success" size="20" onclick="getTicket()">Get Ticket Number</button>
                          </br><p class="text-warning">Coinpayments can be slow. Even after it says payment complete on your end it may take 5-10 more min.</br>

                          <p>Please reach out to me on <a class="twitter" href="https://twitter.com/DotNetRussell" target="_blank">Twitter</a> if after 1 hr your payment hasn't posted</p>
                          </br></br>

                          <div class="card-footer">
                          <h4>Ticket#</h4> 
                          <span id="ticketStatus" style="display:none">Checking...</span>
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
                          <input class="form-control" placeholder="Ticket Number" type="text" id="paymentAddr" value=""/>
                          <p class="winnings">Lose your ticket number? No problem. Enter your payout address here</p>
                          <button class="btn btn-lg btn-primary" size="20" onclick="findTicket()">Lookup ticket by payout address</button>


                          </p>
                        </div> 
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>



<section id="about-container" data-background-color="gray">
    <div class="container">

      <div class="row justify-content-md-center">
        <div class="col-lg-2">
        </div>

        <div class="col-lg-8">

          <div class="card" data-background-color="black">
              <div class="card-block content-danger">
              <h3> <i class="now-ui-icons objects_diamond"></i> Get A Referral Bonus </h3>
            <p> For every ticket you sell with the below link, you'll get 10xvg at the drawing </p>
            <div class="alert alert-info" role="alert">
              https://www.xvglotto.com?referralId=YOUR PAYOUT ADDRESS HERE
            </div>
            </div>
          </div>

          <div class="card" data-background-color="black">

          <div class="card-block content-danger">
            <h3> <i class="now-ui-icons emoticons_satisfied"></i> About XVG Lotto </h3>
          <p> This lotto was created to help fund advertising of Verge Currency. I don't have any affiliation with XVG. </p>
          <p> Currently, each ticket sale will pay for the following: </p>
          <ul>
            <li> 1% - Server & Site fee </li>
            <li> 10% - Seed the following weeks lotto pot </li>
            <li> 20% - XVG Marketing Team </li>
            <li> 69% - Added to this weeks lotto pot </li>
          </ul>
          <p class="text-info">
              TICKET SALES WILL BE STOPPED 2 HOURS PRIOR TO DRAWING TO ALLOW ALL TICKETS TO CLEAR
              Drawings will take place once a week on Sunday 5pm EST
          </p>
          </div>
          </div>
        </div>



        <div class="col-lg-2">
        </div>
      </div>

  </div>
</section>

<footer class="footer " data-background-color="black">
            <div class="container">
                <nav>
                    <ul>
                        <li>
                            <a href="https://www.vergecurrency.com">
                                Learn More About Verge
                            </a>
                        </li>
                    </ul>
                </nav>
                <div class="copyright">
                     Design by
                    <a href="https://www.twitter.com/tonigemayel" target="_blank">Toni Gemayel</a>.
                </div>
            </div>
        </footer>



				
<!-- 				<div class="panel panel-default">
				<div class="panel panel-heading">Referral Bonus!</div>
				<div class="panel panel-body">
				<p>For every ticket you sell with the below link, you'll get 10xvg at the drawing </p>
				<h3 style="font-size:20" class="label label-info">https://www.xvglotto.com?referralId=YOUR PAYOUT ADDRESS HERE</h3>
				</div>
				</div> -->
				


<!--   Core JS Files   -->
<script src="./assets/js/core/jquery.3.2.1.min.js" type="text/javascript"></script>
<script src="./assets/js/core/popper.min.js" type="text/javascript"></script>
<script src="./assets/js/core/bootstrap.min.js" type="text/javascript"></script>
<!--  Plugin for Switches, full documentation here: http://www.jque.re/plugins/version3/bootstrap.switch/ -->
<script src="./assets/js/plugins/bootstrap-switch.js"></script>
<!--  Plugin for the Sliders, full documentation here: http://refreshless.com/nouislider/ -->
<script src="./assets/js/plugins/nouislider.min.js" type="text/javascript"></script>
<!--  Plugin for the DatePicker, full documentation here: https://github.com/uxsolutions/bootstrap-datepicker -->
<script src="./assets/js/plugins/bootstrap-datepicker.js" type="text/javascript"></script>
<!-- Control Center for Now Ui Kit: parallax effects, scripts for the example pages etc -->
<script src="./assets/js/now-ui-kit.js?v=1.1.0" type="text/javascript"></script>
</script>


</html>
