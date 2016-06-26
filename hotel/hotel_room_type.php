<?php 
	include("access.php");
	if(isset($_POST['sbt_roomtype'])){
		include("../includes/db.conn.php");
		include("../includes/conf.class.php");
		include("../includes/admin.class.php");
		$bsiAdminMain->hotel_roomtype_entry();
		header("location:roomTypeList.php");
		exit;
	}
   include("header.php");
?>
<script type="text/javascript" src="../admin/js/jquery.validate.js"></script>
<script type="text/javascript">
$(document).ready(function(){
	$("#roomtype-frm").validate();
});
</script>

<div class="flat_area grid_16">
  <button class="button_colour round_all"  onclick="javascript:window.location.href='roomTypeList.php'"  style="float:right;"><img height="24" width="24" alt="Bended Arrow Right" src="../admin/images/icons/small/white/bended_arrow_right.png"><span>Back</span></button>
  <h2>Add / Edit Room Type</h2>
</div>
<div class="box grid_16 round_all">
  <h2 class="box_head grad_colour round_top">&nbsp;</h2>
  <a href="#" class="grabber">&nbsp;</a> <a href="#" class="toggle">&nbsp;</a>
  <div class="block no_padding">
    <?php if((isset($_GET['addedit'])) && ($_GET['addedit'] == 1)){
		   $roomtype_id = $bsiCore->ClearInput(base64_decode($_GET['roomtype_id']));
		   if($roomtype_id){
			   $row = $bsiAdminMain->getRoomtype($roomtype_id);
			   
			   if($row['roomtype_name']=='Short Stay Room')
			   {$rthtml.='
			   <input type="hidden"  name="roomtype_name" id="roomtype_name" value="'.$row['roomtype_name'].'" />First Room';
			   }else{
				$rthtml.='
			   <input type="hidden"  name="roomtype_name" id="roomtype_name" value="'.$row['roomtype_name'].'" />Second Room';   
				}
			   
		   }else{
			   $row=NULL;
			   $rthtml.='
			   <select name="roomtype_name" id="roomtype_name">
			   <option value="Short Stay Room">First Room</option>
			   <option value="Overnight Room">Second Room</option>
			   </select>';
		   }
	  }  
	?>
    <form name="roomtype-frm" id="roomtype-frm" method="post" action="<?=$_SERVER['PHP_SELF']?>" enctype="multipart/form-data">
      <table cellpadding="6" cellspacing="0" border="0">
        <input type="hidden"  name="hotel_id" value="<?=$_SESSION['hhid']?>" />
        <input type="hidden"  name="roomtype_id" value="<?=$roomtype_id?>" />
        <br />
        <tr>
          <td><label>Choose Selection : </label></td>
          <td align="left">
              <?=$rthtml?>
           </td>
        </tr>
        <tr>
        
        
        <tr>
          <td><label>Room Type : </label></td>
          <td align="left"><input type="text" class="required"  id="type_name" name="type_name" value="<?=$row['type_name']?>" style="width:250px;"></td>
        </tr>
        <tr>
          <td valign="top"><label>Services : </label></td>
          <td align="left"><textarea id="type_service" class="required" name="type_service" rows="5" cols="60"><?=$row['services']?>
</textarea></td>
        </tr>
        <tr>
          <td><label>Room Type Image : </label></td>
          <td align="left"><input type="hidden" id="pre_img" name="pre_img" value="<?=$row['rtype_image']?>" />
            <input type="file" name="rtype_image" id="rtype_image">
            <?php if($row>0){?>
            <span style="padding-left:50px;"><a rel="collection" href="../gallery/roomTypeImage/<?=$row['rtype_image']?>" target="_blank">View Image</a></span>
            <?php } ?></td>
        </tr>
        
<tr>
<td align="left"><label>Room Size : </label></td>
<td align="left"><input  style="width:50px;" type="text" id="roomsize" name="roomsize" value="<?=$row['roomsize']?>" class="required" /></td>
</tr>

<tr>
<td align="left"><label>Bed Size : </label></td>
<td align="left"><input  style="width:50px;" type="text" id="bedsize" name="bedsize" value="<?=$row['bedsize']?>" class="required" /></td>
</tr>
        
        
        <tr>
          <td></td>
          <td><input  type="hidden" value="sbt_roomtype" name="sbt_roomtype" />
            <button class="button_colour round_all" id="button"><img height="24" width="24" alt="Bended Arrow Right" src="../admin/images/icons/small/white/bended_arrow_right.png"><span>Submit</span></button></td>
        </tr>
      </table>
    </form>
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