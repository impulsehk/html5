<div class="container-fluid topblue hidden-xs">

    	<div class="row">

        	<div class="col-md-12">

            	<div class="container">

                    <div class="row">

                       <div class="col-md-12">
                       <ul class="nav navbar-left" >
                              <li><span> <i class="fa fa-phone"></i>&nbsp;&nbsp;<?php echo $bsiCore->config['conf_portal_phone'];?></span></li>    
                         </ul>  
					  <?php 
					  
					  function removeQueryStringFromUrl($url) {
							if (substr($url,0,4) == "http") {
								$urlPartsArray = parse_url($url);
								$outputUrl = $urlPartsArray['scheme'] . '://' . $urlPartsArray['host'] . ( isset($urlPartsArray['path']) ? $urlPartsArray['path'] : '' );
							} else {
								$URLexploded = explode("?", $url, 2);
								$outputUrl = $URLexploded[0];
							}
							return $outputUrl;
						}


					   echo $htmlCombo;
					   if(isset($_SESSION['sv_currency'])){
					   $current_curr_code = isset($_GET['currency'])? mysql_real_escape_string($_GET['currency']) : $_SESSION['sv_currency'];
					    $_SESSION['sv_currency']=$current_curr_code;
					   }else{
						  $current_curr_code = isset($_GET['currency'])? mysql_real_escape_string($_GET['currency']) : $bsiCore->currency_code(); 
						  $_SESSION['sv_currency']=$current_curr_code;
					   }
					   //echo $current_curr_code;
					  // $current_curr_code =$bsiCore->currency_code();
					   echo $bsiCore->get_currency_combo45($current_curr_code); 
					   
					   ?>        
					       <!-- for client-->
					  		<?php /*?><?php 
							if(isset($_SESSION['password_2012']) && $_SESSION['client'] == 1) 
							{?>
                       		<ul class="nav navbar-right">

                              <li class="dropdown">

                                <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false"><i class="fa fa-user"></i>&nbsp;&nbsp;<?=$_SESSION['Myname2012']?>&nbsp;<span class="caret"></span></a>

                                      <ul class="dropdown-menu" role="menu">

                             <li><a href="<?php echo  $abs_url; ?>/user_managebooking.php"><?php echo NEW_BOOKING;?></a></li>
							<li><a href="<?php echo  $abs_url; ?>/user_editAccount.php"><?php echo NEW_PROFILE;?></a></li>
							
							<li class="divider"></li>
							<li><a href="<?php echo  $abs_url; ?>/user_logout.php"><?php echo LOGOUT;?></a></li>
                                      </ul>

                                    </li>

                              <!-- <li><a href="javascript:void(0)"  data-toggle="modal" data-target="#myLogin" class="signin"> <i class="fa fa-sign-in"></i> Sign in</a></li>-->

                            </ul>
							<?php } else{
							 if(isset($_SESSION['password_2012']) && $_SESSION['agent'] == 1) 
							 {?>
                      		 <ul class="nav navbar-right">
                        
                                        <li class="dropdown">
                                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false"><i class="fa fa-user"></i>&nbsp;&nbsp;<?=$_SESSION['Myname2012']?>&nbsp;&nbsp;<span class="caret"></span></a>
                                        
                                    <ul class="dropdown-menu" role="menu">
                                    <li><a href="<?php echo  $abs_url; ?>/agent_managebooking.php"><?php echo NEW_BOOKING;?></a></li>
                                    <li><a href="<?php echo  $abs_url; ?>/agent_editAccount.php"><?php echo NEW_PROFILE;?></a></li>
                                    <li class="divider"></li>
                                    <li><a href="<?php echo  $abs_url; ?>/agent_logout.php"><?php echo LOGOUT;?></a></li>
                                   </ul>
                                    </li>
        
                                      <!-- <li><a href="javascript:void(0)"  data-toggle="modal" data-target="#myLogin" class="signin"> <i class="fa fa-sign-in"></i> Sign in</a></li>-->
                                    
                                    </ul>
							 <?php } else{
							// if(!$_SESSION['password_2012']) 
							 ?>
                       		<ul class="nav navbar-right">

                              <li><a href="javascript:void(0)"  data-toggle="modal" data-target="#myLogin" class="signin"> <i class="fa fa-sign-in"></i>&nbsp;&nbsp;<?php echo NEW_CUSTOMER_LOGIN;?></a></li>

                               <li><a href="javascript:void(0)"  data-toggle="modal" data-target="#myagentLogin" class="signin"> <i class="fa fa-sign-in"></i>&nbsp;&nbsp;<?php echo NEW_AGENT_LOGIN;?></a></li>

                             </ul>  
							 <?php  }}?><?php */?>
                              
             
                      
                       
                       
                       </div>

                    </div>

                </div>

            </div>

        </div>

    </div>

	<div class="container-fluid">

    	<div class="row header-background">

            <div class="container">

            	<div class="row posrel">

                   <div class="col-md-4 col-sm-1  logodiv">

                <!--<a href="index.php" class="logo"><img src="images/demo-logo.png" alt=""/></a>-->
					
					<a href="<?php echo  $abs_url; ?>/index.php" class="logo"><img src="<?php echo  $abs_url; ?>/gallery/portal/<?=$bsiCore->config['conf_portal_logo']?>" alt=""/></a>
					

                   </div>

                   <div class="col-md-8 col-sm-11  navbar-right" style="margin:0px;">

                      
