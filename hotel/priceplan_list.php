<?php 
include("access.php");
if(isset($_GET['delid'])){
	include("../includes/db.conn.php");
	include("../includes/conf.class.php");
	include("../includes/admin.class.php");
	$pln_del = base64_decode(mysql_real_escape_string($_REQUEST['delid']));
	$pln_del = explode("|",$pln_del);
	$_SESSION['roomtypeid'] = $pln_del[2]; 
	mysql_query("delete from bsi_priceplan where date_start='$pln_del[0]' and date_end='$pln_del[1]' and room_type_id=".$pln_del[2]." and hotel_id=".$pln_del[3]);
	header("location:priceplan_list.php");
	exit;
}
include("header.php");
if(isset($_SESSION['hhid']) && isset($_SESSION['roomtypeid'])){
	$catch1 = $bsiAdminMain->roomtypeList($_SESSION['hhid'], $_SESSION['roomtypeid']); 
}	
?>
<script type="text/javascript">
$(document).ready(function(){
	 if($('#hotel_id').val() > 0){
	 	$('#getajaxhtml').html('<tr><td colspan=8 align="center"><img src="../admin/images/ajax-loader(1).gif" /></td></tr>');
		getHotelid();
		$('#getajaxhtml').html('<td colspan="8">Please Select Roomtype</td>'); 
	 }
	 
	 function getHotelid(){
		if($('#hotelid').val() != 0){
			var querystr = 'actioncode=6&hotelid='+$('#hotel_id').val(); 
			$.post("../admin/admin_ajax_processor.php", querystr, function(data){												 
				if(data.errorcode == 0){ 
					$('#room_type').html(data.roomtype_dowpdown)
				}else{
				    $('#room_type').html('')
					$('#getajaxhtml').html('<td colspan="8">No Room Type Found In This Hotel !</td>')
				}				
			}, "json");
		}
	 }
	 
	 if($('#room_type').val() > 0){
		 $('#getajaxhtml').html('<tr><td colspan=8 align="center"><img src="../admin/images/ajax-loader(1).gif" /></td></tr>');
		 getRoomType();
	 }
	 
	 $('#room_type').change(function() { 
	 	$('#getajaxhtml').html('<tr><td colspan=8 align="center"><img src="../admin/images/ajax-loader(1).gif" /></td></tr>');
		getRoomType();
	 });
	 
	 function getRoomType(){
		if($('#room_type').val() != 0){
			var querystr = 'actioncode=5&hotelid='+$('#hotel_id').val()+'&roomtype_id='+$('#room_type').val(); 
			$.post("../admin/admin_ajax_processor.php", querystr, function(data){						 
				if(data.errorcode == 0){ 
					$('#getajaxhtml').html(data.strhtml)
				}else{
				    $('#getajaxhtml').html('<tr><td colspan="8">'+data.strmsg+'</td></tr>');
				}				
			}, "json");
		}
		if($('#room_type').val() == 0){
			 $('#getajaxhtml').html('<tr><td colspan="8">Please Select RoomType First</td></tr>');
		} 
	 }
});
</script>
<script language="javascript">
	function priceplan_delete(delid){
		var answer = confirm ("Are you sure want to delete this Priceplan?");
	if (answer)
		window.location="priceplan_list.php?delid="+delid
	}
</script>

<div class="flat_area grid_16">
  <button class="button_colour" style="float:right; padding-right:0px; margin-right:0px;" onclick="javascript:window.location.href='pricePlan.php'"><img height="24" width="24" alt="Bended Arrow Right" src="../admin/images/icons/small/white/bended_arrow_right.png"><span>Add New Price Plan</span></button>
  <h2>Hotel Price Plan <span style="margin-left:200px;">
    <?php if(isset($_SESSION['error_msg'])){ echo $_SESSION['error_msg']; }
  unset($_SESSION['error_msg']); ?>
    </span></h2>
</div>
<div class="box grid_16 round_all"> <span>
  <?php if(isset($_GET['msg'])){ echo $_GET['msg']; } ?>
  </span>
  <h2 class="box_head grad_colour round_top"> <span>Select RoomType</span>
  <span><select name="room_type" id="room_type"><option value="">---select---</option><?=$catch1[0]?></select></span>
  </h2>
  <a href="#" class="grabber">&nbsp;</a> <a href="#" class="toggle">&nbsp;</a>
  <div class="block no_padding">
    <input type="hidden" name="hotel_id" id="hotel_id" value="<?php echo $_SESSION['hhid']; ?>" />
    <table class="static" cellpadding="8">
      <thead>
        <tr>
          <th style="width:70px;"></th>
          <th style="width:60px;">SUN</th>
          <th style="width:60px;">MON</th>
          <th style="width:60px;">TUE</th>
          <th style="width:60px;">WED</th>
          <th style="width:60px;">THU</th>
          <th style="width:60px;">FRI</th>
          <th style="width:60px;">SAT</th>
		   <th style="width:50px;">Extra Bed</th>
          <th style="width:50px;"></th>
        </tr>
      </thead>
      <tbody id="getajaxhtml">
        <?php if(isset($catch1[1])){ ?>
        <?=$catch1[1]?>
        <?php } ?>
      </tbody>
    </table>
    <br />
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