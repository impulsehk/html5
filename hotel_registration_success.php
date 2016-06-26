<?php 
session_start();
include("includes/db.conn.php"); 
include("includes/conf.class.php");
include("includes/language.php");

	if(isset($_SESSION['language'])){
		$htmlCombo=$bsiCore->getbsilanguage($_SESSION['language']);
	}else{
		$htmlCombo=$bsiCore->getbsilanguage(); 
	}

/*if(isset($_REQUEST['page']))
$body_content=mysql_fetch_assoc(mysql_query("select * from bsi_site_contents where id=".$bsiCore->ClearInput($_REQUEST['page'])));
$getBodyContents = $body_content['contents'];
$gettitle=$body_content['cont_title'];*/
		
//$body_content=mysql_fetch_assoc(mysql_query("select * from bsi_site_contents where id=20"));
//$features_hotel=$bsiCore->getFeaturesHotels();


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
<title><?=$bsiCore->config['conf_portal_name']?></title>
</head>

<body>

<header>

<?php include("header.php");?>	

</header>

<div class="container-fluid window-height">
    <div class="row container-background">
        <section class="container">
        	<div class="row">
            <div class="container-fluid">
                <div class="row">
                	<!--<div class="noti">
                        <span>Hotel Shale</span>
                        Get Flat 40% OFF on Hotels. Use Promo Code VIAHOTELS to see the final price
                        <div class="closenoti"></div>
                    </div>-->
                </div>
                
                <div class="row">
                	<div class="container-fluid">
                		<div class="row">
                        	
                            <div class="col-md-12">
                            	
                                <div class="container-fluid">
                					<div class="row mrb20">
                        				<div class="col-md-12 sernbox">
                                             <br />
                                             
                                              <div class="container-fluid">
                                                <div class="row">
                                                    <div class="col-md-12">
                                                    <h2 class="sett4">Your Hotel Listed Successfully  ,  Thanking You </h2>
                                                    </div>
                                                </div>
                                                
                                                <div class="row">
                                                    <div class="col-md-12 cmstext">
                                                    <?php /*?><?=$getBodyContents?><?php */?>
                                                    </div>
                                                </div>
                                                
                                                <!--<div class="row">
                                                    <div class="col-md-6 cmstext">
                                                    Sed ut perspiciatis unde omnis iste natus error sit voluptatem accusantium doloremque laudantium, totam rem aperiam, eaque ipsa quae ab illo inventore veritatis et quasi architecto beatae vitae dicta sunt explicabo. Nemo enim ipsam voluptatem quia voluptas sit aspernatur aut odit aut fugit, sed quia consequuntur magni dolores eos qui ratione voluptatem sequi nesciunt. Neque porro quisquam est, qui dolorem ipsum quia dolor sit amet, consectetur, adipisci velit, sed quia non numquam eius modi tempora incidunt ut labore et dolore magnam aliquam quaerat voluptatem. Ut enim ad minima veniam, quis nostrum exercitationem ullam corporis suscipit laboriosam, nisi ut aliquid ex ea commodi consequatur? Quis autem vel eum iure reprehenderit qui in ea voluptate velit esse quam nihil molestiae consequatur, vel illum qui dolorem eum fugiat quo voluptas nulla pariatur?
                                                    </div>
                                                    <div class="col-md-6 cmstext">
                                                    Sed ut perspiciatis unde omnis iste natus error sit voluptatem accusantium doloremque laudantium, totam rem aperiam, eaque ipsa quae ab illo inventore veritatis et quasi architecto beatae vitae dicta sunt explicabo. Nemo enim ipsam voluptatem quia voluptas sit aspernatur aut odit aut fugit, sed quia consequuntur magni dolores eos qui ratione voluptatem sequi nesciunt. Neque porro quisquam est, qui dolorem ipsum quia dolor sit amet, consectetur, adipisci velit, sed quia non numquam eius modi tempora incidunt ut labore et dolore magnam aliquam quaerat voluptatem. Ut enim ad minima veniam, quis nostrum exercitationem ullam corporis suscipit laboriosam, nisi ut aliquid ex ea commodi consequatur? Quis autem vel eum iure reprehenderit qui in ea voluptate velit esse quam nihil molestiae consequatur, vel illum qui dolorem eum fugiat quo voluptas nulla pariatur?
                                                    </div>
                                                </div>-->
                                                <!--<div class="row">
                                                    <div class="col-md-12 cmstext">
                                                    	<h4>Title</h4>
                                                    </div>
                                                </div>-->
                                                <!--<div class="row">
                                                    <div class="col-md-3 cmstext">
                                                    	Sed ut perspiciatis unde omnis iste natus error sit voluptatem accusantium doloremque laudantium, totam rem aperiam, eaque ipsa quae ab illo inventore veritatis et quasi architecto beatae vitae dicta sunt explicabo. Nemo enim ipsam voluptatem quia voluptas sit aspernatur aut odit aut fugit, sed quia consequuntur magni dolores eos qui ratione voluptatem sequi nesciunt. Neque 
                                                    </div>
                                                    <div class="col-md-3 cmstext">
                                                    	Sed ut perspiciatis unde omnis iste natus error sit voluptatem accusantium doloremque laudantium, totam rem aperiam, eaque ipsa quae ab illo inventore veritatis et quasi architecto beatae vitae dicta sunt explicabo. Nemo enim ipsam voluptatem quia voluptas sit aspernatur aut odit aut fugit, sed quia consequuntur magni dolores eos qui ratione voluptatem sequi nesciunt. Neque 
                                                    </div>
                                                    <div class="col-md-3 cmstext">
                                                    	Sed ut perspiciatis unde omnis iste natus error sit voluptatem accusantium doloremque laudantium, totam rem aperiam, eaque ipsa quae ab illo inventore veritatis et quasi architecto beatae vitae dicta sunt explicabo. Nemo enim ipsam voluptatem quia voluptas sit aspernatur aut odit aut fugit, sed quia consequuntur magni dolores eos qui ratione voluptatem sequi nesciunt. Neque 
                                                    </div>
                                                    <div class="col-md-3 cmstext">
                                                    	Sed ut perspiciatis unde omnis iste natus error sit voluptatem accusantium doloremque laudantium, totam rem aperiam, eaque ipsa quae ab illo inventore veritatis et quasi architecto beatae vitae dicta sunt explicabo. Nemo enim ipsam voluptatem quia voluptas sit aspernatur aut odit aut fugit, sed quia consequuntur magni dolores eos qui ratione voluptatem sequi nesciunt. Neque 
                                                    </div>
                                                </div>-->
                                                <!--<div class="row">
                                                    <div class="col-md-12 cmstext">
                                                    	<h4>List Title</h4>
                                                    </div>
                                                </div>-->
                                                <!--<div class="row">
                                                    <div class="col-md-12">
                                                    	<ul class="cmslist">
                                                        	<li>1. Sed ut perspiciatis unde omnis iste natus error sit voluptatem accusantium doloremque laudantium, totam rem aperiam, eaque ipsa quae ab illo inventore veritatis et quasi architecto beatae vitae dicta sunt explicabo.</li>
                                                            <li>2. asdf</li>
                                                            <li>
                                                            	<ul>
                                                                	<li>2.1 Sed ut perspiciatis unde omnis iste natus error sit voluptatem accusantium doloremque laudantium, totam rem aperiam, eaque ipsa quae ab illo inventore veritatis et quasi architecto beatae vitae dicta sunt explicabo.</li>
                                                                    <li>2.2</li>
                                                                    <li>
                                                                    	<ul>
                                                                            <li>2.2.1</li>
                                                                            <li>2.2.2</li>
                                                                            <li>2.2.3</li>
                                                                        </ul>
                                                                    </li>
                                                                    <li>2.3 Sed ut perspiciatis unde omnis iste natus error sit voluptatem accusantium doloremque laudantium, totam rem aperiam, eaque ipsa quae ab illo inventore veritatis et quasi architecto beatae vitae dicta sunt explicabo.</li>
                                                                </ul>
                                                            </li>
                                                            <li>3. Sed ut perspiciatis unde omnis iste natus error sit voluptatem accusantium doloremque laudantium, totam rem aperiam, eaque ipsa quae ab illo inventore veritatis et quasi architecto beatae vitae dicta sunt explicabo.</li>
                                                        </ul>
                                                    </div>
                                                </div>-->
                                                
                                                
                                                
                                                
                                              </div>
                                             <br />
                                             <br />
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

