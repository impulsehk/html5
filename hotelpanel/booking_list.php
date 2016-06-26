<?php
include("access.php");
//session_start();
include("../includes/db.conn.php");
include("../includes/conf.class.php");
include("../includes/admin.class.php");
include("../includes/mail.class.php");

if((isset($_GET['cancel'])) && ($_GET['cancel'] == 1)){
	$booking_id	=  $bsiCore->ClearInput($_GET['booking_id']);
	$bsiCore->cancelBooking($booking_id);
	header("location:booking_list.php");
	exit;
}



$hotelrow = $bsiAdminMain->getHotelDetails($_SESSION['hhid']);

if(isset($_SESSION['hhid']))
{
	$book_type = 6;
	$hotel_id  = $_SESSION['hhid'];
}


$query = $bsiAdminMain->getBookingInfo($book_type, $hotel_id);

$result = mysql_query($query);
if(mysql_num_rows($result)){
				
				while($row = mysql_fetch_assoc($result)){
					
//*************************For Room Name
$rooms1='';					
$roomnamequery = $bsiCore->getNoOfRoom($row['booking_id']);
$roomnameresult = mysql_query($roomnamequery);
$num = mysql_num_rows($roomnameresult);
while($roomnamerow = mysql_fetch_assoc($roomnameresult)){
		if($i == $num){
			$rooms1 .= $roomnamerow['type_name']." (".$roomnamerow['title'].").";
		}else{
			$rooms1 .= $roomnamerow['type_name']." (".$roomnamerow['title'].").<br/>";
		}
}
					
					$chekoutdate	=	$row['chkOut'];
$stastus='';
$today=date('Y-m-d');
/*if($row_my_booking['is_deleted'] == 0 && $chekoutdate >= $today){ $stastus.='<span class="label label-success">Active</span>'; }
else if($row_my_booking['is_deleted'] == 0 && $chekoutdate < $today){ $stastus.='<span class="label label-primary">Departed</span>'; }
else{ $stastus.='<span class="label label-danger">Cancelled</span>'; }*/
if($row['is_deleted'] == '0'){
	
	$bookingstatus=mysql_fetch_assoc(mysql_query("select * from bsi_reservation where booking_id='".$row['booking_id']."'"));
	$booking_status=$bookingstatus['boking_status'];
	if($bookingstatus['boking_status']==0){$stastus.='<span class="label label-success">Confirm</span>';}
	if($bookingstatus['boking_status']==1){$stastus.='<span class="label label-success">Confirm</span>';}
	if($bookingstatus['boking_status']==2){$stastus.='<span class="label label-primary">Check In</span>';}
	if($bookingstatus['boking_status']==3){$stastus.='<span class="label label-csuccess">Check Out</span>';}
	
	}else{$stastus.='<span class="label label-danger">Cancelled</span>';}
					$clientArr = $bsiAdminMain->getClientInfo($row['client_id']);
				
					
					$amountdue=$row['total_cost']-$row['payment_amount'];
					
					//if(NOW() - $row['bt']) < 3000
					$time1 = strtotime(date('Y-m-d H:i:s'));
					$time2 = strtotime($row['bt']);
					$diff = $time1-$time2;
					$alert='';
					if($diff<1800)
					{$alert='bgcolor="#FF6666"';}
                    // var_dump($row);
						//$taoday= date('Y-m-d H:i:s');;
					$html .= '<tr > 
								<td  '.$alert.'>'.$clientArr['first_name'].'</td>
								<td  '.$alert.'>'.$clientArr['phone'].'</td>
								<td  '.$alert.'>'.substr($row['bt'],10).'</td>
                                <td  '.$alert.'>'.$row['start_date'].'</td>
								<td  '.$alert.'>'.$rooms1.'</td>
								<td  '.$alert.'>'.$bsiCore->currency_symbol().$amountdue.'</td>
								<td>'.$stastus.'</td>
								<td><a href="booking_details.php?bid='.$row['booking_id'].'" style="cursor:pointer;" id="m_booking">Manage Booking</td>
							  </tr>';
                                // <td  '.$alert.'>'.$clientArr['first_name'].'</td>
                                // <td  '.$alert.'>'.$clientArr['phone'].'</td>
                                // <td  '.$alert.'>'.date("H:i:s",strtotime($row['ct'])).'</td> 
                                // <td  '.$alert.'>'.$row['booking_time'].'</td>
                                // <td  '.$alert.'>'.$rooms1.'</td>
                                // <td  '.$alert.'>'.$bsiCore->currency_symbol().$amountdue.'</td>
                                // <td>'.$stastus.'</td>
                                // <td><a href="booking_details.php?bid='.$row['booking_id'].'" style="cursor:pointer;" id="m_booking">Manage Booking</td>
                }

			} 


?>
<!doctype html>
<html>
<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta http-equiv="refresh" content="300;url=booking_list.php">
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
<title><?=$bsiCore->config['conf_portal_name']?> : Hotel Booking List</title>

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
                            				<h2 class="sett3"><span>Welcome To <?=$hotelrow['hotel_name']?></h2>
                                		</div>
                                    </div>
                                 </div>
                            </div>
                        </div>
                    
                		<div class="row" style="margin-top:20px;">
                        	
                            <div class="col-md-10 col-md-push-2">
                                <div class="container-fluid">
                					<div class="row">
                        				<div class="col-md-12 sernbox">
                                             <div class="container-fluid">
                                                <div class="row">
                                                    <div class="col-md-12" style="padding:0px;">
                                                    	
                                             			<div class="table-responsive">
                                                          <table class="table table-striped">
                                                          	<tr>
                                                             <th>Customer Name</th> 	 	 	 	 	
                                                             <th>Customer Phone</th>
                                                             <th>Booking Time</th>
                                                             <th>Booking Date</th>
                                                             <th>Room Type</th>
                                                             <th>Amount Due</th>
                                                             <th>Status </th>
                                                                <th></th>
                                                             </tr>
															 
															 <?php echo $html;

?>
															 
                                                           
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
                            
                            <div class="col-md-2 col-md-pull-10">
                            	<div class="container-fluid">
                					<div class="row">
                        				<div class="col-md-12 padmarzero">
                                        	<ul  class="list-group">
                                             <li class="list-group-item"><a href="hotel-home.php">Dashboard » </a></li>
                                             <li class="list-group-item active"><a href="booking_list.php">Booking List » </a></li>
                                             <li class="list-group-item"><a href="booking_history.php">Booking History » </a></li>
											 <li class="list-group-item"><a href="hotel_logout.php">Logout</a></li>
                                            </ul>
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

<!--<script src="js/jquery.min.js"></script>
<script src="js/bootstrap.js"></script>
<script src="js/cssmenu/script.js"></script>
-->
<style>
.label-csuccess {
	background-color:#C0C;
}

mark {
   /* background-color: yellow;*/
	background-color:#C33;
    color: black;
}
</style>
</body>
</html>
