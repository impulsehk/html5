<?php
	include("access.php");
	if(!isset($_SESSION['hotel_id']) || !isset($_SESSION['RoomType_Capacity_Qty'])){
		header("location:admin_room_block.php");
		exit;
	}
	$pageid = 27; 
	include("header.php");
	$hotel_id = $_SESSION['hotel_id'];
	$hotelDetails=$bsiCore->getHotelDetails($hotel_id);
	$roomtypeArray=$_SESSION['RoomType_Capacity_Qty'];
	$country = $bsiAdminMain->country("US"); 
?>
<script type="text/javascript" src="js/jquery.validate.js"></script>
<script type="text/javascript">
$(document).ready(function(){
	$('#signupform').validate();
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
        <td width="30%" valign="top"><table cellpadding="6" width="100%" border="0">
            <tr>
              <td valign="top"><!---***************************************-->
                
                <table cellpadding="5" width="100%" border="1" bgcolor="#eeeeee">
                  <tbody>
                    <tr>
                      <td colspan="2" style="padding-left:8px; font-weight:bold; font-size:12px; text-decoration:underline;" width="80px" align="left">Room Charges For.</td>
                    </tr>
                    <tr>
                      <td colspan="2" style="padding-left:8px; font-weight:bold; font-size:12px;" width="80px" align="left"><?=$hotelDetails['hotel_name']?></td>
                    </tr>
         <?php
			 $count=count($roomtypeArray);
			 $gettotalPrice=0;
			 $roomtype='';
			 $getRoom='<tr><td><b>Room:</b></td><td>';
			 for($i=0;$i<$count;$i++){
				 if($i+1 == $count){
					 $getRoom.=$roomtypeArray[$i]['Qty']." x ".$roomtypeArray[$i]['roomTypeName']."(".$roomtypeArray[$i]['capacityTitle'].")";
					 $roomtype.=$roomtypeArray[$i]['Qty']." x ".$roomtypeArray[$i]['roomTypeName']."(".$roomtypeArray[$i]['capacityTitle'].")";
				 }else{
					 $getRoom.=$roomtypeArray[$i]['Qty']." x ".$roomtypeArray[$i]['roomTypeName']."(".$roomtypeArray[$i]['capacityTitle'].")<br/>";
					 $roomtype.=$roomtypeArray[$i]['Qty']." x ".$roomtypeArray[$i]['roomTypeName']."(".$roomtypeArray[$i]['capacityTitle'].")<br/>";
				 }
			 }
			 $getRoom.='</td></tr>';
			 $_SESSION['getRoom']=$roomtype;
		?>
                    <?=$getRoom;?>
                    <tr>
                      <td><b>TotalRooms:</b></td>
                      <td><?=$_SESSION['sv_rooms']?></td>
                    </tr>
                    <tr>
                      <td><b>Adults:</b></td>
                      <td><?=$_SESSION['sv_adults']?></td>
                    </tr>
                    <tr>
                      <td><b>Children:</b></td>
                      <td><?=$_SESSION['sv_childcount']?></td>
                    </tr>
                    <tr>
                      <td><b>Check-in:</b></td>
                      <td><?=$_SESSION['sv_checkindate']?></td>
                    </tr>
                    <tr>
                      <td><b>Check-out:</b></td>
                      <td><?=$_SESSION['sv_checkoutdate']?></td>
                    </tr>
                    <tr>
                      <td><b>Nights:</b></td>
                      <td><?=$_SESSION['sv_nightcount']?></td>
                    </tr>
                    <tr>
                      <td width="110px"><b>Total room price:</b></td>
                      <td><b>
                        <?=$bsiCore->config['conf_currency_symbol'].$_SESSION['total_cost']?>
                        </b></td>
                    </tr>
                  </tbody>
                </table>
                <br>
                <table cellpadding="6" width="100%" border="1" bgcolor="#eeeeee">
                  <tbody>
                    <tr>
                      <td colspan="2" style="padding-left:8px; font-weight:bold; font-size:12px; text-decoration:underline;" width="80px" align="left">Total Charges</td>
                    </tr>
                    <tr>
                      <td width="110px"><b>Room Subtotal:</b></td>
                      <td class="tr"><?=$bsiCore->config['conf_currency_symbol'].number_format($_SESSION['total_cost'],2)?></td>
                    </tr>
                    <tr>
                      <td><b>Tax &amp; Fees:</b></td>
                      <td class="tr"><?=$bsiCore->config['conf_currency_symbol'].number_format($_SESSION['tax'],2)?></td>
                    </tr>
                    <tr>
                      <td><b>TOTAL:</b></td>
                      <td class="tr"><span class="color-green big"><b>
                        <?=$bsiCore->config['conf_currency_symbol'].number_format(($_SESSION['total_cost']+$_SESSION['tax']),2)?>
                        </b></span></td>
                    </tr>
                  </tbody>
                </table>
                
                <!---***************************************--></td>
            </tr>
          </table></td>
        <td width="10%">&nbsp;</td>
        <!-- Hotel Listing -->
        <td valign="top"><!-- ***************************************Client Details*****************************************-->
          
          <form method="post" action="admin_rmbookprocess.php" id="signupform" name="signupform" class="signupform" >
            <input type="hidden" name="allowlang" id="allowlang" value="no" />
            <table cellpadding="4" cellspacing="0" border="0" style="font-family:Arial, Helvetica, sans-serif; font-size:13px;">
              <tr>
                <td><strong>Title
                  :</strong></td>
                <td id="title"><select name="title" class="textbox3">
                    <option value="Mr.">Mr.</option>
                    <option value="Ms.">Ms.</option>
                    <option value="Mrs.">Mrs.</option>
                    <option value="Miss.">Miss.</option>
                    <option value="Dr.">Dr.</option>
                    <option value="Prof.">Prof.</option>
                  </select></td>
                <input type="hidden" name="payment_gateway" id="payment_gateway" value="admin"/>
                <td></td>
              </tr>
              <tr>
                <td><strong>First Name
                  :</strong></td>
                <td><input type="text" name="fname" id="fname" class="required"  size="35" /></td>
                <td  class="status"></td>
              </tr>
              <tr>
                <td><strong>Last Name
                  :</strong></td>
                <td><input type="text" name="lname" id="lname" class="required" size="35" /></td>
                <td  class="status"></td>
              </tr>
              <tr>
                <td><strong>Address
                  :</strong></td>
                <td><input type="text" name="address1" id="address1" class="required" size="35" /></td>
                <td  class="status"></td>
              </tr>
              <tr>
                <td><strong>City
                  :</strong></td>
                <td><input type="text" name="city"  id="city" class="required" size="35" /></td>
                <td  class="status"></td>
              </tr>
              <tr>
                <td><strong>State
                  :</strong></td>
                <td><input type="text" name="state"  id="state" class="required" size="35" /></td>
                <td  class="status"></td>
              </tr>
              <tr>
                <td><strong>Zipcode
                  :</strong></td>
                <td><input type="text" name="zipcode" class="required"  id="zipcode" size="35" /></td>
                <td  class="status"></td>
              </tr>
              <tr>
                <td><strong>Country
                  :</strong></td>
                <td><?=$country?></td>
                <td class="status"></td>
              </tr>
              <tr>
                <td><strong>Phone
                  :</strong></td>
                <td><input type="text" name="phone" class="required" id="phone" size="35" /></td>
                <td  class="status"></td>
              </tr>
              <tr>
                <td><strong>Fax
                  :</strong></td>
                <td><input type="text" name="fax" class="" id="fax" size="35" /></td>
                <td></td>
              </tr>
              <tr>
                <td><strong>Email
                  :</strong></td>
                <td><input type="text" name="email"  id="email" class="required email" style="width:198px;" /></td>
                <td  class="status"></td>
              </tr>
              <tr>
                <td><strong>Password
                  :</strong></td>
                <td><input type="password" name="pass" class="required" id="pass" size="35" /></td>
                <td></td>
              </tr>
              <input type="hidden" name="message" />
              <!--<tr>
                <td valign="top" nowrap="nowrap"><strong>Additional Request
                  :</strong></td>
                <td colspan="2"><textarea name="message" rows="2" cols="50" class="textarea"></textarea></td>
              </tr>-->
              <tr>
                <td></td>
                <td><button name="submit" type="submit" id="submit" class="button_colour round_all" ><img height="24" width="24" alt="Bended Arrow Right" src="images/icons/small/white/bended_arrow_right.png"><span> Submit </span></button></td>
                <td></td>
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