<!-- main menu -->
<div id='cssmenu'>
<ul>

    <?php 

 		$resultMenu = mysql_query("select * from bsi_site_contents where parent_id=0 and status='Y' and header_type='1'");

		if(mysql_num_rows($resultMenu)){

			while($rowMenu = mysql_fetch_assoc($resultMenu)){

				if(trim($rowMenu['url']) == ""){

					echo '<li class="has-sub"><a href="'.$abs_url.'/'.str_replace(" ","-",strtolower(trim($rowMenu['cont_title']))).'-'.$rowMenu['id'].'.html">'.$rowMenu['cont_title'].'</a>';

					$resultSubMenu = mysql_query("select * from bsi_site_contents where parent_id='".$rowMenu['id']."' and status='Y'");

					if(mysql_num_rows($resultSubMenu)){

						echo ' <ul>';

						while($rowSubMenu = mysql_fetch_assoc($resultSubMenu)){

							echo '<li><a href="'.$abs_url.'/'.str_replace(" ","-",strtolower(trim($rowSubMenu['cont_title']))).'-'.$rowSubMenu['id'].'.html">'.$rowSubMenu['cont_title'].'</a></li>';

						}

						echo '</ul>';

					}

					echo '</li>';

				}else{

					echo ' <li><a href="'.$abs_url.'/'.$rowMenu['url'].'" title="Home">'.$rowMenu['cont_title'].'</a>';

					$resultSubMenu = mysql_query("select * from bsi_site_contents where parent_id='".$rowMenu['id']."' and status='Y'");

					$resultSubMenu = mysql_query("select * from bsi_site_contents where parent_id='".$rowMenu['id']."' and status='Y'");

					if(mysql_num_rows($resultSubMenu)){

						echo '<ul>';

						while($rowSubMenu = mysql_fetch_assoc($resultSubMenu)){

							echo '<li><a href="'.$abs_url.'/'.str_replace(" ","-",strtolower(trim($rowSubMenu['cont_title']))).'-'.$rowSubMenu['id'].'.html">'.$rowSubMenu['cont_title'].'</a></li>'; 

						}

						echo '</ul>';

					}

					echo '</li>';

				}

			}

		}

 	?>

    <li><a href='<?php echo  $abs_url; ?>/contactus.php'>Contact</a></li>

    </ul>
</div>

                      

                   </div>

                </div>

            </div>

    	</div>

    </div>
  <script type="text/javascript">
   
   			 //language.......
								 
			 $('.languagedv').on('click', function(e){
				 e.stopPropagation();
				 if($(this).hasClass('lopen')){
					 $('.lan-dropdown').slideUp();
					 $(this).removeClass('lopen');
				 }else{
					 $('.lan-dropdown').slideDown();
					 $('.languagedv').addClass('lopen');
				  }
			 });
			 $('.lan-dropdown ul li').on('click', function(){
				 $('.lan-dropdown ul li').removeClass('lactive');
				 $(this).addClass('lactive');
				 var id = $(this).attr('id');
				 
				 $('.lan-dropdown').slideUp();
				 $('.languagedv').removeClass('lopen');
				 
				 $('.languagedv').children().first().next().html(id);
				 $('.languagedv').children().first().attr('src','images/'+id+'.jpg');
			 });

			 
			 $(document).on('click', function(){
				 $('.lan-dropdown').slideUp();
				 $('.languagedv').removeClass('lopen');
			 }); 

    <!-- Language supports -->
	function changelan(val)
	{
		window.location.href='<?php echo removeQueryStringFromUrl($_SERVER['REQUEST_URI']); ?>?lang='+val;
	}
	
	//language.......
								 
			 $('.currencydv').on('click', function(e){
				 e.stopPropagation();
				 if($(this).hasClass('lopen')){
					 $('.curr-dropdown').slideUp();
					 $(this).removeClass('lopen');
				 }else{
					 $('.curr-dropdown').slideDown();
					 $('.currencydv').addClass('lopen');
				  }
			 });
			 $('.curr-dropdown ul li').on('click', function(){
				 $('.curr-dropdown ul li').removeClass('cactive');
				 $(this).addClass('cactive');
				 var id = $(this).attr('id');
				 
				 $('.curr-dropdown').slideUp();
				 $('.currencydv').removeClass('lopen');
				 
				 $('.currencydv').children().first().next().html(id);
				 
			 });

			 
			 $(document).on('click', function(){
				 $('.curr-dropdown').slideUp();
				 $('.currencydv').removeClass('lopen');
			 }); 
 
function changecurr(val) 
	{
		window.location.href='<?php echo removeQueryStringFromUrl($_SERVER['REQUEST_URI']); ?>?currency='+val;
	}
    <!-- Language supports -->
 	</script>     
