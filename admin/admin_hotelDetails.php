<?php
	include("access.php");
	$pageid = 27; 
	if(!isset($_REQUEST['hotel_id']) || $_REQUEST['hotel_id'] == ""){
		header("location:admin_room_block.php");
		exit;	
	}
	include("header.php");
	include("../includes/hotel-details.class.php"); 
	$bsiHotelDetails = new bsiHotelDetails();
	$availabilityByRoomTypeFinal = $_SESSION['availabilityByRoomTypeFinal'];
	$hotel_id = base64_decode($_GET['hotel_id']);
	$_SESSION['hotel_id'] = $hotel_id;
?>
<script type="text/javascript">
$(document).ready(function(){
    $('#changeSelect').click(function() { 
            document.location='admin_room_block.php';
    }); 
});
$(document).ready(function(){
	
	$("#booknow1").click(function(){
		ValidateForm(id);
	});
});
</script>
<script type="text/javascript">
	function ValidateForm(id){ 
		
		var val = document.getElementById(id).value;
		//alert(val);
		if(val != 0){
			document.getElementById("booknow1").disabled = false;
			return true;
		}
	}
</script>
<script type="text/javascript">
function bookRoom(){ 
 window.location="admin_bookingProcess.php?roomtype=1";
}
</script>
<div class="flat_area grid_16">
  <h2>&nbsp;</h2>
