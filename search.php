<?php
session_start();
//print_r($_POST);
header("Cache-Control: private, must-revalidate, max-age=0");
header("Pragma: no-cache");
header("Expires: Sat, 26 Jul 1997 05:00:00 GMT");
include("includes/db.conn.php");
include("includes/conf.class.php");
include("includes/language.php");
	if(isset($_SESSION['language'])){
	$htmlCombo=$bsiCore->getbsilanguage($_SESSION['language']); 
	}else{
		$htmlCombo=$bsiCore->getbsilanguage(); 
	}
if(isset($_POST['type'])){ 
if($_POST['type']==1){ 
		if(isset($_SESSION['sv_currency']))
		{$currency=$_SESSION['sv_currency'];}
		else
		{$currency=$bsiCore->currency_code();}	
		$hotel_data_redirect=$bsiCore->getHotelDetails($_POST['hotel_id']);
		$totaladult1=0;
		$totalchild1=0;
		foreach($_POST['adults'] as $key => $val){
			$totaladult1+=$val;
		}
		
		foreach($_POST['children'] as $key => $val){
			$totalchild1+=$val;
		}
		
		echo "<script language=\"JavaScript\">";		
		echo "document.write('<form action=\"".strtolower($hotel_data_redirect['city_name']).'/'.str_replace(" ","-",strtolower(trim($hotel_data_redirect['hotel_name']))).'-'.$_POST['hotel_id'].'.html'."\" method=\"post\" name=\"formhotel\">');";		
		echo "document.write('<input type=\"hidden\" name=\"check_in\"  value=\"".$_POST['check_in']."\">');";
		echo "document.write('<input type=\"hidden\" name=\"check_out\"  value=\"".$_POST['check_out']."\">');";	
		echo "document.write('<input type=\"hidden\" name=\"rooms\"  value=\"1\">');";	
		echo "document.write('<input type=\"hidden\" name=\"adults[]\"  value=\"".$totaladult1."\">');";	
		echo "document.write('<input type=\"hidden\" name=\"children[]\"  value=\"".$totalchild1."\">');";	
		echo "document.write('<input type=\"hidden\" name=\"hotel_id\"  value=\"".$_POST['hotel_id']."\">');";		
		echo "document.write('<input type=\"hidden\" name=\"currency\"  value=\"".$currency."\">');";		
		echo "document.write('</form>');";		
		echo "setTimeout(\"document.formhotel.submit()\",500);";		
		echo "</script>";	
       die;
 } 
}
include("includes/hotel-search.class.php");
$bsiHotelSearch = new bsiHotelSearch();
$bsiCore->clearExpiredBookings();
$map_genrator="";
$map_i=1;
$adultperrrom = "";
$childperrrom = "";
$totalNoAdult = 0;
$totalNoChild = 0;
if(isset($_POST['rooms'])){
	$arrayAdult = $_POST['adults'];
	$arrayChild = $_POST['children'];
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
    $_SESSION['childperrrom'] = $childperrrom;
	$_SESSION['sv_childcount'] = $totalNoChild;
}
$recommended     = array();
$recommendedHtml = array();
$recommendedPrice = '';
	$html='';
	if(isset($_SESSION['adult'])){
		unset($_SESSION['adult']);
		$_SESSION['adult'] = $totalNoAdult;
	}else{
		$_SESSION['adult'] = $totalNoAdult;
	}
	if(!isset($_SESSION['adultperrrom'])){
		unset($_SESSION['adultperrrom']);
		$_SESSION['adultperrrom'] = '1'; 
	}
	
 $array_cnt_room = array_count_values(explode('#',$_SESSION['adultperrrom']));
	$adultperrrom   = array_unique(explode('#',$_SESSION['adultperrrom']));
	if(isset($_POST['sortOrder'])){
		$sortOrder = $_POST['sortOrder'];
		if($sortOrder == "STAR_RATING_DESC"){
			$sqlSDB=$bsiHotelSearch->hotelFilterByDestinationDsc();
		}else if($sortOrder == "STAR_RATING_ASC"){
			$sqlSDB=$bsiHotelSearch->hotelFilterByDestinationAsc();
		}else{
			$sqlSDB=$bsiHotelSearch->hotelFilterByDestination();
		}
	}else{
	$sqlSDB=$bsiHotelSearch->hotelFilterByDestination();
	}
	//echo $sqlSDB;
