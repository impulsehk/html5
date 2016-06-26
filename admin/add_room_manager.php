<?php


	include("access.php");


	/*if(!isset($_GET['add']) || $_GET['add'] != 111){


	   header("location:roomList.php");	


	}*/


	if(isset($_POST['sbt_room'])){


		include("../includes/db.conn.php");


		include("../includes/conf.class.php");


		include("../includes/admin.class.php");


		$bsiAdminMain->hotel_room_entry();


		header("location:roomList.php");


	}


	$pageid = 13;


	include("header.php");


	$hotel_list=$bsiAdminMain->hotelname();


	$capacity_id=$bsiAdminMain->hotel_room_capacity();


?>


<script type="text/javascript" src="js/jquery.validate.js"></script>


<script>


	$(document).ready(function(){


		$("#add_edit_room").validate();


	});


</script>



<link rel="stylesheet" href="css/chosen.css">

<script type="text/javascript">


$(document).ready(function() {


	 $('#hotel_id').change(function() { 


		if($('#hotel_id').val() == 0){


			jQuery("#button:button").attr("disabled", "disabled");  


			$('#roomtype').html('<tr><td colspan=6><font color="#9B0000">Please Select Hotel First !</font></td></tr>');


			$('#capacity').html('<tr><td colspan=6><font color="#9B0000">Please Select Hotel First !</font></td></tr>');			


		}else{


			jQuery("#button:button").removeAttr("disabled"); 


			var querystr = 'actioncode=7&hotelid='+$('#hotel_id').val(); 


			$.post("admin_ajax_processor.php", querystr, function(data){						 


				if(data.errorcode == 0){


					 $('#roomtype').html(data.roomtype);


					  $('#capacity').html(data.capacity);


				}else{


				   $('#roomtype').html('<tr><td colspan=6><font color="#9B0000">Sorry No Roomtype found in this hotel !</td></font></tr>');


				   $('#capacity').html('<tr><td colspan=6><font color="#9B0000">Sorry No Room Capacity found in this hotel !</font></td></tr>');


				   jQuery("#button:button").attr("disabled", "disabled");


				}


			}, "json");			


		}


    });

/*mmmm*/
	
/*	$('#capacity').change(function() { 
        getExtrabed();
	});

	if($('#capacity').val() > 0){
		getExtrabed();
	}
	
	
		function getExtrabed(){

		if($('#capacity').val() != 0){ 

			$("#submit").removeAttr("disabled");

			var querystr = 'actioncode=30&capacity_id='+$('#capacity').val()+'&roomtype_id='+$('#roomtype').val(); 	
			
			alert(querystr);die;

			$.post("admin_ajax_processor.php", querystr, function(data){												 

				if(data.errorcode == 0){

					 $('#extrabed_allowed').html(data.strhtml)

				}else{

					$('#extrabed_allowed').html(data.strmsg)

				}

			}, "json");

		}else{

			$('#extrabed_allowed').html('<span style=\"font-family:Arial, Helvetica, sans-serif; font-size:10px;\"><?=PLEASE_SELECT_ADULT?></span>');

		}

	}
*/

});

</script>

<script type="text/javascript">


$(document).ready(function() {

$('#capacity').change(function() { 


		if($('#capacity_id').val() == 0){

//var a =$('#capacity_id').val();

//alert(a);
			jQuery("#button:button").attr("disabled", "disabled");  


			$('#extrabed_allowed').html('<tr><td colspan=6><font color="#9B0000">Please select No of Adult First !</font></td></tr>');


			//$('#capacity').html('<tr><td colspan=6><font color="#9B0000">Please Select Hotel First !</font></td></tr>');			


		}else{


			jQuery("#button:button").removeAttr("disabled"); 


			var querystr = 'actioncode=30&hotelid='+$('#hotel_id').val()+'&capacity_id='+$('#capacity_id').val()+'&roomtype_id='+$('#roomtype_id').val(); 

          // alert(querystr);
			$.post("admin_ajax_processor.php", querystr, function(data){						 


				if(data.errorcode == 0){


					 //$('#roomtype').html(data.roomtype);
					 // $('#capacity').html(data.capacity);
                 $('#extrabed_allowed').html(data.strhtml)

				}else{


				 //  $('#roomtype').html('<tr><td colspan=6><font color="#9B0000">Sorry No Roomtype found in this hotel !</td></font></tr>');


				  // $('#capacity').html('<tr><td colspan=6><font color="#9B0000">Sorry No Room Capacity found in this hotel !</font></td></tr>');


				   jQuery("#button:button").attr("disabled", "disabled");


				}


			}, "json");			


		}


    });

});

</script>

<div class="flat_area grid_16">


<button class="button_colour round_all" id="button" onclick="window.location.href='<?=$_SERVER['HTTP_REFERER']?>'" style="float:right;"><img height="24" width="24" alt="Bended Arrow Right" src="images/icons/small/white/bended_arrow_right.png"><span>Back</span></button>


  <h2>Add / Edit Room</h2>


</div>


<div class="box grid_16 round_all">


  <h2 class="box_head grad_colour round_top">&nbsp;</h2>


  <a href="#" class="grabber">&nbsp;</a> <a href="#" class="toggle">&nbsp;</a>


  <div class="block no_padding">


    <?php if((isset($_GET['add'])) && ($_GET['add'] == 111)){?>


    <form name="add_edit_room" id="add_edit_room" method="post" action="<?=$_SERVER['PHP_SELF']?>">


      <table cellpadding="6" cellspacing="0" border="0" >


        <tr>


          <td><label>Hotel Name : </label></td>


          <td align="left" ><select name="hotel_id" id="hotel_id" data-placeholder="Choose a hotel." class="chosen-select" style="width:250px;">


              <?=$hotel_list?>


            </select></td>
        </tr>


        <tr>


          <td><label>Room Type : </label></td>


          <td align="left"><span id="roomtype"><font color="#9B0000">Please Select Hotel First</font></span></td>
        </tr>


        <tr>


          <td><label>No of Rooms : </label></td>


          <td align="left"><input  type="text" class="required digits"   id="room_no" name="room_no"  style="width:100px;" /></td>
        </tr>


        <tr>


          <td><label>Capacity : </label></td>


          <td align="left"><span id="capacity"><font color="#9B0000">Please Select Hotel First</font></span></td>
        </tr>


        <tr>


          <td><label>No of Children : </label></td>


          <td align="left"><input  type="text" class="digits"  id="no_of_child" name="no_of_child"  style="width:100px;" /></td>
        </tr>


<!--<tr>
<td><label>Extra One Bed : </label></td>
<td align="left"><input type="checkbox" name="extrabed"  ></td>
</tr>-->
  


        <tr>


          <td></td>


          <td><input  type="hidden" value="11" name="sbt_room" />


            <button class="button_colour round_all" id="button"><img height="24" width="24" alt="Bended Arrow Right" src="images/icons/small/white/bended_arrow_right.png"><span>Submit</span></button></td>
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