<?php 
include("access.php");
if(isset($_POST['act_sbmt'])){
    include("../includes/db.conn.php");
	include("../includes/conf.class.php");
	include("../includes/admin.class.php");
	$bsiAdminMain->main_gallery_img_upload();
	$_SESSION['hotel_id'] = mysql_real_escape_string($_POST['hotel_id']);
	header("location:gallery_list.php");
	exit;
}
    $pageid=23;
	include("header.php");
?>
<script type="text/javascript">
$(document).ready(function(){
//*************************************************
	$('#hotel_id').change(function() { 
	if($('#hotel_id').val() != 0)
	//$("input[type=button]").removeAttr("disabled");
		jQuery("#button:button").removeAttr("disabled"); 
	else
		jQuery("#button:button").attr("disabled", "disabled");  
	});
//**************************************************
});
</script>
<div class="flat_area grid_16">
  <h2>&nbsp;</h2>
</div>
<form action="<?=$_SERVER['PHP_SELF']?>" method="post" enctype="multipart/form-data">
  <div class="box grid_16 round_all">
    <h2 class="box_head grad_colour round_top">
      <select name="hotel_id" id="hotel_id">
        <?=$select_hotel=$bsiAdminMain->hotelname();?>
      </select>
    </h2>
    <a href="#" class="grabber">&nbsp;</a> <a href="#" class="toggle">&nbsp;</a>
    <div class="block no_padding">
      <fieldset>
        <legend ></legend>
        <table cellspacing="0" cellpadding="5" border="0" class="bodytext">
          <tbody>
            <tr>
              <td>Image 1: </td>
              <td><input type="file" size="25" name="image1" id="image1"/></td>
            </tr>
            <tr>
              <td>Image 2: </td>
              <td><input type="file" size="25" name="image2" id="image2"/></td>
            </tr>
            <tr>
              <td>Image 3: </td>
              <td><input type="file" size="25" name="image3" id="image3"/></td>
            </tr>
            <tr>
              <td>Image 4: </td>
              <td><input type="file" size="25" name="image4" id="image4"/></td>
            </tr>
            <tr>
              <td>Image 5: </td>
              <td><input type="file" size="25" name="image5" id="image5"/></td>
            </tr>
          </tbody>
        </table>
      </fieldset>
    </div>
  </div>
  <button name="act_sbmt" class="button_colour round_all" value="submit" id="button" disabled><img height="24" width="24" alt="Bended Arrow Right" src="images/icons/small/white/bended_arrow_right.png"><span>Upload</span> </button>
</form>
</body></html>