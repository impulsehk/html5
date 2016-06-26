<?php 
include("access.php");
	if(isset($_REQUEST['delid'])){
		include("../includes/db.conn.php");
		include("../includes/conf.class.php");
		include("../includes/admin.class.php");
		$bsiAdminMain->hotel_delete();  
		$bsiAdminMain->create_map_json(); 
		header("location:hotel_list.php");
	}
	$pageid = 9;
	include("header.php");
	if(isset($_GET['agent_id'])){
		$getHtml = $bsiAdminMain->getHotelhtml(mysql_real_escape_string(base64_decode($_GET['agent_id']))); 
	}else{
		$getHtml = $bsiAdminMain->getHotelhtml();
	}
?>
<script language="javascript">
	function capacity_delete(delid){
		var answer = confirm ("Are you sure want to delete this Hotel? Remember corresponding of this Hotel all room and priceplan will be deleted forever.");
		if (answer)
			window.location="<?=$_SERVER['PHP_SELF']?>?delid="+delid;
	}	
</script>

<div class="flat_area grid_16">
  <?php $hotel_id = base64_encode(0); ?>
  <button class="button_colour" style="float:right; padding-right:0px; margin-right:0px;" onclick="javascript:window.location.href='hotel_details_entry.php?hotel_id=<?=$hotel_id?>&addedit=1'"><img height="24" width="24" alt="Bended Arrow Right" src="images/icons/small/white/bended_arrow_right.png"><span>Add New Hotel Details</span></button>
  <a href="hotelList_PDF.php?query=<?=$getHtml[0]?>" target="_blank">
  <button class="skin_colour round_all" id="pdf_button" title="Print this page" style="float:right;" ><img src="images/icons/small/white/pdf_documents.png" width="24" height="24" alt="PDF Documents"><span>PDF</span></button>
  </a>
  <h2><?php if(isset($_GET['agent_id']) && $_GET['agent_id'] != ""){ echo "Agent "; } ?>Hotel List</h2>
</div>
<div class="box grid_16 round_all">
  <table class="display datatable">
    <thead>
      <tr>
        <th nowrap="nowrap" class="first" width="200">Hotel Name</th>
        <th nowrap="nowrap" width="250">Address</th>
        <th nowrap="nowrap">Checkin Hour</th>
        <th nowrap="nowrap">Checkout Hour</th>
        <th nowrap="nowrap">Status</th>
        <th class="last" nowrap="nowrap">&nbsp;</th>
      </tr>
    </thead>
    <tbody>
      <?=$getHtml[1]?>
    </tbody>
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