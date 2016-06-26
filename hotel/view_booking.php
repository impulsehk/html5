<?php


include ("access.php");	


if(isset($_REQUEST['cancel'])){


	include("../includes/db.conn.php");


	include("../includes/conf.class.php");	


	include("../includes/admin.class.php");


	include("../includes/mail.class.php");


	$cancel = $bsiCore->ClearInput($_GET['cancel']);	


	$bsiAdminMain->booking_cencel_delete(1); 


	header("location:view_booking.php");


	exit;


}


include ("header.php");


if(isset($_SESSION['hhid'])){


	$book_type = 1;


	$hotel_id  = $_SESSION['hhid'];


}


$query = $bsiAdminMain->getBookingInfo($book_type, $hotel_id);


$html  = $bsiAdminMain->getHtml($book_type, $hotel_id, $query);


?>


<script type="text/javascript">


	function getHotelId(){


		window.open('pdf.php?hotelid='+<?=$hotel_id?>+'&booking_list_type='+0,'Active Booking List');


		


	}


	


	function cancel(bid){


		var answer = confirm ("Are you sure want to cancel Booking?");


		if (answer)


			window.location="<?=$_SERVER['PHP_SELF']?>?cancel="+bid+"&book_type="+<?=$book_type?>+"&hotel_id="+<?=$hotel_id?>;


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


<button class="skin_colour round_all" id="pdf_button" title="Print this page" style="float:right;" onclick="return getHotelId();"> <img src="../admin/images/icons/small/white/pdf_documents.png" width="24" height="24" alt="PDF Documents"> <span>PDF</span></button>


  <h2>Active Booking List</h2> 


</div>


<div class="box grid_16 round_all">


  <table class="display datatable"> 


      <?=$html['html']?>


  </table>


 </div>


</div>


<div style="padding-right:8px;"><?php include("footer.php"); ?></div>


</div>


</div>


</div>


<div id="loading_overlay">


  <div class="loading_message round_bottom">Loading...</div>


</div>


<script type="text/javascript" src="../admin/js/DataTables/jquery.dataTables.js"></script> 


<script type="text/javascript" src="../admin/js/adminica/adminica_datatables.js"></script>


</body></html>