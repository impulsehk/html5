<?php
session_start();
include("includes/db.conn.php");
include("includes/conf.class.php");

include("includes/booking-process2.class.php");

include("includes/mail.class.php");

require 'mailer/PHPMailerAutoload.php';

$pos2 = strpos($_SERVER['HTTP_REFERER'], $_SERVER['SERVER_NAME']);

if(!$pos2){

	header('Location: booking-failure.php?error_code=9');

	exit;			

} 



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

	if($bookprs->agentExistence){

		//mysql_query("UPDATE bsi_bookings SET payment_success=true,`status`=true,payment_type='poa', payment_amount='".$bookprs->totalPaymentAmount."', agent='".$bookprs->agentExistence."', client_id=".$bookprs->clientId.", agent_id=".$bookprs->agentId.", commission='".$bookprs->commission."' WHERE booking_id = '".$bookprs->bookingId."'"); 
		
		mysql_query("UPDATE bsi_bookings SET payment_success=true, payment_type='poa', payment_amount='".$bookprs->totalPaymentAmount."', agent='".$bookprs->agentExistence."', client_id=".$bookprs->clientId.", agent_id=".$bookprs->agentId.", commission='".$bookprs->commission."' ,confirmation_time=NOW() WHERE booking_id = '".$bookprs->bookingId."'"); 

	}else{

		//mysql_query("UPDATE bsi_bookings SET payment_success=true,`status`=true,payment_type='poa', client_id=".$bookprs->clientId." WHERE booking_id = '".$bookprs->bookingId."'");	

mysql_query("UPDATE bsi_bookings SET payment_success=true, payment_type='poa', client_id=".$bookprs->clientId." ,confirmation_time=NOW() WHERE booking_id = '".$bookprs->bookingId."'");	

	}

		  

	$getemailcontent = $bsiCore->loadEmailContent(1);

	$emailBody       = "Dear ".$bookprs->clientName.",<br><br>";

	$emailBody      .= $getemailcontent['body'];
	
	$emailBody      .= '<br><br>'.$bookprs->invoiceHtml;
$emailBody .= '<br><br>Regards,<br>'.$bsiCore->config['conf_portal_name'].'<br>'.$bsiCore->config['conf_portal_phone'];

	$emailBody .= '<br><br><font style=\"color:#F00; font-size:10px;\">[ You will need to carry a print out of this e-mail and present it to the hotel on arrival and check-in. This e-mail is the confirmation voucher for your booking. ]</font>';		
$returnMsg = $bsiMail->sendEMail($bookprs->clientEmail, $getemailcontent['subject'], $emailBody, $bookprs->bookingId, 1);
//$returnMsg =$bsiCore->sendtestEMail($bookprs->clientEmail, $getemailcontent['subject'], $emailBody,$bookprs->bookingId, 1);

	if($returnMsg == true){		

		$notifyEmailSubject = "Booking no.".$bookprs->bookingId." - Notification of Room Booking by ".$bookprs->clientName;				

		$bsiMail->sendEMail($bsiCore->config['conf_portal_email'], $notifyEmailSubject, $bookprs->invoiceHtml);	
		 
		$bsiMail->sendEMail($bookprs->bookingArray['email_addr'], $notifyEmailSubject, $bookprs->invoiceHtml); 	
		//$bsiCore->sendtestEMail($bsiCore->config['conf_portal_email'], $notifyEmailSubject, $bookprs->invoiceHtml);	
		//$bsiCore->sendtestEMail($bookprs->bookingArray['email_addr'], $notifyEmailSubject, $bookprs->invoiceHtml); 	

		header('Location: booking-confirm.php?success_code=1');

		die;

	}else {		

		header('Location: booking-failure.php?error_code=25');

		die;

	}		

}


function processCreditCard(){

	global $bookprs;

	global $bsiCore;

	

	$bsiMail = new bsiMail();

	

	mysql_query("UPDATE bsi_bookings SET payment_success=true, payment_type='cc', client_id=".$bookprs->clientId.", payment_amount=".$bookprs->payment_amount." ,confirmation_time=NOW() WHERE booking_id = '".$bookprs->bookingId."'");

$invoiceROWS = mysql_fetch_assoc(mysql_query("SELECT client_name, client_email, invoice FROM bsi_invoice WHERE booking_id='".$bookprs->bookingId."'"));

	$emailBody  = "Dear ".$invoiceROWS['client_name'].",<br><br>";

	$emailBody .= $bsiMail->emailContent['body']."<br><br>";

	$emailBody .= $invoiceROWS['invoice'];

	$emailBody .= '<br><br>Regards,<br>'.$bsiCore->config['conf_portal_name'].'<br>'.$bsiCore->config['conf_portal_phone'];

	$emailBody .= '<br><br><font style=\"color:#F00; font-size:10px;\">[ You will need to carry a print out of this e-mail and present it to the hotel on arrival and check-in. This e-mail is the confirmation voucher for your booking. ]</font>';		

	

	$returnMsg = $bsiMail->sendEMail($invoiceROWS['client_email'], $bsiMail->emailContent['subject'], $emailBody, $bookprs->bookingId, 1); 

	if ($returnMsg == "Message successfully sent!") {		

		/* Notify Email for Hotel about Booking */		

		$notifyEmailSubject = "Booking no.".$bookprs->bookingId." - Notification of Room Booking by ".$invoiceROWS['client_name'];				

		$notifynMsg = $bsiMail->sendEMail($bsiCore->config['conf_hotel_email'], $notifyEmailSubject, $invoiceROWS['invoice']);

		$notifynMsg = $bsiMail->sendEMail($bookprs->bookingArray['email_addr'], $notifyEmailSubject, $invoiceROWS['invoice']); 	

		header('Location: booking-confirm.php?success_code=1');

		die; 

	}else {

		header('Location: booking-failure.php?error_code=25');

		die;

	}

}


function processPayPal(){

	global $bookprs;

	

	echo "<script language=\"JavaScript\">";

	echo "document.write('<form action=\"paypal.php\" method=\"post\" name=\"formpaypal\">');";

	echo "document.write('<input type=\"hidden\" name=\"amount\"  value=\"".number_format($bookprs->totalPaymentAmount, 2, '.', '')."\">');";

	echo "document.write('<input type=\"hidden\" name=\"invoice\"  value=\"".$bookprs->bookingId."\">');";

	echo "document.write('</form>');";

	echo "setTimeout(\"document.formpaypal.submit()\",500);";

	echo "</script>";		

}



function processOther(){

	/* not implemented yet */

	header('Location: booking-failure.php?error_code=22');

	die;

}



?>