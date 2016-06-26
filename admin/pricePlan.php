<?php 

include("access.php");

if(isset($_POST['submit_btn'])){

    include("../includes/db.conn.php");

	include("../includes/conf.class.php");

	include("../includes/admin.class.php");

	$bsiAdminMain->UpdateAndInsertPriceplan();

	header("location: priceplan_list.php");

}else{

	unset($_SESSION['hotel_id']); 

	unset($_SESSION['roomtypeid']);

}

$pageid = 16;

include("header.php");

if(isset($_GET['rtype_id'])){

	$rtypeid=mysql_real_escape_string(base64_decode($_GET['rtype_id']));

	$defaultvalue=mysql_real_escape_string(base64_decode($_GET['default_value']));

	$hotel_id=mysql_real_escape_string(base64_decode($_GET['hid']));

	if($defaultvalue == 1){

		$startdate = mysql_real_escape_string(base64_decode($_GET['start_date']));

		$enddate   = mysql_real_escape_string(base64_decode($_GET['end_date']));

	}else{

		$startdate = mysql_real_escape_string(base64_decode($_GET['start_date']));

		$enddate   = mysql_real_escape_string(base64_decode($_GET['end_date']));

	}

	$ro_ppres    = $bsiAdminMain->getPricePlanRow($rtypeid,$defaultvalue,$startdate,$enddate);

	$hotelSql    = $bsiCore->getHotelName($hotel_id);

	$hotel_name  = $hotelSql['hotel_name'];

	$roomtypeSql = $bsiAdminMain->getRoomtype($rtypeid);

	$roomtype    = $roomtypeSql['type_name'];

	$gethtml     = $bsiAdminMain->getPriceplanEditFrm($ro_ppres);

	$_SESSION['roomtypeid'] = $rtypeid;

}

if(isset($_SESSION['hotel_id'])){

	$hotel_list=$bsiAdminMain->hotelname($_SESSION['hotel_id']);

}else{

	$hotel_list=$bsiAdminMain->hotelname(0);

}

?>
<link rel="stylesheet" href="css/chosen.css">
<script type="text/javascript" src="js/jquery.validate_pp.js"></script>

<script>

  $(document).ready(function(){

    $("#priceplan").validate();

  });

  </script>

<script type="text/javascript" src="ckeditor/ckeditor_basic.js"></script>

<script>

$(document).ready(function() {

	 $('#subbtn').hide();

	 $('#hotelid').change(function() { 

		gethotel();

	 });

	 

	 if($('#hotelid').val() > 0){

		gethotel(); 

	 }

	 

	 function gethotel(){

		if($('#hotelid').val() != 0){

			var querystr = 'actioncode=1&hotelid='+$('#hotelid').val(); 

			$.post("admin_ajax_processor.php", querystr, function(data){						 

				if(data.errorcode == 0){

					$('#room_type').html(data.roomtype_dowpdown);

				}else{

				    $('#room_type').html(data.strmsg);

				}	

			}, "json");

		} else{

			$('#room_type').html('<option value="0">Select Room Type</option>');  

			$('#getajaxhtml').html("");

			$('#subbtn').hide();

		}

	 }

	 //Room type Events

	 

	  $('#room_type').change(function(){

		 getRoomtype();

	 });

	 

	 if($('#room_type').val() > 0){

		 getRoomtype();

	 }

	 

	 function getRoomtype(){

		if($('#room_type').val() != 0){

			 var querystr = 'actioncode=2&hotelid='+$('#hotelid').val()+'&roomtypeId='+$('#room_type').val();

			 //alert(querystr);

			 $.post("admin_ajax_processor.php", querystr, function(data){

				 if(data.errorcode == 0){

					$('#getajaxhtml').html(data.priceFrm)

					$('#subbtn').show();

				}else{

				    $('#getajaxhtml').html('<td colspan="8">'+data.strmsg+'</td>');

					$('#subbtn').hide();

				}

			 }, "json");

		 }

		 if($('#room_type').val() == 0){

			 $('#getajaxhtml').html("");

			 $('#subbtn').hide();

		 } 

	 }

});

$(document).ready(function(){

 	$.datepicker.setDefaults({ dateFormat: '<?=$bsiCore->config['conf_dateformat']?>' });

    $("#txtFromDate").datepicker({

        minDate: 0,

        maxDate: "+365D",

        numberOfMonths: 2,

        onSelect: function(selected) {

		  var date = $(this).datepicker('getDate');

      	  if(date){

              date.setDate(date.getDate() + <?=$bsiCore->config['conf_min_night_booking']?>);

          }

          $("#txtToDate").datepicker("option","minDate", date)

        }

    });

    $("#txtToDate").datepicker({ 

        minDate: 0,

        maxDate:"+365D",

        numberOfMonths: 2,

        onSelect: function(selected) {

           $("#txtFromDate").datepicker("option","maxDate", selected)

        }

    });

 

 $("#txtFromDate").datepicker();

 $("#datepickerImage").click(function() { 

  $("#txtFromDate").datepicker("show");

 });

 

 $("#txtToDate").datepicker();

 $("#datepickerImage1").click(function() { 

  $("#txtToDate").datepicker("show");

 });    

});

function checkRoomtype(){

	var roomtype=document.forms["priceplan"]["room_type"].value;

	if(roomtype != 0){

		 return true;

		}else{

			alert("Please Select Room Type");

	        return false;

		}

}

</script>