$totalhotelbydestination = mysql_num_rows($sqlSDB);
	$totalhotelbyavailable   = 0;
	
	$available = false;
	if($totalhotelbydestination > 0){
		$available = true;
	}
	while($rowSDB=mysql_fetch_assoc($sqlSDB)){
		$totalAvailabilityOfHotel=array();
		$totalRoomType=array();
		foreach($adultperrrom as $i => $capacityQty2){
			$total_capacity[$capacityQty2]=0;
		}	
		$sqlRoomType=$bsiHotelSearch->hotelGetRoomType($rowSDB['hotel_id']);
		while($rowRoomType=mysql_fetch_assoc($sqlRoomType)){
				
				foreach($adultperrrom as $i => $capacityQty){
					$sqlCapacity=$bsiHotelSearch->hotelGetCapacity($rowSDB['hotel_id'], $capacityQty);
					if(mysql_num_rows($sqlCapacity)){
					while($rowCapacity=mysql_fetch_assoc($sqlCapacity)){
	
						$searchcorefunc=$bsiHotelSearch->getAvailableRooms($rowRoomType['roomtype_id'], $rowRoomType['type_name'], $rowCapacity['capacity_id'], $rowSDB['hotel_id'], $capacityQty, $rowCapacity['title'], $rowCapacity['capacity']);
						$total_capacity[$capacityQty]+=$searchcorefunc['availableNumberOfRoom'];
						
						if($searchcorefunc['availableNumberOfRoom'] !=0){
							array_push($totalAvailabilityOfHotel,$searchcorefunc['totalAvailability']);
							array_push($totalRoomType,$rowRoomType['roomtype_id']);
							
						}
						
					}
					
					}
					
				}
				
			}
			
			$flag=1;
			foreach($total_capacity as $i => $capacityQty3){
				
				if($capacityQty3 < $array_cnt_room[$i])
				$flag=0;
			}
			
			
		if($flag != 0){
			$totalhotelbyavailable++;
			$totalAvailabilityOfHotelFinal[$rowSDB['hotel_id']] = $totalAvailabilityOfHotel;
			$availabilityByRoomTypeFinal[$rowSDB['hotel_id']] = $bsiHotelSearch->availabilityByRoomType($totalAvailabilityOfHotel,array_unique($totalRoomType));
			$recommendedPrice = "";
			$recommendedPricedetilscapacitytitle ="";
		$recommendedPricedetilscapacity ="";
		$recommendedPricedetilsprice ="";
		$recommendedRoomtypeid ="";
		$recommendedcapacityid ="";
		$recommendedPricedetilschildprice ="";
			$totalsumrecommendedprice = 0;
			$i = 0;
			foreach($array_cnt_room as $capacity2 => $noofroom2){
				$mainarrayretrun2 = $bsiCore->recommendedBookingList($totalAvailabilityOfHotel, $noofroom2, $capacity2, $rowSDB['hotel_id']);
				$recommendedPrice.=	$mainarrayretrun2['recommendedPrice'];
				
			$recommendedPricedetilscapacitytitle.=$mainarrayretrun2['recommendedPricedetilscapacitytitle'];
			$recommendedPricedetilscapacity.=$mainarrayretrun2['recommendedPricedetilscapacity'];
			$recommendedPricedetilsprice.=$mainarrayretrun2['recommendedPricedetilsprice'];
			$recommendedPricedetilschildprice.=$mainarrayretrun2['recommendedPricedetilschildprice'];
			$recommendedRoomtypeid.=$mainarrayretrun2['roomtype_id'];
			$recommendedcapacityid.=$mainarrayretrun2['capacity_id'];
				$totalsumrecommendedprice += $mainarrayretrun2['price_sub'];
				$recommended[$i] = $mainarrayretrun2['recommendedPriceArray2']; 
				$i++; 
			}
			//$totalsumrecommendedprice = number_format($totalsumrecommendedprice,2);
			
		$reviewArray=$bsiCore->rating_review($rowSDB['hotel_id']);
		if($reviewArray['totalCount'] > 0)
		$htmlreview='<span class="ser-rate">
                                <span>'.$reviewArray['ratiograde'].'</span>
                                '.number_format($reviewArray['totalRatio'],1).'
                              </span>'; 
		else
		$htmlreview='';
		
		$offer_price=$bsiCore->calculate_offer($_SESSION['sv_mcheckindate'], $_SESSION['sv_mcheckoutdate'], $_SESSION['sv_nightcount'], $totalsumrecommendedprice, $rowSDB['hotel_id']);
		
		if($offer_price['status']){
			$discount_rebon='<div class="ribbon roffer "></div><div class="badge_save">Save<strong>'.$offer_price['discount_percent'].'%</strong></div>';
			
			$offer_html='<div class="price_list"><div><!--<sup>'.$bsiCore->get_currency_symbol($bsiHotelSearch->currency).'</sup>'.$bsiCore->getExchangemoney($offer_price['discount_price'],$bsiHotelSearch->currency).'<span class="normal_price_list">'.$bsiCore->get_currency_symbol($bsiHotelSearch->currency).$bsiCore->getExchangemoney($totalsumrecommendedprice,$bsiHotelSearch->currency).'</span><small>'.FROM_PER.' '.$_SESSION['sv_nightcount'].' '.NIGHTS.'</small>-->
                        <p><a href="'.strtolower($rowSDB['city_name']).'/'.str_replace(" ","-",strtolower(trim($rowSDB['hotel_name']))).'-'.$rowSDB['hotel_id'].'.html" class="searchbtn" style="float:none  !important;">'.BOOK_NOW.'</a></p>
                        </div></div>';
		}else{
			$offer_html='<div class="price_list"><div><!--<sup>'.$bsiCore->get_currency_symbol($bsiHotelSearch->currency).'</sup>'.$bsiCore->getExchangemoney($totalsumrecommendedprice,$bsiHotelSearch->currency).'<small>'.FROM_PER.' '.$_SESSION['sv_nightcount'].' '.NIGHTS.'</small>-->
                        <p><a href="'.strtolower($rowSDB['city_name']).'/'.str_replace(" ","-",strtolower(trim($rowSDB['hotel_name']))).'-'.$rowSDB['hotel_id'].'.html" class="searchbtn" style="float:none  !important;">'.BOOK_NOW.'</a></p>
                        </div></div>';
			$discount_rebon='';
		
		}
		
		$map_genrator.= '<script  type="text/javascript">
        $(document).ready(function () {
		function initialize'.$rowSDB['hotel_id'].'() {	
        $(".hotel-map'.$rowSDB['hotel_id'].'").ShopLocator({
            infoBubble:{
                visible: true,
                backgroundColor: \'transparent\',
                arrowSize: 0,
                arrowPosition: 50,
                minHeight: 127,
                maxHeight: null,
                minWidth: 170,
                maxWidth: 250,
                hideCloseButton: false,
				 closeSrc: "css/closeButton.svg"
            },
			map:{
				zoom: 10,
				maxZoom: "16",
                minZoom: "2"
			},
			markersIcon: "images/map/marker_h.png",
            marker:{
                latlng: ['.$rowSDB['latitude'].', '.$rowSDB['longitude'].'],
                title: "'.$rowSDB['hotel_name'].'",
                street: "'.$rowSDB['address_1'].'",
                zip: "'.$rowSDB['post_code'].'",
                city: "'.$rowSDB['city_name'].'"
            }
        });
		};
	
		$(\'#showonmap'.$rowSDB['hotel_id'].'\').on(\'shown.bs.modal\', function (e) {
		 initialize'.$rowSDB['hotel_id'].'();

        });
 
   });
    </script>';
	

		$html.='<div class="row mrb20" id="mrb203">
		<totelp style="display:none;">'.$recommendedPricedetilsprice.'</totelp>
                    <div class="col-md-12 sernbox">
                      <div class="container-fluid">
                        <div class="row">
                          <div class="col-md-4 col-sm-4 serimg">
                            <div class="search-image">
							'.$discount_rebon.'                              
							  
                              <img alt="" src="gallery/hotelImage/'.$rowSDB['default_img'].'">
                            </div>
                          </div> 
                          <div class="col-md-8 col-sm-8">
                            <h3 class="sertl"><a href="'.strtolower($rowSDB['city_name']).'/'.str_replace(" ","-",strtolower(trim($rowSDB['hotel_name']))).'-'.$rowSDB['hotel_id'].'.html">'.$rowSDB['hotel_name'].'</a>&nbsp;'.$bsiCore->hotelStar($rowSDB['star_rating']).'
                             '.$htmlreview.'
                            </h3>
                           <p class="sertlul">'.$rowSDB['address_1'].' '.$rowSDB['address_2'].', '.$rowSDB['city_name'].' [ <a href="javascript:void(0)" role="modal"  data-toggle="modal" data-target=#showonmap'.$rowSDB['hotel_id'].'>'.SHOW_ON_MAP.'</a>] </p>
                            <div class="modal fade" id="showonmap'.$rowSDB['hotel_id'].'" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                              <div class="modal-dialog">
                                <div class="modal-content">
                                  <div class="modal-header">
                                    <button aria-label="Close" data-dismiss="modal" class="close" type="button"><span aria-hidden="true">�</span></button>
            <h4 class="modal-title" id="myModalLabel">'.$rowSDB['hotel_name'].'</h4>
                                  </div>
                                  <div class="modal-body">
                                    <div class="container-fluid">
                                      <div class="row">
                                        <div class="col-md-12">
                                          <div class="hotel-map'.$rowSDB['hotel_id'].'" ></div>
                                        </div>
                                      </div>
                                    </div>
                                  </div>
                                </div>
                              </div>
                            </div>
                            <p class="settxt">'.$rowSDB['desc_short'].'</p>
                          </div>
                        </div>
			<!--		<br> comment by marco 20160220 -->
                        <div class="row">
                          <div class="col-md-9">
                            <table class="table table-condensed graytable">
                              <tbody><!--<tr class="bggr">
                                  	<th class="tmx">'.AVAILABLE_ROOM.'</th>
									<th>'.MAX_OCCUPENCY.'</th>
									<th>Price</th>
									
                                </tr>
                                <tr class="bggr2">
                                  <td colspan="3">'.$bsiHotelSearch->totalRoom.' '.ROOMS.', '.$bsiHotelSearch->totalAdult.'  '.ADULTS.',  '.$bsiHotelSearch->nightCount.' '.NIGHTS.'</td>
                                </tr>-->
                                '.$recommendedPrice.'
                               
                              </tbody></table>
                          </div>
						   <div class="col-md-3">
						   
						     '.$offer_html.'
						   
						     
						   </div>
                        </div>
                        <div class="clr"></div>
                      </div>
                    </div>
                 </div>';

 
									$map_i++;
									$recommendedHtml[$rowSDB['hotel_id']] = array("recommendedRoomtype" => $recommendedPrice, "recommended" => $recommended,"recommendedPricedetilscapacitytitle"=>$recommendedPricedetilscapacitytitle,"recommendedPricedetilscapacity"=>$recommendedPricedetilscapacity,"recommendedPricedetilsprice"=>$recommendedPricedetilsprice,"recommendedPricedetilschildprice"=>$recommendedPricedetilschildprice,"recommendedRoomtypeid"=>$recommendedRoomtypeid,"recommendedcapacityid"=>$recommendedcapacityid); 
			$_SESSION['recommendedRoomtype'] = $recommendedHtml;				 
		}
		}
		//echo $html;
		 
		

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
<link rel="stylesheet" type="text/css" href="css/mapStyle.css">
<link rel="stylesheet" type="text/css" href="css/loader.css">
<title>
<?=$bsiCore->config['conf_portal_name']?>
: Search</title>
<script src="js/jquery.min.js"></script>
<script src="js/cssmenu/script.js"></script>
<script type="text/javascript" src="js/jquery.easing.1.3.js"></script>
<script src="src/jquery.anyslider.js"></script>
<script src="js/bootstrap.js"></script>
<script src="js/moment-with-locales.js"></script>
<script type="text/javascript" src="js/bootstrap-datepicker.js"></script>
<script src="http://code.jquery.com/ui/1.11.2/jquery-ui.js"></script>

