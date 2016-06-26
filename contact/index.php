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
				<h4 class="title">Call us for free</h4>
				<p class="bg-primary"><i class="glyphicon glyphicon-phone-alt"></i>&nbsp;97009865</p>
				<p class="bg-primary">info@feelspark.com</p>
				<h4 class="title">Contact Form</h4>

				<form>
					<div class="contact-form">
						<div class="form-box-content">
							<div class="form-group">
								<select name="" id="" class="selectpicker full">
									<option value="0">Enquiry</option>
									<option value="1">Customer Option</option>
									<option value="2">Complaints</option>
									<option value="3">Hostel Application</option>
									<option value="4">Angel/VC Investment</option>
									<option value="5">Marketing Cooperation</option>
									<option value="6">Press emquiry / Interview</option>
									<option value="7">Other</option>
								</select>
								<input type="text" value="" class="form-control" name="name" placeholder="Name in Full">

								<input type="text" value="" class="form-control" name="contactemail" placeholder="E-mail">

								<input type="text" value="" class="form-control" name="phone" placeholder="phone">

								<label for="">Comments / Question:</label>
								<textarea type="textarea" value="" class="form-control" name="comments" rows="3"></textarea>
								<input type="submit" class="btn btn-block go-button" value="Submit" id="search_submit">

							</div>
						</div>
					</div>
				</form>

			</div>	
			<!-- footer -->
			<?php include("../layout/footer.php"); ?>
			<!-- -->
		</div>
	</body>
</html>