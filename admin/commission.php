<?php 
	include("access.php");
	$pageid = 41;
	include("header.php");
?>
<script type="text/javascript">
$(document).ready(function() {
	 jQuery("#pdf_button:button").attr("disabled", "disabled");  
	 $('#agent_id').change(function() {  
		var querystr = 'actioncode=24&agent_id='+$('#agent_id').val();	 
		$.post("admin_ajax_processor.php", querystr, function(data){						 
			if(data.errorcode == 0){
			   $('#getTable').html('<div style="width:300px; height:50px;"><img src="images/ajax-loader(1).gif" /></div>');
			   $('#getTable').html(data.table);
			}else{
			   $('#getTable').html('<img src="images/ajax-loader(1).gif" />');
			   $('#getTable').html(data.strmsg);
			}
		}, "json");	
		if($('#agent_id').val() == 0){
			jQuery("#pdf_button:button").attr("disabled", "disabled"); 
			jQuery("#msg").show();  
		}else{
			jQuery("#msg").hide();
			jQuery("#pdf_button:button").removeAttr("disabled");
		}
    });
});
function getPDF(){
	var id = document.getElementById('agent_id').value;
	window.open('commissionList_PDF.php?comm='+id);
}
</script>
<div class="flat_area grid_16">
  <div style="width:420px; float:right;"><table width="100%"><tr><td width="50%" style="padding-bottom:10px;"><span id="msg">Please Select Agent From Dropdown. </span></td><td><?=$bsiCore->getAgentCombo()?><span><button class="skin_colour round_all" id="pdf_button" title="Print this page" style="float:right;" onclick="return getPDF();"><img src="images/icons/small/white/pdf_documents.png" width="24" height="24" alt="PDF Documents"><span>PDF</span></button></span></td></tr></table></div>
  <h2>Commission List</h2>
</div>
<span id="getTable">
</span>
</body></html>