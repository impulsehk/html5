<?php



include ("access.php");



if(isset($_GET['delid'])){
	include("../includes/db.conn.php"); 
	include("../includes/conf.class.php");
	include("../includes/admin.class.php");
	$bsiAdminMain->delete_currency();
	header("location:currency_list.php");	
	exit;
}


$pageid = 55;

include ("header.php");


?>



<script>



	



</script>







<div class="flat_area grid_16">

  <button class="button_colour" style="float:right; padding-right:0px; margin-right:0px;" onClick="window.location.href='add_edit_currency.php?id=0'"><img height="24" width="24" alt="Bended Arrow Right" src="images/icons/small/white/bended_arrow_right.png"><span>Add New Currency</span></button>

  <h2>Currency List </h2>



</div>



<div class="box grid_16 round_all"> 



  <table  class="display datatable">



    <thead>



      <tr>



        <th width="20%">Currency Code</th>



        <th width="20%">Currency Symbol</th>



        <th width="20%">Exchange Rate</th>



        <th width="20%">Default Currency?</th>



        <th width="25%">&nbsp;</th>



      </tr>



    </thead>



  



    <?=$bsiAdminMain->generatecurrency()?>



   



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