<!--<script type="text/javascript" src="https://maps.googleapis.com/maps/api/js?libraries=places,geometry"></script>-->
 <script type="text/javascript" src="https://maps.googleapis.com/maps/api/js?libraries=places,geometry&language=<?php echo $_SESSION['language'];?>"></script>

<script src="js/dependences/markerclusterer.js"></script>
<script src="js/dependences/infobubble.js"></script>
<script src="js/shop-locatorsasd.js"></script>
<?php echo $map_genrator; ?> 

<script type="text/javascript">
<?php if(isset($_POST['rooms'])){ ?>
$(window).load(function() {
	setTimeout(
  function() 
  {
	$(".loader").hide();
	$("#mainbody2").show();
	$( '#allcitymap' ).attr( 'src', function ( i, val ) { return val; });	
  }, 1000);
})
<?php }else{ ?>
$(document).ready(function(){
	$(".loader").hide();
	$("#mainbody2").show();
})
<?php } ?>


</script>

<script>
$(function() {
var $divs = $("div#mrb203");

$('#pricesorting').on('change', function () {
	var item=$(this);
  
	if(item.val()==1){
    var numericallyOrderedDivs = $divs.sort(function (a, b) {
        return $(a).find("totalp").text() > $(b).find("totalp").text();
    });
    $("#content").html(numericallyOrderedDivs);
}
});

});
</script>
</head>

