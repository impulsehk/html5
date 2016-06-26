<?php
include("access.php");
//session_start();
include("../includes/db.conn.php");
include("../includes/conf.class.php");
include("../includes/admin.class.php");

$row = $bsiAdminMain->getHotelDetails($_SESSION['hhid']);
$capacitysql = mysql_query("SELECT * FROM `bsi_capacity` WHERE hotel_id='".$_SESSION['hhid']."' ");
$capacityrow = mysql_fetch_assoc($capacitysql); 

$statussql = mysql_query("SELECT * FROM `bsi_hotels` WHERE hotel_id='".$_SESSION['hhid']."' ");
$statusrow = mysql_fetch_assoc($statussql); 


$html='';
$sql = mysql_query("SELECT * FROM `bsi_roomtype` WHERE hotel_id='".$_SESSION['hhid']."' ");
while($roomtypeRow = mysql_fetch_assoc($sql)){

$html.='<div class="col-md-6"> 
<div class="container-fluid">
<div class="row">
<div class="col-md-12 sernbox">
<div class="container-fluid">
<div class="row">
<div class="col-md-12">
<br />';
if($statusrow['status']==1){$onoff="OFF";}else{$onoff="ON";}

$html.='<div class="row">
<div class="col-md-3">
<div class="form-group ">
<input type="hidden" name="hstatus" id="hstaus" value="'.$statusrow['status'].'">
<input type="submit" class="searchbtn11" value="'.$onoff.'"  name="ssrnoroominc" id="on_off">
</div>
</div>
<div class="col-md-9">
<div class="form-group ">
<h4 class="sett4">'.$roomtypeRow['type_name'].'</h4>   
</div>
</div>   
</div>
<br />

<input type="hidden" name="capacity_id" id="capacity_id" value="'.$capacityrow['capacity_id'].'">';
$ssrsql = mysql_query("SELECT roomtype_id FROM `bsi_roomtype` WHERE hotel_id='".$_SESSION['hhid']."' and type_name='".$roomtypeRow['type_name']."' ");
$roomtypeid = mysql_fetch_assoc($ssrsql);
$Roomsql = mysql_query("SELECT * FROM `bsi_room` WHERE hotel_id='".$_SESSION['hhid']."' and roomtype_id='".$roomtypeid['roomtype_id']."' ");
$countroomno=mysql_num_rows($Roomsql);
$checkin=date('Y-m-d');
$checkout=date('Y-m-d', strtotime(' +1 day'));
$ssravailable=$bsiCore->getAvailableRooms($roomtypeid['roomtype_id'],'Short Stay Room',$capacityrow['capacity_id'],$_SESSION['hhid'],$capacityrow['capacity_id'],$capacityrow['title'],$capacityrow['capacity'],$checkin,$checkout);


$html.='<div class="container-fluid">
<input type="hidden" name="roomtypeid" id="ssrroomtypeid" value="'.$roomtypeid['roomtype_id'].'" >
<div class="row">
<div class="col-md-5">
<div class="form-group ">
<label class="chkdate" for="exampleInputEmail1">No Of Room </label>
</div>
</div>

<div class="col-md-2">
<div class="form-group ">
<input type="text" name="'.$roomtypeid['roomtype_id'].'.ssrroomno" id="'.$roomtypeid['roomtype_id'].'.ssrroomno" class="form-control roundcorner" >
</div>
</div>

<div class="col-md-5">
<div class="form-group ">
<input type="submit" class="form-control searchbtn" value="Submit"  name="'.$roomtypeid['roomtype_id'].'.ssrnoroominc" id="'.$roomtypeid['roomtype_id'].'.ssrnoroominc">
</div>
</div>
    
</div>

<br>

<div class="row">
    <div class="col-md-6">
        <div class="form-group ">
            <label class="chkdate" for="exampleInputEmail1">No Of Room Available</label>
        </div>
    </div>

    <div class="col-md-6">
        <div class="form-group ">
        '.$ssravailable['availableroomno'].'
		<input type="text" name="'.$ssravailable['availablefirstroomid'].'" id="ssrfirstroomid" value="'.$ssravailable['availablefirstroomid'].'">
         <input type="hidden" name="ssrfirstroomid" id="ssrfirstroomid" value="'.$ssravailable['availablefirstroomid'].'">
        </div>
    </div>
</div>

<br>

$ssrlastbookhtml

<div class="row">
	<div class="col-md-5">
        <input type="submit" class="form-control searchbtn13" value="Walk In (-1)"  name="'.$ssravailable['availablefirstroomid'].'" id="'.$ssravailable['availablefirstroomid'].'">
</div>
		
<div class="col-md-2"><br></div>
    
<div class="col-md-5">
<input type="submit" class="form-control searchbtn12" value="New Room (+1)"  name="ssrroomincrease" id="ssrroomincrease">
</div>
</div>
<br />
</div></div>
</div> 
</div>
<div class="clr"></div>
</div>
</div>
</div>
</div>
</div>';

	}
