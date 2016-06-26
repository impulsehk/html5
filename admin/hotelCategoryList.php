<?php
	include("access.php");
	if(isset($_REQUEST['delid'])){
		include("../includes/db.conn.php");
		include("../includes/conf.class.php");
		include("../includes/admin.class.php");
		$bsiAdminMain->hotel_delete();
		header("location:".$_SERVER['PHP_SELF']);
	}
	$pageid = 17;
	include("header.php");
	if(isset($_SESSION['hotel_id'])){
		$hid=$_SESSION['hotel_id'];
		$select_hotel = $bsiAdminMain->hotelname($hid);
	}else{
		$select_hotel = $bsiAdminMain->hotelname();
	}
?>
<link rel="stylesheet" href="css/chosen.css">
<script type="text/javascript">
$(document).ready(function() {
	 if($('#hotel_id').val() > 0){
		 $('#getarounddata').html('<tr><td colspan=4 align="center"><img src="images/ajax-loader(1).gif" /></td></tr>');
		 roomlist_generate();		 
	 }
	 	 
	 $('#hotel_id').change(function() { 
	 $('#getarounddata').html('<tr><td colspan=4 align="center"><img src="images/ajax-loader(1).gif" /></td></tr>');
		roomlist_generate();
    });
	
	function roomlist_generate(){
		if($('#hotel_id').val() != 0){
			var querystr = 'actioncode=10&hotelid='+$('#hotel_id').val(); 
			$.post("admin_ajax_processor.php", querystr, function(data){						 
				if(data.errorcode == 0){
					 $('#getarounddata').html(data.aroundList)
				}else{
					$('#getarounddata').html('<tr><td colspan=4>No Category Available in this hotel!</td></tr>');
				}
			}, "json");
		}else{
			$('#getarounddata').html('<tr><td colspan=4>Please Select Hotel First</td></tr>')
		}
	}
});
</script>
<script language="javascript">
	function capacity_delete(delid){
		var answer = confirm ("Are you sure want to delete this Category? Remember corresponding of this Category all field will be deleted forever.");
	if (answer)
		window.location="add_edit_Category.php?delete=555&category_id="+delid;
	}
</script>
			<div class="flat_area grid_16"><?php $category_id=base64_encode(0);?>
            <button class="button_colour" style="float:right; padding-right:0px; margin-right:0px;" onclick="javascript:window.location.href='add_edit_Category.php?category_id=<?php echo $category_id;?>&addedit=1'"><img height="24" width="24" alt="Bended Arrow Right" src="images/icons/small/white/bended_arrow_right.png"><span>Add New Category</span></button>
					<h2>Category List</h2>
				</div>
				<div class="box grid_16 round_all">
					<h2 class="box_head grad_colour round_top">Select Hotel &nbsp;<select name="hotel_id" id="hotel_id" data-placeholder="Choose a hotel." class="chosen-select" style="width:250px;"><?php echo $select_hotel;?></select></h2>	
					<a href="#" class="grabber">&nbsp;</a>
					<a href="#" class="toggle">&nbsp;</a>
					<div class="block no_padding">
                    	<table class="static" cellpadding="8"> 
							<thead> 
								<tr> 
									<th class="first" width="700px" style="padding-left:10px;">Category Title</th>
									<th class="last">&nbsp;</th> 
								</tr> 
							</thead> 
                            <tbody id="getarounddata">
                            </tbody> 
						</table> 
					</div>
			</div>

			
		</div>
		<div id="loading_overlay">
			<div class="loading_message round_bottom">Loading...</div>
		</div>
        <div style="padding-right:8px;"><?php include("footer.php"); ?>
        <script src="js/chosen.jquery.min.js" type="text/javascript"></script>
  <script type="text/javascript">
    var config = {
      '.chosen-select'           : {}
    }
    for (var selector in config) {
      $(selector).chosen(config[selector]);
    }
  </script></div>
		</body>
	</html>