<!--<script src="js/jquery.min.js"></script>-->
<script src="http://code.jquery.com/ui/1.11.2/jquery-ui.js"></script>

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
                    	<div class="col-md-12 derror" id="error"> 
                        </div>
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
                            <div class="col-sm-offset-2 col-sm-10">
                             
                            </div>
                          </div>
                          <div class="form-group">
                            <div class="col-sm-offset-2 col-sm-10">
                            <br />
							   <input type="submit" class="form-control searchbtn logbtn" value="<?php echo NEW_LOGIN;?>" id="submit_login" name="submit_login" >
                              <a href="javascript:void(0)" data-toggle="modal" data-target="#forpass" data-dismiss="modal" class="forpass"><?php echo NEW_FORGET_PASSWORD?></a>
                            </div>
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
                    	<div class="col-md-12 derror" id="errorforget">
                        </div>
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
                            <div class="col-sm-offset-2 col-sm-10">
                            <br />
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
                    	<div class="col-md-12 derror" id="agenterror"> 
                        
                        </div>
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
                            <div class="col-sm-offset-2 col-sm-10">
                            </div>
                          </div>
                          <div class="form-group">
                            <div class="col-sm-offset-2 col-sm-10">
                            <br />
							   <input type="submit" class="form-control searchbtn logbtn" value="<?php echo NEW_LOGIN;?>" id="submit_agentlogin" name="submit_agentlogin" >
                              <a href="javascript:void(0)" data-toggle="modal" data-target="#agentforpass" data-dismiss="modal" class="forpass"><?php echo NEW_FORGET_PASSWORD?></a>
                            </div>
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
                    	<div class="col-md-12 derror" id="agenterrorforget">
					</div>
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
                            <div class="col-sm-offset-2 col-sm-10">
                            <br />
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


