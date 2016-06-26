<?php 
include("access.php");
if(isset($_GET['hotel_id']) && isset($_GET['photoid'])){
	include("../includes/db.conn.php");
	include("../includes/conf.class.php");
	include("../includes/admin.class.php");
	
	$photoid=$bsiCore->ClearInput($_GET['photoid']);
	$hotel_id=$bsiCore->ClearInput($_GET['hotel_id']);
	//echo "select img_path from bsi_gallery where id='".$photoid."'";die;
	$p_path = mysql_fetch_assoc(mysql_query("select img_path from bsi_gallery where id='".$photoid."'"));;
	
	if(file_exists("../gallery/hotelImage/thumb_".$p_path['img_path'])){
		unlink("../gallery/hotelImage/thumb_".$p_path['img_path']);
		unlink("../gallery/hotelImage/".$p_path['img_path']);
	}
	mysql_query("delete from bsi_gallery where id='".$photoid."'");
	
	$_SESSION['hotel_id']=$hotel_id;
	header("location:gallery_list.php");
	exit;
}
  $pageid=23;
	include("header.php");
	if(isset($_SESSION['hotel_id'])){
		$hotel_list=$bsiAdminMain->hotelname($_SESSION['hotel_id']);
	}else{
		$hotel_list=$bsiAdminMain->hotelname();
	}
?>
<link rel="stylesheet" href="css/chosen.css">
<script type="text/javascript">
$(document).ready(function(){
//************************************************* 	
	if($('#hotel_id').val() > 0){
		 galleryList();		 
	 }
 
  $('#hotel_id').change(function() { 
		galleryList();		
	});
function galleryList(){
	if($('#hotel_id').val() != 0 ){
			var querystr = 'actioncode=13&hotelid='+$('#hotel_id').val();
			//alert(querystr);
			$.post("admin_ajax_processor.php", querystr, function(data){						 
				if(data.errorcode == 0){
					$('#gallery_list').html(data.categoryphoto);
				}else{
				    $('#gallery_list').html(data.strmsg);
				}	
			}, "json");
		}else{
			$('#gallery_list').html('please select hotel first');
		}
}
});
//**************************************************
</script>
<script type="text/javascript">
  function delFunction(id, hotel_id){
       window.location.href="<?=$_SERVER["PHP_SELF"]?>?photoid="+id+"&hotel_id="+hotel_id;
  }
</script>

<div class="flat_area grid_16">
  <h2>Hotel Gallery List
    <button class="button_colour" style="float:right; padding-right:0px; margin-right:0px;" onclick="javascript:window.location.href='photo_upload.php'"><img height="24" width="24" alt="Bended Arrow Right" src="images/icons/small/white/bended_arrow_right.png"><span>Upload Photo</span></button>
  </h2>
</div>
<div class="box grid_16 round_all">
  <h2 class="box_head grad_colour round_top">Select Hotel&nbsp;&nbsp;
    <select name="hotel_id" id="hotel_id" data-placeholder="Choose a hotel." class="chosen-select" style="width:250px;">
      <?=$hotel_list?>
    </select>
  </h2>
  <a href="#" class="grabber">&nbsp;</a> <a href="#" class="toggle">&nbsp;</a>
  <div class="block no_padding"> <span id="gallery_list"></span> </div>
</div>
</div>
<!--<script type="text/javascript" src="js/fancybox/fancybox/jquery.fancybox-1.3.4.js"></script>
		<script type="text/javascript"> 
          $(".gallery ul li a").fancybox({
                 'overlayColor':'#000'   
          });
          $("a img.fancy").fancybox();
        </script>-->
<div id="loading_overlay">
  <div class="loading_message round_bottom">Loading...</div>
</div>
<div style="padding-right:8px;">
  <?php include("footer.php"); ?>
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
</body></html>