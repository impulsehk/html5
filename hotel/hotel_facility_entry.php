<?php
	include("access.php");
	if(isset($_POST['sbt_facility'])){
		include("../includes/db.conn.php");
		include("../includes/conf.class.php");
		include("../includes/admin.class.php");
		$bsiAdminMain->hotel_facility_entry();
		header("location:hotel_facility_list.php");
		exit; 
	}
	include("header.php");
	$id = base64_decode(mysql_real_escape_string($_GET['id']));
	if($id){ 
		$row = mysql_fetch_assoc(mysql_query("select * from bsi_hotel_facilities where facilities_id='".$id."'"));
	}else{
		$row = NULL;
	}
?>
<script src="//cdn.ckeditor.com/4.5.1/basic/ckeditor.js"></script>

<div class="flat_area grid_16">
  <button class="button_colour round_all" onclick="window.location.href='<?=$_SERVER['HTTP_REFERER']?>'" style="float:right;"><img height="24" width="24" alt="Bended Arrow Right" src="../admin/images/icons/small/white/bended_arrow_right.png"><span>
  Back
  </span></button>
  <h2> Add / Edit Hotel Facility </h2>
</div>
<div class="box grid_16 round_all">
  <h2 class="box_head grad_colour round_top">&nbsp;</h2>
  <a href="#" class="grabber">&nbsp;</a> <a href="#" class="toggle">&nbsp;</a>
  <div class="block no_padding">
    <form name="facility" method="post" action="<?=$_SERVER['PHP_SELF']?>">
      <input type="hidden" name="id" value="<?php echo $id; ?>" />
      <input type="hidden" name="hotel_id" value="<?php echo $_SESSION['hhid']; ?>" />
      <table cellpadding="3" class="bodytext"  width="100%">
	  
	  <tr>
                            	<td height="30px" width="120px">
                                	
                                </td>
                                <td  height="30px">
                                
                                  
                                </td>
                            </tr>
	  
	  
	  
        <tr>
          <td valign="top"><label> General Facilities
              : </label></td>
          <td align="left"><textarea name="general" class="ckeditor" cols="80" rows="7"><?=$row['general']?>
</textarea></td>
        </tr>
        <tr>
          <td valign="top"><label> Activities Facilities
              : </label></td>
          <td align="left"><textarea name="activities" class="ckeditor" cols="80" rows="7"><?=$row['activities']?>
</textarea></td>
        </tr>
        <tr>
          <td valign="top"><label> Services Facilities
              : </label></td>
          <td align="left"><textarea name="services" class="ckeditor" cols="80" rows="7"><?=$row['services']?>
</textarea></td>
        </tr>
        <tr>
          <td>&nbsp;</td>
          <td><input  type="hidden" value="11" name="sbt_facility" />
            <button class="button_colour round_all"><img height="24" width="24" alt="Bended Arrow Right" src="../admin/images/icons/small/white/bended_arrow_right.png"><span>
            Submit
            </span></button></td>
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