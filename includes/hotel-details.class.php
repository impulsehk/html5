<?php
/**
* @package BSI
* @author Best Soft Inc see README.php
* @copyright Best Soft Inc.
* See COPYRIGHT.php for copyright notices and details.
*/
class bsiHotelDetails
{
	public function sendErrorMsg(){		
		$this->errorMsg = "unknown error";	
		echo json_encode(array("errorcode"=>99,"strmsg"=>$this->errorMsg));
	}
	public function getHotelDeatils($hotel_id){	 
		global $bsiCore;
		$hotel_data=array();
	    $row=mysql_fetch_assoc(mysql_query("select bh.*, bc.cou_name, brt.type_name from bsi_hotels bh, bsi_country bc, bsi_roomtype brt where bh.country_code=bc.country_code and  bh.hotel_id=".$bsiCore->ClearInput($hotel_id)));	
		$hotel_data['hotel_name']=$row['hotel_name'];
		$hotel_data['address_1']=$row['address_1'];
		$hotel_data['address_2']=$row['address_2'];
		$hotel_data['city_name']=$row['city_name'];
		$hotel_data['state']=$row['state'];
		$hotel_data['post_code']=$row['post_code'];
		$hotel_data['cou_name']=$row['cou_name'];
		$hotel_data['desc_short']=$row['desc_short'];
		$hotel_data['desc_long']=$row['desc_long'];
		$hotel_data['checking_hour']=$row['checking_hour'];
		$hotel_data['checkout_hour']=$row['checkout_hour'];
		$hotel_data['pets_status']=($row['pets_status'])? 'Pets are allowed.' : 'Pets are NOT allowed.';
		$hotel_data['latitude']=$row['latitude'];
		$hotel_data['longitude']=$row['longitude'];
		$hotel_data['terms_n_cond']=$row['terms_n_cond'];
		$hotel_data['type_name']=$row['type_name'];
		$hotel_data['star_rating']=$row['star_rating'];
		$hotel_data['default_img']=$row['default_img'];
		$hotel_data['hotel_policies']=$row['hotel_policies'];
		return $hotel_data;
	}
	public function saveSubmitReview(){
		global $bsiCore;
		$errorcode = 0;
		$strmsg = "";
		$hotelid = $bsiCore->ClearInput($_POST['hotelid']);		
		$guestname = $bsiCore->ClearInput($_POST['guestname']);	
		$guestemail = $bsiCore->ClearInput($_POST['guestemail']);	
		$rclean = $bsiCore->ClearInput($_POST['rclean']);	
		$rcomfort = $bsiCore->ClearInput($_POST['rcomfort']);	
		$rlocation = $bsiCore->ClearInput($_POST['rlocation']);	
		$rservices = $bsiCore->ClearInput($_POST['rservices']);	
		$rstaff = $bsiCore->ClearInput($_POST['rstaff']);	
		$rvm = $bsiCore->ClearInput($_POST['rvm']);	
		$cpositive = $bsiCore->ClearInput($_POST['cpositive']);	
		$cnegative = $bsiCore->ClearInput($_POST['cnegative']);	
		
		$query=mysql_query("INSERT INTO bsi_hotel_review (hotel_id, guest_name, guest_email,  comment_positive, comment_negetive, rating_clean, rating_comfort, rating_location, rating_services, rating_staff, rating_value_fr_money) VALUES ('".$hotelid."', '".$guestname."', '".$guestemail."','".$cpositive."', '".$cnegative."', '".$rclean."', '".$rcomfort."', '".$rlocation."', '".$rservices."', '".$rstaff."', '".$rvm."')");	
		
		if($query){	
			
			$gethtml = "Successfully your information has been inserted";
			echo json_encode(array("errorcode"=>$errorcode,"strhtml"=>$gethtml));
		
		}else{
			
			$errorcode = 1;
			$strmsg .= "Sorry! no information has been inserted,try again!";
			echo json_encode(array("errorcode"=>$errorcode,"strmsg"=>$strmsg));	
		}
			
	}
	
