<?php
	include("access.php");
	if(isset($_POST['sbt_room'])){
		include("../includes/db.conn.php");
		include("../includes/conf.class.php");
		include("../includes/admin.class.php");
		$bsiAdminMain->hotel_room_entry();
		header("location:roomList.php");
		exit;
	}
	include("header.php");
	$roomtype=$bsiAdminMain->getroomTypeList($_SESSION['hhid']);
	$capacity_id=$bsiAdminMain->gethotel_room_capacity($_SESSION['hhid']);
?>
<script type="text/javascript" src="../admin/js/jquery.validate.js"></script>
<script>
	$(document).ready(function(){
		$("#add_edit_room").validate();
	});
</script>
<div class="flat_area grid_16">
<button class="button_colour round_all" id="button" onclick="javascript:window.location.href='roomList.php'" style="float:right;"><img height="24" width="24" alt="Bended Arrow Right" src="../admin/images/icons/small/white/bended_arrow_right.png"><span>Back</span></button>
  <h2>Add Room</h2>
</div>
<div class="box grid_16 round_all">
  <h2 class="box_head grad_colour round_top">&nbsp;&nbsp;</h2>
  <a href="#" class="grabber">&nbsp;</a> <a href="#" class="toggle">&nbsp;</a>
  <div class="block no_padding">
    <?php if((isset($_GET['add'])) && ($_GET['add'] == 111)){?>
    <form name="add_edit_room" id="add_edit_room" method="post" action="<?=$_SERVER['PHP_SELF']?>">
      <table cellpadding="6" cellspacing="0" border="0" >
        <tr>
          <td><label>Room Type : </label></td>
          <td align="left"><select id="roomtype_id" name="roomtype_id"><?=$roomtype?></select></td>
        </tr>
        <tr>
          <td><label>No of Rooms : </label></td>
          <td align="left"><input  type="text" class="required digits"   id="room_no" name="room_no"  style="width:70px;" /></td>
        </tr>
        <tr>
          <td><label>Capacity : </label></td>
          <td align="left"><select id="capacity_id" name="capacity_id"><?=$capacity_id?></select></td> 
        </tr>
        <tr>
          <td><label>No of Children : </label></td>
          <td align="left"><input  type="text"  id="no_of_child" name="no_of_child"  style="width:70px;" /></td>
        </tr>
        <tr>
          <td></td>
          <td><input  type="hidden" value="11" name="sbt_room" />
            <button class="button_colour round_all" id="button"><img height="24" width="24" alt="Bended Arrow Right" src="../admin/images/icons/small/white/bended_arrow_right.png"><span>Submit</span></button></td>
        </tr>
      </table>
    </form>
    <?php } ?>
  </div>
</div>
</div>
<div id="loading_overlay">
  <div class="loading_message round_bottom">Loading...</div>
</div>
<div style="padding-right:8px;"><?php include("footer.php"); ?></div> 
</body></html>