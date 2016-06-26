<?php

include ("access.php");

if((isset($_GET['action'])) && ($_GET['action'] == "unblock")){

	include("../includes/db.conn.php");

	include("../includes/conf.class.php");

	

	$booking_id  = $bsiCore->ClearInput($_GET['bid']);

	$roomtype_id = $bsiCore->ClearInput($_GET['rti']);

	$capacity_id = $bsiCore->ClearInput($_GET['cid']);

	$hotel_id    = $bsiCore->ClearInput($_GET['hid']);

	

	$result      = mysql_query("SELECT count(*) from bsi_reservation br, bsi_bookings bb, bsi_roomtype brt where br.booking_id='".$booking_id."' and bb.is_block=1 and br.roomtype_id=brt.roomtype_id group by br.roomtype_id");

	$num=mysql_num_rows($result);

	if($num <= 1){

		mysql_query("delete from bsi_reservation where booking_id='".$booking_id."' and roomtype_id='".$roomtype_id."'");

		mysql_query("delete from bsi_bookings where booking_id='".$booking_id."'");

	}else{

		mysql_query("delete from bsi_reservation where booking_id='".$booking_id."' and roomtype_id='".$roomtype_id."'"); 	

	}
	
	$_SESSION['hotel_id'] = $hotel_id;
	$_SESSION['show'] = true;
	
	header("location:admin_block_room.php");
	exit;
}



$pageid = 41;

//echo "aaaa";die;

include ("header.php");

if(isset($_SESSION['show'])){

	$show = $_SESSION['show'];

}else{

	$show = false;

}



$hotel_id = 0;



if(isset($_SESSION['hotel_id'])){

	$hotel_id = $_SESSION['hotel_id'];	

}else{

   $hotel_id = 0;	

}



if(isset($_POST['submit'])){

	include('../includes/search.class.php');

	$bsisearch = new bsiSearch();

	$bsiCore->clearExpiredBookings();

	$hotel_id = $_POST['hotelid'];

	$show = true;

}

?>

<link rel="stylesheet" type="text/css" href="../css/datepick.css" />

<style type="text/css">

body {

	font-size:8pt;

	font-family:Verdana;

	padding: 5px;

}

</style>
<link rel="stylesheet" href="css/chosen.css">
<script type="text/javascript">

$(document).ready(function() {

	 $('#hotelid').change(function() { 

			var querystr = 'actioncode=24&hotelid='+$('#hotelid').val(); 

			$.post("admin_ajax_processor.php", querystr, function(data){						 

				if(data.errorcode == 0){

					  $('#blockroom').html(data.block);

				}else{

				      $('#blockroom').html(data.block);

				}

			}, "json");	

    });

	

	$('#button').click(function(){

		if($('#hotelid').val() == 0){ 

			alert("Please Select Hotel Name");

			return false;

		}

		if($('#txtFromDate').val() == ""){ 

			alert("Please Select Checkin Date");

			return false;

		}

		if($('#txtToDate').val() == ""){ 

			alert("Please Select Checkout Date");

			return false;

		}

		if($('#capacity_id').val() == 0){ 

			alert("Please Select Capacity");

			return false;

		}

	});

});

</script>



<script type="text/javascript">

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

 $("#datepickerImage").click(function() { 

    $("#txtFromDate").datepicker("show");

  });

 $("#datepickerImage1").click(function() { 

    $("#txtToDate").datepicker("show");

  });

});

</script>



<div class="flat_area grid_16">

  <h2>Room Avaiblity & Block Room</h2>

</div>

