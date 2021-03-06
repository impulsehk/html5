<?php

/**

* @package BSI

* @author BestSoft Inc see README.php

* @copyright BestSoft Inc.

* See COPYRIGHT.php for copyright notices and details.

*/

$bookprs=new BookingProcess;



class BookingProcess

{	

	public $clientId			= 0;

	public $clientName			= '';

	public $clientEmail			= '';

	public $bookingId			= '';

	public $paymentGatewayCode	= '';		

	public $totalPaymentAmount 	= 0.00;	

	public $invoiceHtml			= '';

	public $bookingrefrence     = 'N/A';

	public $extrabed            = 0;

	public $agentExistence      = 0;

	public $commissionPercent   = 0;

	public $commission          = 0.00;

	public $payment_amount      = 0;

	public $payment_tax         = 0;

	public $conf_payment_commission;

	private $getRoom        	= '';
	
	public $bookingArray        = array();

	

	#this variable are activated when agent is loged in

	public $title               = '';

	public $email               = '';

	public $firstname           = '';

	public $lastname            = '';

	public $address1            = '';

	public $address2            = '';

	public $city                = '';

	public $state               = '';

	public $zip                 = '';

	public $country             = '';

	public $phone               = '';

	public $lastInsertedCid     = 0;

	public $agentId             = 0;

		

	function BookingProcess() {				

		$this->setMyRequestParams();

		/*if($this->agentExistence){

			$this->getAgentInfo();

			$this->inserClientInfo();

		}else{

			$this->getClientInfo();
}*/

		$this->createInvoice();

	}

	

	private function setMyRequestParams(){

		global $bsiCore;
	//echo $_SESSION['grandtotal'];die;

		//$this->setMyParamValue($this->agentExistence, 'SESSION', 'agent', NULL, true);

		$this->setMyParamValue($this->clientName, 'SESSION', 'Myname2012', NULL, true);
		
		$this->setMyParamValue($this->clientEmail, 'SESSION', 'myemail2012', NULL, true);

		//$this->setMyParamValue($this->clientdata, 'SESSION', 'myemail2012', NULL, true);

		$this->setMyParamValue($this->clientId, 'SESSION', 'client_id2012', NULL, true);

		$this->setMyParamValue($this->bookingId, 'SESSION', 'bookingId', NULL, true);

		$this->setMyParamValue($this->checkindate, 'SESSION', 'sv_checkindate', NULL, true);

		$this->setMyParamValue($this->checkoutdate, 'SESSION', 'sv_checkoutdate', NULL, true);

		$this->setMyParamValue($this->nightcount, 'SESSION', 'sv_nightcount', NULL, true);

		$this->setMyParamValue($this->rooms, 'SESSION', 'sv_rooms', NULL, true);

		$this->setMyParamValue($this->adults, 'SESSION', 'sv_adults', NULL, true);

		$this->setMyParamValue($this->childcount, 'SESSION', 'sv_childcount', NULL, true);

		//$this->setMyParamValue($this->totalPaymentAmount, 'SESSION', 'grandtotal', NULL, true);	

		$this->setMyParamValue($this->payment_tax, 'SESSION', 'tax', NULL, true);		

		$this->setMyParamValue($this->paymentGatewayCode, 'POST', 'payment_gateway','', true);	

		

		/*if($this->agentExistence){

			$this->setMyParamValue($this->title, 'POST', 'title','', true);

			$this->setMyParamValue($this->email, 'POST', 'email','', true);

			$this->setMyParamValue($this->firstname, 'POST', 'firstname','', true);

			$this->setMyParamValue($this->lastname, 'POST', 'lastname','', true);

			$this->setMyParamValue($this->address1, 'POST', 'address1','', true);

			$this->setMyParamValue($this->address2, 'POST', 'address2','', true);

			$this->setMyParamValue($this->city, 'POST', 'city','', true);

			$this->setMyParamValue($this->state, 'POST', 'state','', true);

			$this->setMyParamValue($this->zip, 'POST', 'zip','', true);

			$this->setMyParamValue($this->country, 'POST', 'country','', true);

			$this->setMyParamValue($this->phone, 'POST', 'phone','', true); 

		}*/
		 
   
		$month_num = intval(substr($bsiCore->getMySqlDate($this->checkindate), 5, 2)) ;
		$sql = mysql_query("SELECT * FROM bsi_deposit_discount WHERE month_num = ".$month_num);
		$depositepercent = mysql_fetch_assoc($sql);
		if($depositepercent['deposit_percent'] > 0){
		
		$this->totalPaymentAmount=$_SESSION['grandtotal']*$depositepercent['deposit_percent']/100;
		
		}else{
		$this->totalPaymentAmount=$_SESSION['grandtotal'];
		}
		
		
		
		//$this->setMyParamValue($this->totalPaymentAmount, 'SESSION', 'grandtotal', NULL, true);

					

		$this->expTime 			       = intval($bsiCore->config['conf_booking_exptime']);	

		$this->currencySymbol 	       = $bsiCore->currency_symbol();

		$this->taxPercent 		       = $bsiCore->config['conf_tax_amount'];

		$this->conf_payment_commission = $bsiCore->config['conf_payment_commission'];

	}

