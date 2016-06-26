<?php 

	include("access.php");

	if(isset($_POST['sbt_submit'])){

		include("../includes/db.conn.php");

		include("../includes/conf.class.php");

		include("../includes/admin.class.php");

		$bsiAdminMain->capacity_addedit(); 

		header('Location:capacityList.php');

	}

	$pageid = 15;

	include ("header.php");

	

?>
<link rel="stylesheet" href="css/chosen.css">
<script type="text/javascript" src="js/jquery.validate.js"></script>

<script>

  $(document).ready(function(){

    $("#capcity-entry").validate();

	$('#hotel_id').change(function() { 

		activateBtn();

    });

	if($('#hotel_id').val() > 0){

		 activateBtn();			

	}

	//10/4/2012:@lok

	function activateBtn(){

		if($('#hotel_id').val() == 0){

			jQuery("#button:button").attr("disabled", "disabled"); 			

		}else{

			jQuery("#button:button").removeAttr("disabled");		

		}

	}

  });

</script>



<div class="flat_area grid_16">

<button name="submit" id="button" class="button_colour round_all" onclick="window.location.href='<?=$_SERVER['HTTP_REFERER']?>'" style="float:right;"><img height="24" width="24" alt="Bended Arrow Right" src="images/icons/small/white/bended_arrow_right.png"><span>Back</span></button>

  <h2>Add / Edit Occupancy types</h2>

</div>

<div class="box grid_16 round_all">

  <h2 class="box_head grad_colour round_top">&nbsp;</h2>

  <a href="#" class="grabber">&nbsp;</a> <a href="#" class="toggle">&nbsp;</a>

  <div class="block no_padding">

<?php 

	if(isset($_REQUEST['addedit'])){	

	$id=$bsiCore->ClearInput(base64_decode($_REQUEST['id']));

	if($id){

		$row_1 = $bsiCore->getCapacity($id);

		$hotel_list=$bsiAdminMain->hotelname($row_1['hotel_id']);				

	}else{

	$row_1=NULL;

	$hotel_list=$bsiAdminMain->hotelname();

	}

?>

    <form name="capcity-entry" id="capcity-entry" method="post" action="<?=$_SERVER['PHP_SELF']?>" enctype="multipart/form-data">

      <input type="hidden"  name="id" value="<?=$id?>" />

      <table cellpadding="8" cellspacing="0" border="0">

        <tr>

          <td align="left"><label>Hotel Name : </label></td>

          <td align="left"><select name="hotel_id" id="hotel_id" data-placeholder="Choose a hotel." class="chosen-select" style="width:250px;">

              <?=$hotel_list?>

            </select></td>

        </tr>

        

        <tr>

          <td align="left"><label>Occupancy types : </label></td>

          <td align="left"><input  style="width:250px;"  type="text"  id="title" name="title" value="<?=$row_1['title']?>" class="required" /></td>

        </tr>

        

        <tr>

          <td align="left"><label>Occupancy : </label></td>

          <td align="left"><input  style="width:50px;" type="text" id="capacity" name="capacity" value="<?=$row_1['capacity']?>" class="required digits" /></td>

        </tr>

        

     

        <tr><input type="hidden" name="sbt_submit" value="sbt_submit"/>

          <td></td><td><button name="submit" id="button" class="button_colour round_all"><img height="24" width="24" alt="Bended Arrow Right" src="images/icons/small/white/bended_arrow_right.png"><span>Submit</span></button></td>

        </tr>

      </table>

    </form>

    <?php } ?>

  </div>

</div>

</div>

<div id="loading_overlay">

  <div class="loading_message round_bottom">Loading...</div>

</div>

<div style="padding-right:8px;"><?php include("footer.php"); ?>
<script src="js/chosen.jquery.min.js" type="text/javascript"></script>
  <script type="text/javascript">
    var config = {
      '.chosen-select'           : {}
    }
    for (var selector in config) {
      $(selector).chosen(config[selector]);
    }
  </script>
</div> 

</body></html>