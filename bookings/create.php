<?php 
session_start();
include("../models/model.php");
include("../includes/db.conn.php"); 
include("../includes/conf.class.php");
// include("../includes/language.php");
// if(isset($_SESSION['language'])){
// 	$htmlCombo=$bsiCore->getbsilanguage($_SESSION['language']);
// }else{
// 	$htmlCombo=$bsiCore->getbsilanguage(); 
// }
?>

<?php
$booking_id = $_SESSION['bid'];
// $booking_id = $_GET['spk'];
// $code = $_GET['code'];
// $token = $_POST['authenicity_token'];
// $customer = $_POST['customer'];
// $email = $_POST['contactemail'];
// $phone = $_POST['phone'];

$code = $_SESSION['cid'];
$showBuffer = false;
$Hostel = new Model('bsi_hotels', 'hotel_id');
$RoomType = new Model('bsi_roomtype', 'roomtype_id');
$PricePlan = new PriceModel();
$Booking = new Model('bsi_bookings', 'booking_id');
$Client = new Model('bsi_clients', 'client_id');
$current_booking = $Booking->find($booking_id);
$client = $Client->find( $current_booking['client_id'] );
$customer = $client['first_name'];
$email = $client['email'];
$phone = $client['phone'];

$roomType = $RoomType->find( $code );
// var_dump($roomTypes['hotel_id']);
$hostel = $Hostel->find( $roomType['hotel_id'] );
// var_dump($hostel);
$price = $PricePlan->finding($hostel['hotel_id'], $code);
$total = $price[0][strtolower(date("D"))];
// var_dump($total);

// update booking here:
$Booking->update($booking_id, 'payment_success', 1);
?>

<!doctype html>
<html>
	<head>
		<meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<link rel="stylesheet" href="../css/bootstrap.css">
		<link rel="stylesheet" href="../fonts/stylesheet.css">
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css">
		<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.10.0/css/bootstrap-select.min.css">
		<link rel="stylesheet" href="../js/cssmenu/styles.css">
		<link rel="stylesheet" href="../css/component.css">
		<script src="../js/jquery.min.js"></script>
		<script src="../js/cssmenu/script.js"></script>
		<script type="text/javascript" src="../js/jquery.easing.1.3.js"></script>
		<script src="../src/jquery.anyslider.js"></script>
		<script src="../js/bootstrap.js"></script>
		<script src="../js/moment-with-locales.js"></script>
		<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.10.0/js/bootstrap-select.min.js"></script>
		<script type="text/javascript" src="../js/bootstrap-datepicker.js"></script>
		<script type="text/javascript" src="../js/new-layout.js"></script>
	</head>
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

			<div class="title-container">
				<h3>Congratulations! Your booking has been confirmed</h3>
				<p>Screen shot this page and show when you check in your room</p>
			</div>
			<div class="content-container">
				<div class="content-details">
					<h3>Booking Details</h3>
					<hr/>
					<h3><?= $hostel['hotel_name'] ?></h3>
					<p class="address"><?= $hostel['address_1'].$hostel['address_2'] ?></p>
					<div class="list-row">
						<div>Hostel phone:</div>
						<div><?= $hostel['phone_number'] ?></div>
					</div>
					<div class="list-row">
						<div>References number:</div>
						<div><b><?= $booking_id ?></b></div>
					</div>
					<div class="list-row">
						<div>Client Name:</div>
						<div><?= $customer ?></div>
					</div>
					<div class="list-row">
						<div>Check in Date:</div>
						<div><?= date("d M Y") ?></div>
					</div>
					<div class="list-row">
						<div>Duration:</div>
						<div><?= $roomType['type_name'] ?></div>
					</div>
					<div class="list-row">
						<div>Sub total:</div>
						<div><b>$<?= $total ?></b></div>
					</div>
					<div class="list-row">
						<div>Payment:</div>
						<div>done by Paypal</div>
					</div>
					<hr/>
					<h4>Thank You</h4>
					<p>leave a comment</p>
				</div>
			</div>

			<!-- footer -->
			<?php include("../layout/footer.php"); ?>
			<!-- -->
		</div>
	</body>
</html>
