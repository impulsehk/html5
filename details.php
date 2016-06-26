<?php
error_reporting(0);
    session_start();
	if(isset($_POST['check_in'])){
		include("includes/db.conn.php");
			
		/*$pos2 = strpos($_SERVER['HTTP_REFERER'], $_SERVER['SERVER_NAME']);
		if(!$pos2){
			header('Location: booking-failure.php?error_code=9x');
			exit;			
		}	*/
	
	
	
		include("includes/conf.class.php");
		include("includes/hotel-search.class.php");
		$abs_url=$bsiCore->abs_url(dirname(__FILE__));
		
		$bsiHotelSearch = new bsiHotelSearch(); 
		//*********************************** 
		$_SESSION['hotel_id']=$_POST['hotel_id'];
		$arrayAdult = $_POST['adults'];
		$arrayChild = $_POST['children'];
		$totalNoAdult = 0;
		$totalNoChild = 0;
		$childperrrom = '';
		$adultperrrom = '';
		foreach($arrayAdult as $i => $value){ 
			$adultperrrom .= $value.'#';
			$totalNoAdult += $value;
		}
		$adultperrrom = substr($adultperrrom, 0, -1);
		$_SESSION['adultperrrom'] = $adultperrrom;
		foreach($arrayChild as $i => $value){
			$childperrrom .= $value.'#';
			$totalNoChild += $value;
		}
		$childperrrom = substr($childperrrom, 0, -1);
		$_SESSION['childperrrom']  = $childperrrom;
		$_SESSION['sv_childcount'] = $childperrrom;
		//***********************************


//$bsiCore->clearExpiredBookings(); 
		//room search
		$recommended      = array();
		$recommendedHtml  = array();
		$recommendedPrice = '';
		
		if(!isset($_SESSION['adultperrrom'])){
			unset($_SESSION['adultperrrom']);
			$_SESSION['adultperrrom'] = '1'; 
		}
	
		$array_cnt_room = array_count_values(explode('#', $_SESSION['adultperrrom']));
		$adultperrrom   = array_unique(explode('#', $_SESSION['adultperrrom']));
		$totalRoomType  = array();
		$totalAvailabilityOfHotel = array();
		$availabilityByRoomTypeFinal = array();
		foreach($adultperrrom as $key => $capacity){
			$total_capacity[$capacity] = 0;
		}
		$sqlRoomType    = $bsiHotelSearch->hotelGetRoomType($_SESSION['hotel_id']);
		while($rowRoomType = mysql_fetch_assoc($sqlRoomType)){
			foreach($adultperrrom as $key => $capacityQty){			
				$sqlCapacity = $bsiHotelSearch->hotelGetCapacity($_SESSION['hotel_id'], $capacityQty);
				while($rowCapacity = mysql_fetch_assoc($sqlCapacity)){				
					$searchcorefunc = $bsiHotelSearch->getAvailableRooms($rowRoomType['roomtype_id'], $rowRoomType['type_name'], $rowCapacity['capacity_id'], $_SESSION['hotel_id'], $capacityQty, $rowCapacity['title'], $rowCapacity['capacity']); 
					$total_capacity[$capacityQty] += $searchcorefunc['availableNumberOfRoom'];				
					if($searchcorefunc['availableNumberOfRoom'] != 0){
						array_push($totalAvailabilityOfHotel, $searchcorefunc['totalAvailability']);
						array_push($totalRoomType, $rowRoomType['roomtype_id']);				
					}				
				}			
			}	
		}
		if(!empty($totalAvailabilityOfHotel)){
			unset($_SESSION['roomavailablity']);
			$availabilityByRoomTypeFinal[$_SESSION['hotel_id']] = $bsiHotelSearch->availabilityByRoomType($totalAvailabilityOfHotel,array_unique($totalRoomType)); 
			$_SESSION['roomavailablity'] = $totalAvailabilityOfHotel;
			$_SESSION['availabilityByRoomTypeFinal'] = $availabilityByRoomTypeFinal;
		}else{
			$_SESSION['roomavailablity'] = array();
			$_SESSION['availabilityByRoomTypeFinal'] = array();
		}
		$_SESSION['hotelsearch'] = 1;
		//header("location:details.php?hotel_id=".$_SESSION['hotel_id']);
		$hotelsql= mysql_query("select hotel_name from `bsi_hotels`  where hotel_id=".$_SESSION['hotel_id']);
		$hotelname = mysql_fetch_assoc($hotelsql);
		header("location:".str_replace(" ","-",strtolower(trim($hotelname['hotel_name']))).'-'.$_SESSION['hotel_id'].'.html');
		//header("location:".str_replace(" ","-",strtolower(trim('zfsdf'))).'-'.$_SESSION['hotel_id'].'.html');
		exit; 
	} 
	
	
	if(isset($_POST['mailtofrnd'])){
		include("includes/db.conn.php"); 
		include("includes/conf.class.php");
		include("includes/mail.class.php");
		$bsiMail = new bsiMail;
		$abs_url=$bsiCore->abs_url(dirname(__FILE__));
		$hotelsql= mysql_query("select * from `bsi_hotels`  where hotel_id=".$_POST['mailtofrnd']);
		$hotelname = mysql_fetch_assoc($hotelsql);
		$subject = 'HOTEL SUGGESTION';
		
		$emailbody ='
		Hi<br/><br/>I found this hotel.<br/>
		You can check this :  <a href="'.$abs_url.'/'.$hotelname['city_name'].'/'.str_replace(" ","-",strtolower(trim($hotelname['hotel_name']))).'-'.$hotelname['hotel_id'].'.html">'.$abs_url.'/'.$hotelname['city_name'].'/'.str_replace(" ","-",strtolower(trim($hotelname['hotel_name']))).'-'.$hotelname['hotel_id'].'.html</a>
		<br/>'.$_POST['msg'].'<br/>
		Mailed sent from <br/> '.$bsiCore->config['conf_portal_name'];
		$bsiMail->sendEMail($_POST['email2'], $subject, $emailbody);
		header("location:".$hotelname['city_name'].'/'.str_replace(" ","-",strtolower(trim($hotelname['hotel_name']))).'-'.$hotelname['hotel_id'].'.html');
		exit;
	}
	
	
	
	include("includes/db.conn.php");
	include("includes/conf.class.php");
	$bsiCore->clearExpiredBookings(); 
	$dateForm=$bsiCore->UserDateFormat();
	$abs_url=$bsiCore->abs_url(dirname(__FILE__));
	if($_SERVER['HTTP_REFERER']==$abs_url.'/' || $_SERVER['HTTP_REFERER']==$abs_url.'/index.php' )
	{
		if(isset($_SESSION['availabilityByRoomTypeFinal']))
		{
			unset($_SESSION['availabilityByRoomTypeFinal']);	
		}
	}
	include("includes/language.php");
	if(isset($_SESSION['language']))
	{ 
	
	$htmlCombo=$bsiCore->getabsbsilanguage($_SESSION['language'],$abs_url); 
	}else{ 
	$htmlCombo=$bsiCore->getabsbsilanguage(0,$abs_url); }
  
  if(isset($_REQUEST['hotel_id'])){
		
		$hotel_id =$_REQUEST['hotel_id'];
		$resultChk = mysql_query("select * from bsi_hotels where hotel_id='".$hotel_id."'");
		if(mysql_num_rows($resultChk)){
			$rowDetails = mysql_fetch_assoc($resultChk);
		}else{
			header("location:index.php?sss");
			exit;
		}	
	}else{
		header("location:index.php?ddd");
		exit;
	}

