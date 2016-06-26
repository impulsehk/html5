<?php
	/*include("access.php");
	if(isset($_SESSION['password_2012'])){
$name     = $_SESSION['Myname2012'];	
$email    = $_SESSION['myemail2012'];
$hotel_id = $_SESSION['hotel_id'];
}*/
session_start();
$name     = $_SESSION['Myname2012'];	
$email    = $_SESSION['myemail2012'];
$hotel_id = $_SESSION['hotel_id'];
include("includes/db.conn.php");
include("includes/conf.class.php");
include("includes/language.php"); 

/*$pos2 = strpos($_SERVER['HTTP_REFERER'], $_SERVER['SERVER_NAME']);
if(!$pos2){
header('Location: booking-failure.php?error_code=9');
exit;			
} */
if(isset($_SESSION['language'])){
	$htmlCombo=$bsiCore->getbsilanguage($_SESSION['language']); 
}else{
	$htmlCombo=$bsiCore->getbsilanguage(); 
	}
$hotelDetails  = $bsiCore->getHotelDetails($hotel_id);

$roomtypeArray = $_SESSION['RoomType_Capacity_Qty'];

?>

<!doctype html>
<html>
<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">
<!-- Latest compiled and minified CSS -->
<link rel="stylesheet" href="css/bootstrap.css">
<link rel="stylesheet" href="fonts/stylesheet.css">
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css">
<link rel="stylesheet" href="src/jquery-anyslider.css">
<!----><!--<script type="text/javascript" src="js/custom-form-elements.min.js"></script>-->
<!-- Optional theme 
<link rel="stylesheet" href="css/bootstrap-theme.css">-->
<!-- Custom Page Theme -->
<link rel="stylesheet" href="https://code.jquery.com/ui/1.11.2/themes/smoothness/jquery-ui.css">

<link rel="stylesheet" href="css/page-theme.css">
<link rel="stylesheet" href="js/cssmenu/styles.css">
<script src="js/jquery.min.js"></script>
<script src="js/cssmenu/script.js"></script>
<script type="text/javascript" src="js/jquery.easing.1.3.js"></script>
<script src="src/jquery.anyslider.js"></script>
<script src="js/bootstrap.js"></script>
<script src="js/moment-with-locales.js"></script>
<script type="text/javascript" src="js/bootstrap-datepicker.js"></script>
<title><?=$bsiCore->config['conf_portal_name']?> : checkout_step2</title>
</head>

<body>


<header>
	<?php include("header.php");?>	
</header>


<div class="container-fluid">
    <div class="row container-background">
        <section class="container" >
        	<div class="row">
            <div class="container-fluid">
                
                
                <div class="row">
                	<div class="container-fluid">
                		<div class="row">
                        	
                            <div class="col-md-8 col-md-push-4">
                            	<h2 class="sett4"><?=NEW_BOOKIING_CHECKOUT?></h2>
                                <div class="container-fluid">
                					<div class="row mrb20">
                        				<div class="col-md-12 sernbox">
                                             <div class="container-fluid">
                                                <div class="row">
                                                    <div class="col-md-12 col-sm-12 ">
                                                    	
                                              <div class="container-fluid">
                                                <div class="row">
                                                    <div class="col-md-4 col-sm-4 col-xs-4 chkst chkstps1-off">
             <p><?=STEP_FIRST?><span><?=GET_STARTED?></span></p>
                                                    </div>                            
                                                    <div class="col-md-4 col-sm-4 col-xs-4 chkst chkstps2-on">
<p><?=STEP_TWO?>
<span><?=ROOMS_GUEST_DETAILS?></span></p>              
                                                   </div>                            
                                                    <div class="col-md-4 col-sm-4 col-xs-4 chkst chkstps3-off">
