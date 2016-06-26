<?php
/**
* @package BSI
* @author Best Soft Inc see README.php
* @copyright Best Soft Inc.
* See COPYRIGHT.php for copyright notices and details.
*/
class bsiHotelSearch
{
	public $destination = '';
	public $checkInDate = '';
    public $checkOutDate = '';	
	public $mysqlCheckInDate = '';
    public $mysqlCheckOutDate = '';
	public $totalAdult = 0;
	public $totalRoom = 0;
	public $childPerRoom = 0;
	public $extrabedPerRoom = false;
				
	public $currency = '';	
	
	public $nightCount = 0;	
	public $fullDateRange;
	public $roomType = array();	
	public $multiCapacity = array();
	public $searchCode = "SUCCESS";
	const SEARCH_CODE = "SUCCESS";
	
	function bsiHotelSearch() {				
		$this->setRequestParams();
		$this->getNightCount();
		$this->setMySessionVars();	
	}
	
	private function setRequestParams() {		
		global $bsiCore;
		$destination=''; 
	if(isset($_POST['destination'])){
	$sql=mysql_query("select * from bsi_city where city_name='".$_POST['destination']."' ");
		if(mysql_num_rows($sql)){
		$destination=$_POST['destination'];
		}else{
		$destination='All Cities';
		} 
	}else{
		$destination='All Cities';
	}
	$dateForm=$bsiCore->UserDateFormat();
	//date_default_timezone_set('America/Los_Angeles');
	$currtime=date('H:i'); 
	if($currtime >='00:00' && $currtime <='05:59'){
		$chkin=date($dateForm,strtotime("-1 days"));
		$datformat=date('Y-m-d',strtotime("-1 days"));
		$chkout=date($dateForm, strtotime('+1 days', strtotime($datformat)));

	}else{
		if(isset($_POST['check_in'])){
		$chkin=$_POST['check_in'];}
		if(isset($_POST['check_out'])){
		$chkout=$_POST['check_out'];}
	} 
	//die;
//echo $chkin .' '.$chkout; die;
	
		$tmpVar = isset($destination)?$destination: $_SESSION['sv_destination'];
		$this->setMyParamValue($this->destination, $tmpVar, NULL, true);
		
		$tmpVar = isset($_POST['check_in'])? $chkin : $_SESSION['sv_checkindate'];
		$this->setMyParamValue($this->checkInDate, $tmpVar, NULL, true);
		
		$tmpVar = isset($_POST['check_out'])? $chkout : $_SESSION['sv_checkoutdate'];
		$this->setMyParamValue($this->checkOutDate, $tmpVar, NULL, true);
				
		$tmpVar = isset($_POST['rooms'])? $_POST['rooms'] : $_SESSION['sv_rooms'];
		$this->setMyParamValue($this->totalRoom, $tmpVar, 0, false);
		
		
		$tmpVar = isset($_REQUEST['currency'])? $_REQUEST['currency'] : $_SESSION['sv_currency'] ;
		$this->setMyParamValue($this->currency, $tmpVar, 0, true);
		
		
		$tmpVar = isset($_POST['children'])? $_POST['children'] : $_SESSION['sv_childcount'];
		if(is_array($tmpVar)){
			foreach($tmpVar as $key => $val){
				$this->childPerRoom += $val;	
			}
		}else{
			$this->setMyParamValue($this->childPerRoom, $tmpVar, 0, false);	
		}
		
		$tmpVar = isset($_POST['adults'])? $_POST['adults'] : $_SESSION['sv_adults'];
		if(is_array($tmpVar)){
			foreach($tmpVar as $key => $val){
				$this->totalAdult += $val;	
			}
		}else{
			$this->setMyParamValue($this->totalAdult, $tmpVar, 0, false);	
		}
		//echo 'Check In Date : '.$this->checkInDate;		
		//echo 'Check Out Date : '.$this->checkOutDate;;			
		$this->mysqlCheckInDate = $bsiCore->getMySqlDate($this->checkInDate);	
		$this->mysqlCheckOutDate = $bsiCore->getMySqlDate($this->checkOutDate);	
		//echo 'Check In Date : '.$this->mysqlCheckInDate;
		//echo 'Check Out Date : '.$this->mysqlCheckOutDate;die;			
	}
	