include("includes/hotel-details.class.php"); 
	$bsiHotelDetails = new bsiHotelDetails();
	$_SESSION['hotel_id'] = $hotel_id;
	$hotel_data   = $bsiHotelDetails->getHotelDeatils($hotel_id);
	$hotel_gallery= $bsiHotelDetails->getHotelgallery($hotel_id, $hotel_data['hotel_name'],$abs_url);
	$hotel_rating = $bsiHotelDetails->rating_review($hotel_id);
	//$hotel_rating = $bsiCore->rating_review($hotel_id);
	//$reviewArray=$bsiCore->rating_review($row['hotel_id']);
	$hotel_around = $bsiHotelDetails->getAroundHoteldetails($hotel_id); 
	$hotel_facility = $bsiHotelDetails->getHotelFacilities($hotel_id); 
	$guest_corner = $bsiHotelDetails->getguestCorner();
	//$count        = $bsiHotelDetails->getNoOfViewers();
	$dateArr      = $bsiHotelDetails->getRecentBookingInfo($hotel_id);
	$bookingTime  = date('l jS \of F Y h:i:s A', strtotime($dateArr['booking_time']));
	$clientArr    = $bsiCore->client($dateArr['client_id']);
	$countryname  = $bsiCore->getCountryName($clientArr['country']);
	if(isset($_SESSION['availabilityByRoomTypeFinal'])){ $availabilityByRoomTypeFinal = $_SESSION['availabilityByRoomTypeFinal']; }
	
	function rating_coloring($rating){		 
		if($rating <= 5){
			$color="progress-red";
		}elseif($rating > 5 && $rating <=7){
			$color="progress-yellow";
		}elseif($rating > 7){
			$color="progress-green";
		}
		return $color;
	}

?>

<!doctype html>
<html>
    <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- Latest compiled and minified CSS -->
    <link rel="stylesheet" href="<?php echo $abs_url; ?>/css/bootstrap.css">
    <link rel="stylesheet" href="<?php echo $abs_url; ?>/fonts/stylesheet.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="<?php echo $abs_url; ?>/css/datepicker.css">
    <link rel="stylesheet" href="<?php echo $abs_url; ?>/css/jquery.switch.css">
    <link rel="stylesheet" href="<?php echo $abs_url; ?>/css/page-theme.css">
    <link rel="stylesheet" href="<?php echo $abs_url; ?>/js/cssmenu/styles.css">
    <link rel="stylesheet" href="<?php echo $abs_url; ?>/js/tiksluscarousel-master/css/normalize.css" />
    <link rel="stylesheet" href="<?php echo $abs_url; ?>/js/tiksluscarousel-master/css/tiksluscarousel.css" />
    <link rel="stylesheet" href="<?php echo $abs_url; ?>/js/tiksluscarousel-master/css/github.css" />
    <link rel="stylesheet" href="<?php echo $abs_url; ?>/js/tiksluscarousel-master/css/animate.css" />
    <link rel="stylesheet" type="text/css" href="<?php echo $abs_url; ?>/css/mapStyle.css">
    <script src="<?php echo $abs_url; ?>/js/jquery.min.js"></script>
    <script type="text/javascript" src="<?php echo $abs_url; ?>/js/jquery.easing.1.3.js"></script>
    <script src="<?php echo $abs_url; ?>/src/jquery.anyslider.js"></script>
    <script src="<?php echo $abs_url; ?>/js/bootstrap.js"></script>
    <script src="http://code.jquery.com/ui/1.11.2/jquery-ui.js"></script>
    <script src="<?php echo $abs_url; ?>/js/moment-with-locales.js"></script>
    <script type="text/javascript" src="<?php echo $abs_url; ?>/js/bootstrap-datepicker.js"></script>
    <title><?php echo $bsiCore->config['conf_portal_name'].' : '.$hotel_data['hotel_name'].', '.$rowDetails['city_name'];?></title>
    <script>
	$(document).ready(function(){
		$('.email_to_friend').on('click', function(){
			if($('.stf_form').is(':visible')){
				$('.stf_form').slideUp();
			}else{
				$('.stf_form').slideDown();
			}
		});
		$('.closeetf').on('click', function(){
			$('.stf_form').slideUp();
		});
	});
</script>
    <script type="text/javascript" src="https://maps.googleapis.com/maps/api/js?libraries=places,geometry"></script>
    <script src="<?php echo $abs_url; ?>/js/dependences/markerclusterer.js"></script>
    <script src="<?php echo $abs_url; ?>/js/dependences/infobubble.js"></script>
    <script src="<?php echo $abs_url; ?>/js/shop-locatorsasd.js"></script>
    <script  type="text/javascript">
        $(document).ready(function () {
		function initialize() {	
        $(".hotel-map").ShopLocator({
            infoBubble:{
                visible: true,
                backgroundColor: 'transparent',
                arrowSize: 0,
                arrowPosition: 50,
                minHeight: 127,
                maxHeight: null,
                minWidth: 170,
                maxWidth: 250,
                hideCloseButton: false,
				 closeSrc: "<?php echo $abs_url; ?>/css/closeButton.svg"
            },
			map:{
				zoom: 10,
				maxZoom: "16",
                minZoom: "2"
			},
			markersIcon: "<?php echo $abs_url; ?>/images/map/marker_h.png",
            marker:{
                latlng: [<?php echo $hotel_data['latitude']; ?>, <?php echo $hotel_data['longitude']; ?>],
                title: "<?php echo $hotel_data['hotel_name']; ?>",
                street: "<?php echo $hotel_data['address_1']; ?>",
                zip: "<?php echo $hotel_data['post_code']; ?>",
                city: "<?php echo $hotel_data['city_name']; ?>"
            }
        });
		};
		
		$('a[href=#deltav4]').on('shown.bs.tab', function (e) {
		//$('a[href=#deltav3']).on('click', function() {
       initialize();
       
   
        });
 
   });
    </script>
    
      <script>
  $(document).ready(function(){
    $('.leftb').on('click', function(){
      var id = $(this).parent().attr('id');
      var min = $('#'+id).data('min');
      //var max = $('#'+id).data('max');
      var currentCount = parseInt($(this).next().text());
      if(currentCount > min){
        $(this).next().text(currentCount-1);
        $('#'+id).next().val(currentCount-1);
		priceupdate();
      }
    });
    $('.rightb').on('click', function(){
      var id = $(this).parent().attr('id');
      //var min = $('#'+id).data('min');
      var max = $('#'+id).data('max');
      var currentCount = parseInt($(this).prev().text());
      if(currentCount < max ){
        $(this).prev().text(currentCount+1);
        $('#'+id).next().val(currentCount+1);
		priceupdate();
      }
    });
	
	
  });
