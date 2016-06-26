<?php

include ("access.php");

if(isset($_REQUEST['cancel'])){

	include("../includes/db.conn.php");

	include("../includes/conf.class.php");

	include("../includes/admin.class.php");

	include("../includes/mail.class.php");

	$bsiAdminMain->booking_cencel_delete(1);

	$client = base64_encode(mysql_real_escape_string($_REQUEST['client']));

	header("location:customerbooking.php?client=".$client);

	exit;

}

if(isset($_REQUEST['active'])){
	
	include("../includes/db.conn.php");
	include("../includes/conf.class.php");
	include("../includes/admin.class.php");	
	include("../includes/mail.class.php");

	$bsiAdminMain->booking_cencel_delete(3); 
	$client = base64_encode(mysql_real_escape_string($_REQUEST['client']));

	header("location:customerbooking.php?client=".$client);
	exit;
}    

if(isset($_REQUEST['delid'])){
  
	include("../includes/db.conn.php");

	include("../includes/conf.class.php");

	include("../includes/admin.class.php");

	$bsiAdminMain->booking_cencel_delete(2);

	$client = base64_encode(mysql_real_escape_string($_REQUEST['client']));

	header("location:customerbooking.php?client=".$client);

	exit;

}

$pageid = 29;

if(isset($_GET['client']) && $_GET['client'] != ""){

	

}else{

	header("location:customerlookup.php");

	exit;

}

include("header.php");

$client = $bsiCore->ClearInput(base64_decode($_GET['client']));

$html   = $bsiAdminMain->fetchClientBookingDetails($client);

?>

<script type="text/javascript">

function myPopup2(booking_id){

	var width = 730;

	var height = 650;

	var left = (screen.width - width)/2;

	var top = (screen.height - height)/2;

	var url='../data/invoice/voucher_'+booking_id+'.pdf';

	var params = 'width='+width+', height='+height;

	params += ', top='+top+', left='+left;

	params += ', directories=no';

	params += ', location=no';

	params += ', menubar=no';

	params += ', resizable=no';

	params += ', scrollbars=yes';

	params += ', status=no';

	params += ', toolbar=no';

	newwin=window.open(url,'Chat', params);

	if (window.focus) {newwin.focus()}

	return false;

}

function booking_delete(delid){

var answer = confirm ("Are you sure want to delete booking? Remember once booking deleted, it will be deleted forever from your database.");

if (answer)

	window.location="customerbooking.php?delid="+delid+"&client="+<?=$client?>;

}

function cancel(bid){

	var answer = confirm ("Are you sure want to cancel Booking?");

	if (answer)

		window.location="customerbooking.php?cancel="+bid+"&client="+<?=$client?>;

}

</script>

<div class="flat_area grid_16">

  <button name="button" onclick="javascript:window.location.href='customerlookup.php'" id="button" class="button_colour round_all" style="float:right;"><img height="24" width="24" alt="Bended Arrow Right" src="images/icons/small/white/bended_arrow_right.png"><span>Back</span></button>

  <h2>Booking List</h2>

</div>

<div class="box grid_16 round_all">

  <table class="display datatable">

    <thead>

      <tr>

        <th width="9%" nowrap>Booking Id</th>

        <th width="18%" nowrap>Name</th>

        <th width="8%" nowrap="nowrap">Check In</th>

        <th width="10%" nowrap>Check Out</th>

        <th width="10%" nowrap>Amount</th>

        <th width="9%" nowrap>Booking Date</th>

        <th width="8%" nowrap="nowrap">Status</th>

        <th width="25%">&nbsp;</th>

      </tr>

    </thead>

    <?=$html?>

  </table>

  <!--################################################# --> 

</div>

</div>

<div style="padding-right:8px;"><?php include("footer.php"); ?></div>

</div>

</div>

</div>

<div id="loading_overlay">

  <div class="loading_message round_bottom">Loading...</div>

</div>

<script type="text/javascript" src="js/DataTables/jquery.dataTables.js"></script> 

<script type="text/javascript" src="js/adminica/adminica_datatables.js"></script>

</body></html>