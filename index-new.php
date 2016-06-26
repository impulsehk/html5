<?php 
session_start();
include("models/model.php");
include("includes/db.conn.php"); 
include("includes/conf.class.php");
include("includes/language.php");

if(isset($_SESSION['language'])){
	$htmlCombo=$bsiCore->getbsilanguage($_SESSION['language']);
}else{
	$htmlCombo=$bsiCore->getbsilanguage(); 
}

// if(isset($_REQUEST['page']))
// $body_content=mysql_fetch_assoc(mysql_query("select * from bsi_site_contents where id=".$bsiCore->ClearInput($_REQUEST['page'])));
// $getBodyContents = $body_content['contents'];
// $gettitle=$body_content['cont_title'];
		
?>
<?php
	$districts = new Model('bsi_city', 'cid');
	$hostels = new Model('bsi_hotels', 'hotel_id');
	// echo $hostels->find(2)->hotel_name;
	foreach ($hostels->all() as $hostel) {
		// echo $hostel['hotel_name'];
	}
	foreach ( $hostels->find_by('city_name', 'Tsim Sha Tsui') as $hostel ) {
		// echo $hostel['hotel_name'];
	}
?>

<!doctype html>
<html>
	<head>
		<meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<link rel="stylesheet" href="css/bootstrap.css">
		<link rel="stylesheet" href="fonts/stylesheet.css">
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css">
		<link rel="stylesheet" href="js/cssmenu/styles.css">
		<link rel="stylesheet" href="css/component.css">
		<script src="js/jquery.min.js"></script>
		<script src="js/cssmenu/script.js"></script>
		<script type="text/javascript" src="js/jquery.easing.1.3.js"></script>
		<script src="src/jquery.anyslider.js"></script>
		<script src="js/bootstrap.js"></script>
		<script src="js/moment-with-locales.js"></script>
		<script type="text/javascript" src="js/bootstrap-datepicker.js"></script>
		<title><?php echo $bsiCore->config['conf_portal_name'].' : '.$gettitle; ?></title>
	</head>
	<body>
		<div class="app-container">
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
						<li><a href="index-new.php">Hostel</a></li>
						<li><a href="./customer/index.php">Customer</a></li>
						<li><a href="./marketing/index.php">Investment & Marketing</a></li>
						<li><a href="./contact/index.php">Contact Us</a></li>
					</ul>
				</div>
			</div>

			<div class="content-container">
				<?php foreach($districts->all() as $district) : ?>
					<div class="hostel-box district-index" style="background-image: url(./gallery/cityImage/<?php echo $district['default_img']?>)">
						<a href="./districts/index.php?code=<?php echo $district['cid'] ?>" class="link-overlay">
							<div class="link-overlay-inner">
								<h4 class="hostel-name">
									<?php echo $district['city_name'] ?>
								</h4>
							</div>
						</a>
					</div>
				<?php endforeach ?>
			</div>
	
			<?php include("./layout/footer.php"); ?>

		</div>

	</body>
</html>

			
