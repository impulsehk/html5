<?php
include("access.php");
include("../includes/db.conn.php");
include("../includes/conf.class.php");
include("../includes/admin.class.php"); 

include("../models/model.php");
$Reservation = new Model('bsi_reservation', 'id');
$Rooms = new Rooms();

$row = $bsiAdminMain->getHotelDetails($_SESSION['hhid']);
$capacitysql = mysql_query("SELECT * FROM `bsi_capacity` WHERE hotel_id='".$_SESSION['hhid']."' ");
$capacityrow = mysql_fetch_assoc($capacitysql); 

$statussql = mysql_query("SELECT * FROM `bsi_hotels` WHERE hotel_id='".$_SESSION['hhid']."' ");
$statusrow = mysql_fetch_assoc($statussql); 
if($statusrow['status']==1){$onoff='<font color="#009900">ON</font>';}else{$onoff='OFF';}

$hostel_id = $_SESSION['hhid'];
?>

<!doctype html> 
<html>
<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta http-equiv="refresh" content="30;url=hotel-home.php">
<!-- Latest compiled and minified CSS -->
<link rel="stylesheet" href="../css/bootstrap.css">
<link rel="stylesheet" href="../fonts/stylesheet.css">
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css">
<link rel="stylesheet" href="../src/jquery-anyslider.css">
<!----><!--<script type="text/javascript" src="js/custom-form-elements.min.js"></script>-->
<!-- Optional theme 
<link rel="stylesheet" href="css/bootstrap-theme.css">-->
<!-- Custom Page Theme -->
<!--<link rel="stylesheet" href="https://code.jquery.com/ui/1.11.2/themes/smoothness/jquery-ui.css">
-->
<link rel="stylesheet" href="../css/datepicker.css">
<link rel="stylesheet" href="../css/page-theme.css">
<link rel="stylesheet" href="../js/cssmenu/styles.css">
<link rel="stylesheet" href="../css/jquery.switch.css">
<script src="../js/jquery.min.js"></script>
<script src="../js/cssmenu/script.js"></script>
<script type="text/javascript" src="../js/jquery.easing.1.3.js"></script>
<script src="../src/jquery.anyslider.js"></script>
<script src="../js/bootstrap.js"></script>
<script src="../js/moment-with-locales.js"></script>
<script type="text/javascript" src="../js/bootstrap-datepicker.js"></script>
<title><?=$bsiCore->config['conf_portal_name']?> : Hotel Panel</title>
</head>

<body>

<header>

<?php //include("header.php");?>	

</header>

<div class="container-fluid">
    <div class="row container-background">
        <section class="container">
        	<div class="row">
            <div class="container-fluid">
                <div class="row">
                	<div class="container-fluid">
                    	
                        <div class="row">
                        	<div class="col-md-12">
                            	<div class="container-fluid">
                    				<div class="row">
                        				<div class="col-md-12 sernbox">
                            				<h2 class="sett3"><span>Welcome To <?php echo $row['hotel_name'];?>  

<label class="switch-light switch-ios pull-right">


<?php if($statusrow['status']==1){?>
<input name="ssron_off" id="ssron_off" checked type="checkbox" class="ssron_off">
<span id="msgon">
<span id="msgon1"><strong>OFF</strong></span> 
<span id="msgoff1"><strong>ON</strong></span>
</span>
<?php } else{?>
<input name="ssron_off" id="ssron_off" type="checkbox" class="ssron_off">
<span id="msgoff">
<span id="msgoff2"><strong>OFF</strong></span>
<span id="msgon2"><strong>ON</strong></span> 
</span>
<?php }?> <a></a> </label></h2>
                                		</div>
                                    </div>
                                 </div>
                            </div>
                        </div>
                    
                		<div class="row" style="margin-top:20px;"> 
                        	
                            
                            
                            
                            
                            <div class="col-md-5 col-md-push-2"> 
                                <div class="container-fluid">
                					<div class="row">
                        				<div class="col-md-12 sernbox">
                                             <div class="container-fluid">
                                                <div class="row">
                                                    <div class="col-md-12">
<!--<br />
<h2 class="sett4">Short Stay Room</h2> 
<br />-->
<br />

<?php  

