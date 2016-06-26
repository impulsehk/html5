<?php 
	include("access.php");
	if(!isset($_GET['booking_id'])){
	  header("location:admin-home.php");	
	}
	include("header.php");
	$bookingid=base64_decode($_GET['booking_id']);
    $bookingid=$bsiCore->ClearInput($bookingid);
	if(isset($bookingid)){
		
		$viewdetailsquery=mysql_query("select DATE_FORMAT(bb.checkin_date, '".$bsiCore->userDateFormat."') AS checkin_date,
			DATE_FORMAT(bb.checkout_date, '".$bsiCore->userDateFormat."') AS checkout_date, checkout_date as end_date,
			DATE_FORMAT(bb.booking_time, '".$bsiCore->userDateFormat."') AS booking_time,		bc.title,bc.first_name,bc.surname,bc.street_addr,bc.street_addr2,bc.phone,bc.zip,bco.name,bb.total_cost,bb.payment_type,bb.hotel_id,bb.is_deleted from bsi_bookings as bb,bsi_clients as bc,bsi_country as bco  where bco.country_code=bc.country and bb.client_id=bc.client_id and  booking_id='".$bookingid."'");
		 $rowviewdetails=mysql_fetch_assoc($viewdetailsquery);
	     $_SESSION['hotel_id'] = $rowviewdetails['hotel_id'];	 
	}
?>


<div class="flat_area grid_16">
<?php
if($_GET['book_type'] == 1){
?>
  <button class="skin_colour round_all" id="pdf_button" title="Print this page" style="float:right;"  onclick="javascript:window.location.href='view_booking.php'"><img src="../admin/images/icons/small/white/pdf_documents.png" width="24" height="24" alt="PDF Documents"> <span>BACK</span></button>
  <?php
}else{
  ?>
   <button class="skin_colour round_all" id="pdf_button" title="Print this page" style="float:right;"  onclick="javascript:window.location.href='booking_history.php'"><img src="../admin/images/icons/small/white/pdf_documents.png" width="24" height="24" alt="PDF Documents"> <span>BACK</span></button>
   <?php
}
   ?>
  <h2>Booking Details</h2>
</div>
<div class="box grid_16 round_all">
  <h2 class="box_head grad_colour round_top">&nbsp;&nbsp;</h2>
  <a href="#" class="grabber">&nbsp;</a> <a href="#" class="toggle">&nbsp;</a>
  <div class="block no_padding">
    <table class="static" cellpadding="4">
      <tr>
        <td><b>CUSTOMER DETAILS</b></td>
        <td></td>
      </tr>
      <tr>
        <td style="width:200px">Name</td>
        <td><?=$rowviewdetails['title']?>
          <?=$rowviewdetails['first_name']?>
          <?=$rowviewdetails['surname']?></td>
      </tr>
      <tr>
        <td style="width:200px">Phone</td>
        <td><?=$rowviewdetails['phone']?></td>
      </tr>
      <tr>
        <td style="width:200px">Address</td>
        <td><?=$rowviewdetails['street_addr']?>
          -
          <?=$rowviewdetails['street_addr2']?></td>
      </tr>
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
      <tr>
        <td style="width:200px">Zip</td>
        <td><?=$rowviewdetails['zip']?></td>
      </tr>
      <tr>
        <td style="width:200px">Country</td>
        <td><?=$rowviewdetails['name']?></td>
      </tr>
    </table>
    <table class="static" cellpadding="8">
      <?=$bsiCore->getInvoiceinfo($bookingid)?>
    </table>
    <table class="static" cellpadding="8">
      <tr><td></td></tr>
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
	
	
    <table class="static" cellpadding="8">
        <tr>
        <td><b>BOOKING STATUS</b></td>
        <td></td>
      </tr>
        <tr>
      
      
 <?php
		 $status='';
		 $today = date('Y-m-d');
		$rowviewdetails['end_date'];
		if($rowviewdetails['is_deleted'] == 0 && $rowviewdetails['end_date']<$today){
			$status='Departed';
			echo '<td style="color:blue;"><strong>'.$status.'</strong></td>';	
		}else if($rowviewdetails['is_deleted']==0 && $rowviewdetails['end_date']>$today){
			$status='Active';
			echo '<td style="color:green;"><strong>'.$status.'</strong></td>';	
		}else if($rowviewdetails['is_deleted']==1){
			$status='Cancelled';
			echo '<td style="color:red;"><strong>'.$status.'</strong></td>';	
		}
		?>
       
        <td></td>
		</tr>

    </table>
  </div>
</div>
</div>
<div style="padding-right:8px;"><?php include("footer.php"); ?></div>
</body></html>