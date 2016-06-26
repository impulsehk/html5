<?php


// Setup class


session_start();


include("includes/db.conn.php");


include("includes/conf.class.php");


include("includes/mail.class.php");





$paymentGatewayDetails = $bsiCore->loadPaymentGateways();


$bsiMail = new bsiMail();





require_once('paypal.class.php');  // include the class file








$p = new paypal_class;             // initiate an instance of the class


// $p->paypal_url = 'https://www.sandbox.paypal.com/cgi-bin/webscr';   // testing paypal url 


$p->paypal_url = 'https://www.paypal.com/cgi-bin/webscr';     // paypal url


            


// setup a variable for this script (ie: 'http://www.micahcarrick.com/paypal.php')


$this_script = 'http://'.$_SERVER['HTTP_HOST'].$_SERVER['PHP_SELF'];





// if there is not action variable, set the default action of 'process'


if (empty($_GET['action'])) $_GET['action'] = 'process';  





switch ($_GET['action']) {


	case 'process':      // Process and order...    	   


		$p->add_field('business', $paymentGatewayDetails['pp']['account']);


		$p->add_field('return', $this_script.'?action=success');


		$p->add_field('cancel_return', $this_script.'?action=cancel');


		$p->add_field('notify_url', $this_script.'?action=ipn');


		$p->add_field('item_name', $bsiCore->config['conf_portal_name']);


		$p->add_field('invoice', $_POST['invoice']);


		$p->add_field('currency_code', $bsiCore->config['conf_currency_code']); 


		$p->add_field('amount', $_POST['amount']);


		mysql_query("update bsi_bookings set client_id=".$_SESSION['client_id2012']." where booking_id='".$_SESSION['bookingId']."'");		


		$p->submit_paypal_post(); // submit the fields to paypal


		// $p->dump_fields();      // for debugging, output a table of all the fields


      break;


      


	case 'success':      // Order was successful... 


		header("location:booking-confirm.php");


		break;


      


	case 'cancel':       // Order was canceled...		

    $hotelsql= mysql_query("select hotel_name,city_name,hotel_id from `bsi_hotels`  where hotel_id=".$_SESSION['hotel_id']);
		$hotelname = mysql_fetch_assoc($hotelsql);
		header("location:".$hotelname['city_name'].'/'.str_replace(" ","-",strtolower(trim($hotelname['hotel_name']))).'-'.$hotelname['hotel_id'].'.html');
		// The order was canceled before being completed. 
      //header("location:checkout_step2.php");    

		//echo "<html><head><title>Canceled</title></head><body><h3>The order was canceled.</h3>";


		//echo "</body></html>";      


		break;


      


	case 'ipn':          // Paypal is calling page for IPN validation...     


      


	if ($p->validate_ipn()) {


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