$ssrsql = mysql_query("SELECT * FROM `bsi_roomtype` WHERE hotel_id='".$_SESSION['hhid']."' and roomtype_name='Short Stay Room' ");
$roomtypeid = mysql_fetch_assoc($ssrsql);

$Roomsql = mysql_query("SELECT * FROM `bsi_room` WHERE hotel_id='".$_SESSION['hhid']."' and roomtype_id='".$roomtypeid['roomtype_id']."' ");
$countroomno=mysql_num_rows($Roomsql);
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
$ssravailable=$bsiCore->getAvailableRooms($roomtypeid['roomtype_id'],'Short Stay Room',$capacityrow['capacity_id'],$_SESSION['hhid'],$capacityrow['capacity_id'],$capacityrow['title'],$capacityrow['capacity'],$checkin,$checkout);

//*********************** For price ***********************************//

$SSRPricesql = mysql_query("SELECT * FROM `bsi_priceplan` WHERE hotel_id='".$_SESSION['hhid']."' and room_type_id='".$roomtypeid['roomtype_id']."' and capacity_id!=1001 and `default`=1");
$SSRpricerow = mysql_fetch_assoc($SSRPricesql);

//*********************** For Last Booking ****************************//
$ssrlastbookhtml='';
$lastsql = mysql_query("SELECT * FROM `bsi_bookings` bb , `bsi_reservation` br WHERE bb.hotel_id='".$_SESSION['hhid']."' and bb.is_block=0 and br.booking_id=bb.booking_id and br.roomtype_id='".$roomtypeid['roomtype_id']."' and (NOW() - bb.booking_time) < 3000 and bb.payment_success='1' order by bb.booking_time desc ");
if(mysql_num_rows($lastsql))
{
	
$lastbook = mysql_fetch_assoc($lastsql); // last booking
$lastbookingtime=explode(" ",$lastbook['booking_time']);
$ssrlastbookhtml.='<div class="row">
	<div class="col-md-12">
    <h4 style="background:rgba(243,8,96,1.00)"><font color="#FDFDFD">New Booking From Web , Time :'.$lastbookingtime[1].'</font></h4>
</div>
</div>
<br>';
}

?>
<div class="row">
   
    <div class="col-md-12">
        <div class="form-group ">
         <input type="hidden" name="hstatus" id="hstaus" value="<?php echo $statusrow['status'];?>">
         <h4 class="sett4"><strong><?php echo $roomtypeid['type_name'];?></strong></h4>   
        </div>
    </div>
    
 
</div>


<input type="hidden" name="capacity_id" id="capacity_id" value="<?php echo $capacityrow['capacity_id'];?>">

<div class="container-fluid">

<input type="hidden" name="ssrroomtypeid" id="ssrroomtypeid" value="<?php echo $roomtypeid['roomtype_id'];?>" >


<div class="row">
    <div class="col-md-5 col-sm-5 col-xs-5">
        <div class="form-group ">
            <label class="chkdate" for="exampleInputEmail1">No Of Room  </label>
        </div>
    </div>
    
    <div class="col-md-3 col-sm-3 col-xs-3">
        <div class="form-group ">
            <input type="text" name="ssrroomno" id="ssrroomno" class="form-control roundcorner" >
        </div>
    </div>
    
    <div class="col-md-4 col-sm-4 col-xs-4">
        <div class="form-group ">
            <input type="submit" class="form-control searchbtn" value="Submit"  name="ssrnoroominc" id="ssrnoroominc">
   
        </div>
    </div>
    
</div>


<div class="row">
    <div class="col-md-6 col-sm-7 col-xs-7">
        <div class="form-group ">
            <label class="chkdate" for="exampleInputEmail1">No Of Room Available</label>
        </div>
    </div>

    <div class="col-md-6 col-sm-5 col-xs-5">
        <div class="form-group ">
        <?php #THIS IS FUCKING INSANE CRAB VARIABLE ?>
        <input type="hidden" name="ssravailroomno" id="ssravailroomno" value="<?php echo $ssravailable['availableroomno'];?>">
        <?php echo sizeof( $Rooms->get_reserve( $hostel_id , $roomtypeid['roomtype_id'] ) ) ?>
        <?php #echo $ssravailable['availableroomno'];?>
         <input type="hidden" name="ssrfirstroomid" id="ssrfirstroomid" value="<?php echo $ssravailable['availablefirstroomid'];?>">
         <input type="hidden" name="ssravailableroomid" id="ssravailableroomid" value="<?php echo $ssravailable['totalRoomAvailableId'];?>">
        </div>
    </div>