<p><?=STEP_THREE?>
<span><?=COFIRMATION?></span></p>                         
                                                   </div>                               					
                                                </div>
                                                <br />
                                               
                                                <div class="row">
                                                    <div class="col-md-12">
													
			<!--<form name="checkout" id="checkout" method="post" action="bookingProcess2.php" >-->
			
                                                    
             <div class="container-fluid"> 
			 
			 
			 <!--promo code -->
			 
			 <div class="row graybox_bg">
			 
			 <div class="col-md-2">

                      	<!--<button class="form-control searchbtn ptp">Proceed to Pay Rs.10</button>-->

                      </div>
			 
			<div class="col-md-5">
                        <p class="rim" ><strong><?=NEW_ENTER_CUPPON_CODE?></strong></p>
                        <span class="rim-error" id="msgerror"></span>
                        <span class="rim-success" id="success"></span>
                      </div>

                      <div class="col-md-5">

                        <a class="hapc" href="javascript:void(0)"><?=NEW_HAVE_A_PROMO_CODE?></a>

                        <div class="inpbox form-control roundcorner">

                        	<input class="inp-code" type="text" placeholder="Voucher Code"  id="discount_coupon" name="discount_coupon">

                            <div class="codeapply" id="btn_coupon_apply"><?=NEW_APPLY?></div>

                        </div>

                      </div>

                      <!--<div class="col-md-3">

                      	<button class="form-control searchbtn ptp">Proceed to Pay Rs.10</button>

                      </div>-->

                  </div>
				  
				  <!--End Of Promo Code-->
			 <br />
			 
			 <form name="checkout" id="checkout" method="post" action="bookingProcess2.php" >
			 <input  type="hidden" id="email" value="<?php echo $email;?>">
                
				  
<?php  
if(isset($_SESSION['agent']) && $_SESSION['agent'] == 1){
$chkagentid=$_SESSION['agent'];
echo $bsiCore->personalDetailsEntry();
}else{
$chkagentid=0;
echo $bsiCore->personalDetails($name, $email);
}
 ?>
				  
        
<div class="row">
<div class="col-md-12">
    <div class="checkbox">
    <label>
    <input type="checkbox" name="termsCondition" id="termsCondition" value="agree" checked /> <?=I_AGREE_WITH?>
    </label>
    <a href="javascript:void(0)" onClick="javascript:myPopup();" class="tser"><?=TERMS_AND_SERVICES?>  </a>
    </div>
    </div>
</div>

                  
                 <!-- <form action="checkpoin3.html">-->
                  <div class="row graybox">
                      <div class="col-md-12">
                      	<h2 class="settpd"><?=PAYMENT_METHOD?></h2>
						
			<?php

		$sql_payment_gateway=mysql_query("select * from  bsi_payment_gateway where enabled=1");

		while($row_payment_gateway=mysql_fetch_assoc($sql_payment_gateway)){

			if($row_payment_gateway['gateway_code']=='cc'){

		?>
		<div class="checkbox">	
   		 <label>
        <input type="radio"  value="<?=$row_payment_gateway['gateway_code']?>"   id="creditcard" name="payment_gateway"  onClick="validatecreditcard();" > <?=$row_payment_gateway['gateway_name']?>
		</label>
  		</div>
		
		
		
		<?php }else{ ?>
		
		  <div class="checkbox">	
   		 <label>
        <!--<input type="radio"  value="<?=$row_payment_gateway['gateway_code']?>"   id="payment_gateway" name="payment_gateway" class="paycls"> <?=$row_payment_gateway['gateway_name']?>-->
        
        <button value="<?=$row_payment_gateway['gateway_code']?>"   id="payment_gateway" name="payment_gateway" class="form-control" ><?=$row_payment_gateway['gateway_name']?></button>
		</label>
  		</div>
		  
		  
          <?php } } ?>			
						
 
 <div id="creditcard-box" class="container-fluid graybox2">
  		<p class="creditcard"><?=NEW_FILL?></p>
       <div class="row">
            <div class="col-md-6 col-sm-6"><?=CARD_HOLDER_NAME?></div>
            <div class="col-md-6 col-sm-6">
            <div class="form-group ">
            <input type="text" class="form-control roundcorner" name="cc_holder_name" id="cc_holder_name">
            </div>
            </div>
       </div>
       <div class="row">
            <div class="col-md-6 col-sm-6"><?=CREDIT_CARD_TYPE?></div>
            <div class="col-md-6 col-sm-6">
            <div class="form-group ">
            <select class="form-control roundcorner" name="CardType" id="CardType">
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
            </select>
            </div>
            </div>
       </div>
       <div class="row">
            <div class="col-md-6 col-sm-6"><?=CREDIT_CARD_NUMBER?></div>
            <div class="col-md-6 col-sm-6">
            <div class="form-group ">
            <input type="text" class="form-control roundcorner" name="CardNumber" maxlength="16" id="CardNumber" >
            </div>
            </div>
       </div>
       <div class="row">
            <div class="col-md-6 col-sm-6"><?=EXPIRATION_DATE?></div>
            <div class="col-md-6 col-sm-6">
            <div class="form-group ">
        
			
