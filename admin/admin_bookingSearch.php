<?php
	include("access.php");
	$pageid = 27; 
	if(!isset($_POST['search_available'])){
		header("location:admin_room_block.php");
		exit;
	}
	include("header.php");
	include("../includes/hotel-search.class.php");
	$bsiHotelSearch = new bsiHotelSearch();
	$bsiCore->clearExpiredBookings();
	$recommended     = array();
	$recommendedHtml = array();
	$html="";
	if(isset($_SESSION['adult'])){
		unset($_SESSION['adult']);
		$_SESSION['adult'] = $_POST['adults'];
	}else{
		$_SESSION['adult'] = $_POST['adults'];
	}
	if(!isset($_SESSION['adultperrrom'])){
		unset($_SESSION['adultperrrom']);
		$_SESSION['adultperrrom'] = '1';
	}
	$array_cnt_room=array_count_values(explode('#',$_SESSION['adultperrrom']));
	$adultperrrom=array_unique(explode('#',$_SESSION['adultperrrom']));
	$sqlSDB=$bsiHotelSearch->hotelFilterByDestination();
	$totalhotelbydestination=mysql_num_rows($sqlSDB);
	$totalhotelbyavailable=0;
	while($rowSDB=mysql_fetch_assoc($sqlSDB)){
		$totalAvailabilityOfHotel=array();
		$totalRoomType=array();
		foreach($adultperrrom as $i => $capacityQty2){
			$total_capacity[$capacityQty2]=0;
		}
			
		$sqlRoomType=$bsiHotelSearch->hotelGetRoomType($rowSDB['hotel_id']);
		while($rowRoomType=mysql_fetch_assoc($sqlRoomType)){
				
				foreach($adultperrrom as $i => $capacityQty){
										
					$sqlCapacity=$bsiHotelSearch->hotelGetCapacity($rowSDB['hotel_id'], $capacityQty);
					while($rowCapacity=mysql_fetch_assoc($sqlCapacity)){
						$searchcorefunc=$bsiHotelSearch->getAvailableRooms($rowRoomType['roomtype_id'], $rowRoomType['type_name'], $rowCapacity['capacity_id'], $rowSDB['hotel_id'], $capacityQty, $rowCapacity['title'], $rowCapacity['capacity']);
						$total_capacity[$capacityQty]+=$searchcorefunc['availableNumberOfRoom'];
						
						if($searchcorefunc['availableNumberOfRoom'] !=0){
							array_push($totalAvailabilityOfHotel,$searchcorefunc['totalAvailability']);
							array_push($totalRoomType,$rowRoomType['roomtype_id']);
						}
					}
				}
			}
			$flag=1;
			foreach($total_capacity as $i => $capacityQty3){
				if($capacityQty3 < $array_cnt_room[$i])
				$flag=0;
			}	
		if($flag){
			
			$recommendedPrice = ""; 
			$totalhotelbyavailable++;
			$totalAvailabilityOfHotelFinal[$rowSDB['hotel_id']] = $totalAvailabilityOfHotel;
			$availabilityByRoomTypeFinal[$rowSDB['hotel_id']] = $bsiHotelSearch->availabilityByRoomType($totalAvailabilityOfHotel, array_unique($totalRoomType));
			
			$totalsumrecommendedprice = 0;
			$i = 0;
			foreach($array_cnt_room as $capacity2 => $noofroom2){
				$mainarrayretrun2 = $bsiCore->recommendedBookingList($totalAvailabilityOfHotel, $noofroom2, $capacity2, $rowSDB['hotel_id']);
				$recommendedPrice.=	$mainarrayretrun2['recommendedPrice_Admin'];	
				$totalsumrecommendedprice += $mainarrayretrun2['price_sub'];
				$recommended[$i] = $mainarrayretrun2['recommendedPriceArray2']; 
				$i++;
			}
			$totalsumrecommendedprice = number_format($totalsumrecommendedprice,2);
					
			$html.='<table border="1" width="100%" cellpadding="4">
            <tr>
              <td style="padding-left:10px;" width=""><b>'.$rowSDB['hotel_name'].'</b><span style="padding-left:5px;">'.$bsiCore->hotelStar($rowSDB['star_rating'],1).'</span></td>
            </tr>
            <tr>
              <td style="padding-left:10px;" width="">'.$rowSDB['address_1'].', '.$rowSDB['city_name'].', ('.$bsiCore->getCountryName($rowSDB['country_code']).')</td>
            </tr>
            <tr>
              <td style="padding-left:10px;" width="">Description</td>
            </tr>
            <tr>
              <td style="padding-left:10px;" width="">
              <table width="100%" cellpadding="5" cellspacing="5" border="1">
                  <thead>
                    <tr>
                      <th bgcolor="#CCCCCC" nowrap="nowrap" align="left">Available room types</th>
                      <th bgcolor="#CCCCCC" align="center">Max Occupency</th>
                      <th bgcolor="#CCCCCC" align="right">Rate</th>
                    </tr>
                    <tr style="background-color:#9C6 !important;">
                      <th colspan="3" style="background-color:#FFCACA !important" align="left">'.$bsiHotelSearch->totalRoom.' Rooms, '.$bsiHotelSearch->totalAdult.' Adults, '.$bsiHotelSearch->nightCount.' Nights</th>
                    </tr>
                  </thead>
                  <tbody>
             		'.$recommendedPrice.'
                 </tbody>
                </table></td>
            </tr>
            <tr><td><table width="100%" cellpadding="5"><tr><td width="80%" align="right"><b>Total Price '.$bsiCore->config['conf_currency_symbol'].$totalsumrecommendedprice.'</b></td><td><button class="button_colour" id="booknow" onclick="javascript:window.location.href=\'admin_hotelDetails.php?hotel_id='.base64_encode($rowSDB['hotel_id']).'\'" ><img width="24" height="24" src="images/icons/small/white/bended_arrow_right.png" alt="Bended Arrow Right"/><span>Book Now</span></button></td></tr></table></td></tr>
          </table><br /><br />';
			  $recommendedHtml[$rowSDB['hotel_id']] = array("recommendedRoomtype" => $recommendedPrice, "recommended" => $recommended);
			  $_SESSION['recommendedRoomtype'] = $recommendedHtml;
		 } 
	}
	
	if(isset($totalAvailabilityOfHotelFinal)){
		$_SESSION['totalAvailabilityOfHotelFinal']=$totalAvailabilityOfHotelFinal;
		$_SESSION['availabilityByRoomTypeFinal']=$availabilityByRoomTypeFinal;
		$_SESSION['ArrayCntRoom']=$array_cnt_room;
	}
?>
<script type="text/javascript">
$(document).ready(function(){
    $('#changeSelect').click(function() { 
            document.location='admin_room_block.php';
    }); 
});
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
                            //print_r($roomAdultarr);
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
        
        <td valign="top"><div style="padding-left:10px; height:30px;">
            <h3>
              <?=$totalhotelbydestination?>
              Hotels found,
              <?=$totalhotelbyavailable?>
              Available</h3>
          </div>
          
          <!-- ***************************************Hotel Listing*****************************************-->
          
          <?=$html?></td>
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