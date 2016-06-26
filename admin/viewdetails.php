<?php 
	include("access.php");
	if(!isset($_GET['booking_id'])){
	  header("location:admin-home.php");
	exit;	
	}
	$pageid = 24;
	include("header.php");
	$bookingid = base64_decode($_GET['booking_id']);
    $bookingid = $bsiCore->ClearInput($bookingid);
	$bid=$_GET['booking_id'];
	if(isset($_GET['hotel_id']))
	{
	$hid=$_GET['hotel_id'];
	}
	if(isset($bookingid)){
		$viewdetailsquery = mysql_query("select DATE_FORMAT(bb.checkin_date, '".$bsiCore->userDateFormat."') AS checkin_date,   
DATE_FORMAT(bb.checkout_date, '".$bsiCore->userDateFormat."') AS checkout_date, bb.checkout_date as end_date, DATE_FORMAT(bb.booking_time, '".$bsiCore->userDateFormat."') AS booking_time, bb.total_cost, bb.payment_type, bb.hotel_id, bb.is_deleted, agent, client_id from bsi_bookings as bb where booking_id='".$bookingid."'");
		 $rowviewdetails = mysql_fetch_assoc($viewdetailsquery);  
			 $clientArr = $bsiAdminMain->getClientInfo($rowviewdetails['client_id']);
			 $clientHtml = '<tr>
								<td style="width:200px">Name</td>
								<td>'.$clientArr['first_name'].'</td>
							</tr>
							<tr>
								<td style="width:200px">Phone</td>
								<td>'.$clientArr['phone'].'</td>
							</tr>';
							/*<tr>
								<td style="width:200px">Address</td>
								<td>'.$clientArr['street_addr']." ".$clientArr['street_addr2'].'</td>
							</tr>';
			$clientHtml2 = 	'<tr>
								<td style="width:200px">Zip</td>
								<td>'.$clientArr['zip'].'</td>
							  </tr>
							  <tr>
								<td style="width:200px">Country</td>
								<td>'.$bsiCore->getCountryName($clientArr['country']).'</td>
							  </tr>';*/
	     $_SESSION['hotel_id'] = $rowviewdetails['hotel_id'];	 
	}
?>
<div class="flat_area grid_16">
  <?php if(isset($_GET['client']) && base64_decode($_GET['client']) == true){?>
<!--<button class="skin_colour round_all" id="pdf_button" title="Print this page" style="float:right;"  onclick="javascript:window.location.href='<?=$_SERVER['HTTP_REFERER']?>'"><span>BACK</span></button>-->

<button name="button" onclick="javascript:window.location.href='<?=$_SERVER['HTTP_REFERER']?>'" id="button" class="button_colour round_all" style="float:right;"><img height="24" width="24" alt="Bended Arrow Right" src="images/icons/small/white/bended_arrow_right.png"><span>Back</span></button>

<?php }else if(isset($_GET['book_type'])){?>
<!--<button class="skin_colour round_all" id="pdf_button" title="Print this page" style="float:right;"  onclick="javascript:window.location.href='<?=$_SERVER['HTTP_REFERER']?>?book_type=<?=$bid?>&hotel_id=<?=$hid?>'"><img src="images/icons/small/white/pdf_documents.png" width="24" height="24" alt="PDF Documents"> <span>BACK</span></button>-->

<button name="button" onclick="javascript:window.location.href='view_booking.php'" id="button" class="button_colour round_all" style="float:right;"><img height="24" width="24" alt="Bended Arrow Right" src="images/icons/small/white/bended_arrow_right.png"><span>Back</span></button>

<!--<button class="skin_colour round_all" id="pdf_button" title="Print this page" style="float:right;"  onclick="javascript:window.location.href='view_booking.php'"><span>BACK</span></button>-->
<?php }else{?>

<button name="button" onclick="javascript:window.location.href='commission.php'" id="button" class="button_colour round_all" style="float:right;"><img height="24" width="24" alt="Bended Arrow Right" src="images/icons/small/white/bended_arrow_right.png"><span>Back</span></button>

	<!--<button class="skin_colour round_all" id="pdf_button" title="Print this page" style="float:right;"  onclick="javascript:window.location.href='commission.php'"><span>BACK</span></button>-->
<?php } ?>
  <h2>Booking Details</h2>
</div>
<div class="box grid_16 round_all">
  <h2 class="box_head grad_colour round_top">&nbsp;&nbsp;</h2>
  <a href="#" class="grabber">&nbsp;</a> <a href="#" class="toggle">&nbsp;</a>
  <div class="block no_padding">
    <table class="static" cellpadding="4">
      <tr>
        <td style="font-size:16px;"><b>CUSTOMER DETAILS</b></td>
        <td></td>
      </tr>
      <?=$clientHtml?>
      <tr>
        <td style="width:200px">Check In</td>
        <td><?=$rowviewdetails['checkin_date']?></td>
      </tr>
      <tr>
        <td style="width:200px">Check Out</td>
        <td ><?=$rowviewdetails['checkout_date']?></td>
      </tr>
      <tr>
        <td style="width:200px">Amount</td>
        <td><?=$rowviewdetails['total_cost']?></td>
      </tr>
      <tr>
        <td style="width:200px">Payment Method</td>
        <td><?=$bsiCore->paymentGateway($rowviewdetails['payment_type'])?></td>
      </tr>
      <tr>
        <td style="width:200px">Booking Date</td>
        <td><?=$rowviewdetails['booking_time']?></td>
      </tr>
     <?php /*?> <?=$clientHtml2?><?php */?>
    </table><br />
    <table class="static" cellpadding="4">
    	<?php $getHotelDetails = $bsiAdminMain->getHotelDetails($rowviewdetails['hotel_id']);
	  		$countryname = mysql_fetch_assoc(mysql_query("select `name` from `bsi_country` where `country_code`='".$getHotelDetails['country_code']."'")); ?>
      <tr><td colspan="2" style="font-size:16px;"><b>Hotel Details</b></td></tr>
      <tr><td style="width:200px">Hotel Name</td><td><?=$getHotelDetails['hotel_name']?></td></tr>
      <tr><td>Address</td><td><?=$getHotelDetails['address_1'].",".$getHotelDetails['address_2'].",".$getHotelDetails['city_name']?></td></tr>
      <tr><td>Province</td><td><?=$getHotelDetails['state']?></td></tr>
      <tr><td>Postal Code</td><td><?=$getHotelDetails['post_code']?></td></tr>
      <tr><td>Country</td><td><?=$countryname['name']?></td></tr>
      <tr><td>Hotel Email</td><td><?=$getHotelDetails['email_addr']?></td></tr>
      <tr><td>Hotel Phone</td><td><?=$getHotelDetails['phone_number']?></td></tr>
      <tr><td>Hotel Fax</td><td><?=$getHotelDetails['fax_number']?></td></tr>
    </table>
    <br />
    <table class="static" cellpadding="8">
      <?=$bsiCore->getInvoiceinfo($bookingid)?>
    </table>
    <br />
    <table class="static" cellpadding="8">
      <tr>
        <td></td>
      </tr>
    </table>
    <br />
	
	 <?php
	 
	    if($rowviewdetails['payment_type'] == "cc"){
			$rowdetail_cc=mysql_fetch_assoc(mysql_query("select * from bsi_cc_info where booking_id ='".$bookingid."'"));
			echo '<table class="static" cellpadding="4">
                  <tr><td>Card Holder Name</td><td>'.$rowdetail_cc['cardholder_name'].'</td></tr>				  
				  <tr><td>Card Type</td><td>'.$rowdetail_cc['card_type'].'</td></tr>				  
				  <tr><td>Card Number</td><td>'.$bsiCore->decryptCard($rowdetail_cc['card_number']).'</td></tr>				  
				  <tr><td>Expiry Date</td><td>'.$rowdetail_cc['expiry_date'].'</td></tr>
				  <tr><td>CCV</td><td>'.$rowdetail_cc['ccv2_no'].'</td></tr>
                 </table>'; 			
		}
		?>
		
    <br />
	
<?php 
$rowdispute=mysql_fetch_assoc(mysql_query("select * from bsi_reservation where booking_id='".$bookingid."'"));

?>

 <table class="static" cellpadding="8">
      <tr>
        <td><b>BOOKING STATUS</b></td>
        <td></td>
        
      </tr>
      <tr>
        <?php
		 $status='';
		 
	if($rowviewdetails['is_deleted'] == 0)
	{
	$bookingstatus=mysql_fetch_assoc(mysql_query("select * from bsi_reservation where booking_id='".$bookingid."'"));
	if($bookingstatus['boking_status']==0){$bstatus='Confirm';}
	if($bookingstatus['boking_status']==1){$bstatus='Confirm';}
	if($bookingstatus['boking_status']==2){$bstatus='Check In';}
	if($bookingstatus['boking_status']==3){$bstatus='Check Out';}
	}else{
	$bstatus='Cancel';
	}
	echo '<td style="color:red;"><strong>'.$bstatus.'</strong></td>';	 
		 
		 /*$today = date('Y-m-d');
		 if($rowviewdetails['is_deleted'] == 0 && $rowviewdetails['end_date'] < $today){
			$status='Departed';
			echo '<td style="color:blue;"><strong>'.$status.'</strong></td>';	
		}else if($rowviewdetails['is_deleted']==0 && $rowviewdetails['end_date']>= $today){
			$status='Active';
			echo '<td style="color:green;"><strong>'.$status.'</strong></td>';	
		}else if($rowviewdetails['is_deleted']==1){
			$status='Cancelled';
			echo '<td style="color:red;"><strong>'.$status.'</strong></td>';	
		}*/
		?>
        <td style="background:#ffffff;"></td>
      </tr>
      <tr><td></td><td></td></tr>
      <br />
      <br />
    </table>
    
<table class="static" cellpadding="8">

<!--<tr>
<td valign="top"><b>Dispute</b></td>
<td></td>
</tr>-->
<tr>
<td valign="top"><b>Dispute</b></td>
<td align="left"><textarea id="dispute"  name="dispute" rows="5" cols="60"><?=$rowdispute['booking_dispute']?></textarea>

<button class="button_colour round_all" id="buttondispute"><img height="24" width="24" alt="Bended Arrow Right" src="images/icons/small/white/bended_arrow_right.png"><span>Submit</span></button>
</td>
<input type="hidden" name="bookingid" id="bookingid" value="<?php echo $bookingid;?>" />
</tr>
        
        <!--<tr>

		 <td><button class="button_colour round_all" id="button"><img height="24" width="24" alt="Bended Arrow Right" src="images/icons/small/white/bended_arrow_right.png"><span>Submit</span></button></td>
         <td></td>
        </tr>-->
      
    </table>
	
	
    <br />
    <br />
    
	  </div>
</div>
</div>
<div style="padding-right:8px;">
  <?php include("footer.php"); ?>
</div>
<!--<script type="text/javascript">
function test(val)
{
	if(val=='')
	{
	alert("Please enter Valid Confirmation Code.");
	return false;
	}
	else
	return true;
}
</script>-->

<script type="text/javascript">
$(document).ready(function(){
$('#buttondispute').click(function(){
var querystr = 'actioncode=33&dispute='+$('#dispute').val()+'&booking_id='+$('#bookingid').val();
$.post("admin_ajax_processor.php", querystr, function(data){							 
if(data.errorcode == 0){
alert("Comment Updated Successfully !");	
location.reload();	
}else{
alert(data.strhtml);
}
}, "json");
});
});
	
</script>
</body></html>