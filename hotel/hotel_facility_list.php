<?php
	include("access.php");
	if(isset($_REQUEST['delid'])){
		include("../includes/db.conn.php");
		include("../includes/conf.class.php");
		include("../includes/admin.class.php");
		$bsiAdminMain->facilty_delete();
		header("location:".$_SERVER['PHP_SELF']);
		exit;
	}
	include("header.php");
	define("EDIT", 'Edit');
	define("DELETE", 'Delete');
?>
<script language="javascript">
function capacity_delete(delid){
	var answer = confirm ('Do you really want to delete Facilty?');
	if(answer)
		window.location="hotel_facility_list.php?delid="+delid
}
</script>

<div class="flat_area grid_16">
  <?php $id=base64_encode(0);?>
  <button class="button_colour" style="float:right; padding-right:0px; margin-right:0px;" onclick="javascript:window.location.href='hotel_facility_entry.php?id=<?=$id?>&addedit=1'"><img height="24" width="24" alt="Bended Arrow Right" src="../admin/images/icons/small/white/bended_arrow_right.png"><span> Add New Facility </span></button>
  <h2> Hotel Facility List </h2>
  <?php if(isset($_SESSION['error_msg'])){ echo $_SESSION['error_msg']; }unset($_SESSION['error_msg']); ?>
</div>
<div class="box grid_16 round_all">
  <h2 class="box_head grad_colour round_top">&nbsp;</h2>
  <a href="#" class="grabber">&nbsp;</a> <a href="#" class="toggle">&nbsp;</a>
  <div class="block no_padding">
    <table class="static" cellpadding="8">
      <thead>
        <tr>
          <th class="first" width="30%">General Facilities</th>
          <th width="30%">Activities Facilities</th>
          <th width="30%" style="text-decoration:!important;">Services Facilities</th>
          <th class="last">&nbsp;</th>
        </tr>
      </thead>
      <tbody>
        <?php echo $bsiAdminMain->getHotelFacility(); ?>
      </tbody>
    </table>
  </div>
</div>
</div>
<div id="loading_overlay">
  <div class="loading_message round_bottom">Loading...</div>
</div>
<div style="padding-right:8px;">
  <?php include("footer.php"); ?>
</div>
</body></html>