</div>
<div class="box grid_16 round_all">
  <h2 class="box_head grad_colour round_top">&nbsp;</h2>
  <a href="#" class="grabber">&nbsp;</a> <a href="#" class="toggle">&nbsp;</a>
  <div class="block no_padding">
    <table width="100%">
      <tr>
        <td colspan="2">&nbsp;</td>
      </tr>
      <tr>
        <td width="20%" valign="top"><table cellpadding="5" width="100%" border="0">
            <tr>
              <th style="padding-left:8px;" width="80px" align="left">Destination</th>
              <td style="text-align:left; padding-left:7px;"><?=$_SESSION['sv_destination']?></td>
            </tr>
            <tr>
              <th style="padding-left:8px;" align="left">Check In Date</th>
              <td style="text-align:left; padding-left:7px;"><?=$_SESSION['sv_checkindate']?></td>
            </tr>
            <tr>
              <th nowrap="nowrap" style="padding-left:8px;" align="left">Check Out Date</th>
              <td style="text-align:left; padding-left:7px;"><?=$_SESSION['sv_checkoutdate']?></td>
            </tr>
            <tr>
              <th style="padding-left:8px;" align="left">Total Nights</th>
              <td style="text-align:left; padding-left:7px;"><?=$_SESSION['sv_nightcount']?></td>
            </tr>
            <tr>
              <td colspan="2"><table width="200px" style="padding:2px 0 0 3px; border:solid 1px #801f31;">
                  <?php 
                            $getHtml      = "";
                            $roomAdultarr = array();
                            $roomAdultarr = explode('#', $_SESSION['adultperrrom']);
                            foreach($roomAdultarr as $room => $adult){
                                $getHtml  .= '<tr>
                                                <th width="28px" style="padding-left:2px;">Rooms </th>
                                                <td width="5px">'.($room+1).'</td>
                                                <td width="3px">:</td>
                                                <td width="5px">'.$adult.'</td>
                                                <th width="35px">Adults</th>
                                             </tr>';
                            }
                            echo $getHtml;
                        ?>
                </table></td>
            </tr>
            <tr>
              <td colspan="2" style="text-align:right; padding:30px 0 0 5px;"><button class="button_colour" id="changeSelect"><img width="24" height="24" src="images/icons/small/white/bended_arrow_right.png" alt="Bended Arrow Right"/><span>Change Selection</span></button></td>
            </tr>
          </table></td>
        <!-- Hotel Listing -->
        <td valign="top"><!-- ***************************************Hotel Listing*****************************************-->
          
          <table border="1" width="100%" cellpadding="4">
            <tr style="background-color:#ffcaca;">
              <td width="" style="padding:7px 0 7px 10px; vertical-align:central; color:#000;"><b>Recommended for your group</b></td>
            </tr>
            <tr>
              <td style="padding-left:10px;" width=""><table width="100%" cellpadding="5" cellspacing="5" border="1">
                  <thead>
                    <tr>
                      <th bgcolor="#CCCCCC" nowrap="nowrap" align="left">Available room types</th>
                      <th bgcolor="#CCCCCC" align="center">Max Occupency</th>
                      <th bgcolor="#CCCCCC" align="right">Rate</th>
                    </tr>
                    <tr style="background-color:#9C6 !important;">
                      <th colspan="3" style="background-color:#FFCACA !important" align="left"><?=$_SESSION['sv_rooms']?>
                        Rooms,
                        <?=$_SESSION['sv_adults']?>
                        Adults,
                        <?=$_SESSION['sv_nightcount']?>
                        Nights</th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php
						$recommended = array();
						$recommended = $_SESSION['recommendedRoomtype'];
						echo $recommended[$hotel_id]['recommendedRoomtype']  
					  ?>
                    <tr>
                      <td colspan="3"><table width="100%" cellpadding="5">
                          <tr>
                            <td width="80%" align="right">&nbsp;</td>
                            <td align="right"><button class="button_colour" id="booknow" onclick="javascript:return bookRoom();" ><img width="24" height="24" src="images/icons/small/white/bended_arrow_right.png" alt="Bended Arrow Right"/><span>Book Now</span></button></td>
                          </tr>
                        </table></td>
                    </tr>
                  </tbody>
                </table>
                <br>
                <br></td>
            </tr>
          </table>
          <br>
          <br>
          <form action="admin_bookingProcess.php" method="post" name="myos">
            <table border="1" width="100%" cellpadding="4">
              <tr style="background-color:#ffcaca;">
                <td width="" style="padding:7px 0 7px 10px; vertical-align:central; color:#000;"><b>Or, make your own selection</b></td>
              </tr>
              <tr>
                <td style="padding-left:10px;" width=""><table width="100%" cellpadding="5" cellspacing="5" border="1">
                    <thead>
                      <tr>
                        <th bgcolor="#CCCCCC" nowrap="nowrap" align="left">Available room types</th>
                        <th bgcolor="#CCCCCC" align="center">Max Occupency</th>
                        <th bgcolor="#CCCCCC" align="center">Rate</th>
                        <th bgcolor="#CCCCCC" align="center">No. rooms</th>
                      </tr>
                    </thead>
                    <tbody>
                      <?php
						
						$j=1;
						foreach($availabilityByRoomTypeFinal[$hotel_id] as $i => $availabilityRow){
							if($j==1)
							$dashed='';
							else
							$dashed='class="dashed2"';
							
							$roomTypeRes=$bsiHotelDetails->roomTypeDetails($i);
							$rowRoomType=mysql_fetch_assoc($roomTypeRes);
							
							$totalRow = count($availabilityRow);
							$html="";
							foreach($availabilityRow as $k => $val){
									if($totalRow > 1){
											if($k==0){
												$html.='<tr '.$dashed.'>
														<td class="w14 " rowspan="'.$totalRow.'"><b class="big">'.$rowRoomType['type_name'].'</b></td>
														<td class="w14 tl">'.$val['capacityTitle'].'&nbsp;('.$val['adultPerRoom'].') </td>
														<td class="w15 ">'.$bsiCore->config['conf_currency_symbol'].number_format($val['totalPrice'],2).' </td>
														<td align="center">'.$bsiHotelDetails->roomDropDownGen(count(explode('#',$val['totalRoomAvailableId'])),$i,$k,$val['totalPrice']).' </td> 
													</tr>';
											}else{
												$html.='<tr>
														<td class="w14 tl">'.$val['capacityTitle'].'&nbsp;('.$val['adultPerRoom'].') </td>
														<td class="w15 ">'.$bsiCore->config['conf_currency_symbol'].number_format($val['totalPrice'],2).' </td>
														<td align="center">'.$bsiHotelDetails->roomDropDownGen(count(explode('#',$val['totalRoomAvailableId'])),$i,$k,$val['totalPrice']).' </td>
													</tr>';
											}
								
									}else{
								   $html.='<tr '.$dashed.'>
													<td class="w14 "><b class="big">'.$rowRoomType['type_name'].'</b></td>
													<td class="w14 tl">'.$val['capacityTitle'].'&nbsp;('.$val['adultPerRoom'].') </td>
													<td class="w15 ">'.$bsiCore->config['conf_currency_symbol'].number_format($val['totalPrice'],2).' </td>
													<td align="center">'.$bsiHotelDetails->roomDropDownGen(count(explode('#',$val['totalRoomAvailableId'])),$i,$k,$val['totalPrice']).' </td>
												</tr>';
									}
							  
							   } 
						   echo $html;
						   $j++;
						} 
						   ?>
                    <input type="hidden" name="roomtype" value="2" />
                    <tr>
                      <td colspan="4"><table width="100%" cellpadding="5">
                          <tr>
                            <td width="80%" align="right"><div style="color:#FFF; background-color:#F00; width:450px; text-align:center; float:left; font-style:!important;">
                                <?php if(isset($_SESSION['selectErr'])){ echo $_SESSION['selectErr'];
				  unset($_SESSION['selectErr']); } ?>
                              </div></td>
                            <td><button class="button_colour" id="booknow1"><img width="24" height="24" src="images/icons/small/white/bended_arrow_right.png" alt="Bended Arrow Right"/><span>Book Now</span></button></td>
                          </tr>
                        </table></td>
                    </tr>
                      </tbody>
                    
                  </table>
                  <br>
                  <br></td>
              </tr>
            </table>
          </form></td>
      </tr>
    </table>
  </div>
</div>
</div>
<div id="loading_overlay">
  <div class="loading_message round_bottom">Loading...</div>
</div>
<div style="padding-right:8px;">
  <?php include("footer.php"); ?>
</div>
</body></html>