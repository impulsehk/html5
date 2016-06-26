<?php
include ("access.php");
$pageid = 42;
include ("header.php");

$monthNames = Array("January" => 1, "February" => 2, "March" => 3, "April" => 4, "May" => 5, "June" => 6, "July" => 7, "August" => 8, "September" => 9, "October" => 10, "November" => 11, "December" => 12);

if (!isset($_REQUEST["year"])) $_REQUEST["year"] = 2012;

$time = time();
$current_month = date("n", $time);
$current_year = date("Y", $time);

$cMonth     = 1;
$cYear      = $_REQUEST["year"];

$prev_year  = $cYear;
$next_year  = $cYear;
$prev_month = $cMonth-1;
$next_month = $cMonth+1;
 
if ($prev_month == 0 ) {
    $prev_month = 12;
    $prev_year = $cYear - 1;
}
if ($next_month == 13 ) {
    $next_month = 1;
    $next_year = $cYear + 1;
}
if(isset($_REQUEST['hotelid'])){
	$hotelid = $_REQUEST['hotelid'];	
}else{
	$hotelid = 0;
}
$buttonhtml='<input type="submit" name="submit" id="submit" value="Submit" style="vertical-align:middle;"/>';
?>
<link rel="stylesheet" href="css/chosen.css">
<script type="text/javascript" charset="utf-8">
	$(document).ready(function() {
		
		$('#hotelid').change(function(){
			window.location = 'calendar_view.php?hotelid='+$('#hotelid').val();
		});
		
		$('#year').change(function(){
			window.location = 'calendar_view.php?hotelid='+$('#hotelid').val()+'&year='+$('#year').val();
		});	
		$('#submit').hide();
		$('#roomtype').change(function(){
			if($('#roomtype').val() != 0){ 
				$('#submit').show();
			}else{
				$('#submit').hide();
				window.location='calendar_view.php';
			}
		});
		
		$('#refresh').click(function(){
			window.location = 'calendar_view.php';
		});
	});
</script>

<div class="flat_area grid_16">
<button class="button_colour round_all" type="button" name="refresh" id="refresh" style="float:right;"><img height="24" width="24" alt="Bended Arrow Right" src="images/icons/small/white/bended_arrow_right.png"><span>Refresh</span></button>
  <h2>Calendar View Availability</h2>
