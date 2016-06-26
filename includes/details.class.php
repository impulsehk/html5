<?php
/**
* @package BSI
* @author BestSoft Inc see README.php
* @copyright BestSoft Inc.
* See COPYRIGHT.php for copyright notices and details.
*/

/**
* @package BSI
* @author BestSoft Inc see README.php
* @copyright BestSoft Inc.
* See COPYRIGHT.php for copyright notices and details.
*/

class bsiBookingDetails
{
	public $hotelid = 0;
	public $guestsPerRoom = 0;   
	public $nightCount = 0; 
	public $checkInDate = '';
	public $checkOutDate = ''; 
	public $totalRoomCount = 0; 
	public $discountPlans = array(); 
	public $roomPrices = array();
	public $listHotelExtraService = array();
	
	private $selectedRooms = '';
	private $needExtraBed = '';
	public  $mysqlCheckInDate = '';
	public  $mysqlCheckOutDate = '';
	private $hotelExrtaServices = array();
	
	private $searchVars = array();
	private $detailVars = array(); 
	
	function bsiBookingDetails() { 
		$this->setRequestParams();    
	}  
	
	private function setRequestParams() { 
		/**
		* Global Ref: conf.class.php
		**/
		global $bsiCore; 
		//print_r($_POST);die;
		$this->setMyParamValue($this->hotelid, 'SESSION', 'hotelid', NULL, true);  
		$this->setMyParamValue($this->guestsPerRoom, 'SESSION', 'sv_guestperroom', NULL, true);  
		$this->setMyParamValue($this->checkInDate, 'SESSION', 'sv_checkindate', NULL, true);
		$this->setMyParamValue($this->mysqlCheckInDate, 'SESSION', 'sv_mcheckindate', NULL, true);
		$this->setMyParamValue($this->checkOutDate, 'SESSION', 'sv_checkoutdate', NULL, true);
		$this->setMyParamValue($this->mysqlCheckOutDate, 'SESSION', 'sv_mcheckoutdate', NULL, true);
		$this->setMyParamValue($this->nightCount, 'SESSION', 'sv_nightcount', NULL, true);  
		$this->setMyParamValue($this->searchVars, 'SESSION', 'svars_details', NULL, true);
		
		$this->setMyParamValue($this->selectedRooms, 'POST_SPECIAL', 'svars_selectedrooms', NULL, true);  
		$selected = 0;
		foreach($this->selectedRooms as &$val){  
			$val = $bsiCore->ClearInput($val); if($val) $selected++;
		}   
		if($selected == 0) $this->invalidRequest(9);  
		$this->setMyParamValue($this->needExtraBed, 'POST_SPECIAL', 'svars_extrabed', NULL, false); 
		$this->setMyParamValue($this->hotelExrtaServices, 'POST_SPECIAL', 'extraservices', NULL, false); 
		if($this->hotelExrtaServices)$this->hotelExrtaServices = array_filter($this->hotelExrtaServices);    
	}
	