<!--<script src="js/jquery.min.js"></script>-->
<!-- Latest compiled and minified JavaScript -->
<script src="js/bootstrap.js"></script>


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
		
		$('.chekrow').on('click',function(){
			var id = $(this).attr('id');
			$('.rw1').removeClass('rw1bg');
			$('input.radiocheckbox').attr('checked', false);
			$('input.radiocheckbox').prop('checked', false);
				
			if($(this).hasClass('openrow')){
				$(this).removeClass('openrow');
				$(this).children().first().removeClass('rw1bg');
				$('#'+id+'-box').slideUp();
			}else{
				$('.chekrow').removeClass('openrow');
				$(this).addClass('openrow');
				$(this).children().first().addClass('rw1bg');
				$(this).children('input.radiocheckbox').attr('checked', true);
				$(this).children('input.radiocheckbox').prop('checked', true);
				$('.formcontainer').slideUp();
				$('#'+id+'-box').slideDown();
			}
		});
		
	});
</script>
<script type="text/javascript">
    $(document).ready(function() {
		if($('.window-height').innerHeight()+400>$(window).height()){
		    $('.footer-bg').css({'position':'relative'});
	      }else{
		    $('.footer-bg').css({'position':'absolute', 'bottom':0, 'left':0});
	      }
	});
	$(window).resize(function(){
	  if($('.window-height').innerHeight()+400>$(window).height()){
		  $('.footer-bg').css({'position':'relative'});
	  }else{
		  $('.footer-bg').css({'position':'absolute', 'bottom':0, 'left':0});
	  }
  });
</script>

<script type="text/javascript">
	$(document).ready(function() {
	
	$("#submit_login").click(function(){
	var querystr = 'actioncode=12&email='+$('#inputEmail3').val()+'&password='+$('#inputPassword3').val();
	//alert(querystr) 
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
	//alert(querystr) 
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
	//alert(querystr);die;
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
	//alert(querystr) 
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

</body>
</html>