<?php 


	include("access.php");


	if(isset($_GET['delid'])){


		include("../includes/db.conn.php");


		include("../includes/conf.class.php");


		include("../includes/admin.class.php");


		$pln_del = base64_decode(mysql_real_escape_string($_REQUEST['delid']));


		$pln_del = explode("|",$pln_del);


		if(isset($_SESSION['roomtypeid'])){


			$_SESSION['roomtypeid'] = $pln_del[2]; 


		}else{


			$_SESSION['roomtypeid'] = $pln_del[2]; 


		}

//echo "delete from bsi_priceplan where date_start='$pln_del[0]' and date_end='$pln_del[1]' and room_type_id=".$pln_del[2]." and hotel_id=".$pln_del[3];die;

		mysql_query("delete from bsi_priceplan where date_start='$pln_del[0]' and date_end='$pln_del[1]' and room_type_id=".$pln_del[2]." and hotel_id=".$pln_del[3]);


		header("location:priceplan_list.php");


	}


	$pageid = 16;


	include("header.php");


	


	if(isset($_SESSION['hotel_id']) && isset($_SESSION['roomtypeid'])){


		$hotel_list = $bsiAdminMain->hotelname($_SESSION['hotel_id']);


	}else{


		$hotel_list=$bsiAdminMain->hotelname();


	}


	if(isset($_SESSION['hotel_id']) && isset($_SESSION['roomtypeid'])){


		$catch1 = $bsiAdminMain->roomtypeList($_SESSION['hotel_id'],$_SESSION['roomtypeid']); 


	}


	


?>

<link rel="stylesheet" href="css/chosen.css">

<script type="text/javascript">


$(document).ready(function(){


	 $('#hotelid').change(function() { 


	 	$('#getajaxhtml').html('<tr><td colspan=8 align="center"><img src="images/ajax-loader(1).gif" /></td></tr>');


		getHotelid();


		$('#getajaxhtml').html('<td colspan="8">Please Select Roomtype</td>'); 


	 });


	 


	 function getHotelid(){


		if($('#hotelid').val() != 0){


			var querystr = 'actioncode=6&hotelid='+$('#hotelid').val(); 


			$.post("admin_ajax_processor.php", querystr, function(data){												 


				if(data.errorcode == 0){ 


					$('#room_type').html(data.roomtype_dowpdown)


				}else{


				    $('#room_type').html('')


					$('#getajaxhtml').html('<td colspan="8">No Room Type Found In This Hotel !</td>')


				}


				


			}, "json");


		}


		 


		 if($('#hotelid').val() == 0){


			$('#room_type').html('<option value="0">Select Room Type</option>')


			$('#getajaxhtml').html('<td colspan="8">Please Select hotel first</td>')


	 	}


	 }


	 


	 


	 $('#room_type').change(function() { 


	 	$('#getajaxhtml').html('<tr><td colspan=8 align="center"><img src="images/ajax-loader(1).gif" /></td></tr>');


		getRoomType();


	 });


	 





	 function getRoomType(){


		if($('#room_type').val() != 0){


			var querystr = 'actioncode=5&hotelid='+$('#hotelid').val()+'&roomtype_id='+$('#room_type').val(); 


			$.post("admin_ajax_processor.php", querystr, function(data){						 


				if(data.errorcode == 0){ 


					$('#getajaxhtml').html(data.strhtml)


				}else{


				    $('#getajaxhtml').html('<tr><td colspan="8">'+data.strmsg+'</td></tr>');


				}


				


			}, "json");


		}


		if($('#room_type').val() == 0){


			 $('#getajaxhtml').html('<tr><td colspan="8">Please Select RoomType First</td></tr>');


		 } 


	 }


	


});


</script>


<script language="javascript">


	function priceplan_delete(delid){


		var answer = confirm ("Are you sure want to delete this Priceplan?");


	if (answer)


		window.location="priceplan_list.php?delid="+delid


	}


</script>





<div class="flat_area grid_16">


  <button class="button_colour" style="float:right; padding-right:0px; margin-right:0px;" onclick="javascript:window.location.href='pricePlan.php'"><img height="24" width="24" alt="Bended Arrow Right" src="images/icons/small/white/bended_arrow_right.png"><span>Add New Price Plan</span></button>


  <h2>Hotel Price Plan <span style="margin-left:200px;">


    <?php if(isset($_SESSION['error_msg'])){ echo $_SESSION['error_msg']; }


  unset($_SESSION['error_msg']); ?>


    </span></h2>


</div>


<div class="box grid_16 round_all"> <span>


  <?php if(isset($_GET['msg'])){ echo $_GET['msg']; } ?>


  </span>


  <h2 class="box_head grad_colour round_top"> Select Hotel


    <select name="hotelid" id="hotelid" data-placeholder="Choose a hotel." class="chosen-select" style="width:250px;">


      <?=$hotel_list?>


    </select>


    <span>Select RoomType</span><span>


    <select name="room_type" id="room_type">


      <?php 


	if(isset($rlist)){?>


      <?=$rlist?>


      <?php } ?>


      <option value="">---select---</option>


      <?=$catch1[0]?>


    </select>


    </span> </h2>


  <a href="#" class="grabber">&nbsp;</a> <a href="#" class="toggle">&nbsp;</a>


  <div class="block no_padding">


    <table class="static" cellpadding="8">


      <thead>


        <tr>


          <th style="width:70px;"></th>


          <th style="width:60px;">SUN</th>


          <th style="width:60px;">MON</th>


          <th style="width:60px;">TUE</th>


          <th style="width:60px;">WED</th>


          <th style="width:60px;">THU</th>


          <th style="width:60px;">FRI</th>


          <th style="width:60px;">SAT</th>
  		
          <!--<th>Extra Bed</th>-->

          <th style="width:50px;" colspan="2"></th>


        </tr>


      </thead>


      <tbody id="getajaxhtml">


        <?php /*if(isset($catch1[1])){ ?>


        <?=$catch1[1]?>


        <?php }*/ ?>


      </tbody>


    </table>


    <br />


  </div>


</div>


</div>


<div id="loading_overlay">


  <div class="loading_message round_bottom">Loading...</div>


</div>


<div style="padding-right:8px;">


  <?php include("footer.php"); ?>

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