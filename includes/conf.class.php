<?php 
/**
* @package BSI
* @author BestSoft Inc see README.php
* @copyright BestSoft Inc.
* See COPYRIGHT.php for copyright notices and details.
*/
//session_start();

$bsiCore = new bsiHotelCore;
class bsiHotelCore{
	public $config = array();
	public $userDateFormat = "";		
	function bsiHotelCore(){		
		$this->getBSIConfig();
		$this->getUserDateFormat();		 
	}	 
	
	private function getBSIConfig(){
		$sql = mysql_query("SELECT conf_id, IFNULL(conf_key, false) AS conf_key, IFNULL(conf_value,false) AS conf_value FROM bsi_configure");
		while($currentRow = mysql_fetch_assoc($sql)){
			if($currentRow["conf_key"]){
				if($currentRow["conf_value"]){
					$this->config[trim($currentRow["conf_key"])] = trim($currentRow["conf_value"]);
				}else{
					$this->config[trim($currentRow["conf_key"])] = false;
				}
			}
		}
		mysql_free_result($sql);	
	}
	
	public function getMySqlDate($date){
		if($date == "") return "";
		$dateformatter = preg_split("@[/.-]@", $this->config['conf_dateformat']);
		$date_part = preg_split("@[/.-]@", $date);		
		$date_array = array();		
		for($i=0; $i<3; $i++) {
			$date_array[$dateformatter[$i]] = $date_part[$i];
		}
		return $date_array['yy']."-".$date_array['mm']."-".$date_array['dd'];
	}	
	
	public function clearExpiredBookings(){	
	//echo "here";die;
		$sql = mysql_query("SELECT booking_id FROM bsi_bookings WHERE payment_success = false AND ((NOW() - booking_time) > ".intval($this->config['conf_booking_exptime'])." )");
		while($currentRow = mysql_fetch_assoc($sql)){			
			mysql_query("DELETE FROM bsi_invoice WHERE booking_id = '".$currentRow["booking_id"]."'");
			mysql_query("DELETE FROM bsi_reservation WHERE bookings_id = '".$currentRow["booking_id"]."'");	
			mysql_query("DELETE FROM bsi_bookings WHERE booking_id = '".$currentRow["booking_id"]."'");			
		}
		mysql_free_result($sql); 
	}		
	
	public function loadPaymentGateways() {			
		$paymentGateways = array();
		$sql = mysql_query("SELECT * FROM bsi_payment_gateway ");
		while($currentRow = mysql_fetch_assoc($sql)){	
			$paymentGateways[$currentRow["gateway_code"]] = array('name'=>$currentRow["gateway_name"], 'account'=>$currentRow["account"]);	 
		}
		mysql_free_result($sql);
		return $paymentGateways;
	}
	
	private function getUserDateFormat(){		
		$dtformatter  = array('dd'=>'%d', 'mm'=>'%m', 'yy'=>'%Y', 'yy'=>'%Y');
		$dtformatter1 = array('dd'=>'d', 'mm'=>'m', 'yyyy'=>'Y', 'yy'=>'Y');		
		$dtformat = preg_split("@[/.-]@", $this->config['conf_dateformat']);
		$dtseparator = ($dtformat[0] === 'yyyy')? substr($this->config['conf_dateformat'], 4, 1) : substr($this->config['conf_dateformat'], 2, 1);
		$this->userDateFormat = $dtformatter[$dtformat[0]].$dtseparator.$dtformatter[$dtformat[1]].$dtseparator.$dtformatter[$dtformat[2]];
		$this->userDateFormat2 = $dtformatter1[$dtformat[0]].$dtseparator.$dtformatter1[$dtformat[1]].$dtseparator.$dtformatter1[$dtformat[2]];	 	
	}  	
	
	public function UserDateFormat(){		
		$dtformatter  = array('mm/dd/yy'=>'m/d/Y', 'dd/mm/yy'=>'d/m/Y', 'mm-dd-yy'=>'m-d-Y', 'dd-mm-yy'=>'d-m-Y', 'mm.dd.yy'=>'m.d.Y', 'dd.mm.yy'=>'d.m.Y', 'yy-mm-dd'=>'Y-m-d');
		return $dtformatter[trim($this->config['conf_dateformat'])];
	}  	
	
	public function ClearInput($dirty){
		$dirty = mysql_real_escape_string($dirty);
		return $dirty;
	}
	
	public function getweburl(){
		$host_info = pathinfo($_SERVER["PHP_SELF"]);
		if($host_info['dirname']==chr(92))
			$url= "http://".$_SERVER['SERVER_NAME']."/"; 
		else
			$url= "http://".$_SERVER['SERVER_NAME'].$host_info['dirname']."/";
		return $url;
	}
	public function login($login_email, $login_password){
		 $check = mysql_query("select * from bsi_clients where email='".$login_email."' and password='".$login_password."'");
		 if(mysql_num_rows($check)){
			$row2= mysql_fetch_assoc($check);
			$_SESSION['Myname2012']    = $row2['title']." ".$row2['first_name']." ".$row2['surname'];
			$_SESSION['myemail2012']   = $login_email;
			$_SESSION['client_id2012'] = $row2['client_id'];
			$_SESSION['password_2012'] = $login_password;
			$_SESSION['agent']         = 0;
			$_SESSION['client'] = 1;
			return true;
		}else{
			return false; 
		}
	}
	
	public function loginAgent($login_email, $login_password){
		 $check = mysql_query("select * from bsi_agent where email='".$login_email."' and password='".$login_password."'");
		 if(mysql_num_rows($check)){
			$row2= mysql_fetch_assoc($check);
			$_SESSION['Myname2012']	   = $row2['fname']." ".$row2['lname'];
			$_SESSION['myemail2012']   = $login_email;
			$_SESSION['client_id2012'] = $row2['agent_id'];
			$_SESSION['password_2012'] = $login_password;
			$_SESSION['agent']         = 1;
			$_SESSION['client'] == 0;
			return true;
		}else{
			return false;
		}
	}
	
	public function client($clientid){
		$row = mysql_fetch_assoc(mysql_query("select * from bsi_clients where client_id='".$clientid."'"));
		return $row;
			
	}
	
	public function minValuePopulate($mainArray, $capacity){
		$minarrayset=array();
		$remainingarray=array();
		foreach($mainArray as $i => $val){
			
			if($val['adultPerRoom']==$capacity && !isset($tmparray)){
			$tmparray=$val;
			
			}else{
				if($val['adultPerRoom']==$capacity ){
					if ($val['totalPrice'] > $tmparray['totalPrice']){
						$tmparray=$tmparray;
						$remainingarray[]=$val;
					}else{
						$tmparray=$val;
					}
				
				}
			}
		} 
		$minarrayset['min']=$tmparray;
		
		$minarrayset['remainingarray']=$remainingarray;
		return $minarrayset;
	}
	
	public function recommendedBookingList($totalarray3, $noofroom3, $capacity3, $hotelid){
		$recommended            = array();
		$recommendedHtml        = array();
		$mainretrunarray        = array();
		$recommendedPrice       = "";
		$recommendedPricedetilscapacitytitle ="";
		$recommendedPricedetilscapacity ="";
		$recommendedPricedetilsprice ="";
		$recommendedPricedetilschildprice ="";
		$recommendedPrice_Admin = '';
		$recommendedPriceArray2 = array();
		$price_sub_capacity     = 0;
		$roomtype               = '';
		$i                      = 0; 
		/*print_r($totalarray3);
		echo "<pre>";
		$httml='';*/
		
		
			//echo $httml;die;
		/*$remainingarray=array();
		foreach($totalarray3 as $i => $val){
			
			if($val['adultPerRoom']==$capacity && !isset($tmparray)){
			$tmparray=$val;
			
			}else{
				if($val['adultPerRoom']==$capacity ){
					if ($val['totalPrice'] > $tmparray['totalPrice']){
						$tmparray=$tmparray;
						$remainingarray[]=$val;
					}else{
						$tmparray=$val;
					}
				
				}
			}
		} */
			//echo $noofroom3;die;
		while($noofroom3 > 0){
			$minarrayset   = $this->minValuePopulate($totalarray3, $capacity3);
			$minvaluearray = $minarrayset['min'];
					 
			$total_room2   = count(explode('#',$minvaluearray['totalRoomAvailableId']));
			$n3            = $noofroom3;
			$noofroom3     = $noofroom3-$total_room2;
			if($noofroom3 >=0)
				$n = $total_room2;
			else
				$n = $n3;
			//print_r($minvaluearray);die;
			$recommendedPriceArray2[$n] = $minvaluearray;
			if(!empty($minvaluearray)){
			 
			$child_caption ='';
			$childshow='';
				if($minvaluearray['child_price']>0){
					$child_caption='<font color="#00CC00">'.NEW_INCLUDEING_CHILD_PRICE.' ('.$this->get_currency_symbol($_SESSION['sv_currency']).$this->getExchangemoney($minvaluearray['child_price'],$_SESSION['sv_currency']).')</font>';
					$childshow='&amp; <i class="fa fa-child"> x </i>'.$minvaluearray['per_child'].' ';
				}else{
					$child_caption=''; 
					$childshow='';
				}
				
				 
		
			
				$price_sub = $n*$minvaluearray['totalPrice'];		
				$price_sub_capacity+=$price_sub	;	
				$room_typeid=$minvaluearray['roomTypeId'];
				$capacity_id=$minvaluearray['capcityid'];
				
				foreach($totalarray3 as $data){
			$total_room2   = count(explode('#',$data['totalRoomAvailableId']));
			/*$n3            = $noofroom3;
			$noofroom3     = $noofroom3-$total_room2;
			if($noofroom3 >=0)
				$n = $total_room2;
			else
				$n = $n3;*/
			
			$recommendedPrice .='<tr>
			<td>'.$n.' x '.$data['roomTypeName'].'('.$data['capacityTitle'].') '.$this->roomIndicator($total_room2).'</td>
			<!--<td><i class="fa fa-male" title="Adult Occupancy"></i> x '.$data['capcity'].' '.$childshow.'</td>-->
			<td>'.$this->get_currency_symbol($_SESSION['sv_currency']).$this->getExchangemoney($data['totalPrice'],$_SESSION['sv_currency']).'</td>
		</tr>';
			}
				
				/*$recommendedPrice .= '<tr>
			<td>'.$n.' x '.$minvaluearray['roomTypeName'].'('.$minvaluearray['capacityTitle'].') <a href="javascript:void(0)" class="rmanc">'.$this->roomIndicator($total_room2).'</a></td>
			<td><i class="fa fa-male" title="Adult Occupancy"></i> x '.$minvaluearray['capcity'].' '.$childshow.'</td>
			
		</tr>';	*/
				
				$recommendedPrice_Admin.= '<tr>
			<td width="40%">'.$n.' x '.$minvaluearray['roomTypeName'].'('.$minvaluearray['capacityTitle'].') '.$this->roomIndicator($total_room2, 1).'</td>
			<td width="30%" align="center">'.$minvaluearray['capcity'].' '.$childshow.'</td>
			<td width="30%" align="right"> <strong class="price">'.$this->config['conf_currency_symbol'].number_format($price_sub,2).' &nbsp; '.$child_caption.'</strong></td>
		</tr>';	
		$recommendedPricedetilscapacitytitle .='<td>'.$n.' x '.$minvaluearray['roomTypeName'].'('.$minvaluearray['capacityTitle'].') <a href="javascript:void(0)" class="rmanc">'.$this->roomIndicator($total_room2).'</a></td>';
		
		$recommendedPricedetilscapacity.='<td>'.$minvaluearray['capcity'].' '.$childshow.'</td>';
		$recommendedPricedetilsprice =$price_sub;
		$recommendedPricedetilschildprice=$minvaluearray['child_price'];
		
				$totalarray3=$minarrayset['remainingarray'];
			}
			$i++;
		}
		$mainretrunarray['recommendedPrice']       = $recommendedPrice;
		$mainretrunarray['recommendedPriceArray2'] = $recommendedPriceArray2;
		$mainretrunarray['price_sub']              = $price_sub_capacity;
		$mainretrunarray['recommendedPrice_Admin'] = $recommendedPrice_Admin;
		$mainretrunarray['recommendedPricedetilscapacitytitle'] = $recommendedPricedetilscapacitytitle;
		$mainretrunarray['recommendedPricedetilscapacity'] = $recommendedPricedetilscapacity;
		$mainretrunarray['recommendedPricedetilsprice'] = $recommendedPricedetilsprice;
		$mainretrunarray['recommendedPricedetilschildprice'] = $recommendedPricedetilschildprice;
		$mainretrunarray['roomtype_id']       = $room_typeid;
		$mainretrunarray['capacity_id']       = $capacity_id;
		return $mainretrunarray;	  
	}
	
