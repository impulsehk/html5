<?php 
session_start();
include("../models/model.php");
include("../models/utilities.php");
include("../includes/db.conn.php"); 
include("../includes/conf.class.php");
// include("../includes/language.php");
// if(isset($_SESSION['language'])){
// 	$htmlCombo=$bsiCore->getbsilanguage($_SESSION['language']);
// }else{
// 	$htmlCombo=$bsiCore->getbsilanguage(); 
// }


?>
<?php
$districts = new Model('bsi_city', 'cid');
$RoomType = new Model('bsi_roomtype', 'room_type_id');
$id = $_GET['code'];
$district = $districts->find($id);
$h_model = new Model('bsi_hotels', 'hotel_id');
$hostels = $h_model->find_by( 'city_name',$district['city_name'] );
$PricePlan = new PriceModel();
$prices = [];

?>

<!doctype html>
<html>
	<head>
		<?php include("../layout/head.php"); ?>
		<script type="text/javascript" src="https://maps.googleapis.com/maps/api/js?libraries=places,geometry&language=<?php echo $_SESSION['language'];?>"></script>
		<script type="text/javascript" src="../js/shop-locator.js"></script>
		<script type="application/javascript">
			(function ($) {
		    "use strict";
		    $(document).ready(function () { 
				  $(".google-map").ShopLocator({
            pluginStyle: "modern",
            json: "../data/json/homepagemap.json",
            infoBubble: {
              visible: true,
              arrowPosition: 50,
              minHeight: 112,
              maxHeight: null,
              minWidth: 170,
              maxWidth: 250
            },
					  map:{
              mapStyle: [{"featureType":"administrative","elementType":"labels.text.fill","stylers":[{"color":"#444444"}]},{"featureType":"landscape","elementType":"all","stylers":[{"color":"#f2f2f2"}]},{"featureType":"poi","elementType":"all","stylers":[{"visibility":"off"}]},{"featureType":"road","elementType":"all","stylers":[{"saturation":-100},{"lightness":45}]},{"featureType":"road.highway","elementType":"all","stylers":[{"visibility":"simplified"}]},{"featureType":"road.arterial","elementType":"labels.icon","stylers":[{"visibility":"off"}]},{"featureType":"transit","elementType":"all","stylers":[{"visibility":"off"}]},{"featureType":"water","elementType":"all","stylers":[{"color":"#B4D1FF"},{"visibility":"on"}]}]
            }, 
            cluster:{
              enable: true,
              gridSize: 60,
              style:{
                textColor: '#ffffff',
                textSize: 18,
                heightSM: 60,
                widthSM: 60,
                heightMD: 70,
                widthMD: 70,
                heightBIG: 80,
                widthBIG: 80,
                iconSmall: "../css/material/images/clusterSmall.png",
                iconMedium: "../css/material/images/clusterMedium.png",
                iconBig: "../css/material/images/clusterBig.png"
              }
            }
	        });
				});
			}(jQuery));
		</script>
	</head>
	
	<body>
		<div class="app-container">
			<!-- navbar -->
			<div class="navbar-container">
				<div class="navbox">
			    <button type="button" class="navbar-toggle collapsed menu-icon" data-toggle="collapse" data-target="#nav-main-menu" aria-expanded="false">
			      <span class="sr-only">Toggle navigation</span>
			    </button>
				</div>
				<div class="navbox" style="flex: 4 0;">
					<div class="navbox-brand"></div>
				</div>
				<div class="navbox">
					<div class="lang-icon"></div>	
				</div>
			</div>
			<div class="navbar navbar-default">
				<div class="collapse navbar-collapse" id="nav-main-menu">
					<ul class="nav navbar-nav">
						<li><a href="../index-new.php">Hostel</a></li>
						<li><a href="../customer/index.php">Customer</a></li>
						<li><a href="../marketing/index.php">Investment & Marketing</a></li>
						<li><a href="../contact/index.php">Contact Us</a></li>
					</ul>
				</div>
			</div>
			<!-- navbar -->

 			<div id="nav-affix" data-spy="affix" data-offset-top="60">
				<div>
					<a href="../index-new.php" class="back">
						<div class="icon-back"></div>
					</a>
					<div><?php echo $district['city_name']; ?></div>
				</div>
				<div>
					<div class="date-box">
						<span><?php echo date("D"); ?></span>
						<span><?php echo date("d"); ?></span>
					</div>
					<div>
						<div class="seperator"></div>
					</div>
					<div class="date-box">
						<span><?php echo date("D", strtotime('tomorrow')); ?></span>
						<span><?php echo date("d", strtotime('tomorrow')); ?></span>
					</div>
				</div>
			</div>
			<div class="carousel-container">
				<div class="jumbotron-overlay"></div>
			  <div class="carousel-overlay">
			    <h3 class="district"><?php echo $district['city_name'];?></h3>
			  </div>
			  <div class="carousel-image" style="background-image: url(../gallery/cityImage/<?php echo $district['default_img'];?>)"></div>
			</div>
			<div class="content-container hostel-index">

				<?php foreach($hostels as $hostel) : ?>
					<?php
						$roomTypes = $RoomType->find_by( 'hotel_id', $hostel['hotel_id'] );
						$prices = [];
						foreach($roomTypes as $rt) {
							$id = $rt['roomtype_id'];
							$type = $rt['roomtype_name'];
							$price = $PricePlan->finding( $hostel['hotel_id'], $id );
							array_push( $prices, array( str_replace(' Room', '', $type), $price[0][strtolower(date("D"))] ) );
						}
					?>
					<div class="hostel-box" style="background-image: url(../gallery/hotelImage/<?php echo $hostel['default_img']?>);">
						<a href="../hostels/index.php?code=<?php echo $hostel['hotel_id']; ?>" class="link-overlay">
							<div class="link-overlay-inner">
								<p><span><?= staring($hostel['star_rating']); ?></span></p>
								<div class="price-box">
									<?php foreach ($prices as $price) : ?>
										<div class="price-items">
											<?php if ($price[0] == "Overnight") : ?>
												<div class="clock-icon twenty-four"></div>
												<div class="price-label"><?= currency($price[1]); ?></div>
												<!-- <div class="price-label"><?= $bsiCore->get_currency_symbol($_SESSION['sv_currency']).floor($bsiCore->getExchangemoney($price[1],$_SESSION['sv_currency'])) ?></div> -->
											<?php elseif ($price[0] == "Short Stay") : ?>
												<div class="clock-icon one"></div>
												<div class="price-label"><?= currency($price[1]); ?></div>
												<!-- <div class="price-label"><?= $bsiCore->get_currency_symbol($_SESSION['sv_currency']).floor($bsiCore->getExchangemoney($price[1],$_SESSION['sv_currency'])) ?></div> -->
											<?php endif ?>
										</div>
									<?php endforeach ?>
								</div>
								<h4 class="hostel-name"><?= $hostel['hotel_name']; ?></h4>
							</div>
						</a>
					</div>
				<?php endforeach ?>

			</div>
			<button class="map btn circle sm-only"></button>
			<div class="map-wrapper">
				<div class="google-map"></div>
			</div>
			<!-- footer -->
			<?php include("../layout/footer.php"); ?>
			<!-- -->
		</div>
	</body>
</html>