<?php 
 include("access.php");
 if(isset($_POST['submit'])){		
	include("../includes/db.conn.php");
	include("../includes/conf.class.php");
	include("../includes/admin.class.php");
	$bsiAdminMain->category_addedit();
	header("Location:adminAroundCategoryList.php");
	exit;
 }
 if(!isset($_GET['addedit']) || $_GET['addedit'] != 1){ 
	 header("location:adminAroundCategoryList.php");	
	 exit;
 }
 if(!isset($_GET['id']) || $_GET['id'] == ""){
	 header("location:adminAroundCategoryList.php");
	 exit;	
 }
 include("header.php");
?>
<script type="text/javascript" src="../admin/js/jquery.validate.js"></script>
<script type="text/javascript">
$(document).ready(function() { 
	$("#around-frm").validate();
	if($('#hotel_id').val() > 0){
		jQuery("#button:button").removeAttr("disabled");	
	}    
	//17/3/2012
	if($('#hotel_id').val() > 0){
		var querystr = 'actioncode=12&hotelid='+$('#hotel_id').val(); 
		$.post("../admin/admin_ajax_processor.php", querystr, function(data){						 
			if(data.errorcode == 0){
				 $('#selectcategory').html(data.categoryList);
			}else{
				$('#selectcategory').html('<label>No Category Found</label>');
			}
		}, "json");
	}
});
</script>
<div class="flat_area grid_16">
  <button name="submit" class="button_colour round_all" value="submit" id="button" onclick="window.location.href='<?=$_SERVER['HTTP_REFERER']?>'" style="float:right;"><img height="24" width="24" alt="Bended Arrow Right" src="../admin/images/icons/small/white/bended_arrow_right.png"><span>
  Back
  </span></button>
  <h2>Add Edit Around </h2>
</div>
<div class="box grid_16 round_all">
  <h2 class="box_head grad_colour round_top">&nbsp;</h2>
  <a href="#" class="grabber">&nbsp;</a> <a href="#" class="toggle">&nbsp;</a>
  <div class="block no_padding">
    <?php 
		if(isset($_REQUEST['addedit'])){	
		$id = $bsiCore->ClearInput(base64_decode($_REQUEST['id']));
		if($id){
			$row_1 = $bsiCore->getAroundCategory($id);										
		}else{
			$row_1 = NULL;	
		}
	?>
    <form name="around-frm" id="around-frm" method="post" action="<?=$_SERVER['PHP_SELF']?>">
      <table cellpadding="8" cellspacing="0" border="0">
        <input type="hidden"  name="id" value="<?=$id?>" />
        <input type="hidden" name="hotel_id" id="hotel_id" value="<?php echo $_SESSION['hhid']; ?>" />
        <input type="hidden" name="categoryTitle" id="categoryTitle" value="<?=$row_1['category_id']?>" />
        <tr>
          <td><label>
              Category Title
              : </label></td>
          <td><?php if($id>0){
					   echo $row_1['category_title'];
				    }else{
			?>
            <span id="selectcategory"></span>
            <?php } ?></td>
        </tr>
        <tr>
          <td><label>
              Title
              : </label></td>
          <td><input type="text" class="required" id="title" name="title" style="width:250px;" value="<?=$row_1['title']?>"/></td>
        </tr>
        <tr>
          <td><label>
              Distance
              : </label></td>
          <td><input type="text" class="required number" id="distance" name="distance" style="width:70px;" value="<?=$row_1['distance']?>"/>
            <span style="padding-left:15px;">
            <label>
              KM
            </label>
            </span></td>
        </tr>
        <tr>
          <td>&nbsp;</td>
          <td><button name="submit" class="button_colour round_all" value="submit" id="button"><img height="24" width="24" alt="Bended Arrow Right" src="../admin/images/icons/small/white/bended_arrow_right.png"><span>
           Submit
            </span></button></td>
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
<div style="padding-right:8px;">
  <?php include("footer.php"); ?>
</div>
</body></html>