</div>


<?php echo $ssrlastbookhtml;?>

<div class="row">

	<div class="col-md-5 col-sm-5 col-xs-4">
        <div class="form-group ">
            <label class="chkdate" for="exampleInputEmail1">Set Price (<?php echo $bsiCore->currency_symbol();?>)</label>
        </div>
    </div>
   
    <div class="col-md-3 col-sm-3 col-xs-4">
        <div class="form-group ">
            <input type="text" name="ssrprice" id="ssrprice" class="form-control roundcorner" value="<?php echo $SSRpricerow['sun'];?>" >
            <input type="hidden" name="ssrprice_id" id="ssrprice_id" value="<?php echo $SSRpricerow['priceplan_id'];?>">
        </div>
    </div>
    
    <div class="col-md-4 col-sm-4 col-xs-4">
        <div class="form-group ">
            <input type="submit" class="form-control searchbtn" value="Submit"  name="ssrpricesubmit" id="ssrpricesubmit">
   
        </div>
    </div>
    
</div>

<div class="row">
	<div class="col-md-6 col-sm-6 col-xs-5">
        <input type="submit" class="form-control searchbtn" value="Walk In (-1)"  name="ssrroomblock" id="ssrroomblock">
    </div>
		
   <!-- <div class="col-md-2 col-sm-2 col-xs-2"><br></div>-->
    
    <div class="col-md-6 col-sm-6 col-xs-7">
		<input type="submit" class="form-control searchbtn" value="New Room (+1)"  name="ssrroomincrease" id="ssrroomincrease">
	</div>
</div>

<br />
                  
<!--</form>-->
              </div>
                                                    </div> 
                                                </div>
                                                <div class="clr"></div>
                                             </div>
                                        </div>
                                    </div>
                                                                        
                                </div>
                            </div>
                            

<!--====                            -->                            
 <?php 
$onrsql = mysql_query("SELECT * FROM `bsi_roomtype` WHERE hotel_id='".$_SESSION['hhid']."' and roomtype_name='Overnight Room'");

$onrroomtypeid = mysql_fetch_assoc($onrsql);
$Roomsql = mysql_query("SELECT * FROM `bsi_room` WHERE hotel_id='".$_SESSION['hhid']."' and roomtype_id='".$onrroomtypeid['roomtype_id']."' ");
$onrcountroomno=mysql_num_rows($Roomsql);

// var_dump($onrroomtypeid['roomtype_id']);
//$checkin=date('Y-m-d');
//$checkout=date('Y-m-d', strtotime(' +1 day'));

$onravailable=$bsiCore->getAvailableRooms($onrroomtypeid['roomtype_id'],'Overnight Room',$capacityrow['capacity_id'],$_SESSION['hhid'],$capacityrow['capacity_id'],$capacityrow['title'],$capacityrow['capacity'],$checkin,$checkout);

//*********************** For price ***********************************//

$ONRPricesql = mysql_query("SELECT * FROM `bsi_priceplan` WHERE hotel_id='".$_SESSION['hhid']."' and room_type_id='".$onrroomtypeid['roomtype_id']."' and capacity_id!=1001 and `default`=1");
$ONRpricerow = mysql_fetch_assoc($ONRPricesql);

//*********************** For Last Booking ****************************//
$onrlastbookhtml='';
$lastonrsql = mysql_query("SELECT * FROM `bsi_bookings` bb , `bsi_reservation` br WHERE bb.hotel_id='".$_SESSION['hhid']."' and bb.is_block=0 and br.booking_id=bb.booking_id and br.roomtype_id='".$onrroomtypeid['roomtype_id']."' and (NOW() - bb.booking_time) < 3000  and bb.payment_success='1' order by bb.booking_time desc ");
if(mysql_num_rows($lastonrsql))
{
$lastonrbook = mysql_fetch_assoc($lastonrsql);
$lastonrbookingtime=explode(" ",$lastonrbook['booking_time']);
$onrlastbookhtml.='<div class="row">
	<div class="col-md-12">
    <h4 style="background:rgba(243,8,96,1.00)"><font color="#FDFDFD">New Booking From Web , Time :'.$lastonrbookingtime[1].'</font></h4>
</div>
</div>
<br>';
}/*else{
$onrlastbookhtml.='<div class="row">
	<div class="col-md-12">
	<h4 style="background:rgba(243,8,96,1.00)"></h4>
</div>
</div>
<br>
<br>';
	}*/


