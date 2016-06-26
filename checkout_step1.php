<?php
 session_start();
 
if(isset($_SESSION['password_2012'])){
 header("location:checkout_step2.php");
 exit;
}

$booking_permission=1; 
 
//echo base64_decode($_REQUEST['bp']);die;
if(base64_decode($_REQUEST['bp'])==0)
{
	 $booking_permission=0;
}

if(base64_decode($_REQUEST['bp'])==9)
{
	 $booking_permission=9;
}

//echo $booking_permission;

if(isset($_SESSION['hotelsearch'])){
	unset($_SESSION['hotelsearch']);
}
include("includes/db.conn.php");
include("includes/conf.class.php");
include("includes/language.php"); 

$hotel_id      = $_SESSION['hotel_id'];
$hotelDetails  = $bsiCore->getHotelDetails($hotel_id); 
if(isset($_SESSION['language'])){
	$htmlCombo=$bsiCore->getbsilanguage($_SESSION['language']); 
}else{
	$htmlCombo=$bsiCore->getbsilanguage(); 
	}
	
	
	
?> 


<?php
if($booking_permission==1)
{
			 $roomtypeArray = $_SESSION['RoomType_Capacity_Qty'];
			 $count         = count($roomtypeArray);
			 $gettotalPrice = 0;
			 $roomtype      = '';
			 $getRoom       = '';
			 $totalRooms    = 0;
			 $totalAdults   = 0;
			 $child_price=0;
			 $ssr=0;
			 $onr=0;
			 for($i=0;$i<$count;$i++){
				 
$sql = mysql_query("SELECT * FROM bsi_roomtype WHERE roomtype_id = ".$roomtypeArray[$i]['roomTypeId']);
$type = mysql_fetch_assoc($sql);
if($type['roomtype_name']=='Short Stay Room')
{
$ssr=$ssr+1;
}else{
$onr=$onr+1;	
}			
				 if($i+1 == $count){
		 
					 //echo $roomtypeArray[$i]['roomTypeId'];
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
				 $totalRooms = $totalRooms+$roomtypeArray[$i]['Qty'];
				 
				/* $searchsql = "		
		SELECT rm.room_id, rm.room_no
		  FROM bsi_room rm
		 WHERE rm.roomtype_id = ".$roomtypeArray[$i]['roomTypeId']."
			   AND rm.capacity_id = ".$roomtypeArray[$i]['capcityid']."
			   AND rm.room_id NOT IN
					  (SELECT resv.room_id
						 FROM bsi_reservation resv, bsi_bookings boks
						WHERE     boks.is_deleted = FALSE   
							  AND resv.booking_id = boks.booking_id
							  AND resv.roomtype_id = ".$roomtypeArray[$i]['roomTypeId']."
							  AND (('".$_SESSION['sv_mcheckindate']."' BETWEEN boks.checkin_date AND DATE_SUB(boks.checkout_date, INTERVAL 1 DAY))
							   OR (DATE_SUB('".$_SESSION['sv_mcheckoutdate']."', INTERVAL 1 DAY) BETWEEN boks.checkin_date AND DATE_SUB(boks.checkout_date, INTERVAL 1 DAY))
							   OR (boks.checkin_date BETWEEN '".$_SESSION['sv_mcheckindate']."' AND DATE_SUB('".$_SESSION['sv_mcheckoutdate']."', INTERVAL 1 DAY))
							   OR (DATE_SUB(boks.checkout_date, INTERVAL 1 DAY) BETWEEN '".$_SESSION['sv_mcheckindate']."' AND DATE_SUB('".$_SESSION['sv_mcheckoutdate']."', INTERVAL 1 DAY))))";*/
							   
		/*$sql = mysql_query($searchsql);
		$availableroomno=mysql_num_rows($sql);
		
		if($availableroomno==0)
		{
		$booking_permission=0;
		}*/
		
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
			 }

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
<title><?=$bsiCore->config['conf_portal_name']?> : Checkout_step1</title>
</head>

<body>


<header>
	<?php include("header.php");?>	
</header>



<div class="container-fluid">
    <div class="row container-background">
        <section class="container">
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
                                                    <div class="col-md-4 col-sm-4 col-xs-4 chkst chkstps1-on">
             <p><?=STEP_FIRST?><span><?=GET_STARTED?></span></p>
                                                    </div>                            
                                                    <div class="col-md-4 col-sm-4 col-xs-4 chkst chkstps2-off">
<p><?=STEP_TWO?>
<span><?=ROOMS_GUEST_DETAILS?></span></p>              
                                                   </div>                            
                                                    <div class="col-md-4 col-sm-4 col-xs-4 chkst chkstps3-off">
<p><?=STEP_THREE?>
<span><?=COFIRMATION?></span></p>                         
                                                   </div>                               					</div>
                                                 
                                               
                                                <br />

<div class="row">
<div class="col-md-12">
    
    
    
                                                    
<div class="container-fluid">

<?php if($booking_permission==1) {?>

<div class="row">                    
<form action="clients_registration.php" id="round-form" name="round-form" method="post">                     
<input value="account" id="account_selection" name="account_selection" type="hidden">

<?php 
$AccountNo = time();
$_SESSION['AccountNo'] = $AccountNo;
?>
                      
<div class="row">
    <div class="col-md-4 col-sm-4 col-xs-5">
    <div class="form-group">
    <label class="chkdate" for="exampleInputEmail1"><?=FIRSTNAME?><span class="strred">*</span></label>
    </div>
    </div>

    <div class="col-md-8 col-sm-8 col-xs-7">
    <div class="form-group">
    <input type="text" class="form-control roundcorner" name="customer_name" id="customer_name">
    </div>
    </div>
</div>
                      
<div class="row">
    <div class="col-md-4 col-sm-4 col-xs-5">
    <div class="form-group">
    <label class="chkdate" for="exampleInputEmail1">Email<span class="strred">*</span></label>
    </div>
    </div>

    <div class="col-md-8 col-sm-8 col-xs-7">
    <div class="form-group">
    <input type="text" class="form-control roundcorner" name="customer_email" id="customer_email">
    </div>
    </div>
</div>

   
<div class="row">
    <div class="col-md-4 col-sm-4 col-xs-5">
    <div class="form-group">
    <label class="chkdate" for="exampleInputEmail1"><?=PHONE?><span class="strred">*</span></label>
    </div>
    </div>
 
    <div class="col-md-8 col-sm-8 col-xs-7">
    <div class="form-group">
    <input type="text" class="form-control roundcorner" name="customer_phone" id="customer_phone">
    </div>
    </div>
</div>

<div class="row">
    <div class="col-md-4">
    </div>
    
    <div class="col-md-8">
    <div class="form-group">
    <input type="submit" class="form-control searchbtn" value="<?php echo NEXT;?>" id="login" name="login">
    </div>
    </div>
</div>                      
 
</form>
</div>

<?php }else if($booking_permission==0){ ?> 
<div class="row">
    <div class="col-md-12 col-sm-12 col-xs-12">
    <div class="form-group">
    <label class="chkdate" for="exampleInputEmail1">Sorry, Your Selected Room is now sold out . Please go back and try for different criteria !</label>
    </div>
    </div>

    
</div>
<?php }else { ?>
<div class="row">
    <div class="col-md-12 col-sm-12 col-xs-12">
    <div class="form-group">
    <label class="chkdate" for="exampleInputEmail1">Sorry, Booking is unavailable for <strong><?php echo $hotelDetails['hotel_name'];?> </strong>!</label>
    </div>
    </div>

    
</div>

<?php }?>

                  
</div>
                                                 
                                                    </div>
                                                </div>
                                              </div>
                                                    </div> 
                                                </div>
                                                <!--<div class="clr"></div>-->
                                             </div>
                                        </div>
                                    </div>
									
									<?php
		 if(isset($_SESSION['isError']) && $_SESSION['isError']==2){ 
		 	 echo '<span style="color:red;">Email Id already exist in our client database!</span>'; 
			 unset($_SESSION['isError']);
		 }else if(isset($_SESSION['isError']) && $_SESSION['isError']==1){ 
		 	 echo '<span style="color:red;">'.EMAIL_OR_PASSWORD_INCORRECT.'</span>'; 
			 unset($_SESSION['isError']);
		 }
	 	?>
                                </div>
                            </div>
                        
                        
                        
                        
                        
                        	<div class="col-md-4 col-md-pull-8">
                            	<div class="container-fluid">
                					<div class="row">
                        				<div class="col-md-12 sernbox">
<h2 class="sett3"><span><?php echo ROOM_CHARGES;?></span><?php echo $hotelDetails['hotel_name'];?></h2>
<div class="clr"></div>

<div class="container-fluid" style="padding:10px 15px">
											
<div class="row">
<div class="col-md-6 col-sm-6 col-xs-6"><p class="pstl"><strong><?=CHECK_IN?>:</strong></p></div>
<div class="col-md-6 col-sm-6 col-xs-6"><p class="pstl"><?=$_SESSION['sv_checkindate']?></p></div>
</div>

 <!--                                              <div class="row">
                                                    <div class="col-md-6 col-sm-6 col-xs-6"><p class="pstl"><strong><?=CHECK_OUT?>:</strong></p></div>
                                                    <div class="col-md-6 col-sm-6 col-xs-6"><p class="pstl"><?php echo $checkout;?></p></div>
                                                </div>	-->
											  <!--<div class="row">
                                                    <div class="col-md-6 col-sm-6 col-xs-6"><p class="pstl"><strong><?=NIGHTS?>:</strong></p></div>
                                                    <div class="col-md-6 col-sm-6 col-xs-6"><p class="pstl"><?=$_SESSION['sv_nightcount']?></p></div>
                                                </div>-->
<div class="row">
<div class="col-md-6 col-sm-6 col-xs-6"><p class="pstl"><strong><?php echo ROOOM;?>:</strong></p></div>
<div class="col-md-6 col-sm-6 col-xs-6"><p class="pstl">
<?php if($booking_permission==0 || $booking_permission==9 ){ 
echo "N/A";
}else{
echo $getRoom;
}?></p></div>
</div>
                                               
                                            
                                               
												
<?php	if(isset($_SESSION['extra_price'])){ ?>
<div class="row">
<div class="col-md-6 col-sm-6 col-xs-6"><p class="pstl"><strong><?=NEW_EXTRA_BED_PRICE?> :</strong></p></div>
<div class="col-md-6 col-sm-6 col-xs-6"><p class="pstl"><?=$bsiCore->get_currency_symbol($_SESSION['sv_currency']).$bsiCore->getExchangemoney($_SESSION['extra_price'],$_SESSION['sv_currency'])?></p></div>
                                                </div>
												<?php }?>
												
<?php if($booking_permission==1){ ?>
<div class="row">
<div class="col-md-6 col-sm-6 col-xs-6"><p class="pstl"><strong><?=TOTAL_ROOM_PRICE?></strong></p></div> 	
<div class="col-md-6 col-sm-6 col-xs-6"><p class="pstl ttl2">
<?=$bsiCore->get_currency_symbol($_SESSION['sv_currency']).$bsiCore->getExchangemoney($_SESSION['tot_roomprice'],$_SESSION['sv_currency'])?><?=$child_caption;?></p></div>
</div>
<?php } ?>
</div>

<?php	if(!empty($_SESSION['listExtraService'])){ 
echo '<h2 class="sett3"><span>'.EXTRAS.'</span></h2>
<div class="clr"></div>
<div class="container-fluid" style="padding:10px 15px">';
foreach($_SESSION['listExtraService'] as $value){ 
echo '<div class="row">
	  <div class="col-md-6 col-sm-6 col-xs-6"><p class="pstl"><strong>'.$value['description'].' :</strong></p></div>
	  <div class="col-md-6 col-sm-6 col-xs-6"><p class="pstl">'.$bsiCore->get_currency_symbol($_SESSION['sv_currency']).$bsiCore->getExchangemoney($value['totalprice'],$_SESSION['sv_currency']).'</p></div></div>';
} 
echo '</div>';
} ?>  

<?php if($booking_permission==1){ ?>
<h2 class="sett3">
<span>
<div class="col-md-6 col-sm-6 col-xs-6"><p class="pstl"><strong><?php echo SUB_TOTAL;?>:</strong></p></div> 	
<div class="col-md-6 col-sm-6 col-xs-6"><p class="pstl ttl2"><?=$bsiCore->get_currency_symbol($_SESSION['sv_currency']).$bsiCore->getExchangemoney($_SESSION['total_cost'],$_SESSION['sv_currency'])?></p></div>
</span>
</h2>
<?php } ?>

<div class="clr"></div>
<?php if($booking_permission==1){ ?>

<div class="container-fluid" style="padding:10px 15px">
                                               
												
												
												<?php
												$month_num = intval(substr($_SESSION['checkin_date'], 5, 2)) ;
												$sql = mysql_query("SELECT * FROM bsi_deposit_discount WHERE month_num = ".$month_num);
												$discountpercent = mysql_fetch_assoc($sql);
												if($discountpercent['discount_percent'] > 0){?>
					<div class="row">
                   <div class="col-md-6 col-sm-6 col-xs-6"><p class="pstl"><strong><?=NEW_MONTHLY_DISCOUNT_SCHEME?>(<?=$discountpercent['discount_percent']?>%):</strong></p></div>
                   <div class="col-md-6 col-sm-6 col-xs-6"><p class="pstl">(-)<?=$bsiCore->get_currency_symbol($_SESSION['sv_currency']).$bsiCore->getExchangemoney($_SESSION['discount_amount'],$_SESSION['sv_currency'])?></p></div>
                   </div>
												<?php } ?>
												
													<?php
												if($bsiCore->config['conf_tax_amount']>0){?>
												
                                                <div class="row">
                                                   <div class="col-md-6 col-sm-6 col-xs-6"><p class="pstl"><strong><?=TAX_FEES?> (<?=$bsiCore->config['conf_tax_amount']?> %) :</strong></p></div>
                                                    <div class="col-md-6 col-sm-6 col-xs-6"><p class="pstl"><?=$bsiCore->get_currency_symbol($_SESSION['sv_currency']).$bsiCore->getExchangemoney($_SESSION['tax'],$_SESSION['sv_currency'])?></p></div>
                                                </div>
												
												<?php } ?>
												
                                              
												
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

<?php } ?>
                                            
                                            <h2 class="sett3"><span><?=CANCELLATION_POLICY?> </span></h2>
                                            <!--<div class="clr"></div>-->
                                            <div class="container-fluid" style="padding:10px 15px">
                                                <div class="row">
                                                    <div class="col-md-12">
                                                    	 <?=$hotelDetails['terms_n_cond'];?> 
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



<!-- Modal Login -->
<div class="modal fade" id="myLogin" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            <h4 class="modal-title" id="myModalLabel"><?php echo CLIENT_LOGIN;?></h4>
          </div>
          <div class="modal-body">
           		<div class="container-fluid">
                	<div class="row">
                    	<div class="col-md-12 derror" id="error"> 
                        </div>
                    </div>
                    <div class="row">
                       <div class="col-md-12">
					   <input value="login" id="account_selection" name="account_selection" type="hidden" >
                          <div class="form-group">
                            <label for="inputEmail3" class="col-sm-2 control-label"><?php echo EMAIL;?></label>
                            <div class="col-sm-10">
							  <input type="email" class="form-control" id="inputEmail3" placeholder="<?php echo EMAIL;?>" name="inputEmail3" >
                            </div>
                          </div>
						  <br>
						  <br>
                          <div class="form-group">
                            <label for="inputPassword3" class="col-sm-2 control-label"><?php echo PASSWORD;?></label>
                            <div class="col-sm-10">
							   <input type="password" class="form-control" id="inputPassword3" placeholder="<?php echo PASSWORD;?>" name="inputPassword3" > 
                            </div>
                          </div>
						  
                          <div class="form-group">
                            <div class="col-sm-offset-2 col-sm-10">
                             
                            </div>
                          </div>
                          <div class="form-group">
                            <div class="col-sm-offset-2 col-sm-10">
                            <br />
							   <input type="submit" class="form-control searchbtn logbtn" value="<?php echo NEW_LOGIN;?>" id="submit_login" name="submit_login" >
                              <a href="javascript:void(0)" data-toggle="modal" data-target="#forpass" data-dismiss="modal" class="forpass"><?php echo NEW_FORGET_PASSWORD?></a>
                            </div>
                          </div>
                       </div>
                    </div>
                </div>
          </div>
    </div>
  </div>
</div>

<!-- Modal Forget Password -->
<div class="modal fade" id="forpass" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            <h4 class="modal-title" id="myModalLabel"><?php echo NEW_CLIENT?>&nbsp;<?php echo NEW_FORGET_PASSWORD?></h4>
          </div>
          <div class="modal-body">
           		<div class="container-fluid">
                	<div class="row">
                    	<div class="col-md-12 derror" id="errorforget">
                        </div>
                    </div>
                    <div class="row">
                       <div class="col-md-12">
					  <input value="forget" id="account_selection" name="account_selection" type="hidden" >
                          <div class="form-group">
                            <label for="inputEmail3" class="col-sm-2 control-label"><?php echo EMAIL;?></label>
                            <div class="col-sm-10">
							  <input type="email" class="form-control" id="inputEmailforget" placeholder="<?php echo EMAIL;?>" name="inputEmailforget">
                            </div>
                          </div>
                          <div class="form-group">
                            <div class="col-sm-offset-2 col-sm-10">
                            <br />
							   <input type="submit" class="form-control searchbtn logbtn" value="<?php echo SEND;?>" id="submit_forget" name="submit_forget">
                            </div>
                          </div>
                       </div>
                    </div>
                </div>
          </div>
    </div>
  </div>
</div>


<!-- Modal Agent Login -->
<div class="modal fade" id="myagentLogin" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            <h4 class="modal-title" id="myModalLabel"><?php echo AGGENT_LOGIN;?></h4>
          </div>
          <div class="modal-body">
           		<div class="container-fluid">
                	<div class="row">
                    	<div class="col-md-12 derror" id="agenterror"> 
                        
                        </div>
                    </div>
                    <div class="row">
                       <div class="col-md-12">
					   <input value="login" id="account_selection" name="account_selection" type="hidden" >
                          <div class="form-group">
                            <label for="inputEmail3" class="col-sm-2 control-label"><?php echo EMAIL;?></label>
                            <div class="col-sm-10">
							  <input type="email" class="form-control" id="agentinputEmail3" placeholder="<?php echo EMAIL;?>" name="agentinputEmail3" >
                            </div>
                          </div>
						  <br>
						  <br>
                          <div class="form-group">
                            <label for="inputPassword3" class="col-sm-2 control-label"><?php echo PASSWORD;?></label>
                            <div class="col-sm-10">
							   <input type="password" class="form-control" id="agentinputPassword3" placeholder="<?php echo PASSWORD;?>" name="agentinputPassword3" > 
                            </div>
                          </div>
						  
                          <div class="form-group">
                            <div class="col-sm-offset-2 col-sm-10">
                            </div>
                          </div>
                          <div class="form-group">
                            <div class="col-sm-offset-2 col-sm-10">
                            <br />
							   <input type="submit" class="form-control searchbtn logbtn" value="<?php echo NEW_LOGIN;?>" id="submit_agentlogin" name="submit_agentlogin" >
                              <a href="javascript:void(0)" data-toggle="modal" data-target="#agentforpass" data-dismiss="modal" class="forpass"><?php echo NEW_FORGET_PASSWORD?></a>
                            </div>
                          </div>
                       </div>
                    </div>
                </div>
          </div>
    </div>
  </div>
</div>

<!-- Modal Agent Forget Password -->
<div class="modal fade" id="agentforpass" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            <h4 class="modal-title" id="myModalLabel"><?php echo NEW_AGENT;?>&nbsp;<?php echo NEW_FORGET_PASSWORD?></h4>
          </div>
          <div class="modal-body">
           		<div class="container-fluid">
                	<div class="row">
                    	<div class="col-md-12 derror" id="agenterrorforget"> 
					</div>
                    </div>
                    <div class="row">
                       <div class="col-md-12">  
					  <input value="forget" id="account_selection" name="account_selection" type="hidden" >
                          <div class="form-group">
                            <label for="inputEmail3" class="col-sm-2 control-label"><?php echo EMAIL;?></label>
                            <div class="col-sm-10">
							  <input type="email" class="form-control" id="inputagentEmailforget" placeholder="<?php echo EMAIL;?>" name="inputagentEmailforget">
                            </div>
                          </div>
                          <div class="form-group">
                            <div class="col-sm-offset-2 col-sm-10">
                            <br />
							   <input type="submit" class="form-control searchbtn logbtn" value="<?php echo SEND;?>" id="submit_agentforget" name="submit_agentforget">
                            </div>
                          </div>
                       </div>
                    </div>
                </div>
          </div>
    </div>
  </div>
</div>





<script type="text/javascript">
    $(document).ready(function() {
		$('.fhd').on('click',function(){
			if($(this).hasClass('arshow')){
				$(this).removeClass('arshow');
				$(this).addClass('arhide');
			}else{
				$(this).removeClass('arhide');
				$(this).addClass('arshow');
			}
			$('#flink').toggle();
		});
		$('.closenoti').on('click',function(){
			$('.noti').parent().css('height','15px');
			$('.noti').remove();
		});
		
		$('.chekrow').on('click',function(){
			var id = $(this).attr('id');
			$('.rw1').removeClass('rw1bg');
			$('input.radiocheckbox').attr('checked', false);
			$('input.radiocheckbox').prop('checked', false);
				
			if($(this).hasClass('openrow')){
				$(this).removeClass('openrow');
				$(this).children().first().removeClass('rw1bg');
				$('#'+id+'-box').slideUp();
			}else{
				$('.chekrow').removeClass('openrow');
				$(this).addClass('openrow');
				$(this).children().first().addClass('rw1bg');
				$(this).children('input.radiocheckbox').attr('checked', true);
				$(this).children('input.radiocheckbox').prop('checked', true);
				$('.formcontainer').slideUp();
				$('#'+id+'-box').slideDown();
			}
		});
		
	});
</script>

<script type="text/javascript">
$(document).ready(function() {
$("#register").click(function(){
if($("#email").val()=="" ){
alert("Please enter your email id");
 return false;
}
else if($("#pass").val()=="" ){
alert("Please enter password");
 return false;
}
else if($("#firstname").val()=="" ){
alert("Please enter your name");
 return false;
}
else if($("#lastname").val()=="" ){
alert("Please enter your name");
 return false;
}
else if($("#address1").val()=="" ){
alert("Please enter your address");
 return false;
}
else if($("#city").val()=="" ){
alert("Please enter your city");
 return false;
}
else if($("#state").val()=="" ){
alert("Please enter your state");
 return false;
}
else if($("#zip").val()=="" ){
alert("Please enter your zip");
 return false;
}

else if($("#phone").val()=="" ){
alert("Please enter your phone");
 return false;
}

else{
return true;
}
});

});
</script>

<script type="text/javascript">
$(document).ready(function() {
$("#login").click(function(){
if($("#customer_name").val()=="" ){
alert("Please enter your Your Name ");
 return false;
}
else if($("#customer_email").val()=="" ){
alert("Please enter Your email-id");
 return false;
}
else if($("#customer_phone").val()=="" ){
alert("Please enter Phone No");
 return false;
}
else{
return true;
}
});
});
</script>
	
	
	
<script type="text/javascript">
	$(document).ready(function() {
	
	$("#submit_login").click(function(){
	var querystr = 'actioncode=12&email='+$('#inputEmail3').val()+'&password='+$('#inputPassword3').val();
	$.post("ajax-processor.php", querystr, function(data){						 
				if(data.errorcode == 0){
					//$('#error').html('<p> Succesfully Login! Please wait redirecting...</p>');
					$(location).attr('href', 'user_managebooking.php?submenuheader=0');
				}else{
				$('#error').html('<?php echo NEW_EMAIL_NOT_MATCH;?>');
				//alert('Emailid or Password does not matched.');	
				}
			}, "json");
	});
	
	
	$("#submit_forget").click(function(){
	var querystr = 'actioncode=13&email='+$('#inputEmailforget').val();
	$.post("ajax-processor.php", querystr, function(data){						 
				if(data.errorcode == 0){
				$('#errorforget').html('<p> <?php echo NEW_MAIL_CHK;?>..</p>');
					//$(location).attr('href', 'cuenta.php?submenuheader=0');
				}else{
				$('#errorforget').html(' <?php echo NEW_NOT_EXISTS;?>.');
				//alert('Emailid or Password does not matched.');	
				}
			}, "json");
	});
	
	
	});
</script>

<script type="text/javascript">
	$(document).ready(function() {
	
	$("#submit_agentlogin").click(function(){
	var querystr = 'actioncode=14&email='+$('#agentinputEmail3').val()+'&password='+$('#agentinputPassword3').val();
	$.post("ajax-processor.php", querystr, function(data){						 
				if(data.errorcode == 0){
					//$('#error').html('<p> Succesfully Login! Please wait redirecting...</p>');
					$(location).attr('href', 'agent_managebooking.php?submenuheader=0');
				}else{
				$('#agenterror').html('<?php echo NEW_EMAIL_NOT_MATCH;?>.');
				//alert('Emailid or Password does not matched.');	
				}
			}, "json");
	});
	
	
	$("#submit_agentforget").click(function(){
	var querystr = 'actioncode=16&email='+$('#inputagentEmailforget').val();
	$.post("ajax-processor.php", querystr, function(data){						 
				if(data.errorcode == 0){
				$('#agenterrorforget').html('<p> <?php echo NEW_MAIL_CHK;?>...</p>');
					//$(location).attr('href', 'cuenta.php?submenuheader=0');
				}else{
				$('#agenterrorforget').html(' <?php echo NEW_NOT_EXISTS;?>.');
				//alert('Emailid or Password does not matched.');	
				}
			}, "json");
	});
	
	
	});
</script>



</body>
</html>
