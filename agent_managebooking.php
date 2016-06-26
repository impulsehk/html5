<?php
include("access.php");
//print_r($_SESSION);
include("includes/db.conn.php");
include("includes/conf.class.php");
include("includes/language.php");
if(isset($_SESSION['language'])){
$htmlCombo=$bsiCore->getbsilanguage($_SESSION['language']);
}else{
$htmlCombo=$bsiCore->getbsilanguage(); 
}

include("includes/mail.class.php");
if((isset($_GET['cancel'])) && ($_GET['cancel'] == 1)){
	$booking_id	=  $bsiCore->ClearInput($_GET['booking_id']);
	$bsiCore->cancelBooking($booking_id);
	header("location:agent_managebooking.php");
	exit;
}

//$body_content=mysql_fetch_assoc(mysql_query("select * from bsi_site_contents where id=20"));
//$features_hotel=$bsiCore->getFeaturesHotels();
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
<!--<link rel="stylesheet" href="https://code.jquery.com/ui/1.11.2/themes/smoothness/jquery-ui.css">
-->
<link rel="stylesheet" href="css/datepicker.css">
<link rel="stylesheet" href="css/page-theme.css">
<link rel="stylesheet" href="js/cssmenu/styles.css">
<script src="js/jquery.min.js"></script>
<script src="js/cssmenu/script.js"></script>
<script type="text/javascript" src="js/jquery.easing.1.3.js"></script>
<script src="src/jquery.anyslider.js"></script>
<script src="js/bootstrap.js"></script>
<script src="js/moment-with-locales.js"></script>
<script type="text/javascript" src="js/bootstrap-datepicker.js"></script>
<title><?=$bsiCore->config['conf_portal_name']?> : Agent Manage Booking</title>
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
                        	<div class="col-md-12">
                            	<div class="container-fluid">
                    				<div class="row">
                        				<div class="col-md-12 sernbox">
                            				<h2 class="sett3"><span><?=HI?>, <?=$_SESSION['Myname2012']?></span><?=MY_ACCOUNT_MY_BOOKINGS?></h2>
                                		</div>
                                    </div>
                                 </div>
                            </div>
                        </div>
                    
                		<div class="row" style="margin-top:20px;">
                        	<div class="col-md-3">
                            	<div class="container-fluid">
                					<div class="row">
                        				<div class="col-md-12 padmarzero">
                                        	<ul  class="list-group">
                                              <li class="list-group-item active"><a href="agent_managebooking.php"><?=MANAGE_MY_BOOKINGS?> » </a></li>
                                                <li class="list-group-item"><a href="agent_editAccount.php"><?=UPDATE_UR_PROFILE?> » </a></li>
												<li class="list-group-item"><a href="agenthotel_list.php"><?=NEW_ADD_NEW_HOTEL?> »  </a></li>
                                                <li class="list-group-item"><a href="agent_changepass.php"><?=CHANGE_PASSWORD?> » </a></li>
												<li class="list-group-item"><a href="agent_logout.php"><?=LOG_OUT?> </a></li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-9">
                                <div class="container-fluid">
                					<div class="row">
                        				<div class="col-md-12 sernbox">
                                             <div class="container-fluid">
                                                <div class="row">
                                                    <div class="col-md-12" style="padding:0px;">
                                                    	
                                             			<div class="table-responsive">
                                                          <table class="table table-striped">
                                                          	<tr>
                                                             	<th><?php echo BOOKING_ID;?></th> 	 	 	 	 	
                                                                <th><?php echo HOTEL_NAME;?></th>
                                                                <th><?php echo CLIENT_NAME;?></th>
                                                                <th><?php echo BOOKING_PERIOD;?></th>
                                                                <th><?php echo AMOUNT;?></th>
                                                                <th><?php echo STATUS;?></th>
                                                                <th><?php echo ACTION;?></th>
                                                             </tr>
															 
															 
															 
					
<?php

$getBookingQuery		=	'';

if(isset($_SESSION['client_id2012'])){

	$getBookingQuery	=	$bsiCore->getAgentBookingDetails($_SESSION['client_id2012']);

}

$getBookingResult	=	mysql_query($getBookingQuery);

while($row_my_booking = mysql_fetch_assoc($getBookingResult)){

	$agentArr       = $bsiCore->client($row_my_booking['client_id']);

	$stylestr = '';	

	$stastus 		=  	'';

	$today   		=  	date('Y-m-d');
	
	$chekoutdate	=	$row_my_booking['end_date'];

	if($row_my_booking['is_deleted'] == 0 && $chekoutdate >= $today){ $stastus.='<span class="label label-success">'.ACTIVE.'</span>'; }

	else if($row_my_booking['is_deleted'] == 0 && $chekoutdate < $today){ $stastus.='<span class="label label-primary">'.DEPARTED.'</span>'; }

	else{ $stastus.='<span class="label label-danger">'.CANCELLED.'</span>'; }

	$name    = $row_my_booking['hotel_name'];

	$namelen = strlen($row_my_booking['hotel_name']);

	$name1   = substr($row_my_booking['hotel_name'], 0, 16);

	$name2   = substr($row_my_booking['hotel_name'], 17, 16);

	$name3   = substr($row_my_booking['hotel_name'], 17, 16);

	if($namelen < 35){

		$name = $name1."<br/>".$name2;

	}else if($namelen > 36){

		$name = $name1."<br/>".$name3."..";

	}else{

		$name = $row_my_booking['hotel_name']; 

	}

?>

 <tr>

              <td><?php echo $row_my_booking['booking_id'];?></td>

              <td><?php echo $name;?></td>
			  <td><?php echo $agentArr['first_name']." ".$agentArr['surname'];?></td>

              <td><?php echo $row_my_booking['checkin_date'];?>

            -

            <?php echo $row_my_booking['checkout_date'];?></td>

              <td><?php echo  $bsiCore->currency_symbol().$row_my_booking['payment_amount'];?></td>

              <td><?php echo  $stastus;?></td>

              <td><a href="agent_booking_request.php?bid=<?php echo $row_my_booking['booking_id'];?>" style="cursor:pointer;" id="m_booking">

               <?php echo MANAGE_BOOKING;?>

                </a></td>

            </tr>

<?php //$flag++; 
} ?>
                                                         
                                                          </table>
                                                        </div>
                                                        
                                                    </div> 
                                                </div>
                                                <div class="clr"></div>
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
<br />
<br />
<br />

<?php include("footer.php");?>

</body>
</html>
