<?php 
include("access.php");
if(isset($_POST['act_sbmt'])){
    include("../includes/db.conn.php");
	include("../includes/conf.class.php");
	include("../includes/admin.class.php");
	$bsiAdminMain->main_gallery_img_upload();
	header("location:gallery_list.php");
	exit;
}
include("header.php");	
?>
<script type="text/javascript">
 function imagefieldvalidation(){
	 var myImage=new Array();
	 myImage[0] = document.forms["myForm"]["image1"].value;
	 myImage[1] = document.forms["myForm"]["image1"].value;
	 myImage[2] = document.forms["myForm"]["image1"].value;
	 myImage[3] = document.forms["myForm"]["image1"].value;
	 myImage[4] = document.forms["myForm"]["image1"].value;
 	 for(var i = 0;i < myImage.length;i++){
	   if(myImage[i] == "" || myImage[i] == null){
		   alert("please choose at least one image");
		   return false;	   
	   }else{
			return true;
	   }
     } 
 }
</script>
<div class="flat_area grid_16">
  <button class="button_colour" style="float:right; padding-right:0px; margin-right:0px;" onclick="javascript:window.location.href='gallery_list.php'"><img height="24" width="24" alt="Bended Arrow Right" src="../admin/images/icons/small/white/bended_arrow_right.png"><span>BACK</span></button>
  <h2>&nbsp;</h2>
</div>
<form action="<?=$_SERVER['PHP_SELF']?>" name="myForm" method="post" enctype="multipart/form-data" onsubmit="return imagefieldvalidation();">
  <div class="box grid_16 round_all">
    <h2 class="box_head grad_colour round_top">&nbsp;&nbsp;</h2>
    <a href="#" class="grabber">&nbsp;</a> <a href="#" class="toggle">&nbsp;</a>
    <div class="block no_padding">
      <fieldset>
        <legend></legend><input type="hidden" name="hotel_id" value="<?=$_SESSION['hhid']?>" />
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
  <button name="act_sbmt" class="button_colour round_all" value="submit" id="button"><img height="24" width="24" alt="Bended Arrow Right" src="../admin/images/icons/small/white/bended_arrow_right.png"><span>Upload</span> </button>
</form>
</body></html>