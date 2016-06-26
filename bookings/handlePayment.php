<?php
session_start();
include("../models/model.php");
require_once("../paypal.class.php");
include("../includes/conf.class.php");

// include("includes/db.conn.php");
// include("../includes/booking-process2.class.php");
include("../includes/mail.class.php");
// require 'mailer/PHPMailerAutoload.php';

global $bsiCore;

// config trial
// var_dump($getConfig);
//
$action = $_GET['action'];
// handle success action here instead
if ($action == 'success') {
	$booking_id = $_GET['spk'];
	$code = $_GET['code'];
	$_SESSION['bid'] = null;
	$_SESSION['cid'] = null;
	$_SESSION['bid'] = $booking_id;
	$_SESSION['cid'] = $code;
	header("Location:create.php");
}

$token = $_POST['authenicity_token'];
$customer = $_POST['customer'];
$email = $_POST['contactemail']; // no validation
$phone = $_POST['phone'];
$gateway_code = $_POST['gateway_code'];

$booking_id = $_SESSION['reserved_booking_id'];
var_dump($booking_id);

$code = $_POST['code'];

$Hostel = new Model('bsi_hotels', 'hotel_id');
$RoomType = new Model('bsi_roomtype', 'roomtype_id');
$Client = new Model('bsi_clients', 'client_id');
$PricePlan = new PriceModel();
$Gateway = new Model('bsi_payment_gateway', 'id');
$Booking = new Model('bsi_bookings', 'booking_id');
$Reservation = new Model('bsi_reservation', 'id');
$Rooms = new Rooms();
$Email = new Model('bsi_email_contents', 'id');
// config model, needs in every where, fuck
// $Config = new Configure();
// $sendEmail = new bsiMail();
// var_dump($sendEmail);
// var_dump($Config);


$roomType = $RoomType->find( $code );
// var_dump($roomTypes['hotel_id']);
$hostel = $Hostel->find( $roomType['hotel_id'] );
// var_dump($hostel);
$price = $PricePlan->finding($hostel['hotel_id'], $code);
$total = $price[0][strtolower(date("D"))];
$rooms = $Rooms->get_reserve($hostel['hotel_id'], $code);

// var_dump($rooms);
// var_dump($room);
// $room_no = sizeof($room);
// var_dump( sizeof($room) );
// var_dump($hostel['hotel_id']);
// var_dump($code);
// var_dump($total);
$confirmMail = $Email->find(1);

// $config = $Configure->key();
// var_dump($config);
if ($action == 'process') {
	// create client
	$Client->insert(array('first_name'=>$customer, 'phone'=>$phone, 'email'=>$email, 'ip'=>$_SERVER['REMOTE_ADDR']) );
	$client = $Client->last();
	$lack = 60*60*6;
	$one_day = 60*60*18;
	$booking_id = 'SPK'.time();
	if ($gateway_code == 'poa') {
		$payment_success = 1;
	} else {
		$payment_success = 0;
	}
	if (sizeof($rooms) > 0) {
		$Booking->insert(
			array(
				'booking_id'=> $booking_id,
				'hotel_id'=>$hostel['hotel_id'],
				'checkin_date'=>date('Y-m-d', time() - $lack),
				'checkout_date'=>date('Y-m-d', time() + $one_day),
				'client_id'=>$client['client_id'],
				'child_count'=>0,
				'total_cost'=>$total,
				'payment_amount'=>0,
				'payment_type'=>$gateway_code,
				'reviewid'=>substr(uniqid(), -8, 8),
				'payment_success'=>$payment_success
			)
		);
		$Reservation->insert(
			array(
				'booking_id' => $booking_id,
				'roomtype_id' => $code,
				'room_id' => $rooms[0][0],
				'boking_status' => 0
			)
		);
	} else {
		// handle all room reserved
	}
}




// create booking
// var_dump(loadEmailContent(1));

// // function loadEmailContent($id) {
//   //   $emailContent=array();
// 		$sql = mysql_query("SELECT * FROM bsi_email_contents WHERE id = '1'");
// 		$currentrow = mysql_fetch_assoc($sql);	
// 		$emailContent =  array('subject'=> $currentrow["email_subject"], 'body'=> $currentrow["email_text"]);			
// 		var_dump($emailContent);
// 		// mysql_free_result($sql);	
// 		// return  $emailContent;	
// // }