	private function setMyParamValue(&$membervariable, $vartype, $param, $defaultvalue, $required = false){

		global $bsiCore;

		switch($vartype){

			case "POST": 

				if($required){if(!isset($_POST[$param])){$this->invalidRequest(91);} 

					else{$membervariable = mysql_real_escape_string($_POST[$param]);}}

				else{if(isset($_POST[$param])){$membervariable = mysql_real_escape_string($_POST[$param]);} 

					else{$membervariable = $defaultvalue;}}				

				break;	

			case "GET":

				if($required){if(!isset($_GET[$param])){$this->invalidRequest(92);} 

					else{$membervariable = $bsiCore->ClearInput($_GET[$param]);}}

				else{if(isset($_GET[$param])){$membervariable = $bsiCore->ClearInput($_GET[$param]);} 

					else{$membervariable = $defaultvalue;}}				

				break;	

			case "SESSION":

				if($required){if(!isset($_SESSION[$param])){$this->invalidRequest(93);} 

					else{$membervariable = $_SESSION[$param];}}

				else{if(isset($_SESSION[$param])){$membervariable = $_SESSION[$param];} 

					else{$membervariable = $defaultvalue;}}				

				break;	

			case "REQUEST":

				if($required){if(!isset($_REQUEST[$param])){$this->invalidRequest(94);}

					else{$membervariable = $bsiCore->ClearInput($_REQUEST[$param]);}}

				else{if(isset($_REQUEST[$param])){$membervariable = $bsiCore->ClearInput($_REQUEST[$param]);}

					else{$membervariable = $defaultvalue;}}				

				break;

			case "SERVER":

				if($required){if(!isset($_SERVER[$param])){$this->invalidRequest(95);}

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

	

	private function inserClientInfo(){

		mysql_query("insert into bsi_clients (first_name, surname, title, street_addr, street_addr2, city, province, zip, country, phone, email, agent) values ('".$this->firstname."', '".$this->lastname."', '".$this->title."', '".$this->address1."', '".$this->address2."', '".$this->city."', '".$this->state."', '".$this->zip."', '".$this->country."', '".$this->phone."', '".$this->email."', '1')");

		$this->clientEmail     = $this->email;

		$this->clientName      = $this->firstname." ".$this->lastname;

		//$this->clientdata      = $this->email;

		$this->lastInsertedCid = mysql_insert_id();

		$this->clientId        = $this->lastInsertedCid;

	}

	

	private function getClientInfo(){

		$row = mysql_fetch_assoc(mysql_query("select * from bsi_clients where client_id=".$this->clientId));

		$this->clientEmail = $row['email'];
		
		$this->clientEmail = $row['email'];

	}

	

	private function getAgentInfo(){

		$row = mysql_fetch_assoc(mysql_query("select * from bsi_agent where agent_id=".$this->clientId));

		$this->agentId            = $row['agent_id']; 

		$this->commissionPercent  = $row['commission'];

		$this->commission         = $this->commission+($this->totalPaymentAmount*$this->commissionPercent/100);

		if($this->conf_payment_commission == 0){

			$this->totalPaymentAmount = ($this->totalPaymentAmount+$this->commission);

		}else{

			$this->totalPaymentAmount = $this->totalPaymentAmount;

		}

	}

	

	private function createInvoice(){

		global $bsiCore;

		$roomtypeArray = $_SESSION['RoomType_Capacity_Qty'];

$this->invoiceHtml = '<style>
html
{
	width: 100%;
}

.Noxa ::-moz-selection{background:#fefac7;color:#555555;}
.Noxa ::selection{background:#fefac7;color:#555555;}

.Noxa body { 
   background-color: #f5f5f5; 
   margin: 0 !important; 
   padding: 0; 
}

.Noxa .ReadMsgBody
{
	width: 100%;
	background-color: #f5f5f5;
}
.Noxa .ExternalClass
{
	width: 100%;
	background-color: #f5f5f5;
}

.Noxa a { 
    color:#00aeef; 
	text-decoration:none;
	font-weight:normal;
	font-style: normal;
} 
.Noxa a:hover { 
    color:#999999; 
	text-decoration:none;
	font-weight:normal;
	font-style: normal;
}



.Noxa p,
.Noxa div {
	margin: 0 !important;
}

.Noxa ul {
	margin-top: 0 !important; margin-bottom: 0 !important;
}


.Noxa table {
	border-collapse: collapse;
}
.pad10{ padding:10px;}

@media only screen and (max-width: 640px)  {
	.Noxa table table{width:100% !important; }
	.Noxa table[class="myfull"] {width: 100% !important;}
	.Noxa td[class="full_width"] {width:100% !important; }
	.Noxa div[class="div_scale"] {width: 440px !important; margin: 0 auto !important;}
	.Noxa table[class="table_scale"] {width: 440px !important; margin: 0 auto !important; }
	.Noxa td[class="td_scale"] {width: 440px !important; margin: 0 auto !important;}
	.Noxa img[class="img_scale"] {width: 100% !important; height: auto !important;}
	.Noxa img[class="divider"] {width: 440px !important; height: 2px !important;}
	.Noxa table[class="spacer"] {display: none !important;}
	.Noxa td[class="spacer"] {display: none !important;}
	.Noxa td[class="center"] {text-align: center !important;}
	.Noxa table[class="full"] {width: 400px !important; margin-left: 20px !important; margin-right: 20px !important;}
	.Noxa img[class="divider"] {width: 400px !important; height: 1px !important;}
	.Noxa td[class="no_padding"] {padding-right: 0px !important; padding-left: 0px !important;}
	.Noxa table[class="highlighted"] {width:100%;}
	.img{ width:150px !important;}
	.Noxa table[class="table_scale"] tr td{ word-break:break-all !important; white-space:normal }
}


@media only screen and (max-width: 479px)  {
	.Noxa table table{width:100% !important; }
	.Noxa table[class="myfull"] {width: 100% !important;}
	.Noxa td[class="full_width"] {width:100% !important; }
	.Noxa div[class="div_scale"] {width: 280px !important; margin: 0 auto !important;}
	.Noxa table[class="table_scale"] {width: 280px !important; margin: 0 auto !important;}
	.Noxa td[class="td_scale"] {width: 280px !important; margin: 0 auto !important;}
	.Noxa img[class="img_scale"] {width: 100% !important; height: auto !important;}
	.Noxa img[class="divider"] {width: 280px !important; height: 2px !important;}
	.Noxa table[class="spacer"] {display: none !important;}
	.Noxa td[class="spacer"] {display: none !important;}
	.Noxa td[class="center"] {text-align: center !important;}
	.Noxa table[class="full"] {width: 240px !important; margin-left: 20px !important; margin-right: 20px !important; }
	.Noxa img[class="divider"] {width: 240px !important; height: 1px !important;}
	.Noxa td[class="no_padding"] {padding-right: 0px !important; padding-left: 0px !important;}
	.Noxa table[class="highlighted"] {width:100%;}
	.img{ width:100px !important;}
	.Noxa table[class="table_scale"] tr td{ word-break:break-all !important; white-space:normal !important}
}
</style>

';

//$actual_link = "http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
//$url = (isset($_SERVER['HTTPS']) ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";

$abs_url=$bsiCore->abs_url(dirname(__FILE__));
$imageurl=explode("/includes",$abs_url);
//<img src="http://bestsoftinc.net/bsiv30/gallery/portal/'.$bsiCore->config['conf_portal_logo'].'"/>


			$this->invoiceHtml.= ' 
			<table id="background-table" border="0" cellpadding="0" cellspacing="0" width="100%">
            <tbody>
            <tr>
           <td align="center" bgcolor="#ececec"> 
           <br/><br/>
           <table border="0" cellpadding="0" cellspacing="0" width="640" class="table_scale" bgcolor="#ffffff">
           <tbody>
           <tr>
          <td style="padding:10px">
          <table border="0" width="100%" cellpadding="0" cellspacing="0"  class="table_scale" bgcolor="#ffffff">
          <tr>
          <td bgcolor="#f1f1f1" align="center" style="border:1px solid #999; padding:5px 0">
          <img src="'.$imageurl[0].'/gallery/portal/'.$bsiCore->config['conf_mail_logo'].'"/>
          </td>
          </tr>
          </table>
		  </td>
          </tr>';
								
										
$this->invoiceHtml.=' <tr><td style="padding:10px">
                                    	<table style="font-family:Arial, Helvetica, sans-serif; font-size:14px; width:100%;" border="1" cellpadding="0" cellspacing="0" >
                                            <tbody>
                                            <tr bgcolor="#01b7f2">
                                              <th colspan="4" style="padding:5px 0; color:#ffffff; font-weight:bold; font-size:16px;">Booking Details</th>
                                            </tr>
                                            <tr>
                                              <td width="25%" style="padding:5px 0"><span style="padding-left:10px;">Booking Number</span></td>
                                              <td width="75%" colspan="3"><span style="padding-left:10px;">'.$this->bookingId.'</span></td>
                                            </tr>
                                            <tr>
                                              <td width="25%" style="padding:5px 0"><span style="padding-left:10px;">Guest Name</span></td>
                                              <td width="75%" colspan="3"><span style="padding-left:10px;">'.$this->clientName.'</span></td>
                                            </tr>
											
											<tr>
                                              <td width="25%" style="padding:5px 0"><span style="padding-left:10px;">Check in Days</span></td>
                                              <td width="75%" colspan="3"><span style="padding-left:10px;">'.$this->checkindate.'</span></td>
                                            </tr>
											
											<tr>
                                              <td width="25%" style="padding:5px 0"><span style="padding-left:10px;">Total Rooms</span></td>
                                              <td width="75%" colspan="3"><span style="padding-left:10px;">'.$this->rooms.'</span></td>
                                            </tr>
											
                                            <tr>
                                              <td  colspan="4" height="9" style="font-size:0"></td>
                                            </tr>';
                                            
                                            /*<tr bgcolor="#eeeeee">
                                              <td align="center" width="25%" style="padding:5px 0"><strong>Check in Days</strong></td>
                                              <td align="center" width="25%"><strong>Check out Days</strong></td>
                                              <td align="center" width="25%"><strong>Total Nights</strong></td>
                                              <td align="center" width="25%"><strong>Total Rooms</strong></td>
                                            </tr>
                                            <tr>
                                              <td align="center" width="25%" style="padding:5px 0">'.$this->checkindate.'</td>
                                              <td align="center" width="25%">'.$this->checkoutdate.'</td>
                                              <td align="center" width="25%">'.$this->nightcount.'</td>
                                              <td align="center" width="25%">'.$this->rooms.'</td>
                                            </tr>
                                            <tr>
                                              <td  colspan="4" height="9" style="font-size:0"></td>
                                            </tr>*/
                                           
                                           $this->invoiceHtml.=' <tr bgcolor="#eeeeee">
                                              <td align="center" width="25%" style="padding:5px 0"><strong>Number of Room</strong></td>
                                              <td align="center" width="25%"><strong>Room Type</strong></td>
                                              <td align="center" width="25%"><strong>Max Occupancy</strong></td>
                                              <td align="right" width="25%"><strong><span style="padding-right:10px">Gross Total</span></strong></td>
                                            </tr>
                                            ';

		//****************************************************

			 $count=count($roomtypeArray);

			 $gettotalPrice=0;

			 $price=0;
			 $child_caption ='';

			 for($i=0;$i<$count;$i++){

				 $getRoomType=$roomtypeArray[$i]['roomTypeName'];
				 
				  $getchildprice = $roomtypeArray[$i]['child_price'];
				 
				 
				if($getchildprice>0){
					$child_caption=' (Including '.$_SESSION['sv_childcount'].' Child)';
				}

				 $price=$roomtypeArray[$i]['totalPrice'];

				 $gettotalPrice+=$roomtypeArray[$i]['totalPrice'];

				 $noOfRoom=$roomtypeArray[$i]['Qty'];

				 $capacity=$bsiCore->getCapacity($roomtypeArray[$i]['capcityid']);

		$this->invoiceHtml.='
		<tr bgcolor="#eeeeee">
        <td align="center" width="25%" style="padding:5px 0"><strong>'.$noOfRoom.'</strong></td>
        <td align="center" width="25%"><strong>'.$getRoomType.'</strong></td>
        <td align="center" width="25%"><strong>'.$capacity['capacity'].'&nbsp;'.$child_caption.'</strong></td>
         <td align="center" width="25%"><span style="padding-right:10px"><strong>'.$this->currencySymbol.($price*$noOfRoom).'</strong></span></td>
         </tr>
		 <tr>
         <td  colspan="4" height="9" style="font-size:0"></td>
         </tr>';
			}		

		//***************************************************	

			if(isset($_SESSION['extra_price']))
			{
		$this->invoiceHtml.= '
		<tr bgcolor="#eeeeee">
        <td colspan="3" align="right" width="75%" style="padding:5px 0"><span style="padding-right:10px"><strong>Extra Bed  Price :</strong></span></td>
        <td align="right" width="25%"><span style="padding-right:10px"><strong>'.$this->currencySymbol.number_format($_SESSION['extra_price'], 2 , '.', ',').'</strong></span></td>
        </tr>';
		    }
			
			if(!empty($_SESSION['listExtraService'])){
		  $this->invoiceHtml.= '<tr>
				    <td bgcolor="#eeeeee" align="left" colspan="4"><strong>Options/Services</strong></td>
			    </tr>';
		  $i=1;
			foreach($_SESSION['listExtraService'] as $key => $value){ 
				
				$this->invoiceHtml.= '<tr >
							<td align="left" colspan="3">'.$value['description'].'</td>
							<td  align="right" style="padding-right:5px;">'.$this->currencySymbol.number_format($value['totalprice'], 2).'</td>
						  </tr>';	
						  
				$extraservice.=$value['description'].',';		  	 
			}	
	  }

		$this->invoiceHtml.= '
		<tr bgcolor="#eeeeee">
        <td colspan="3" align="right" width="75%" style="padding:5px 0"><span style="padding-right:10px"><strong>Sub Total</strong></span></td>
        <td align="right" width="25%"><span style="padding-right:10px"><strong>'.$this->currencySymbol.number_format($_SESSION['total_cost'], 2 , '.', ',').'</strong></span></td>
          </tr>';
											
		
		
		if(isset($_SESSION['cuppon_discount_amount']))
		{
		$this->invoiceHtml.= '
		<tr>
        <td colspan="3" align="right" width="75%" style="padding:5px 0"><span style="padding-right:10px">Cuppon Code '.$_SESSION['discountcoupon'].'  Applied</span></td>
        <td align="right" width="25%"><span style="padding-right:10px">(-) '.$this->currencySymbol.number_format($_SESSION['cuppon_discount_amount'], 2 , '.', ',').'</span></td>
        </tr>';
 		}


		$month_num = intval(substr($bsiCore->getMySqlDate($this->checkindate), 5, 2)) ;
		$sqldis= mysql_query("SELECT * FROM bsi_deposit_discount WHERE month_num = ".$month_num);
		$depositepercent = mysql_fetch_assoc($sqldis);
		
		if($depositepercent['discount_percent'] > 0)
		{
		$this->invoiceHtml.= '
		<tr>
        <td colspan="3" align="right" width="75%" style="padding:5px 0"><span style="padding-right:10px">Monthly Discount Scheme ( '.number_format(($depositepercent['discount_percent']), 2 , '.', ',').'%)</span></td>
        <td align="right" width="25%"><span style="padding-right:10px">(-) '.$this->currencySymbol.number_format($_SESSION['discount_amount'], 2 , '.', ',').'</span></td>
        </tr>';
		
		 }
		
		if($bsiCore->config['conf_tax_amount']>0)
		{	
		$tax = $bsiCore->config['conf_tax_amount'];							
		$this->invoiceHtml.= '<tr>
                                              <td colspan="3" align="right" width="75%" style="padding:5px 0"><span style="padding-right:10px">Tax('.number_format(($tax), 2 , '.', ',').'%)</span></td>
                                              <td align="right" width="25%"><span style="padding-right:10px"> '.$this->currencySymbol.number_format($this->payment_tax, 2 , '.', ',').'</span></td>
                                            </tr>';
		}
		
     $this->invoiceHtml.= '
	 <tr bgcolor="#eeeeee">
     <td colspan="3" align="right" width="75%" style="padding:5px 0"><span style="padding-right:10px"><strong>Grand Total</strong></span></td>
     <td align="right" width="25%"><span style="padding-right:10px"><strong>'.$this->currencySymbol.number_format($_SESSION['grandtotal'], 2 , '.', ',').'</strong></span></td>
     </tr>';
											
		$month_num = intval(substr($bsiCore->getMySqlDate($this->checkindate), 5, 2)) ;
		$sqld= mysql_query("SELECT * FROM bsi_deposit_discount WHERE month_num = ".$month_num);
		$depositepercent = mysql_fetch_assoc($sqld);

		if($depositepercent['deposit_percent'] > 0)
		{
		$this->totalPaymentAmount=$_SESSION['grandtotal']*$depositepercent['deposit_percent']/100;
		$this->invoiceHtml.= '
		<tr bgcolor="#eeeeee">
        <td colspan="3" align="right" width="75%" style="padding:5px 0"><span style="padding-right:10px"><strong>Advance Payment Amount('.number_format(($depositepercent['deposit_percent'] ), 2 , '.', ',').'% of Grand Total)</strong></span></td>
        <td align="right" width="25%"><span style="padding-right:10px"><strong>'.$this->currencySymbol.number_format($this->totalPaymentAmount, 2 , '.', ',').'</strong></span></td>
         </tr>';
		
		}   
		
		
		$this->invoiceHtml.= '
		 </tbody></table>
		 </td>
         </tr>
         <tr>
         <td height="15"></td>
         </tr>
         <tr>
         <td style="padding:10px">
		';
		
		$reviewsql= mysql_query("SELECT `reviewid` FROM `bsi_bookings` WHERE booking_id = '".$this->bookingId."' ");
		$rowreview = mysql_fetch_assoc($reviewsql);
		

		if($this->paymentGatewayCode == "poa" || $this->paymentGatewayCode == "admin"){

			$payoptions = "Manual: Pay On Arival";		

			if($this->paymentGatewayCode == "admin"){

				$payoptions = "Manual: Booked By Administrator";	

			}

			
			$this->invoiceHtml.= '
			<table style="font-family:Arial, Helvetica, sans-serif; font-size:14px; width:100%;" border="1" cellpadding="0" cellspacing="0" >
              <tbody>
              <tr bgcolor="#01b7f2">
              <th colspan="4" style="padding:5px 0; color:#ffffff; font-weight:bold; font-size:16px;">Payment Details</th>
              </tr>
              <tr>
               <td width="25%" style="padding:5px 0"><span style="padding-left:10px;">Payment Option</span></td>
               <td width="75%" colspan="3" bgcolor="#cccccc"><span style="padding-left:10px;">'.$payoptions.'</span></td>
               </tr>
               </tbody>
               </table>
			    <br/><br/> 
<table style="font-family:Arial, Helvetica, sans-serif; font-size:14px; width:100%;" border="1" cellpadding="0" cellspacing="0" >
<tbody>
<tr bgcolor="#01b7f2">
<th colspan="4" style="padding:5px 0; color:#ffffff; font-weight:bold; font-size:16px;">Tell us what you think</th>
</tr>

<tr>
<td width="25%" style="padding:5px 0"><span style="padding-left:10px;">Review & feedback</span></td>
<td width="75%" colspan="3" bgcolor="#cccccc"><span style="padding-left:10px;"><a href="http://feelspark.com/review/'.$rowreview['reviewid'].'" target="_blank"> http://feelspark.com/review/'.$rowreview['reviewid'].'</a></span></td>
</tr>
</tbody>
</table>
			   
	</td>
    </tr>
    </tbody>
    </table>
    <br/><br/> 
     </td>
      </tr>
      </tbody>
     </table>';
			}

		//echo $this->invoiceHtml;die;

		if($this->paymentGatewayCode == "cc"){

			$payoptions = "Credit Card";

			$this->invoiceHtml.='
			<table style="font-family:Arial, Helvetica, sans-serif; font-size:14px; width:100%;" border="1" cellpadding="0" cellspacing="0" >
            <tbody>
           <tr bgcolor="#01b7f2">
           <th colspan="4" style="padding:5px 0; color:#ffffff; font-weight:bold; font-size:16px;">Payment Details</th>
           </tr>
           <tr>
           <td width="25%" style="padding:5px 0"><span style="padding-left:10px;">Payment Option</span></td>
           <td width="75%" colspan="3" bgcolor="#cccccc"><span style="padding-left:10px;">'.$payoptions.'</span></td>
           </tr>
           </tbody>
           </table>
		    <br/><br/> 
		   <table style="font-family:Arial, Helvetica, sans-serif; font-size:14px; width:100%;" border="1" cellpadding="0" cellspacing="0" >
<tbody>
<tr bgcolor="#01b7f2">
<th colspan="4" style="padding:5px 0; color:#ffffff; font-weight:bold; font-size:16px;">Tell us what you think</th>
</tr>

<tr>
<td width="25%" style="padding:5px 0"><span style="padding-left:10px;">Review & feedback</span></td>
<td width="75%" colspan="3" bgcolor="#cccccc"><span style="padding-left:10px;"><a href="http://feelspark.com/review/'.$rowreview['reviewid'].'" target="_blank"> http://feelspark.com/review/'.$rowreview['reviewid'].'</a></span></td>
</tr>
</tbody>
</table>

		   </td>
    </tr>
    </tbody>
    </table>
    <br/><br/> 
     </td>
      </tr>
      </tbody>
     </table>
		   ';

			

			$cardnum        = $bsiCore->ClearInput($_POST['CardNumber']);

			$cc_holder_name = $bsiCore->ClearInput($_POST['cc_holder_name']);

			$CardType       = $bsiCore->ClearInput($_POST['CardType']);

			$cc_exp_dt      = $bsiCore->ClearInput($_POST['cc_exp_dt']);

			$expireyear     = $bsiCore->ClearInput($_POST['expireyear']);

			$cc_ccv         = $bsiCore->ClearInput($_POST['cc_ccv']);

			$cardnum_enc    = $bsiCore->encryptCard($_POST['CardNumber']);

			

			$cardno_len     = strlen($cardnum)-4;

			$creditcard_no  = substr($cardnum,$cardno_len);

			$star           = '';
			
			for($i=0;$i<$cardno_len;$i++){ $star.='#';}

			$show_cardno    = $star.$creditcard_no;

			

mysql_query("insert into bsi_cc_info(booking_id, cardholder_name, card_type, card_number, expiry_date, ccv2_no) values('".$this->bookingId."', '".$cc_holder_name."', '".$CardType."', '".$cardnum_enc."', '".$cc_exp_dt."/".$expireyear."', '".$cc_ccv."')");


		}
		
		
	/*$this->invoiceHtml.='
    </td>
    </tr>
    </tbody>
    </table>
    <br/><br/> 
     </td>
      </tr>
      </tbody>
     </table>';*/


		$insertInvoiceSQL = mysql_query("INSERT INTO bsi_invoice(booking_id, client_name, client_email, invoice) values('".$this->bookingId."', '".$this->clientName."', '".$this->clientEmail."', '".$this->invoiceHtml."')")or die("Error at line No : 139".mysql_error());


		

		

		//**************************************pdf generate  start*********************************************************************

		

		require_once('tcpdf_min/tcpdf.php');

		
   
		if($bsiCore->config['conf_portal_logo'] == ""){

			$potal_logo='<h2>'.$bsiCore->config['conf_portal_name'].'</h2>';

		}else{

			if(file_exists('gallery/portal/thumb_'.$bsiCore->config['conf_portal_logo'])){

				$potal_logo='<img src="gallery/portal/thumb_'.$bsiCore->config['conf_portal_logo'].'" width="152px" height="45px" align="left" />';

			}else{

				$potal_logo='<h2>'.$bsiCore->config['conf_portal_name'].'</h2>';

			}

		}	

		if($bsiCore->config['conf_portal_signature'] == ""){

			$potal_signature='';

		}else{

			if(file_exists('gallery/portal/thumb_'.$bsiCore->config['conf_portal_signature'])){

				$potal_signature='<img src="gallery/portal/thumb_'.$bsiCore->config['conf_portal_signature'].'" width="152px" height="80px" align="left" />';

			}else{

				$potal_signature='';	

			}

		}

		

		if($this->agentExistence){

			$ahtml = '<td align="left" width="70%"><b>Agent / '.$this->agentId.'</b></td>';	

		}else{

			$ahtml = '<td align="left" width="70%"><b>'.$this->clientId.'</b></td>';

		}

		

		$this->bookingArray   = $bsiCore->bookingDeatails($this->bookingId);

		$hotel_name 		  = $this->bookingArray['hotel_name'];

		$address_1 			  = $this->bookingArray['address_1'];

		$address_2 			  = $this->bookingArray['address_2'];

		$city_name		      = $this->bookingArray['city_name'];

		$state       		  = $this->bookingArray['state'];

		$country_name 		  = $this->bookingArray['name'];

		$post_code            = $this->bookingArray['post_code'];

		$terms_n_cond         = $this->bookingArray['terms_n_cond'];

		$phone_number         = $this->bookingArray['phone_number'];		

		$payment_type         = $bsiCore->paymentGateway($this->paymentGatewayCode);

		$this->payment_amount = $this->bookingArray['total_cost'];

		

		if($this->paymentGatewayCode == "cc"){

			$getPM = '<tr>

				<td bgcolor="#d2d0d0" width="160px"><b>Payment Method : </b>'.$payment_type.'</td>

				<td bgcolor="#d2d0d0" colspan="2" width="197px">&nbsp;&nbsp;&nbsp;<b>Card No : </b>'.$show_cardno.'</td>

				<td width="127px" bgcolor="#d2d0d0" align="left">&nbsp;&nbsp;&nbsp;<b>EXP : </b>'.$cc_exp_dt."/".$expireyear.'</td>

			 </tr>';

		}else{

			$getPM = '<tr>

				<td bgcolor="#d2d0d0" width="160px"><b>Payment Method : </b>'.$payment_type.'</td>

				<td bgcolor="#d2d0d0" colspan="2" width="197px">&nbsp;&nbsp;&nbsp;<b>Card No : </b>N/A</td>

				<td width="127px" bgcolor="#d2d0d0" align="left">&nbsp;&nbsp;&nbsp;<b>EXP : </b>N/A</td>

			 </tr>';

		}

		$getRoom   = $_SESSION['getRoom'];



		$portal_name = $bsiCore->config['conf_portal_name']."<br/>Address : ".$bsiCore->config['conf_portal_streetaddr'].",".$bsiCore->config['conf_portal_city'].",".$bsiCore->config['conf_portal_state'].",".$bsiCore->config['conf_portal_country']."-".$bsiCore->config['conf_portal_zipcode']."<br/>Phone# : ".$bsiCore->config['conf_portal_phone'];

		if($bsiCore->config['conf_portal_fax'] != ""){

			$portal_name.=', Fax# : '.$bsiCore->config['conf_portal_fax'];

		}
		
		$extraservice='';
		$extrahtml='';
     	//*****************  Hotel Extras ************
		if(!empty($_SESSION['listExtraService']))
		{
		  $extraservice.= '<tr><td>Hotel Extras : </td><td align="left" class="test3"><b>';
			foreach($_SESSION['listExtraService'] as $key => $value)
			{$extraservice.=$value['description'].',';}
			$extraservice=rtrim($extraservice,",");
			$extraservice.='</b></td></tr>';	
	    }

		$url = "http://".$_SERVER['SERVER_NAME']."/";

		$pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);



		// set document information

		$pdf->SetCreator(PDF_CREATOR);

		$pdf->SetAuthor('Union Travel - Hotels in Albania');

		$pdf->SetTitle('Hotel Booking System');

		$pdf->SetSubject('Hotels in Albania');

		$pdf->SetKeywords('hotel, hotels, hotel in albania, hotels in albania, uniontravel, union travel');

		

		// remove default header/footer

		$pdf->setPrintHeader(false);

		$pdf->setPrintFooter(false);

		

		// set default monospaced font

		$pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);

		

		//set margins

		$pdf->SetMargins(10, 20, 10);

		$pdf->SetHeaderMargin(PDF_MARGIN_HEADER);

		$pdf->SetFooterMargin(PDF_MARGIN_FOOTER);

		

		//set auto page breaks

		$pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);

		

		//set image scale factor

		$pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);

		

		//set some language-dependent strings

		



		// ---------------------------------------------------------

		

		// set font

		$pdf->SetFont('helvetica', '', 10);

		

		// add a page

		$pdf->AddPage();

		

		

		$html = <<<EOF

		<!-- EXAMPLE OF CSS STYLE -->

		<style>

		h1 {

		color: navy;

		font-family: times;

		font-size: 20pt;

		text-decoration: none;

		}

		p.first {

		color: #003300;

		font-family: helvetica;

		font-size: 12pt;

		}

		p.first span {

		color: #006600;

		font-style: italic;

		}

		p#second {

		color: rgb(00,63,127);

		font-family: times;

		font-size: 12pt;

		text-align: justify;

		}

		p#second > span {

		background-color: #FFFFAA;

		}

