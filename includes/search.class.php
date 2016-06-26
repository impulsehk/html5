<?php
/**
* @package BSI
* @author BestSoft Inc see README.php
* @copyright BestSoft Inc.
* See COPYRIGHT.php for copyright notices and details.
*/
class bsiSearch
{
	public $hotelid = 0;
	public $checkInDate = '';
    public $checkOutDate = '';	
	public $mysqlCheckInDate = '';
    public $mysqlCheckOutDate = '';
	public $guestsPerRoom = 0;
	public $childPerRoom = 0;
	public $extrabedPerRoom = false;			
	public $nightCount = 0;	
	public $fullDateRange;
	public $roomType = array();	
	public $multiCapacity = array();
	public $searchCode = "SUCCESS";
	const SEARCH_CODE  = "SUCCESS";
	
	function bsiSearch() {				
		$this->setRequestParams();
		$this->getNightCount();
		$this->checkSearchEngine();		
		
		if($this->searchCode == self::SEARCH_CODE){
			$this->loadMultiCapacity();			
			$this->loadRoomTypes();
			$this->fullDateRange = $this->getDateRangeArray($this->mysqlCheckInDate, $this->mysqlCheckOutDate);
			$this->setMySessionVars();
		}	
	}
	
	private function setRequestParams() {		
		global $bsiCore;
		$tmpVar = isset($_POST['hotelid'])? $_POST['hotelid'] : NULL;
		$this->setMyParamValue($this->hotelid, $bsiCore->ClearInput($tmpVar), NULL, true);
		$tmpVar = isset($_POST['check_in'])? $_POST['check_in'] : NULL;
		$this->setMyParamValue($this->checkInDate, $bsiCore->ClearInput($tmpVar), NULL, true);
		$tmpVar = isset($_POST['check_out'])? $_POST['check_out'] : NULL;
		$this->setMyParamValue($this->checkOutDate, $bsiCore->ClearInput($tmpVar), NULL, true);
		 $tmpVar = isset($_POST['capacity'])? $_POST['capacity'] : 0;
		$this->setMyParamValue($this->guestsPerRoom, $bsiCore->ClearInput($tmpVar), 0, true);
		$tmpVar = isset($_POST['childcount'])? $_POST['childcount'] : 0;
		$this->setMyParamValue($this->childPerRoom, $bsiCore->ClearInput($tmpVar), 0, false);
		$tmpVar = isset($_POST['extrabed'])? true : false;
		$this->setMyParamValue($this->extrabedPerRoom, $tmpVar, false, false);				
		$this->mysqlCheckInDate = $bsiCore->getMySqlDate($this->checkInDate);	
		$this->mysqlCheckOutDate = $bsiCore->getMySqlDate($this->checkOutDate);				
	}
	
	private function setMyParamValue(&$membervariable, $paramvalue, $defaultvalue, $required = false){
		if($required){if(!isset($paramvalue)){$this->invalidRequest();}}
		if(isset($paramvalue)){ $membervariable = $paramvalue;}else{$membervariable = $defaultvalue;}
	}
	
