<?php
include("access.php");
if(!isset($_SESSION['hotel_id']) || !isset($_SESSION['RoomType_Capacity_Qty'])){
	header("location:admin_room_block.php");
	exit;
}
include("../includes/db.conn.php");
include("../includes/conf.class.php");
include("../includes/admin.class.php");
include("../includes/admin_bookingProcess2.class.php");
include("../includes/mail.class.php");
$pageid = 27;
$user_id = $_SESSION['cpid'];
$bsiAdminMain->pageAccess($user_id, $pageid);
switch($bookprs->paymentGatewayCode){
	case "poa":
		processPayOnArrival();
		break;
		
	case "pp": 		
		processPayPal();
		break;	
					
	case "2co":
		process2Checkout();
		break;	
		
	case "cc":
		processCreditCard();
		break;			
		
	case "admin":
		processPayOnArrival();
		break;	
				
	case "an":
		processAuthorizeDotNet();
		break;
		
	default:
		processOther();
}
function processPayOnArrival(){
	global $bookprs;
	global $bsiCore;
	$bsiMail = new bsiMail();
	mysql_query("UPDATE bsi_bookings SET payment_success=true, payment_type='poa', client_id=".$bookprs->clientId." WHERE booking_id = '".$bookprs->bookingId."'");	
		
	$getemailcontent = $bsiCore->loadEmailContent(1);
	
	$emailBody       = "Dear ".$bookprs->clientName.",<br><br>";
	$emailBody      .= html_entity_decode($getemailcontent['body']);	
	$returnMsg = $bsiMail->sendEMail($bookprs->clientEmail, $getemailcontent['subject'], $emailBody, $bookprs->bookingId, 1, 1);
	if($returnMsg == true){		
		$notifyEmailSubject = "Booking no.".$bookprs->bookingId." - Notification of Room Booking by ".$bookprs->clientName;				
		$bsiMail->sendEMail($bsiCore->config['conf_portal_email'], $notifyEmailSubject, $bookprs->invoiceHtml);	
		
		$bsiMail->sendEMail($bookprs->bookingArray['email_addr'], $notifyEmailSubject, $bookprs->invoiceHtml);	
		header('Location: booking-confirm.php?success_code=1');
		die;
	}else {		
		header('Location: booking-failure.php?error_code=25');
		die;
	}		
}
function processOther(){
	/* not implemented yet */
	header('Location: booking-failure.php?error_code=22');
	die;
}
?>