<?php
			//$dtHtml=''; 
$dtHtml= '<select class="form-control roundcorner"  style="width:60px; float:left; margin-right:20px;"name="cc_exp_dt" id="cc_exp_dt">';
//$current_month=date('m');
	for($j=1; $j <=12; $j++)
	{
	$dtHtml .= ' <option value="'.$j.'">'.$j.'</option>';
	}
    $dtHtml .= '</select>';
	echo $dtHtml;		

?>

<?php
$html= $dtHtml;
$yyHtml= '<select class="form-control roundcorner" style="width:100px" name="expireyear" id="expireyear" >';
$current_year=date('Y');
for($i=$current_year; $i <= $current_year+10; $i++)
{
 	$yyHtml .= '<option value="'.$i.'">'.$i.'</option>';
}
$yyHtml .= '</select></td>';
echo $yyHtml;
$html .= $yyHtml;
?>
			
            </div>
            </div>
       </div>
       <div class="row">
            <div class="col-md-6 col-sm-6"><?=CVC_CODE?></div>
            <div class="col-md-6 col-sm-6"><input type="text" class="form-control roundcorner" name="cc_ccv" id="cc_ccv" maxlength="4" ></div>
       </div>
  </div> 
 
   
  
  

  
<!--<div class="row">

<div class="col-md-4">
<button value="pp"   id="payment_gateway" name="payment_gateway" class="form-control" ><img src="http://feelspark.com/images/pp_here_flat.png" width="75%"></button>
</div>
</div>-->

	<!--
    For previous one
    <div class="checkbox">	
    <label>
            <input type="radio"  value="pp"   id="payment_gateway" name="payment_gateway" class="paycls" style="display:none"><img src="http://feelspark.com/images/paypal.JPG" width="50%">
            </label>
    </div>-->

<!--</div>
 <br />
<div class="col-md-2 ">
</div>
  
<div class="col-md-4 ">-->

<!--<button value="pp"   id="payment_gateway" name="payment_gateway" class="form-control" ><img src="http://feelspark.com/images/visa-mastercard-logo.png" width="68%"></button>-->
    <!--<div class="checkbox">	
     <label>
            <input type="radio"  value="pp"   id="payment_gateway1" name="payment_gateway" class="paycls" style="display:none">
            <img src="http://feelspark.com/images/creditcard.JPG" width="50%">
    </label>
    </div>-->

 <br />
<div class="row">
  <div class="col-md-6 ">
<button value="pp"   id="payment_gateway" name="payment_gateway" class="form-control" style="height:12%"><img src="http://feelspark.com/images/visa-mastercard-logo.png" width="75%" height="100%"></button>
</div>
</div>
  <br />
  
                      </div>
                  </div>
                  <br />
                  
                  
