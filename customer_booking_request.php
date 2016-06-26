<?php
include("access.php");
include("includes/db.conn.php");
include("includes/conf.class.php"); 
include("includes/language.php");
if(isset($_SESSION['default_lang'])){
	$htmlCombo=$bsiCore->getbsilanguage($_SESSION['default_lang']);
}else{
	$htmlCombo=$bsiCore->getbsilanguage(); 
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html lang="en-us" xml:lang="en-us" xmlns="http://www.w3.org/1999/xhtml">
	<head profile="http://a9.com/-/spec/opensearch/1.1/">
	<title>
    <?=$bsiCore->config['conf_portal_name']?>
    </title>
	<!-- Meta tags -->
	<meta http-equiv="content-language" content="en-us" />
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<meta http-equiv="Content-Script-Type" content="text/javascript" />
	<meta http-equiv="Content-Style-Type" content="text/css" />
	<meta http-equiv="window-target" content="_top" />
	<!-- skip frames -->
	<meta name="robots" content="index,follow" />
	<meta name="keywords" content="booking, hotel, hotels, reservations" />
	<meta name="description" content="Online Booking" />
	<!-- Favicons -->
	<link href="img/favicon.png" rel="shortcut icon" type="image/png" />
	<link href="img/favicon.png" rel="icon" type="image/png" />
	<!-- Main Stylesheets -->
	<link href="css/style.css" media="screen" rel="stylesheet" type="text/css" />
	<link href="css/extensions.css" media="screen" rel="stylesheet" type="text/css" />
	<!-- browser specific extensions / remove it if you want to validate this document -->
	<link href="css/print.css" media="print" rel="stylesheet" type="text/css" />
	<!-- for printing -->
	<!-- Alternate stylesheets/themes -->
	<link href="css/orange.css" media="screen" rel="alternate stylesheet" type="text/css" title="orange" />
	<link href="css/pink.css" media="screen" rel="alternate stylesheet" type="text/css" title="pink" />
	<link href="css/red.css" media="screen" rel="alternate stylesheet" type="text/css" title="red" />
	<link href="css/blue.css" media="screen" rel="alternate stylesheet" type="text/css" title="blue" />
	<link href="css/brown.css" media="screen" rel="alternate stylesheet" type="text/css" title="brown" />
	<link href="css/cyan.css" media="screen" rel="alternate stylesheet" type="text/css" title="cyan" />
	<link href="css/purple.css" media="screen" rel="alternate stylesheet" type="text/css" title="purple" />
	<!-- Your Custom Stylesheet -->
	<link href="css/custom.css" media="screen" rel="stylesheet" type="text/css" />
	<!-- RSS links (if needed) -->
	<link href="top.rss" rel="alternate" type="application/rss+xml" title="Top Destinations" />
	<link href="deals.rss" rel="alternate" type="application/rss+xml" title="Best Deals" />
	<link href="blog.rss" rel="alternate" type="application/rss+xml" title="Latest News" />
	<!-- jQuery with plugins -->
	<script src="js/jquery-1.4.2.min.js" type="text/javascript"></script><!-- Could be loaded remotely from Google CDN : <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.4.2/jquery.min.js" type="text/javascript"></script> -->
	<script src="js/jquery.ui.core.min.js" type="text/javascript"></script>
	<script src="js/jquery.ui.widget.min.js" type="text/javascript"></script>
	<script src="js/jquery.ui.tabs.min.js" type="text/javascript"></script>
	<script src="js/jquery.datepick.pack.js" type="text/javascript"></script>
	<script src="js/jquery.datepick-en-GB.js" type="text/javascript"></script><!--  Datepick localisations: http://keith-wood.name/datepick.html -->
	<script src="js/jquery.imgpreview.js" type="text/javascript"></script>
	<script src="js/jquery.nyroModal.pack.js" type="text/javascript"></script>
	<script src="js/jquery.notice.js" type="text/javascript"></script>
	<script src="js/jquery.cycle.pack.js" type="text/javascript"></script>
	<script src="js/jquery.notice.js" type="text/javascript"></script>
	<!-- Google maps and marker clustering -->
	<script src="http://www.google.com/jsapi?autoload={'modules':[{name:'maps',version:3,other_params:'sensor=false'}]}" type="text/javascript"></script>
	<script src="js/Fluster2.packed.js" type="text/javascript"></script>
	<!-- Custom template functions -->
	<script src="js/custom.js" type="text/javascript"></script>
	<!-- Style switcher : only needed here for theme demonstration (does not work in IE7) -->
	<script src="js/styleswitch.js" type="text/javascript"></script>
	<!-- Internet Explorer Fixes -->
	<!--[if IE]>
	<link rel="stylesheet" type="text/css" media="all" href="css/ie.css"/>
	<![endif]-->
	<!--Upgrade MSIE5.5-7 to be compatible with MSIE8: http://ie7-js.googlecode.com/svn/version/2.1(beta3)/IE8.js -->
	<!--[if lt IE 8]>
	<script src="js/IE8.js"></script>
	<![endif]-->
	<script type="text/javascript">
	//<![CDATA[
		
		
	$(document).ready(function(){
		
		// Template setup
		Site.setup();
		
		// FAQ click handling
		$('.question > a').click(function() {
			$(this).parent().find('q').toggle();
			return false;
		});
	
	});
	
	
	//]]>
	</script>
	<script language="javascript">    
	function cancelDialogue(booking_id){
		var booking_id;
		var answer;
		var cancel_id=1;
		booking_id=booking_id;
		
		answer=confirm("Do You really want to cancel Your Booking ?");
		if(answer == true){
			window.location="managebooking.php?cancel="+cancel_id+"&booking_id="+booking_id;	
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
	</head>
	<?php include("header.php");?>
	<!-- End of Header -->
	
<div class="grid_12">
      <div class="note"> 
    
    <!-- Breadcrumb -->
    
    <div class="breadcrumb"><strong><?=HI?>,
      <?=$_SESSION['Myname2012']?>
      </strong></div>
    <h5 style="padding-left:9px;"><?=MY_ACCOUNT_MY_BOOKINGS?></h5>
  </div>
    </div>
<!-- Left menu: Categories -->
<div class="grid_3">
      <div class="grid_3">
    <ul class="list tr">
          <li><a href="my_account.php"><?=MANAGE_MY_BOOKINGS?></a> &raquo;&nbsp;</li>
          <li><a href="review_submit.php"><?=SUBMIT_HOTEL_REVIEW?></a> &raquo;&nbsp;</li>
          <li><a href="editAccount.php?edit=333"><?=UPDATE_UR_PROFILE?></a> &raquo;&nbsp;</li>
          <li><a href="editAccount.php?change=555"><?=CHANGE_PASSWORD?></a> &raquo;&nbsp;</li>
          <li><a href="logout.php"><?=LOG_OUT?></a> &raquo;&nbsp;</li>
        </ul>
  </div>
    </div>
<!-- End of Left menu: Categories --> 
<!-- Questions and Answers -->
<div class="grid_9">
      <div class="padded" id="bookingdetails">
    <?php
	$rooms1             = '';
	$bookingid			= $bsiCore->ClearInput($_GET['bid']);
	$rowbookingdata		= $bsiCore->getBookingInfo($bookingid);
	$query				= $bsiCore->getNoOfRoom($bookingid);
	$result 			= mysql_query($query);
	$i					= 1;
	$num				= mysql_num_rows($result);
	while($row = mysql_fetch_assoc($result)){
		if($i == $num){
			$rooms1 .= $row['count']." x ".$row['type_name']." (".$row['title'].").";
		}else{
			$rooms1 .= $row['count']." x ".$row['type_name']." (".$row['title'].").<br/>";
		}
		$i++;
	}
	if(isset($_SESSION['adult'])){
		$adult1 = $_SESSION['adult'];
	}else{
		$adult1 = 1;
	}
?>
    <table width="100%" cellpadding="6">
          <tr>
        <td class="asButton" ><input type="button" class="btn btn-custom radius " value="      <?=PRINT_BOOKING_DETAILS?>      " onclick="javascript:myPopup2('<?=$bookingid?>');" /></td>
        <td class="asButton" align="left"><input type="button" class="btn btn-custom radius " value="     <?=PRINT_HOTEL_VOUCHER?>     " onclick="javascript:myPopup3('<?=$bookingid?>');" /></td>
        <td class="asButton"><?php
	 	$statusArr = $bsiCore->checkBookingStatus($bookingid);
		$cur_date  = date('Y-m-d');
		if(!($cur_date>$statusArr['checkin_date']) && $statusArr['is_deleted'] != 1){
     ?>
              <input type="button" class="btn btn-custom radius " value="      <?=CANEL_MY_BOOKING?>      " onclick="return cancelDialogue('<?=$bookingid?>');" />
              <?php
		}else { echo '<div style="width:200px;">&nbsp;</div>'; }
	 ?></td>
      </tr>
          <tr>
        <td colspan="3"><table cellpadding="2" cellspacing="0" style="border:0px solid #f6f7f8;" width="100%">
            <tr style="background-color:#9C9; height:35px;">
              <td colspan="2"><strong><?=BOOKING_DETAILS?></strong></td>
            </tr>
            <tr class="tableStyle">
              <td width="160px" align="left"><?=BOOKING_ID?></td>
              <td><?=$rowbookingdata['booking_id']?></td>
              <input type="hidden" name="booking_id" id="booking_id" value="<?=$rowbookingdata['booking_id']?>" />
            </tr>
            <tr class="tableStyle2">
              <td width="160px" align="left"><?=CLIENT_NAME?></td>
              <td><?=$rowbookingdata['first_name']?>
                <?=$rowbookingdata['surname']?></td>
            </tr>
            <tr class="tableStyle">
              <td width="160px" align="left"><?=HOTEL_NAME?></td>
              <td><?=$rowbookingdata['hotel_name']?></td>
            </tr>
            <tr class="tableStyle2">
              <td width="160px" align="left"><?=ADDRESS?></td>
              <td><?=$rowbookingdata['address_1']?>
                <br/>
                <?=$rowbookingdata['address_2']?></td>
            </tr>
            <tr class="tableStyle">
              <td width="160px" align="left"><?=ARRIVAL?></td>
              <td><?=$rowbookingdata['checkin_date']?></td>
            </tr>
            <tr class="tableStyle2">
              <td width="160px" align="left"><?=DEPATURE?></td>
              <td><?=$rowbookingdata['checkout_date']?></td>
            </tr>
            <tr class="tableStyle">
              <td width="160px" align="left"><?=NUMBER_OF_ROOMS?></td>
              <td><?=$rooms1?></td>
            </tr>
            <tr class="tableStyle2">
              <td width="160px" align="left"><?=NUMBER_OF_ADULTS?></td>
              <td><?=$adult1?></td>
            </tr>
            <tr  class="tableStyle">
              <td width="160px" align="left"><?=NUMBER_OF_CHILDREN?></td>
              <td><?=$rowbookingdata['child_count']?></td>
            </tr>
          </table></td>
      </tr>
        </table>
  </div>
    </div>
<!-- End of Questions and Answers -->
<p>&nbsp;</p>
<div class="clear">&nbsp;</div>
</div>
<?php include("footer.php"); ?>
<!-- Scroll to top link --> 
<a href="#" id="totop" class="radius" title="back to top"><img src="img/top.png" alt="back to top" /></a>
</body></html>