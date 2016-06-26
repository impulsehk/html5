<?php 
session_start();
include("../models/model.php");
include("../includes/db.conn.php"); 
include("../includes/conf.class.php");
// include("../includes/language.php");
?>

<!doctype html>
<html>
	<?php include("../layout/head.php"); ?>
	<body>
		<div class="app-container">
			<!-- navbar -->
			<div class="navbar-container">
				<div class="navbox">
			    <button type="button" class="navbar-toggle collapsed menu-icon" data-toggle="collapse" data-target="#nav-main-menu" aria-expanded="false">
			      <span class="sr-only">Toggle navigation</span>
			    </button>
				</div>
				<div class="navbox" style="flex: 4 0;">
					<div class="navbox-brand"></div>
				</div>
				<div class="navbox">
					<div class="lang-icon"></div>	
				</div>
			</div>
			<div class="navbar navbar-default">
				<div class="collapse navbar-collapse" id="nav-main-menu">
					<ul class="nav navbar-nav">
						<li><a href="../index-new.php">Hostel</a></li>
						<li><a href="../customer/index.php">Customer</a></li>
						<li><a href="../marketing/index.php">Investment & Marketing</a></li>
						<li><a href="../contact/index.php">Contact Us</a></li>
					</ul>
				</div>
			</div>
			<!-- navbar -->

			<div class="content-container pages">
			  <div class="pill-container">
			    <ul class="nav nav-pills nav-justified">
			      <li class="faq active">FAQ</li>
			      <li class="booking">Booking</li>
			    </ul>    
			  </div>
			  <div class="content-faq active">
			  	<h4>Qusetion</h4>
			  	<p>answer</p>
			  	<h4>Qusetion</h4>
			  	<p>answer</p>
			   	<h4>Qusetion</h4>
			  	<p>answer</p>
			  </div>
				<div class="content-booking">
					<h4>How to make a booking?</h4>
					<p>How to make a booking in feelspark.com?</p>
					<ul class="list-group">
						<li class="list-group-item">Search the hostel by location</li>
						<li class="list-group-item">Select the hostel and room type</li>
						<li class="list-group-item">Enter your details (Nickname, email address, mobile)</li>
						<li class="list-group-item">Pay the deposit (20% of total rent) by credit card or PayPal</li>
						<li class="list-group-item">Screen Cap / Note your reference number</li>
						<li class="list-group-item">Get to your hostel</li>
					</ul>
					<p>Note.</p>
					<p>The room is reserved for you for 30mins (For Hourly room)</p>
					<p>The room is reserved for you for 2 hour ( For over night room)</p>
					<p>We are able to edit it .....</p>
				</div>
			</div>
	
			<!-- footer -->
			<?php include("../layout/footer.php"); ?>
			<!-- -->
		</div>
	</body>
</html>