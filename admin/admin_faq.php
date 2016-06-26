<?php 
	include("access.php");
	if(isset($_REQUEST['delid'])){
		include("../includes/db.conn.php");
		include("../includes/conf.class.php");
		$fdeleteid=$bsiCore->ClearInput(base64_decode($_REQUEST['delid']));
		mysql_query("delete from bsi_faq where faq_id=".$fdeleteid);
		header("location:".$_SERVER['PHP_SELF']);
	}
	$pageid = 20;
	include ("header.php");
?>

<div class="flat_area grid_16">
  <button class="button_colour" style="float:right; padding-right:0px; margin-right:0px;" onclick="javascript:window.location.href='admin_faq_entry.php'" id="add_faq_form"><img height="24" width="24" alt="Bended Arrow Right" src="images/icons/small/white/bended_arrow_right.png"><span>Add FAQ</span></button>
  <h2>Faq Management </h2>
</div>
<div class="box grid_16 round_all">
    <table class="display datatable">
      <thead>
        <tr>
          <th style="width:50px;"><strong>Faq Id</strong></th>
          <th><strong>Question</strong></th>
          <th style="width:80px;"></th>
        </tr>
      </thead>
      <?php
			$faq_res=mysql_query("select * from bsi_faq");
			while($row=mysql_fetch_assoc($faq_res)){	
	   ?>
      <tr>
        <td><?=$row['faq_id']?></td>
        <td><?=$row['question']?></td>
        <td style="text-align:right; padding:0px 6px 0px 0px"><a href="admin_faq_entry.php?fid=<?=base64_encode($row['faq_id'])?>">Edit</a> | <a href="<?=$_SERVER['PHP_SELF']?>?delid=<?=base64_encode($row['faq_id'])?>">Delete</a></td>
      </tr>
      <?php   
		}
		?>
    </table>
  </div>
</div>
<div style="padding-right:8px;"><?php include("footer.php"); ?></div> 
</div>
</div>
</div>
<div id="loading_overlay">
  <div class="loading_message round_bottom">Loading...</div>
</div>
<script type="text/javascript" src="js/DataTables/jquery.dataTables.js"></script> 
<script type="text/javascript" src="js/adminica/adminica_datatables.js"></script>
</body></html>