<?php
	include("../includes/db.conn.php");
	include("../includes/conf.class.php");
	include("../includes/admin.class.php");
	$user_id = $_SESSION['cpid'];
	$bsiAdminMain->pageAccess($user_id, $pageid); 
?>
<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8">
		<!-- iPhone, iPad and Android specific settings -->	
		<meta name="viewport" content="width=device-width; initial-scale=1.0; maximum-scale=1;">
		<meta name="apple-mobile-web-app-capable" content="yes" />
		<meta name="apple-mobile-web-app-status-bar-style" content="black-translucent" />
		
		<title>BSI Control Panel</title>
		
		<!-- Create an icon and splash screen for iPhone and iPad -->
		<link rel="apple-touch-icon" href="images/iOS_icon.png">
		<link rel="apple-touch-startup-image" href="images/iOS_startup.png"> 
		<link rel="stylesheet" type="text/css" href="css/all.css" media="screen">
		
		<!-- These following stylesheets will set the light theme, fixed width, top bar, red colour -->
		<link rel="stylesheet" type="text/css" href="css/theme/theme_light.css" media="screen">
		<link rel="stylesheet" type="text/css" href="css/layout_fixed.css" media="screen">
		<link rel="stylesheet" type="text/css" href="css/header_top.css" media="screen">
		<link rel="stylesheet" type="text/css" href="css/theme/theme_red.css" media="screen">
		<!--[if IE 6]><link rel="stylesheet" type="text/css" href="css/ie6.css" media="screen" /><![endif]-->
		<!--[if IE 7]><link rel="stylesheet" type="text/css" href="css/ie.css" media="screen" /><![endif]-->
			
		<!-- Load JQuery -->		
		<script type="text/javascript" src="js/jquery.min.js"></script>
		<!-- Load JQuery UI -->
		<script type="text/javascript" src="js/jquery-ui.min.js"></script>
		
		<!-- Load Interface Plugins -->
		<script type="text/javascript" src="js/uniform/jquery.uniform.js"></script>
		<script type="text/javascript" src="js/iPhone/jquery.iphoneui.js"></script>
		<script type="text/javascript" src="js/uitotop/js/jquery.ui.totop.js"></script>
		<!-- This file configures the various jQuery plugins for Adminica. Contains links to help pages for each plugin. -->
		<script type="text/javascript" src="js/adminica/adminica_ui.js"></script>
		
	</head>
	<body>
		<div id="wrapper">
			<div id="topbar" class="clearfix">
				<a href="admin-home.php" class="logo"><span></span></a>
				<div class="user_box round_all">
					
					
					<h3><a class="text_shadow" href="logout.php">Sign Out</a></h3><br><br>
					
				</div><!-- #user_box -->	
			</div><!-- #topbar -->		
				
		
		<div id="main_container" class="main_container container_16 clearfix">
			
			<div id="nav_top" class="clearfix round_top">
				<ul class="clearfix round_all">
                	  <?php
 //include("../includes/db.conn.php");  
$sql_parent=mysql_query("select * from bsi_adminmenu where parent_id=0 and status='Y' order by ord");
while($row_parent=mysql_fetch_array($sql_parent)){//while start
  $checkMenu1 = mysql_query("select * from bsi_user_access where user_id = ".$user_id." and menu_id = ".$row_parent[0]."");
	if(mysql_num_rows($checkMenu1)){//1st if start
					
					
			echo '<li><a href="'.$row_parent[2].'">'.$row_parent[1].'</a>';
		$sql_parent222=mysql_query("select * from bsi_adminmenu where parent_id=".$row_parent[0]." and status='Y' order by ord");
                 if(mysql_num_rows($sql_parent222)){	//2nd if start
					echo '<ul class="dropdown">';
			while($row_parent222=mysql_fetch_array($sql_parent222)){
					$checkMenu2 = mysql_query("select * from bsi_user_access where user_id = ".$user_id." and menu_id = ".$row_parent222[0]."");		
				if(mysql_num_rows($checkMenu2)){
					$sql_parent333=mysql_query("select * from bsi_adminmenu where parent_id=".$row_parent222[0]." and status='Y' order by ord");
						if(mysql_num_rows($sql_parent333)){	//sql_parent333 if start
						
										   echo '<li><a href="'.$row_parent222[2].'" class="has_slide">'.$row_parent222[1].'</a>';
											echo '<ul class="slideout">'; 
					    while($row_parent333=mysql_fetch_array($sql_parent333)){//parent333 while start
							
					$checkMenu3 = mysql_query("select * from bsi_user_access where user_id = ".$user_id." and menu_id = ".$row_parent333[0]."");
														if(mysql_num_rows($checkMenu3)){//menu3 if start
																			
														echo '<li><a href="'.$row_parent333[2].'">'.$row_parent333[1].'</a></li>';
														
														}//menu3 if end
											
											
											}//parent333 while end
											echo '</ul>';  
										}else{										
										   echo '<li><a href="'.$row_parent222[2].'">'.$row_parent222[1].'</a></li>';
										}
										
								   }
									
									
									
									}//sql_parent333 if end
								echo '</ul>';
							}else{	//sql_parent333 else start
								echo '</li>';
							
							
							
							
							}//2nd if end
							
							
				          
						  
						   }//1st if end
						   
						   
						   
						}//while end
						?>
                    
				</ul>	
			</div><!-- #nav_top -->