// email to client function (require varify)
function emailEmitting($emailContent, $receiver) {

	$emailBody       = "Dear ".$receiver.",<br><br>";
	$emailBody      .= $emailContent['body'];
// 	// $emailBody      .= '<br><br>'.$bookprs->invoiceHtml;
	// Config break, hard code
	$emailBody .= '<br><br>Regards,<br>'.'Spark - Book the Room Tonight'.'<br>'.'97009865';
	$emailBody .= '<br><br><font style=\"color:#F00; font-size:10px;\">[ You will need to carry a print out of this e-mail and present it to the hotel on arrival and check-in. This e-mail is the confirmation voucher for your booking. ]</font>';
	// $returnMsg = $bsiMail->sendEMail($email, $getemailcontent['subject'], $emailBody, $booking_id, 1);
// 	if($returnMsg == true){		
// 		$notifyEmailSubject = "Booking no.".$booking_id." - Notification of Room Booking by ".$customer;
// 		var_dump($getemailcontent);				
// 		// this one probably send email to hotel
// 		$bsiMail->sendEMail($bsiCore->config['conf_portal_email'], $notifyEmailSubject, $bookprs->invoiceHtml);	
// 		// this one probably send email to client
// 		$bsiMail->sendEMail($bookprs->bookingArray['email_addr'], $notifyEmailSubject, $bookprs->invoiceHtml); 	
// 		//$bsiCore->sendtestEMail($bsiCore->config['conf_portal_email'], $notifyEmailSubject, $bookprs->invoiceHtml);	
// 		//$bsiCore->sendtestEMail($bookprs->bookingArray['email_addr'], $notifyEmailSubject, $bookprs->invoiceHtml); 	
// 		header('Location: booking-confirm.php?success_code=1');
// 		die;
// 	}else {		
// 		header('Location: booking-failure.php?error_code=25');
// 		die;
// 	}
	// var_dump($returnMsg);
	// var_dump($emailBody);
}


