<?php 
include ("access.php");//echo "<pre>";print_r($_SESSION);echo "</pre>";
if(isset($_SESSION['cpaccessid']) && $_SESSION['cpaccessid'] == 0){
	$_SESSION['ACCESS DENIED'] = '<table align="center"><tr><td><font style="font-family:\'Comic Sans MS\', cursive; font-size:24px; color:#F00;">ACCESS DENIED</font></td></tr></table>';
	header("location:admin-home.php");
	exit;
}
if(isset($_GET['id'])){
	global $bsiCore;
	include("../includes/db.conn.php"); 
	include("../includes/conf.class.php");
	mysql_query("delete from bsi_user_access where user_id=".$bsiCore->ClearInput(base64_decode($_GET['id'])));
    mysql_query("delete from bsi_admin where id=".$bsiCore->ClearInput(base64_decode($_GET['id'])));
	header("location:user_list.php");
	exit;
}
$pageid = 39;
include ("header.php");
?>
<?php
 $id  = 0;
 $acc = 0;
 $id  = base64_encode($id."|".$acc);
?>
<script type="text/javascript">
function addNew(id){
	var id = id;
	window.location="add_new_user.php?id=0&addedit=1";
}
</script>

<div class="flat_area grid_16">
  <button class="button_colour" style="float: right; padding-right: 0px; margin-right: 0px;" name="add_user" id="add_user" onclick=javascript:window.location.href='add_new_user.php?id=<?=$id?>&addedit=1'><img alt="Bended Arrow Right" src="images/icons/small/white/bended_arrow_right.png" height="24" width="24"><span>Add New User</span></button>
  <h2>User List</h2>
</div>
<div class="box grid_16 round_all">
  <?php if(isset($_SESSION['logmsg'])){?>
  <div align="center">
    <?='<font color="#FF0000" style="text-decoration:underline;"><b>'.$_SESSION['logmsg'].'</b></font>'?>
    <?php unset($_SESSION['logmsg']); ?>
  </div>
  <?php } ?>
  <h2 class="box_head grad_colour round_top">&nbsp;&nbsp;</h2>
  <a href="#" class="grabber">&nbsp;</a> <a href="#" class="toggle">&nbsp;</a>
  <div class="block no_padding">
    <form method="post" action="<?=$_SERVER['PHP_SELF']?>">
      <table cellpadding="6" class="static">
        <?=$bsiAdminMain->showbsiAdmin()?>
      </table>
    </form>
  </div>
</div>
</div>
<div style="padding-right:8px;">
  <?php include("footer.php"); ?>
</div>
</body></html>