</script>


     <script  type="text/javascript">
	 function priceupdate() {	
	  $(document).ready(function () {
		 
		  var rtype_input = $("#roomtype_input").val();
		  var extras_input = $("#extras_input").val();
		  var rtype_arr = rtype_input.split("#"); 
		  var rtype_query = "";
		  for(key in rtype_arr){
			 rtype_arr2=rtype_arr[key].split("-");
			 rtype_val=$("#"+rtype_arr2[0]+"").val();
			 rtyep_id=rtype_arr2[0].split("_");
			 
			if(rtype_val != 0){
			  rtype_query +=  rtyep_id[1]+"#"+rtype_arr2[2]+"#"+rtype_val+"#"+rtype_arr2[1]+"@";
			}
			  
		  };
		  
		  
		  
		  var extras_query = "";
		  extras_arr=extras_input.split("#");
		 	for(key in extras_arr){
				extras_id=$('#'+extras_arr[key]+'').val();
				if($('#'+extras_arr[key]+'').prop('checked')){
					 extras_query += extras_id+"#"
				}
			};
			if(extras_query != ""){
			extras_query = extras_query.substring(0, extras_query.length - 1);
			}
			
			rtype_query = rtype_query.substring(0, rtype_query.length - 1);
			
		   var hotel_id=<?php echo  $hotel_id; ?>;
		   var querystr = 'actioncode=18&hotel_id='+hotel_id+'&extras_query='+extras_query+'&rtype_query='+rtype_query;
		   //alert(querystr);
		   if(rtype_query != ""){
			 
		   $.post("<?php echo $abs_url; ?>/ajax-processor.php", querystr, function(data){
				    $("#total_price").html(data.total_amt);
					$("#htmldeposite").html(data.deposite_html);
					$("#htmlblock").html(data.strhtml);
					$("#htmlcheckout").html(data.checkout_html);
			
			}, "json");  
			$("#booknowbtn777").show();
		   }else{
			   $("#total_price").html("0.00");
			   $("#htmldeposite").html("");
			   $("#htmlblock").html("");
			   $("#booknowbtn777").hide();
		   }
		
	 }); 
	  }; 
	  priceupdate();
	 </script>
     
    </head>
 
    <body>
<header>
      <?php include("header-r.php");	?>
    </header>
