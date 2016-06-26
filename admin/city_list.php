<?php 


include("access.php");


	if(isset($_REQUEST['delcid'])){


		include("../includes/db.conn.php");


		include("../includes/conf.class.php");


		include("../includes/admin.class.php");


		$bsiAdminMain->deleteCity(); 


		header("location:city_list.php");


	}


	$pageid = 9;


	include("header.php");


	$getHtml = $bsiAdminMain->getAllcity(); 


?>
        
<div class="flat_area grid_16">
  <button class="button_colour" style="float:right; padding-right:0px; margin-right:0px;" onclick="javascript:window.location.href='add_new_city.php?cid=<?php echo  base64_encode(0);?>'"><img height="24" width="24" alt="Bended Arrow Right" src="images/icons/small/white/bended_arrow_right.png"><span>Add New City</span></button>
  <h2>City List&nbsp;&nbsp;<?php
  if(isset($_SESSION['err'])){
	  echo '<font color="#FF0000">Already exists</font>';
	  unset($_SESSION['err']);
  }
?></h2>



</div>


<div class="box grid_16 round_all">


    <table class="display datatable">


      <thead>


        <tr>

          <th nowrap="nowrap" class="first" width="200">City Name</th>
		  <th nowrap="nowrap">Country Name</th>

          <th class="last" nowrap="nowrap">&nbsp;</th>


        </tr>


      </thead>


      <tbody>


        <?=$getHtml?>


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