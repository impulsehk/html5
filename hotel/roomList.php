<?php
include("access.php");
if((isset($_REQUEST['delid'])) && (base64_decode($_REQUEST['delid']) == 555)){
	include("../includes/db.conn.php");
	include("../includes/conf.class.php");
	$bsiCore->deleteRoom($bsiCore->ClearInput(base64_decode($_REQUEST['roomtype_id'])), $bsiCore->ClearInput(base64_decode($_REQUEST['capacity_id'])), $no_of_child=$bsiCore->ClearInput(base64_decode($_REQUEST['no_of_child'])), $bsiCore->ClearInput(base64_decode($_REQUEST['hotel_id'])));
	header("location: roomList.php");
	exit;
}
include ("header.php");	
$roomType=$bsiAdminMain->getRoomDetails($_SESSION['hhid'])
?>

<div class="flat_area grid_16">
  <h2>Hotel Room List
    <button class="button_colour" style="float:right; padding-right:0px; margin-right:0px;" onclick="javascript:window.location.href='add_room_manager.php?add=111'"><img height="24" width="24" alt="Bended Arrow Right" src="../admin/images/icons/small/white/bended_arrow_right.png"><span>Add&nbsp;&nbsp;New&nbsp;&nbsp;Room</span></button>
  </h2>
</div>
<div class="box grid_16 round_all">
  <h2 class="box_head grad_colour round_top">&nbsp;&nbsp;</h2>
  <a href="#" class="grabber">&nbsp;</a> <a href="#" class="toggle">&nbsp;</a>
  <div class="block no_padding">
    <table class="static" cellpadding="4">
      <thead>
        <tr>
          <th width="30%" nowrap="nowrap">Room Type</th>
          <th width="15%" nowrap="nowrap">Capacity</th>
          <th width="15%" nowrap="nowrap">Total Room</th>
          <th width="15%" nowrap="nowrap">Child / Room</th>
          <th width="25%">&nbsp;</th>
        </tr>
      </thead>
      <tbody>
        <?php
		   while($getroomtyperow = mysql_fetch_assoc($roomType)){
		?>
        <tr>
          <td align="left"><?=$getroomtyperow['type_name']?></td>
          <td align="left"><?=$getroomtyperow['title']?>
            (
            <?=$getroomtyperow['capacity']?>
            )</td>
          <td><?=$getroomtyperow['totalroom']?></td>
          <td><?=$getroomtyperow['no_of_child']?></td>
          <td align="right"><a href="roomList.php?delid=<?=base64_encode(555)?>&roomtype_id=<?=base64_encode($getroomtyperow['roomtype_id'])?>&capacity_id=<?=base64_encode($getroomtyperow['capacity_id'])?>&no_of_child=<?=base64_encode($getroomtyperow['no_of_child'])?>&hotel_id=<?=base64_encode($_SESSION['hhid'])?>">Delete</a></td>
        </tr>
        <?php
		  }
		?>
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