<div class="container-fluid">
      <div class="row container-background">
    <section class="container">
          <div class="row">
        <div class="container-fluid" id="modsearch">
             
              <div class="row">
            <div class="container-fluid">
                  <div class="row">
                
                <div class="col-md-9 col-md-push-3">
                      <h2 class="sett4">
                    <?=$hotel_data['hotel_name']?>
                    <?=$bsiCore->hotelStar($hotel_data['star_rating'])?>
                    
                    <?php if($hotel_rating['totalRatio']>0) { ?>
                   <!-- <span class="det-rate"><span><?php echo $hotel_rating['ratiograde'];?></span><?php echo $hotel_rating['totalRatio'];?></span> -->
                    <?php } ?></h2>
                      <p class="sertlul">
                    <?=$hotel_data['address_1']?>
                    <?=$hotel_data['address_2']?>
                    ,
                    <?=$hotel_data['city_name']?>
                    <?=$hotel_data['post_code']?>
                    <?=$hotel_data['cou_name']?>
                    <?php /*?><?php if(isset($_SESSION['availabilityByRoomTypeFinal'])) {?>
                    <a href="#top" class="searchbtn">
                       <?=BOOK_NOW?>
                        </a></p>
                      <?php } ?><?php */?>
                      <div class="clr"></div>
                      <div class="container-fluid">
                    <div class="row">
                          <div class="col-md-12 nav-tab-div" style="padding:0">
                        <ul class="nav nav-tabs detailstab" role="tablist" id="myTab">
                              <li role="presentation" class="active"> <a href="#deltav1" role="tab" data-toggle="tab" class="tabtxt">
                                <?=HOTEL_OVERVIEW?>
                                <span class="hidden-lg"><br />
                              &nbsp;</span> </a> </li>
                              <li role="presentation"> <a href="#deltav2" role="tab" data-toggle="tab" class="tabtxt"> <?php echo HOTEL_FACILITIES; ?> <span class="hidden-lg"><br />
                              &nbsp;</span> </a> </li>
                              <li role="presentation"> <a href="#deltav3" role="tab" data-toggle="tab" class="tabtxt">
                                <?=GUEST_REVIEW?>
                                <span class="hidden-lg"><br />
                              &nbsp;</span> </a> </li>
                              <li role="presentation"> <a href="#deltav4" role="tab" data-toggle="tab" class="tabtxt">
                                <?=SHOW_ON_MAP?>
                                <span class="hidden-lg"><br />
                              &nbsp;</span> </a>
                        </ul>
                      </div>
                        </div>
                  </div>
                      <div class="container-fluid">
                    <div class="row mrb20">
                          <div class="col-md-12 detbox">
                        <div class="tab-content">
                              <div role="tabpanel" class="tab-pane active" id="deltav1">
                            <div class="container-fluid">
                                  <div class="row">
                                <div class="col-md-12 col-sm-12"> <br />
                                      <div id="fruits">
                                    <ul>
                                          <?=$hotel_gallery?>
                                        </ul>
                                  </div>
                                      <p class="settxt"><?php echo $hotel_data['desc_long']; ?> 
                                   
                                  </p>
                                      <div class="clr"></div>
                                      <div class="container-fluid">
                                   <!-- ********************** new design start ******************-->
                                    <form action="<?php echo $abs_url; ?>/bookingProcess.php" method="post" name="booking">
                                   <?php
								   $roomtype_input_id="";
								   $extras_input_id="";
								   //print_r($availabilityByRoomTypeFinal);
								   if(!empty($availabilityByRoomTypeFinal)){ ?>
                                    <div class="row">
                                          <div class="col-md-8 col-sm-8">
                                        <div class="row padmarzero" id="avl">
                                              <h2 class="bs-sett3"><?php echo AVAILABILITY;?></h2>
                                            </div>
                                        <div class="row padmarzero hed1 hidden-xs">
                                              <div class="col-md-6 col-sm-6"><?php echo NEW_ROOM_TYPE;?> </div>
                                              <div class="col-md-3 col-sm-3"><?php echo NEW_QUANTITY;?></div>
                                              <div class="col-md-3 col-sm-3"><?php echo NEW_PRICE_ROOM;?></div>
                                            </div> 
                                            <!--******************* row start ************************-->
                                      <?php
									   $recommended = array();
									   if(isset($_SESSION['recommendedRoomtype'])){
									   $recommended = $_SESSION['recommendedRoomtype']; 
									   //print_r($recommended);
										$roomtypeid7=  $recommended[$hotel_id]['recommendedRoomtypeid'];
										 $capacityid7=  $recommended[$hotel_id]['recommendedcapacityid'];
									   }else{
										   $roomtypeid7= 0;
										 $capacityid7= 0;
										   }
									  foreach($availabilityByRoomTypeFinal[$hotel_id] as $i => $availabilityRow){						
										$roomTypeRes=$bsiHotelDetails->roomTypeDetails($i);
										$rowRoomType=mysql_fetch_assoc($roomTypeRes);										
										$totalRow = count($availabilityRow);
										$html="";
										//print_r($availabilityRow); 
										foreach($availabilityRow as $k => $val){
											
											if($val['roomTypeId']==$roomtypeid7 and $val['capcityid']==$capacityid7){
												
												$select_room=1;
												$recommendedPrice_total=$recommended[$hotel_id]['recommendedPricedetilschildprice'];
											}else{
												
												$select_room=0;
												$recommendedPrice_total=0.00;
											}
											
											$child_html = '';
											if($val['child_price']>0){
												$child_html = '<span class="avlset" title="Child occupancy"> <span class="avlset-icon"> <i class="fa fa-child"></i> </span> x '.$_SESSION['sv_childcount'].' </span> </span>';
											}
											
											$offer_price=$bsiCore->calculate_offer($_SESSION['sv_mcheckindate'], $_SESSION['sv_mcheckoutdate'], $_SESSION['sv_nightcount'], $val['totalPrice'] , $hotel_id);
											if($offer_price['status']){
												$price_html='<span style="color:#FB1A1E">'.$bsiCore->get_currency_symbol($_SESSION['sv_currency']).$bsiCore->getExchangemoney($offer_price['discount_price'],$_SESSION['sv_currency']).'</span>   <span style="text-decoration: line-through;">'.$bsiCore->get_currency_symbol($_SESSION['sv_currency']).$bsiCore->getExchangemoney($val['totalPrice'],$_SESSION['sv_currency']).'</span>';
												$actual_price=$offer_price['discount_price'];
											}else{
												$price_html=$bsiCore->get_currency_symbol($_SESSION['sv_currency']).$bsiCore->getExchangemoney($val['totalPrice'],$_SESSION['sv_currency']);
												$actual_price=$val['totalPrice'];
											}
									  ?>      
                                        <div class="row rtset">
                                             <div class="visible-xs col-xs-6"> <span class="rcp1"><?php echo NEW_ROOM_TYPE;?></span> </div>
                                              <div class="col-md-6 col-sm-6 col-xs-6">
                                            <div class="thumb_cart hidden-xs"> <a data-target="#modal_single_room-<?php echo $val['roomTypeId'];?>" data-toggle="modal" href="#"> <img alt="" src="<?php echo $abs_url; ?>/gallery/roomTypeImage/<?php echo $rowRoomType['rtype_image']; ?>"> </a> </div>
                                            <span class="item_cart"> <a data-target="#modal_single_room-<?php echo $val['roomTypeId'];?>" data-toggle="modal" href="#"><?php echo $rowRoomType['type_name']; ?> <span class="avlset" title="Adult occupancy"> 
                                            <i class="fa fa-male"></i> 
                                            x <?php echo $val['capcity'];?> 
                                            </span></a>
                                             <?php echo  $child_html ?> </div>
                                              <div class="clearfix visible-xs"></div>
                                              <div class="visible-xs  col-xs-6"> <span class="rcp1"><?php echo NEW_QUANTITY;?></span> </div>
                                              <div class="col-md-3 col-sm-3 col-xs-6">
                                            <div id="single-room1-<?php echo $val['roomTypeId']; ?>" class="inpselset rcmar20" data-max="<?php echo count(explode('#',$val['totalRoomAvailableId'])); ?>" data-min="0">
                                                  <div class="leftb" > - </div>
                                                  <div class="midb"><?php echo $select_room; ?></div>
                                                  <div class="rightb" > + </div> 
                                                </div> 
                                            <input id="room_<?php echo  $val['roomTypeId'].'_'.$k; ?>" name="room_<?php echo  $val['roomTypeId'].'_'.$k; ?>" type="hidden" value="<?php echo $select_room; ?>">
                                           <?php $roomtype_input_id.="room_".$val['roomTypeId'].'_'.$k.'-'.$actual_price."-".$val['capcityid']."#";  ?>
                                          
                                          </div>
                                              <div class="clearfix visible-xs"></div>
                                              <div class="visible-xs col-xs-6"> <span class="rcp1"><?php echo NEW_PRICE_ROOM;?></span> </div>
                                              <div class="col-md-3 col-sm-3 col-xs-6"> <span class="rcp"><?php echo $price_html; ?></span> </div>
                                            </div>
                                            
                                             <!--******************** modal start ****************-->
                                            <div class="modal fade" id="modal_single_room-<?php echo $val['roomTypeId'];?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
      <div class="modal-dialog">
    <div class="modal-content">
          <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel"><?php echo $rowRoomType['type_name']; ?></h4>
      </div>
          <div class="modal-body">
        <div class="container-fluid">
              <div class="row">
            <div class="col-md-12"><?php echo $rowRoomType['services']; ?> <br />
                 
                </div>
              
            <div class="clearfix"></div>
            <div class="col-md-12 col-sm-12"> <br/>
                  <img style="width: 100%" src="<?php echo $abs_url; ?>/gallery/roomTypeImage/<?php echo $rowRoomType['rtype_image']; ?>"/> <br/>
                </div>
            
          </div>
            </div>
      </div>
        </div>
  </div>
    </div>
   <!--******************** modal end ****************-->
                                         <?php
										}
									  }
									  ?>
                                       <?php 
									   $gethotelextras=$bsiHotelDetails->gethotelextras($hotel_id);
									  // print_r($gethotelextras);
									   if($gethotelextras != 'false'){ 
									   ?>
                                       <!--******************** extras start ****************-->
                                        <br/>
                                        <div class="row padmarzero hed1 hidden-xs">
                                              <div class="col-md-12"><?php echo ADD_OPTIONS_SERVICES;?></div>
                                            </div>
                                          <?php  
										  $y7=1;
										 while($rowext= mysql_fetch_assoc($gethotelextras)){
										
										  ?>
                                        <div class="row rtset">
                                              <div class="col-md-6 col-sm-6 col-xs-4"> <span class="rcp2"><?php echo $rowext['service_name'];?></span> </div>
                                              <div class="col-md-2 col-sm-2 col-xs-2"> <span class="rcp2"><strong>+<?php echo  $bsiCore->get_currency_symbol($_SESSION['sv_currency']).$bsiCore->getExchangemoney($rowext['service_price'],$_SESSION['sv_currency']);?></strong></span> </div>
                                              <div class="col-md-4 col-sm-4 col-xs-6">
                                            <label class="switch-light switch-ios pull-right">
                                                  <input  name="extras[<?php echo $rowext['id']; ?>]" id="extras_<?php echo $y7;?>" value="<?php echo $rowext['id'];?>" type="checkbox" onClick="javascript:priceupdate();">
                                                  <span> <span><?php echo CNO;?></span> <span><?php echo CYES;?></span> </span> <a></a> </label>
                                          </div>
                                            </div>
                                            <?php 
											 $extras_input_id.="extras_".$y7."#";
											$y7++; 
											} ?>
                                        <!--******************** extras end ****************-->
                                       <?php   } ?>
                                      </div>   
                                      
                                      
                                          <div class="col-md-4 col-sm-4 smalmar">
                                        <h2 class="bs-sett3"><?php echo BOOKING_SUMMARY;?></h2>
                                        <div class="container-fluid summeryset"> <br/>
                                              <div class="row">
                                            <div class="col-md-7 col-sm-7 col-xs-7">
                                                  <p class="pstl"><?php echo CHECK_IN;?></p>
                                                </div>
                                            <div class="col-md-5 col-sm-5 col-xs-5">
                                                  <p class="pst3"><?php echo $_SESSION['sv_checkindate']; ?></p>
                                                </div>
                                          </div>
                                          
                                           <!--<span id="htmlcheckout">
                                              
                                              </span> 
                                            <div class="row">
                                            <div class="col-md-7 col-sm-7 col-xs-7">
                                                  <p class="pstl"><?php echo CHECK_OUT;?></p>
                                                </div>
                                            <div class="col-md-5 col-sm-5 col-xs-5">
                                                  <p class="pst3"><?php echo $_SESSION['sv_checkoutdate']; ?></p>
                                                </div>
                                          </div>
                                              <div class="row">
                                            <div class="col-md-7 col-sm-7 col-xs-7">
                                                  <p class="pstl"><?php echo NIGHTS;?></p>
                                                </div>
                                            <div class="col-md-5 col-sm-5 col-xs-5">
                                                  <p class="pst3"><?php echo $_SESSION['sv_nightcount']; ?></p>
                                                </div>
                                          </div>  -->
                                              <span id="htmlblock">
                                              
                                              </span>
                                              
                                             
                                             
                                              <div class="row">
                                            <div class="col-md-6 col-sm-6 col-xs-6">
                                                  <p class="pstlb">Total Price</p>
                                                </div>
                                            <div class="col-md-6 col-sm-6 col-xs-6">
                                                  <p class="pst3b" id="total_price"></p>
                                                </div>
                                          </div>
                                          
                                           <span id="htmldeposite">
                                              
                                              </span>
                                              
                                          <!--<div class="row">
                                            <div class="col-md-7 col-sm-7 col-xs-7">
                                                  <p class="pstlb">Deposite 20% </p>
                                                </div>
                                            <div class="col-md-5 col-sm-5 col-xs-5">
                                                  <p class="pst3b" id="deposite_price"></p>
                                                </div>
                                          </div>
                                          
                                          <div class="row">
                                            <div class="col-md-7 col-sm-7 col-xs-7">
                                                  <p class="pstlb">Downpayment Due</p>
                                                </div>
                                            <div class="col-md-5 col-sm-5 col-xs-5">
                                                  <p class="pst3b" id="due_price"></p>
                                                </div>
                                          </div>-->
                                          
                                              <div class="row">
                                            <div class="col-xs-12" id="booknowbtn777"><button class="searchbtn7">
                                                  <?=BOOK_NOW?>
                                                  </button>  <!--<a href="#modsrch" class="searchbtn8"><?php echo MODIFY_YOUR_SEARCH;?></a>--> </div>
                                          </div>
                                            </div>
                                      </div>
                                        </div>
                                        <!-- ********************** new design end ******************-->
                                        <?php } ?>
                                        <input type="hidden" id="roomtype_input" value="<?php echo substr($roomtype_input_id, 0, -1); ?>" >
                                        <input type="hidden" id="extras_input" value="<?php echo substr($extras_input_id, 0, -1); ?>" >
                                        
                                    <br/>
                                   
                                    <div class="row">
                                          <?php //if(isset($_SESSION['availabilityByRoomTypeFinal'])) {}?>
                                        <div class="row">
                                              <div class="col-md-12">
                                            <table class="table table-condensed  nobdr">
                                                  <tr class="bggr">
                                                <th colspan="2"><?php echo HOTEL_POLICIES;?>
                                                    </th>
                                              </tr>
                                                 <!-- <tr>
                                                <td><strong>
                                                  <?php echo CHECK_IN;?>
                                                  </strong></td>
                                                <td>from
                                                      <?=$hotel_data['checking_hour']?>
                                                      hours</td>
                                              </tr>
                                                  <tr>
                                                <td><strong>
                                                  <?php echo CHECK_OUT;?>
                                                  </strong></td>
                                                <td>Until
                                                      <?=$hotel_data['checkout_hour']?>
                                                      hours</td>
                                              </tr>
                                                  <tr>
                                                <td><strong>
                                                  <?php echo PETS;?>
                                                  </strong></td>
                                                <td><?=$hotel_data['pets_status']?></td>
                                              </tr>-->
                                              
                                               <tr>
                                                <td><?=$hotel_data['hotel_policies']?></td>
                                              </tr>
                                                </table>
                                          </div>
                                            </div>
                                        <div class="row">
                                              <div class="col-md-12">
                                            <table class="table table-condensed graytable">
                                                  <tr class="bggr">
                                                <th><?=IMPORTANT_INFORMATION?></th>
                                              </tr>
                                                  <tr>
                                                <td><?=$hotel_data['terms_n_cond']?></td>
                                              </tr>
                                                </table>
                                          </div>
                                            </div>
                                        <div class="clr"></div>
                                      </div>
                                       <input type="hidden" name="roomtype" id="roomtype" value="2" />
                                        </form>
                                  </div>
                                    </div>
                              </div>
                                </div>
                          </div>
                              <div role="tabpane2" class="tab-pane" id="deltav2">
                            <?=$hotel_facility?>
                          </div>
                              <div role="tabpane3" class="tab-pane" id="deltav3">
                            <div class="reviewdiv">
                                  <div class="container-fluid">
                                <div class="row">
                                      <div class="col-md-4">
                                    <p class="speech">
                                          <?=TOTAL_SCORE?>
                                          <span>
                                      <?=number_format($hotel_rating['totalRatio'],2)?>
                                      </span></p>
                                    <br />
                                  </div>
                                      <div class="col-md-8">
                                    <div class="container-fluid">
                                          <div class="row">
                                        <div class="col-md-4 col-sm-4 txt-aln">
                                              <?=CLEAN?>
                                            </div>
                                        <div class="col-md-8 col-sm-8">
                                              <div class="progress">
                                            <div class="progress-bar progress-bar-success" role="progressbar" aria-valuenow="40" aria-valuemin="0" aria-valuemax="100" style="width: <?=number_format(($hotel_rating['rating_for_clean']*10),0)?>%"> 
                                                  <!--<span class="sr-only">40% Complete (success)</span>--> 
                                                </div>
                                            <div class="per">
                                                  <?=$hotel_rating['rating_for_clean']?>
                                                </div>
                                          </div>
                                            </div>
                                      </div>
                                          <div class="row">
                                        <div class="col-md-4 col-sm-4 txt-aln">
                                              <?=COMFORT?>
                                            </div>
                                        <div class="col-md-8 col-sm-8">
                                              <div class="progress">
                                            <div class="progress-bar progress-bar-success" role="progressbar" aria-valuenow="80" aria-valuemin="0" aria-valuemax="100" style="width: <?=number_format(($hotel_rating['rating_for_comfort']*10),0)?>%"> 
                                                  <!--<span class="sr-only">40% Complete (success)</span>--> 
                                                </div>
                                            <div class="per">
                                                  <?=$hotel_rating['rating_for_comfort']?>
                                                </div>
                                          </div>
                                            </div>
                                      </div>
                                          <div class="row">
                                        <div class="col-md-4 col-sm-4 txt-aln">
                                              <?=LOCATION?>
                                            </div>
                                        <div class="col-md-8 col-sm-8">
                                              <div class="progress">
                                            <div class="progress-bar progress-bar-success" role="progressbar" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100" style="width: <?=number_format(($hotel_rating['rating_for_location']*10),0)?>%"> 
                                                  <!--<span class="sr-only">40% Complete (success)</span>--> 
                                                </div>
                                            <div class="per">
                                                  <?=$hotel_rating['rating_for_location']?>
                                                </div>
                                          </div>
                                            </div>
                                      </div>
                                          <div class="row">
                                        <div class="col-md-4 col-sm-4 txt-aln">
                                              <?=SERVICES?>
                                            </div>
                                        <div class="col-md-8 col-sm-8">
                                              <div class="progress">
                                            <div class="progress-bar progress-bar-success" role="progressbar" aria-valuenow="20" aria-valuemin="0" aria-valuemax="100" style="width: <?=number_format(($hotel_rating['rating_for_services']*10),0)?>%"> 
                                                  <!-- <span class="sr-only">40% Complete (success)</span>--> 
                                                </div>
                                            <div class="per">
                                                  <?=$hotel_rating['rating_for_services']?>
                                                </div>
                                          </div>
                                            </div>
                                      </div>
                                          <div class="row">
                                        <div class="col-md-4 col-sm-4 txt-aln">
                                              <?=STAFF?>
                                            </div>
                                        <div class="col-md-8 col-sm-8">
                                              <div class="progress">
                                            <div class="progress-bar progress-bar-success" role="progressbar" aria-valuenow="90" aria-valuemin="0" aria-valuemax="100" style="width: <?=number_format(($hotel_rating['rating_for_staff']*10),0)?>%"> 
                                                  <!--<span class="sr-only">40% Complete (success)</span>--> 
                                                </div>
                                            <div class="per">
                                                  <?=$hotel_rating['rating_for_staff']?>
                                                </div>
                                          </div>
                                            </div>
                                      </div>
                                          <div class="row">
                                        <div class="col-md-4 col-sm-4 txt-aln">
                                              <?=VALUE_FOR_MONEY?>
                                            </div>
                                        <div class="col-md-8 col-sm-8 ">
                                              <div class="progress">
                                            <div class="progress-bar progress-bar-success" role="progressbar" aria-valuenow="30" aria-valuemin="0" aria-valuemax="100" style="width: <?=number_format(($hotel_rating['rating_for_money']*10),0)?>%"> <span class="sr-only">30% Complete (success)</span> </div>
                                            <div class="per">
                                                  <?=$hotel_rating['rating_for_money']?>
                                                </div>
                                          </div>
                                            </div>
                                      </div>
                                        </div>
                                  </div>
                                    </div>
                                <div class="row">
                                      <div class="col-md-12">
                                    <h4 class="headding2 bdrb">
                                          <?=INDIVIDUAL_GUEST_REVIEWS?>
                                          (
                                          <?=$hotel_rating['numRows']?>
                                          )</h4>
                                  </div>
                                    </div>
                                <?=$hotel_rating['ratingList']?>
                              </div>
                                </div>
                          </div>
                              <div role="tabpane4" class="tab-pane" id="deltav4">
                            <div class="hotel-map"></div>
                          </div>
                            </div>
                      </div>
                        </div>
                  </div>
                    <?php
				if(isset($_SESSION['sv_currency']))
				{$currency=$_SESSION['sv_currency'];}
				else
				{$currency=$bsiCore->currency_code();}	
				?>
              <?php if(isset($_SESSION['availabilityByRoomTypeFinal'])) {
					$checkin=$_SESSION['sv_checkindate'];
					$checkout=$_SESSION['sv_checkoutdate'];
				}else{
					$checkin ="";
					$checkout= "";
				}
				 $searchboxdisp='';
				//print_r($_SESSION['availabilityByRoomTypeFinal']);
			     if(isset($_SESSION['availabilityByRoomTypeFinal'])) { $searchboxdisp='style="display:none;" '; }
				?>
              <form name="booking" method="post" action="<?php echo str_replace(" ","-",strtolower(trim($hotel_data['hotel_name']))).'-'.$hotel_id.'.html'; ?>">
            <input type="hidden" name="hotel_id" id="hotel_id" value="<?php echo $hotel_id; ?>" />
            <input type="hidden" name="currency" id="currency" value="<?php echo $currency; ?>" />
            <div class="row"  <?php echo  $searchboxdisp; ?>  id="seacrh_blck">
            
                  <div class="col-md-12 ">
                <div class="searchbg">
                      <div class="container-fluid padmarzero"  >
                    <div class="row ">
                          <input type="hidden"  name="destination" value="<?php echo $rowDetails['city_name']; ?>">
                          <div class="col-md-4">
                        <div class="container-fluid padmarzerocondition">
                              <div class="row">
                            <div class="col-md-4 padmarzero"><span class="sertxt">
                              <?=CHECK_IN?>
                              </span></div>
                            <div class='input-group date'>
                                  <!--<input type='text' id="dpd1" class="form-control roundcornerleft" data-date-format="<?php echo $bsiCore->bt_date_format(); ?>" name="check_in" value="<?=$checkin?>"/>-->
                                  <input type='text'  value="<?php echo date($dateForm, strtotime(' +0 day'));?>" readonly     class="form-control roundcornerleft" data-date-format="<?php echo $bsiCore->bt_date_format(); ?>" name="check_in"/>
                                  <span class="input-group-addon roundcornerright"> <span class="glyphicon glyphicon-calendar"></span> </span> </div>
                          </div>
                            </div>
                      </div>
                       
                      
                      <input type='hidden'  value="<?php echo date($dateForm, strtotime(' +1 day'));?>" readonly    class="form-control roundcornerleft" data-date-format="<?php echo $bsiCore->bt_date_format(); ?>"  name="check_out"/>
                      
                      
                          <input type="hidden" name="rooms" value="1" id="room"/>
                          <div class="col-md-4">
                        <div class="container-fluid padmarzerocondition">
                              <div class="row">
                            <div class="col-md-4 padmarzero"><span class="sertxt">
                              <?=ADULT?>
                              </span></div>
                            <div class="col-md-8 padmarzero">
                                  <div class="inpselset" id="adult" data-min="1" data-max="20">
                                <div class="leftb"> - </div>
                                <div class="midb">2</div>
                                <div class="rightb"> + </div>
                              </div>
                                  <input type="hidden" value="2" name="adults[]"/>
                                </div>
                          </div>
                            </div>
                      </div>
                        
                          <div class="col-md-4 btnserdiv">
                        <input type="submit" class="form-control searchbtn" value="<?=SEARCH?>" id="search_submit" >
                      </div>
                        </div>
                  </div>
                    </div>
                <br />
              </div>
                </div>
           
          </form>
                    </div>
                    <div class="col-md-3 col-md-pull-9">
                      <div class="container-fluid">
                   
               
                   
                  
                      <div class="row">
                      
                      
                      
                      
                      
                          <div class="col-md-12 sernbox" style="border:none !important;" > <a  href="<?php echo $abs_url; ?>/search.php" class="searchbtn" style="width:100% !important;"><?php echo BACK_TO_SEARCH_RESULT;?></a> </div>
                        </div>
                  </div>
                      <br/>
                    </div>
                    
                   
                    
              </div>
                </div>
          </div>
            </div>
      </div>
      
          
        </section>
  </div>
    </div>