	public function roomIndicator($noOfRoom, $admin=0){
		if($admin){
			if($noOfRoom == 1){
				$html='<span style="background-color:red;"><font color="#FFFFFF">&nbsp;&nbsp;Last room&nbsp;&nbsp;</font></span>';
			}elseif($noOfRoom < 4){
				$html='<span style="background-color:red;"><font color="#FFFFFF">&nbsp;&nbsp;Only '.$noOfRoom.' rooms left&nbsp;&nbsp;</font></span>';
			}else{
				$html='<span style="background-color:green;"><font color="#FFFFFF">&nbsp;&nbsp;Available&nbsp;&nbsp;</font></span>';
			}
		}else{
			if($noOfRoom == 1){
			$html='<a href="javascript:void(0)" class="rmanc"><span class="label labelred">Last room</span></a>';
			}elseif($noOfRoom < 4){
			$html='<a href="javascript:void(0)" class="rmanc"><span class="label labelred">Only '.$noOfRoom.' rooms left</span></a>';
			}else{
				$html='';
			}	
		}
		
		return $html;
	}
	
	public function hotelStar($rating, $admin=0){
		$html="";
		for($i=1; $i <= $rating; $i++){
			if($admin){
				$html.='<img src="../img/star.png" alt="*" />';
			}else{
				$html.='<a class="stars sfull"></a>';
			}
		}
		return $html;
	}
	
	public function hotelStar_bootstarp($rating){
		$html="";
		for($i=1; $i <= $rating; $i++){
			$html.='<i class="fa fa-star"></i>';
		}
		return $html;
	}
	
	
	public function rating_review($hotel_id){
		global $bsiCore;
		$ratingList=array();
		$review_grade=array("Worst", "Poor", "Poor", "Average", "Average", "Average", "Average", "Average", "Good", "Good", "Superb");
		$hotel_id = $this->ClearInput($hotel_id);	
		$query="select * from bsi_hotel_review where hotel_id='".$hotel_id."' and approved = 1";
		$res=mysql_query($query) or die(mysql_error());
		$rating_list="";
		$arr=array();
		$clean_ratio=0;
		$comfort_ratio=0;
		$location_ratio=0;
		$services_ratio=0;
		$staff_ratio=0;
		$value_for_money_ratio=0;
		if(mysql_num_rows($res)){
			while($row=mysql_fetch_assoc($res))
			{
				$score=$row['rating_clean']+$row['rating_comfort']+$row['rating_location']+$row['rating_services']+$row['rating_staff']+$row['rating_value_fr_money'];
				$fracnum=number_format($score/6,2);
				array_push($arr,$fracnum);					
				
				$rating_list.='<tr class="dashed">
				<td class="w14 padded"><b></b><br/>
				<small>'.date("F j, Y", strtotime($row['review_date'])).'</small></td>
				<td class="w12 padded"><p class="comment_good">'.$row['comment_positive'].' </p>
				<p class="comment_bad">'.$row['comment_negetive'].'</p></td>
				<td class="w14 tc padded"><span class="baloon-green"><b>'.$fracnum.'</b></span></td>
				</tr>';
						
				$clean_ratio+=$row['rating_clean'];
				$comfort_ratio+=$row['rating_comfort'];
				$location_ratio+=$row['rating_location'];
				$services_ratio+=$row['rating_services'];
				$staff_ratio+=$row['rating_staff'];
				$value_for_money_ratio+=$row['rating_value_fr_money'];			
			}
			$ratingList['ratingList']=$rating_list;
			$ratingList['totalCount']=$tot=count($arr);
			$ratingList['totalRatio']=$total_ratio=array_sum($arr)/$tot;
			$ratingList['ratiograde']=$review_grade[round($total_ratio)];
			
			$ratingList['rating_for_clean']=$clean_ratio=number_format($clean_ratio/$tot,2);
			$ratingList['rating_for_comfort']=$comfort_ratio=number_format($comfort_ratio/$tot,2);
			$ratingList['rating_for_location']=$location_ratio=number_format($location_ratio/$tot,2);
			$ratingList['rating_for_services']=$services_ratio=number_format($services_ratio/$tot,2);
			$ratingList['rating_for_staff']=$staff_ratio=number_format($staff_ratio/$tot,2);
			$ratingList['rating_for_money']=$value_for_money_ratio=number_format($value_for_money_ratio/$tot,2);
		}else{
			$ratingList['ratingList']=0;
			$ratingList['totalCount']=0;
			$ratingList['totalRatio']=0;
			
			$ratingList['rating_for_clean']=0;
			$ratingList['rating_for_comfort']=0;
			$ratingList['rating_for_location']=0;
			$ratingList['rating_for_services']=0;
			$ratingList['rating_for_staff']=0;
			$ratingList['rating_for_money']=0;
		}
		return $ratingList;
	}
	public function getHotelDetails($hotel_id){
		$row =mysql_fetch_assoc(mysql_query("SELECT bh . * , bco.name FROM `bsi_hotels` AS bh, `bsi_country` AS bco WHERE bco.country_code = bh.country_code AND hotel_id = '".$hotel_id."'"));
		return $row;
	}
	
	public function getCapacity($capacityid){
		$row=mysql_fetch_assoc(mysql_query("select * from bsi_capacity where capacity_id='".$capacityid."'"));
		return $row;
	}
	
	public function paymentGateway($code){
		$row = mysql_fetch_assoc(mysql_query("SELECT gateway_name FROM bsi_payment_gateway where gateway_code='".$code."'"));
		return  $row['gateway_name'];
	}
	
	public function getCountryName($countryCode){
		$row=mysql_fetch_assoc(mysql_query("select * from bsi_country where country_code='".$countryCode."'"));
		return $row['name'];
	}
	
	public function bookingDeatails($bid){
		$row=mysql_fetch_assoc(mysql_query("SELECT bb.*, bh.*, bco.name, bh.phone_number FROM bsi_bookings bb, bsi_hotels bh, bsi_country bco WHERE bb.hotel_id = bh.hotel_id AND bco.country_code = bh.country_code AND bb.booking_id = '".$bid."'")); 
		return $row;
	}	
	//************************Encryption function**********************************************************
	public function encryptCard($creditno){
		$key = 'sdj*sadt63423h&%$@c34234c346v4c43czxcx'; //Change the key here
		$td = mcrypt_module_open('tripledes', '', 'cfb', '');
		srand((double) microtime() * 1000000);
		$iv = mcrypt_create_iv(mcrypt_enc_get_iv_size($td), MCRYPT_RAND);
		$okey = substr(md5($key.rand(0, 9)), 0, mcrypt_enc_get_key_size($td));
		mcrypt_generic_init($td, $okey, $iv);
		$encrypted = mcrypt_generic($td, $creditno.chr(194));
		$code = $encrypted.$iv;
		$code = eregi_replace("'", "\'", $code);
		return $code;
	}
	