	private function setMyParamValue(&$membervariable, $vartype, $param, $defaultvalue, $required = false){
		global $bsiCore;
		switch($vartype){
			case "POST": 
			if($required){if(!isset($_POST[$param])){$this->invalidRequest(9);} 
			else{$membervariable = $bsiCore->ClearInput($_POST[$param]);}}
			else{if(isset($_POST[$param])){$membervariable = $bsiCore->ClearInput($_POST[$param]);} 
			else{$membervariable = $defaultvalue;}}    
			break; 
			
			case "POST_SPECIAL":
			if($required){if(!isset($_POST[$param])){$this->invalidRequest(9);}
			else{$membervariable = $_POST[$param];}}
			else{if(isset($_POST[$param])){$membervariable = $_POST[$param];}
			else{$membervariable = $defaultvalue;}}    
			break; 
			
			case "GET":
			if($required){if(!isset($_GET[$param])){$this->invalidRequest(9);} 
			else{$membervariable = $bsiCore->ClearInput($_GET[$param]);}}
			else{if(isset($_GET[$param])){$membervariable = $bsiCore->ClearInput($_GET[$param]);} 
			else{$membervariable = $defaultvalue;}}    
			break; 
			
			case "SESSION":
			if($required){if(!isset($_SESSION[$param])){$this->invalidRequest(9);} 
			else{$membervariable = $_SESSION[$param];}}
			else{if(isset($_SESSION[$param])){$membervariable = $_SESSION[$param];} 
			else{$membervariable = $defaultvalue;}}    
			break; 
			
			case "REQUEST":
			if($required){if(!isset($_REQUEST[$param])){$this->invalidRequest(9);}
			else{$membervariable = $bsiCore->ClearInput($_REQUEST[$param]);}}
			else{if(isset($_REQUEST[$param])){$membervariable = $bsiCore->ClearInput($_REQUEST[$param]);}
			else{$membervariable = $defaultvalue;}}    
			break;
			
			case "SERVER":
			if($required){if(!isset($_SERVER[$param])){$this->invalidRequest(9);}
			else{$membervariable = $_SERVER[$param];}}
			else{if(isset($_SERVER[$param])){$membervariable = $_SERVER[$param];}
			else{$membervariable = $defaultvalue;}}    
			break; 
		}  
	} 
	
	private function invalidRequest($errocode = 9){  
		header('Location: booking-failure.php?error_code='.$errocode.'');
		die;
	}
		
	//*************************************************************************************************
	public function generateBookingDetails2() {
	/**
	* Global Ref: conf.class.php
	**/
	global $bsiCore;
	
	$result             = array();
	$dvroomidsonly      = "";
	$selectedRoomsCount = count($this->selectedRooms); 
	
	$dvarsCtr = 0;
	for($i = 0; $i < $selectedRoomsCount; $i++){
		if($this->selectedRooms[$i] > 0){  
			$this->detailVars[$dvarsCtr] = $this->searchVars[$i]; //selected only   	
			$tmpRoomCounter = 0;        
			foreach($this->detailVars[$dvarsCtr]['availablerooms'] as $availablerooms){ 
				$this->roomPrices['subtotal'] = $this->roomPrices['subtotal'] + $tmpTotalPrice; 
				$dvroomidsonly.= $availablerooms['roomid'].",";  
				//print_r($availablerooms['roomid']);          
				$tmpRoomCounter++; 
				if($tmpRoomCounter == $this->selectedRooms[$i]){
					$tmpAvRmSize = count($this->detailVars[$dvarsCtr]['availablerooms']);
					for($akey = $tmpRoomCounter; $akey < $tmpAvRmSize; $akey++){
						unset($this->detailVars[$dvarsCtr]['availablerooms'][$akey]);
					}
					break;  
				}   
			}
			array_push($result, array('roomno'=>$tmpRoomCounter, 'roomtype'=>$this->detailVars[$dvarsCtr]['roomtypename'], 'capacitytitle'=>$this->detailVars[$dvarsCtr]['capacitytitle'] ,'capacity'=>$this->guestsPerRoom));  
		
			$dvarsCtr++;    
			}
		}//die;
		//print_r($result);
		
		if(isset( $_SESSION['dvars_details']))unset($_SESSION['dvars_details']);
			$_SESSION['dvars_details'] = $this->detailVars;
			//print_r($this->detailVars);die;
		
		if(isset( $_SESSION['dvars_details2']))unset($_SESSION['dvars_details2']);
			$_SESSION['dvars_details2'] = $result;
		
		
		if(isset($_SESSION['dv_roomidsonly']))unset($_SESSION['dv_roomidsonly']);
			$_SESSION['dv_roomidsonly'] = substr($dvroomidsonly, 0, -1); 
			$this->totalRoomCount =  count(explode(",", $_SESSION['dv_roomidsonly']));
			
			return $result;
		} 
	}
?>