<?php include("footer-r.php");?>

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
            <div class="col-md-12 derror" id="error"> </div>
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
                <div class="col-sm-offset-2 col-sm-10"> </div>
              </div>
                  <div class="form-group">
                <div class="col-sm-offset-2 col-sm-10"> <br />
                      <input type="submit" class="form-control searchbtn logbtn" value="<?php echo NEW_LOGIN;?>" id="submit_login" name="submit_login" >
                      <a href="javascript:void(0)" data-toggle="modal" data-target="#forpass" data-dismiss="modal" class="forpass"><?php echo NEW_FORGET_PASSWORD?></a> </div>
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
            <div class="col-md-12 derror" id="errorforget"> </div>
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
                <div class="col-sm-offset-2 col-sm-10"> <br />
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
            <div class="col-md-12 derror" id="agenterror"> </div>
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
                <div class="col-sm-offset-2 col-sm-10"> </div>
              </div>
                  <div class="form-group">
                <div class="col-sm-offset-2 col-sm-10"> <br />
                      <input type="submit" class="form-control searchbtn logbtn" value="<?php echo NEW_LOGIN;?>" id="submit_agentlogin" name="submit_agentlogin" >
                      <a href="javascript:void(0)" data-toggle="modal" data-target="#agentforpass" data-dismiss="modal" class="forpass"><?php echo NEW_FORGET_PASSWORD?></a> </div>
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
            <div class="col-md-12 derror" id="agenterrorforget"> </div>
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
                <div class="col-sm-offset-2 col-sm-10"> <br />
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

