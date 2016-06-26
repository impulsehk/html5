<?php
include ("access.php");
if(isset($_REQUEST['update'])){
	header('location:customerlookup.php');
	exit;
}
$pageid = 29;
include ("header.php");
$html = $bsiAdminMain->getCustomerHtml();
?>
<script>
	
</script>

<div class="flat_area grid_16">
  <h2>Customer List</h2>
</div>
<div class="box grid_16 round_all"> 
  <table  class="display datatable">
    <thead>
      <tr>
        <th width="25%">Customer Name</th>
        <!--<th width="30%">Address</th>-->
        <th width="25%">Phone</th>
        <th width="25%">Email Id</th>
        <th width="25%">&nbsp;</th>
      </tr>
    </thead>
    <tbody id="getcustomerHtml">
      <?=$html?>
    </tbody>
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