$Paypal = new paypal_class();
// redirect point after payment
$this_script = 'http://'.$_SERVER['HTTP_HOST'].$_SERVER['PHP_SELF'];
// payment url:
$Paypal->paypal_url = 'https://www.sandbox.paypal.com/cgi-bin/webscr';
// $Paypal->paypal_url = 'https://www.paypal.com/cgi-bin/webscr';
switch ($action) {
	case 'process':
		switch ($gateway_code) {
			case 'pp':
				// $Booking->update($booking_id, 'payment_success', 1);

				$Paypal->add_field('business', $Gateway->find(1)['account'] );
				$Paypal->add_field('return', $this_script.'?action=success&spk='.$booking_id.'&code='.$code);
				$Paypal->add_field('cancel_return', $this_script.'?action=cancel');
				$Paypal->add_field('notify_url', $this_script.'?action=ipn');
				$Paypal->add_field('item_name', "Spark - Book the Room Tonight");
				$Paypal->add_field('invoice', $booking_id);
				$Paypal->add_field('currency_code', 'HKD');
				$Paypal->add_field('amount', $total);
				$Paypal->submit_paypal_post();
				// header("Location:create.php");
			break;
			case 'poa':
				$_SESSION['bid'] = null;
				$_SESSION['cid'] = null;
				$_SESSION['bid'] = $booking_id;
				$_SESSION['cid'] = $code;
				// var_dump($Paypal);
				// var_dump($customer);
				// emailEmitting($confirmMail, $customer, $Config);
				// this will directly goto create.php
				header("Location:create.php");
				// header("Location:".$this_script.'?action=ipn');
			break;
		}
	break;
	case 'success':
		// booking need to fetch again if success

		header("Location:create.php");
	break;
	case 'failed':
	case 'cancel':
		header("Location:../index-new.php");
	break;
	case 'ipn':
		if ($Paypal->validate_ipn()) {
			mysql_query("UPDATE bsi_bookings SET payment_success=true, payment_type='pp', payment_amount=".$p->ipn_data['payment_gross'].", payment_txnid='".$p->ipn_data['txn_id']."', paypal_email='".$p->ipn_data['payer_email']."' ,confirmation_time=NOW() WHERE booking_id='".$p->ipn_data['invoice']."'");
			$invoiceROWS = mysql_fetch_assoc(mysql_query("SELECT client_name, client_email, invoice FROM bsi_invoice WHERE booking_id='".$p->ipn_data['invoice']."'"));
			$invoiceHTML = $invoiceROWS['invoice'];		
			//$invoiceHTML.= '<br><br><table style="font-family:Verdana, Geneva, sans-serif; font-size: 12px; bgcolor:#999999; width:700px; border:none;" cellpadding="4" cellspacing="1"><tr><td align="left" colspan="2" style="font-weight:bold; font-variant:small-caps; background:#ffffff">Payment Details</td></tr><tr><td align="left" width="30%" style="font-weight:bold; font-variant:small-caps; background:#ffffff">Payment Option</td><td align="left" style="background:#ffffff">Paypal</td></tr><tr><td align="left" width="30%" style="font-weight:bold; font-variant:small-caps; background:#ffffff">Payer E-Mail</td><td align="left" style="background:#ffffff">'.$p->ipn_data['payer_email'].'</td></tr><tr><td align="left" style="font-weight:bold; font-variant:small-caps; background:#ffffff">Transaction ID</td><td align="left" style="background:#ffffff">'.$p->ipn_data['txn_id'].'</td></tr></table>';
			$reviewsql= mysql_query("SELECT `reviewid` FROM `bsi_bookings` WHERE booking_id = '".$_SESSION['bookingId']."' ");
			$rowreview = mysql_fetch_assoc($reviewsql);
			$invoiceHTML.= '
			<table style="font-family:Arial, Helvetica, sans-serif; font-size:14px; width:100%;" border="1" cellpadding="0" cellspacing="0" >
        <tbody>
          <tr bgcolor="#01b7f2">
            <th colspan="4" style="padding:5px 0; color:#ffffff; font-weight:bold; font-size:16px;">Payment Details</th>
          </tr>
          <tr>
          	<td width="25%" style="padding:5px 0"><span style="padding-left:10px;">Payment Option</span></td>
            <td width="75%" colspan="3" bgcolor="#cccccc"><span style="padding-left:10px;">Paypal</span></td>
          </tr>
			   	<tr>
            <td width="25%" style="padding:5px 0"><span style="padding-left:10px;">Payer E-Mail</span></td>
            <td width="75%" colspan="3" bgcolor="#cccccc"><span style="padding-left:10px;">'.$p->ipn_data['payer_email'].'</span></td>
         	</tr>
				  <tr>
            <td width="25%" style="padding:5px 0"><span style="padding-left:10px;">Transaction ID</span></td>
            <td width="75%" colspan="3" bgcolor="#cccccc"><span style="padding-left:10px;">'.$p->ipn_data['txn_id'].'</span></td>
          </tr>
        </tbody>
      </table>
		  <br/><br/> 
			<table style="font-family:Arial, Helvetica, sans-serif; font-size:14px; width:100%;" border="1" cellpadding="0" cellspacing="0" >
				<tbody>
					<tr bgcolor="#01b7f2">
						<th colspan="4" style="padding:5px 0; color:#ffffff; font-weight:bold; font-size:16px;">Tell us what you think</th>
					</tr>
					<tr>
						<td width="25%" style="padding:5px 0"><span style="padding-left:10px;">Review & feedback</span></td>
						<td width="75%" colspan="3" bgcolor="#cccccc"><span style="padding-left:10px;"><a href="http://feelspark.com/review/'.$rowreview['reviewid'].'" target="_blank"> http://feelspark.com/review/'.$rowreview['reviewid'].'</a></span></td>
					</tr>
				</tbody>
			</table>
			<!-- problem -->
								</td>
						  </tr>
						</tbody>
				  </table>
				  <br/><br/> 
				 </td>
				</tr>
		  </tbody>
		 </table>';
		mysql_query("UPDATE bsi_invoice SET invoice = '".$invoiceHTML."' WHERE booking_id='".$p->ipn_data['invoice']."'");

		$emailBody = "Dear ".$invoiceROWS['client_name'].",<br><br>";
		$emailBody .= html_entity_decode($bsiMail->emailContent['body'])."<br><br>";
		$emailBody .= $invoiceHTML;
		$emailBody .= "<br><br>Regards,<br>".$bsiCore->config['conf_portal_name'].'<br>'.$bsiCore->config['conf_portal_phone'];
		$emailBody .= "<br><br><font style=\"color:#F00; font-size:10px;\">[ You will need to carry a print out of this e-mail and present it to the hotel on arrival and check-in. This e-mail is the confirmation voucher for your booking. ]</font>";
		$bsiMail->sendEMail($invoiceROWS['client_email'], $bsiMail->emailContent['subject'], $emailBody, $p->ipn_data['invoice'], 1);

		/* Notify Email for Hotel about Booking */

		$notifyEmailSubject = "Booking no.".$p->ipn_data['invoice']." - Notification of Room Booking by ".$invoiceROWS['client_name'];
		$bsiMail->sendEMail($bsiCore->config['conf_portal_email'], $notifyEmailSubject, $invoiceHTML);			
	}
	break;
}


?>