<!-- Single Room -->
<!--<div class="modal fade" id="modal_single_room" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
      <div class="modal-dialog">
    <div class="modal-content">
          <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">Single Room</h4>
      </div>
          <div class="modal-body">
        <div class="container-fluid">
              <div class="row">
            <div class="col-md-12"> Lorem ipsum dolor sit amet, at omnes deseruisse pri. Quo aeterno legimus insolens ad. Sit cu detraxit constituam, an mel iudico constituto efficiendi. Mea liber ridens inermis ei, mei legendos vulputate an, labitur tibique te qui. <br />
                  <br />
                </div>
            <div class="col-md-6"> <i class="fa fa-wifi"></i> Free wifi <br/>
                  <i class="fa fa-television"></i> Plasma Tv <br/>
                  <i class="fa fa-medkit"></i> Safety box <br/>
                </div>
            <div class="col-md-6"> <i class="fa fa-check"></i> Lorem ipsum dolor sit amet <br/>
                  <i class="fa fa-check"></i> Lorem ipsum dolor sit amet <br/>
                  <i class="fa fa-check"></i> Lorem ipsum dolor sit amet <br/>
                </div>
            <div class="clearfix"></div>
            <div class="col-md-4 col-sm-4"> <br/>
                  <img style="width: 100%" src="http://178.62.5.12/bhbsp/gallery/hotelImage/1436696761_1313_14031016580018626956.jpg"/> <br/>
                </div>
            <div class="col-md-4 col-sm-4"> <br/>
                  <img style="width: 100%" src="http://178.62.5.12/bhbsp/gallery/hotelImage/1436696761_1313_14031016580018626956.jpg"/> <br/>
                </div>
            <div class="col-md-4 col-sm-4"> <br/>
                  <img style="width: 100%" src="http://178.62.5.12/bhbsp/gallery/hotelImage/1436696761_1313_14031016580018626956.jpg"/> <br/>
                </div>
          </div>
            </div>
      </div>
        </div>
  </div>
    </div>-->