<!--<div class="checkbox">
    <label>
    <input type="checkbox" name="termsCondition" id="termsCondition" value="agree" /> <?=I_AGREE_WITH?>
    </label>
    <a href="javascript:void(0)" onClick="javascript:myPopup();" class="tser"><?=TERMS_AND_SERVICES?>  </a>
    </div>-->
                  
<!--<div class="row">
    <div class="col-md-6">
    
    </div>

    <div class="col-md-6">
    <input type="submit" value="<?=NEXT_STEP?>"   disabled  class="form-control searchbtn" id="nextstep" name="nextstep">
    </div>

</div>-->

</form>
</div>
                                                  
     
                                                     </div>
                                                </div>
                                              </div>
                                                    </div> 
                                                </div>
                                                <div class="clr"></div>
                                             </div>
                                        </div>
                                    </div>
                                                                        
                                </div>
                            </div>
                            
                            <div class="col-md-4 col-md-pull-8">
                            	<div class="container-fluid">
                					<div class="row">
                        				<div class="col-md-12 sernbox">
                                            <h2 class="sett3"><span><?=ROOM_CHARGES?></span><?=$hotelDetails['hotel_name']?></h2>
                                            <div class="clr"></div>
                                            <div class="container-fluid" style="padding:10px 15px">
											
											
