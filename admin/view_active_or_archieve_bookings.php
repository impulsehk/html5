<?php
include ("access.php");
if(isset($_REQUEST['delid'])){
	include("../includes/db.conn.php");
	include("../includes/conf.class.php");
	include("../includes/admin.class.php");
	$delete = $bsiCore->ClearInput($_GET['delid']);	
	$bsiAdminMain->booking_cencel_delete(2);
	header("location:view_active_or_archieve_bookings.php?book_type=".$_GET['book_type']."&hotel_id=".base64_encode($_GET['hotel_id']));
	exit;
}
if(isset($_REQUEST['cancel'])){
	include("../includes/db.conn.php");
	include("../includes/conf.class.php");	
	include("../includes/admin.class.php");
	include("../includes/mail.class.php");
	$cancel = $bsiCore->ClearInput($_GET['cancel']);	
	$bsiAdminMain->booking_cencel_delete(1); 
	header("location:view_active_or_archieve_bookings.php?book_type=".$_GET['book_type']."&hotel_id=".base64_encode($_GET['hotel_id']));
	exit;
}
$pageid = 24;
include ("header.php");
$bookArr = array(1=>"Active Booking", 2=>"Booking History");
if(isset($_GET['book_type']) && isset($_GET['hotel_id'])){
	$book_type = $bsiCore->ClearInput($_GET['book_type']);
	$hotel_id  = $bsiCore->ClearInput(base64_decode($_GET['hotel_id']));
}else{
	$book_type = $bsiCore->ClearInput($_POST['book_type']);
	$hotel_id  = $bsiCore->ClearInput($_POST['hotel_id']);
	//$report  = $bsiCore->ClearInput($_POST['report']);
	if(isset($_SESSION['shortby'])){ unset($_SESSION['shortby']); }
	if(isset($_SESSION['hotelidpdf'])){ unset($_SESSION['hotelidpdf']); }
	if(isset($_SESSION['check_in'])){ unset($_SESSION['check_in']); }
	if(isset($_SESSION['check_out'])){ unset($_SESSION['check_out']); }
	if(isset($_REQUEST['shortby'])){
		$book_type = (3+$book_type);
		$_SESSION['hotelidpdf']  = mysql_real_escape_string($_POST['hotel_id']);
		$_SESSION['shortby']     = mysql_real_escape_string($_POST['shortby']);
		$_SESSION['check_in']    = mysql_real_escape_string($_POST['check_in']);
		$_SESSION['check_out']   = mysql_real_escape_string($_POST['check_out']);
	}
}
//echo $book_type;die;
$query = $bsiAdminMain->getBookingInfo($book_type, $hotel_id);
//echo $query;die;
$htmlArr = $bsiAdminMain->getHtml($book_type, $hotel_id, $query);
?>
<script type="text/javascript">
	function getHotelId(){
		<?php if($book_type == 1){?>
		window.open('pdf.php?hotelid='+<?=$hotel_id?>+'&booking_list_type='+0,'Active Booking List');
		<?php }else if($book_type == 2){ ?>
		window.open('pdf_archieve.php?hotelid='+<?=$hotel_id?>+'&booking_list_type='+1,'Booking History');	
		<?php	
		}else if($book_type == 4){
		?>
		window.open('pdf.php?hotelid='+<?=$hotel_id?>+'&booking_list_type='+<?=0?>+'&genList=4','Active Booking List');	
		<?php	
		}else{
		?>
		window.open('pdf_archieve.php?hotelid='+<?=$hotel_id?>+'&booking_list_type='+<?=1?>+'&genList=5','Booking History');	
		<?php	
		}
		?>
	}
	
	function cancel(bid){
		var answer = confirm ("Are you sure want to cancel Booking?");
		if (answer)
			window.location="<?=$_SERVER['PHP_SELF']?>?cancel="+bid+"&book_type="+<?=$book_type?>+"&hotel_id="+<?=$hotel_id?>;
	}
	
	function deleteBooking(bid){
		var answer = confirm ("Are you sure want to delete Booking?");
		if (answer)
			window.location="<?=$_SERVER['PHP_SELF']?>?delid="+bid+"&book_type="+<?=$book_type?>+"&hotel_id="+<?=$hotel_id?>;
	}
	
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
</script>
<div class="flat_area grid_16">
<?php 
	if(isset($_SESSION['check_in'])){
		$backPage = 'gen-booking-list';
	}else{
		$backPage = 'view_booking';
	}