<script>
  $(function () {
    $('#myTab a:first').tab('show')
  });
</script> 

<!--  ************************************************************ For logo ***********************************************************************************--> 

<script>
(function($) {

  $.fn.menumaker = function(options) {
      
      var cssmenu = $(this), settings = $.extend({
        title: "Menu",
        format: "dropdown",
        sticky: false
      }, options);

      return this.each(function() {
        cssmenu.prepend('<div id="menu-button"><a href="/"><img src="<?php echo $abs_url; ?>/gallery/portal/<?=$bsiCore->config['conf_portal_logo']?>" alt=""/></a></div>');
        $(this).find("#menu-button").on('click', function(){
          $(this).toggleClass('menu-opened');
          var mainmenu = $(this).next('ul');
          if (mainmenu.hasClass('open')) { 
            mainmenu.hide().removeClass('open');
          }
          else {
            mainmenu.show().addClass('open');
            if (settings.format === "dropdown") {
              mainmenu.find('ul').show();
            }
          }
        });

        cssmenu.find('li ul').parent().addClass('has-sub');

        multiTg = function() {
          cssmenu.find(".has-sub").prepend('<span class="submenu-button"></span>');
          cssmenu.find('.submenu-button').on('click', function() {
            $(this).toggleClass('submenu-opened');
            if ($(this).siblings('ul').hasClass('open')) {
              $(this).siblings('ul').removeClass('open').hide();
            }
            else {
              $(this).siblings('ul').addClass('open').show();
            }
          });
        };

        if (settings.format === 'multitoggle') multiTg();
        else cssmenu.addClass('dropdown');

        if (settings.sticky === true) cssmenu.css('position', 'fixed');

        resizeFix = function() {
          if ($( window ).width() > 768) {
            cssmenu.find('ul').show();
          }
          if ($(window).width() <= 768) {
            cssmenu.find('ul').hide().removeClass('open');
			
          }
        };
        resizeFix();
        return $(window).on('resize', resizeFix);

      });
  };
})(jQuery);

