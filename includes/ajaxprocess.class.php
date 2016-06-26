<?php
    session_start();
	class AjaxProcessor
	{
	
		private $errorCode2 = 0;
		private $errorMsg2 = '';
		public function sendErrorMsg(){		 
			$this->errorMsg = "unknown error";	
			echo json_encode(array("errorcode"=>99,"strmsg"=>$this->errorMsg));
		}
		
		public function getRoomCapacity(){
			global $bsiCore;
			$errorcode = 0;
			$htmldiv = '';
			$array=array();
			$room = $bsiCore->ClearInput($_POST['room']);
			for($i=1; $i<=$room; $i++){
			$htmldiv .= '<div style="width:165px; float:left; height:35px;">
          					Rm '.$i.': &nbsp;&nbsp;&nbsp;
          	  				<select id="adults" name="adults[]">
							  <option value="1" selected="selected">1</option>
							  <option value="2" >2</option>
							  <option value="3">3</option>
							  <option value="4">4</option>
							  <option value="5">5</option>
							  <option value="6">6</option>
							  <option value="7">7</option>
							  <option value="8">8</option>
							  <option value="9">9</option>
							  <option value="10">10</option>
							</select>
              				<select id="children" name="children[]" style="float:right;">
							  <option value="0" selected="selected">0</option>
							  <option value="1">1</option>
							  <option value="2">2</option>
							  <option value="3">3</option>
							  <option value="4">4</option>
							</select>
					   </div>';
			}
			
			echo json_encode(array("errorcode"=>$errorcode,"searchCapacity"=>$htmldiv));
    	}
		public function getHotelRoomCapacity(){
			global $bsiCore;
			$errorcode = 0;
			$htmldiv = '';
			$array=array();
			$room = $_POST['room']; 
			for($i=1; $i<=$room; $i++){
				if($room == $i){
					$htmldiv .= '<p class="fl" style="width:50px;">
                    <label class="" for="number_change">
                      '.ADULT.'
                    </label>
                    <br />
                    <select id="adults" name="adults[]">
                      <option value="1" selected="selected">1</option>
                      <option value="2" >2</option>
                      <option value="3">3</option>
                      <option value="4">4</option>
                      <option value="5">5</option>
                      <option value="6">6</option>
                      <option value="7">7</option>
                      <option value="8">8</option>
                      <option value="9">9</option>
                      <option value="10">10</option>
                    </select>
                  </p>
                  <p class="fl" style="width:50px;">
                    <label class="" for="number_change">
                      '.CHILD.'
                    </label>
                    <br />
                    <select id="children" name="children[]">
                      <option value="0" selected="selected">0</option>
                      <option value="1">1</option>
                      <option value="2">2</option>
                      <option value="3">3</option>
                      <option value="4">4</option>
                    </select>
                  </p>';	
				}else{
				$htmldiv .= '<p class="fl" style="width:50px;">
						<label class="" for="number_change">
						  '.ADULT.'
						</label>
						<br />
						<select id="adults" name="adults[]">
						  <option value="1" selected="selected">1</option>
						  <option value="2">2</option>
						  <option value="3">3</option>
						  <option value="4">4</option>
						  <option value="5">5</option>
						  <option value="6">6</option>
						  <option value="7">7</option>
						  <option value="8">8</option>
						  <option value="9">9</option>
						  <option value="10">10</option>
						</select>
					  </p>
					  <p class="fl" style="width:50px;">
						<label class="" for="number_change">
						  '.CHILD.'
						</label>
						<br />
						<select id="children" name="children[]">
						  <option value="0" selected="selected">0</option>
						  <option value="1">1</option>
						  <option value="2">2</option>
						  <option value="3">3</option>
						  <option value="4">4</option>
						</select>
					  </p>
					  <br />';
				}
			}
			
			echo json_encode(array("errorcode"=>$errorcode,"searchCapacity"=>$htmldiv));
    	}
				
	public function saveSubmitReview(){
		global $bsiCore;
		$errorcode = 0;
		$strmsg = "";
		$hotelid_bookingid = $bsiCore->ClearInput($_POST['hotelid_bookingid']);
		$idArray		   = explode("$", $hotelid_bookingid);
		$clientid		   = $bsiCore->ClearInput($_POST['clientid']);		
		$rclean 		   = $bsiCore->ClearInput($_POST['rclean']);	
		$rcomfort		   = $bsiCore->ClearInput($_POST['rcomfort']);	
		$rlocation		   = $bsiCore->ClearInput($_POST['rlocation']);	
		$rservices 		   = $bsiCore->ClearInput($_POST['rservices']);	
		$rstaff 		   = $bsiCore->ClearInput($_POST['rstaff']);	
		$rvm    		   = $bsiCore->ClearInput($_POST['rvm']);	
		$cpositive 		   = $bsiCore->ClearInput($_POST['cpositive']);	
		$cnegative 		   = $bsiCore->ClearInput($_POST['cnegative']);	
		$query=mysql_query("INSERT INTO bsi_hotel_review (hotel_id, booking_id, client_id, comment_positive, comment_negetive, rating_clean, rating_comfort, rating_location, rating_services, rating_staff, rating_value_fr_money, approved) VALUES ('".$idArray[1]."', '".$idArray[2]."', '".$clientid."','".$cpositive."', '".$cnegative."', '".$rclean."', '".$rcomfort."', '".$rlocation."', '".$rservices."', '".$rstaff."', '".$rvm."', '1')");			
		if($query){	
			$gethtml = "Successfully your information has been inserted";
			echo json_encode(array("errorcode"=>$errorcode,"strhtml"=>$gethtml));		
		}else{
			$errorcode = 1;
			$strmsg .= "Sorry! no information has been inserted,try again!";
			echo json_encode(array("errorcode"=>$errorcode,"strmsg"=>$strmsg));	
		}
			
	}
	
	//Submit New Customer
	
	public function updateProfile(){
		
		global $bsiCore;
		$errorcode = 0;
		$strmsg = "";
		$_SESSION['client_id']=0;
		
		$state=$bsiCore->ClearInput($_POST['state']);
		$title=$bsiCore->ClearInput($_POST['title']);
		$firstname=$bsiCore->ClearInput($_POST['firstname']);
		$lastname=$bsiCore->ClearInput($_POST['lastname']);
		$email=$bsiCore->ClearInput($_POST['email']);
		$address1=$bsiCore->ClearInput($_POST['address1']);
		$address2=$bsiCore->ClearInput($_POST['address2']);
		$city=$bsiCore->ClearInput($_POST['city']);
		$zip=$bsiCore->ClearInput($_POST['zip']);
		$country=$bsiCore->ClearInput($_POST['country']);
		$phone=$bsiCore->ClearInput($_POST['phone']);
		
		$query=mysql_query("UPDATE `bsi_clients` SET `first_name` = '".$firstname."', `surname` = '".$lastname."', `title` = '".$title."', `street_addr` = '".$address1."',`street_addr2`='".$address2."', `city` = '".$city."', `province` = '".$state."', `zip` = '".$zip."', `country` = '".$country."', `phone` = '".$phone."', `email` = '".$email."' WHERE `client_id` ='".$_SESSION['client_id2012']."'");
		
		if($query){	
			$_SESSION['Myname2012'] = $title." ".$firstname." ".$lastname;	
			$gethtml = "Your information has been Successfully updated";
			echo json_encode(array("errorcode"=>$errorcode,"strhtml"=>$gethtml));
		
		}else{			
			$errorcode = 1;
			$strmsg .= "Sorry! no information has been updated,try again later!";
			echo json_encode(array("errorcode"=>$errorcode,"strmsg"=>$strmsg));	
		}
		
	}
	//moneyexchange
	public function getExchangemoney(){
		
		global $bsiCore;
		$errorcode     = 0;
		$strmsg        = "";
		$amount        = urlencode($bsiCore->ClearInput($_POST['amount']));
		$from_Currency = urlencode($bsiCore->ClearInput($_POST['from_Currency']));
		$to_Currency   = urlencode($bsiCore->ClearInput($_POST['to_Currency']));
		$url           = "hl=en&q=$amount$from_Currency%3D%3F$to_Currency";
		$rawdata       = file_get_contents("http://google.com/ig/calculator?".$url); 
		$data          = explode('"', $rawdata);
		$data          = explode(' ', $data['3']);
		$var           = $data['0'];
		$pattern       = '/ /';
		$replacement   = '';
		$data          = preg_replace($pattern, $replacement, $var);
		//$data          = number_format($data, '.', 2);
		echo json_encode(array("errorcode"=>$errorcode,"strmsg"=>$data));
	}
	
	//change password
	public function changePassword(){
		
		global $bsiCore;
		$bsiMail   = new bsiMail();
		$errorcode = 0;
		$strmsg    = "";
		$sucess    = 'Your Password Resetted SuccessFully';
		$error     = 'Error message';
		$old_pass  = md5($bsiCore->ClearInput($_POST['old_pass']));
		$new_pass  = md5($bsiCore->ClearInput($_POST['new_pass']));	
		$search    = mysql_query("select * from bsi_clients where client_id='".$_SESSION['client_id2012']."' and password='".$old_pass."'");
				
		if(mysql_num_rows($search)){
			mysql_query("UPDATE `bsi_clients` SET `password` = '".$new_pass."' WHERE `client_id` ='".$_SESSION['client_id2012']."'");
			$row       = $bsiCore->client($_SESSION['client_id2012']);
			$email     = $row['email'];
			$name      = $row['title'].". ".$row['surname'];
			$emailBody = "Hi<br/><br/>".$name."<br/>Your Password is successfully changed.<br/>
			<br/>Email : ".$email."<br/>Password : ".$bsiCore->ClearInput($_POST['new_pass']);			
			$returnMsg = $bsiMail->sendEMail($email, 'Notification of Successful Password Changed', $emailBody);
			echo json_encode(array("errorcode"=>$errorcode,"strhtml"=>$sucess));
		}else{			
			$errorcode = 1;
			echo json_encode(array("errorcode"=>$errorcode,"strmsg"=>$error));	
		}
		
	}
	
	function getContact(){
	
		global $bsiCore;
		$bsiMail      = new bsiMail();
		$errorcode    = 0;
		$strmsg       = "";
		$subject      = $bsiCore->ClearInput($_POST['subject']);
		$name         = $bsiCore->ClearInput($_POST['name']);
		$contactemail = $bsiCore->ClearInput($_POST['contactemail']);
		$phone        = $bsiCore->ClearInput($_POST['phone']);
		$comments     = $bsiCore->ClearInput($_POST['comments']);
		
		$emailBody    = "Hi<br/><br/>".$comments."<br/><br/>Reagrds,<br/>Name : ".$name."<br/>Email : ".$contactemail."<br/>Phone : ".$phone;
		
		$con_subject  = array("booking"=>"Problems booking a Hotel","cancelation"=>"Changing or canceling a reservation","email_issue"=>"Confirmation email issues","registration"=>"Account registration / password issues","price"=>"Price Match Guarantee","upcoming_trip"=>"Questions about an upcoming trip","completed_trip"=>"Issues with a completed trip","web_site_problem"=>"Web site problems","call_center"=>"Call center experience","other"=>"Other");
		
		$newarray_with_key = array_keys($con_subject);
		$return_key        = array_search($subject,$newarray_with_key);
		$subject           = $con_subject[$newarray_with_key[$return_key]];
		$sucess            = '<div class="success">Success message</div>';
		$error             = '<div class="alert">Error message</div>';
		
		$returnMsg = $bsiMail->sendEMail($bsiCore->config['conf_portal_email'], $subject, $emailBody); 
		if($returnMsg == 'Message successfully sent!'){
			echo json_encode(array("errorcode"=>$errorcode,"strhtml"=>$sucess));
		}else{
			echo json_encode(array("errorcode"=>$errorcode,"strhtml"=>$error));
		}
	}
	
		public function insertNews(){
			global $bsiCore;
			$errorcode = 0;
			$strmsg = "";
			
			//echo $email ;die;
			
			$email = mysql_real_escape_string($_POST['email']);
			$result = mysql_query("select * from bsi_newsletter where email='".$email."'");
			if(!mysql_num_rows($result)){
				mysql_query("insert into bsi_newsletter(`email`, `emailTime`) Values ('".$email."', CURDATE())");
				$errorcode = 0;
				$strmsg    = "You are successfully subscribed";
				//$strmsg    ='HOTEL_NAME';
				echo json_encode(array("errorcode"=>$errorcode,"strhtml"=>$strmsg));
			}else{
				$errorcode = 1;
				$strmsg = "Already Subscribed";
				echo json_encode(array("errorcode"=>$errorcode,"strhtml"=>$strmsg));
			}
		}
		
		public function getCCform(){ 
			global $bsiCore;
			$errorcode = 0;
			$strmsg = "";
			$dtHtml = '';
			$yyHtml = '';
			$html = ' 
			<p class="creditcard">Fill Credit Card Information</p>
       <div class="row">
            <div class="col-md-6 col-sm-6">Card holders name</div>
            <div class="col-md-6 col-sm-6">
            <div class="form-group ">
            <input type="text" class="form-control roundcorner">
            </div>
            </div>
       </div>
       <div class="row">
            <div class="col-md-6 col-sm-6">Credit card type</div>
            <div class="col-md-6 col-sm-6">
            <div class="form-group ">
            <select class="form-control roundcorner">
              <option>AmEx</option>
            </select>
            </div>
            </div>
       </div>
       <div class="row">
            <div class="col-md-6 col-sm-6">Credit card number</div>
            <div class="col-md-6 col-sm-6">
            <div class="form-group ">
            <input type="text" class="form-control roundcorner">
            </div>
            </div>
       </div>
       <div class="row">
            <div class="col-md-6 col-sm-6">Expiration date(MM/YYYY)</div>
            <div class="col-md-6 col-sm-6">
            <div class="form-group ">
            <select class="form-control roundcorner" style="width:60px; float:left; margin-right:20px;">
              <option>2</option>
            </select>
            <select class="form-control roundcorner" style="width:80px">
              <option>2015</option>
            </select>
            </div>
            </div>
       </div>
       <div class="row">
            <div class="col-md-6 col-sm-6">CVC-code</div>
            <div class="col-md-6 col-sm-6"><input type="text" class="form-control roundcorner"></div>
       </div>
';	
			echo json_encode(array("errorcode"=>0,"strhtml"=>$html));
		}
		
		
		
		public function getCCformOLD(){ 
			global $bsiCore;
			$errorcode = 0;
			$strmsg = "";
			$dtHtml = '';
			$yyHtml = '';
			$html = '<script type="text/javascript" src="js/jquery.validate.js"></script>
					<script type="text/javascript">
						$(document).ready(function(){
						   $("#checkout").validate({
								rules: {
									cc_holder_name: {
										required: true,
										
									},
									cc_ccv: {
										required: true,
										
									},
									CardNumber: {
										required: true,
										
									}
								},
								messages: {
									cc_holder_name: {
										required: "<font color=\'red\'>This Field Is Required</font>",
										
									},
									cc_ccv: {
										required: "<font color=\'red\'> This Field Is Required</font>",
										
									},
									CardNumber: {
										required: "<font color=\'red\'> This Field Is Required</font>",
										
									}
								}
						  });
					  });	
					</script>
			<table cellpadding="3" cellspacing="0" border="0">
              <tr>
              	 <td width="165px"><p><label for="creditcardholdername">Card holder\'s name</label></p></td>
                 <td><input type="text" value="" name="cc_holder_name" id="cc_holder_name"/></td>
                 <td  class="status"></td>
              </tr>
              <tr>
                <td><p><label for="creditcardtype">Credit card type</label></p></td>
                <td><select name="CardType" id="CardType" class="textbox">
                    <option value="AmEx">AmEx</option>
                    <option value="DinersClub">DinersClub</option>
                    <option value="Discover">Discover</option>
                    <option value="JCB">JCB</option>
                    <option value="Maestro">Maestro</option>
                    <option value="MasterCard">MasterCard</option>
                    <option value="Solo">Solo</option>
                    <option value="Switch">Switch</option>
                    <option value="Visa">Visa</option>
                    <option value="VisaElectron">VisaElectron</option>
                  </select></td>
                <td  class="status"></td>
               </tr>
               <tr>
                <td ><p><label for="creditcardnumber">Credit card number</label></p></td>
                <td><input type="text" value="" name="CardNumber" id="CardNumber" maxlength="16"/></td>
                <td  class="status"></td>
              </tr>
              <tr>             
                <td><p><label for="creditcardexpire">Expiration date(MM/YYYY)</label></p></td>';
                $dtHtml .= '<td><select name="cc_exp_dt" id="cc_exp_dt">';
						$current_month=date('m');
						for($j=1; $j <=12; $j++){
							if($j==$current_month)
								$dtHtml .= '<option value="'.$j.'" selected="selected">'.$j.'</option>';
							else
								$dtHtml .= ' <option value="'.$j.'">'.$j.'</option>';
						}
                    $dtHtml .= '</select>';
					$html .= $dtHtml;
                    $yyHtml .= '<select name="expireyear" id="expireyear">';
						$current_year=date('Y');
						for($i=$current_year; $i <= $current_year+10; $i++){
                      		$yyHtml .= '<option value="'.$i.'">'.$i.'</option>';
                      }
                    $yyHtml .= '</select></td>';
					$html .= $yyHtml;
                    $html .= '<td  class="status"></td>
               </tr>
               <tr>
                <td><p><label for="cvccode">CVC-code</label></p></td>
                <td><input type="text" value="" name="cc_ccv" id="cc_ccv" maxlength="4"/></td>
                <td  class="status"></td>
              </tr>
            </table>';	
			echo json_encode(array("errorcode"=>0,"strhtml"=>$html));
		}
		
		public function agent_updateProfile(){
			global $bsiCore;
			$errorcode = 0;
			$strmsg    = "";
			$state     = mysql_real_escape_string($_POST['state']);
			$firstname = mysql_real_escape_string($_POST['firstname']);
			$lastname  = mysql_real_escape_string($_POST['lastname']);
			$email     = mysql_real_escape_string($_POST['email']);
			$address   = mysql_real_escape_string($_POST['address']);
			$city      = mysql_real_escape_string($_POST['city']);
			$zip       = mysql_real_escape_string($_POST['zip']);
			$country   = mysql_real_escape_string($_POST['country']);
			$phone     = mysql_real_escape_string($_POST['phone']);
			
			$query = mysql_query("UPDATE `bsi_agent` SET `fname` = '".$firstname."', `lname` = '".$lastname."', `address` = '".$address."', `city` = '".$city."', `state` = '".$state."', `zipcode` = '".$zip."', `country` = '".$country."', `phone` = '".$phone."', `email` = '".$email."' WHERE `agent_id` ='".$_SESSION['client_id2012']."'"); 
			
			if($query){		
				$_SESSION['Myname2012'] = $firstname." ".$lastname;		
				$gethtml = "Your information has been Successfully updated";
				echo json_encode(array("errorcode"=>$errorcode,"strhtml"=>$gethtml));
			
			}else{			
				$errorcode = 1;
				$strmsg .= "Sorry! no information has been updated,try again later!";
				echo json_encode(array("errorcode"=>$errorcode,"strmsg"=>$strmsg));	
			}
		}
		
		//change password
		public function agent_changePassword(){
		global $bsiCore;
		$bsiMail   = new bsiMail();
		$errorcode = 0;
		$strhtml    = "";
		$sucess    = 'Your Password Resetted Successfully'; 
		$error     = 'Error message';
		$old_pass  = md5($bsiCore->ClearInput($_POST['old_pass']));
		$new_pass  = md5($bsiCore->ClearInput($_POST['new_pass']));	
		$search    = mysql_query("select * from bsi_agent where agent_id=".$_SESSION['client_id2012']." and password='".$old_pass."'");		
		if(mysql_num_rows($search)){
			mysql_query("UPDATE `bsi_agent` SET `password` = '".$new_pass."' WHERE `agent_id` =".$_SESSION['client_id2012']);
			$row       = $bsiCore->getAgentrow($_SESSION['client_id2012']);
			$email     = $row['email'];
			$name      = $row['fname']." ".$row['lname'];
			$emailBody = "Hi<br/><br/>".$name."<br/>Your Password is successfully changed.<br/>
			<br/>Email : ".$email."<br/>Password : ".$bsiCore->ClearInput($_POST['new_pass']);			
			$returnMsg = $bsiMail->sendEMail($email, 'Notification of Successful Password Changed', $emailBody);
			echo json_encode(array("errorcode"=>$errorcode,"strhtml"=>$sucess));
		}else{			
			$errorcode = 1;
			echo json_encode(array("errorcode"=>$errorcode,"strhtml"=>$error));	
		}
		
		}
		

	public function testapplyCouponDiscount()
{		

		global $bsiCore;	

		$errorCode = 0;
		$errorMsg = "";	
		$orignalPrice = NULL;
		$advamtmodified = false;
		
		if(isset($_SESSION['total_cost'])){
			$orignalPrice = $_SESSION['total_cost'];
			$subtotal=$orignalPrice;		
		}

		$discountcoupon = $bsiCore->ClearInput($_POST['discountcoupon']);		
		$clientemail = $bsiCore->ClearInput($_POST['clientemail']);	
		$agent_id=$bsiCore->ClearInput($_POST['agent']);
		$discount = 0.00;
		$taxamount = 0.00;
		$grandtotal = 0.00;
	
		$promo = mysql_fetch_assoc(mysql_query("SELECT * FROM bsi_promocode WHERE promo_code = '".$discountcoupon."' AND (exp_date IS NULL OR exp_date >= CURDATE())"));		
		
		if(!$promo){
		$errorCode = 1;
		
		//$errorMsg = NEW_CUPPON_MSG1;
		$errorMsg = "Promo Code Expired";			
		}
		
		//$clientemail ='abcdefghxx@abcd.com';
		if($promo["promo_category"] == 2)
		{		
			if($agent_id!=0){
					
			// ***************************************     For agent 
			
			$existingclient = mysql_fetch_assoc(mysql_query("SELECT * FROM `bsi_agent`  WHERE email = '".$clientemail."' "));
			
			}else{
			// ****************************************  For Client
			
			$existingclient = mysql_fetch_assoc(mysql_query("SELECT * FROM bsi_clients WHERE email = '".$clientemail."' "));
			}

			if(!$existingclient)
			{
			$errorCode = 1;
			//$errorMsg = BOOKING_DETAILS_NOT_CUSTOMER;
			$errorMsg = "Not A Customer";
			}
		}
		
		if($promo["promo_category"] == 3){
		if($clientemail != $promo["customer_email"]){
		$errorCode = 1;
		//$errorMsg = BOOKING_DETAILS_EXPIRED_COUPON;
		$errorMsg = "Coupon Expired";
		}
		}
		
		//$subtotal=50; 
		$subtotal=round($subtotal);
		if($subtotal < $promo['min_amount']){
			$errorCode = 1;
		
			$errorMsg = "Your sub total ".$subtotal." is less than the cuppon amount ".$promo['min_amount'];
		}
			
		if($errorCode){   	
		
		//********************************** New Code For Unsuccess  Cuppon **********************************************//
		$grandtotal = $subtotal;

		//*****************************************calculate  for monthly discount 
		$month_num = intval(substr($_SESSION['checkin_date'], 5, 2)) ;
		$sql = mysql_query("SELECT * FROM bsi_deposit_discount WHERE month_num = ".$month_num);
		$discountpercent = mysql_fetch_assoc($sql);		
		if($discountpercent['discount_percent'] > 0){
		

		$discount_amount=$grandtotal*$discountpercent['discount_percent']/100;
		$total_cost_after_discount=$grandtotal-$discount_amount;
				}else{
		$total_cost_after_discount=$grandtotal;	
				}	

		//*****************************************calculate  for tax
		if($bsiCore->config['conf_tax_amount'] > 0){
		
			$taxamount = ($total_cost_after_discount * $bsiCore->config['conf_tax_amount'])/100;		
			$grandtotal = $total_cost_after_discount + $taxamount;
			}else{
			$grandtotal = $total_cost_after_discount ;
			}
			
		
		//*****************************************calculate  for monthly discount 
		$month_num = intval(substr($_SESSION['checkin_date'], 5, 2)) ;
		$sql = mysql_query("SELECT * FROM bsi_deposit_discount WHERE month_num = ".$month_num);
		$discountpercent = mysql_fetch_assoc($sql);		
		if($discountpercent['deposit_percent'] > 0){
		
		
		$total_pay_amount=$grandtotal*$discountpercent['deposit_percent']/100;
		
				}else{
		$total_pay_amount=$grandtotal;	
				}					

		$fmsubtotal		= number_format($subtotal, 2 , '.', ',');
		
		$fmtaxamount	=number_format($bsiCore->getExchangemoney($taxamount,$_SESSION['sv_currency']), 2 , '.', ',');	
	
		$fmgrandtotal	=number_format($bsiCore->getExchangemoney($grandtotal,$_SESSION['sv_currency']), 2 , '.', ',');	
	
		$fmtotal_pay_amount	=number_format($bsiCore->getExchangemoney($total_pay_amount,$_SESSION['sv_currency']), 2 , '.', ',');	
		
		
		/////////////////////////////

		if(isset($_SESSION['total_cost'])){unset($_SESSION['total_cost']);}
		
		if(isset($_SESSION['cuppon_discount_amount'])){unset($_SESSION['cuppon_discount_amount']);}

		if(isset($_SESSION['discountcoupon'])){unset($_SESSION['discountcoupon']);}

		if(isset($_SESSION['total_cost_after_discount'])){unset($_SESSION['total_cost_after_discount']);}	

		if(isset($_SESSION['tax'])){unset($_SESSION['tax'] 	);}

		if(isset($_SESSION['grandtotal'])){unset($_SESSION['grandtotal']);}	
		
		if(isset($_SESSION['aaaa'])){unset($_SESSION['aaaa']);}	

		$_SESSION['total_cost']=$subtotal;
		
		$_SESSION['tax'] 	=$taxamount;
		
		$_SESSION['grandtotal']=$grandtotal ;
		
		$_SESSION['aaaa']=$total_pay_amount;
		
		//***************                                   end                                          ***********//
			
		//echo json_encode(array("errorcode"=>$errorCode,"strmsg"=>$errorMsg));	
		
		echo json_encode(array("errorcode"=>$errorCode,"strmsg"=>$errorMsg,"fmtaxamount"=>$fmtaxamount,"fmgrandtotal"=>$fmgrandtotal,"fmtotal_pay_amount"=>$fmtotal_pay_amount));
		
		
		}else{
		
		if($promo['percentage'] == 1){
			if($promo['discount'] > 0){
				$discountAmount = ($subtotal * $promo["discount"])/100;		
			}						
		}else{
			$discountAmount = $promo["discount"];

		}
	
		$discount=$discountAmount;
		$grandtotal = $subtotal - $discount;

		//*****************************************calculate  for monthly discount 
		$month_num = intval(substr($_SESSION['checkin_date'], 5, 2)) ;
		$sql = mysql_query("SELECT * FROM bsi_deposit_discount WHERE month_num = ".$month_num);
		$discountpercent = mysql_fetch_assoc($sql);		
		if($discountpercent['discount_percent'] > 0){
		

		$discount_amount=$grandtotal*$discountpercent['discount_percent']/100;
		$total_cost_after_discount=$grandtotal-$discount_amount;
				}else{
		$total_cost_after_discount=$grandtotal;	
				}	

		//*****************************************calculate  for tax
		if($bsiCore->config['conf_tax_amount'] > 0){
		
			$taxamount = ($total_cost_after_discount * $bsiCore->config['conf_tax_amount'])/100;		
			$grandtotal = $total_cost_after_discount + $taxamount;
			}else{
			$grandtotal = $total_cost_after_discount ;
			}
			
		
		//*****************************************calculate  for monthly discount 
		$month_num = intval(substr($_SESSION['checkin_date'], 5, 2)) ;
		$sql = mysql_query("SELECT * FROM bsi_deposit_discount WHERE month_num = ".$month_num);
		$discountpercent = mysql_fetch_assoc($sql);		
		if($discountpercent['deposit_percent'] > 0){
		
		
		$total_pay_amount=$grandtotal*$discountpercent['deposit_percent']/100;
		
				}else{
		$total_pay_amount=$grandtotal;	
				}					

		$fmsubtotal		= number_format($subtotal, 2 , '.', ',');
		
		//$fmdiscount	= number_format($discount, 2 , '.', ',');		
		$fmdiscount	=number_format($bsiCore->getExchangemoney($discount,$_SESSION['sv_currency']), 2 , '.', ',');	
		//$fmdiscount_amount 	= number_format($discount_amount, 2 , '.', ',');	
		$fmdiscount_amount	=number_format($bsiCore->getExchangemoney($discount_amount,$_SESSION['sv_currency']), 2 , '.', ',');	
		//$fmtaxamount 	= number_format($taxamount, 2 , '.', ',');	
		$fmtaxamount	=number_format($bsiCore->getExchangemoney($taxamount,$_SESSION['sv_currency']), 2 , '.', ',');	
		//$fmgrandtotal	= number_format($grandtotal, 2 , '.', ',');
		$fmgrandtotal	=number_format($bsiCore->getExchangemoney($grandtotal,$_SESSION['sv_currency']), 2 , '.', ',');	
		//$fmtotal_pay_amount= number_format($total_pay_amount, 2 , '.', ',');
		$fmtotal_pay_amount	=number_format($bsiCore->getExchangemoney($total_pay_amount,$_SESSION['sv_currency']), 2 , '.', ',');	
		
		
		/////////////////////////////

		if(isset($_SESSION['total_cost'])){unset($_SESSION['total_cost']);}

		if(isset($_SESSION['discount_amount'])){unset($_SESSION['discount_amount']);}

		if(isset($_SESSION['total_cost_after_discount'])){unset($_SESSION['total_cost_after_discount']);}	

		if(isset($_SESSION['tax'])){unset($_SESSION['tax'] 	);}

		if(isset($_SESSION['grandtotal'])){unset($_SESSION['grandtotal']);}	
		
		if(isset($_SESSION['aaaa'])){unset($_SESSION['aaaa']);}	


		$_SESSION['total_cost']=$subtotal;
		
		$_SESSION['discountcoupon']=$discountcoupon;
		
		$_SESSION['cuppon_discount_amount']=$discount;
		
		$_SESSION['total_cost_after_discount']=$total_cost_after_discount;
		
		$_SESSION['discount_amount']=$discount_amount;
		
		$_SESSION['tax'] 	=$taxamount;
		
		$_SESSION['grandtotal']=$grandtotal ;
		
		$_SESSION['aaaa']=$total_pay_amount;

		$errorMsg="Couppon Applied Successfully";

		
			
			echo json_encode(array("errorcode"=>$errorCode,"strmsg"=>$errorMsg,"fmdiscount"=>$fmdiscount,"couponcode"=>$discountcoupon,"fmtaxamount"=>$fmtaxamount,"fmgrandtotal"=>$fmgrandtotal,"fmtotal_pay_amount"=>$fmtotal_pay_amount,"fmdiscount_amount"=>$fmdiscount_amount ));
		
		}		


}

		
public function validateLogin()
{ 
		global $bsiCore;
		$errorcode = 0;
		
		$result = mysql_query("select * from bsi_clients where email='".$bsiCore->ClearInput($_POST['email'])."' and password='".md5($bsiCore->ClearInput($_POST['password']))."' ");
		if(mysql_num_rows($result)){
			$row = mysql_fetch_assoc($result);			
			$_SESSION['Myname2012']    = $row['title']." ".$row['first_name']." ".$row['surname'];
			$_SESSION['myemail2012']   = $bsiCore->ClearInput($_POST['email']);
			$_SESSION['client_id2012'] = $row['client_id'];
			$_SESSION['password_2012'] = md5($bsiCore->ClearInput($_POST['password']));
			$_SESSION['agent']= 0;
			$_SESSION['client']=1;
			echo json_encode(array("errorcode"=>$errorcode));
		}else{
			$errorcode = 1;
			echo json_encode(array("errorcode"=>$errorcode));
		}
	}
	
	
	public function forgotPassword(){
		global $bsiCore;
		$errorcode = 0;
		$emailid = mysql_real_escape_string($_POST['email']);
		$result  = mysql_query("select * from bsi_clients where email='".$emailid."'  ");
		if(mysql_num_rows($result)){
			$bsiMail       = new bsimail();
			$temp_password = substr(uniqid(), -6, 6);
			$row           = mysql_fetch_assoc($result);
			mysql_query("update bsi_clients set password='".md5($temp_password)."' where client_id=".$row['client_id']);
			$subject =  " Password reset Confirmation";
			$body    =  "Dear ".$row['first_name']."  ".$row['surname'].",<br><br>" .
						"Your password has been reset, as per your request . <br><br>" .
						"Please find below your new login information <br><br>" .
						"Username: " . $row['email'] . "<br>" .
						"Password: " . $temp_password . "<br><br>" ."Thanking You ";
			$bsiMail->sendEMail($emailid, $subject, $body);	
			echo json_encode(array("errorcode"=>$errorcode));
		}else{
			$errorcode = 1;
			echo json_encode(array("errorcode"=>$errorcode));
		}
	}
	
	public function validateagentLogin(){ 
		global $bsiCore;
		$errorcode = 0;
		$result = mysql_query("select * from bsi_agent where email='".$bsiCore->ClearInput($_POST['email'])."' and password='".md5($bsiCore->ClearInput($_POST['password']))."' ");
		if(mysql_num_rows($result)){
			$row = mysql_fetch_assoc($result);
			
			$_SESSION['Myname2012']	   = $row['fname']." ".$row['lname'];
			$_SESSION['myemail2012']   = $bsiCore->ClearInput($_POST['email']);
			$_SESSION['client_id2012'] = $row['agent_id'];
			$_SESSION['password_2012'] =  md5($bsiCore->ClearInput($_POST['password']));
			$_SESSION['agent']         = 1;
			$_SESSION['client']=0;
			echo json_encode(array("errorcode"=>$errorcode));
		}else{
			$errorcode = 1;
			echo json_encode(array("errorcode"=>$errorcode));
		}
	}
	
	public function forgotagentPassword(){
		global $bsiCore;
		$errorcode = 0;
		$emailid = mysql_real_escape_string($_POST['email']);
		$result  = mysql_query("select * from bsi_agent where email='".$emailid."'  ");
		if(mysql_num_rows($result)){
			$bsiMail       = new bsimail();
			$temp_password = substr(uniqid(), -6, 6);
			$row           = mysql_fetch_assoc($result);
			mysql_query("update bsi_agent set password='".md5($temp_password)."' where agent_id=".$row['agent_id']);
			$subject =  " Your password has been reset";
			$body    =  "Hi,<br><br>" .
						"Your new login information is: <br><br>" .
						"Username: " . $row['email'] . "<br>" .
						"Password: " . $temp_password . "<br><br>" ."Thanking You.";
			$bsiMail->sendEMail($emailid, $subject, $body);	
			echo json_encode(array("errorcode"=>$errorcode));
		}else{
			$errorcode = 1;
			echo json_encode(array("errorcode"=>$errorcode));
		}
	}
	
	
	public function generatecitydrop(){
		    global $bsiCore;
	        $errorcode  = 0;
			$country_code=mysql_real_escape_string($_POST['country_code']);
			$gethtml885='';
		    $cres=mysql_query("select * from bsi_city where country_code='".$country_code."'");
			if(mysql_num_rows($cres)){
			
			 while($row77=mysql_fetch_assoc($cres)){
					  $gethtml885.= '<option value="'.$row77['city_name'].'">'.$row77['city_name'].'</option>';
				 }
			 }
		 echo json_encode(array("errorcode"=>$errorcode,"strmsg"=>$gethtml885));
	}
	
	public function hoteldetailspricecalculate(){
		 global $bsiCore;
		$roomtype_arr=explode("@",mysql_real_escape_string($_POST['rtype_query']));
		$ssr=0;
		$onr=0;
		$hotel_id=mysql_real_escape_string($_POST['hotel_id']);
		$rtype_html="";
		$total_amt=0;
		foreach ($roomtype_arr as $valuer) {
			$rtype_part_val=explode("#",$valuer);
			$row_rt=mysql_fetch_assoc(mysql_query("select * from bsi_roomtype where roomtype_id=".$rtype_part_val[0]));
			
if($row_rt['roomtype_name']=='Short Stay Room')
{
$ssr=$ssr+1;
}else{
$onr=$onr+1;	
}	
			
			$rtype_html.='<div class="row">
							<div class="col-md-7 col-sm-7 col-xs-7">
								  <p class="pstl">'.$row_rt['type_name'].' x '.$rtype_part_val[2].'</p>
								</div>
							<div class="col-md-5 col-sm-5 col-xs-5">
								  <p class="pst3">'.$bsiCore->get_currency_symbol($_SESSION['sv_currency']).$bsiCore->getExchangemoney(($rtype_part_val[3]*$rtype_part_val[2]),$_SESSION['sv_currency']).'</p>
								</div>
						  </div>';
		    $total_amt=$total_amt+($rtype_part_val[3]*$rtype_part_val[2]);
		}
		$extras_html="";
		if($_POST['extras_query']!=""){
			$extras_arr=explode("#",mysql_real_escape_string($_POST['extras_query']));
			foreach ($extras_arr as $valuex) {
				$row_ex=mysql_fetch_assoc(mysql_query("select * from bsi_hotel_extras where id=".$valuex));
				$extras_html.='<div class="row">
							<div class="col-md-7 col-sm-7 col-xs-7">
								  <p class="pstl">'.$row_ex['service_name'].'</p>
								</div>
							<div class="col-md-5 col-sm-5 col-xs-5">
								  <p class="pst3">'.$bsiCore->get_currency_symbol($_SESSION['sv_currency']).$bsiCore->getExchangemoney($row_ex['service_price'],$_SESSION['sv_currency']).'</p>
								</div>
						  </div>';
				$total_amt=$total_amt+$row_ex['service_price'];
			}
		}
		
		$checkin_date  = $_SESSION['sv_mcheckindate'];
		$month_num = intval(substr($checkin_date, 5, 2)) ;
		$sql = mysql_query("SELECT * FROM bsi_deposit_discount WHERE month_num = ".$month_num);
		$depositepercent = mysql_fetch_assoc($sql);
		
		if($ssr>0 && $onr>0)
			{$checkout=$_SESSION['sv_checkoutdate'];}
			if($ssr>0 && $onr==0)
			{$checkout=$_SESSION['sv_checkindate'];}
			if($ssr==0 && $onr>0)
			{$checkout=$_SESSION['sv_checkoutdate'];}
		$checkouthtml='<div class="row">
                       <div class="col-md-7 col-sm-7 col-xs-7">
                       <p class="pstl">Check Out</p>
                       </div>
                       <div class="col-md-5 col-sm-5 col-xs-5">
                       <p class="pst3">'.$checkout.'</p>
                       </div>
                       </div>';
		
		if($depositepercent['deposit_percent'] > 0)
		{
		$deposite=$total_amt*$depositepercent['deposit_percent']/100;
		$advance_amt=$total_amt-$deposite;
		$deposite_html='<div class="row">
							<div class="col-md-7 col-sm-7 col-xs-7">
								  <p class="pstl">Deposite '.$depositepercent['deposit_percent'].' %</p>
								</div>
							<div class="col-md-5 col-sm-5 col-xs-5">
								  <p class="pst3">'.$bsiCore->get_currency_symbol($_SESSION['sv_currency']).$bsiCore->getExchangemoney($deposite,$_SESSION['sv_currency']).'</p>
								</div>
						  </div>
						  
						  <div class="row">
							<div class="col-md-7 col-sm-7 col-xs-7">
								  <p class="pstl">Downpayment Due</p>
								</div>
							<div class="col-md-5 col-sm-5 col-xs-5">
								  <p class="pst3">'.$bsiCore->get_currency_symbol($_SESSION['sv_currency']).$bsiCore->getExchangemoney($advance_amt,$_SESSION['sv_currency']).'</p>
								</div>
						  </div>';
		}else{
		$deposite=$total_amt;
		$deposite_html='';
		}
		//$advance_amt=$total_amt-$deposite;
		$total_amt_html=$bsiCore->get_currency_symbol($_SESSION['sv_currency']).$bsiCore->getExchangemoney($total_amt,$_SESSION['sv_currency']);
		$html=$rtype_html.$extras_html;
		
		 echo json_encode(array("strhtml"=>$html, "total_amt"=>$total_amt_html,"deposite_html"=>$deposite_html,"checkout_html"=>$checkouthtml));
		
	}
	
	
	public function autocompleteSearch(){
		    global $bsiCore;
	        $errorcode  = 0;
			$query=$_POST['query'];
			$mainrray=array();
			
			
			$sql=mysql_query("SELECT bh.city_name, count(*) as count1, bc.cou_name FROM `bsi_hotels`bh, `bsi_country` bc where bh.country_code=bc.country_code and bh.city_name like '%".$query."%'  group by bh.city_name ");
			while($row=mysql_fetch_assoc($sql)){
				$stack = array("label"=>$row['city_name'], "category"=>"Cities", "type"=>"2", "id"=>"", "count"=>$row['count1'], "city"=>"", "country"=>$row['cou_name']);
				array_push($mainrray,$stack);
			}
			
			$sql2=mysql_query("SELECT bh.hotel_name, bh.hotel_id, bh.city_name,  bc.cou_name FROM `bsi_hotels`bh, `bsi_country` bc where bh.country_code=bc.country_code and bh.hotel_name like '%".$query."%'");
			
			while($row2=mysql_fetch_assoc($sql2)){
				$stack = array("label"=>$row2['hotel_name'], "category"=>"Hotels", "type"=>"1", "id"=>$row2['hotel_id'], "count"=>"", "city"=>$row2['city_name'], "country"=>$row2['cou_name']);
				array_push($mainrray,$stack);
			}
			
			$json = json_encode($mainrray);
			print $json;
		
	}
	
public function hotelpanelroomBlocking(){
		global $bsiCore;
		$errorcode = 0;
		$strhtml    = "";
		
		$capacity_id=$bsiCore->ClearInput($_POST['capacityid']);	
		$roomtype_id=$bsiCore->ClearInput($_POST['roomtypeid']);	
		//date_default_timezone_set('America/Los_Angeles');
		$currtime=date('H:i'); 
	if($currtime >='00:00' && $currtime <='05:59'){
		$checkin=date('Y-m-d',strtotime("-1 days"));
		$datformat=date('Y-m-d',strtotime("-1 days"));
		$checkout=date('Y-m-d', strtotime('+1 days', strtotime($datformat)));
	}else{
		$checkin=date('Y-m-d');
		$checkout=date('Y-m-d', strtotime(' +1 day'));
	}
	
	$searchsql = "SELECT rm.room_id, rm.room_no FROM bsi_room rm WHERE rm.roomtype_id = ".$roomtype_id." AND rm.capacity_id = ".$capacity_id." AND rm.room_id NOT IN (SELECT resv.room_id FROM bsi_reservation resv, bsi_bookings boks WHERE boks.is_deleted = FALSE AND resv.booking_id = boks.booking_id AND resv.roomtype_id = ".$roomtype_id." AND (('".$checkin."' BETWEEN boks.checkin_date AND DATE_SUB(boks.checkout_date, INTERVAL 1 DAY)) OR (DATE_SUB('".$checkout."', INTERVAL 1 DAY) BETWEEN boks.checkin_date AND DATE_SUB(boks.checkout_date, INTERVAL 1 DAY)) OR (boks.checkin_date BETWEEN '".$checkin."' AND DATE_SUB('".$checkout."', INTERVAL 1 DAY)) OR (DATE_SUB(boks.checkout_date, INTERVAL 1 DAY) BETWEEN '".$checkin."' AND DATE_SUB('".$checkout."', INTERVAL 1 DAY))))";
			//echo $searchsql;die;				   
		$sql = mysql_query($searchsql);
		$availableroomno=mysql_num_rows($sql);
		//echo $availableroomno;die;
		//$checkin=date('Y-m-d');
		//$checkout=date('Y-m-d', strtotime(' +1 day'));
		if($availableroomno==0) 
	{
		$errorcode = 1;
		$sucess='No Room Available Now ....';
		echo json_encode(array("errorcode"=>$errorcode,"strhtml"=>$sucess));
		
		}else{
		$room_id=$bsiCore->ClearInput($_POST['firstroomid']);
		if($room_id!=""){
		
		$bookingId=$bsiCore->config['conf_bookingid_prefix'].time();
$sql = mysql_query("INSERT INTO bsi_bookings (booking_id, hotel_id, booking_time, checkin_date, checkout_date, client_id, child_count, extra_guest_count, discount_coupon, total_cost, payment_amount, payment_type, special_requests, is_block, payment_success) values('".$bookingId."', ".$_SESSION['hhid'].", NOW(), '".$checkin."', '".$checkout."', '0', 0 , 0, '', '', '', '', '',1, 1)");

$sql = mysql_query("INSERT INTO bsi_reservation (booking_id, room_id, roomtype_id) values('".$bookingId."','".$room_id."','".$roomtype_id."')");			$sucess='1 Room Block Successfully !';
			echo json_encode(array("errorcode"=>$errorcode,"strhtml"=>$sucess));
		}else{
			$errorcode = 1;
			$sucess='No Room Available now !!';
			echo json_encode(array("errorcode"=>$errorcode,"strhtml"=>$sucess));
			}
			
	}
		
		
		}
		
		
public function OLDOLDincreaseRoom(){
		global $bsiCore;
		$errorcode = 0;
		$strhtml    = "";
		$capacity_id=$bsiCore->ClearInput($_POST['capacity_id']);
		$roomtypeid=$bsiCore->ClearInput($_POST['roomtypeid']);	
		$noofroom=$bsiCore->ClearInput($_POST['noofroom']);	
		$availableroomno=$bsiCore->ClearInput($_POST['availableroomno']);
		$availableroomid=$bsiCore->ClearInput($_POST['availableroomid']);
		$noofroom1=$noofroom-$availableroomno;
		$hotel_id=$_SESSION['hhid'];
		if($noofroom1==0)
		{
		$sucess='Please Enter Proper No Of Room(s) !';	
		}else{
		if($noofroom1>0){
		for($r=1;$r<=$noofroom1;$r++)
		{			
		mysql_query("INSERT INTO `bsi_room` (`hotel_id` ,`roomtype_id`, `room_no` ,`capacity_id`,`no_of_child`,`extra_bed` )VALUES ('". $hotel_id."', '".$roomtypeid."','1', '".$capacity_id."', '0','0')") or die("Error at line : 342".mysql_error());
			
		mysql_query("update bsi_room set room_no='".mysql_insert_id()."' where room_id='".mysql_insert_id()."'"); 
		}
		$sucess=$noofroom1.' rooms inserted successfully !';
		
		}else{
			
		$checkin=date('Y-m-d');
		$checkout=date('Y-m-d', strtotime(' +1 day'));
		$bookingId=$bsiCore->config['conf_bookingid_prefix'].time();
	
$sql = mysql_query("INSERT INTO bsi_bookings (booking_id, hotel_id, booking_time, checkin_date, checkout_date, client_id, child_count, extra_guest_count, discount_coupon, total_cost, payment_amount, payment_type, special_requests, is_block, payment_success) values('".$bookingId."', ".$_SESSION['hhid'].", NOW(), '".$checkin."', '".$checkout."', '0', 0 , 0, '', '', '', '', '',1, 1)");
		for($r=0;$r<abs($noofroom1);$r++){
		$arr = explode("#",$availableroomid);
		$first = $arr[$r];

$sql = mysql_query("INSERT INTO bsi_reservation (booking_id, room_id, roomtype_id) values('".$bookingId."','".$first."','".$roomtypeid."')");	
			}
		$sucess=abs($noofroom1).' rooms Blocked successfully !';
		}//die;
		}
		echo json_encode(array("errorcode"=>$errorcode,"strhtml"=>$sucess));
		
		
		}
		
		public function hotelstatus(){
		global $bsiCore;
		$errorcode = 0;
		$strhtml    = "";
		$sucess='true';
		$hotelstaus=$bsiCore->ClearInput($_POST['hotelstaus']);	
		$hotel_id=$_SESSION['hhid'];
		
		$statussql=mysql_query("select status from  bsi_hotels where hotel_id='".$hotel_id."'"); 
		$statusrow = mysql_fetch_assoc($statussql);	
		
		if($statusrow['status']==1){
		$status=0;
		$shtml='OFF';
		}else{
		$status=1;
		$shtml='ON';}
			
		mysql_query("update bsi_hotels set status='".$status."' where hotel_id='".$hotel_id."'"); 
		$hotel_data_map='';
		$icons=array("marker_h.png","marker_h1.png","marker_h2.png","marker_h3.png","marker_h4.png","marker_h5.png");
		$i89=1;
		$hotel_sql = mysql_query("select * from bsi_hotels where status =1");
		$total_rows89= mysql_num_rows($hotel_sql);
		while($row_hotel = mysql_fetch_assoc($hotel_sql)){  
		if($i89==$total_rows89){
			$hotel_data_map.='{"lat":"'.$row_hotel['latitude'].'", "lng":"'.$row_hotel['longitude'].'", "title":"'.$row_hotel['hotel_name'].'", "street":"'.$row_hotel['address_1'].'", "city":"'.$row_hotel['city_name'].'", "zip":"'.$row_hotel['post_code'].'", "url":"http://feelspark.com/'.$row_hotel['city_name'].'/'.str_replace(" ","-",strtolower(trim($row_hotel['hotel_name']))).'-'.$row_hotel['hotel_id'].'.html", "iconset":"'.$icons[$row_hotel['star_rating']].'"}';
		}else{
			$hotel_data_map.='{"lat":"'.$row_hotel['latitude'].'", "lng":"'.$row_hotel['longitude'].'", "title":"'.$row_hotel['hotel_name'].'", "street":"'.$row_hotel['address_1'].'", "city":"'.$row_hotel['city_name'].'", "zip":"'.$row_hotel['post_code'].'", "url":"http://feelspark.com/'.$row_hotel['city_name'].'/'.str_replace(" ","-",strtolower(trim($row_hotel['hotel_name']))).'-'.$row_hotel['hotel_id'].'.html", "iconset":"'.$icons[$row_hotel['star_rating']].'"},'; 
		}
		$hotel_data_map.="\n";
		$i89++;
		}
		
		$myfile = fopen("data/json/homepagemap.json", "w") or die("Unable to open file!");
		
		fwrite($myfile, "[\n");
		fwrite($myfile, $hotel_data_map);
		fwrite($myfile, "]");
		fclose($myfile);
		//$bsiAdminMain->create_map_json();
		
		echo json_encode(array("errorcode"=>$errorcode,"strhtml"=>$shtml));
		
		
		}
		
public function setroomprice(){
		global $bsiCore;
		$errorcode = 0;
		$strhtml    = "";
		//$sucess='';
		$price=$bsiCore->ClearInput($_POST['price']);
		$price_id=$bsiCore->ClearInput($_POST['price_id']);	
		$hotel_id=$_SESSION['hhid'];
		$query=mysql_query("UPDATE `bsi_priceplan` SET `sun` = '".$price."', `mon` = '".$price."', `tue` = '".$price."', `wed` = '".$price."',`thu`='".$price."', `fri` = '".$price."', `sat` = '".$price."' where priceplan_id='".$price_id."' ");
		
		echo json_encode(array("errorcode"=>$errorcode,"strhtml"=>$sucess));
		}
		
public function increaseRoomno(){
		global $bsiCore;
		$errorcode = 0;
		$strhtml    = "";
		$currtime=date('H:i'); 
	if($currtime >='00:00' && $currtime <='05:59'){
		$checkin=date('Y-m-d',strtotime("-1 days"));
		$datformat=date('Y-m-d',strtotime("-1 days"));
		$checkout=date('Y-m-d', strtotime('+1 days', strtotime($datformat)));

	}else{
$checkin=date('Y-m-d');
$checkout=date('Y-m-d', strtotime(' +1 day'));
	}
		//$checkin=date('Y-m-d');
		//$checkout=date('Y-m-d', strtotime('+1 day'));
		$hotel_id=$_SESSION['hhid'];
		$capacity_id=$bsiCore->ClearInput($_POST['capacity_id']);
		$roomtypeid=$bsiCore->ClearInput($_POST['roomtypeid']);	
		$availableroomid=$bsiCore->ClearInput($_POST['availableroomid']);
	
		$search    = mysql_query("select bb.booking_id from bsi_bookings as bb,bsi_reservation as br where bb.is_block='1' and bb.checkin_date='".$checkin."' and bb.checkout_date='".$checkout."' and bb.booking_id=br.booking_id and br.roomtype_id='".$roomtypeid."' ");
		$count=mysql_num_rows($search);	
		if($count>0)
		{ 
			$row=mysql_fetch_assoc($search);
			$delsearch=mysql_query("select id from bsi_reservation where booking_id='".$row['booking_id']."' order by id DESC ");
			$delrow=mysql_fetch_assoc($delsearch);	
			mysql_query("delete from bsi_reservation where id='".$delrow['id']."' ");	
		    $sucess='1 Room release Successfully !';
		
		}else{
		
			mysql_query("INSERT INTO `bsi_room` (`hotel_id` ,`roomtype_id`, `room_no` ,`capacity_id`,`no_of_child`,`extra_bed` )VALUES ('". $hotel_id."', '".$roomtypeid."','1', '".$capacity_id."', '0','0')") or die("Error at line : 342".mysql_error());
			
		    mysql_query("update bsi_room set room_no='".mysql_insert_id()."' where room_id='".mysql_insert_id()."'"); 
		    $sucess='1 Room Added Successfully !';
		
		}
		echo json_encode(array("errorcode"=>$errorcode,"strhtml"=>$sucess));
		}
		
public function OLDincreaseRoom(){
		global $bsiCore;
		$errorcode = 0;
		$strhtml    = "";
		$currtime=date('H:i'); 
	if($currtime >='00:00' && $currtime <='05:59'){
		$checkin=date('Y-m-d',strtotime("-1 days"));
		$datformat=date('Y-m-d',strtotime("-1 days"));
		$checkout=date('Y-m-d', strtotime('+1 days', strtotime($datformat)));

	}else{
$checkin=date('Y-m-d');
$checkout=date('Y-m-d', strtotime(' +1 day'));
	}
		//$checkin=date('Y-m-d');
		//$checkout=date('Y-m-d', strtotime('+1 day'));
		$capacity_id=$bsiCore->ClearInput($_POST['capacity_id']);
		$roomtypeid=$bsiCore->ClearInput($_POST['roomtypeid']);	
		$availableroomid=$bsiCore->ClearInput($_POST['availableroomid']);
		$noofroom=$bsiCore->ClearInput($_POST['noofroom']);
		$hotel_id=$_SESSION['hhid'];
		
		$search = mysql_query("select bb.booking_id from bsi_bookings as bb,bsi_reservation as br where bb.is_block='1' and bb.checkin_date='".$checkin."' and bb.checkout_date='".$checkout."' and bb.booking_id=br.booking_id and br.roomtype_id='".$roomtypeid."' ");
		$blockno=mysql_num_rows($search);	
//*********** Condition 1
		if($noofroom>$blockno)	
		{
		$difference=$noofroom-$blockno;
	//*********** Release all room.
		while($row=mysql_fetch_assoc($search))
		{
			mysql_query("delete from bsi_bookings where booking_id='".$row['booking_id']."' ");
			mysql_query("delete from bsi_reservation where booking_id='".$row['booking_id']."' ");	
		}
	//*********** Add rows in bsi_room for reminding difference.
		for($r=1;$r<=$difference;$r++)
		{			
		mysql_query("INSERT INTO `bsi_room` (`hotel_id` ,`roomtype_id`, `room_no` ,`capacity_id`,`no_of_child`,`extra_bed` )VALUES ('". $hotel_id."', '".$roomtypeid."','1', '".$capacity_id."', '0','0')") or die("Error at line : 342".mysql_error());
			
		mysql_query("update bsi_room set room_no='".mysql_insert_id()."' where room_id='".mysql_insert_id()."'"); 
		}
		$sucess=$difference.' rooms inserted successfully !';
		
		}
//*********** Condition 2
		else if($noofroom<$blockno)
		{
	//******** Release some room.
		$difference=$blockno-$noofroom;	
		for($i=1;i<$difference;$i++)
		{
			while($row=mysql_fetch_assoc($search))
		{
			mysql_query("delete from bsi_bookings where booking_id='".$row['booking_id']."' ");
			mysql_query("delete from bsi_reservation where booking_id='".$row['booking_id']."' ");	
		}			
		}
		$sucess=$difference.' rooms unblock successfully !';		
		}else{

		$bookingId=$bsiCore->config['conf_bookingid_prefix'].time();
$sql = mysql_query("INSERT INTO bsi_bookings (booking_id, hotel_id, booking_time, checkin_date, checkout_date, client_id, child_count, extra_guest_count, discount_coupon, total_cost, payment_amount, payment_type, special_requests, is_block, payment_success) values('".$bookingId."', ".$_SESSION['hhid'].", NOW(), '".$checkin."', '".$checkout."', '0', 0 , 0, '', '', '', '', '',1, 1)");

for($r=0;$r<$noofroom;$r++){
		$arr = explode("#",$availableroomid);
		$first = $arr[$r];
$sql = mysql_query("INSERT INTO bsi_reservation (booking_id, room_id, roomtype_id) values('".$bookingId."','".$first."','".$roomtypeid."')");	
		}
			$sucess=$noofroom.' rooms block successfully !';
			}		
		
		echo json_encode(array("errorcode"=>$errorcode,"strhtml"=>$sucess));
		
		
		}
		
public function increaseRoom(){
		global $bsiCore;
		$errorcode = 0;
		$strhtml    = "";
		$currtime=date('H:i'); 
	$currtime=date('H:i'); 
	if($currtime >='00:00' && $currtime <='05:59'){
		$checkin=date('Y-m-d',strtotime("-1 days"));
		$datformat=date('Y-m-d',strtotime("-1 days"));
		$checkout=date('Y-m-d', strtotime('+1 days', strtotime($datformat)));

	}else{
$checkin=date('Y-m-d');
$checkout=date('Y-m-d', strtotime(' +1 day'));
	}
		//$checkin=date('Y-m-d');
		//$checkout=date('Y-m-d', strtotime(' +1 day'));
		$capacity_id=$bsiCore->ClearInput($_POST['capacity_id']);
		$roomtypeid=$bsiCore->ClearInput($_POST['roomtypeid']);	
		$noofroom=$bsiCore->ClearInput($_POST['noofroom']);	
		$availableroomno=$bsiCore->ClearInput($_POST['availableroomno']);
		$availableroomid=$bsiCore->ClearInput($_POST['availableroomid']);
		$differcnce=$noofroom-$availableroomno;
		
		//print_r($_POST);die;
		$hotel_id=$_SESSION['hhid'];
		$search = mysql_query("select bb.booking_id from bsi_bookings as bb,bsi_reservation as br where bb.is_block='1' and bb.checkin_date='".$checkin."' and bb.checkout_date='".$checkout."' and bb.booking_id=br.booking_id and br.roomtype_id='".$roomtypeid."' ");
		$blockno=mysql_num_rows($search);
		
		//echo 'Block No ==>'.$blockno;
		//echo 'Difference ==>'.$differcnce;//die;
		/*if($differcnce<0)
		{
		$bookingId=$bsiCore->config['conf_bookingid_prefix'].time();
		$sql = mysql_query("INSERT INTO bsi_bookings (booking_id, hotel_id, booking_time, checkin_date, checkout_date, client_id, child_count, extra_guest_count, discount_coupon, total_cost, payment_amount, payment_type, special_requests, is_block, payment_success) values('".$bookingId."', ".$_SESSION['hhid'].", NOW(), '".$checkin."', '".$checkout."', '0', 0 , 0, '', '', '', '', '',1, 1)");
		for($r=0;$r<abs($differcnce);$r++){
		$arr = explode("#",$availableroomid);
		$first = $arr[$r];
$sql = mysql_query("INSERT INTO bsi_reservation (booking_id, room_id, roomtype_id) values('".$bookingId."','".$first."','".$roomtypeid."')");	
			}
			
		$sucess=abs($differcnce).' rooms Blocked successfully !';	
		}else{*/
		
		if($differcnce==0)
		{
		$sucess='Please Enter Proper No Of Room(s) !';	
		}else{
			
		if($differcnce>0){	
		//echo "one";die;
//************** No Block Room 		
		if($blockno==0)
		{
			for($r=1;$r<=$differcnce;$r++)
			{	
			mysql_query("INSERT INTO `bsi_room` (`hotel_id` ,`roomtype_id`, `room_no` ,`capacity_id`,`no_of_child`,`extra_bed` )VALUES ('". $hotel_id."', '".$roomtypeid."','1', '".$capacity_id."', '0','0')") or die("Error at line : 342".mysql_error());
			mysql_query("update bsi_room set room_no='".mysql_insert_id()."' where room_id='".mysql_insert_id()."'"); 
			}
		$sucess=abs($differcnce).' room(s) inserted successfully !';
		}else{
		if($blockno>$differcnce)
		{
		$i=0;	
		while($row=mysql_fetch_assoc($search))
		{ 
		//if($i!=$differcnce){
		//$row=mysql_fetch_assoc($search);
			//mysql_query("delete from bsi_bookings where booking_id='".$row['booking_id']."' ");
		//mysql_query("delete from bsi_reservation where booking_id='".$row['booking_id']."' ");	
		//echo "select id from bsi_reservation where booking_id='".$row['booking_id']."' order by id DESC ";	
		$delsearch=mysql_query("select id from bsi_reservation where booking_id='".$row['booking_id']."' order by id DESC ");
			//$delrow=mysql_fetch_assoc($delsearch);	
		while($delrow=mysql_fetch_assoc($delsearch))
		{ 
		if($i!=$differcnce){
			mysql_query("delete from bsi_reservation where id='".$delrow['id']."' ");
			$i++;
		}
		}
		}
		
		
		$sucess=$i.' room(s) Un-Blocked successfully !';	
			
			}else{
			
		while($row=mysql_fetch_assoc($search))
		{ 
			mysql_query("delete from bsi_bookings where booking_id='".$row['booking_id']."' ");
			mysql_query("delete from bsi_reservation where booking_id='".$row['booking_id']."' ");	
		}
		$noofaddroom=$differcnce-$blockno;
		for($r=1;$r<=$noofaddroom;$r++)
			{	
			mysql_query("INSERT INTO `bsi_room` (`hotel_id` ,`roomtype_id`, `room_no` ,`capacity_id`,`no_of_child`,`extra_bed` )VALUES ('". $hotel_id."', '".$roomtypeid."','1', '".$capacity_id."', '0','0')") or die("Error at line : 342".mysql_error());
			mysql_query("update bsi_room set room_no='".mysql_insert_id()."' where room_id='".mysql_insert_id()."'"); 
			}
		$sucess=abs($noofaddroom).' room(s) inserted successfully !';		
		}
		
		}
		
		}else{
			//echo "Two";die;
			
			$bookingId=$bsiCore->config['conf_bookingid_prefix'].time();
		$sql = mysql_query("INSERT INTO bsi_bookings (booking_id, hotel_id, booking_time, checkin_date, checkout_date, client_id, child_count, extra_guest_count, discount_coupon, total_cost, payment_amount, payment_type, special_requests, is_block, payment_success) values('".$bookingId."', ".$_SESSION['hhid'].", NOW(), '".$checkin."', '".$checkout."', '0', 0 , 0, '', '', '', '', '',1, 1)");
		for($r=0;$r<abs($differcnce);$r++){
		$arr = explode("#",$availableroomid);
		$first = $arr[$r];
$sql = mysql_query("INSERT INTO bsi_reservation (booking_id, room_id, roomtype_id) values('".$bookingId."','".$first."','".$roomtypeid."')");	
			}
			
		$sucess=abs($differcnce).' rooms Blocked successfully !';	
			
			}
		}
		/*}*/
		echo json_encode(array("errorcode"=>$errorcode,"strhtml"=>$sucess));
		
		
		}
		
		
public function updatebookingstatus(){
		
		global $bsiCore;
		//$bsiMail   = new bsiMail();
		$errorcode = 0;
		$strmsg    = "";
		$sucess    = '';
		$error     = 'Try After Some Time';
		$status  = $bsiCore->ClearInput($_POST['status']);
		$booking_id  = $bsiCore->ClearInput($_POST['booking_id']);	
		$search    = mysql_query("select `boking_status` from `bsi_reservation` where booking_id='".$booking_id."'");
				
		if(mysql_num_rows($search)){
			mysql_query("UPDATE `bsi_bookings` SET `is_deleted` = '0' WHERE `booking_id` ='".$booking_id."'");
			mysql_query("UPDATE `bsi_reservation` SET `boking_status` = '".$status."' WHERE `booking_id` ='".$booking_id."'");
			echo json_encode(array("errorcode"=>$errorcode,"strhtml"=>$sucess));
		}else{			
			$errorcode = 1;
			echo json_encode(array("errorcode"=>$errorcode,"strmsg"=>$error));	
		}
		
	}
		
	}//end of class
	
?>