<body>
<!-- loader start here -->
<?php if($_SESSION['sv_destination']=='All Cities'){$destinationname="Any in Hong Kong";}else{$destinationname=$_SESSION['sv_destination'];}?>

<div class="loader">
    <div class="container-fluid" >
      <div class="row">
        <div class="col-md-12">
          <div class="loding-circle">
            <!--<div class="loding-logo"><img alt="" src="http://178.62.5.12/bhbsp/images/demo-logo.png"></div>-->
           <div class="loding-logo"><img alt="" src="gallery/portal/<?php echo $bsiCore->config['conf_portal_logo']; ?>"></div>
            
            <div class="ajaxloding"></div>
            <div class="loding-text"><?php echo PLEASE_WAIT;?></div>
            <div class="loding-text2"><?php echo WE_R_SEARCHING_FOR_THE_BEST_VALUE;?></div>
            <div class="loding-text3"><?php echo NEW_HOTEL_IN;?>&nbsp;&nbsp;<?=$destinationname?></div>
            <div class="loding-text5 ">
            <?php echo CHECK_IN;?>: <?=$_SESSION['sv_checkindate']?>
            </div>
            <div class="loding-text2"><?php echo THIS_WILL_TAKE_ONLY_FEW_SECOND;?></div>
          </div>
        </div>
      </div>
    </div>
