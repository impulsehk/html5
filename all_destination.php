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
	$cityHtml = $bsiCore->getCitynameHtml();
	if(isset($_SESSION['availabilityByRoomTypeFinal'])){
		unset($_SESSION['availabilityByRoomTypeFinal']);	
	}
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

<link rel="stylesheet" href="https://code.jquery.com/ui/1.11.2/themes/smoothness/jquery-ui.css">

<link rel="stylesheet" href="css/page-theme.css">
<link rel="stylesheet" href="js/cssmenu/styles.css">
<script src="js/jquery.min.js"></script>
<script src="js/cssmenu/script.js"></script>
<script type="text/javascript" src="js/jquery.easing.1.3.js"></script>
<script src="src/jquery.anyslider.js"></script>
<script src="js/bootstrap.js"></script>
<script src="js/moment-with-locales.js"></script>
<script type="text/javascript" src="js/bootstrap-datepicker.js"></script>
<title><?=$bsiCore->config['conf_portal_name']?> : all destination</title>

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
                        	
                            
                            <?=$cityHtml?>
                           
                            
                            
                          
                            
                            
                        </div>
                    </div>
                </div>
                
            </div>
            </div>
        </section>
	</div>
</div>

<script src="js/jquery.min.js"></script>
<script src="http://code.jquery.com/ui/1.11.2/jquery-ui.js"></script>

<?php include("footer.php");?>

<!-- Modal Login -->
<div class="modal fade" id="myLogin" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            <h4 class="modal-title" id="myModalLabel">Login</h4>
          </div>
          <div class="modal-body">
           		<div class="container-fluid">
                	<div class="row">
                    	<div class="col-md-12 derror" id="error"> 
                        	<!--Email is not exist-->
                        </div>
                    </div>
                    <div class="row">
                       <div class="col-md-12">
                      <!--<form class="form-horizontal" action="agent_managebooking.html" method="post" >-->
					   <input value="login" id="account_selection" name="account_selection" type="hidden" >
                          <div class="form-group">
                            <label for="inputEmail3" class="col-sm-2 control-label">Email</label>
                            <div class="col-sm-10">
                              <!--<input type="email" class="form-control" id="inputEmail3" placeholder="Email">-->
							  <input type="email" class="form-control" id="inputEmail3" placeholder="Email" name="inputEmail3" >
                            </div>
                          </div>
						  <br>
						  <br>
                          <div class="form-group">
                            <label for="inputPassword3" class="col-sm-2 control-label">Password</label>
                            <div class="col-sm-10">
                             <!-- <input type="password" class="form-control" id="inputPassword3" placeholder="Password">-->
							   <input type="password" class="form-control" id="inputPassword3" placeholder="Password" name="inputPassword3" > 
                            </div>
                          </div>
						  
                          <div class="form-group">
                            <div class="col-sm-offset-2 col-sm-10">
                              <!--<div class="checkbox">
                                <label>
                                  <input type="checkbox"> Remember me
                                </label>
                              </div>-->
                            </div>
                          </div>
                          <div class="form-group">
                            <div class="col-sm-offset-2 col-sm-10">
                            <br />
                              <!--<input type="submit" class="form-control searchbtn logbtn" value="Login">-->
							   <input type="submit" class="form-control searchbtn logbtn" value="Login" id="submit_login" name="submit_login" >
                              <a href="javascript:void(0)" data-toggle="modal" data-target="#forpass" data-dismiss="modal" class="forpass">Forgot Password</a>
                            </div>
                          </div>
                    <!--</form>-->
                       
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
            <h4 class="modal-title" id="myModalLabel">Forget Password</h4>
          </div>
          <div class="modal-body">
           		<div class="container-fluid">
                	<div class="row">
                    	<div class="col-md-12 derror" id="errorforget">
                        	<!--Email is not exist-->
                        </div>
                    </div>
                    <div class="row">
                       <div class="col-md-12">
                      <!--<form class="form-horizontal" action="agent_managebooking.html" method="post" >-->
					  <input value="forget" id="account_selection" name="account_selection" type="hidden" >
                          <div class="form-group">
                            <label for="inputEmail3" class="col-sm-2 control-label">Email</label>
                            <div class="col-sm-10">
                             <!-- <input type="email" class="form-control" id="inputEmail3" placeholder="Email">-->
							  <input type="email" class="form-control" id="inputEmailforget" placeholder="Email" name="inputEmailforget">
                            </div>
                          </div>
                          <div class="form-group">
                            <div class="col-sm-offset-2 col-sm-10">
                            <br />
                             <!-- <input type="submit" class="form-control searchbtn logbtn" value="Send">-->
							   <input type="submit" class="form-control searchbtn logbtn" value="Send" id="submit_forget" name="submit_forget">
                            </div>
                          </div>
                   <!-- </form>-->
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
            <h4 class="modal-title" id="myModalLabel">Agent Login</h4>
          </div>
          <div class="modal-body">
           		<div class="container-fluid">
                	<div class="row">
                    	<div class="col-md-12 derror" id="agenterror"> 
                        	<!--Email is not exist-->
                        </div>
                    </div>
                    <div class="row">
                       <div class="col-md-12">
                      <!--<form class="form-horizontal" action="agent_managebooking.html" method="post" >-->
					   <input value="login" id="account_selection" name="account_selection" type="hidden" >
                          <div class="form-group">
                            <label for="inputEmail3" class="col-sm-2 control-label">Email</label>
                            <div class="col-sm-10">
                              <!--<input type="email" class="form-control" id="inputEmail3" placeholder="Email">-->
							  <input type="email" class="form-control" id="agentinputEmail3" placeholder="Email" name="agentinputEmail3" >
                            </div>
                          </div>
						  <br>
						  <br>
                          <div class="form-group">
                            <label for="inputPassword3" class="col-sm-2 control-label">Password</label>
                            <div class="col-sm-10">
                             <!-- <input type="password" class="form-control" id="inputPassword3" placeholder="Password">-->
							   <input type="password" class="form-control" id="agentinputPassword3" placeholder="Password" name="agentinputPassword3" > 
                            </div>
                          </div>
						  
                          <div class="form-group">
                            <div class="col-sm-offset-2 col-sm-10">
                              <!--<div class="checkbox">
                                <label>
                                  <input type="checkbox"> Remember me
                                </label>
                              </div>-->
                            </div>
                          </div>
                          <div class="form-group">
                            <div class="col-sm-offset-2 col-sm-10">
                            <br />
                              <!--<input type="submit" class="form-control searchbtn logbtn" value="Login">-->
							   <input type="submit" class="form-control searchbtn logbtn" value="Login" id="submit_agentlogin" name="submit_agentlogin" >
                              <a href="javascript:void(0)" data-toggle="modal" data-target="#agentforpass" data-dismiss="modal" class="forpass">Forgot Password</a>
                            </div>
                          </div>
                    <!--</form>-->
                       
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
            <h4 class="modal-title" id="myModalLabel">Agent Forget Password</h4>
          </div>
          <div class="modal-body">
           		<div class="container-fluid">
                	<div class="row">
                    	<div class="col-md-12 derror" id="agenterrorforget">
                        	<!--Email is not exist-->
                        </div>
                    </div>
                    <div class="row">
                       <div class="col-md-12">
                      <!--<form class="form-horizontal" action="agent_managebooking.html" method="post" >-->
					  <input value="forget" id="account_selection" name="account_selection" type="hidden" >
                          <div class="form-group">
                            <label for="inputEmail3" class="col-sm-2 control-label">Email</label>
                            <div class="col-sm-10">
                             <!-- <input type="email" class="form-control" id="inputEmail3" placeholder="Email">-->
							  <input type="email" class="form-control" id="inputagentEmailforget" placeholder="Email" name="inputagentEmailforget">
                            </div>
                          </div>
                          <div class="form-group">
                            <div class="col-sm-offset-2 col-sm-10">
                            <br />
                             <!-- <input type="submit" class="form-control searchbtn logbtn" value="Send">-->
							   <input type="submit" class="form-control searchbtn logbtn" value="Send" id="submit_agentforget" name="submit_agentforget">
                            </div>
                          </div>
                   <!-- </form>-->
                       </div>
                    </div>
                </div>
          </div>
    </div>
  </div>
