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
	$bookingid=$_SESSION['bookingId'];
	include("includes/db.conn.php");
	include("includes/conf.class.php");
    include("includes/language.php");

	
/*
	$pos2 = strpos($_SERVER['HTTP_REFERER'], $_SERVER['SERVER_NAME']);
    if(!$pos2){
    header('Location: booking-failure.php?error_code=978');
   exit;			
     } 
*/
	if(isset($_SESSION['language'])){
$htmlCombo = $bsiCore->getbsilanguage($_SESSION['language']);
}else{
$htmlCombo = $bsiCore->getbsilanguage(); 
}
$hotelDetails  = $bsiCore->getHotelDetails($hotel_id);
$bookDetails  = $bsiCore->getConfirmDetails($bookingid);
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
<title><?=$bsiCore->config['conf_portal_name']?> , Booking comfirm</title>
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
                                                    <div class="col-md-4 col-sm-4 col-xs-4 chkst chkstps1-off">
             <p><?=STEP_FIRST?><span><?=GET_STARTED?></span></p>
                                                    </div>                            
                                                    <div class="col-md-4 col-sm-4 col-xs-4 chkst chkstps2-off">
<p><?=STEP_TWO?>
<span><?=ROOMS_GUEST_DETAILS?></span></p>              
                                                   </div>                            
                                                    <div class="col-md-4 col-sm-4 col-xs-4 chkst chkstps3-on">
<p><?=STEP_THREE?>
<span><?=COFIRMATION?></span></p>                         
                                                   </div>                                 					</div> 
                                               
                                                               
                                                <!--<div class="row">
                                                    <div class="col-md-12">-->
                                                    
            <!-- <div class="container-fluid">
                  <div class="row"> 
                      <div class="col-md-12"> -->
                      	<h2 class="settpd" style="font-weight:bold"><?=COFIRMATION_MSG?></h2>
                        <?php 
						$countrysql = mysql_query("select cou_name from `bsi_country`  where country_code='".$hotelDetails['country_code']."'  ");
                        $countryres = mysql_fetch_assoc($countrysql);
						$bookingtimerow =mysql_fetch_assoc(mysql_query("SELECT 	booking_time,reviewid,confirmation_time FROM `bsi_bookings` WHERE booking_id = '".$bookingid."'"));
						$booktime = $bookingtimerow['booking_time'];
						$confirmation_time = $bookingtimerow['confirmation_time'];
              
		  
						?>
    
                        
                        <p><strong><?php echo NEW_BOOKING_COMFIRMATION_MSG;?> :</strong> <?php echo  $bookingid;?></p> 
                        
                        <p><strong>Client Name :</strong> <?php echo  $_SESSION['Myname2012'];?></p>
                        <?php echo $bsiCore->getConfirmDetails($bookingid);?>
                        
                        <p><strong><?php echo CHECK_IN;?> :</strong><?php echo $_SESSION['sv_checkindate'];?></p>
