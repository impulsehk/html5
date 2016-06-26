<?php 
session_start();
include("../models/model.php");
include("../includes/db.conn.php"); 
include("../includes/conf.class.php");
// include("includes/language.php");
?>

<!doctype html>
<html>
	<?php include("../layout/head.php"); ?>
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

<div class="content-container pages">
	<h4 class="title">Investment and Marketing</h4>
	<p>Impulse provides the first impulse booking and check-in application in the world with the largest scale.

Like "Airbnb", we created a new market and solution, targeting low budget hotel/hostel, Business traveler, Globetrotter and impulsive traveler.

Appreciative comments among mass media will keep encouraging impulse travel which will be the trend in future.

Friends, companies and various media are welcome to communicate and cooperate with . Interested parties are welcome to contact us through email for investment, marketing or franchise in other city. Please leave a message and your contact number, we will contact the suitable party for further arrangement.</p>
<p>
The worldwide highlighted impulse travel application –
</p>
<p>
No plan is the plan!
</p>
<p>
Contact details of investment and marketing cooperation
</p>
<p>
Contact Person : Ricky Yu
</p>
<p>
Email：info@' </p>
</div>

			<!-- footer -->
			<?php include("../layout/footer.php"); ?>
			<!-- -->
		</div>
	</body>
</html>