</div>




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


<script src="http://code.jquery.com/ui/1.11.2/jquery-ui.js"></script>
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
				$('#error').html('Emailid or Password does not matched.');
				//alert('Emailid or Password does not matched.');	
				}
			}, "json");
	});
	
	
	$("#submit_forget").click(function(){
	var querystr = 'actioncode=13&email='+$('#inputEmailforget').val();
	//alert(querystr) 
	$.post("ajax-processor.php", querystr, function(data){						 
				if(data.errorcode == 0){
				$('#errorforget').html('<p> Password has been Successfully Reset. Please Check Your Email...</p>');
					//$(location).attr('href', 'cuenta.php?submenuheader=0');
				}else{
				$('#errorforget').html(' Email  does not exists.');
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
				$('#agenterror').html('Emailid or Password does not matched.');
				//alert('Emailid or Password does not matched.');	
				}
			}, "json");
	});
	
	
	$("#submit_agentforget").click(function(){
	var querystr = 'actioncode=16&email='+$('#inputagentEmailforget').val();
	//alert(querystr) 
	$.post("ajax-processor.php", querystr, function(data){						 
				if(data.errorcode == 0){
				$('#agenterrorforget').html('<p> Password has been Successfully Reset. Please Check Your Email...</p>');
					//$(location).attr('href', 'cuenta.php?submenuheader=0');
				}else{
				$('#agenterrorforget').html(' Email  does not exists.');
				//alert('Emailid or Password does not matched.');	
				}
			}, "json");
	});
	
	
	});
</script>



<!-- Latest compiled and minified JavaScript -->
<!--<script src="js/bootstrap.js"></script>
<script src="js/cssmenu/script.js"></script>-->
</body>
</html>