(function($){
$(document).ready(function(){

$(document).ready(function() {
  $("#cssmenu").menumaker({
    title: "Menu",
    format: "multitoggle"
  });

  $("#cssmenu").prepend("<div id='menu-line'></div>");

var foundActive = false, activeElement, linePosition = 0, menuLine = $("#cssmenu #menu-line"), lineWidth, defaultPosition, defaultWidth;

$("#cssmenu > ul > li").each(function() {
  if ($(this).hasClass('active')) {
    activeElement = $(this);
    foundActive = true;
  }
});

if (foundActive === false) {
  activeElement = $("#cssmenu > ul > li").first();
} 

defaultWidth = lineWidth = activeElement.width();

defaultPosition = linePosition = activeElement.position().left;

menuLine.css("width", lineWidth);
menuLine.css("left", linePosition);

$("#cssmenu > ul > li").hover(function() {
  activeElement = $(this);
  lineWidth = activeElement.width();
  linePosition = activeElement.position().left;
  menuLine.css("width", lineWidth);
  menuLine.css("left", linePosition);
}, 
function() {
  menuLine.css("left", defaultPosition);
  menuLine.css("width", defaultWidth);
});

});


});
})(jQuery);

</script> 
<script type="text/javascript" src="<?php echo $abs_url; ?>/js/tiksluscarousel-master/js/tiksluscarousel.js"></script> 
<script type="text/javascript" src="<?php echo $abs_url; ?>/js/tiksluscarousel-master/js/rainbow.min.js"></script> 
<script language="javascript">
	$(document).ready(function(){
		$("#fruits").tiksluscarousel({height:480,nav:'thumbnails',current:1});
	});
</script> 
<script type="text/javascript">
function bookRoom(){	
	window.location="<?php echo $abs_url; ?>/bookingProcess.php?roomtype=1";
}
</script> 
<script>

  $("a[href='#top']").click(function() {
    
    var p = $('#avl').offset();
    $("html, body").animate({ scrollTop: p.top }, "slow");
	 //$('html, body').scrollTop( $(document).height() );
     return false;
  });
  
  $("a[href='#modsrch']").click(function() {
    $("#seacrh_blck").show();
    var p = $('#modsearch').offset();
    $("html, body").animate({ scrollTop: p.top }, "slow");
	 //$('html, body').scrollTop( $(document).height() );
     return false;
  });
</script> 
<script type="text/javascript" src="<?php echo $abs_url; ?>/js/bootstrap-datepicker.js"></script> 
<script>
		$(function(){
// disabling dates
		var nowTemp = new Date();
		var now = new Date(nowTemp.getFullYear(), nowTemp.getMonth(), nowTemp.getDate(), 0, 0, 0, 0);
		
		var checkin = $('#dpd1').datepicker({
		onRender: function(date) {
		return date.valueOf() < now.valueOf() ? 'disabled' : '';
		}
		}).on('changeDate', function(ev) {
		if (ev.date.valueOf() > checkout.date.valueOf()) {
		var newDate = new Date(ev.date)
		newDate.setDate(newDate.getDate() + <?php echo  $bsiCore->config['conf_min_night_booking']; ?>);
		checkout.setValue(newDate);
		//alert(newDate);
		//alert(checkout.setValue(newDate));
		}
		checkin.hide();
		$('#dpd2')[0].focus();
		}).data('datepicker');
		var checkout = $('#dpd2').datepicker({
		onRender: function(date) {
		var checkoutdt= parseInt(checkin.date.valueOf())+(60*60*24*1000*<?php echo  ($bsiCore->config['conf_min_night_booking']-1); ?>);
		
		return date.valueOf() <= checkoutdt ? 'disabled' : '';
		
		}
		}).on('changeDate', function(ev) {
		checkout.hide();
		}).data('datepicker');
		
		});
	</script> 
<script type="text/javascript">
	$(document).ready(function() {
	
	$("#submit_login").click(function(){
	var querystr = 'actioncode=12&email='+$('#inputEmail3').val()+'&password='+$('#inputPassword3').val();
	//alert(querystr) 
	$.post("<?php echo $abs_url;?>/ajax-processor.php", querystr, function(data){						 
				if(data.errorcode == 0){
					//$('#error').html('<p> Succesfully Login! Please wait redirecting...</p>');
					$(location).attr('href', '<?php echo $abs_url;?>/user_managebooking.php?submenuheader=0');
				}else{
				$('#error').html('<?php echo NEW_EMAIL_NOT_MATCH;?>');
				//alert('Emailid or Password does not matched.');	
				}
			}, "json");
	});
	
	
	$("#submit_forget").click(function(){
	var querystr = 'actioncode=13&email='+$('#inputEmailforget').val();
	$.post("<?php echo $abs_url;?>/ajax-processor.php", querystr, function(data){						 
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
	//alert(querystr);die;
	$.post("<?php echo $abs_url;?>/ajax-processor.php", querystr, function(data){						 
				if(data.errorcode == 0){
					//$('#error').html('<p> Succesfully Login! Please wait redirecting...</p>');
					$(location).attr('href', '<?php echo $abs_url;?>/agent_managebooking.php?submenuheader=0');
				}else{
				$('#agenterror').html('<?php echo NEW_EMAIL_NOT_MATCH;?>.');
				//alert('Emailid or Password does not matched.');	
				}
			}, "json");
	});
	
	
	$("#submit_agentforget").click(function(){
	var querystr = 'actioncode=16&email='+$('#inputagentEmailforget').val();
	
	$.post("<?php echo $abs_url;?>/ajax-processor.php", querystr, function(data){						 
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
<script type="text/javascript">

	$(document).ready(function() {

	$("#search_submit").click(function(){

	if($("#dpd2").val()=="" ){

	alert("<?=CHECK_IN_ALERT?>");

							 return false;

							}
							else if($("#dpd2").val()=="" ){

							alert("<?=CHECK_OUT_ALERT?> ");

							 return false;

							}

						else{

								return true;

								}

	});

	

	});

	</script> 
<script>
$(function() {
	
	//Filter
	$('.filter-txt').on('click', function(){
		
		if($(this).hasClass('open-down')){
			$(this).removeClass('open-down');
			$(this).next().slideUp();
			$(this).find('.fl-plus').html('<i class="fa fa-plus-square-o"></i>');
		}else{
			$(this).addClass('open-down');
			$(this).next().slideDown();
			$(this).find('.fl-plus').html('<i class="fa fa-minus-square-o"></i>');
		}
				
	});
	
	
});
</script>
</body> 
</html>