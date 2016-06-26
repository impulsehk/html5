<?php
	include("access.php");
	if(isset($_REQUEST['delid'])){
		include("../includes/db.conn.php");
		include("../includes/conf.class.php");
		include("../includes/admin.class.php");
		$bsiAdminMain->category_delete();
		header("location:".$_SERVER['PHP_SELF']);
	}
	$pageid = 18;
	include("header.php");
?>
<script type="text/javascript">
	$(document).ready(function() {	
	if($('#hotel_id').val() > 0){
		$('#getajaxhtml').html('<tr><td colspan=4 align="center"><img src="images/ajax-loader(1).gif" /></td></tr>');
		getAroundcategory();		 
	}	 
	 function getAroundcategory(){
		if($('#hotel_id').val() != 0){
			var querystr = 'actioncode=11&hotelid='+$('#hotel_id').val(); 
			$.post("../admin/admin_ajax_processor.php", querystr, function(data){						 
				if(data.errorcode == 0){
					 $('#getajaxhtml').html(data.aroundList)
				}else{
				    $('#getajaxhtml').html('<tr><td colspan=4><labe>No Around Category Found.</label></td></tr>');
				}
			}, "json");
		}
	 }
});

</script>
<script language="javascript">
	function capacity_delete(delid){
		var answer = confirm ('<?=DELETE_CATEGORY_FIELD_MSG?>');
		if (answer)
			window.location="adminAroundCategoryList.php?delid="+delid
	}
</script>

<div class="flat_area grid_16">
  <?php $id=base64_encode(0);?>
  <button class="button_colour" style="float:right; padding-right:0px; margin-right:0px;" onclick="javascript:window.location.href='addedit_around_category.php?id=<?=$id?>&addedit=1'"><img height="24" width="24" alt="Bended Arrow Right" src="../admin/images/icons/small/white/bended_arrow_right.png"><span>
  Add New Around
  </span></button>
  <h2>
    Around List
  </h2>
</div>
<div class="box grid_16 round_all">
  <h2 class="box_head grad_colour round_top">&nbsp;
    <input type="hidden" name="hotel_id" id="hotel_id" value="<?php echo $_SESSION['hhid']; ?>" />
  </h2>
  <a href="#" class="grabber">&nbsp;</a> <a href="#" class="toggle">&nbsp;</a>
  <div class="block no_padding">
    <table class="static" cellpadding="8">
      <thead>
        <tr>
          <th class="first" width="300px">Category Title</th>
          <th width="200px">Title</th>
          <th width="200px">Distance</th>
          <th class="last">&nbsp;</th>
        </tr>
      </thead>
      <tbody id="getajaxhtml">
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