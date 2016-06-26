<?php 


    include("access.php");


	if(isset($_REQUEST['cancel'])){

		include("../includes/admin.class.php");
		include("../includes/db.conn.php");
		include("../includes/conf.class.php");
		$cancel = $bsiCore->ClearInput($_GET['cancel']);	
		$status = $bsiAdminMain->BookingCancel($cancel);


		if($status == true){ 


			header("location:view_booking.php");


		}


	}


	$pageid = 24;


	include("header.php");


	$hotel_list = $bsiAdminMain->hotelname();	


?>

<link rel="stylesheet" href="css/chosen.css">

<script type="text/javascript">


	$(document).ready(function(){


		disableInput("#book_type");


		disableInput("#submit");


		$('#hotel_id').change(function(){


			if($('#hotel_id').val() > 0){


				enableInput("#book_type");			


			}else{


				disableInput("#book_type");


			}


		});


		$('#book_type').change(function(){


			if($('#book_type').val() != ""){


				enableInput("#submit");			


			}else{


				disableInput("#submit");


			}


		});


		//Enabling Disabling Function


		function disableInput(id){


			jQuery(id).attr('disabled', 'disabled');


		}


		function enableInput(id){


			jQuery(id).removeAttr('disabled');	


		}


	});


</script>


<div style="padding-left:200px; width:100%;">


	<div class="box grid_8">


  <h2 class="box_head grad_colour round_top">View Booking</h2>


  <a href="#" class="grabber">&nbsp;</a> <a href="#" class="toggle">&nbsp;</a>


  <div class="toggle_container">


    <div class="block no_padding">


    <form id="act-frm" method="post" action="view_active_or_archieve_bookings.php">

<input type="hidden" name="report" value="0"  />
    	<table class="bodytext" cellpadding="5" width="100%" align="center">


            <tr><td width="200px" style="padding-left:25px;"><strong>Select Hotel</strong></td><td><select name="hotel_id" id="hotel_id" data-placeholder="Choose a hotel." class="chosen-select" style="width:250px;"><?=$hotel_list?></select></td></tr>


        	<tr><td style="padding-left:25px;"><strong>Select Booking Type</strong></td><td><select name="book_type" id="book_type"><option value="">---Select Type---</option><option value="2">Booking History</option><option value="1">Active Booking</option></select></td></tr>


            <tr><td>&nbsp;</td><td><button id="submit" class="button_colour round_all"><img height="24" width="24" alt="Bended Arrow Right" src="images/icons/small/white/bended_arrow_right.png"><span>Submit</span></button></td></tr>      


   	 	</table>


    </form>


  </div>


  </div>


</div>


</div>


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