		table.first {

		color: #003300;

		font-family: helvetica;

		font-size: 8pt;

		border-left: 1px solid #000000;

		border-right: 1px solid #000000;

		border-top: 1px solid #000000;

		border-bottom: 1px solid #000000;        

		

		}





		td.test {

		background-color: #d8d6d6;

		font-family: helvetica;

		font-size: 8pt;     

		}

		

		td.test3 {

		color: #000000;     

		font-family: helvetica;

		font-size: 8pt;

		border-style: solid solid solid solid;

		border-width: 1px 1px 1px 1px;

		border-color: #d2d0d0 #d2d0d0 #d2d0d0 #d2d0d0;

		

		}

		

		td.test2 {

		color: #ffffff;

		background-color: #868282;

		font-family: helvetica;

		font-size: 8pt;

		font-weight:bold;

		

		

		}

		td.test4 {

		color: #000000;

		font-family: helvetica;

		font-size: 8pt;

		border-style: solid solid solid solid;

		border-width: 1px 1px 1px 1px;

		border-color: #000000 #000000 #000000 #000000;

		

		}

	</style>



<table class="first" cellpadding="4" cellspacing="6" >

<tr><td colspan="2">

<table cellpadding="4" cellspacing="6">

<tr>

	<td width="30%">$potal_logo</td>