	public function decryptCard($code){
		$key = 'sdj*sadt63423h&%$@c34234c346v4c43czxcx'; // use the same key used for encrypting the data
		$td = mcrypt_module_open('tripledes', '', 'cfb', '');
		$iv = substr($code, -8);
		$encrypted = substr($code, 0, -8);
		for ($i = 0; $i < 10; $i++) {
		$okey = substr(md5($key.$i), 0, mcrypt_enc_get_key_size($td));
		mcrypt_generic_init($td, $okey, $iv);
		$decrypted = trim(mdecrypt_generic($td, $encrypted));
		mcrypt_generic_deinit($td);
		$txt = substr($decrypted, 0, -1);
		if (ord(substr($decrypted, -1)) == 194 && is_numeric($txt)) break;
		}
		mcrypt_module_close($td);
		return $txt;
	}
	//userdateformat
	public function formatDateAsUserformat($date1)
	{
		$userformat='';
   $d=date('d',strtotime($date1));
	$m=date('m',strtotime($date1));
	 $y=date('Y',strtotime($date1));
	$userformat=$d.'-'.$m.'-'.$y;
	return $userformat;	
	}
	//getinvoiceinfo	
	public function getInvoiceinfo($bid){
		$invoiceres=mysql_fetch_assoc(mysql_query("select * from bsi_invoice where booking_id='".$bid."'"));			
		return $invoiceres['invoice'];
	}
	public function getBookingInfo($booking_id){
		$row=mysql_fetch_assoc(mysql_query("select bb.booking_id,bb.hotel_id, DATE_FORMAT(bb.checkin_date, '".$this->userDateFormat."') AS
		 					 checkin_date, DATE_FORMAT(bb.checkout_date, '".$this->userDateFormat."') AS checkout_date,DATE_FORMAT(booking_time, '".$this->userDateFormat."') AS booktime,
							 bb.total_cost,bb.payment_amount,bb.client_id,bb.booking_status,bb.booking_time as bt,bb.is_deleted,bb.child_count,bh.hotel_name,bh.address_1,
							 bh.address_2,bh. terms_n_cond,bc.first_name,bc.surname from bsi_bookings
							 as bb,bsi_hotels as bh,bsi_clients as bc where bb.hotel_id=bh.hotel_id and
							 bb.client_id=bc.client_id and booking_id='".$booking_id."'"));
		return $row;
	}
	
	public function getAgentBookingInfo($booking_id){
		$row = mysql_fetch_assoc(mysql_query("select bh.hotel_name, DATE_FORMAT(bb.checkin_date, '".$this->userDateFormat."') AS checkin_date,  DATE_FORMAT(bb.checkout_date, '".$this->userDateFormat."') AS checkout_date, DATE_FORMAT(bb.booking_time, '".$this->userDateFormat."') AS booking_time, bb.total_cost,bb.is_deleted, bb.child_count,bh.hotel_name, concat(bc.fname, ' ' , bc.lname) as agentname, bc.phone, bc.address, bc.zipcode, bco.name, bb.payment_type from bsi_bookings as bb,bsi_hotels as bh,bsi_agent as bc,  bsi_country as bco where bb.hotel_id=bh.hotel_id and bb.client_id=bc.agent_id and bco.country_code=bc.country and bb.agent='1' and booking_id='".$booking_id."'"));
		return $row;
	}
	
	public function getNoOfRoom($booking_id){
		$query="SELECT bc.title,bc.capacity, brt.type_name, count( bc.capacity_id AND brt.type_name ) AS count FROM bsi_capacity AS bc, bsi_room AS br, bsi_roomtype AS brt WHERE br.room_no IN ( SELECT room_id FROM bsi_reservation WHERE booking_id = '".$booking_id."' ) AND br.hotel_id = brt.hotel_id AND br.roomtype_id = brt.roomtype_id AND bc.capacity_id = br.capacity_id GROUP BY bc.capacity_id, brt.type_name";
		//echo $query;die;
		return $query;
	}
	

	public function cancelBooking($booking_id){
	    global $bsiCore;
		global $bsiMail;
		$result	 =	mysql_query("Update bsi_bookings set is_deleted='1' where booking_id='".$booking_id."'");
		$bsiMail = new bsiMail();
		$cust_details = mysql_fetch_assoc(mysql_query("select * from bsi_invoice where booking_id='".$booking_id."'"));
				$email_details = mysql_fetch_assoc(mysql_query("select * from bsi_email_contents where id=2"));
				$cancel_emailBody="Dear ".$cust_details['client_name']."<br>";
				$cancel_emailBody.=html_entity_decode($email_details['email_text'])."<br>";
				$cancel_emailBody.="<b>Your Booking Details:</b><br>".$cust_details['invoice']."<br>";
				$cancel_emailBody.="<b>Regards</b><br>".$bsiCore->config['conf_portal_name']."<BR>".$bsiCore->config['conf_portal_phone']."<br>";
				$bsiMail->sendEMail($cust_details['client_email'], $email_details['email_subject'], $cancel_emailBody);
				
				//$result	 =	mysql_query("Update bsi_bookings set is_deleted='0' where booking_id='".$booking_id."'");
		
	}
	
	public function getMyBookingDetails($client_id){
		$query="select bb.booking_id, bb.hotel_id, DATE_FORMAT(bb.checkin_date, '".$this->userDateFormat."') as checkin_date, DATE_FORMAT(bb.checkout_date, '".$this->userDateFormat."') as checkout_date, checkout_date as chkOut, bb.total_cost,bb.is_deleted,bh.hotel_name from bsi_bookings as bb,bsi_hotels as bh where bb.hotel_id=bh.hotel_id and bb.client_id='".$client_id."'";
		return $query;
	}
		
	public function getAgentBookingDetails($agent_id){
	//echo "select bb.booking_id, bb.hotel_id, DATE_FORMAT(bb.checkin_date, '".$this->userDateFormat."') as checkin_date, DATE_FORMAT(bb.checkout_date, '".$this->userDateFormat."') as checkout_date, checkout_date as end_date, bb.payment_amount, bb.is_deleted, bb.client_id, bh.hotel_name from bsi_bookings as bb,bsi_hotels as bh where bb.hotel_id=bh.hotel_id and bb.agent_id=".$agent_id." and agent='1'";die;
		$query="select bb.booking_id, bb.hotel_id, DATE_FORMAT(bb.checkin_date, '".$this->userDateFormat."') as checkin_date, DATE_FORMAT(bb.checkout_date, '".$this->userDateFormat."') as checkout_date, checkout_date as end_date, bb.payment_amount, bb.is_deleted, bb.client_id, bh.hotel_name from bsi_bookings as bb,bsi_hotels as bh where bb.hotel_id=bh.hotel_id and bb.agent_id=".$agent_id." and agent='1'";
		return $query;
	}
	
	public function loadEmailContent($id) {		
	    $emailContent=array();
		$sql = mysql_query("SELECT * FROM bsi_email_contents WHERE id = ".$id);
		$currentrow = mysql_fetch_assoc($sql);	
		$emailContent =  array('subject'=> $currentrow["email_subject"], 'body'=> $currentrow["email_text"]);			
		mysql_free_result($sql);	
		return  $emailContent;	
	}
	
	
	
	public function gethotelnameDropdown($client_id){
	
	
		$sql		=	mysql_query("SELECT `hotel_id`, `booking_id` FROM `bsi_bookings` WHERE 
						`is_deleted`='0'  and `client_id`='".$client_id."' and  `booking_id` not in (select `booking_id` from `bsi_hotel_review` 
						where `client_id`='".$client_id."')");
		if(mysql_num_rows($sql)){
			
			$row = mysql_fetch_assoc($sql);
				$hotel_name=$this->getHotelName($row['hotel_id']);
				$getHtml= ' <input type="hidden" name="review_hotel_booking" id="review_hotel_booking" value="review$'.$row['hotel_id'].'$'.$row['booking_id'].'"/>'.$hotel_name['hotel_name'].'('.$row['booking_id'].')'.'';
		}
		return $getHtml;
	}
	
	
	public function getHotelName($hotel_id){	
		$row	=	mysql_fetch_assoc(mysql_query("select * from bsi_hotels where hotel_id='".$hotel_id."'"));
		return $row;
	}
	
	public function deleteRoom($roomtype_id,$capacity_id,$no_of_child,$hotel_id){
		mysql_query("delete from bsi_room where roomtype_id=".$roomtype_id." and capacity_id=".$capacity_id." and no_of_child=".$no_of_child." 
		and hotel_id=".$hotel_id);
	}
	
	public function getAroundCategory($id){
		$row = mysql_fetch_assoc(mysql_query("SELECT bahc.category_title, bah . * , bh.hotel_name FROM bsi_around_hotel_category bahc,
		bsi_around_hotel bah, bsi_hotels bh WHERE bah.hotel_id = bh.hotel_id AND bah.category_id = bahc.category_id AND bah.id ='".$id."'"));
		return $row;
	}
	
	public function getCountry($countrycode){
		$row=mysql_fetch_assoc(mysql_query("select * from bsi_country where country_code='".$countrycode."'"));
		return $row;
	}
	
	public function getAgentList(){
		$sql='select * from bsi_agent';
		return $sql;
	}
	
	public function getAgentrow($aid){
		$row = mysql_fetch_assoc(mysql_query("select * from bsi_agent where agent_id=".$aid));
		return $row;
	} 
	public function emailValidation($emailid){
		$result = mysql_query("select * from bsi_agent where email='".$emailid."'");
		$arrayRow = array();
		if(mysql_num_rows($result)){
			$temp_password = substr(uniqid(), -6, 6);
			$password = $temp_password;
			mysql_query("Update bsi_agent SET password='".md5($password)."' where email='".$emailid."'");
			$row = mysql_fetch_assoc($result);
			$arrayRow['password'] = $temp_password;
			$arrayRow['fname'] 	  = $row['fname'];
			$arrayRow['lname'] 	  = $row['lname'];
			$arrayRow['emailid']  = $row['email'];
			$arrayRow['status'] = true;
			return $arrayRow;	
		}else{
			return $arrayRow['status'] = false;	
		}
	}
	
	public function getguestCorner(){
		$getHTML    =   '<div class="grid_4">
							<div class="box radius">
								<div class="padded">
									<h2 class="gray radius">'.GUEST_CORNER.'</h2>
										<ul>';
										
		$result = mysql_query("SELECT bsc.cont_title as title, bsc2.* FROM `bsi_site_contents` as bsc, `bsi_site_contents` as bsc2 WHERE bsc.id=bsc2.parent_id and bsc.id=6 group by bsc2.cont_title, bsc2.cont_title");
		if(mysql_num_rows($result)){
			while($row = mysql_fetch_assoc($result)){																
				$getHTML   .=                  '<li><a href="index1.php?page='.$row['id'].'">'.$row['cont_title'].'</a></li>'; 
			}
		}
		$getHTML   .= 					'</ul>
									</div>
								</div>
							</div>';
		return $getHTML;
	}
	
	public function getDestination(){
		$sql=mysql_query("select bh.city_name, bc.cou_name, count(*) as noh from bsi_hotels bh, bsi_country bc where
		bh.country_code=bc.country_code  group by city_name");
		$suggestions = '';
		$num = mysql_num_rows($sql); 
		$i = 1;
		while ($row=mysql_fetch_assoc($sql)){
			if($num == $i){	
				$suggestions.= "'".$row['city_name']."'"; 
			}else{
				$suggestions.= "'".$row['city_name']."',";
			}
			$i++;
		}
		return $suggestions;	
	}
	
	public function getfrontGallery(){
		$html = '';
		$td   = 0;
		$result = mysql_query("select * from bsi_gallery where gallery_type='2'");
		while($row = mysql_fetch_assoc($result)){
			$html .= '
			<div>
                    <div class="scrlslider">
                        <div class="scrltext bg2" style="background:url(gallery/'.$row['img_path'].') no-repeat top center">
                        </div>  
                    </div>
                </div>';
		}
		return $html;
	}
	
	public function getGallery(){
		$html = '';
		$td   = 0;
		$result = mysql_query("select * from bsi_gallery where gallery_type='2'");
		while($row = mysql_fetch_assoc($result)){
			$html .= '<div>
                    <div class="scrlslider">
                        <div class="scrltext">
                        	<img src="gallery/'.$row['img_path'].'" style="min-height: 100%; max-width: 100%">
                        </div>  
                    </div>
                </div>';
		}
		return $html;
	}
	
		public function getTopDestination(){
		global $bsiCore;
		$stringCity = '';
		$tstringCity ='';
		$priceArr = array();
		$cityArr  = array();
		$lastarr  = array();
		$distintcityres = mysql_query("select city_name from bsi_hotels group by city_name order by city_name DESC limit 8");
		if(mysql_num_rows($distintcityres)){
			while($row = mysql_fetch_assoc($distintcityres)){
				$hotelidres = mysql_query("select hotel_id,hotel_name,default_img from bsi_hotels where city_name='".$row['city_name']."'");
				if(mysql_num_rows($hotelidres)){ 
					while($rowh = mysql_fetch_assoc($hotelidres)){
					
					
						$priceres = mysql_query("select * from bsi_priceplan where hotel_id=    '".$rowh['hotel_id']."'  and capacity_id!=1001 ");
						$priceArr[$row['city_name']][$rowh['hotel_id']]= array();
						if(mysql_num_rows($priceres)){
							while($rowp = mysql_fetch_assoc($priceres)){
							
								array_push($priceArr[$row['city_name']][$rowh['hotel_id']], $rowp['sun'], $rowp['mon'], $rowp['tue'], $rowp['wed'], $rowp['thu'], $rowp['fri'], $rowp['sat']);
							}
							  
						}
					}
				}
			}
		}
		
		if(!empty($priceArr)){
		
			foreach($priceArr as $city_name => $hotelid){
				$finalArr[$city_name] = array();
				foreach($hotelid as $key => $value){
					$finalArr[$city_name] = array_merge((array)$finalArr[$city_name], (array)$value);
				}
			}
			
		
			if(!empty($finalArr)){
				foreach($finalArr as $ckey => $pvalue){
					sort($pvalue);
					$cityArr[$ckey] = array();
					foreach($pvalue as $val){
					if($val!=0)
						array_push($cityArr[$ckey], $val);
					}
				}
			}
			if(!empty($cityArr)){
				foreach($cityArr as $city => $price){
					if(!empty($price)){
						$lastarr[$city]  = $price[0];
					}
				}
				asort($lastarr);
				foreach($lastarr as $city => $price){
			
		$cityqry=mysql_query("select * from bsi_city where city_name='$city' " );
					$rows=mysql_fetch_assoc($cityqry);
							
							$stringCity .= '<div class="col-md-3 col-sm-6 padb15">

                            	<div class="container-fluid">

                					<div class="row">

                        				<div class="col-md-12 padmarzero tdbox">

                                            <div class="container-fluid">

                								<div class="row">

                        							<div class="col-md-12 col-sm-12 hp-img">';
													if($rows['default_img']!=''){

                                                    	$stringCity .= '<a href="'.$city.'/"><img src="gallery/cityImage/'.$rows['default_img'].'"/></a>';
														}else{
														$stringCity .= '<a href="'.$city.'/"><img src="images/no_photo.jpg"/></a>';
														}
                                            	$stringCity .= '</div>

                                                    <div class="col-md-12 col-sm-12">
													
													<h3 class="hptl"><a href="'.$city.'/">'.mysql_real_escape_string($city).'</a></h3>

                                                    	

                                                        <p class="hp-txt">'.NEW_STARTING_FROM.'  '.$bsiCore->get_currency_symbol($_SESSION['sv_currency']).$bsiCore->getExchangemoney($price, $_SESSION['sv_currency']).'</span></p>

                                            		</div>

                                            	</div>

                                            </div>

                                        </div>

                                    </div>

                                </div>

                            </div>';
					
					
				}
			}
		}
		
		return $stringCity;
	}
	
	public function getHotelDestination(){ 
	    
		$sql=mysql_query("SELECT `city_name` , `country_code` FROM bsi_hotels GROUP BY `city_name` , `country_code`");  
		
		$html = '<select name="destination" id="destination"><option value="All Cities">Select Desination</option>';
		$num = mysql_num_rows($sql); 
		$i = 1;
		while ($row=mysql_fetch_assoc($sql)){
			$row99=mysql_fetch_assoc(mysql_query("select cou_name from bsi_country where country_code='".$row['country_code']."'"));
            $citycoun= $row['city_name'].','.$row99['cou_name'];
			$html.= '<option value="'.$row['city_name'].'">'.$citycoun.'</option>'; 
			$i++;
		}
		$html.= '</select>';
		
		
		return $html;	 
	}
	
	
	public function getfrontHotelDestination(){ 
	    
		$sql=mysql_query("SELECT `city_name` , `country_code` FROM bsi_hotels GROUP BY `city_name` , `country_code`");  
		$html = '<select name="destination" id="destination" class="form-control wdth8" ><option value="All Cities">'.NEW_SELECT_DESTINATION.'</option>';
		$num = mysql_num_rows($sql); 
		$i = 1;
		while ($row=mysql_fetch_assoc($sql)){
			$row99=mysql_fetch_assoc(mysql_query("select cou_name from bsi_country where country_code='".$row['country_code']."'"));
            $citycoun= $row['city_name'].','.$row99['cou_name'];
			$html.= '<option value="'.$row['city_name'].'">'.$citycoun.'</option>'; 
			$i++;
		}
		$html.= '</select>';		
		return $html;	 
	}
	
	
	public function getAgentCombo($agent_id=0){
		$agent    = '<select name="agent_id" id="agent_id"><option value="0">---Select Agent---</option>';
		$agentSql = "select * from `bsi_agent`";
		$result   = mysql_query($agentSql);
		if(mysql_num_rows($result)){
			while($hotelRow=mysql_fetch_assoc($result)){
				if($hotelRow['agent_id'] == $agent_id)
					$agent .="<option value='".$hotelRow['agent_id']."' selected='selected'>".$hotelRow['fname']." ".$hotelRow['lname']."</option>";
				else
					$agent .="<option value='".$hotelRow['agent_id']."'>".$hotelRow['fname']." ".$hotelRow['lname']."</option>";
			}
		}
		$agent .= '</select>';
		return $agent;
	}
	
	
	
	public function personalDetailsEntry(){
		$html = '<div class="row">
                  	  <div class="col-md-4">
                          <div class="form-group ">
                             
                          </div>
                      </div>
                      <div class="col-md-8">
                          <div class="form-group ">
                              
                          </div>
                      </div>
                  </div>
			  
			  <div class="row">
                  	  <div class="col-md-4">
                          <div class="form-group ">
                              <label class="chkdate" for="exampleInputEmail1">'.EMMAIL_ADDRESS.'<span class="strred">*</span></label>
                          </div>
                      </div>
                      <div class="col-md-8">
                          <div class="form-group ">
                              <input type="text" class="form-control roundcorner" name="email" id="email"  required>
                          </div>
                      </div>
                  </div>
				  
				   <div class="row">
                      <div class="col-md-4">
                          <div class="form-group ">
                              <label class="chkdate" for="exampleInputEmail1">'.TITLE.'</label>
                            </div>
                      </div>
                      <div class="col-md-8">
                          <div class="form-group ">
						<select name="title" class="form-control roundcorner">
                    <option value="Mr">'.MR.'</option>
                    <option value="Mrs">'.MRS.'</option>
                    <option value="Dr">'.DR.'</option>
                    <option value="Miss">'.MISS.'</option>
                  </select>
                            </div>
                      </div>
                  </div>  
				  
				  <div class="row">
                      <div class="col-md-4">
                          <div class="form-group">
                              <label class="chkdate" for="exampleInputEmail1">'.FIRSTNAME.' <span class="strred">*</span></label>
                            </div>
                      </div>
                      <div class="col-md-8">
                          <div class="form-group">
                              <input type="text" class="form-control roundcorner" name="firstname" required>
                            </div>
                      </div>
                  </div> 
				  
				   <div class="row">
                      <div class="col-md-4">
                          <div class="form-group">
                              <label class="chkdate" for="exampleInputEmail1">'.LASTNAME.'<span class="strred">*</span></label>
                            </div>
                      </div>
                      <div class="col-md-8">
                          <div class="form-group">
                              <input type="text" class="form-control roundcorner" name="lastname" required>
                            </div>
                      </div>
                  </div>
                  <div class="row">
                      <div class="col-md-4">
                          <div class="form-group">
                              <label class="chkdate" for="exampleInputEmail1">'.ADDRESS_FIRST.' <span class="strred">*</span></label>
                            </div>
                      </div>
                      <div class="col-md-8">
                          <div class="form-group">
                              <input type="text" class="form-control roundcorner"  name="address1" required>
                            </div>
                      </div>
                  </div> 
				  
                  <div class="row">
                      <div class="col-md-4">
                          <div class="form-group">
                              <label class="chkdate" for="exampleInputEmail1">'.ADDRESS_SECOND.' </label>
                            </div>
                      </div>
                      <div class="col-md-8">
                          <div class="form-group">
                              <input type="text" class="form-control roundcorner" name="address2">
                            </div>
                      </div>
                  </div>
				  
				  <div class="row">
                      <div class="col-md-4">
                          <div class="form-group">
                              <label class="chkdate" for="exampleInputEmail1">'.CITY.' <span class="strred">*</span></label>
                            </div>
                      </div>
                      <div class="col-md-8">
                          <div class="form-group">
                              <input type="text" class="form-control roundcorner" name="city" required> 
                            </div>
                      </div>
                  </div>
                  <div class="row">
                      <div class="col-md-4">
                          <div class="form-group">
                              <label class="chkdate" for="exampleInputEmail1">'.STATE.'</label>
                            </div>
                      </div>
                      <div class="col-md-8">
                          <div class="form-group">
                              <input type="text" class="form-control roundcorner" name="state">
                            </div>
                      </div>
                  </div>
                  <div class="row">
                      <div class="col-md-4">
                          <div class="form-group">
                              <label class="chkdate" for="exampleInputEmail1">'.ZIP.'<span class="strred">*</span></label>
                            </div>
                      </div>
                      <div class="col-md-8">
                          <div class="form-group">
                              <input type="text" class="form-control roundcorner"  name="zip" required>
                            </div>
                      </div>
                  </div>
				  
				 <div class="row">
                      <div class="col-md-4">
                          <div class="form-group">
                              <label class="chkdate" for="exampleInputEmail1">'.COUNTRY.'</label>
                            </div>
                      </div>
                      <div class="col-md-8">
                          <div class="form-group">
						  '.$this->countryfront('US').'
						   </div>
                      </div>
                  </div>
				  
                  <div class="row">
                      <div class="col-md-4">
                          <div class="form-group">
                              <label class="chkdate" for="exampleInputEmail1">'.PHONE.' <span class="strred">*</span></label>
                            </div>
                      </div>
                      <div class="col-md-8">
                          <div class="form-group">
                              <input type="text" class="form-control roundcorner" name="phone" required>
                            </div>
                      </div>
            </div>';
			return $html;
	}
	
	public function countryfront($country_code=''){
			$country = '<select name="country" id="country" class="form-control roundcorner">';
			$countrySql = "select * from `bsi_country`";
			$result = mysql_query($countrySql) or die("Error at line : 400".mysql_error());
			while($countryRow=mysql_fetch_assoc($result)){
				if($countryRow['country_code'] == $country_code)
					$country .='<option value="'.$countryRow['country_code'].'" selected="selected">'.$countryRow['name'].'</option>';
				else
					$country .='<option value="'.$countryRow['country_code'].'">'.$countryRow['name'].'</option>';
			}
			$country .= '</select>';
			return $country;
		}
	

	public function personalDetails($name, $email){
		$html = '<div class="row graybox">
                      <div class="col-md-12 col-sm-12 col-xs-12">
					  
                      	<h2 class="settpd">'.PERSONAL_DETAILS.'</h2>
                        
                        <p class="perdetails">'.FULL_NAME_TEXT.' :
                        
                  '.$name.'<br>
                        '.EMAIL_ID_TEXT.' :
                        
                  '.$email.'
               
                        </p>
                       <!-- <div class="row">
    <div class="col-md-4 col-sm-4 col-xs-4">
    <div class="form-group">
    <label class="chkdate" for="exampleInputEmail1">'.FULL_NAME_TEXT.' :</label>
    </div>
    </div>

    <div class="col-md-8 col-sm-8 col-xs-8">
    <div class="form-group">
    <span>
                  '.$name.'</span>
    </div>
    </div>
</div>


 <div class="row">
    <div class="col-md-4 col-sm-4 col-xs-4">
    <div class="form-group">
    <label class="chkdate" for="exampleInputEmail1">'.EMAIL_ID_TEXT.' :</label>
    </div>
    </div>

    <div class="col-md-8 col-sm-8 col-xs-8">
    <div class="form-group">
   <span>
                  '.$email.'
                </span>
    </div>
    </div>
</div>-->
                      </div>
                  </div>';
	  return $html;	
	}
	
	//country
		public function country($country_code=''){
			$country = '<select name="country" id="country"><option value="">select country</option>';
			$countrySql = "select * from `bsi_country`";
			$result = mysql_query($countrySql) or die("Error at line : 400".mysql_error());
			while($countryRow=mysql_fetch_assoc($result)){
				if($countryRow['country_code'] == $country_code)
					$country .='<option value="'.$countryRow['country_code'].'" selected="selected">'.$countryRow['name'].'</option>';
				else
					$country .='<option value="'.$countryRow['country_code'].'">'.$countryRow['name'].'</option>';
			}
			$country .= '</select>';
			return $country;
		}
		//*********************************************************
		
 
     public function getbsilanguage($lcode = ''){ 
	    $flag = array('en' => 'images/English.jpg', 'alb' => 'images/Albanian.jpg', 'de' => 'images/Deutsch.jpg', 'el' => 'images/Greek.jpg', 'es' => 'images/Espanol.jpg', 'fr' => 'images/Francaise.jpg', 'it' => 'images/Italiano.jpg'); 
	  	 
	   $lan="";
	   if($lcode == ''){
		   $default_lang = mysql_fetch_array(mysql_query("select * from `bsi_language` where status=true and `default`=1"));
		   $lcode= $default_lang['lang_code'];
		   $lan="English";
	   }
	   else{
	   	    $current_lang = mysql_fetch_array(mysql_query("select `language` from `bsi_language` where status=true and `lang_code`='".$lcode."'"));
			$lan= $current_lang['language'];
	   }
	   $lcodehtml = '
	  <div class="lan-cont"><div class="languagedv">
	  <img src="'.$flag[$lcode].'"/><p>'.$lan.'</p><i class="caret"></i></div>
	  <div class="lan-dropdown"><ul>     
	  ';
		
	   $lcodeSql = "select * from `bsi_language` where status=true order by lang_order";
	   $result = mysql_query($lcodeSql);
	   while($countryRow = mysql_fetch_assoc($result)){
		  if($lcode == $countryRow['lang_code']){
			   $lcodehtml .='
			   <li class="lactive" id="'.$countryRow['lang_code'].'" onClick="changelan(this.id)">
			   <img src="'.$flag[$countryRow['lang_code']].'"/>
			   <p>'.$countryRow['language'].'</p></li>';
		   }else{
			    $lcodehtml .=' 
			   <li  id="'.$countryRow['lang_code'].'" onClick="changelan(this.id)"> 
			   <img src="'.$flag[$countryRow['lang_code']].'"/>   
			   <p>'.$countryRow['language'].'</p></li>';
		   }
		}
		$lcodehtml .= '</ul></div></div>';
		return $lcodehtml;
   }
   
   
   public function get_currency_combo45($curr_code){
	  $sql=mysql_query("select * from bsi_currency order by currency_code");
	   $a22='<div class="lan-cont">
  <div class="currencydv"> 
    <p>'.$curr_code.'</p>
    <i class="caret"></i></div>
  <div class="curr-dropdown">
    <ul>
	<li class="cactive" id="'.$curr_code.'" onClick="changecurr(this.id)">
        <p>'.$curr_code.'</p>
      </li>
	';
	 while($row=mysql_fetch_assoc($sql)){
		  if($row['currency_code'] != $curr_code){
     
       $a22.='<li  id="'.$row['currency_code'].'" onClick="changecurr(this.id)"> 
        <p>'.$row['currency_code'].'</p>
      </li>';
	  }
	 }
   $a22.='</ul>
  </div>
</div>';
return $a22;
   }
   
   public function getabsbsilanguage($lcode = '',$aurl){ 
   //echo $aurl; die;
	    $flag = array('en' => ''.$aurl.'/images/English.jpg', 'alb' => ''.$aurl.'/images/Albanian.jpg', 'de' => ''.$aurl.'/images/Deutsch.jpg', 'el' => ''.$aurl.'/images/Greek.jpg', 'es' => ''.$aurl.'/images/Espanol.jpg', 'fr' => ''.$aurl.'/images/Francaise.jpg', 'it' => ''.$aurl.'/images/Italiano.jpg'); 
	  	 
	   $lan="";
	   if($lcode == ''){
		   $default_lang = mysql_fetch_array(mysql_query("select * from `bsi_language` where status=true and `default`=1"));
		   $lcode= $default_lang['lang_code'];
		   $lan="English";
	   }
	   else{
	   	    $current_lang = mysql_fetch_array(mysql_query("select `language` from `bsi_language` where status=true and `lang_code`='".$lcode."'"));
			$lan= $current_lang['language'];
	   }
	   $lcodehtml = '
	  <div class="lan-cont"><div class="languagedv">
	  <img src="'.$flag[$lcode].'"/><p>'.$lan.'</p><i class="caret"></i></div>
	  <div class="lan-dropdown"><ul>     
	  ';
		
	   $lcodeSql = "select * from `bsi_language` where status=true order by lang_order";
	   $result = mysql_query($lcodeSql);
	   while($countryRow = mysql_fetch_assoc($result)){
		  if($lcode == $countryRow['lang_code']){
			   $lcodehtml .='
			   <li class="lactive" id="'.$countryRow['lang_code'].'" onClick="changelan(this.id)">
			   <img src="'.$flag[$countryRow['lang_code']].'"/>
			   <p>'.$countryRow['language'].'</p></li>';
		   }else{
			    $lcodehtml .=' 
			   <li  id="'.$countryRow['lang_code'].'" onClick="changelan(this.id)"> 
			   <img src="'.$flag[$countryRow['lang_code']].'"/>   
			   <p>'.$countryRow['language'].'</p></li>';
		   }
		}
		$lcodehtml .= '</ul></div></div>';
		return $lcodehtml;
   }
   
    public function Combine($array1, $array2) {
		$assArray = array();
		$cnt = count($array1);
		for($i=0;$i<$cnt;$i++) {
			$assArray[$i][$array1[$i]] = $array2[$i];
		}
		return $assArray;
    }
	public function checkBookingStatus($bookingid){
		$row = mysql_fetch_assoc(mysql_query("select is_deleted, checkin_date from bsi_bookings where booking_id='".$bookingid."'"));
		return $row;   
    }
	
	public function removesessionVariables($admin=0){
		if(isset($_SESSION['adultperrrom'])){ unset($_SESSION['adultperrrom']); }
		if(isset($_SESSION['childperrrom'])){ unset($_SESSION['childperrrom']); }
		if(isset($_SESSION['recommendedRoomtype'])){ unset($_SESSION['recommendedRoomtype']); }
		if(isset($_SESSION['totalAvailabilityOfHotelFinal'])){ unset($_SESSION['totalAvailabilityOfHotelFinal']); }
		if(isset($_SESSION['availabilityByRoomTypeFinal'])){ unset($_SESSION['availabilityByRoomTypeFinal']); }	
		if(isset($_SESSION['ArrayCntRoom'])){ unset($_SESSION['ArrayCntRoom']); }
		if(isset($_SESSION['hotel_id'])){ unset($_SESSION['hotel_id']); }
		if(isset($_SESSION['bookingId'])){ unset($_SESSION['bookingId']); }
		if(isset($_SESSION['tax'])){ unset($_SESSION['tax']); }
		if(isset($_SESSION['total_cost'])){ unset($_SESSION['total_cost']); }	
		if(isset($_SESSION['grandtotal'])){ unset($_SESSION['grandtotal']); }
		if(isset($_SESSION['RoomType_Capacity_Qty'])){ unset($_SESSION['RoomType_Capacity_Qty']); }
		if(isset($_SESSION['getRoom'])){ unset($_SESSION['getRoom']); }
		if(isset($_SESSION['sv_checkindate'])){ unset($_SESSION['sv_checkindate']); }
		if(isset($_SESSION['sv_checkoutdate'])){ unset($_SESSION['sv_checkoutdate']); }
		if(isset($_SESSION['sv_mcheckindate'])){ unset($_SESSION['sv_mcheckindate']); }
		if(isset($_SESSION['sv_mcheckoutdate'])){ unset($_SESSION['sv_mcheckoutdate']); }
		if(isset($_SESSION['sv_nightcount'])){ unset($_SESSION['sv_nightcount']); }
		if(isset($_SESSION['sv_rooms'])){ unset($_SESSION['sv_rooms']); }
		if(isset($_SESSION['sv_adults'])){ unset($_SESSION['sv_adults']); }
		if(isset($_SESSION['sv_destination'])){ unset($_SESSION['sv_destination']); }
		if(isset($_SESSION['sv_childcount'])){ unset($_SESSION['sv_childcount']); }
		if(isset($_SESSION['adult'])){ unset($_SESSION['adult']); }
		if(isset($_SESSION['selectErr2'])){ unset($_SESSION['selectErr2']); }
		if(isset($_SESSION['selectErr'])){ unset($_SESSION['selectErr']); }	
		if(isset($_SESSION['svars_details'])){ unset($_SESSION['svars_details']); }
		if(isset($_SESSION['payment_gateway'])){ unset($_SESSION['payment_gateway']); }
		if(isset($_SESSION['sv_guestperroom'])){ unset($_SESSION['sv_guestperroom']); }
		if(isset($_SESSION['sv_extrabed'])){ unset($_SESSION['sv_extrabed']); }
		if(isset($_SESSION['dvars_details'])){ unset($_SESSION['dvars_details']); }
		if(isset($_SESSION['dvars_details2'])){ unset($_SESSION['dvars_details2']); }
		if(isset($_SESSION['dv_roomidsonly'])){ unset($_SESSION['dv_roomidsonly']); }
		if(isset($_SESSION['httpRefferer'])){ unset($_SESSION['httpRefferer']); }
		if(isset($_SESSION['cuppon_discount_amount'])){ unset($_SESSION['cuppon_discount_amount']); }
	    if(isset($_SESSION['discountcoupon'])){ unset($_SESSION['discountcoupon']); }
		if(isset($_SESSION['discount_amount'])){ unset($_SESSION['discount_amount']); }
	    if(isset($_SESSION['aaaa'])){ unset($_SESSION['aaaa']); }
	    if(isset($_SESSION['sv_currency'])){ unset($_SESSION['sv_currency']); }
	    if(isset($_SESSION['extra_price'])){ unset($_SESSION['extra_price']); }
		 if(isset($_SESSION['listExtraService'])){ unset($_SESSION['listExtraService']); }
		  if(isset($_SESSION['tot_roomprice'])){ unset($_SESSION['tot_roomprice']); }
			
	
		if($admin){
			if(isset($_SESSION['roomtypeid'])){ unset($_SESSION['roomtypeid']); }
			if(isset($_SESSION['Myname2012'])){ unset($_SESSION['Myname2012']); }
			if(isset($_SESSION['log_msg'])){ unset($_SESSION['log_msg']); }
			if(isset($_SESSION['myemail2012'])){ unset($_SESSION['myemail2012']); }
			if(isset($_SESSION['password_2012'])){ unset($_SESSION['password_2012']); }	
			if(isset($_SESSION['client_id2012'])){ unset($_SESSION['client_id2012']); }
			if(isset($_SESSION['clientLog'])){ unset($_SESSION['clientLog']); }
			if(isset($_SESSION['show'])){ unset($_SESSION['show']); }	
			if(isset($_SESSION['hotelid'])){ unset($_SESSION['hotelid']); }
		}
	}
#*******************************************Version 2.3*************************************************************************

   
   
   public function getCitynameHtml(){
		$cityHtml = '';
		
		$result = mysql_query("select DISTINCT city_name ,country_code from bsi_hotels "); 
		if(mysql_num_rows($result)){
			while($row = mysql_fetch_assoc($result)){
			$countryname = mysql_fetch_assoc(mysql_query("select cou_name from `bsi_country`  where country_code='".$row['country_code']."'"));
				$cityHtml .= '<div class="col-md-12">
                            	<h2 class="sett4" id="'.str_replace(" ", "", $row['city_name']).'">'.$row['city_name'].'  , '.$countryname['cou_name'].'</h2>
                                <div class="container-fluid">';
				$hotelresult = mysql_query("select * from bsi_hotels where city_name='".$row['city_name']."' and status=1");
				if(mysql_num_rows($hotelresult)){
					while($rowh = mysql_fetch_assoc($hotelresult)){
					$cityHtml .= '<div class="row mrb20">
                        				<div class="col-md-12 sernbox">
                                             <div class="container-fluid">
                                                <div class="row">
                                                    <div class="col-md-3 col-sm-3 serimg">
                                                    	<img src="gallery/hotelImage/'.$rowh['default_img'].'" alt=""/>
                                                       
                                                    </div> 
                                                    <div class="col-md-9 col-sm-9">
                                                    	<h3 class="sertl"><a href="'.$rowh['city_name'].'/'.str_replace(" ","-",strtolower(trim($rowh['hotel_name']))).'-'.$rowh['hotel_id'].'.html">'.$rowh['hotel_name'].'</a>
														'.$this->hotelStar($rowh['star_rating']).'
                                                        </h3>
                                                        <p class="sertlul">'.$rowh['address_1'].' '.$rowh['address_2'].', '.$rowh['city_name'].'</p>
                                                        <p class="settxt">'.$rowh['desc_short'].'</p>
                                                    </div>
                                                </div>
                                                
                                                
                                                <div class="clr"></div>
                                             </div>
                                        </div>
                                    </div>';
					
					}
				
				}
				$cityHtml .= ' <div class="container-fluid">
                                       <div class="row">
                                           <div class="col-md-12" style="text-align:center">                                          
                                                <!-- Pagination -->
                                            </div>
                                        </div>
                                    </div>                                    
                                </div>
                            </div>';
				//$k++;
			}  
		}
		return $cityHtml;
   }
   
    public function bt_date_format(){
		  if($this->config['conf_dateformat']=='yy-mm-dd')
		  $df='yy'.$this->config['conf_dateformat'];
		  else
		   $df=$this->config['conf_dateformat'].'yy';
		   
		   return $df;
	  }
	  
	  
	  
	   public function getExchangemoney_update() {
		$sql=mysql_query("select * from bsi_currency where default_c = 0");
		$default2=mysql_fetch_assoc(mysql_query("select * from bsi_currency where default_c = 1"));
		while($row=mysql_fetch_assoc($sql)){
			$amount=1;
			$amount = urlencode($amount);
			$from_Currency = urlencode($default2['currency_code']);
			$to_Currency = urlencode($row['currency_code']);
			$url = "http://www.google.com/finance/converter?a=$amount&from=$from_Currency&to=$to_Currency";
			
			$ch = curl_init();
			$timeout = 0;
			curl_setopt ($ch, CURLOPT_URL, $url);
			curl_setopt ($ch, CURLOPT_RETURNTRANSFER, 1);
			
			curl_setopt ($ch, CURLOPT_USERAGENT,
			"Mozilla/4.0 (compatible; MSIE 8.0; Windows NT 6.1)");
			curl_setopt ($ch, CURLOPT_CONNECTTIMEOUT, $timeout);
			$rawdata = curl_exec($ch);
			curl_close($ch);
			$data = explode('bld>', $rawdata);  
			$data = explode($to_Currency, $data[1]);
			
			$var=round($data[0], 2);
		//return round($var,3);
			mysql_query("update bsi_currency set  exchange_rate ='".$var."' where currency_code='".$row['currency_code']."'");
		}
	}
	  
	  public function getExchangemoney($amount1,$to_Currency1){
	      $row=mysql_fetch_assoc(mysql_query("select * from bsi_currency where currency_code = '".$to_Currency1."'")); 
		  $exchange_rate=$row['exchange_rate'];
		  $amount        = $amount1*$exchange_rate;
		  return number_format($amount,2);
		   //return $amount;
	 }
	 
	  public function getExchange($amount1,$to_Currency1){
	      $row=mysql_fetch_assoc(mysql_query("select * from bsi_currency where currency_code = '".$to_Currency1."'")); 
		  $exchange_rate=$row['exchange_rate'];
		  $amount        = $amount1/$exchange_rate;
		  //return number_format($amount,2);
		  return $amount;
	 }
	 
	 
	 public function currency_symbol(){
		 $default2=mysql_fetch_assoc(mysql_query("select * from bsi_currency where default_c = 1"));
		 return $default2['currency_symbl'];
		 
	 }
	 public function currency_code(){
		 $default2=mysql_fetch_assoc(mysql_query("select * from bsi_currency where default_c = 1"));
		 return $default2['currency_code'];
	 }
	 
	 public function get_currency_symbol($c_code){
		 $default2=mysql_fetch_assoc(mysql_query("select * from bsi_currency where currency_code = '".$c_code."'"));
		 return $default2['currency_symbl'];
	 }  

 public function get_currency_combo3($c_code){
		  
		  $sql=mysql_query("select * from bsi_currency order by currency_code");
		  $combo='<label for="exampleInputEmail1">'.NEW_CURRENCY.':</label>
                         	<select class="form-control roundcorner" name="currency" id="currency">';
		 while($row=mysql_fetch_assoc($sql)){
			  if($row['currency_code'] == $c_code)
			  $combo.='<option value="'.$row["currency_code"].'"  selected="selected">'.$row['currency_code'].'</option>';
			  else
			  $combo.='<option value="'.$row["currency_code"].'">'.$row['currency_code'].'</option>';
		  }
		  $combo.='  </select>
                           
                       ';
	      if(mysql_num_rows($sql) == 1){  
			
			   $combo='<input type="hidden" name="currency" value="'.$this->currency_code().'" />';
		  }
		  
		  return $combo;
	  }
	  
	  
	  public function getPopularHotel(){
		 global $bsiCore;
		$hotelHTML= '';
		$count = 0;

		
		$sql= mysql_query("select * from `bsi_popular_hotel`  limit  4"); 
		 if(mysql_num_rows($sql)){
			while($rows = mysql_fetch_assoc($sql)){
		//echo "select * from `bsi_hotels`  where hotel_id='".$rows['Hotel_id']."'  ";die;
		 $result = mysql_query("select * from `bsi_hotels`  where hotel_id='".$rows['Hotel_id']."' and status=1  "); 
		 if(mysql_num_rows($result)){
			while($row = mysql_fetch_assoc($result)){
				
//******************** Availability Checking 
$capacitysql = mysql_query("SELECT * FROM `bsi_capacity` WHERE hotel_id='".$rows['Hotel_id']."' ");
$capacityrow = mysql_fetch_assoc($capacitysql); 

$ssrsql = mysql_query("SELECT * FROM `bsi_roomtype` WHERE hotel_id='".$rows['Hotel_id']."' and roomtype_name='Short Stay Room' ");
$roomtypeid = mysql_fetch_assoc($ssrsql);

$checkin=date('Y-m-d');
$checkout=date('Y-m-d', strtotime(' +1 day'));
$ssravailable=$this->getAvailableRooms($roomtypeid['roomtype_id'],'Short Stay Room',$capacityrow['capacity_id'],$rows['Hotel_id'],$capacityrow['capacity_id'],$capacityrow['title'],$capacityrow['capacity'],$checkin,$checkout);

$onrsql = mysql_query("SELECT * FROM `bsi_roomtype` WHERE hotel_id='".$rows['Hotel_id']."' and roomtype_name='Overnight Room'");
$onrroomtypeid = mysql_fetch_assoc($onrsql);

$onravailable=$bsiCore->getAvailableRooms($onrroomtypeid['roomtype_id'],'Overnight Room',$capacityrow['capacity_id'],$rows['Hotel_id'],$capacityrow['capacity_id'],$capacityrow['title'],$capacityrow['capacity'],$checkin,$checkout);

$totalavailableroom=$ssravailable['availableroomno']+$onravailable['availableroomno'];

//echo $row['hotel_name']."==".$totalavailableroom;

//array_push($stack,$totalavailableroom);
			

	if($totalavailableroom>0){
		$priceres = mysql_query("select * from bsi_priceplan where hotel_id='".$row['hotel_id']."'  and capacity_id!=1001 ");
		if(mysql_num_rows($priceres)){
			if($count!=2){
			$rowcountry =mysql_fetch_assoc(mysql_query("select * from `bsi_country`   where country_code	='".$row['country_code']."'  ")); 
			$reviewArray=$bsiCore->rating_review($row['hotel_id']);
			if($reviewArray['totalRatio'] != 0){
				$reviewhtml='<span class="index-rate"><span>'.$reviewArray['ratiograde'].'</span>'.number_format($reviewArray['totalRatio'],1).'</span>';
			}else{
				$reviewhtml='';
			}
			$hotelHTML.='
			 <div class="col-md-6 col-sm-6 padb15">
                              <div class="container-fluid">
                            <div class="row">
                                  <div class="col-md-12 padmarzero tdbox">
                                <div class="container-fluid">
                                      <div class="row">
                                    <div class="col-md-12 col-sm-12 hp-img">
                                          <div class="search-image">
                                        <div class="ribbon popular"></div>
                                        
                                        '.$reviewhtml.'
                                        <p class="index-price1">From/Per night</p>
                                        <p class="index-price2">'.$bsiCore->get_currency_symbol($_SESSION['sv_currency']).$bsiCore->getExchangemoney($bsiCore->get_lowest_price_hotel($row['hotel_id']), $_SESSION['sv_currency']).'</p>
                                        <a href="'.$row['city_name'].'/'.str_replace(" ","-",strtolower(trim($row['hotel_name']))).'-'.$row['hotel_id'].'.html"> <img alt="" src="gallery/hotelImage/'.$row['default_img'].'" > </a> </div>
                                        </div>
                                    <div class="col-md-12 col-sm-12">
                                          
										  <p class="hp-txt serrateholder"><a href="'.$row['city_name'].'/'.str_replace(" ","-",strtolower(trim($row['hotel_name']))).'-'.$row['hotel_id'].'.html">'.$row['hotel_name'].'</a>, '.$row['city_name'].'</p>
                                          <p class="itemhome">'.$bsiCore->hotelStar_bootstarp($row['star_rating']).'</p>
                                        </div>
                                  </div>
                                    </div>
                              </div>
                                </div>
                          </div>
                            </div>
			
			';
			$count++;
			}
			}
			
	}
			
			}
			}
			}
		 }
		// print_r($stack);
		 return $hotelHTML;
		 }
		 
		 
		 public function getPopularHotelold(){
		 global $bsiCore;
		$hotelHTML= '';
		
		$sql= mysql_query("select * from `bsi_popular_hotel`  limit  4"); 
		 if(mysql_num_rows($sql)){
			while($rows = mysql_fetch_assoc($sql)){
		//echo "select * from `bsi_hotels`  where hotel_id='".$rows['Hotel_id']."'  ";die;
		 $result = mysql_query("select * from `bsi_hotels`  where hotel_id='".$rows['Hotel_id']."' and status=1  "); 
		 if(mysql_num_rows($result)){
			while($row = mysql_fetch_assoc($result)){
		
		$priceres = mysql_query("select * from bsi_priceplan where hotel_id='".$row['hotel_id']."'  and capacity_id!=1001 ");
		if(mysql_num_rows($priceres)){
			$rowcountry =mysql_fetch_assoc(mysql_query("select * from `bsi_country`   where country_code	='".$row['country_code']."'  ")); 
			$reviewArray=$bsiCore->rating_review($row['hotel_id']);
			if($reviewArray['totalRatio'] != 0){
				$reviewhtml='<span class="index-rate"><span>'.$reviewArray['ratiograde'].'</span>'.$reviewArray['totalRatio'].'</span>';
			}else{
				$reviewhtml='';
			}
			$hotelHTML.='
			 <div class="col-md-6 col-sm-6 padb15">
                              <div class="container-fluid">
                            <div class="row">
                                  <div class="col-md-12 padmarzero tdbox">
                                <div class="container-fluid">
                                      <div class="row">
                                    <div class="col-md-12 col-sm-12 hp-img">
                                          <div class="search-image">
                                        <div class="ribbon popular"></div>
                                        
                                        '.$reviewhtml.'
                                        <p class="index-price1">From/Per night</p>
                                        <p class="index-price2">'.$bsiCore->get_currency_symbol($_SESSION['sv_currency']).$bsiCore->getExchangemoney($bsiCore->get_lowest_price_hotel($row['hotel_id']), $_SESSION['sv_currency']).'</p>
                                        <a href="'.$row['city_name'].'/'.str_replace(" ","-",strtolower(trim($row['hotel_name']))).'-'.$row['hotel_id'].'.html"> <img alt="" src="gallery/hotelImage/'.$row['default_img'].'" > </a> </div>
                                        </div>
                                    <div class="col-md-12 col-sm-12">
                                          
										  <p class="hp-txt serrateholder"><a href="'.$row['city_name'].'/'.str_replace(" ","-",strtolower(trim($row['hotel_name']))).'-'.$row['hotel_id'].'.html">'.$row['hotel_name'].'</a>, '.$row['city_name'].'</p>
                                          <p class="itemhome">'.$bsiCore->hotelStar_bootstarp($row['star_rating']).'</p>
                                        </div>
                                  </div>
                                    </div>
                              </div>
                                </div>
                          </div>
                            </div>
			
			';
			}
			}
			}
			}
		 }
		 return $hotelHTML;
		 }
		 
		 public function getNewListing(){
		 
		/* if(isset($_SESSION['availabilityByRoomTypeFinal'])){
		unset($_SESSION['availabilityByRoomTypeFinal']);	
	}*/
		global $bsiCore;
		$hotelHTML= '';
		 $result = mysql_query("select * from `bsi_hotels` where status=1 ORDER BY hotel_id DESC  limit  2"); 
		 
		 if(mysql_num_rows($result)){
			while($row = mysql_fetch_assoc($result)){
				
				$priceres = mysql_query("select * from bsi_priceplan where hotel_id='".$row['hotel_id']."'  and capacity_id!=1001 ");
				if(mysql_num_rows($priceres)){
			$rowcountry =mysql_fetch_assoc(mysql_query("select * from `bsi_country`   where country_code	='".$row['country_code']."'  "));
			
			$reviewArray=$bsiCore->rating_review($row['hotel_id']);
			if($reviewArray['totalRatio'] != 0){
				$reviewhtml='<span class="index-rate"><span>'.$reviewArray['ratiograde'].'</span>'.number_format($reviewArray['totalRatio'],1).'</span>';
			}else{
				$reviewhtml='';
			}
			
			$hotelHTML.='
			<div class="col-md-6 col-sm-6 padb15">
                              <div class="container-fluid">
                            <div class="row">
                                  <div class="col-md-12 padmarzero tdbox">
                                <div class="container-fluid">
                                      <div class="row">
                                    <div class="col-md-12 col-sm-12 hp-img">
                                          <div class="search-image">
                                        
                                        '.$reviewhtml.'
                                        <p class="index-price1">From/Per night</p>
                                        <p class="index-price2">'.$bsiCore->get_currency_symbol($_SESSION['sv_currency']).$bsiCore->getExchangemoney($bsiCore->get_lowest_price_hotel($row['hotel_id']), $_SESSION['sv_currency']).'</p>
                                        <a href="'.$row['city_name'].'/'.str_replace(" ","-",strtolower(trim($row['hotel_name']))).'-'.$row['hotel_id'].'.html"> <img alt="" src="gallery/hotelImage/'.$row['default_img'].'" > </a> </div>
                                        </div>
                                    <div class="col-md-12 col-sm-12">
                                          
										  <p class="hp-txt serrateholder"><a href="'.$row['city_name'].'/'.str_replace(" ","-",strtolower(trim($row['hotel_name']))).'-'.$row['hotel_id'].'.html">'.$row['hotel_name'].'</a>, '.$row['city_name'].'</p>
                                          <p class="itemhome"> '.$bsiCore->hotelStar_bootstarp($row['star_rating']).' </p>
                                        </div>
                                  </div>
                                    </div>
                              </div>
                                </div>
                          </div>
                            </div>
			
			';
			}
			}
		 }
		 return $hotelHTML;
		 }
		 
		 public function abs_url($abs_path){
			$base_dir  = $abs_path; // Absolute path to your installation, ex: /var/www/mywebsite
			$doc_root  = preg_replace("!{$_SERVER['SCRIPT_NAME']}$!", '', $_SERVER['SCRIPT_FILENAME']); # ex: /var/www
			$base_url  = preg_replace("!^{$doc_root}!", '', $base_dir); # ex: '' or '/mywebsite'
			$protocol  = empty($_SERVER['HTTPS']) ? 'http' : 'https';
			$port      = $_SERVER['SERVER_PORT'];
			$disp_port = ($protocol == 'http' && $port == 80 || $protocol == 'https' && $port == 443) ? '' : ":$port";
			$domain    = $_SERVER['SERVER_NAME'];
			$full_url  = "$protocol://{$domain}{$disp_port}{$base_url}"; # Ex: 'http://example.com', 'https://example.com/mywebsite', etc.
            return $full_url;
		 }
		 
		 
		 public function calculate_offer($checkin, $checkout, $nights, $normal_price, $hotel_id){
			 $offerval=array();
			 $offerval["status"]=false;
			 $sql=mysql_query("SELECT * FROM `bsi_hotel_offer` where  ('".$checkin."' between start_dt and end_dt) and  ('".$checkout."' between start_dt and end_dt) and hotel_id=".$hotel_id." and minimum_nights <= ".$nights."");
			 
			 if(mysql_num_rows($sql)){  
			 $offerval["status"]=true;
			 $row=mysql_fetch_assoc($sql);
			 $offerval["discount_percent"]=$row["discount_percent"];
			 $discount_price= $normal_price - ($normal_price * $row["discount_percent"]/100);
			 $offerval["discount_price"]=$discount_price;
				 
			 }
			 
			 return $offerval;
		 }
		 
		 public function get_lowest_price_hotel($hotel_id){
			 $sql=mysql_query("SELECT * FROM `bsi_priceplan` WHERE `capacity_id` != 1001 and `hotel_id`=".$hotel_id);
			 $stack = array();
			 while($row=mysql_fetch_assoc($sql)){
				 if($row['sun'] != "0.00"){ array_push($stack, $row['sun']); }
				 if($row['mon'] != "0.00"){ array_push($stack, $row['mon']); }
				 if($row['tue'] != "0.00"){ array_push($stack, $row['tue']); }
				 if($row['wed'] != "0.00"){ array_push($stack, $row['wed']); }
				 if($row['thu'] != "0.00"){ array_push($stack, $row['thu']); }
				 if($row['fri'] != "0.00"){ array_push($stack, $row['fri']); }
				 if($row['sat'] != "0.00"){ array_push($stack, $row['sat']); }
			 }
			if(!$stack) 
			 {
				 return 0;
			}else{
				sort($stack);
				return $stack[0];
			}
		 }
		 
		 public function get_max_adult(){
			 $sql=mysql_query("SELECT max(capacity) as max FROM `bsi_capacity`");
			 $row=mysql_fetch_assoc($sql);
			 return $row['max'];
			 
		 }
		 
		 public function get_max_child(){
			 $sql=mysql_query("SELECT max(no_of_child) as max FROM `bsi_room`");
			 $row=mysql_fetch_assoc($sql);
			 return $row['max'];
			 
		 }
		 
public function getAvailableRooms($roomTypeId, $roomTypeName, $capcityid, $hotel_id, $adultPerRoom, $capacityTitle, $capcity ,$mysqlCheckInDate,$mysqlCheckOutDate){ 
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
							  AND (('".$mysqlCheckInDate."' BETWEEN boks.checkin_date AND DATE_SUB(boks.checkout_date, INTERVAL 1 DAY))
							   OR (DATE_SUB('".$mysqlCheckOutDate."', INTERVAL 1 DAY) BETWEEN boks.checkin_date AND DATE_SUB(boks.checkout_date, INTERVAL 1 DAY))
							   OR (boks.checkin_date BETWEEN '".$mysqlCheckInDate."' AND DATE_SUB('".$mysqlCheckOutDate."', INTERVAL 1 DAY))
							   OR (DATE_SUB(boks.checkout_date, INTERVAL 1 DAY) BETWEEN '".$mysqlCheckInDate."' AND DATE_SUB('".$mysqlCheckOutDate."', INTERVAL 1 DAY))))";
		//echo $searchsql;die;
		$sql = mysql_query($searchsql);
		$availableroomno=mysql_num_rows($sql);
		//$searchcorefunc['availableNumberOfRoom']=mysql_num_rows($sql);
	
		$totalRoomAvailableId="";
		while($row = mysql_fetch_assoc($sql)){				
			$totalRoomAvailableId.=$row["room_id"]."#";	
		}
		//print_r($totalRoomAvailableId);
		$arr = explode("#", $totalRoomAvailableId);
		$last = $arr[0];
		
		$searchcorefunc['totalRoomAvailableId']=$totalRoomAvailableId;
		$searchcorefunc['availableroomno']=$availableroomno;
		$searchcorefunc['availablefirstroomid']=$last;
		
		
		return $searchcorefunc;
	}
public function getConfirmDetails($booking_id){
		$paymenthtmt='';
		$sql =mysql_query("SELECT payment_type,payment_txnid,paypal_email FROM `bsi_bookings` WHERE booking_id = '".$booking_id."'");
		$row = mysql_fetch_assoc($sql); 
		$pnamesql =mysql_query("SELECT gateway_name FROM `bsi_payment_gateway` WHERE gateway_code = '".$row['payment_type']."'");
		$pnamerow = mysql_fetch_assoc($pnamesql);
		$paymenthtmt.='<p><strong>Payment Method:</strong>'.$pnamerow['gateway_name'].'</p>';
		if($row['payment_type']=='cc')
		{
		$rowdetail_cc=mysql_fetch_assoc(mysql_query("select * from bsi_cc_info where booking_id ='".$booking_id."'"));
		$paymenthtmt.='
		<p><strong>Card Holder Name :</strong>'.$rowdetail_cc['cardholder_name'].'</p>
		<p><strong>Card Type :</strong>'.$rowdetail_cc['card_type'].'</p>
		<p><strong>Card Number :</strong>'.$this->decryptCard($rowdetail_cc['card_number']).'</p>
		<p><strong>Expiry Date :</strong>'.$rowdetail_cc['expiry_date'].'</p>
		<p><strong>CCV :</strong>'.$rowdetail_cc['ccv2_no'].'</p>';	
		}
		if($row['payment_type']=='pp')
		{
		$paymenthtmt.='
		<p><strong>Payer E-Mail :</strong>'.$row['paypal_email'].'</p>
		<p><strong>Transaction ID :</strong>'.$row['payment_txnid'].'</p>
		';	
		}
		return $paymenthtmt;
	}
	
public function sendtestEMail($to,$sub,$msg, $attachment=0, $flag=0, $admin=0){

//require '../mailer/PHPMailerAutoload.php';
$mail = new PHPMailer;
$mail->isMail();
$mail->SMTPDebug = 0;
$mail->Debugoutput = 'html';
$mail->Host = "smtp.gmail.com";
$mail->Port = 587;
$mail->SMTPSecure = 'tls';
$mail->SMTPAuth = true;
$mail->Username = "info@feelspark.com";
$mail->Password = "Rest2015";
$mail->setFrom('info@feelspark.com', 'feelspark.com');
//$mail->addAddress('ikbal.mondal@bestsoftinc.com', 'John Doe');
//$mail->Subject = 'PHPMailer SMTP test';
//$mail->msgHTML('test');
//$mail->addAttachment('images/phpmailer_mini.png');
if($admin == 1){

			$attachment   = '../data/invoice/voucher_'.$attachment.'.pdf';  	 

		}else{

			$attachment   = 'data/invoice/voucher_'.$attachment.'.pdf';

		}
		
		if($flag == 1){		

			$mail->addAddress($to);
			$mail->Subject = $sub; 
			$mail->msgHTML($msg);	
            $mail->addAttachment($attachment);
		}else{

			$mail->addAddress($to);
			$mail->Subject = $sub; 
			$mail->msgHTML($msg);	

		}



/*$mail->addAddress($to);
$mail->Subject = $sub; 
$mail->msgHTML($msg);*/
//$mail->addAttachment('http://room.com.bd/data/invoice/voucher_RCB1434021758.pdf');
//echo $attachment;die;
//$mail->addAttachment('http://room.com.bd/gallery/1432379285_coxs-bazar-08.jpg');

$mailsend=$mail->send();
return $mailsend;
//echo "emailsend";die;

}
	  
}
?>