</div>
<!-- loader end here -->

<div id="mainbody2" style="display:none">
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
                
                <div class="col-md-9 col-md-push-3">
                  <h2 class="sett4">
                    <?=$totalhotelbydestination?>
                    <?=HOTELS_FOUND?>
                    ,
                    <?=$totalhotelbyavailable?>
                    <?=AVAILABLE?>
                  </h2>
                  <!--<div class="container-fluid">-->
                  
                  <input type='hidden' id='current_page' />
                  <input type='hidden' id='show_per_page' />
                  
                  
                  <!-- /Static code -->
                  <div id="content" class="container-fluid"> 
                     
               
                    
                 
                  
                  <!-- /Static code -->
                  <?php
												 
		echo  $html;
		if(isset($totalAvailabilityOfHotelFinal)){
			$_SESSION['totalAvailabilityOfHotelFinal']=$totalAvailabilityOfHotelFinal;
			$_SESSION['availabilityByRoomTypeFinal']=$availabilityByRoomTypeFinal;
			$_SESSION['ArrayCntRoom']=$array_cnt_room;
		}else{
			echo NO_HOTEL_FOUND;
		}
		?>
                  <!-- Pagination  CODE  -->
                  <div class="container-fluid">
                    <div class="row">
                      <div class="col-md-12" style="text-align:center">
                        <?php 
											
												if($totalhotelbyavailable >10){
												?>
                        <div id='page_navigation'></div>
                        <?php } ?>
                      </div>
                    </div>
                  </div>
                  
                  <!-- END OF Pagination  CODE  --> 
                  
                  <!--</div>--> 
                  
                </div>
              </div>
              <div class="col-md-3 col-md-pull-9">
                  <div class="container-fluid">
                    <div class="row">
                      <div class="col-md-12 sernbox" style="border:1px solid #fcb717;">
                        <h2 class="sett3">
                          <?=NEW_YOUR_SEARCH_DETAILS?>
                        </h2>
                        <br />
                        <br />
                        <div class="container-fluid" style="padding:20px 15px">
                          <div class="row">
                            <div class="col-md-6 col-sm-6 col-xs-6">
                              <p class="pstl"><strong>
                                <?=DESTINATIONS?>
                                </strong></p>
                            </div>
                            <div class="col-md-6 col-sm-6 col-xs-6">
                              <p class="pstl">
                              <?php if($_SESSION['sv_destination']=='All Cities'){$destinationname="Any in Hong Kong";}else{$destinationname=$_SESSION['sv_destination'];}?>
                                <?=$destinationname?>
                              </p>
                            </div>
                          </div>
                          <div class="row">
                            <div class="col-md-6 col-sm-6 col-xs-6">
                              <p class="pstl"><strong>
                                <?=CHECK_IN_DATE?>
                                </strong></p>
                            </div>
                            <div class="col-md-6 col-sm-6 col-xs-6">
                              <p class="pstl">
                                <?=$_SESSION['sv_checkindate']?>
                              </p>
                            </div>
                          </div>
                          <!--<div class="row">
                            <div class="col-md-6 col-sm-6 col-xs-6">
                              <p class="pstl"><strong>
                                <?=CHECKK_OUT_DATE?>
                                </strong></p>
                            </div>
                            <div class="col-md-6 col-sm-6 col-xs-6">
                              <p class="pstl">
                                <?=$_SESSION['sv_checkoutdate']?>
                              </p>
                            </div>
                          </div>-->
 <!--                         <div class="row">
                            <div class="col-md-6 col-sm-6 col-xs-6">
                              <p class="pstl"><strong>
                                <?=TOTAL_NIGHTS?>
                                </strong></p>
                            </div>
                            <div class="col-md-6 col-sm-6 col-xs-6">
                              <p class="pstl">
                                <?=$_SESSION['sv_nightcount']?>
                              </p>
                            </div>
                          </div>-->
                          <?php 
					$getHtml      = "";
					$roomAdultarr = array();
					$roomAdultarr = explode('#', $_SESSION['adultperrrom']);
					$roomChildarr = explode('#', $_SESSION['childperrrom']);
					$arrayCombine = $bsiCore->Combine($roomAdultarr, $roomChildarr);
					$i=1;
					foreach($arrayCombine as $k => $valarr){
						foreach($valarr as $room => $child){
							$getHtml  .= '  <div class="row">
                                                    <div class="container-fluid">
                                                        <div class="row" style="border:1px solid #e1e1e1; margin:0; padding:0">
                                                        <div class="col-md-6 col-sm-6 col-xs-6 pst2"><p class="pstl">'.$room.' '.ADULTS.'</p></div>
                                                        <div class="col-md-6 col-sm-6 col-xs-6 pst2"><p class="pstl">'.$child.' '.CHILD.'</p></div> 
														</div>
                                                    </div>
                                                </div>';
							$i++;
						}
					}
				//	echo $getHtml;  //disable displaying adult & child in "Your Search Details" box
				?>
                          <div class="row">
                            <div class="container-fluid">
                              <div class="row">
                                <div class="col-md-12" style="margin-top:20px; text-align:center"> <a class="searchbtn serbtn3" href="index.php">
                                  <?=CHANGE_SELECTION?>
                                  </a> </div>
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
<style>
#page_navigation a {
	padding:3px;
	border:1px solid gray;
	margin:2px;
	color:black;
	text-decoration:none
}
.active_page {
	background:#01b7f2;
	color:white !important;
}
</style>
<style>
#datepicker,
#datepicker2{
	width:80%;
	float:left;
}
.ui-datepicker-trigger{ 
	float:right;
	margin-top:4px;
}
div.searchbg{
	z-index:999999;
	position:relative;
}
label.chkdate{ width:100%; float:left;}
@media (max-width: 980px) and (min-width: 650px){
#datepicker,
#datepicker2{
	width:95%;
	float:left;
}
}
@media (max-width: 649px) and (min-width: 300px){
#datepicker,
#datepicker2{
	width:85%;
	float:left;
}
}
</style>
<script>
$(function() {
	$( "#datepicker" ).datepicker({
		showOn: "button",
		buttonImage: "images/calendar.jpg",
		buttonImageOnly: true,
		buttonText: "Date"
	});
	$( "#datepicker" ).on('click',function(){
		$(this).next().trigger('click');
	});
	$( "#datepicker2" ).datepicker({
		showOn: "button",
		buttonImage: "images/calendar.jpg",
		buttonImageOnly: true,
		buttonText: "Date"
	});
	$( "#datepicker2" ).on('click',function(){
		$(this).next().trigger('click');
	});
});
</script> 
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
		//close in popup modal
		$('.close').on('click',function(){
			$('div.searchbg').css('zIndex',999999);
		});
		//open popup modal signin
		$('.signin').on('click',function(){
			$('div.searchbg').css('zIndex',1);
		});
	});