<p><strong>Booking Time :</strong> <?php echo date("H:i:s",strtotime($confirmation_time));?></p>
                        <p><strong><?php echo ADULT;?> :</strong> <?php echo  $_SESSION['sv_adults'];?></p>
                        
                        <p><strong><?php echo NEW_HOTEL_INFO;?> :</strong><br>
                        <?php echo $hotelDetails['hotel_name'];?><br>
						<?php echo $hotelDetails['address_1'];?><br>
                        <?php echo $hotelDetails['city_name'];?> -  <?php echo $hotelDetails['post_code'];?> , <?php echo  $countryres['cou_name']; ?><br>
                        <?php echo PHONE;?> : <?php echo $hotelDetails['phone_number'];?> <br>
                        <?php echo EMAIL;?> :  <?php echo $hotelDetails['email_addr'];?>     
                         </p>
                         <p><strong>Review & feedback :</strong><a href="http://feelspark.com/review/<?php echo  $bookingtimerow['reviewid'];?>" target="_blank"> http://feelspark.com/review/<?php echo  $bookingtimerow['reviewid'];?></a></p>
                    <!--  </div>
                  </div>-->
                 
                  <!--<form action="checkpoin3.html">-->
                  
                 
                  <div class="row">
                      <!--<div class="col-md-4 col-xs-offset-3 col-sm-7 col-xs-8">-->
                      <div class="col-md-12">
  						<!--<a  href="javascript:;"  onClick="javascript:myPopup3('<?=$bookingid?>');" class="searchbtn"> <?=NEW_CONFIRM_PRINT?> </a>-->
                        <center>
                        <label><font color="#FF0000">*** please screen capture this page as confirmation***</font></label>
                        </center>
                      </div>   
                      
                  </div>   
                 <!-- </form>-->
            <!-- </div>-->
                                                  
     
                                                   <!--  </div>
                                                </div>-->
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
			// $child_price+=$roomtypeArray[$i]['child_price'];
			
			$child_caption ='';
			if($child_price>0){ 
				$child_caption=' ('.NEW_INCLUDEING_CHILD_PRICE.' '.$bsiCore->get_currency_symbol($_SESSION['sv_currency']). $bsiCore->getExchangemoney($child_price,$_SESSION['sv_currency']).')';
			}
			 
		?>
                                            	
                                                
                                                <div class="row">
                                                    <div class="col-md-6 col-sm-6 col-xs-6"><p class="pstl"><strong><?php echo ROOOM;?>:</strong></p></div>
                                                    <div class="col-md-6 col-sm-6 col-xs-6"><p class="pstl"> <?php echo $getRoom;?></p></div>
                                                </div>
                                                
												
												<?php	if(isset($_SESSION['extra_price'])){ ?>
												<div class="row">
                                                    <div class="col-md-6 col-sm-6 col-xs-6"><p class="pstl"><strong><?=NEW_EXTRA_BED_PRICE?>:</strong></p></div>
                                                    <div class="col-md-6 col-sm-6 col-xs-6"><p class="pstl"><?=$bsiCore->get_currency_symbol($_SESSION['sv_currency']).$bsiCore->getExchangemoney($_SESSION['extra_price'],$_SESSION['sv_currency'])?></p></div>
                                                </div>
												<?php }?>
												
                                                <div class="row">
                                                    <div class="col-md-6 col-sm-6 col-xs-6"><p class="pstl"><strong><?=TOTAL_ROOM_PRICE?></strong></p></div> 	
                                                    <div class="col-md-6 col-sm-6 col-xs-6"><p class="pstl ttl2">
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
<div class="col-md-6 col-sm-6 col-xs-6"><p class="pstl"><strong><?php echo SUB_TOTAL;?>:</strong></p></div> 	
<div class="col-md-6 col-sm-6 col-xs-6"><p class="pstl ttl2"><?=$bsiCore->get_currency_symbol($_SESSION['sv_currency']).$bsiCore->getExchangemoney($_SESSION['total_cost'],$_SESSION['sv_currency'])?></p></div>
</span></h2>
                                            <div class="clr"></div>
                                            <div class="container-fluid" style="padding:10px 15px">
											
											
                                               <!-- <div class="row">
                                                    <div class="col-md-6 col-sm-6 col-xs-6"><p class="pstl"><strong>Room Subtotal:</strong></p></div>
                                                    <div class="col-md-6 col-sm-6 col-xs-6"><p class="pstl"><?=$bsiCore->config['conf_currency_symbol'].$_SESSION['total_cost']?></p></div>
                                                </div>-->
                                                
                                                <!--<div class="row">
                                                    <div class="col-md-6 col-sm-6 col-xs-6"><p class="pstl"><strong><?php echo SUB_TOTAL;?>:</strong></p></div> 	
                                                    <div class="col-md-6 col-sm-6 col-xs-6"><p class="pstl ttl2">
                                                   <?=$bsiCore->get_currency_symbol($_SESSION['sv_currency']).$bsiCore->getExchangemoney($_SESSION['total_cost'],$_SESSION['sv_currency'])?><?=$child_caption;?></p></div>
                                                </div>-->
												
												<?php if(isset($_SESSION['cuppon_discount_amount'])){?>
												<div class="row">
                                                    <div class="col-md-6 col-sm-6 col-xs-6"><p class="pstl"><strong><?=NEW_CUPPON?>  <?=$_SESSION['discountcoupon']?> <?=NEW_APPLIED?></strong></p></div>
                                                    <div class="col-md-6 col-sm-6 col-xs-6"><p class="pstl" id="c_tax_amount">(-)<?=$bsiCore->get_currency_symbol($_SESSION['sv_currency']).
													$bsiCore->getExchangemoney($_SESSION['cuppon_discount_amount'],$_SESSION['sv_currency'])
													
													?></p></div>
                                                </div>
												
												<?php } ?>
												
												<?php
												$month_num = intval(substr($_SESSION['checkin_date'], 5, 2)) ;
												$sql = mysql_query("SELECT * FROM bsi_deposit_discount WHERE month_num = ".$month_num);
												$discountpercent = mysql_fetch_assoc($sql);
												if($discountpercent['discount_percent'] > 0){?>
					<div class="row">
                   <div class="col-md-6 col-sm-6 col-xs-6"><p class="pstl"><strong><?=NEW_MONTHLY_DISCOUNT_SCHEME?>(<?=$discountpercent['discount_percent']?>%):</strong></p></div>
                   <div class="col-md-6 col-sm-6 col-xs-6"><p class="pstl">(-)<?php echo $bsiCore->get_currency_symbol($_SESSION['sv_currency']).$bsiCore->getExchangemoney($_SESSION['discount_amount'],$_SESSION['sv_currency']);?></p></div>
                   </div>
												<?php } ?>
												
												<?php
												if($bsiCore->config['conf_tax_amount']>0){?>
												
                                                <div class="row">
                                                    <div class="col-md-6 col-sm-6 col-xs-6"><p class="pstl"><strong><?=TAX_FEES?>:</strong></p></div>
                                                    <div class="col-md-6 col-sm-6 col-xs-6"><p class="pstl"><?php echo $bsiCore->get_currency_symbol($_SESSION['sv_currency']).$bsiCore->getExchangemoney($_SESSION['tax'],$_SESSION['sv_currency']);?></p></div>
                                                </div>
												
												<?php } ?>
												
                                                <!--<div class="row">
                                                    <div class="col-md-6 col-sm-6 col-xs-6"><p class="pstl ttl"><strong><?=TOTAL?>:</strong></p>
                                                    </div> 	
                                                    <div class="col-md-6 col-sm-6 col-xs-6"><p class="pstl ttl">
                                                    <?php echo $bsiCore->get_currency_symbol($_SESSION['sv_currency']).$bsiCore->getExchangemoney($_SESSION['grandtotal'],$_SESSION['sv_currency']);?></p></div>
                                                </div>-->
												
												<?php
												$month_num = intval(substr($_SESSION['checkin_date'], 5, 2)) ;
												$sql = mysql_query("SELECT * FROM bsi_deposit_discount WHERE month_num = ".$month_num);
												$discountpercent = mysql_fetch_assoc($sql);
												if($discountpercent['deposit_percent'] > 0){
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


<?php 
$bsiCore->removesessionVariables();
include("footer.php");?>

<script type="text/javascript">

function myPopup3(booking_id){

		//alert(booking_id);

		var width = 730;

		var height = 650;

		var left = (screen.width - width)/2;

		var top = (screen.height - height)/2;

		var url='data/invoice/voucher_'+booking_id+'.pdf';
		//alert(url);

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

		if (window.focus) {

			newwin.focus()

		}

		return false;

	}


</script>


</body>
</html>
