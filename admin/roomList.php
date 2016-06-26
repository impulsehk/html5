<?php
include("access.php");
	if((isset($_REQUEST['delid'])) && ($_REQUEST['delid'] == 555)){
		include("../includes/db.conn.php");
		include("../includes/conf.class.php");
		$bsiCore->deleteRoom($bsiCore->ClearInput(base64_decode($_REQUEST['roomtype_id'])),
							 $bsiCore->ClearInput(base64_decode($_REQUEST['capacity_id'])),
							 $no_of_child=$bsiCore->ClearInput(base64_decode($_REQUEST['no_of_child'])),
							 $bsiCore->ClearInput(base64_decode($_REQUEST['hotel_id'])));
							 if(isset($_SESSION['hotel_id'])){
								 unset($_SESSION['hotel_id']);
								 $_SESSION['hotel_id']=base64_decode($_REQUEST['hotel_id']);
							 }else{
								  $_SESSION['hotel_id']=base64_decode($_REQUEST['hotel_id']);
							 }
		header("location: roomList.php");
	}
	$pageid = 13;
	include ("header.php");
	if(isset($_SESSION['hotel_id'])){
	$hid=$_SESSION['hotel_id']; 
	$hotel_list=$bsiAdminMain->hotelname($hid);
	}else{
	$hotel_list=$bsiAdminMain->hotelname();
}
?>
<link rel="stylesheet" href="css/chosen.css">

<script type="text/javascript">
$(document).ready(function() {
	 if($('#hotel_id').val() > 0){
		 $('#getajaxhtml').html('<tr><td colspan=5 align="center"><img src="images/ajax-loader(1).gif" /></td></tr>');
		 roomlist_generate();		 
	 }
	 	 
	 $('#hotel_id').change(function() { 
	 $('#getajaxhtml').html('<tr><td colspan=5 align="center"><img src="images/ajax-loader(1).gif" /></td></tr>');
		roomlist_generate();
    });
	
	function roomlist_generate(){
		if($('#hotel_id').val() != 0){
			var querystr = 'actioncode=4&hotelid='+$('#hotel_id').val(); 
			//alert(querystr);
			$.post("admin_ajax_processor.php", querystr, function(data){						
				//alert("1");						 
				if(data.errorcode == 0){
					 $('#getajaxhtml').html(data.strhtml)
					 //alert(data.strhtml);
				}else{
				    //alert(data.strmsg);
					$('#getajaxhtml').html('<tr><td colspan=5>No Room Available in this hotel!</td></tr>');
				}
			}, "json");
		}else{
			$('#getajaxhtml').html('<tr><td colspan=5>Please Select Hotel First</td></tr>')
		}
	}
});
</script>
			<div class="flat_area grid_16">
          
					<h2>Hotel Room List <button class="button_colour" style="float:right; padding-right:0px; margin-right:0px;" onclick="javascript:window.location.href='add_room_manager.php?add=111'"><img height="24" width="24" alt="Bended Arrow Right" src="images/icons/small/white/bended_arrow_right.png"><span>Add New Room</span></button></h2>
				</div>
				<div class="box grid_16 round_all">
					<h2 class="box_head grad_colour round_top">  Select Hotel&nbsp;&nbsp;<select name="hotel_id" id="hotel_id" data-placeholder="Choose a hotel." class="chosen-select" style="width:250px;"><?=$hotel_list?></select></h2>	
					<a href="#" class="grabber">&nbsp;</a>
					<a href="#" class="toggle">&nbsp;</a>
					<div class="block no_padding">
                        <table class="static" cellpadding="4">
                        <thead> 
                            <tr>
                                <th class="first">Room Type</th>
                                <th>Capacity</th>
                                <th>Total Room</th>
                                <th>Child / Room</th>
                                <!--<th>Extra One Bed / Room</th>-->
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
        <div style="padding-right:8px;"><?php include("footer.php"); ?></div> 
 <script src="js/chosen.jquery.min.js" type="text/javascript"></script>
  <script type="text/javascript">
    var config = {
      '.chosen-select'           : {}
    }
    for (var selector in config) {
      $(selector).chosen(config[selector]);
    }
  </script>
        </body>
	</html>