<?php
			 $count         = count($roomtypeArray);
			 $gettotalPrice = 0;
			 $roomtype      = '';
			 $getRoom       = '';
			 $totalRooms    = 0;
			 $totalAdults   = 0;
			 $child_price=0;
			  $child_price = 0;
			 $child_caption ='';
			 $ssr=0;
			 $onr=0;
			 for($i=0;$i<$count;$i++){
				 
$sql = mysql_query("SELECT * FROM bsi_roomtype WHERE roomtype_id = ".$roomtypeArray[$i]['roomTypeId']);
$type = mysql_fetch_assoc($sql);
//echo "==>".$type['roomtype_name'];
if($type['roomtype_name']=='Short Stay Room')
{
$ssr=$ssr+1;
}else{
$onr=$onr+1;	
}		
				 if($i+1 == $count){
					 $getRoom.=$roomtypeArray[$i]['Qty']." x ".$roomtypeArray[$i]['roomTypeName']."(".$roomtypeArray[$i]['capacityTitle'].")";
					 $roomtype.=$roomtypeArray[$i]['Qty']." x ".$roomtypeArray[$i]['roomTypeName']."(".$roomtypeArray[$i]['capacityTitle'].")";
					  $child_price+=$roomtypeArray[$i]['child_price'];
					 $totalAdults = $totalAdults+($roomtypeArray[$i]['Qty']*$roomtypeArray[$i]['noofadults']);
				 }else{
					 $getRoom.=$roomtypeArray[$i]['Qty']." x ".$roomtypeArray[$i]['roomTypeName']."(".$roomtypeArray[$i]['capacityTitle'].")<br/>";
					 $roomtype.=$roomtypeArray[$i]['Qty']." x ".$roomtypeArray[$i]['roomTypeName']."(".$roomtypeArray[$i]['capacityTitle'].")<br/>";
					 $totalAdults = $totalAdults+($roomtypeArray[$i]['Qty']*$roomtypeArray[$i]['noofadults']);
					  $child_price+=$roomtypeArray[$i]['child_price'];
				 }
				 $totalRooms = $totalRooms+$roomtypeArray[$i]['Qty'];;
			 }
			 $getRoom              .= '</td></tr>';
			 $_SESSION['getRoom']   = $roomtype;
			 $_SESSION['sv_rooms']  = $totalRooms;
			 $_SESSION['sv_adults'] = $totalAdults;
			 
			  $_SESSION['sv_child_price'] = $child_price;
			 
			$child_caption ='';
			if($child_price>0){
				$child_caption=' ('.NEW_INCLUDEING_CHILD_PRICE.' '.$bsiCore->get_currency_symbol($_SESSION['sv_currency']). $bsiCore->getExchangemoney($child_price,$_SESSION['sv_currency']).')';
			}			
			if($ssr>0 && $onr>0)
			{$checkout=$_SESSION['sv_checkoutdate'];}
			if($ssr>0 && $onr==0)
			{$checkout=$_SESSION['sv_checkindate'];}
			if($ssr==0 && $onr>0)
			{$checkout=$_SESSION['sv_checkoutdate'];}
			
		?>											

                                            	
                                                <div class="row">
                                                    <div class="col-md-6 col-sm-6 col-xs-6" id="dicountdisplay"><p class="pstl"><strong><?=CHECK_IN?>:</strong></p></div>
                                                    <div class="col-md-6 col-sm-6 col-xs-6"><p class="pstl" id="pstl1"><?=$_SESSION['sv_checkindate']?></p></div>
                                                </div>
                                              
                                                <div class="row">
                                                    <div class="col-md-6 col-sm-6 col-xs-6"><p class="pstl"><strong><?php echo ROOOM;?>:</strong></p></div>
                                                    <div class="col-md-6 col-sm-6 col-xs-6"><p class="pstl"> <?php echo $getRoom;?></p></div>
                                                </div>
												
												<?php	if(isset($_SESSION['extra_price'])){ ?>
												<div class="row">
                                                    <div class="col-md-6 col-sm-6 col-xs-6"><p class="pstl"><strong><?=NEW_EXTRA_BED_PRICE?></strong></p></div>
                                                    <div class="col-md-6 col-sm-6 col-xs-6"><p class="pstl"><?=$bsiCore->get_currency_symbol($_SESSION['sv_currency']).$bsiCore->getExchangemoney($_SESSION['extra_price'],$_SESSION['sv_currency'])?></p></div>
                                                </div>
												<?php }?>
												
                                                <div class="row">
                                                    <div class="col-md-6 col-sm-6 col-xs-6"><p class="pstl"><strong><?=TOTAL_ROOM_PRICE?>:</strong></p></div> 	
                                                    <div class="col-md-6 col-sm-6 col-xs-6"><p class="pstl ttl2"  id="ccode1">
                                                    <?=$bsiCore->get_currency_symbol($_SESSION['sv_currency']).$bsiCore->getExchangemoney($_SESSION['tot_roomprice'],$_SESSION['sv_currency'])?><?=$child_caption;?></p></div>
                                                </div>
												
												
												
                                            </div>
                                             <?php	if(!empty($_SESSION['listExtraService'])){ 
											 echo '<h2 class="sett3"><span>'.EXTRAS.'</span></h2>
                                            <div class="clr"></div>
                                            <div class="container-fluid" style="padding:10px 15px">';
											foreach($_SESSION['listExtraService'] as $value){ 
											
												echo '<div class="row">
												 <div class="col-md-6 col-sm-6 col-xs-6"><p class="pstl"><strong>'.$value['description'].' :</strong></p></div>
                                                    <div class="col-md-6 col-sm-6 col-xs-6"><p class="pstl">'.$bsiCore->get_currency_symbol($_SESSION['sv_currency']).$bsiCore->getExchangemoney($value['totalprice'],$_SESSION['sv_currency']).'</p></div>
                                                </div>';
												 } 
                                                echo '</div>';
												} ?>  