<div class="flat_area grid_16">

  <button class="button_colour round_all" onclick="window.location.href='<?=$_SERVER['HTTP_REFERER']?>'" style="float:right;"><img height="24" width="24" alt="Bended Arrow Right" src="images/icons/small/white/bended_arrow_right.png"><span>Back</span></button>

  <h2>Add / Edit Priceplan</h2>

</div>

<form name="priceplan" id="priceplan" method="post" action="<?=$_SERVER['PHP_SELF']?>" onsubmit="return checkRoomtype();">

  <div class="box grid_16 round_all">

    <h2 class="box_head grad_colour round_top">&nbsp; </h2>

    <a href="#" class="grabber">&nbsp;</a> <a href="#" class="toggle">&nbsp;</a>

    <div class="block no_padding">

      <table cellpadding="4" cellspacing="0" width="100%">

        <tr>

          <td colspan="2">&nbsp;</td>

        </tr>

        <?php

			 if(isset($_GET['rtype_id'])){

				 echo '<input type="hidden" name="hotelid" value="'.$hotel_id.'">';

				 echo '<input type="hidden" name="room_type" value="'.$rtypeid.'">';

				 echo '<input type="hidden" name="default1" value="'.$defaultvalue.'">';

				echo '<tr><td width="100px">Hotel Name</td><td>'.$hotel_name ."</td></tr><tr><td>Roomtype</td><td>".$roomtype."</td></tr>";

			 }else{ 

		 ?>

        <tr>

          <td width="100px">Select Hotel</td>

          <td><select name="hotelid" id="hotelid" data-placeholder="Choose a hotel." class="chosen-select" style="width:250px;" >

              <?=$hotel_list?>

            </select></td>

        </tr>

        <tr>

          <td>Select Roomtype</td>

          <td><select name="room_type" id="room_type">

              <option value="0">Select Room Type</option>

            </select></td>

        </tr>

        <?php }

			if(isset($_REQUEST['start_date']) && base64_decode($_REQUEST['start_date']) == '0000-00-00'){

				echo '<input type="hidden" name="startdate" value="00-00-0000"><input type="hidden" name="enddate" value="00-00-0000">';

			}else if(isset($_REQUEST['start_date']) && base64_decode($_REQUEST['start_date']) != '0000-00-00'){

				

				$rrrse=mysql_query($ro_ppres);

				$i=1;

					while($ro_pp=mysql_fetch_assoc($rrrse)){

					if($i == 1){

		?>

         <tr>

          <td>Start Date</td>

          <td><table><tr><td><input type="text"  name="startdate" id="txtFromDate" style="width:70px; margin-right:0px;" class="required" value="<?=$ro_pp['startdate']?>"/></td><td>&nbsp;<a id="datepickerImage" href="javascript:;"><img src="../img/month.png" width="18px" height="18px"/></a></td></tr></table></td>

        </tr>

        <tr>

          <td>End Date</td>

          <td><table><tr><td><input type="text"  name="enddate" id="txtToDate" style="width:70px; margin-right:0px;" class="required" value="<?=$ro_pp['enddate']?>"/></td><td>&nbsp;<a id="datepickerImage1" href="javascript:;"><img src="../img/month.png" width="18px" height="18px"/></a></td></tr></table></td>

        </tr>

        <?php	

					}

					$i++;

				 

				}

			}else{

		 ?>

        <tr>

          <td>Start Date</td>

          <td><table><tr><td><input type="text" readonly name="startdate" id="txtFromDate" style="width:70px; margin-right:0px;" class="required"/></td><td>&nbsp;<a id="datepickerImage" href="javascript:;"><img src="../img/month.png" width="18px" height="18px"/></a></td></tr></table></td>

        </tr>

        <tr>

          <td>End Date</td>

          <td><table><tr><td><input type="text" readonly name="enddate" id="txtToDate" style="width:70px; margin-right:0px;" class="required"/></td><td>&nbsp;<a id="datepickerImage1" href="javascript:;"><img src="../img/month.png" width="18px" height="18px"/></a></td></tr></table></td>

        </tr>

        <?php } ?>

      </table>

      <br />

      <table  cellpadding="0" border="0" class="static" >

        <thead>

          <tr>

            <th width="100px">&nbsp;</th>

            <th>Sun</th>

            <th>Mon</th>

            <th>Tui</th>

            <th>Wed</th>

            <th>Thu</th>

            <th>Fri</th>

            <th>Sat</th>
            
            <!-- <th>Extra Bed</th>-->

          </tr>

        </thead>

        <tbody id="getajaxhtml">

          <?php

			if(isset($gethtml))

				echo $gethtml;

		?>

        </tbody>

      </table>

      <?php

		 if(isset($_GET['rtype_id'])){

	   ?>

       <table width="100%">

        <tr>

          <td width="108px">&nbsp;</td>

          <td><input type="hidden" name="submit_btn" value="1" />

            <button class="button_colour round_all"><img height="24" width="24" alt="Bended Arrow Right" src="images/icons/small/white/bended_arrow_right.png"><span>Submit</span></button></td>

        </tr>

      </table>

       <?php

		 }else{ 

		?>

      <table width="100%">

        <tr>

          <td width="108px">&nbsp;</td>

          <td id="subbtn"><input type="hidden" name="submit_btn" value="1" />

            <button class="button_colour round_all"><img height="24" width="24" alt="Bended Arrow Right" src="images/icons/small/white/bended_arrow_right.png"><span>Submit</span></button></td>

        </tr>

      </table>

      <?php

		 } 

		?>

    </div>

  </div>

</form>

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