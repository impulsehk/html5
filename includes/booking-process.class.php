<?php

/**

* @package BSI

* @author BestSoft Inc see README.php

* @copyright BestSoft Inc.

* See COPYRIGHT.php for copyright notices and details.

*/

$bsiHotelBooking = new bsiHotelBooking;
 
//print_r($extrasArr);die;
class bsiHotelBooking{
	public $extrasArr = array();
	public $listExtraService = array();
	public $totalextraprices = 0.00;
	public function gettotalAmount($total_cost,$val){
		$total_price=0;
		$total_price=$total_cost*$val; 
		return $total_price;
	}
	
	private function getExrtaServices(){	
		
		$this->extrasArr = array_filter($_POST['extras']);	
		$extidlist = implode(",", array_keys($this->extrasArr));
		//echo "SELECT * FROM bsi_hotel_extras  WHERE id IN(".$extidlist.")";die;
		$sql = mysql_query("SELECT * FROM bsi_hotel_extras  WHERE id IN(".$extidlist.")");
		
		while($currentrow = mysql_fetch_assoc($sql)){	
		   $totalextraprices = 0.00;
			$temptotalfees = 0.00;
			$tempdescription = "";
			$temptotalfees = number_format(($currentrow["service_price"]), 2, '.', '');
			$tempdescription = $currentrow["service_name"]." ";				
			array_push($this->listExtraService, array('extraid'=>$currentrow["id"],'description'=>$tempdescription, 'price'=>$currentrow["service_price"], 'totalprice'=>$temptotalfees));
				
			$this->totalextraprices = $this->totalextraprices  + $temptotalfees;		
				
		}
		
		$_SESSION['listExtraService']=$this->listExtraService;		
		mysql_free_result($sql);	
	}

	public function getbookingId($hotel_id,$checkin_date,$checkout_date,$child_count,$total_cost, $bookingid,$extra_price){
		global $bsiCore;
		$reviewid = substr(uniqid(), -8, 8);
		$offer_price=$bsiCore->calculate_offer($checkin_date,$checkout_date, $_SESSION['sv_nightcount'], $total_cost,$hotel_id);
		
		if($offer_price['status']){
			
			$total_cost=$offer_price['discount_price'];
			}
		$_SESSION['tot_roomprice'] 		= $total_cost;
		$this->extrasArr = array_filter($_POST['extras']);	
		if(isset($_SESSION['listExtraService'])) unset($_SESSION['listExtraService']);
		if(count($this->extrasArr) > 0){   
			$this->getExrtaServices();
			
			$total_cost = $total_cost + $this->totalextraprices ;	
			
		}
		
		if($extra_price>0)
		{
		$_SESSION['extra_price']=$extra_price;
		}
		$total_cost=$total_cost+$extra_price;
		//echo $total_cost;die;
		$month_num = intval(substr($checkin_date, 5, 2)) ;
		$sql = mysql_query("SELECT * FROM bsi_deposit_discount WHERE month_num = ".$month_num);
		$discountpercent = mysql_fetch_assoc($sql);
		if($discountpercent['discount_percent'] > 0)
		{		
		$discount_amount=$total_cost*$discountpercent['discount_percent']/100;
		$total_cost_after_discount=$total_cost-$discount_amount;
		$_SESSION['discount_amount']=$discount_amount;
		}else{
		$total_cost_after_discount=$total_cost;
		}
		$tax = $total_cost_after_discount*$bsiCore->config['conf_tax_amount']/100;		
		$grandtotal = $total_cost_after_discount+$tax;
		$_SESSION['checkin_date']=$checkin_date;
		$_SESSION['tax'] 		= $tax;
		$_SESSION['total_cost'] = $total_cost;		
		$_SESSION['total_cost_after_discount']=$total_cost_after_discount;
		$_SESSION['grandtotal'] = $grandtotal;

		
		$month_num = intval(substr($checkin_date, 5, 2)) ;
		$sql = mysql_query("SELECT * FROM bsi_deposit_discount WHERE month_num = ".$month_num);
		$depositepercent = mysql_fetch_assoc($sql);
		if($depositepercent['deposit_percent'] > 0){
		
		$deposite=$grandtotal*$depositepercent['deposit_percent']/100;
		}else{
		$deposite=$grandtotal;
		}
		//echo $deposite;;die;
		$_SESSION['aaaa'] = $deposite;
		


		mysql_query("insert into bsi_bookings (booking_id, hotel_id, checkin_date, checkout_date, client_id, child_count, total_cost,payment_amount,reviewid) values ('".$bookingid."', '".$hotel_id."', '".$checkin_date."', '".$checkout_date."', '0', '".$child_count."', '".$grandtotal."','".$deposite."', '".$reviewid."')");
	}

	public function roombooking($booking_id,$roomTypeId,$availableroomid, $noofroom){		
		$availableroomidArray=explode('#',$availableroomid);
		for($i=0; $i<$noofroom; $i++){
			$roomid=$availableroomidArray[$i];
	   		mysql_query("insert into bsi_reservation (booking_id, room_id, roomtype_id) values ('".$booking_id."', '".$roomid."', '".$roomTypeId."')");
		}
		return true;;
	}
}
?>