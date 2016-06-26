<?php
	session_start();
	include("includes/db.conn.php");
	include("includes/conf.class.php");
	include("includes/booking-process.class.php");
	$roomtype = $_REQUEST['roomtype'];
	//echo $_POST['extrabed'];
	//echo $_POST['price'];die;
	//print_r($_SESSION['availabilityByRoomTypeFinal']);die;
	$availabilityByRoomTypeFinal = $_SESSION['availabilityByRoomTypeFinal'];
	$hotel_id = $_SESSION['hotel_id']; 
	$recommendedRoom = $_SESSION['recommendedRoomtype'];
	$sv_checkindate  = $_SESSION['sv_mcheckindate'];
	$sv_checkoutdate = $_SESSION['sv_mcheckoutdate'];
	$sv_childcount   = $_SESSION['sv_childcount'];

	switch($roomtype){		
	case '1':
		//bookingid generated
		$bookingid = $bsiCore->config['conf_bookingid_prefix'].time();
		$_SESSION['bookingId'] = $bookingid;
		$totalAmount = 0;
		
		//print_r($recommendedRoom[$hotel_id]['recommended']);die;
		
		foreach($recommendedRoom[$hotel_id]['recommended'] as $key => $value){
			//Room Reservation
			foreach($value as $key2 => $value2){
				$room = explode("#", $value2['totalRoomAvailableId']);
				for($i=0;$i<$key2;$i++){
					$status = mysql_query("insert into bsi_reservation (booking_id, room_id, roomtype_id) values ('".$bookingid."', '".$room[$i]."', '".$value2['roomTypeId']."')");
				}
				$totalAmount += $bsiHotelBooking->gettotalAmount($value2['totalPrice'], $key2);
				$arrayRoomType[]=array("roomTypeId" => $value2['roomTypeId'], "roomTypeName" => $value2['roomTypeName'], "capacityTitle" => $value2['capacityTitle'],"Qty" => $key2, "totalPrice" => $value2['totalPrice'], "noofadults" => $value2['adultPerRoom'], "capcityid" => $value2['capcityid'],"child_price"=>$value2['child_price']);
			}
		}
		//Booking Proceeded
		$bsiHotelBooking->getbookingId($hotel_id, $sv_checkindate, $sv_checkoutdate, $sv_childcount, $totalAmount, $bookingid);
		$_SESSION['RoomType_Capacity_Qty']=$arrayRoomType;
		if($status == true){
			header("location:checkout_step1.php");
			exit;
		}
		//Booking Proceeded		
	break;
	case '2':
	//print_r($_POST);die;
		array_pop($_POST);
		$toamt=0;
		$booking_permission=1;
		$bookingid=$bsiCore->config['conf_bookingid_prefix'].time();
		$_SESSION['bookingId'] = $bookingid;
		$flag      = false;
		
		$roomkey=array();
		foreach($_POST as $key => $val)	{	if (strpos($key,'room_') !== false) $roomkey[].=$key;  }
		$extrakey=array();
		foreach($_POST as $key => $val)	{	if (strpos($key,'extrabed_') !== false) $extrakey[].=$key;  }
		
		/*foreach($_POST as $key => $val){	

			//if($val > 0){
			if($_POST[$arrkey[0]]>0){
				$flag        = true;
				//$room=explode('_', $key);
				$room=explode('_',$arrkey[0]);
				$roomArray   = $availabilityByRoomTypeFinal[$hotel_id][$room[1]][$room[2]];
				
				//$totalAmount = $bsiHotelBooking->gettotalAmount($roomArray['totalPrice'],$val);
				$totalAmount = $bsiHotelBooking->gettotalAmount($roomArray['totalPrice'],$_POST[$arrkey[0]]);
				$toamt      += $totalAmount;
				//$status      = $bsiHotelBooking->roombooking($bookingid, $roomArray['roomTypeId'],$roomArray['totalRoomAvailableId'], $val);
				$status      = $bsiHotelBooking->roombooking($bookingid, $roomArray['roomTypeId'],$roomArray['totalRoomAvailableId'], $_POST[$arrkey[0]]);
				$arrayRoomType[] = array("roomTypeName" => $roomArray['roomTypeName'], "capacityTitle" => $roomArray['capacityTitle'],"Qty" => $_POST[$arrkey[0]], "totalPrice" => $roomArray['totalPrice'], "noofadults" => $roomArray['adultPerRoom'], "capcityid" => $roomArray['capcityid'],"child_price"=>$value2['child_price']);
				//print_r($arrayRoomType);die;
			}
		}	*/
		
		$statussql=mysql_query("select status from  bsi_hotels where hotel_id='".$hotel_id."'"); 
		$statusrow = mysql_fetch_assoc($statussql);	
		
		if($statusrow['status']==0)
		{
		$flag        = true;
		$booking_permission=9;
		
		}else{
		
		for($i=0; $i<count($_POST); $i++){
		
			if($_POST[$roomkey[$i]]>0){
			$flag        = true;
			
			
			
			$room=explode('_',$roomkey[$i]);
			
			$roomArray   = $availabilityByRoomTypeFinal[$hotel_id][$room[1]][$room[2]];
			//print_r($roomArray);die;
			$totalAmount = $bsiHotelBooking->gettotalAmount($roomArray['totalPrice'],$_POST[$roomkey[$i]]);
			$toamt      += $totalAmount;
			$extraprice+=$_POST[$extrakey[$i]];
			//$status      = $bsiHotelBooking->roombooking($bookingid, $roomArray['roomTypeId'],$roomArray['totalRoomAvailableId'], $_POST[$roomkey[$i]]);
			$arrayRoomType[] = array("roomTypeId" => $roomArray['roomTypeId'],"roomTypeName" => $roomArray['roomTypeName'], "capacityTitle" => $roomArray['capacityTitle'],"Qty" => $_POST[$roomkey[$i]], "totalPrice" => $roomArray['totalPrice'], "noofadults" => $roomArray['adultPerRoom'], "capcityid" => $roomArray['capcityid'],"child_price"=>$roomArray['child_price'],"extra_price"=>$_POST[$extrakey[$i]]);
			
			/* ================ For double checking  ================= */
			
			$searchsql = "		
		SELECT rm.room_id, rm.room_no
		  FROM bsi_room rm
		 WHERE rm.roomtype_id = ".$roomArray['roomTypeId']."
			   AND rm.capacity_id = ".$roomArray['capcityid']."
			   AND rm.room_id NOT IN
					  (SELECT resv.room_id
						 FROM bsi_reservation resv, bsi_bookings boks
						WHERE     boks.is_deleted = FALSE   
							  AND resv.booking_id = boks.booking_id
							  AND resv.roomtype_id = ".$roomArray['roomTypeId']."
							  AND (('".$_SESSION['sv_mcheckindate']."' BETWEEN boks.checkin_date AND DATE_SUB(boks.checkout_date, INTERVAL 1 DAY))
							   OR (DATE_SUB('".$_SESSION['sv_mcheckoutdate']."', INTERVAL 1 DAY) BETWEEN boks.checkin_date AND DATE_SUB(boks.checkout_date, INTERVAL 1 DAY))
							   OR (boks.checkin_date BETWEEN '".$_SESSION['sv_mcheckindate']."' AND DATE_SUB('".$_SESSION['sv_mcheckoutdate']."', INTERVAL 1 DAY))
							   OR (DATE_SUB(boks.checkout_date, INTERVAL 1 DAY) BETWEEN '".$_SESSION['sv_mcheckindate']."' AND DATE_SUB('".$_SESSION['sv_mcheckoutdate']."', INTERVAL 1 DAY))))";
			//echo $searchsql;die;				   
		$sql = mysql_query($searchsql);
		$availableroomno=mysql_num_rows($sql);
		
if($availableroomno==0) 
	{
	//******************** Not Available *********************//	
		$booking_permission=0;
	}else{
	//******************** Available *********************//
        $status=$bsiHotelBooking->roombooking($bookingid, $roomArray['roomTypeId'],$roomArray['totalRoomAvailableId'], $_POST[$roomkey[$i]]);
			}
			
			/* ================ End of double checking  ================= */
			
			
			//print_r($arrayRoomType);die;
			}
		}
		
		}
		if($flag == true){
			if($booking_permission==0){
			$_SESSION['selectErr2'] = 'Room Sold Out';
			header("location:checkout_step1.php?bp=".base64_encode(0)); 
			//header("location:".$hotelname['city_name'].'/'.str_replace(" ","-",strtolower(trim($hotelname['hotel_name']))).'-'.$_SESSION['hotel_id'].'.html');
			}
			else if($booking_permission==9) {
			$_SESSION['selectErr2'] = 'Booking Unavaiable';
			header("location:checkout_step1.php?bp=".base64_encode(9));
				}else{
			$bsiHotelBooking->getbookingId($hotel_id,$sv_checkindate,$sv_checkoutdate,$sv_childcount,$toamt,$bookingid,$extraprice);
			$_SESSION['RoomType_Capacity_Qty'] = $arrayRoomType;
			header("location:checkout_step1.php?bp=".base64_encode(1));
			exit;
			}
		}else{
			$_SESSION['selectErr2'] = 'Please select atlease one Room to Proceed.';
			$hotelsql= mysql_query("select * from `bsi_hotels`  where hotel_id=".$_SESSION['hotel_id']);
			$hotelname = mysql_fetch_assoc($hotelsql);
			header("location:".$hotelname['city_name'].'/'.str_replace(" ","-",strtolower(trim($hotelname['hotel_name']))).'-'.$_SESSION['hotel_id'].'.html');
			
			exit;
		}
	break;
}
?>