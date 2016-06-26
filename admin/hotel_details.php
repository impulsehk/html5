<?php 
    include("access.php");
   if(!isset($_GET['hotel_id'])){
	   header("location:hotel_list.php");	
	}
	$pageid = 9;
	include("header.php");
	global $bsiCore;
?>
			<div class="flat_area grid_16">
					<button class="button_colour" style="float:right; padding-right:0px; margin-right:0px;" onclick="javascript:window.location.href='<?=$_SERVER['HTTP_REFERER']?>'"><img height="24" width="24" alt="Bended Arrow Right" src="images/icons/small/white/bended_arrow_right.png"><span>back</span></button><h2>Hotel Details</h2>
				</div>
				<div class="box grid_16 round_all">
					<h2 class="box_head grad_colour round_top">&nbsp;&nbsp;</h2>	
					<a href="#" class="grabber">&nbsp;</a>
					<a href="#" class="toggle">&nbsp;</a>
					<div class="block no_padding">
                    <?php if(isset($_GET['hotel_id'])){
                    	$hotel_id=$bsiCore->ClearInput(base64_decode($_REQUEST['hotel_id']));
						$hotelRow = $bsiCore->getHotelDetails($hotel_id);
						if($hotelRow['status']==1){
							$status="Yes";
						}else{
							$status="No";
						}
						$pet_status="";
						if($hotelRow['pets_status']==1){
							$pet_status="Allowed";
						}else{
							$pet_status="Not Allowed";
						}
						$star='<div style="width:500px;">';
						for($i=0;$i<$hotelRow['star_rating'];$i++){
							$star.='<img src="../gallery/star.png" height="13px" width="13px"/>';	
						}
						$star.='</div>';
					}
						
					?>
                    	<table  cellpadding="8" class="static">
                        	<tr><td width="20%" align="left"><strong>Hotel Name</strong></td><td><?=$hotelRow['hotel_name']?></th></tr>
                            <tr><td width="20%"  align="left"><strong>Address 1</strong></td><td><?=$hotelRow['address_1']?></td></tr>
                            <tr><td width="20%"  align="left"><strong>Address 2</strong></td><td><?=$hotelRow['address_1']?></td></tr>
                            <tr><td width="20%"  align="left"><strong>City</strong></td><td><?=$hotelRow['city_name']?></td></tr>
                            <tr><td width="20%"  align="left"><strong>State</strong></td><td><?=$hotelRow['state']?></td></tr>
                            <tr><td width="20%"  align="left"><strong>Postal Code</strong></td><td><?=$hotelRow['post_code']?></td></tr>
                            <tr><td width="20%"  align="left"><strong>Country</strong></td><td><?=$hotelRow['name']?></td></tr>
                            <tr><td width="20%"  align="left"><strong>Email id</strong></td><td><?=$hotelRow['email_addr']?></td></tr>
                            <tr><td width="20%"  align="left"><strong>Hotel Image</strong></td><td><?php if($hotelRow['default_img'] != ""){ ?><a rel="collection" href="../gallery/hotelImage/<?=$hotelRow['default_img']?>" target="_blank">View Image</a><?php } else{ echo "<b>No Image</b>"; } ?></td></tr>
                            <tr><td width="20%"  align="left"><strong>Phone No</strong></td><td><?=$hotelRow['phone_number']?></td></tr>
                            <tr><td width="20%"  align="left"><strong>Fax No</strong></td><td><?=$hotelRow['fax_number']?></td></tr>
                            <tr><td width="20%"  align="left"><strong>Star Rating</strong></td><td><?=$star?></td></tr>
                            <tr ><td width="20%"  align="left"><strong>Short Description</strong></td><td style="font-weight:normal; "><?=$hotelRow['desc_short']?></td></tr>
                            <tr><td width="20%" valign="top"><strong>Long Description</strong></td><td><?=$hotelRow['desc_long']?></td></tr>
                            <tr><td width="20%"  align="left"><strong>Check In</strong></td><td><?=$hotelRow['checking_hour']?></td></tr>
                            <tr><td width="20%"  align="left"><strong>Check Out</strong></td><td><?=$hotelRow['checkout_hour']?></td></tr>
                            <tr><td width="20%"  align="left"><strong>Pets Allowed</strong></td><td><?=$pet_status?></td></tr>
                            <tr><td width="20%" valign="top"><strong>Terms & Condition</strong></td><td><?=$hotelRow['terms_n_cond']?></td></tr>
                            <tr><td width="20%"  align="left"><strong>Status</strong></td><td><?=$status?></td></tr>
                            <tr><td width="20%"  align="left"></td><td></td></tr>
                       </table>
                    
					</div>
			</div>

			
		</div>
		<div id="loading_overlay">
			<div class="loading_message round_bottom">Loading...</div>
		</div>
        <div style="padding-right:8px;"><?php include("footer.php"); ?></div> 
		</body>
	</html>