	<td align="right" width="70%"><h1>Hotel <span style="color:#990000">Voucher</span></h1><br>

	</td>

</tr>

</table>

</td></tr>



<tr>

<td colspan="2" class="test2">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; VOUCHER &nbsp;&nbsp;&nbsp;&nbsp;&nbsp; VOUCHER &nbsp;&nbsp;&nbsp;&nbsp;&nbsp; VOUCHER &nbsp;&nbsp;&nbsp;&nbsp;&nbsp; VOUCHER &nbsp;&nbsp;&nbsp;&nbsp;&nbsp; VOUCHER &nbsp;&nbsp;&nbsp;&nbsp;&nbsp; VOUCHER &nbsp;&nbsp;&nbsp;&nbsp;&nbsp; VOUCHER &nbsp;&nbsp;&nbsp;&nbsp;&nbsp; VOUCHER&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; VOUCHER &nbsp;&nbsp;&nbsp;&nbsp;</td>

</tr>

<tr>

<td width="40%">

<table cellpadding="4" cellspacing="6" border="0">

<tr>

	<td width="30%">Booking Id : </td>

	<td align="left" width="70%"><b>$this->bookingId</b></td>

</tr>

<tr>

	<td width="30%">Client : </td>

	<td align="left" width="70%"><b>$this->clientName</b></td>

</tr>



<tr>

