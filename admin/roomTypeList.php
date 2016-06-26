<?php
	include("access.php");
	if(isset($_REQUEST['delid'])){
		include("../includes/db.conn.php");
		include("../includes/conf.class.php");
		$delid=$bsiCore->ClearInput($_REQUEST['delid']);
		$row = mysql_fetch_assoc(mysql_query("select * from bsi_roomtype where roomtype_id=$delid"));
		if($row['rtype_image'] != "" || $row['rtype_image'] != NULL){ 
			unlink("../gallery/roomTypeImage/".$row['rtype_image']);
			unlink("../gallery/roomTypeImage/thumb_".$row['rtype_image']);
		}
		mysql_query("delete from bsi_roomtype where roomtype_id=".$delid);
		
		//echo "delete from bsi_priceplan where roomtype_id=".$delid;die;
		mysql_query("delete from bsi_priceplan where room_type_id=".$delid);
		mysql_query("delete from bsi_room where roomtype_id=".$delid);
		$_SESSION['hotel_id'] = $row ['hotel_id'];
		header("location: roomTypeList.php");
	}
	$pageid = 14;
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
		 $('#roomTypelist').html('<tr><td colspan=3 align="center"><img src="images/ajax-loader(1).gif" /></td></tr>');
		 roomlist_generate();		 
	 }
	 	 
	 $('#hotel_id').change(function() { 
	 	$('#roomTypelist').html('<tr><td colspan=3 align="center"><img src="images/ajax-loader(1).gif" /></td></tr>');
		roomlist_generate();
    });
	
	function roomlist_generate(){
		if($('#hotel_id').val() != 0){ 
			var querystr = 'actioncode=8&hotelid='+$('#hotel_id').val(); 
			$.post("admin_ajax_processor.php", querystr, function(data){						 
				if(data.errorcode == 0){
					 $('#roomTypelist').html(data.roomTypelist)
				}else{
					$('#roomTypelist').html('<tr><td colspan=3>No Room Type Available in this hotel!</td></tr>');
				}
			}, "json");
		}else{
			$('#roomTypelist').html('<tr><td colspan=3>Please Select Hotel First</td></tr>')
		}
	}
});
</script>
<script language="javascript">
	function roomtype_delete(delid){
		var answer = confirm ("Are you sure want to delete this Roomtype? Remember corresponding of this Roomtype all room and priceplan will be deleted forever.");
	if (answer)
		window.location="roomTypeList.php?delid="+delid
	}
</script>
			<div class="flat_area grid_16"><?php $id=base64_encode(0);?>
            <button class="button_colour" style="float:right; padding-right:0px; margin-right:0px;" onclick="javascript:window.location.href='hotel_room_type.php?roomtype_id=<?php echo $id;?>&addedit=1'"><img height="24" width="24" alt="Bended Arrow Right" src="images/icons/small/white/bended_arrow_right.png"><span>Add New Room Type</span></button>
					<h2>RoomType List</h2>
				</div>
				<div class="box grid_16 round_all">
					<h2 class="box_head grad_colour round_top">Select Hotel <select name="hotel_id" id="hotel_id" data-placeholder="Choose a hotel." class="chosen-select" style="width:250px;"><?php echo $hotel_list;?></select></h2>	
					<a href="#" class="grabber">&nbsp;</a>
					<a href="#" class="toggle">&nbsp;</a>
					<div class="block no_padding">
						<table cellpadding="8" class="static">
                        	<thead>
                                <tr>
                                    <th class="first" style="padding:0 0 0 10px; width:200px">Room Type</th>
                                    <th style="padding:0 0 0 10px; width:400px">Services</th>
                                    <th class="last" style="padding:0 15px 0 0; width:100px">&nbsp;</th>
                                </tr>
                            </thead>
                                <tbody id="roomTypelist"></tbody>
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
  </script>
        </div> 
        </body>
	</html>