</script> 
<script>
        $(function () {
            $('.slider1').anyslider({
                animation: 'fade',
                interval: 5000,
                reverse: true,
                startSlide: 1
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
<script type="text/javascript">
	$(document).ready(function(){
	//how much items per page to show
	var show_per_page = 10;  	
	//getting the amount of elements inside content div
	var number_of_items = $('#content').children().size();
	//calculate the number of pages we are going to have
	var number_of_pages = Math.ceil(number_of_items/show_per_page);
	//set the value of our hidden input fields
	$('#current_page').val(0);
	$('#show_per_page').val(show_per_page);
	//now when we got all we need for the navigation let's make it '
	/* 
	what are we going to have in the navigation?
		- link to previous page
		- links to specific pages
		- link to next page
	*/
	var navigation_html = '<a class="previous_link" href="javascript:previous();"><?=PREV?></a>';
	var current_link = 0;
	while(number_of_pages > current_link){
		navigation_html += '<a class="page_link" href="javascript:go_to_page(' + current_link +')" longdesc="' + current_link +'">'+ (current_link + 1) +'</a>';
		current_link++;
	}
	navigation_html += '<a class="next_link" href="javascript:next();"><?=NEXT?></a>';
	
	$('#page_navigation').html(navigation_html);
	//add active_page class to the first page link
	$('#page_navigation .page_link:first').addClass('active_page');
	//hide all the elements inside content div
	$('#content').children().css('display', 'none');
	//and show the first n (show_per_page) elements
	$('#content').children().slice(0, show_per_page).css('display', 'block');
});
function previous(){
	new_page = parseInt($('#current_page').val()) - 1;
	//if there is an item before the current active link run the function
	if($('.active_page').prev('.page_link').length==true){
		go_to_page(new_page);
	}
}
function next(){
	new_page = parseInt($('#current_page').val()) + 1;
	//if there is an item after the current active link run the function
	if($('.active_page').next('.page_link').length==true){
		go_to_page(new_page);
	}
}
function go_to_page(page_num){
	//get the number of items shown per page
	var show_per_page = parseInt($('#show_per_page').val());
	//get the element number where to start the slice from
	start_from = page_num * show_per_page;
	//get the element number where to end the slice
	end_on = start_from + show_per_page;
	//hide all children elements of content div, get specific items and show them
	$('#content').children().css('display', 'none').slice(start_from, end_on).css('display', 'block');
	/*get the page link that has longdesc attribute of the current page and add active_page class to it
	and remove that class from previously active page link*/
	$('.page_link[longdesc=' + page_num +']').addClass('active_page').siblings('.active_page').removeClass('active_page');
	//update the current page input field
	$('#current_page').val(page_num);
}
</script> 
<!-- Pagination end -->
</div>
</body>
</html>