	private function setMyParamValue(&$membervariable, $paramvalue, $defaultvalue, $required = false){
		if($required){if(!isset($paramvalue)){$this->invalidRequest();}}
		if(isset($paramvalue)){$membervariable = $paramvalue;}else{$membervariable = $defaultvalue;}
	}
	
	private function setMySessionVars(){
		if(isset($_SESSION['sv_checkindate']))   unset($_SESSION['sv_checkindate']);
		if(isset($_SESSION['sv_checkoutdate']))  unset($_SESSION['sv_checkoutdate']);
		if(isset($_SESSION['sv_mcheckindate']))  unset($_SESSION['sv_mcheckindate']);
		if(isset($_SESSION['sv_mcheckoutdate'])) unset($_SESSION['sv_mcheckoutdate']);
		if(isset($_SESSION['sv_nightcount']))  unset($_SESSION['sv_nightcount']);
		if(isset($_SESSION['sv_childcount']))  unset($_SESSION['sv_childcount']);
		if(isset($_SESSION['sv_rooms']))       unset($_SESSION['sv_rooms']);
		if(isset($_SESSION['sv_adults']))      unset($_SESSION['sv_adults']);
		if(isset($_SESSION['sv_destination'])) unset($_SESSION['sv_destination']);
		
		if(isset($_SESSION['sv_currency'])) unset($_SESSION['sv_currency']);
		
		$_SESSION['sv_checkindate']   = $this->checkInDate;
		$_SESSION['sv_checkoutdate']  = $this->checkOutDate;
		$_SESSION['sv_mcheckindate']  = $this->mysqlCheckInDate;
		$_SESSION['sv_mcheckoutdate'] = $this->mysqlCheckOutDate;
		$_SESSION['sv_nightcount']  = $this->nightCount;		
		$_SESSION['sv_rooms']       = $this->totalRoom;	
		$_SESSION['sv_adults']      = $this->totalAdult;	
		$_SESSION['sv_destination'] = $this->destination;	
		$_SESSION['sv_childcount']  = $this->childPerRoom;	
		
		
		$_SESSION['sv_currency'] = $this->currency;	
		
		$_SESSION['svars_details']  = array();
	}
	
	private function invalidRequest(){
		header('Location: booking-failure.php?error_code=9');
		die;
	}
	
