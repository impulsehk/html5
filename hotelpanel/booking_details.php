<?php
include("access.php");
//session_start();
include("../includes/db.conn.php");
include("../includes/conf.class.php");
include("../includes/admin.class.php");
$hotelrow = $bsiAdminMain->getHotelDetails($_SESSION['hhid']);
/*include("includes/language.php");
if(isset($_SESSION['language'])){
$htmlCombo=$bsiCore->getbsilanguage($_SESSION['language']);
}else{
$htmlCombo=$bsiCore->getbsilanguage(); 
}*/
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
<title><?=$bsiCore->config['conf_portal_name']?> :  Client Booking Request</title>
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
                            				<h2 class="sett3"><span><?=$hotelrow['hotel_name']?><br>Front Desk System 前台系統</h2>
                                		</div>
                                    </div>
                                 </div>
                            </div>
                        </div>
                    
                		<div class="row" style="margin-top:20px;">
                        	<div class="col-md-2">
                            	<div class="container-fluid">
                					<div class="row">
                        				<div class="col-md-12 padmarzero">
                                        	<ul  class="list-group">
                                            <li class="list-group-item"><a href="hotel-home.php">Dashboard 主頁 » </a></li>
                                            <li class="list-group-item active"><a href="booking_list.php">Booking List 今日客人表 » </a></li>
											<li class="list-group-item"><a href="booking_history.php">Booking History 訂房紀錄 » </a></li>
											<li class="list-group-item"><a href="hotel_logout.php">Log Out 登出</a></li>
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
	
	
	//$booking_status=$rowbookingdata['booking_status'];
	//echo "select * from bsi_reservation where booking_id='".$bookingid."'";die;
	$bookingstatus=mysql_fetch_assoc(mysql_query("select * from bsi_reservation where booking_id='".$bookingid."'"));
	$booking_status=$bookingstatus['boking_status'];
	if($rowbookingdata['is_deleted']=='0'){
	if($bookingstatus['boking_status']==0){$current_status='Confirm 房間已確認';}
	if($bookingstatus['boking_status']==1){$current_status='Confirm 房間已確認';}
	if($bookingstatus['boking_status']==2){$current_status='Check In 已入住';}
	if($bookingstatus['boking_status']==3){$current_status='Check Out 已離開';}
	}else{
	$current_status='Cancel 取消訂房';}
	
	$i					= 1;
	$num				= mysql_num_rows($result);
	$adult1				=0; 
	while($row = mysql_fetch_assoc($result)){
		if($i == $num){
			$rooms1 .= $row['count']." x ".$row['type_name']." (".$row['title'].").";
		}else{
			$rooms1 .= $row['count']." x ".$row['type_name']." (".$row['title'].").<br/>";
		}
		$nor=$row['count'];
		$i++;
		$adult1=$adult1+$row['capacity']; 
			}
	/*if(isset($_SESSION['adult'])){
		$adult1 = $_SESSION['adult'];
	}else{
		$adult1 = 1;
	}*/
?>							



                            <div class="col-md-10">
                                <div class="container-fluid">
                					<div class="row">
                        				<div class="col-md-12 sernbox">
                                             <div class="container-fluid">
                                             	<div class="row" style="padding-top:10px; padding-bottom:10px;">
<div class="col-md-2">
<button class="searchbtn5" onClick="javascript:myPopup2('<?=$bookingid?>');" >
<span class="glyphicon glyphicon-print" aria-hidden="true"></span><br />
Print 列印紀錄
</button>
</div>

<div class="col-md-2">
<button class="searchbtn5" id="statusconfirm" value="1" style="background-color:orange;">
Confirm 房間已確認
</button>
</div>

<div class="col-md-2">
<button class="searchbtn5" id="stauscheckin" value="2" style="background-color:orange;">
Check In 已入住
</button>
</div>

<div class="col-md-2">
<button class="searchbtn5" id="statuscheckout" value="3" style="background-color:orange;">
Check Out 已離開
</button>
</div>



<?php
	 	$statusArr = $bsiCore->checkBookingStatus($bookingid);
		$cur_date  = date('Y-m-d');
		//if(!($cur_date>$statusArr['checkin_date']) && $statusArr['is_deleted'] != 1){
		//if(!($cur_date>$statusArr['checkin_date'])){
?>

<div class="col-md-2">
<button class="searchbtn5" onClick="return cancelDialogue('<?=$bookingid?>');" style="background-color:orange;">
Cancel 取消訂房
</button>
<?php
//}else { echo '<div class="col-md-2">&nbsp;'; }
?>
</div>

<div class="col-md-2">

<button class="searchbtn5" onClick="javascript:myPopup3('<?=$bookingid?>');" >
<span class="glyphicon glyphicon-print" aria-hidden="true"></span><br />
Voucher 客人憑証
</button>

