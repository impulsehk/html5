<?php
include("access.php");
include("includes/db.conn.php");
include("includes/conf.class.php"); 
include("includes/language.php");
if(isset($_SESSION['language'])){
$htmlCombo=$bsiCore->getbsilanguage($_SESSION['language']);
}else{
$htmlCombo=$bsiCore->getbsilanguage(); 
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
<title><?=$bsiCore->config['conf_portal_name']?> : Agent Booking Request</title>
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
                                                <li class="list-group-item"><a href="agent_managebooking.php"><?=MANAGE_MY_BOOKINGS?> » </a></li>
                                                <li class="list-group-item"><a href="agent_editAccount.php"><?=UPDATE_UR_PROFILE?> » </a></li>
												<li class="list-group-item"><a href="agenthotel_list.php"><?=NEW_ADD_NEW_HOTEL?> »  </a></li>
                                                <li class="list-group-item"><a href="agent_changepass.php"><?=CHANGE_PASSWORD?> » </a></li>
												<li class="list-group-item"><a href="agent_logout.php"><?=LOG_OUT?> </a></li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>
							
							
							
<?php

	$rooms1             = '';

	$bookingid			= $bsiCore->ClearInput($_GET['bid']);

	$rowbookingdata		= $bsiCore->getBookingInfo($bookingid);

	$query				= $bsiCore->getNoOfRoom($bookingid);

	$result 			= mysql_query($query);

	$i					= 1;
	
	$adult1              =0;

	$num				= mysql_num_rows($result);

	while($row = mysql_fetch_assoc($result)){

		if($i == $num){

			$rooms1 .= $row['count']." x ".$row['type_name']." (".$row['title'].").";

		}else{

			$rooms1 .= $row['count']." x ".$row['type_name']." (".$row['title'].").<br/>";

		}

		$i++;
		
		$adult1=$adult1+$row['capacity']; 

	}


	/*if(isset($_SESSION['adult'])){

		$adult1 = $_SESSION['adult'];

	}else{

		$adult1 = 1;

	}*/

?>


                            <div class="col-md-9">
                                <div class="container-fluid">
                					<div class="row">
                        				<div class="col-md-12 sernbox">
                                             <div class="container-fluid">
                                             	<div class="row" style="padding-top:10px; padding-bottom:10px;">
<div class="col-md-4">
<button class="searchbtn5" onClick="javascript:myPopup2('<?=$bookingid?>');" >
<span class="glyphicon glyphicon-print" aria-hidden="true"></span><br />
<?=PRINT_BOOKING_DETAILS?>
</button>
</div>
<div class="col-md-4">
<button class="searchbtn5" onClick="javascript:myPopup3('<?=$bookingid?>');" >
<span class="glyphicon glyphicon-print" aria-hidden="true"></span><br />
<?=PRINT_HOTEL_VOUCHER?>
</button>
</div>

<?php
	 	$statusArr = $bsiCore->checkBookingStatus($bookingid);
		$cur_date  = date('Y-m-d');
		if(!($cur_date>$statusArr['checkin_date']) && $statusArr['is_deleted'] != 1){
?>

<div class="col-md-4">
<button class="searchbtn5" onClick="return cancelDialogue('<?=$bookingid?>');" >
<span class="glyphicon glyphicon-print" aria-hidden="true"></span><br />
<?=CANEL_MY_BOOKING?>
</button>
<?php

		}else { echo '<div class="col-md-4">&nbsp;'; }

	 ?>
</div>
</div>

                                                <div class="row">
                                                    <div class="col-md-12">
<div class="panel  panel-info">
  <div class="panel-heading"><strong><?=BOOKING_DETAILS?></strong></div>

  <table class="table">
    <tr>
    	<td><?=BOOKING_ID?></td>
        <td><?=$rowbookingdata['booking_id']?></td>
    </tr>
    <tr>
    	<td><?=CLIENT_NAME?></td>
        <td><?=$rowbookingdata['first_name']?>  <?=$rowbookingdata['surname']?></td>
    </tr>
    <tr>
    	<td><?=HOTEL_NAME?></td>
        <td><?=$rowbookingdata['hotel_name']?></td>
    </tr>
    <tr>
    	<td><?=ADDRESS?></td>
        <td><?=$rowbookingdata['address_1']?> <?=$rowbookingdata['address_2']?></td>
    </tr>
    <tr>
    	<td><?=ARRIVAL?></td>
        <td><?=$rowbookingdata['checkin_date']?></td>
    </tr>
    <tr>
    	<td><?=DEPATURE?></td>
        <td><?=$rowbookingdata['checkout_date']?></td>
    </tr>
    <tr>
    	<td><?=NUMBER_OF_ROOMS?></td>
        <td><?=$rooms1?></td>
    </tr>
    <tr>
    	<td><?=NUMBER_OF_ADULTS?></td>
        <td><?=$adult1?></td>
    </tr>
    <tr>
    	<td><?=NUMBER_OF_CHILDREN?></td>
        <td><?=$rowbookingdata['child_count']?></td>
    </tr>
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

<script language="javascript">    

	function cancelDialogue(booking_id){

		var booking_id;

		var answer;

		var cancel_id=1;

		booking_id=booking_id;

		

		answer=confirm("Do You really want to cancel Your Booking ?");

		if(answer == true){

			window.location="agent_managebooking.php?cancel="+cancel_id+"&booking_id="+booking_id;	

		}

	}

    

    function myPopup2(booking_id){

		//alert(booking_id);

		var width = 730;

		var height = 650;

		var left = (screen.width - width)/2;

		var top = (screen.height - height)/2;

		var url='print_invoice.php?bid='+booking_id;

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