<h2 class="sett3"><span>
<span>
<div class="col-md-6 col-sm-6 col-xs-6"><p class="pstl"><strong><?php echo SUB_TOTAL;?>:</strong></p></div> 	
<div class="col-md-6 col-sm-6 col-xs-6"><p class="pstl ttl2"><?=$bsiCore->get_currency_symbol($_SESSION['sv_currency']).$bsiCore->getExchangemoney($_SESSION['total_cost'],$_SESSION['sv_currency'])?></p></div>
</span>
</span></h2>
                                            <div class="clr"></div>
                                            <div class="container-fluid" style="padding:10px 15px">
                                                <!--<div class="row">
                                                    <div class="col-md-6 col-sm-6 col-xs-6"><p class="pstl"><strong>Room Subtotal:</strong></p></div>
                                                    <div class="col-md-6 col-sm-6 col-xs-6"><p class="pstl"><?=$bsiCore->config['conf_currency_symbol'].number_format($_SESSION['total_cost'],2)?></p></div>
                                                </div>-->
												<!--<div class="row">
                                                    <div class="col-md-6 col-sm-6 col-xs-6"><p class="pstl"><strong><?php echo SUB_TOTAL;?>:</strong></p></div> 	
                                                    <div class="col-md-6 col-sm-6 col-xs-6"><p class="pstl ttl2">
                                                   <?=$bsiCore->get_currency_symbol($_SESSION['sv_currency']).$bsiCore->getExchangemoney($_SESSION['total_cost'],$_SESSION['sv_currency'])?><?=$child_caption;?></p></div>
                                                </div>-->
												<div class="row" >
												 <div class="col-md-6 col-sm-6 col-xs-6"><p class="pstl" id="csuccess"><strong></strong></p></div> 	
                                                    <div class="col-md-6 col-sm-6 col-xs-6"><p class="pstl" id="ccode"></p></div>
                                                </div>
												
												<?php
												$month_num = intval(substr($_SESSION['checkin_date'], 5, 2)) ;
												$sql = mysql_query("SELECT * FROM bsi_deposit_discount WHERE month_num = ".$month_num);
												$discountpercent = mysql_fetch_assoc($sql);
												if($discountpercent['discount_percent'] > 0){?>
					<div class="row">
                   <div class="col-md-6 col-sm-6 col-xs-6"><p class="pstl"><strong><?=NEW_MONTHLY_DISCOUNT_SCHEME?>(<?=$discountpercent['discount_percent']?>%):</strong></p></div>
                   <div class="col-md-6 col-sm-6 col-xs-6"><p class="pstl" id="c_monthly_discount">(-)<?php echo $bsiCore->get_currency_symbol($_SESSION['sv_currency']).$bsiCore->getExchangemoney($_SESSION['discount_amount'],$_SESSION['sv_currency']);?></p></div>
                   </div>
												<?php } ?>
												
												<?php
												if($bsiCore->config['conf_tax_amount']>0){?>
												
                                                <div class="row">
                                                    <div class="col-md-6 col-sm-6 col-xs-6"><p class="pstl"><strong><?=TAX_FEES?> (<?=$bsiCore->config['conf_tax_amount']?> %)</strong></p></div>
                                                    <div class="col-md-6 col-sm-6 col-xs-6"><p class="pstl" id="c_tax_amount"><?php echo $bsiCore->get_currency_symbol($_SESSION['sv_currency']).$bsiCore->getExchangemoney($_SESSION['tax'],$_SESSION['sv_currency']);?></p></div>
                                                </div>
												
												<?php } ?>
												
                                                <!--<div class="row">
                                                    <div class="col-md-6 col-sm-6 col-xs-6"><p class="pstl ttl"><strong><?=TOTAL?></strong></p>
                                                    </div> 	
                                                    <div class="col-md-6 col-sm-6 col-xs-6"><p class="pstl ttl" id="c_total_cost">
                                                    <?php echo $bsiCore->get_currency_symbol($_SESSION['sv_currency']).$bsiCore->getExchangemoney($_SESSION['grandtotal'],$_SESSION['sv_currency']);?></p></div>
                                                </div>-->
												
												
												<?php
												$month_num = intval(substr($_SESSION['checkin_date'], 5, 2)) ;
												$sql = mysql_query("SELECT * FROM bsi_deposit_discount WHERE month_num = ".$month_num);
												$discountpercent = mysql_fetch_assoc($sql);
												if($discountpercent['deposit_percent'] > 0){
												//$deposite=(($_SESSION['total_cost_after_discount']+$_SESSION['tax'])*$depositepercent['deposit_percent'])/100;
												?>
					<div class="row">
                   <div class="col-md-6 col-sm-6 col-xs-6"><p class="pstl" style="color:red"><strong><?=$discountpercent['deposit_percent']?>% <?=DEPOSITT?> :</strong></p></div>
                   <div class="col-md-6 col-sm-6 col-xs-6"><p class="pstl" style="color:red"><strong><?=$bsiCore->get_currency_symbol($_SESSION['sv_currency']).$bsiCore->getExchangemoney($_SESSION['aaaa'],$_SESSION['sv_currency'])?></strong></p></div>
                   </div>
                   
                   <?php $adv_amt=$_SESSION['total_cost']-$_SESSION['aaaa'];?>
                   <div class="row">
                   <div class="col-md-6 col-sm-6 col-xs-6"><p class="pstl" style="color:red"><strong><?=DOWNPAYMENT_DUE?> :</strong></p></div>
                   <div class="col-md-6 col-sm-6 col-xs-6"><p class="pstl" style="color:red"><strong><?=$bsiCore->get_currency_symbol($_SESSION['sv_currency']).$bsiCore->getExchangemoney($adv_amt,$_SESSION['sv_currency'])?></strong></p></div>
                   </div>
												<?php } ?>
												
                                            </div>
                                            
                                            <h2 class="sett3"><span><?=CANCELLATION_POLICY?> </span></h2>
                                            <div class="clr"></div>
                                            <div class="container-fluid" style="padding:10px 15px">
                                                <div class="row">
                                                    <div class="col-md-12">
                                                    	 <?=$hotelDetails['terms_n_cond']?>
                                                    </div>
                                                </div>
                                            </div>
                                             <h2 class="sett3"><span>Customer Notes</span></h2>
                                           
                                            <div class="container-fluid" style="padding:10px 15px">
                                                <div class="row">
                                                    <div class="col-md-12">
                                                    	 <?=$hotelDetails['customer_notes'];?> 
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                            
                            
                            
                        </div>
                    </div>
                </div>
                
            </div>
            </div>
        </section>
	</div>