<div class="box grid_16 round_all">

  <h2 class="box_head grad_colour round_top">&nbsp;&nbsp;</h2>

  <a href="#" class="grabber">&nbsp;</a> <a href="#" class="toggle">&nbsp;</a>

  <div class="block no_padding">

    <table class="bodytext" width="100%">

      <tr>

        <td width="50%"><!-- AAAAAA-->

          

          <form action="<?=$_SERVER['PHP_SELF']?>" method="post" name="admin_blockroom" id="admin_blockroom">

            <table  border="0" cellspacing="0" cellpadding="5">

              <tr><td class="TitleBlue11pt" nowrap="nowrap">&nbsp;Select Hotel a</td><td colspan="3"><select name="hotelid" id="hotelid" data-placeholder="Choose a hotel." class="chosen-select" style="width:250px;"><?=$bsiAdminMain->hotelname($hotel_id)?></select></td></tr>

              <tr>

                <td class="TitleBlue11pt" nowrap="nowrap">Checkin Date:</td>

                <td><table>

                    <tr>

                      <td><input name="check_in" id="txtFromDate" readonly class="required" size="10"></td>

                      <td style="padding-left:5px;"><a id="datepickerImage" href="javascript:;"><img src="../img/month.png" height="18px" width="18px" /></a></td>

                    </tr>

                  </table></td>

                <td class="TitleBlue11pt" nowrap="nowrap">Checkout Date:</td>

                <td><table>

                    <tr>

                      <td><input name="check_out" id="txtToDate" class="required"  readonly="readonly" size="10"></td>

                      <td style="padding-left:5px;"><a id="datepickerImage1" href="javascript:;"><img src="../img/month.png" height="18px" width="18px" /></a></td>

                    </tr>

                  </table></td>

              </tr><input type="hidden" name="capacity" value="1" />

              <!--<tr>

                <td class="TitleBlue11pt" nowrap="nowrap">Capacity:</td>

                <td id="caphtml" colspan="3"><font color="#9B0000">Please Select Hotel First !</font></td>

              </tr>-->

              <tr>

                <td>&nbsp;</td>

                <td><button name="submit" type="submit" id="button" class="button_colour round_all"><img height="24" width="24" alt="Bended Arrow Right" src="images/icons/small/white/bended_arrow_right.png"><span>Search</span></button></td>

              </tr>

            </table>

          </form>

          <br />

          <?php if(isset($_POST['submit'])){ ?>

          <form name="adminsearchresult" id="adminsearchresult" method="post" action="roomblocking.class.php" >

            <input type="hidden" name="allowlang" id="allowlang" value="no" />

            <table cellpadding="4" cellspacing="0" border="2" style="font-family:Arial, Helvetica, sans-serif; font-size:12px;" width="450px">

              <tr>

                <th align="left" colspan="2"><b>Search Result (

                  <?=$_POST['check_in']?>

                  to

                  <?=$_POST['check_out']?>

                  ) =

                  <?=$bsisearch->nightCount?>

                  Night(s)</b></th>

              </tr>

              <tr>

                <th align="left" width="250px">Roomtype</th>

                <th align="left">Availablity</th>

              </tr>

              <?php

	 	$gotSearchResult = false;

		$idgenrator = 0;

		foreach($bsisearch->roomType as $room_type){

			foreach($bsisearch->multiCapacity as $capid=>$capvalues){			

				$room_result = $bsisearch->getAvailableRooms($room_type['rtid'], $room_type['rtname'], $capid, $_POST['hotelid']);

				if(intval($room_result['roomcnt']) > 0) {

					$gotSearchResult = true;	

			 ?>

              <tr>

                <td><?=$room_type['rtname']?>

                  (

                  <?=$capvalues['captitle']?>

                  )</td>

                <td><?=$room_result['roomdropdown']?></td>

              </tr>

              <?php 

		$idgenrator++;

	} } } ?>

              <tr>

                <td><?php if($gotSearchResult == false){ echo $room_result['roomdropdown']; }else { echo '&nbsp;'; } ?></td>

                <td><button name="submit" type="submit" class="button_colour round_all"><img height="24" width="24" alt="Bended Arrow Right" src="images/icons/small/white/bended_arrow_right.png"><span>Block</span></button></td>

              </tr>

            </table>

          </form>

          <?php } ?></td>

        <td valign="top" width="50%" id="blockroom"><br />

        	<?php if($show == true){?>

            <table cellpadding="4" cellspacing="0" border="2" width="400px" style="font-family:Arial, Helvetica, sans-serif; font-size:12px;">

            <tr>

              <th colspan="4" style="font-family:Arial, Helvetica, sans-serif; font-size:17px; font-weight:bold;" align="center">Room Block List</th>

            </tr>

            <tr>

              <th width="100px" nowrap="nowrap">Date Range</th>

              <th width="120px" nowrap="nowrap">Roomtype</th>

              <th  width="58px" nowrap="nowrap">Total Room</th>

              <th width="50px;" nowrap="nowrap">Action</th>

            </tr>

            <?=$getHtml=$bsiAdminMain->getBlockRoomDetails($hotel_id)?>

          </table>

          <?php } ?>

        </td>

      </tr>

    </table>

  </div>

</div>

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