?>                 
<div class="col-md-5 col-md-push-2"> 
<div class="container-fluid">
                					<div class="row">
                        				<div class="col-md-12 sernbox">
                                             <div class="container-fluid">
                                                <div class="row">
                                                    <div class="col-md-12">
<!--<br />
<h2 class="sett4"><?php echo $onrroomtypeid['type_name'];?></h2> 
<br />-->
<br />
<div class="row">
    
    <input type="hidden" name="noofonr" id="noofonr" value="<?php echo $onrcountroomno;?>">
    <div class="col-md-12">
        <div class="form-group ">
         <h4 class="sett4"><strong><?php echo $onrroomtypeid['type_name'];?></strong></h4>   
        </div>
    </div>
   
</div>

<div class="container-fluid">
                  
<input type="hidden" name="onrroomtypeid" id="onrroomtypeid" value="<?php echo $onrroomtypeid['roomtype_id'];?>" >                

<div class="row">
    <div class="col-md-5 col-sm-5 col-xs-5">
        <div class="form-group ">
            <label class="chkdate" for="exampleInputEmail1">No Of Room </label>
        </div>
    </div>
    
    <div class="col-md-3 col-sm-3 col-xs-3">
        <div class="form-group ">
            <input type="text" name="onrroomno" id="onrroomno" class="form-control roundcorner" >
        </div>
    </div>
    
    <div class="col-md-4 col-sm-4 col-xs-4">
        <div class="form-group ">
            <input type="submit" class="form-control searchbtn" value="Submit"  name="onrnoroominc" id="onrnoroominc">
   
        </div>
    </div>
    
</div>


<div class="row">
    <div class="col-md-6 col-sm-7 col-xs-7">
        <div class="form-group ">
            <label class="chkdate" for="exampleInputEmail1">No Of Room Available</label>
        </div>
    </div>
    
    <div class="col-md-6 col-sm-5 col-xs-5">
        <div class="form-group ">
         <input type="hidden" name="onravailroomno" id="onravailroomno" value="<?php echo $onravailable['availableroomno'];?>">
      <?php echo sizeof( $Rooms->get_reserve( $hostel_id , $onrroomtypeid['roomtype_id'] ) ) ?>
      <?php #echo $onravailable['availableroomno'];?>
      <input type="hidden" name="onravailableroomno" id="onravailableroomno" value="<?php echo $onravailable['availableroomno'];?>">
      <input type="hidden" name="onrfirstroomid" id="onrfirstroomid" value="<?php echo $onravailable['availablefirstroomid'];?>">
      <input type="hidden" name="onravailableroomid" id="onravailableroomid" value="<?php echo $onravailable['totalRoomAvailableId'];?>">
        </div>
    </div>
</div> 
 

 <?php echo $onrlastbookhtml;?>   


<div class="row">
    
    <div class="col-md-5 col-sm-5 col-xs-4">
        <div class="form-group ">
            <label class="chkdate" for="exampleInputEmail1">Set Price (<?php echo $bsiCore->currency_symbol();?>)</label>
        </div>
    </div>
    
    <div class="col-md-3 col-sm-3 col-xs-4">
        <div class="form-group ">
            <input type="text" name="onrprice" id="onrprice" class="form-control roundcorner" value="<?php echo $ONRpricerow['sun'];?>">
            <input type="hidden" name="onrprice_id" id="onrprice_id" value="<?php echo $ONRpricerow['priceplan_id'];?>">
        </div>
    </div>
    
    <div class="col-md-4 col-sm-4 col-xs-4">
        <div class="form-group ">
            <input type="submit" class="form-control searchbtn" value="Submit"  name="onrpricesubmit" id="onrpricesubmit">
   
        </div>
    </div>
    