</div>


<?php include("footer.php");?>



<script type="text/javascript">	

$(document).ready(function(){
//enabling disabling submit button//
$('#termsCondition').change(function() { 
//alert('ok');
if ($(this).is(':checked')) {
// ENABLE
//alert('hhhh');
$("#nextstep").removeAttr("disabled");
} else {
// DISABLE            
$("#nextstep").attr("disabled", "disabled");
}
});
//**********************************//
});
//]]>
</script>

<script type="text/javascript">

	function myPopup(){

		var width = 730;

		var height = 650;

		var left = (screen.width - width)/2;

		var top = (screen.height - height)/2;

		var url='term_condition.php';

		var params = 'width='+width+', height='+height;

		params += ', top='+top+', left='+left;

		params += ', directories=no';

		params += ', location=no';

		params += ', menubar=no';

		params += ', resizable=no';

		params += ', scrollbars=yes';

		params += ', status=no';

		params += ', toolbar=no';

		newwin=window.open(url,'Chat', params);

		if (window.focus) {newwin.focus()}

		return false;

	}

</script>

<script>
$(document).ready( function(){
$('.hapc').on('click',function(){
$(this).next().show();
$(this).hide();
});

$('.codeapply').on('click',function(){ 
$('.rim-error').show();
});
});
</script>