	<td width="30%">Hotel : </td>

	<td align="left" width="70%"><b>$hotel_name</b></td>

</tr>

<tr>

	<td width="30%">Address : </td>

	<td class="test3"><b>$address_1,$address_2<br/>$city_name,$state<br/>

	$post_code,$country_name</b></td>

</tr>

<tr>

	<td width="30%">Phone : </td>

	<td align="left" width="70%"><b>$phone_number </b></td>

</tr>

</table>

</td>

<td width="14%">&nbsp;</td>

<td width="51%" class="test9">

<table cellpadding="4" cellspacing="6" border="0" bgcolor="#999999">

<tr>

	<td width="120px">Number Of Rooms : </td>

	<td align="center" class="test3"><b>$this->rooms</b></td>

</tr>

<tr>

	<td>Number Of Adults : </td>

	<td align="center" class="test3"><b>$this->adults</b></td>

</tr>

<tr>

	<td>Number Of Children : </td>

	<td align="center" class="test3"><b>$this->childcount</b></td>

</tr>



<tr>

	<td>Room Type : </td>

	<td align="left" class="test3"><b>$getRoom</b></td>

</tr>

$extraservice

</table>

</td>

</tr>



<tr>

	<td class="test3" colspan="2" width="100%">

		<table width="100%">