	private function getNightCount() {		
		$checkin_date = getdate(strtotime($this->mysqlCheckInDate));
		$checkout_date = getdate(strtotime($this->mysqlCheckOutDate));
		$checkin_date_new = mktime( 12, 0, 0, $checkin_date['mon'], $checkin_date['mday'], $checkin_date['year']);
		$checkout_date_new = mktime( 12, 0, 0, $checkout_date['mon'], $checkout_date['mday'], $checkout_date['year']);
		$this->nightCount = round(abs($checkin_date_new - $checkout_date_new) / 86400);
	}
	
	
	public function hotelFilterByDestination(){
		if($this->destination != "All Cities"){
			$addQuery = " where bh.city_name like '%".$this->destination."%'";	
		}else{
			$addQuery = "";	
		}
		$sqlres=mysql_query("SELECT bh . * , count( bhr.hotel_id)  as review FROM bsi_hotels AS bh LEFT OUTER JOIN bsi_hotel_review AS bhr ON
bh.hotel_id = bhr.hotel_id ".$addQuery." GROUP BY bh.hotel_id") or die(mysql_error());	
		return $sqlres;	
	}
	
	public function hotelFilterByDestinationAsc(){
		if($this->destination != "All Cities"){
			$addQuery = " where bh.city_name like '%".$this->destination."%' and bh.status=1";	
		}else{
			$addQuery = "where bh.status=1";	
		}
		$sqlres=mysql_query("SELECT bh . * , count( bhr.hotel_id)  as review FROM bsi_hotels AS bh LEFT OUTER JOIN bsi_hotel_review AS bhr ON
bh.hotel_id = bhr.hotel_id ".$addQuery." GROUP BY bh.hotel_id order by bh.star_rating asc") or die(mysql_error()); 
		return $sqlres;	
	}
	
	public function hotelFilterByDestinationDsc(){
		if($this->destination != "All Cities"){
			$addQuery = " where bh.city_name like '%".$this->destination."%'";	
		}else{
			$addQuery = "";	
		}
		$sqlres=mysql_query("SELECT bh . * , count( bhr.hotel_id)  as review FROM bsi_hotels AS bh LEFT OUTER JOIN bsi_hotel_review AS bhr ON
bh.hotel_id = bhr.hotel_id ".$addQuery." GROUP BY bh.hotel_id order by bh.star_rating desc") or die(mysql_error());
		return $sqlres;	
	}
	
	public function hotelGetRoomType($hotel_id){
		$sqlres=mysql_query("select * from bsi_roomtype where hotel_id=".$hotel_id) or die(mysql_error());
		return $sqlres;
		
	}
	
	public function hotelGetCapacity($hotel_id, $capacity){
		//echo "select * from bsi_capacity where hotel_id=".$hotel_id." and capacity=".$capacity;die;
		$sqlres=mysql_query("select * from bsi_capacity where hotel_id=".$hotel_id." and capacity=".$capacity) or die(mysql_error()); 
		return $sqlres;
		
	}
	
	private function getDateRangeArray($startDate, $endDate, $nightAdjustment = true) {	
		$date_arr = array(); 
		$day_array=array(); 
		$total_array=array();
		$time_from = mktime(1,0,0,substr($startDate,5,2), substr($startDate,8,2),substr($startDate,0,4));
		$time_to = mktime(1,0,0,substr($endDate,5,2), substr($endDate,8,2),substr($endDate,0,4));		
		if ($time_to >= $time_from) { 
			if($nightAdjustment){
				while ($time_from < $time_to) {      
					array_push($date_arr, date('Y-m-d',$time_from));
					array_push($day_array, date('D',$time_from));
					$time_from+= 86400; // add 24 hours
				}
			}else{
				while ($time_from <= $time_to) {      
					array_push($date_arr, date('Y-m-d',$time_from));
					array_push($day_array, $time_from);
					$time_from+= 86400; // add 24 hours
				}
			}			
		}  
		array_push($total_array, $date_arr);
		array_push($total_array, $day_array);
		return $total_array;		
		
	}
	
	public function getAvailableRooms($roomTypeId, $roomTypeName, $capcityid, $hotel_id, $adultPerRoom, $capacityTitle, $capcity){ 
		global $bsiCore;
		$searchcorefunc=array();
		$totalAvailability=array();
		$searchsql = "		
		SELECT rm.room_id, rm.room_no
		  FROM bsi_room rm
		 WHERE rm.roomtype_id = ".$roomTypeId."
			   AND rm.capacity_id = ".$capcityid."
			   AND rm.room_id NOT IN
					  (SELECT resv.room_id
						 FROM bsi_reservation resv, bsi_bookings boks
						WHERE     boks.is_deleted = FALSE
							  AND resv.booking_id = boks.booking_id
							  AND resv.roomtype_id = ".$roomTypeId."
							  AND (('".$this->mysqlCheckInDate."' BETWEEN boks.checkin_date AND DATE_SUB(boks.checkout_date, INTERVAL 1 DAY))
							   OR (DATE_SUB('".$this->mysqlCheckOutDate."', INTERVAL 1 DAY) BETWEEN boks.checkin_date AND DATE_SUB(boks.checkout_date, INTERVAL 1 DAY))
							   OR (boks.checkin_date BETWEEN '".$this->mysqlCheckInDate."' AND DATE_SUB('".$this->mysqlCheckOutDate."', INTERVAL 1 DAY))
							   OR (DATE_SUB(boks.checkout_date, INTERVAL 1 DAY) BETWEEN '".$this->mysqlCheckInDate."' AND DATE_SUB('".$this->mysqlCheckOutDate."', INTERVAL 1 DAY))))";
		//echo $searchsql;die;
		$sql = mysql_query($searchsql);
		$searchcorefunc['availableNumberOfRoom']=mysql_num_rows($sql);
	
		$dayName = $this->getDateRangeArray($this->mysqlCheckInDate,$this->mysqlCheckOutDate);
		
		$dayDate = $dayName[0];
		$dayName = $dayName[1];
		$total_price = 0;
		$child_price = 0;
		
		foreach($dayDate as $key => $date){
			$rowPricesql = mysql_query("select * from bsi_priceplan where hotel_id=".$hotel_id." and room_type_id=".$roomTypeId." and capacity_id=".$capcityid." and '".$date."' between date_start and date_end");
			if(mysql_num_rows($rowPricesql)){
				$rowPrice = mysql_fetch_assoc($rowPricesql);
				$total_price += $rowPrice[strtolower($dayName[$key])];
			}else{
				$rowPrice = mysql_fetch_assoc(mysql_query("select * from bsi_priceplan where hotel_id=".$hotel_id." and room_type_id=".$roomTypeId." and capacity_id=".$capcityid));
				$total_price += $rowPrice[strtolower($dayName[$key])];	
			}
			
			//*************************************child ************************************//
			
			$chld_row2=mysql_fetch_assoc(mysql_query("SELECT distinct(`no_of_child`) FROM `bsi_room` WHERE hotel_id=".$hotel_id." and  `capacity_id`=".$capcityid." and `roomtype_id`=".$roomTypeId.""));
				if($chld_row2['no_of_child'] >= $this->childPerRoom && $this->childPerRoom != 0){
					$child_flag=true;
			
					$childpricesql = mysql_query("SELECT * FROM bsi_priceplan WHERE hotel_id=".$hotel_id." and  room_type_id = ".$roomTypeId." AND capacity_id =1001 AND ('".$date."' BETWEEN date_start AND date_end)");
					 if(mysql_num_rows($rowPricesql)){
						$chrow=mysql_fetch_assoc($childpricesql);
				     }else{
						// echo "SELECT * FROM bsi_priceplan WHERE hotel_id=".$hotel_id." and  room_type_id = ".$roomTypeId." AND capacity_id =1001 AND  default_plan=1"; die;
						
						$childpricesql2 = mysql_query("SELECT * FROM bsi_priceplan WHERE hotel_id=".$hotel_id." and  room_type_id = ".$roomTypeId." AND capacity_id =1001 AND  `default`=1");
						$chrow=mysql_fetch_assoc($childpricesql2);
				      }
					 
					  $day=date('D');
					  					
					  $child_price+=($chrow[strtolower($day)]*$this->childPerRoom); 	
			
			
			
				}
			// child calculation end
		}
		$totalRoomAvailableId="";
		while($row = mysql_fetch_assoc($sql)){				
			$totalRoomAvailableId.=$row["room_id"]."#";	
		}
				//echo $this->mysqlCheckInDate;die;
		/*$offer_price=$bsiCore->calculate_offer($this->mysqlCheckInDate,$this->mysqlCheckOutDate, $_SESSION['sv_nightcount'], $total_price,$hotel_id);
		
		if($offer_price['status']){
			
			$total_price=$offer_price['discount_price'];
			}else{
				
			$total_price=$total_price;	
				}*/
		
		$total_price+=$child_price;
		$totalRoomAvailableId=substr($totalRoomAvailableId,0,-1);
		$searchcorefunc['dayName']=$total_price;
		$totalAvailability['roomTypeId']=$roomTypeId;
		$totalAvailability['roomTypeName']=$roomTypeName;
		$totalAvailability['capcityid']=$capcityid;
		
		$totalAvailability['capcity']=$capcity;
		$totalAvailability['adultPerRoom']=$adultPerRoom;
		$totalAvailability['totalPrice']=$total_price;
		$totalAvailability['per_child']=$this->childPerRoom;
		
		$totalAvailability['child_price']=$child_price;
		$totalAvailability['capacityTitle']=$capacityTitle;
		$totalAvailability['totalRoomAvailableId']=$totalRoomAvailableId;
		$searchcorefunc['totalAvailability']=$totalAvailability;
		//print_r($searchcorefunc);die;
		return $searchcorefunc;
	}
	
	
	public function availabilityByRoomType($mainArray, $roomtypearray){
		$retrunarray=array();
		foreach($roomtypearray as $i => $roomtype){
			$retrunarray_sub=array();
			foreach($mainArray as $i => $val){
				if($val['roomTypeId']==$roomtype)
				array_push($retrunarray_sub, $val);
			}
			$retrunarray[$roomtype]=$retrunarray_sub;
		}
		return $retrunarray;
	} 
}
?>