</div>


<div class="row">
	<div class="col-md-6 col-sm-6 col-xs-5">
		<input type="submit" class="form-control searchbtn" value="Walk In (-1)"  name="onrroomblock" id="onrroomblock">
	</div>  

	<!--<div class="col-md-2"><br></div>-->
    
    <div class="col-md-6 col-sm-6 col-xs-7">
		<input type="submit" class="form-control searchbtn" value="New Room (+1)"  name="onrroomincrease" id="onrroomincrease">
    </div>
</div>

<br>

</div>
                                                    </div> 
                                                </div>
                                                <div class="clr"></div>
                                             </div>
                                        </div>
                                    </div>
                                                                        
                                </div>
                            </div>
                           <br/>
                            
                            <div class="col-md-2 col-md-pull-10">
                            	<div class="container-fluid">
                					<div class="row">
                        				<div class="col-md-12 padmarzero">
                                        	<ul  class="list-group">
                                             <li class="list-group-item active"><a href="hotel-home.php">Dashboard » </a></li>
                                             <li class="list-group-item"><a href="booking_list.php">Booking List » </a></li>
											 <li class="list-group-item"><a href="booking_history.php">Booking History » </a></li>
                                             <li class="list-group-item"><a href="hotel_logout.php">Logout </a></li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>
 
 <!--====     -->                      
                            
                        </div>
                    </div>
                </div>
                
            </div>
            </div>
        </section>
	</div>
</div>
<br />
<br />
<br />

<?php // include("footer.php");?>

<script type="text/javascript"> 

$(document).ready(function(){
$('#ssrroomblock').click(function(){
	
	if($('#hstaus').val() != 0){
	
var querystr = 'actioncode=20&firstroomid='+$('#ssrfirstroomid').val()+'&roomtypeid='+$('#ssrroomtypeid').val()+'&capacityid='+$('#capacity_id').val();
$.post("../ajax-processor.php", querystr, function(data){						 
if(data.errorcode == 0){
alert(data.strhtml);	
location.reload();	
}else{
alert(data.strhtml);
location.reload();
}
}, "json");
}else{
alert("Not accept new booking");	
	}
});
});
	//]]>
	
$(document).ready(function(){
$('#onrroomblock').click(function(){
	
	if($('#hstaus').val() != 0){
	
var querystr = 'actioncode=20&firstroomid='+$('#onrfirstroomid').val()+'&roomtypeid='+$('#onrroomtypeid').val()+'&capacityid='+$('#capacity_id').val();
$.post("../ajax-processor.php", querystr, function(data){						 
if(data.errorcode == 0){
alert(data.strhtml);	
location.reload();	
}else{
//$('#change_pass').html((data.strmsg))
alert(data.strhtml);
}
}, "json");
}else{
alert("Not accept new booking");	
	}
});
});
	//]]>
	
$(document).ready(function(){
$('#ssrroomincrease').click(function(){
var querystr = 'actioncode=21&capacity_id='+$('#capacity_id').val()+'&roomtypeid='+$('#ssrroomtypeid').val()+'&availableroomid='+$('#ssravailableroomid').val();
//alert(querystr);
$.post("../ajax-processor.php", querystr, function(data){	 					 
if(data.errorcode == 0){
alert(data.strhtml);	
location.reload();	
}else{
//$('#change_pass').html((data.strmsg))
alert(data.strhtml);
}
}, "json");
});
});
	//]]>
	
$(document).ready(function(){  onrroomtypeid
$('#onrroomincrease').click(function(){
var querystr = 'actioncode=21&capacity_id='+$('#capacity_id').val()+'&roomtypeid='+$('#onrroomtypeid').val()+'&availableroomid='+$('#onravailableroomid').val();
//alert(querystr);
$.post("../ajax-processor.php", querystr, function(data){						 
if(data.errorcode == 0){
alert(data.strhtml);	
location.reload();	
}else{
//$('#change_pass').html((data.strmsg))
alert(data.strhtml);
}
}, "json");
});
});
	//]]> noofssr
	
	