	public function rating_review($hotel_id){
		global $bsiCore;
		$ratingList=array();
		$review_grade=array("Worst", "Very Poor", "Poor", "Below Average", "Below Average", "Average", "Above Average", "Above Average", "Good", "Very Good", "Superb");
		$hotel_id = $bsiCore->ClearInput($hotel_id);	
		$query="select * from bsi_hotel_review where hotel_id='".$hotel_id."'  and approved=1 "  ;
		$res=mysql_query($query) or die(mysql_error());
		$rating_list="";
		$arr=array();
		$clean_ratio=0;
		$comfort_ratio=0;
		$location_ratio=0;
		$services_ratio=0;
		$staff_ratio=0;
		$value_for_money_ratio=0;
		$numRows=mysql_num_rows($res);
		if($numRows){
			while($row=mysql_fetch_assoc($res)){
				$score=$row['rating_clean']+$row['rating_comfort']+$row['rating_location']+$row['rating_services']+$row['rating_staff']+$row['rating_value_fr_money'];
				$fracnum=number_format($score/6,2);
				array_push($arr,$fracnum);
									
				$clientname = $bsiCore->client($row['client_id']);
				/*$rating_list.='<tr class="dashed">
				<td class="w14 padded"><b>'.$clientname['title'].' '.$clientname['first_name'].' '.$clientname['surname'].'</b><br/>
				<small>'.date("F j, Y", strtotime($row['review_date'])).'</small></td>
				<td class="w12 padded"><p class="comment_good">'.$row['comment_positive'].' </p>
				<p class="comment_bad">'.$row['comment_negetive'].'</p></td>
				<td class="w14 tc padded"><span class="baloon-green"><b>'.$fracnum.'</b></span></td>
				</tr>';*/
				
				
				$rating_list.='<div class="row grdv">
    																<div class="col-md-7 col-sm-7 col-xs-7">
                                                                    	<p class="gestrev">'.$clientname['title'].' '.$clientname['first_name'].' '.$clientname['surname'].'</b><br/>
				<span><small>'.date("F j, Y", strtotime($row['review_date'])).'</small></span></p>
				</div>
				<div class="col-md-3 col-sm-3 col-xs-3">
                                                                    	<p class="gesstar"><span class="gstrpl">&#43;</span>'.$row['comment_positive'].' <br/>
				<span class="gstrminus">&#45;</span>'.$row['comment_negetive'].'</p>
				</div>
                                                                    <div class="col-md-2 col-sm-2 col-xs-2">
                                                                    	<div class="grbl pull-right">'.$fracnum.'</div>
                                                                    </div>
                                                                </div>';
						
				$clean_ratio+=$row['rating_clean'];
				$comfort_ratio+=$row['rating_comfort'];
				$location_ratio+=$row['rating_location'];
				$services_ratio+=$row['rating_services'];
				$staff_ratio+=$row['rating_staff'];
				$value_for_money_ratio+=$row['rating_value_fr_money'];			
			}
			$ratingList['numRows']=$numRows;
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
			$ratingList['numRows']	 =0;
			$ratingList['ratingList']='';
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
	
	public function roomTypeDetails($roomTypeId){
        // echo "select * from bsi_roomtype where roomtype_id=".$roomTypeId;die;
		$sql=mysql_query("select * from bsi_roomtype where roomtype_id=".$roomTypeId);
		return $sql;
	}
	
	public function roomDropDownGen($totalRoom, $roomTypeId, $arrayPos, $pricePerroom){
		global $bsiCore;
		$dropdown='<select name="room_'.$roomTypeId.'_'.$arrayPos.'" id="roomtype_id" class="form-control roundcorner">';
		for($i=0; $i <= $totalRoom; $i++ ){
			
			if($i==0){
				$dropdown.='<option value="'.$i.'">'.$i.'</option>';
			}else{
				//$price=number_format(($pricePerroom*$i),2);
				$price=($pricePerroom*$i);
				/*$dropdown.='<option value="'.$i.'">'.$i.' ( '.$bsiCore->config['conf_currency_symbol'].$price.' )</option>';*/
								
				$dropdown.='<option value="'.$i.'">'.$i.' ('.$bsiCore->get_currency_symbol($_SESSION['sv_currency']).$bsiCore->getExchangemoney($price,$_SESSION['sv_currency']).' )</option>';
			}
		}
		$dropdown.='</select>';
		return $dropdown;
	} 
public function getAroundHoteldetails($hotelid){ 
global $bsiCore;
$getHTML  = '';
$sqlresult = mysql_query("select category_id, category_title from bsi_around_hotel_category where hotel_id=".$hotelid);
$num=mysql_num_rows($sqlresult);
if($num){
$getHTML.= '<div class="container-fluid">
                                            <div class="row">
                                                <div class="col-md-12 sernbox" style="border:1px solid #fcb717;">';
$getHTML .=' <h2 class="sett3">'.NEW_HOTEL_NEARBY.'</h2>
						<div class="container-fluid">
                        <div class="row">
                        <div class="col-md-12">';
while($row = mysql_fetch_assoc($sqlresult)){
$getHTML .='<p class="filter-txt open-down">'.$row['category_title'].' <span class="pull-right fl-plus"><i class="fa fa-minus-square-o"></i></span></p><div class="flt">';
$sqlresult2 = mysql_query("SELECT * FROM `bsi_around_hotel` where category_id = '".$row['category_id']."'");
while($row2 = mysql_fetch_assoc($sqlresult2)){
$getHTML .='
<div  class="row">
<div class="col-md-8 col-sm-8 col-xs-8"><p class="pstl">'.$row2['title'].' </p></div>
<div class="col-md-4 col-sm-4 col-xs-4"><p class="pstl">'.$row2['distance'].' km </p></div>
</div>';
}
$getHTML .='</div>';
}
$getHTML .='</div></div></div></div></div></div>';
}
return $getHTML;
}
	public function getHotelFacilities($hotelid){
		$getHTML = '<table class="table table-condensed graytable">';
		$result = mysql_query("select * from bsi_hotel_facilities where hotel_id='".$hotelid."'");
		//while($row = mysql_fetch_assoc($result)){
		$row = mysql_fetch_assoc($result);
		$getHTML .='
		<tr>
	   <td class="w14 padded" valign="top"><b>'.GENERAL.'</b></td>
	  <td class="w34 padded">'.$row['general'].'</td>
	  </tr>
      <tr>
	 <td class="w14 padded" valign="top"><b>'.ACTIVITIES.'</b></td>
     <td class="w34 padded">'.$row['activities'].'</td>
     </tr>
	<tr>
	<td class="w14 padded" valign="top"><b>'.SERVICES.'</b></td>
	<td class="w34 padded">'.$row['services'].'</td>
	</tr>';
		//}
	$getHTML .='
	</table>';
	return $getHTML;
}
public function getHotelgallery($hotelid, $hotelname,$aurl){
	$html = '';
		$td   = 0;
		$result = mysql_query("select * from bsi_gallery where hotel_id='".$hotelid."'");
		//echo "<tr>";
		while($row = mysql_fetch_assoc($result)){
			$html .= '<li><img src="'.$aurl.'/gallery/hotelImage/'.$row['img_path'].'"/></li>';
		}
		return $html;
	}
	
	public function getguestCorner(){
		$getHTML    =   '<div class="box radius">
								<div class="padded">
									<h2 class="gray radius">Guest Corner</h2>
									<table class="full">
										<tbody>';
										
		$result = mysql_query("SELECT bsc.cont_title as title, bsc2.* FROM `bsi_site_contents` as bsc, `bsi_site_contents` as bsc2 WHERE bsc.id=bsc2.parent_id and bsc.id=6 group by bsc2.cont_title, bsc2.cont_title");
		if(mysql_num_rows($result)){
			while($row = mysql_fetch_assoc($result)){																
				$getHTML   .=                  '<tr><td><a href="index1.php?page='.$row['id'].'">'.$row['cont_title'].'</a></td></tr>';
			}
		}
		$getHTML   .= 					'</tbody>
									</table>
								</div>
							</div>';
		return $getHTML;
	}
	
	public function getNoOfViewers(){
		$rip   = $_SERVER['REMOTE_ADDR'];
		$sd    = time();
		$count = 1;
		$file1 = "data/ip.txt"; 
		$lines = file($file1);
		$line2 = "";
		foreach($lines as $line_num => $line){
			$fp   = strpos($line,'****');
			$nam  = substr($line,0,$fp);
			$sp   = strpos($line,'++++');
			$val  = substr($line,$fp+4,$sp-($fp+4));
			$diff = $sd-$val;
			if($diff < 300 && $nam != $rip){
				 $count = $count+1;
				 $line2 = $line2.$line; 
			}
		}
		$my = $rip."****".$sd."++++\n";
		$open1 = fopen($file1, "w");
		fwrite($open1,"$line2");
		fwrite($open1,"$my");
		fclose($open1);	
		return $count;
	}
	
	public function getRecentBookingInfo($hotelid){
		$result = mysql_query("SELECT booking_time, client_id FROM `bsi_bookings` WHERE hotel_id=".$hotelid." order by booking_id DESC LIMIT 1");	
		$row    = mysql_fetch_assoc($result);
		return $row;
	}
	
	public function gethotelextras($hotelid){
		
		$result = mysql_query("SELECT * FROM `bsi_hotel_extras` where hotel_id=".$hotelid." order by service_price");
		if(mysql_num_rows($result)){
		  $row    = $result;
		}else{
			
			$row='false';
			
		}
		return $row;
	}
	
}
?>