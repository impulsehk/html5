<?php 
include("access.php");
if(isset($_GET['hotel_id']) && isset($_GET['photoid'])){
	include("../includes/db.conn.php");
	include("../includes/conf.class.php");
	include("../includes/admin.class.php");
	$photoid=$bsiCore->ClearInput($_GET['photoid']);
	$p_path=mysql_fetch_assoc(mysql_query("select img_path from bsi_gallery where id='".$photoid."'"));
	if(isset($p_path['img_path'])){
		if($p_path['img_path'] !=""){
			if(file_exists("../gallery/hotelImage/thumb_".$p_path['img_path'])){
				unlink("../gallery/hotelImage/thumb_".$p_path['img_path']);
				unlink("../gallery/hotelImage/".$p_path['img_path']);
			}
		}
	}
	mysql_query("delete from bsi_gallery where id='".$photoid."'");
	header("location:gallery_list.php");
	exit;
}
	include("header.php");
?>
<script type="text/javascript">
$(document).ready(function(){
//************************************************* 	
	var querystr = 'actioncode=26&hotelid='+<?=$_SESSION['hhid']?>; 
	$.post("../admin/admin_ajax_processor.php", querystr, function(data){						 
		if(data.errorcode == 0){
			$('#gallery_list').html(data.categoryphoto);
		}else{
			$('#gallery_list').html(data.strmsg); 
		}	
	}, "json");
//**************************************************
});
</script>
<script type="text/javascript">
  function delFunction(id, hotel_id){
       window.location.href="<?=$_SERVER["PHP_SELF"]?>?photoid="+id+"&hotel_id="+hotel_id;
  }
</script>
<div class="flat_area grid_16">
  <button class="button_colour" style="float:right; padding-right:0px; margin-right:0px;" onclick="javascript:window.location.href='photo_upload.php'"><img height="24" width="24" alt="Bended Arrow Right" src="../admin/images/icons/small/white/bended_arrow_right.png"><span>Upload&nbsp;&nbsp;Photo</span></button>
  <h2>Hotel Photo List </h2>
</div>
<div class="box grid_16 round_all">
  <h2 class="box_head grad_colour round_top">&nbsp;&nbsp;</h2>
  <a href="#" class="grabber">&nbsp;</a> <a href="#" class="toggle">&nbsp;</a>
  <div class="block no_padding"> <span id="gallery_list"></span> </div>
</div>
</div>
<div id="loading_overlay">
  <div class="loading_message round_bottom">Loading...</div>
</div>
<div style="padding-right:8px;">
  <?php include("footer.php"); ?>
</div>
</body></html>