<?php
include("access.php");
include("../includes/db.conn.php");
include("../includes/conf.class.php"); 
include("../includes/details.class.php");	
	$bsibooking      = new bsiBookingDetails(); 
	$bsibooking->generateBookingDetails2(); 
	$pricedata       = array();
	$reservationdata = array();
	$reservationdata = $_SESSION['dvars_details'];
	$bookingId       = $bsiCore->config['conf_bookingid_prefix'].time();
	
	$sql = mysql_query("INSERT INTO bsi_bookings (booking_id, hotel_id, booking_time, checkin_date, checkout_date, client_id, child_count, extra_guest_count, discount_coupon, total_cost, payment_amount, payment_type, special_requests, is_block, payment_success) values('".$bookingId."', ".$bsibooking->hotelid.", NOW(), '".$bsibooking->mysqlCheckInDate."', '".$bsibooking->mysqlCheckOutDate."', '0', 0 , 0, '', '', '', '', '',1, 1)");
	
	foreach($reservationdata as $revdata){
		foreach($revdata['availablerooms'] as $rooms){    
			$sql = mysql_query("INSERT INTO bsi_reservation (booking_id, room_id, roomtype_id) values('".$bookingId."',  ".$rooms['roomid'].", ".$revdata['roomtypeid'].")");
		} 
	}
	unset($_SESSION['hotel_id']);
	header("location:admin_block_room.php");
	
?>