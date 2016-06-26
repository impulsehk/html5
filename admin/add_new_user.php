<?php 
include ("access.php");
if(isset($_POST['submit'])){
	include("../includes/db.conn.php");
	include("../includes/conf.class.php");
	include("../includes/admin.class.php");
	$bsiAdminMain->bsiEditupdate($_POST['idd']);
	header("location:user_list.php");
	exit;
}
$pageid = 39;
include("header.php"); 
if(isset($_GET['id'])){
	$id = $bsiCore->ClearInput(base64_decode($_GET['id']));
	$idarr = explode("|", $id);
	$accessid = $idarr[1];
	$id = $idarr[0];		
}
if($id){
	if($id == 1){
		$class = '';
	}else{
		$class = 'class="required"';
	}
	$getHtml = $bsiAdminMain->getmenuListGenerate($id);
	$strhtml=$bsiAdminMain->bsiAdminedit($id);
	$attribute = 'readonly="readonly"';
	if($strhtml['status'] == 1){
		$status='checked="checked"';
	}else{
		$status=NULL;
	}
	$passcomment="(leave blank for un-change password)";	
}else{
	$attribute = '';
	$getHtml = $bsiAdminMain->getmenuListGenerate();
	$strhtml = NULL;
	$status=NULL;	
	$passcomment="";
	
	$class = 'class="required"';	
}
?>
<script type="text/javascript" src="../scripts/jquery-1.2.6.min.js"></script>
<script type="text/javascript" src="js/jquery.validate.js"></script>
<script type="text/javascript">
$(document).ready(function(){
	
	$("#menuFrm").validate();
	});
function checkAll(ca) {
var fs=ca.id.split('-')[1];
var cboxes=document.getElementById('fs-'+fs).getElementsByTagName('input');
for (j=0; j<cboxes.length; j++) {
cboxes[j].checked=((ca.checked==true)? true : false);
}
}
function initCheckAll() {
var fsets=document.getElementById('menuFrm').getElementsByTagName('fieldset');
for (i=0; i<fsets.length; i++) {
document.getElementById('ca-'+i).onclick=function() {checkAll(this)}
}
}
window.onload=initCheckAll;
</script>
  <div class="flat_area grid_16">
  <button name="button" onclick="javascript:window.location.href='<?=$_SERVER['HTTP_REFERER']?>'" id="button" class="button_colour round_all" style="float:right;"><img height="24" width="24" alt="Bended Arrow Right" src="images/icons/small/white/bended_arrow_right.png"><span>Back</span></button>
    <h2>User Add / Edit</h2>
  </div>
  <div class="box grid_16 round_all">
    <h2 class="box_head grad_colour round_top">&nbsp;&nbsp;</h2>
    <a href="#" class="grabber">&nbsp;</a> <a href="#" class="toggle">&nbsp;</a>
    <div class="block no_padding"> 
    <form method="post" action="<?=$_SERVER['PHP_SELF']?>" name="menuFrm" id="menuFrm">
      <table cellpadding="8">
        <tr>
          <td align="left" width="100px"><strong>First Name:</strong></td>
          <td><input type="text" class="required" value="<?=$strhtml['f_name']?>" style="width:250px;" name="fname" id="fname"/></td>
        </tr>
        <tr>
          <td align="left"><strong>Last Name:</strong></td>
          <td><input type="text" <?=$class?> value="<?=$strhtml['l_name']?>" style="width:250px;" name="lname" id="lname"/></td>
        </tr>
        <tr>
          <td align="left"><strong>User Name:</strong></td>
          <td><input type="text" class="required" value="<?=$strhtml['username']?>" style="width:250px;" <?=$attribute?> name="uname" id="uname"/></td>
        </tr>
        <tr>
          <td align="left"><strong>Password:</strong></td>
          <td><input type="password"   value="" style="width:250px;" name="pass" id="pass"/><?=$passcomment?>
            </td>
        </tr>
        <tr>
          <td align="left"><strong>Email:</strong></td>
          <td><input type="text" value="<?=$strhtml['email']?>" class="required email" <?=$attribute?> name="email" id="email" style="width:250px;"/></td>
        </tr>
        <tr>
          <td align="left"><strong>Designation:</strong></td>
          <td><input type="text" class="required" value="<?=$strhtml['designation']?>" style="width:250px;"  <?php if($accessid){ echo $attribute; } ?> name="designation" id="designation"/></td>
        </tr>
        <tr>
          <td align="left"><strong>Status:</strong></td>
          <td><input type="checkbox" name="status" id="status" value="1" <?=$status?> /></td>
        </tr>
      </table>
      <div style="padding-left:10px; padding-right:10px;">
      <?php if(!$accessid){ echo $getHtml; }?>
      </div>
      <input type="hidden" name="httpRefferer" value="<?=$_SERVER['HTTP_REFERER']?>" />
      <input type="hidden" id="accessid" name="accessid" value="<?=$accessid?>"/>
      <input type="hidden" id="id" name="idd" value="<?=$id?>"/>
      <input type="hidden" name="act" value="1">
      <?php
	  if($strhtml['id'] == 1){
	  ?>
    <button class="button_colour round_all" type="submit"  name="submit" style="margin-left:125px; "><img height="24" width="24" alt="Bended Arrow Right" src="images/icons/small/white/bended_arrow_right.png"><span>Submit</span></button>
    <?php
	  }else{
	?>
     <button class="button_colour round_all" type="submit"  name="submit" style="margin-left:370px; "><img height="24" width="24" alt="Bended Arrow Right" src="images/icons/small/white/bended_arrow_right.png"><span>Submit</span></button>
    <?php
	  }
	?>
    </form>
    </div>
  </div>
</div>
<div style="padding-right:8px;">
  <?php include("footer.php"); ?>
</div>
</body>
</html>