	private function setMySessionVars(){
		if(isset($_SESSION['hotelid'])) unset($_SESSION['hotelid']);
		if(isset($_SESSION['sv_checkindate'])) unset($_SESSION['sv_checkindate']);
		if(isset($_SESSION['sv_checkoutdate'])) unset($_SESSION['sv_checkoutdate']);
		if(isset($_SESSION['sv_mcheckindate'])) unset($_SESSION['sv_mcheckindate']);
		if(isset($_SESSION['sv_mcheckoutdate'])) unset($_SESSION['sv_mcheckoutdate']);
		if(isset($_SESSION['sv_nightcount'])) unset($_SESSION['sv_nightcount']);
		if(isset($_SESSION['sv_guestperroom'])) unset($_SESSION['sv_guestperroom']);
		if(isset($_SESSION['sv_childcount'])) unset($_SESSION['sv_childcount']);
		if(isset($_SESSION['sv_extrabed'])) unset($_SESSION['sv_extrabed']);	
		
		$_SESSION['hotelid'] = $this->hotelid;
		$_SESSION['sv_checkindate'] = $this->checkInDate;
		$_SESSION['sv_checkoutdate'] = $this->checkOutDate;
		$_SESSION['sv_mcheckindate'] = $this->mysqlCheckInDate;
		$_SESSION['sv_mcheckoutdate'] = $this->mysqlCheckOutDate;
		$_SESSION['sv_nightcount'] = $this->nightCount;		
		$_SESSION['sv_guestperroom'] = $this->guestsPerRoom;	
		$_SESSION['sv_childcount'] = $this->childPerRoom;		
		$_SESSION['sv_extrabed'] = $this->extrabedPerRoom;		
		$_SESSION['svars_details'] = array();
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
	
	/**
     * Takes two dates formatted as YYYY-MM-DD and 
	 * creates an inclusive array of the dates between the from date not the to date
     * @return array
     */	
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
	
	private function checkSearchEngine(){
		global $bsiCore;
		if(intval($bsiCore->config['conf_booking_turn_off']) > 0){
			$this->searchCode = "SEARCH_ENGINE_TURN_OFF";
			return 0;
		}
				
		$diffrow = mysql_fetch_assoc(mysql_query("SELECT DATEDIFF('".$this->mysqlCheckOutDate."', '".$this->mysqlCheckInDate."') AS INOUTDIFF"));
		$dateDiff = intval($diffrow['INOUTDIFF']);
		if($dateDiff < 0){
			$this->searchCode = "OUT_BEFORE_IN";
			return 0;
		}else if($dateDiff < intval($bsiCore->config['conf_min_night_booking'])){
			$this->searchCode = "NOT_MINNIMUM_NIGHT";
			return 0;
		}
		
		$userInputDate = strtotime($this->mysqlCheckInDate);
		$hotelDateTime = strtotime(date("Y-m-d"));
		$timezonediff =  ($userInputDate - $hotelDateTime);
		if($timezonediff < 0){
			$this->searchCode = "TIME_ZONE_MISMATCH";  
			return 0;
		}		
	}
	
	private function loadRoomTypes(){    
		$sql = mysql_query("SELECT * FROM bsi_roomtype where hotel_id=".$this->hotelid);
		while($currentrow = mysql_fetch_assoc($sql)){ 
			array_push($this->roomType, array('rtid'=>$currentrow["roomtype_id"], 'rtname'=>$currentrow["type_name"]));
		}
		mysql_free_result($sql);
	}	
	
	private function loadMultiCapacity() {		 
		$sql = mysql_query("SELECT * FROM bsi_capacity WHERE capacity >= ".$this->guestsPerRoom." and hotel_id=".$this->hotelid); 
		while($currentrow = mysql_fetch_assoc($sql)){			
			$this->multiCapacity[$currentrow["capacity_id"]] = array('capval'=>$currentrow["capacity"],'captitle'=>$currentrow["title"]);
		}		
		mysql_free_result($sql);
	}
	
	public function getHotelExtras(){
		$hotelExtras = array();
		global $bsiCore;
		$sql = mysql_query("SELECT * FROM bsi_extras WHERE enabled = 1");
		while($currentrow = mysql_fetch_assoc($sql)){
			if($bsiCore->config['conf_tax_amount'] > 0 && $bsiCore->config['conf_price_with_tax']==1){ 
				$extprice=$currentrow["fees"]+($currentrow["fees"] * $bsiCore->config['conf_tax_amount']/100);
			}else{
				$extprice=$currentrow["fees"];
			}
			array_push($hotelExtras, array('extraid'=>$currentrow["extras_id"],'description'=>$currentrow["description"], 'price'=>$extprice));
		}
		mysql_free_result($sql);
		return $hotelExtras;		
	}	
	
	
	public function getHotelExtras_PerDay(){
		$hotelExtras_perDay = array();
		global $bsiCore;
		$sql = mysql_query("SELECT * FROM bsi_hotelextras_per_day WHERE enabled = 1");
		while($currentrow = mysql_fetch_assoc($sql)){
			if($bsiCore->config['conf_tax_amount'] > 0 && $bsiCore->config['conf_price_with_tax']==1){ 
				$extprice=$currentrow["fees"]+($currentrow["fees"] * $bsiCore->config['conf_tax_amount']/100);
			}else{
				$extprice=$currentrow["fees"];
			}
			array_push($hotelExtras_perDay, array('extraid'=>$currentrow["extras_id"],'description'=>$currentrow["description"], 'price'=>$extprice));
		}
		mysql_free_result($sql);
		return $hotelExtras_perDay;		
	}	
	
	public function getAvailableRooms($roomTypeId, $roomTypeName, $capcityid, $hotelid){
		/**
		 * Global Ref: conf.class.php
		 **/
		global $bsiCore;	
		
		$currency_symbol = $bsiCore->config['conf_currency_symbol'];		
		$searchresult = array('roomtypeid'=>$roomTypeId, 'roomtypename'=>$roomTypeName, 'capacityid'=>$capcityid, 'capacitytitle'=>$this->multiCapacity[$capcityid]['captitle'], "capacity"=> $this->multiCapacity[$capcityid]['capval'], 'maxchild'=>$this->childPerRoom, 'hotelid'=>$hotelid);
		$room_count = 0;
		$dropdown_html = '';
		
		$price_details_html = '';
		$total_price_amount = 0;
		$calculated_extraprice = 0;
		$extraSearchParam = "";
		
		if($this->childPerRoom > 0){
			$extraSearchParam.= " AND rm.no_of_child = ".$this->childPerRoom." ";
		}
		if($this->extrabedPerRoom){
			$extraSearchParam.= " AND rm.extra_bed > 0 ";		
		}
		
	
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
        
        		
		$sql = mysql_query($searchsql);
		$tmpctr = 0;
		if(mysql_num_rows($sql)){
			$tmpctr = 1;
			$searchresult['availablerooms'] = array();
			$dropdown_html .= '<select name="svars_selectedrooms[]" style="width:70px;"><option value="0" selected="selected">0</option>';
			while($currentrow = mysql_fetch_assoc($sql)){				
				$dropdown_html.= '<option value="'.$tmpctr.'">'.$tmpctr.'</option>';
				array_push($searchresult['availablerooms'], array('roomid'=>$currentrow["room_id"], 'roomno'=>$currentrow["room_no"]));
				$tmpctr++;
			}
			//print_r($searchresult);die;
			$dropdown_html.= '</select>';
		}else{
			$dropdown_html .= '<b>Sorry No Room Found</b>';	
		}
		mysql_free_result($sql);			
		if($tmpctr > 1) array_push($_SESSION['svars_details'], $searchresult);
		unset($searchresult);
		
		return array(
		'roomcnt' => $tmpctr-1,		
		'roomdropdown' => $dropdown_html);
	}
}
?>