</div>
<form action="<?=$_SERVER['PHP_SELF']?>" method="post">
<div class="box grid_16 round_all">
  <h2 class="box_head grad_colour round_top"><select name="hotelid" id="hotelid" data-placeholder="Choose a hotel." class="chosen-select" style="width:250px;"><?=$bsiAdminMain->hotelname($hotelid)?></select> <?php if(isset($_REQUEST['hotelid'])){?>&nbsp; <?=$bsiAdminMain->getYearcombo($cYear)?> &nbsp; <?php if(isset($_POST['submit'])){ echo $bsiAdminMain->getRoomtypeCal($_POST['hotelid'], $_POST['roomtype']); }else{ echo $bsiAdminMain->getRoomtypeCal($hotelid); }?><?=$buttonhtml?><?php }?></h2>
  <a href="#" class="grabber">&nbsp;</a><a href="#" class="toggle">&nbsp;</a> 
  <div class="block no_padding"> 
    <!-- Body Part-->
    <?php if(isset($_REQUEST['hotelid'])){?>
    <table width="100%">
      <tr>
      	<td align="center" valign="top">
        	<table width="100%" cellpadding="2" border="0"> 
            <?php
				echo '<tr><td height="33px" style="text-decoration:underline; font-size:14px;" valign="middle"><b>Month</b></td></tr>';
				foreach($monthNames as $key => $month){ 
					if($current_month == $month && $current_year == $cYear){
						echo '<tr style="background-color:#ffdf80;"><td height="30px"><b>'.$key.'</b></td></tr>';
					}else{
						if($month % 2 == 0){
							echo '<tr style="background-color:#F2F2F2;"><td height="30px"><b>'.$key.'</b></td></tr>';
						}else{
							echo '<tr style="background-color:#FFFFFF;"><td height="30px"><b>'.$key.'</b></td></tr>';
						}
					}
				}
			?>
            </table>
        </td>
        <td align="center" width="90%" valign="top"><table width="100%" border="0" cellpadding="3" cellspacing="2">
        <?php
			echo "<tr height='33px'>";
			echo $bsiAdminMain->getdaysName();
			echo "</tr>"; 
			foreach($monthNames as $key => $month){ 
				$timestamp = mktime(0, 0, 0, $month, 1, $cYear);
			    $maxday    = date("t",$timestamp);
				 $thismonth = getdate ($timestamp);
				$startday  = $thismonth['wday'];
				$no_of_td  = $maxday+$startday;
				//YYYY-MM-DD date format
				$date_form = "$cYear/$month/";
				
				if(isset($_POST['submit'])){
					$sql = 'and roomtype_id='.$_POST['roomtype'];
				}else{
					$sql = '';
				}
				$row = mysql_fetch_assoc(mysql_query("SELECT count(*) AS no_of_room FROM `bsi_room` where hotel_id=".$hotelid." ".$sql));
				$no_of_room = $row['no_of_room'];
				
				if($current_month == $month && $current_year == $cYear){
					$trColor = 'background-color:#ffdf80;';
				}else{
					if($month % 2 == 0){
						$trColor = 'background-color:#F2F2F2;';
					}else{
						$trColor = 'background-color:#FFFFFF;';
					}
				}
				
				echo '<tr style="font-size:8px; '.$trColor.'">';
				for ($i=0; $i<($maxday+$startday); $i++) {
				   if(isset($_POST['submit'])){					   
					   $result = mysql_query("SELECT count(br.roomtype_id) as counter FROM bsi_bookings as bb, bsi_reservation as br, bsi_room as bro, bsi_roomtype as brt, bsi_capacity as bc WHERE bb.booking_id = br.booking_id and bro.room_id = br.room_id and bro.roomtype_id = brt.roomtype_id and bro.capacity_id = bc.capacity_id and '".$date_form.($i - $startday + 1)."' between bb.checkin_date and DATE_SUB(bb.checkout_date, INTERVAL 1 DAY) and bb.hotel_id=".$_POST['hotelid']." and br.roomtype_id=".$_POST['roomtype']);
				   }else{
					   $result = mysql_query("SELECT count(br.roomtype_id) as counter FROM bsi_bookings as bb, bsi_reservation as br, bsi_room as bro, bsi_roomtype as brt, bsi_capacity as bc WHERE bb.booking_id = br.booking_id and bro.room_id = br.room_id and bro.roomtype_id = brt.roomtype_id and bro.capacity_id = bc.capacity_id and '".$date_form.($i - $startday + 1)."' between bb.checkin_date and DATE_SUB(bb.checkout_date, INTERVAL 1 DAY) and bb.hotel_id=".$hotelid);
				   }
								   					
					if($i < $startday){ 
						echo "<td></td>"; 
					}else{
						if(mysql_num_rows($result)){
							$rowcount = mysql_fetch_assoc($result);
							$noOfRoom = $no_of_room - $rowcount['counter'];
						}else{
							$noOfRoom = $no_of_room;
						}
						
						if($noOfRoom){
							$color = '#bffcc1';
						}else{
							$color = '#f3747f';
						}
						
						if($i == 0 || $i == 6 || $i == 7 || $i == 13 || $i == 14 || $i == 20 || $i == 21 || $i == 27 || $i == 28 || $i == 34 || $i == 35){
							echo "<td align='center' bgcolor='#ffbc5b' style='color:#040404;' valign='middle' height='30px'>".($i - $startday + 1)."<br/><div style='background-color:".$color."; font-size:11px; font-weight:bold;'>".$noOfRoom. "</div></td>";
						}else{
							echo "<td align='center' valign='middle' height='30px'>". ($i - $startday + 1) ."<br/><div style='background-color:".$color."; font-size:11px; font-weight:bold;'>".$noOfRoom. "</div></td>";
						}
					}
				}
				for($td=$no_of_td; $td<38; $td++){
					echo "<td></td>"; 
				}
				 echo "</tr>";
			}
		 ?> 
         	  <tr><td colspan="37"></td></tr>
         	  <tr><td colspan="37"><div style="display:none; float:right;" id="submitButton"><button class="button_colour round_all" type="submit" name="submit" id="submit"><img height="24" width="24" alt="Bended Arrow Right" src="images/icons/small/white/bended_arrow_right.png"><span>Submit</span></button></div></td></tr>
          </table></td>
      </tr>
    </table>
    <table cellpadding="3" cellspacing="0" width="100%">
    	<tr><td colspan="3"><b>Legend:</b></td></tr>
        <tr><td width="20px" height="22px"><div style="background-color:#bffcc1">&nbsp;</div></td><td>All Available</td><td></td></tr>
        <tr><td width="20px" height="22px"><div style="background-color:#f3747f">&nbsp;</div></td><td>Not Available</td><td valign="baseline" align="right"></td></tr>
    </table>
    <?php }else{
				echo "<b>Please Select Hotel First</b>";
		   }
	?>
  </div>
</div>
</form>
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