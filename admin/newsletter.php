<?php 
    include("access.php");
	if(isset($_REQUEST['delid'])){
		include("../includes/db.conn.php");
		include("../includes/conf.class.php");
		include("../includes/admin.class.php");
		$bsiAdminMain->email_delete(); 
		header("location:newsletter.php");
	}
	$pageid = 40;
	include("header.php");
	$gethtml = $bsiAdminMain->getBsiNewsletter();
?>
<script language="javascript">
	function email_delete(delid){
		var answer = confirm ("Are you sure want to delete this Email? Remember corresponding of  all data will be deleted forever.");
		if (answer)
			window.location="<?=$_SERVER['PHP_SELF']?>?delid="+delid;
	}	
</script>
<div class="flat_area grid_16">
  <h2>News Letter List</h2>
</div>
<div class="box grid_16 round_all">
  <h2 class="box_head grad_colour round_top">&nbsp;&nbsp;</h2>
  <a href="#" class="grabber">&nbsp;</a> <a href="#" class="toggle">&nbsp;</a>
  <div class="block no_padding">
    <table class="display datatable">
      <thead>
        <tr>
          <th nowrap="nowrap" class="first" width="10%">Email Id</th>
          <th nowrap="nowrap" width="60%">Email Address</th>
          <th nowrap="nowrap" width="20%">Email Date</th>
          <th class="last" nowrap="nowrap" width="10%">&nbsp;</th>
        </tr>
      </thead>
      <tbody>
      <?=$gethtml?>
      </tbody>
    </table>
  </div>
</div>
</div>
 <div style="padding-right:8px;"><?php include("footer.php"); ?></div> 
<script type="text/javascript" src="js/DataTables/jquery.dataTables.js"></script> 
<script type="text/javascript" src="js/adminica/adminica_datatables.js"></script>
</body></html>