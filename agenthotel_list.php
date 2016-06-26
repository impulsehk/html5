<?php
	include("access.php");    
	include("includes/db.conn.php");
	include("includes/conf.class.php");
	include("includes/admin.class.php");
	include("includes/language.php");
	if(isset($_SESSION['language'])){
		$htmlCombo=$bsiCore->getbsilanguage($_SESSION['language']);
	}else{
		$htmlCombo=$bsiCore->getbsilanguage(); 
	}
global $bsiCore;

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
<title><?=$bsiCore->config['conf_portal_name']?> : Agent Hotel List</title>
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
                            				<h2 class="sett3"><span><?php echo HI;?>, <?php echo $_SESSION['Myname2012'];?></span><?=MY_ACCOUNT_MY_BOOKINGS?></h2>
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
                                                  <li class="list-group-item"><a href="agent_managebooking.php"><?php echo MANAGE_MY_BOOKINGS;?> » </a></li>
                                                <li class="list-group-item"><a href="agent_editAccount.php"><?php echo UPDATE_UR_PROFILE;?> » </a></li>
												<li class="list-group-item"><a href="agenthotel_list.php"><?php echo NEW_ADD_NEW_HOTEL;?> »  </a></li>
                                                <li class="list-group-item"><a href="agent_changepass.php"><?php echo CHANGE_PASSWORD;?> » </a></li>
												 <li class="list-group-item"><a href="agent_logout.php"><?php echo LOG_OUT;?> </a></li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-9">
                                <div class="container-fluid">
                					<div class="row">
                        				<div class="col-md-12 sernbox">
                                             <div class="container-fluid">
                                             	<div class="row" style="padding-top:10px; padding-bottom:10px;">

<div class="col-md-8">
	<h2 class="sett4 sett4_2"><?php echo HOTEL_LIST;?></h2>
</div>
<div class="col-md-4">
<a class="searchbtn6" href="agent_add_hotel.php">
<span class="glyphicon glyphicon-plus-sign" aria-hidden="true"></span> 
<?php echo NEW_ADD_NEW_HOTEL;?>
</a>
</div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-md-12" style="padding:0px;">
                                                    	
                                             			<div class="table-responsive">
                                                          <table class="table table-striped">
                                                          	<tr>
                                                             	<th><?php  echo HOTEL_NAME;?></th>
																<th><?php  echo ADDRESS;?></th>
																<th><?php  echo CHECKIN_HOUR;?></th>
																<th><?php  echo CHECKOUT_HOUR;?></th>
																<th><?php  echo STATUS;?></th>
                                                             </tr>
															  <?php
		     if(isset($_SESSION['client_id2012'])){
			 //echo "select * from bsi_agent_entry_hotel where agent_id='".$bsiCore->ClearInput($_SESSION['client_id2012'])."'";
				 $agenthqryres=mysql_query("select * from bsi_agent_entry_hotel where agent_id='".$bsiCore->ClearInput($_SESSION['client_id2012'])."'");		
				  if(mysql_num_rows($agenthqryres)){
					 while($rowp=mysql_fetch_assoc($agenthqryres)){
						 $hrow=$bsiCore->getHotelDetails($rowp['hotel_id']);	
						 $status=($hrow['status']==1)? '<span class="label label-success">'.ENABLED.'</span>' : '<span class="label label-success">'.DISABLED.'</span>';?>
						<tr><td><?php echo $hrow['hotel_name'];		?></td>					 
						<td><?=$hrow['address_1'].', '.$hrow['city_name'].',<br> '.$countryname['name']?></td>
                         <td><?=$hrow['checking_hour']?></td>
                         <td><?=$hrow['checkout_hour']?></td>
                         <td><?=$status?></td></tr>
					
					
					<?php }}}								 
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


</body>
</html>