//echo $html;//die;
?>

<!doctype html> 
<html>
<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">
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
                            				<h2 class="sett3"><span>Welcome To <?=$row['hotel_name']?></h2>
                                		</div>
                                    </div>
                                 </div>
                            </div>
                        </div>
                    
                		<div class="row" style="margin-top:20px;"> 
                        	
                            
                            <!--<div class="col-md-2">
                            	<div class="container-fluid">
                					<div class="row">
                        				<div class="col-md-12 padmarzero">
                                        	<ul  class="list-group">
                                                 <li class="list-group-item active"><a href="hotel-home.php">Dashboard » </a></li>
                                             <li class="list-group-item"><a href="booking_list.php">Booking List » </a></li>
												
												<li class="list-group-item"><a href="hotel_logout.php">Logout </a></li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>-->
                            
                            
  <?php echo $html;?>                        
                            

                    
                            
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
$('#searchbtn').click(function(){
	
	if($('#hstaus').val() != 0){
	
var querystr = 'actioncode=20&firstroomid='+$('#ssrfirstroomid').val()+'&roomtypeid='+$('#ssrroomtypeid').val();
//alert(querystr);
$.post("../ajax-processor.php", querystr, function(data){						 
if(data.errorcode == 0){
//alert(data.strhtml);	
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
$('#onrroomblock').click(function(){
var querystr = 'actioncode=20&firstroomid='+$('#onrfirstroomid').val()+'&roomtypeid='+$('#onrroomtypeid').val();
$.post("../ajax-processor.php", querystr, function(data){						 
if(data.errorcode == 0){
//alert(data.strhtml);	
location.reload();	
}else{
//$('#change_pass').html((data.strmsg))
alert(data.strhtml);
}
}, "json");
});
});
	//]]>
	
$(document).ready(function(){
$('#ssrroomincrease').click(function(){
var querystr = 'actioncode=21&capacity_id='+$('#capacity_id').val()+'&roomtypeid='+$('#ssrroomtypeid').val()+'&noofroom=1';
$.post("../ajax-processor.php", querystr, function(data){						 
if(data.errorcode == 0){
//alert(data.strhtml);	
location.reload();	
}else{
//$('#change_pass').html((data.strmsg))
alert(data.strhtml);
}
}, "json");
});
});
	//]]>
	
$(document).ready(function(){
$('#onrroomincrease').click(function(){
var querystr = 'actioncode=21&capacity_id='+$('#capacity_id').val()+'&roomtypeid='+$('#onrroomtypeid').val()+'&noofroom=1';
$.post("../ajax-processor.php", querystr, function(data){						 
if(data.errorcode == 0){
//alert(data.strhtml);	
location.reload();	
}else{
//$('#change_pass').html((data.strmsg))
alert(data.strhtml);
}
}, "json");
});
});
	//]]>
	
	
$(document).ready(function(){
$('#ssrnoroominc').click(function(){
	
if($('#ssrroomno').val() != "" && $('#ssrroomno').val() != 0){
	
var querystr = 'actioncode=21&capacity_id='+$('#capacity_id').val()+'&roomtypeid='+$('#ssrroomtypeid').val()+'&noofroom='+$('#ssrroomno').val();
$.post("../ajax-processor.php", querystr, function(data){						 
if(data.errorcode == 0){
//alert(data.strhtml);	
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

$(document).ready(function(){
$('#onrnoroominc').click(function(){

if($('#onrroomno').val() != "" && $('#onrroomno').val() != 0){
	
var querystr = 'actioncode=21&capacity_id='+$('#capacity_id').val()+'&roomtypeid='+$('#onrroomtypeid').val()+'&noofroom='+$('#onrroomno').val();
$.post("../ajax-processor.php", querystr, function(data){						 
if(data.errorcode == 0){
//alert(data.strhtml);	
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

$(document).ready(function(){
$('#onrnoroominc').click(function(){

if($('#onrroomno').val() != "" && $('#onrroomno').val() != 0){
	
var querystr = 'actioncode=21&capacity_id='+$('#capacity_id').val()+'&roomtypeid='+$('#onrroomtypeid').val()+'&noofroom='+$('#onrroomno').val();
$.post("../ajax-processor.php", querystr, function(data){						 
if(data.errorcode == 0){
//alert(data.strhtml);	
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

//************************************ hstaus

$(document).ready(function(){
$('.searchbtn11').click(function(){	
var querystr = 'actioncode=22&hotelstaus='+$('#hstaus').val();
//alert(querystr);
$.post("../ajax-processor.php", querystr, function(data){						 
if(data.errorcode == 0){
//alert(data.strhtml);	
location.reload();	
}else{
//$('#change_pass').html((data.strmsg))
alert(data.strhtml);
}
}, "json");

});
});
	
</script>

</body>
</html>