			<tr>

				<td width="80%">

					<table cellpadding="2" cellspacing="2">

					<tr>

						<td width="100px"><b>Arrival :</b></td>

						<td bgcolor="#d2d0d0" align="center">$this->checkindate</td>

						<td align="center"><b>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;

						 Departure :</b></td>

						<td bgcolor="#d2d0d0" align="center">$this->checkoutdate</td>

					</tr>

					<tr>

						<td colspan="4"><b>Payment Details : </b></td>

					</tr>

					$getPM				

					<tr>

						<td colspan="4"><b>Booked And Payable By: </b></td>

					</tr>

					

					<tr>

						<td colspan="4">$portal_name</td>

					</tr>

					</table>	

			</td>

				<td width="20%">

					<table>

						<tr>

							<td>$potal_signature</td>

						</tr>

					</table>

				</td>

			</tr>

		</table>

	</td>

</tr>



<tr>

<td colspan="2">

<table>

<tr>

	 <td valign="top" height="55px"><b>Remarks:<br/>All special request are subject to availabilty.</b></td>

	 <td valign="baseline" align="right" height="70px"><b>Call our customer services center 24/7</b><br/>customer support Head office:$phone_number<br/>$url</td>

</tr>

</table>

</td>

</tr>



<tr>

<td colspan="2" class="test3">$terms_n_cond</td>

</tr>

</table>

EOF;



		// output the HTML content

		$pdf->writeHTML($html, true, false, true, false, '');

		$pdf->SetProtection($permissions=array('copy'), $user_pass='', $owner_pass=null, $mode=0, $pubkeys=null);

		

		$style['position'] = 'R';

		$style['hpadding'] = '2';

		$pdf->write1DBarcode($this->bookingId, 'C39', '', '37', '', 10, 0.5, $style, 'N'); 



		// ---------------------------------------------------------

		//Close and output PDF document

		//$pdf->Output($_SERVER['DOCUMENT_ROOT'].basename(dirname($_SERVER['PHP_SELF'])).'/data/invoice/voucher_'.$this->bookingId.'.pdf', 'F');	
		
		$pdf->Output($_SERVER['DOCUMENT_ROOT'].basename(dirname($_SERVER['PHP_SELF'])).'/data/invoice/voucher_'.$this->bookingId.'.pdf', 'F');	 

		//**************************************pdf generate  end*********************************************************************

	}  

	

}

?>