<script>
$(document).ready( function(){
$('#btn_coupon_apply').click(function() {	
if($('#discount_coupon').val() != "" ){

	   
	    var querystr = 'actioncode=17&discountcoupon='+$('#discount_coupon').val();
		querystr += '&clientemail='+$('#email').val(); 	
		querystr += '&agent='+<?php echo $chkagentid;?>; 	
		
		$.post("ajax-processor.php", querystr, function(data){
		if(data.errorcode == 0){
		$('#csuccess').html("<?=NEW_CUPPON?>   <strong>"+data.couponcode+"</strong>  <?=NEW_APPLIED?>"); 
		$('#msgerror').html(data.strmsg); 
		$('#ccode').html(" (-) <?=$bsiCore->config['conf_currency_symbol']?>  "+data.fmdiscount);
		$('#c_monthly_discount').html(" (-) <?=$bsiCore->config['conf_currency_symbol']?>  "+data.fmdiscount_amount);
		$('#c_tax_amount').html(" (+) <?=$bsiCore->config['conf_currency_symbol']?>  "+data.fmtaxamount);
		$('#c_total_cost').html("<?=$bsiCore->config['conf_currency_symbol']?>  "+data.fmgrandtotal);
		$('#c_total_pay_amount').html("<?=$bsiCore->config['conf_currency_symbol']?>  "+data.fmtotal_pay_amount);
		//alert(data.strmsg);	  
			} else { 
		//alert(data.strmsg);	
		$('#msgerror').html(data.strmsg);		
		$('#csuccess').html(""); 
		$('#ccode').html("");
		$('#c_monthly_discount').html(" (-) <?=$bsiCore->config['conf_currency_symbol']?>  "+data.fmdiscount_amount);
		$('#c_tax_amount').html(" (+) <?=$bsiCore->config['conf_currency_symbol']?>  "+data.fmtaxamount);
		$('#c_total_cost').html("<?=$bsiCore->config['conf_currency_symbol']?>  "+data.fmgrandtotal);
		$('#c_total_pay_amount').html("<?=$bsiCore->config['conf_currency_symbol']?>  "+data.fmtotal_pay_amount);
		
			}				

		}, "json");

		}else{alert("please Enter a Promo code");}

	});
	});
</script>



<script type="text/javascript">
    $(document).ready(function() {
		$('#creditcard').on('click',function(){
			$('#creditcard-box').slideDown();
		});
		$('.paycls').on('click',function(){
			$('#creditcard-box').slideUp();
		});
		
		
		
	});
</script>

<!--<script type="text/javascript">

	$(document).ready(function() {

	$("#nextstep").click(function(){

	if($("#creditcard").val()=="cc" )
	{
	
			if($("#cc_holder_name").val()=="" )
			{
					alert("plesse , enter Creditcard Holder name ");
					return false;
						}else if($("#CardNumber").val()=="" ){
							alert("Please , Enter Your Credit Card No");
							 return false;
								}else if($("#cc_ccv").val()=="" ){
									alert("Please , Enter Your CCV");
							 		return false;
										}else{
											return true;
											     }
															
}
});
});
</script>-->

<!--<script type="text/javascript">

	$(document).ready(function() {

	$("#nextstep").click(function(){
		
	if($("#hotel_name").val()=="" ){
	alert("Please Enter Hotel Name ");
	return false;
							}
													
							
						
						else{
								return true;
								}
	});
	});
</script>-->

<script type="text/javascript">

function validatecreditcard() {
   
 if (document.getElementById("creditcard").checked == true) {
     
$("#nextstep").click(function(){
	if($("#cc_holder_name").val()=="" ){
	alert("<?php echo CARD_HOLDER_NAME;?>");
	return false;}
	
		else if($("#CardNumber").val()=="" ){	
					alert("<?php echo CREDIT_CARD_NUMBER;?>");
					return false;}

						else if($("#cc_ccv").val()=="" ){
									alert("<?php echo CVC_CODE;?>");
							 		return false;}
									else
									{ return true;}
});
    }
   
    }

</script>
<script type="text/javascript">	

	$(document).ready(function(){

				

		$("#nextstep").click(function() {

    		
        if ($("input[name='payment_gateway']").is(':checked')) {
          
		   
		   return true;
        }
        else {
			alert("Please Choose a Paymenttype.");
          return false;
        }
       
   });

		

	});
	</script>
</body>
</html>