?>
  <button class="skin_colour round_all" id="pdf_button" title="Print this page" style="float:right;"  onclick="javascript:window.location.href='<?=$backPage?>.php'"><img src="images/icons/small/white/bended_arrow_right.png" width="24" height="24" alt="PDF Documents"> <span>BACK</span></button>
<?php 
	if($htmlArr['exist']){
		$hoteldatacsv=$bsiAdminMain->getHotelDetails($hotel_id);
		if(isset($_POST['report'])){
?>
<?php if($book_type == 1){?>
  <a href="../data/csvs/Active-<?php echo $hoteldatacsv['hotel_name'].'-'.date('Ymd');?>.csv"><button class="skin_colour round_all" id="pdf_button" title="Print this page" style="float:right;"><img src="images/icons/small/white/bended_arrow_right.png" width="24" height="24" alt="PDF Documents"><span>Export to CSV File</span></button></a>
  <?php }?>
  <?php if($book_type == 2){?>
  <a href="../data/csvs/History-<?php echo $hoteldatacsv['hotel_name'].'-'.date('Ymd');?>.csv"><button class="skin_colour round_all" id="pdf_button" title="Print this page" style="float:right;"><img src="images/icons/small/white/bended_arrow_right.png" width="24" height="24" alt="PDF Documents"><span>Export to CSV File</span></button></a>
  <?php }?>
  <?php 

	}else{
?>

  
   <button class="skin_colour round_all" id="pdf_button" title="Print this page" style="float:right;" onclick="return getHotelId();"> <img src="images/icons/small/white/pdf_documents.png" width="24" height="24" alt="PDF Documents"> <span>PDF</span></button>
  
  
<?php 
	}
	}
?>
  <h2>
    <?php if(isset($_POST['book_type'])){if($_POST['book_type'] == 1){ echo "Active Booking List "; if(isset($_SESSION['check_in'])){echo '( '.$_SESSION['check_in'].' TO '.$_SESSION['check_out'].' BY '.ucwords(str_replace("_", " ", $_SESSION['shortby'])).' )';} } else { echo "Booking History "; if(isset($_SESSION['check_in'])){echo '( '.$_SESSION['check_in'].' TO '.$_SESSION['check_out'].' BY '.ucwords(str_replace("_", " ", $_SESSION['shortby'])).' )';} }}?>
    <?php if(isset($_GET['book_type'])){if($_GET['book_type'] == 1 || $_GET['book_type'] == 4){ echo "Active Booking List "; if(isset($_SESSION['check_in'])){echo '( '.$_SESSION['check_in'].' TO '.$_SESSION['check_out'].' BY '.ucwords(str_replace("_", " ", $_SESSION['shortby'])).' )';} } else { echo "Booking History "; if(isset($_SESSION['check_in'])){echo '( '.$_SESSION['check_in'].' TO '.$_SESSION['check_out'].' BY '.ucwords(str_replace("_", " ", $_SESSION['shortby'])).' )';} }}?>
    
    
  </h2>
</div>
<div class="box grid_16 round_all">
  <table class="display datatable">
    <?=$htmlArr['html']?>
  </table>
</div>
</div>
<div style="padding-right:8px;">
  <?php include("footer.php"); ?>
</div>
</div>
</div>
</div>
<div id="loading_overlay">
  <div class="loading_message round_bottom">Loading...</div>
</div>
<script type="text/javascript" src="js/DataTables/jquery.dataTables.js"></script> 
<script type="text/javascript" src="js/adminica/adminica_datatables.js"></script>
</body></html>