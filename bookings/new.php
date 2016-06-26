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
// code is roomtype id
$code = $_GET['code'];

$showBuffer = false;
$Hostel = new Model('bsi_hotels', 'hotel_id');
$RoomType = new Model('bsi_roomtype', 'roomtype_id');
$PricePlan = new PriceModel();
$Reservation = new Model('bsi_reservation', 'id');
$Rooms = new Rooms();

$roomTypes = $RoomType->find( $code );
// var_dump($roomTypes['hotel_id']);
$hostel = $Hostel->find( $roomTypes['hotel_id'] );
// var_dump($hostel);
$price = $PricePlan->finding($hostel['hotel_id'], $code);
$total = $price[0][strtolower(date("D"))];
// var_dump($total);
$rooms = $Rooms->get_reserve($hostel['hotel_id'], $code);


if (sizeof($rooms) > 0) {
	$booking_id = 'SPK'.time();
	$Reservation->insert(
		array(
			'booking_id' => $booking_id,
			'roomtype_id' => $code,
			'room_id' => $rooms[0][0],
			'boking_status' => 0
		)
	);
	$_SESSION['reserved_booking_id'] = $booking_id;
	var_dump('should reserved');
}
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
		<link rel="stylesheet" href="../css/checkbox.css" />
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
				<h3>Leave us your name to get your room</h3>
			</div>
			<div class="content-container">
				<div class="checkin-box booking">
					<form id="booking-form" action="../bookings/handlePayment.php?action=process" accept-charset="UTF-8" method="post">
						<input type="hidden" name="UTF-8" value="✓">
						<input type="hidden" name="authenicity_token" value="">
						<div class="contact-form">
							<div class="form-box-content">
								<div class="form-group">
									<input id="customer" type="text" value="" class="form-control booking-input" name="customer" placeholder="Name in Full">
									<span class="error-message customer"></span>
									<input id="contactemail" type="text" value="" class="form-control booking-input" name="contactemail" placeholder="E-mail">
									<span class="error-message contactemail"></span>
									<input id="phone" type="text" value="" class="form-control booking-input" name="phone" placeholder="phone">
									<span class="error-message phone"></span>
									<input type="text" class="hidden" value="<?= date('D') ?>" name="check_in">
									<input type="text" class="hidden" value="<?= $code ?>" name="code">
									<input type="text" class="hidden" value="<?= $hostel['hotel_id'] ?>" name="hostel_id">
									<input type="text" class="hidden" value="<?= $total ?>" name="subtotal">
									<input type="text" class="hidden" value="pp" name="gateway_code">
									<input type="submit" name="commit" value class="hidden" id="submit_customer">
									<input type="checkbox" class="hidden" id="agree-term" name="agree-term" value="OFF">
								</div>
							</div>
						</div>
					</form>	
				</div>
				<div class="content-details payment">
					<h3>PAYMENT DETAILS</h3>
					<hr/>
					<h3><?= $hostel['hotel_name'] ?></h3>
					<p class="address"><?= $hostel['address_1'].$hostel['address_2']?></p>
					<div class="list-row">
						<div>Check in Date:</div>
						<div><?= date("d / m / Y") ?></div>
					</div>
					<div class="list-row">
						<div>Duration:</div>
						<div><?= $roomTypes['roomtype_name'] ?></div>
					</div>
					<hr/>
				</div>
				<div class="content-terms">
					<h4>important notice</h4>
					<?= $hostel['hotel_policies']?>
					<div class="terms">
						<div class="roundedOne" style="margin: 0;">
							<label id="roundedOne"></label>
						</div>
						<div class="words return-condition-button">Also check our <span>cancelation policy</span>.</div>
					</div>

				<div class="overlay-wrapper return-condition">
					<div class="note-box">
						<h4>return condition</h4>
						<?= $hostel['terms_n_cond'] ?>
						<div class="close-button">close</div>
					</div>
				</div>

				</div>
				<div class="checkin-box payment">
					<div class="content-form">
						<div class="form-group">
							<?php if (sizeof($rooms) > 0) : ?>
								<div type="submit" class="btn btn-block go-button" id="paypal">$<?= (int) $total ?></div>
							<?php else : ?>
								<button disabled type="reset" class="btn btn-block go-button" id="no-room">NOT AVAILABLE</button>
							<?php endif ?>
						</div>
					</div>
				</div>
			</div>

			<!-- footer -->
			<?php include("../layout/footer.php"); ?>
			<!-- -->
		</div>
	</body>
</html>