$(document).ready(function(){
$('#ssrnoroominc').click(function(){

//var totalroom=$('#noofssr').val();	
//var totalroom2=$('#ssrroomno').val();
//if($('#ssrroomno').val()>$('#ssravailroomno').val()){
if($('#ssrroomno').val()>30 )
{
alert("Please enter NO Of Room whose value is less than 30");	
}else{
if($('#ssrroomno').val() != "" && $('#ssrroomno').val() != 0 ){
var querystr = 'actioncode=24&capacity_id='+$('#capacity_id').val()+'&roomtypeid='+$('#ssrroomtypeid').val()+'&noofroom='+$('#ssrroomno').val()+'&availableroomno='+$('#ssravailroomno').val()+'&availableroomid='+$('#ssravailableroomid').val();
//alert(querystr);	
$.post("../ajax-processor.php", querystr, function(data){						 
if(data.errorcode == 0){
alert(data.strhtml);
location.reload();	
}else{
alert(data.strhtml);
}
}, "json");
}else{
alert("Please , Enter NO Of Room ! ");	
	}
}
});
});

/*$(document).ready(function(){   
$('#onrnoroominc').click(function(){

if($('#onrroomno').val() != "" && $('#onrroomno').val() != 0){
	
var querystr = 'actioncode=21&capacity_id='+$('#capacity_id').val()+'&roomtypeid='+$('#onrroomtypeid').val()+'&noofroom='+$('#onravailroomno').val();
$.post("../ajax-processor.php", querystr, function(data){						 
if(data.errorcode == 0){
//alert(data.strhtml);	onravailroomno
location.reload();	
}else{
//$('#change_pass').html((data.strmsg))
alert(data.strhtml);
}
}, "json");
}else{ 
alert("Please enter NO Of Room");
}

});
});
*/
$(document).ready(function(){
$('#onrnoroominc').click(function(){
if($('#onrroomno').val()>30){
alert("Please enter NO Of Room whose value is less than 30");	
}else{
if($('#onrroomno').val() != "" && $('#onrroomno').val() != 0){
	
var querystr = 'actioncode=24&capacity_id='+$('#capacity_id').val()+'&roomtypeid='+$('#onrroomtypeid').val()+'&noofroom='+$('#onrroomno').val()+'&availableroomno='+$('#onravailroomno').val()+'&availableroomid='+$('#onravailableroomid').val();
$.post("../ajax-processor.php", querystr, function(data){						 
if(data.errorcode == 0){
alert(data.strhtml);
location.reload();	
}else{
alert(data.strhtml);
}
}, "json");
}else{ 
alert("Please enter NO Of Room");
}
}
});
});

//************************************ hstaus

$(document).ready(function(){
$('.ssron_off').click(function(){	
var querystr = 'actioncode=22&hotelstaus='+$('#hstaus').val();
//alert(querystr);
$.post("../ajax-processor.php", querystr, function(data){						 
if(data.errorcode == 0){
if(data.strhtml=='ON')
{
	$('#msgoff').show();	
	//alert('on');
	}else{
	$('#msgon').show();		
	//alert("off");
	}
//$('#msgerror').html(data.strhtml);		
//alert(data.strhtml);	
//location.reload();	
}else{
//$('#change_pass').html((data.strmsg))
alert(data.strhtml);
}
}, "json");

});
});

//********************************* Set Price
$(document).ready(function(){
$('#ssrpricesubmit').click(function(){
var querystr = 'actioncode=23&price='+$('#ssrprice').val()+'&price_id='+$('#ssrprice_id').val();
//alert(querystr);
$.post("../ajax-processor.php", querystr, function(data){						 
if(data.errorcode == 0){
alert("Price Reseted Successfully !");	
location.reload(); 	
}else{
alert(data.strhtml);
}
}, "json");
});
});

$(document).ready(function(){
$('#onrpricesubmit').click(function(){
var querystr = 'actioncode=23&price='+$('#onrprice').val()+'&price_id='+$('#onrprice_id').val();
//alert(querystr);
$.post("../ajax-processor.php", querystr, function(data){						 
if(data.errorcode == 0){
alert("Price Reseted Successfully !");	
location.reload();	
}else{
alert(data.strhtml);
}
}, "json");
});
});
	
</script>

</body>
</html>
