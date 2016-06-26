<?php 
	include("access.php");
	if(isset($_GET['a_id'])){
		include("../includes/db.conn.php");
	    include("../includes/conf.class.php");
		$aid=$bsiCore->ClearInput(base64_decode($_GET['a_id']));
		$rowStatus=$bsiCore->getAgentrow($aid);
		
		if($rowStatus['status']==1){			
			mysql_query("update bsi_agent set status='0' where agent_id=".$aid);
			header("location:agent_list.php");
		}else{			
			mysql_query("update bsi_agent set status='1' where agent_id=".$aid);
			header("location:agent_list.php");
		}
	}
	
	if(isset($_GET['delid'])){
		include("../includes/db.conn.php");
	    include("../includes/conf.class.php");
		$agent_id=$bsiCore->ClearInput($_GET['delid']);
		mysql_query("delete from bsi_agent where agent_id='".$agent_id."'");
		header("location:agent_list.php");
	}
	$pageid = 41;
	include("header.php");
?>
<script language="javascript">
	function agentList_delete(delid){
		var answer = confirm ("Are you sure want to delete this Agent?");
		if(answer)
			window.location="agent_list.php?delid="+delid
	}
</script>
<?php
		$i        = 1;
		$getHtml  = '';
		$text     = '';
		$sql      = $bsiCore->getAgentList(); 
		$result   = mysql_query($sql);
		while($row = mysql_fetch_assoc($result)){
			$country = $bsiCore->getCountry($row['country']);
			$getHtml .= '<tr>
			<td align="right">'.$row['agent_id'].'</td>
			<td>'.$row['fname']." ".$row['lname'].'</td> 
			<td>'.$row['email'].'</td>
			<td>'.$row['phone'].'</td><td>'; 
			if($row['status'] == 0){ $text = "<font color=\"#990000\"><b>Disabled</b></font>";}else{ $text="<font color=\"#00CC00\"><b>Enabled</b></font>"; }
			$getHtml .= $text.'</td>
                      <td style="text-align:right; padding:0px 15px 0px 0px"><a href="add_edit_agent.php?agent_id='.base64_encode($row['agent_id']).'&addedit=1">Edit</a> | <a onClick="javascript:agentList_delete('.$row['agent_id'].')" style="cursor:pointer;">Delete</a> | <a href="agentView.php?agent_id='.base64_encode($row['agent_id']).'">View Details</a> | <a href="hotel_list.php?agent_id='.base64_encode($row['agent_id']).'">View Hotel(s)</a></td> 
                	  </tr>';
		 $i++;			 
		}
		$getHtml = $getHtml;
?>
<div class="flat_area grid_16">
  <?php $id = base64_encode(0);?>
  <button class="button_colour" style="float:right; padding-right:0px; margin-right:0px;" onclick="javascript:window.location.href='add_edit_agent.php?agent_id=<?=$id?>&addedit=1'"><img height="24" width="24" alt="Bended Arrow Right" src="images/icons/small/white/bended_arrow_right.png"><span>Add New Agent</span></button>
  <button class="skin_colour round_all" id="pdf_button" title="Print this page" style="float:right;" onclick="javascript:window.open('agentList_PDF.php?query=<?=base64_encode($sql)?>')"><img src="images/icons/small/white/pdf_documents.png" width="24" height="24" alt="PDF Documents"><span>PDF</span></button>
  <h2>Agent List</h2>
</div>
<div class="box grid_16 round_all">
  <table class="display datatable">
    <thead>
      <tr>
        <th style="padding-left:7px; width:50px;">Agent Id</th>
        <th style="padding-left:7px; width:170px;">Agent Name</th>
        <th style="padding-left:7px; width:250px;">Email Id</th>
        <th style="padding-left:7px; width:90px;">Phone</th>
        <th style="padding-left:7px; width:60px;">Status</th>
        <th style="width:220;">&nbsp;</th>
      </tr>
    </thead>
    <tbody id="getAgentform">
      <?=$getHtml?>
    </tbody>
  </table>
</div>
</div>
<div style="padding-right:8px;">
  <?php include("footer.php"); ?>
</div>
</div>
</div>
</div>
<div id="loading_overlay">
  <div class="loading_message round_bottom">Loading...</div>
</div>
<script type="text/javascript" src="js/DataTables/jquery.dataTables.js"></script> 
<script type="text/javascript" src="js/adminica/adminica_datatables.js"></script>
</body></html>