<!--<button class="searchbtn5">
<span class="glyphicon glyphicon-print" aria-hidden="true"></span><br />
Print Hotel Voucher
</button>-->
</div>


                                                </div>
                                                <div class="row">
                                                    <div class="col-md-12">
<div class="panel  panel-info">
  <div class="panel-heading"><strong>Booking Details 訂房詳細紀錄</strong></div>
<?php 

$clientArr = $bsiAdminMain->getClientInfo($rowbookingdata['client_id']);

$amountdue=$rowbookingdata['total_cost']-$rowbookingdata['payment_amount'];

?>
  <table class="table">
  <input type="hidden" value="<?php echo $bookingid;?>" name="bookingid" id="bookingid" >
   <tr>
    	<td><strong>Name<br>姓名</strong></td>
        <td><?=$clientArr['first_name']?></td>
    </tr>
    
     <tr>
    	<td><strong>Phone<br>電話</strong></td>
        <td><?=$clientArr['phone']?></td>
    </tr>
    
    <tr>
    	<td><strong>Email<br>電郵</strong></td>
        <td><?=$clientArr['email']?></td>
    </tr>

     <tr>
    	<td><strong>Booking Time<br>訂房時間</strong></td>
        <td><?=date("H:i:s",strtotime($rowbookingdata['bt']))?></td>
    </tr>
  
    <tr>
    	<td><strong>Booking Date<br>訂房日期</strong></td>
        <td><?=$rowbookingdata['booktime']?></td>
    </tr>
    
    <tr>
    	<td><strong>Check In Date<br>入住日期</strong> </td>
        <td><?=$rowbookingdata['checkin_date']?></td>
    </tr>
    
    <tr>
    	<td><strong>Paid<br>己繳款</strong> </td>
        <td><?=$bsiCore->currency_symbol().$rowbookingdata['payment_amount']?></td>
    </tr>
    
    <tr>
    	<td><strong>Amount Due<br>欠款</strong> </td>
        <td><?=$bsiCore->currency_symbol().$amountdue?></td>
    </tr>
    
    <tr>
    	<td><strong>Booking ID<br>訂房ID</strong> </td>
        <td><?=$bookingid?></td>
    </tr>
    
     <tr>
    	<td><strong>Room Type<br>房型</strong> </td>
        <td><?=$rooms1?></td>
    </tr>
    
     <tr>
    	<td><strong>No Of Rooms<br>房間數量</strong> </td>
        <td><?=$nor?></td>
    </tr>
    
    <tr>
    	<td><strong>Status<br>狀態</strong> </td>
        <td><?=$current_status?></td>
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


<?php //include("footer.php");?>

<!--<script src="js/jquery.min.js"></script>
<script src="js/bootstrap.js"></script>
<script src="js/cssmenu/script.js"></script>-->

<script language="javascript">    

	function cancelDialogue(booking_id){

		var booking_id;

		var answer;

		var cancel_id=1;

		booking_id=booking_id;

		

		answer=confirm("Do You really want to cancel Your Booking ?");

		if(answer == true){

			window.location="booking_list.php?cancel="+cancel_id+"&booking_id="+booking_id;	

		}

	}

    

    function myPopup2(booking_id){

		//alert(booking_id);

		var width = 730;

		var height = 650;

		var left = (screen.width - width)/2;

		var top = (screen.height - height)/2;

		var url='../print_invoice.php?bid='+booking_id;

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

		var url='../data/invoice/voucher_'+booking_id+'.pdf';
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

<script type="text/javascript"> 

$(document).ready(function(){
$('#statusconfirm').click(function(){
var querystr = 'actioncode=25&status='+$('#statusconfirm').val()+'&booking_id='+$('#bookingid').val();
//alert(querystr);
$.post("../ajax-processor.php", querystr, function(data){						 
if(data.errorcode == 0){	
location.reload();	
}else{
alert(data.strhtml);
}
}, "json");
});
});
	
</script>

<script type="text/javascript"> 

$(document).ready(function(){
$('#stauscheckin').click(function(){
var querystr = 'actioncode=25&status='+$('#stauscheckin').val()+'&booking_id='+$('#bookingid').val();
//alert(querystr);
$.post("../ajax-processor.php", querystr, function(data){						 
if(data.errorcode == 0){	
location.reload();	
}else{
alert(data.strhtml);
}
}, "json");
});
});
	
</script>

<script type="text/javascript"> 

$(document).ready(function(){
$('#statuscheckout').click(function(){
var querystr = 'actioncode=25&status='+$('#statuscheckout').val()+'&booking_id='+$('#bookingid').val();
//alert(querystr);
$.post("../ajax-processor.php", querystr, function(data){						 
if(data.errorcode == 0){	
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
