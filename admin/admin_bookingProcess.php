<?php
	include("access.php");
	include("../includes/db.conn.php");
	include("../includes/conf.class.php");
	include("../includes/admin.class.php");
	include("../includes/booking-process.class.php");
	$pageid = 27;
	$user_id = $_SESSION['cpid'];
	$bsiAdminMain->pageAccess($user_id, $pageid);
	$roomtype                    = $_REQUEST['roomtype'];
	$availabilityByRoomTypeFinal = $_SESSION['availabilityByRoomTypeFinal'];
	$hotel_id                    = $_SESSION['hotel_id'];
	$recommendedRoom             = $_SESSION['recommendedRoomtype'];
	$sv_checkindate              = $_SESSION['sv_mcheckindate'];
	$sv_checkoutdate             = $_SESSION['sv_mcheckoutdate'];
	$sv_childcount               = $_SESSION['sv_childcount'];
	
	switch($roomtype){		
		case '1':
			//bookingid generated
			$bookingid = $bsiCore->config['conf_bookingid_prefix'].time();
			$_SESSION['bookingId'] = $bookingid;
			$totalAmount = 0;
			foreach($recommendedRoom[$hotel_id]['recommended'] as $key => $value){
				//Room Reservation
				foreach($value as $key2 => $value2){
					$room = explode("#", $value2['totalRoomAvailableId']);
					for($i=0;$i<$key2;$i++){
						mysql_query("insert into bsi_reservation (booking_id, room_id, roomtype_id) values ('".$bookingid."', '".$room[$i]."', '".$value2['roomTypeId']."')");
					}
					$totalAmount += $bsiHotelBooking->gettotalAmount($value2['totalPrice'], $key2);
					
					$arrayRoomType[]=array("roomTypeId" => $value2['roomTypeId'], "roomTypeName" => $value2['roomTypeName'], "capacityTitle" => $value2['capacityTitle'],"Qty" => $key2, "totalPrice" => $value2['totalPrice'], "noofadults" => $value2['adultPerRoom'], "capcityid" => $value2['capcityid']);
				}
				//Room Reservation
			}
			//Booking Proceeded
			$bsiHotelBooking->getbookingId($hotel_id, $sv_checkindate, $sv_checkoutdate, $sv_childcount, $totalAmount, $bookingid);
			$_SESSION['RoomType_Capacity_Qty']=$arrayRoomType;
			header("location:admin_checkOut.php");
			exit;
			//Booking Proceeded		
		break;
		
		case '2': 
			array_pop($_POST);
			$toamt=0;
			$bookingid=$bsiCore->config['conf_bookingid_prefix'].time();
			$_SESSION['bookingId'] = $bookingid;
			$flag = false;
			foreach($_POST as $key => $val){					
				if($val > 0){
					$flag = true;
					$room = explode('_', $key);
					$roomArray=$availabilityByRoomTypeFinal[$hotel_id][$room[1]][$room[2]];
					$totalAmount = $bsiHotelBooking->gettotalAmount($roomArray['totalPrice'],$val);
					$toamt += $totalAmount;
					$status = $bsiHotelBooking->roombooking($bookingid, $roomArray['roomTypeId'],$roomArray['totalRoomAvailableId'], $val);
					$arrayRoomType[]=array("roomTypeName" => $roomArray['roomTypeName'], "capacityTitle" => $roomArray['capacityTitle'],"Qty" => $val, "totalPrice" => $roomArray['totalPrice'], "noofadults" => $roomArray['adultPerRoom'], "capcityid" => $roomArray['capcityid']);
				}
			}
			if($flag == true){
				$bsiHotelBooking->getbookingId($hotel_id,$sv_checkindate,$sv_checkoutdate,$sv_childcount,$toamt,$bookingid); 
				$_SESSION['RoomType_Capacity_Qty']=$arrayRoomType;
				header("location:admin_checkOut.php");
				exit;
			}else{
				$_SESSION['selectErr'] = 'Please select atlease one Room to Proceed.';
				header("location:admin_hotelDetails.php?hotel_id=".base64_encode($_SESSION['hotel_id']));
				exit;
			}
		break;
	}
?>