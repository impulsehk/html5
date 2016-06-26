<?php
session_start();
if(isset($_POST['submit'])){
	include("includes/db.conn.php");
	include("includes/conf.class.php");
	include("includes/admin.class.php");
	include("includes/mail.class.php");
	$bsimail=new bsiMail();
	$bsiAdminMain->hotel_addedit_entry($front=true);
	header('Location:hotel_registration_success.php');
	exit;
}
include("includes/db.conn.php");
include("includes/conf.class.php");
include("includes/admin.class.php");
include("includes/language.php");
if(isset($_SESSION['language'])){
	$htmlCombo=$bsiCore->getbsilanguage($_SESSION['language']);
}else{
	$htmlCombo=$bsiCore->getbsilanguage(); 
}
$getCountry   = $bsiAdminMain->getCountrydropdown("IN");
$star_rating  = $bsiAdminMain->star_rating(0);
$petsallowed  = $bsiAdminMain->pets_status(0);
$hotel_status = $bsiAdminMain->status(0);
//$body_content=mysql_fetch_assoc(mysql_query("select * from bsi_site_contents where id=20"));
//$features_hotel=$bsiCore->getFeaturesHotels();
$cname=0;
global $bsiCore; 
?>

<!doctype html>
<html>
<head><meta http-equiv="Content-Type" content="text/html; charset=windows-1252">

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
<title><?=$bsiCore->config['conf_portal_name']?> : Hotel Registration </title>
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
                    	
                    
                		<div class="row" style="margin-top:20px;">
                        	
                            <div class="col-md-12">
                                <div class="container-fluid">
                					<div class="row">
                        				<div class="col-md-12 sernbox">
                                             <div class="container-fluid">
                                                <div class="row">
                                                    <div class="col-md-12">
<br />
<h2 class="sett4">Hotel Registration</h2>
<br />
<form name="hotelDetails-entry" id="hotelDetails-entry" method="post" action="<?=$_SERVER['PHP_SELF']?>" enctype="multipart/form-data" >
<input type="hidden"  name="hotel_id" value="0" />
<div class="container-fluid">

				<div class="row">
                  	  <div class="col-md-6">
                      	<label class="chkdate col-md-4" for=""><?php echo HOTEL_NAME;?><span class="strred">*</span></label>
                      	<div class="form-group col-md-8">
                               <input type="text" id="hotel_name" class="form-control roundcorner" value="" name="hotel_name" />
                        </div>
                      </div>
                      <div class="col-md-6">
                      	<label class="chkdate col-md-4" for=""><?php echo HOTEL_IMAGE;?> <span class="strred">*</span></label>
                      	<div class="form-group col-md-8">
                              <input type="file" name="default_img" id="default_img" class="" value=""/>
                        </div>
                      </div>
                </div>
                <div class="row">
                  	  <div class="col-md-6">
                      	<label class="chkdate col-md-4" for=""><?php echo ADDRESS_FIRST;?><span class="strred">*</span></label>
                      	<div class="form-group col-md-8">
                              <input type="text" id="address_1" class="form-control roundcorner" value="" name="address_1"/>
                        </div>
                      </div>
                      <div class="col-md-6">
                      	<label class="chkdate col-md-4" for=""><?php echo ADDRESS_SECOND;?><span class="strred">*</span></label>
                      	<div class="form-group col-md-8">
                              <input type="text" id="address_2" class="form-control roundcorner" value="" name="address_2" />
                        </div>
                      </div>
                </div>
				
				
				<div class="row">
                  	  <div class="col-md-6">
					  <label class="chkdate col-md-4" for=""><?php echo STATE;?> <span class="strred">*</span></label>
                      	<div class="form-group col-md-8">
							    <input type="text" id="state" class="form-control roundcorner" value="" name="state" />
                        </div>
                      </div>
					  
                      <div class="col-md-6">
                      	<label class="chkdate col-md-4" for=""><?php echo POSTAL_CODE;?> <span class="strred">*</span></label>
                      	<div class="form-group col-md-8">
                              <input name="post_code" id="post_code" value="" class="form-control roundcorner">
                        </div>
                      </div>
                </div>
                
                <div class="row">
                  	  <div class="col-md-6">
					  <label class="chkdate col-md-4" for=""><?php echo COUNTRY;?><span class="strred">*</span></label>
                      	<div class="form-group col-md-8">
                              <!--<input type="text" class="form-control roundcorner">-->
							  <select name="country_code" id="country_code" class="form-control roundcorner">
                    <?=$getCountry?>
                  </select>
							  
                        </div>
                      </div>
                      <div class="col-md-6">
					  <label class="chkdate col-md-4" for=""><?php echo CITY;?> <span class="strred">*</span></label>
                      	
                      	<div class="form-group col-md-8">
                               <select class="form-control roundcorner"  id="city_name" name="city_name">
                              	<!--<option>Kolkata</option>-->
                            </select>
                        </div>
                      </div>
                </div>
                
                
                <div class="row">
                  	  <div class="col-md-6">
                      	<label class="chkdate col-md-4" for=""><?php echo EMAIL_ID;?><span class="strred">*</span></label>
                      	<div class="form-group col-md-8">
                              <input type="text" id="email_addr" class="form-control roundcorner" value="" name="email_addr"/>
                        </div>
                      </div>
                      <div class="col-md-6">
					  	<label class="chkdate col-md-4" for=""><?php echo PASSWORD;?>  <span class="strred">*</span></label>
                      	
                      	<div class="form-group col-md-8">
                            <input type="password" id="password" class="form-control roundcorner" value="" name="password" />
                        </div>
                      </div>
                </div>
                <div class="row">
                  	  <div class="col-md-6">
                      	<label class="chkdate col-md-4" for=""><?php echo PHONE_NUMBER;?> <span class="strred">*</span></label>
                      	<div class="form-group col-md-8">
                              <input type="text" name="phone_number" id="phone_number" class="form-control roundcorner" value=""/>
                        </div>
                      </div>
                      <div class="col-md-6">
                      	<label class="chkdate col-md-4" for=""><?php echo FAX_NUMBER;?></label>
                      	<div class="form-group col-md-8">
                            <input type="text" name="fax_number" id="fax_number" class="form-control roundcorner" value=""/>
                        </div>
                      </div>
                </div>
				
				
				<div class="row">
                  	  <div class="col-md-6">
                      	<label class="chkdate col-md-4" for=""><?php echo STAR_RATING;?> <span class="strred">*</span></label>
                      	<div class="form-group col-md-8">
                              <select name="star_rating" id="star_rating" class="form-control roundcorner">
							  <option value="">select</option>
							  <option value="1">1</option>
							  <option value="2">2</option>
							  <option value="3">3</option>
							  <option value="4">4</option>
							  <option value="5">5</option>
							 </select>
                        </div>
                      </div>
					  
					  <div class="col-md-6">
                      	<label class="chkdate col-md-4" for="">Pets Allowed <span class="strred">*</span></label>
                      	<div class="form-group col-md-8">
                              <select name="pets_status" id="pets_status" class="form-control roundcorner">
							  <option value="0" selected="selected">No</option>
							  <option value="1">Yes</option>
							  </select>
                        </div>
                      </div>
					  
                      
                </div>
				
                <div class="row">
                  	  <div class="col-md-6">
                      	<label class="chkdate col-md-4" for=""><?php echo SHORT_DESCRIPTION;?><span class="strred">*</span></label>
                      	<div class="form-group col-md-8">
                             <textarea name="desc_short" id="desc_short"  class="form-control roundcorner">
</textarea>
                        </div>
                      </div>
                      <div class="col-md-6">
                      	<label class="chkdate col-md-4" for=""><?php echo LONG_DESCRIPTION;?> <span class="strred">*</span></label>
                      	<div class="form-group col-md-8">
                              <textarea name="desc_long" id="desc_long"  class="form-control roundcorner">
</textarea>
                        </div>
                      </div>
                </div>
                
                <div class="row">
                  	  <div class="col-md-6">
                      	<label class="chkdate col-md-4" for=""><?php echo CHECKIN_TIME;?><span class="strred">*</span></label>
                      	<div class="form-group col-md-8">
                              <input type="text"  id="checking_hour" name="checking_hour" value=""  class="form-control roundcorner">
                        </div>
                      </div>
                      <div class="col-md-6">
                      	<label class="chkdate col-md-4" for=""><?php echo CHECKOUT_TIME;?>  <span class="strred">*</span></label>
                      	<div class="form-group col-md-8">
                             <input type="text"  id="checkout_hour" name="checkout_hour" value=""  class="form-control roundcorner">
                        </div>
                      </div>
                </div>

				<div class="row">
				
				
                  	 <!-- <div class="col-md-6">
                      	<label class="chkdate col-md-4" for="">Cancellation Before <span class="strred">*</span></label>
                      	<div class="form-group col-md-6">
                                <input type="text"  id="cancellation_before" name="cancellation_before" value=""  class="form-control roundcorner">
                        </div>
						<label class="chkdate col-md-2" for="">days</label>
                      </div>-->
					  
					  
                      <div class="col-md-6">
                      	<label class="chkdate col-md-4" for=""><?php echo TERMS_CONDITION;?>  <span class="strred">*</span></label>
                      	<div class="form-group col-md-8">
                             <input type="text"  id="checkout_hour" name="checkout_hour" value=""  class="form-control roundcorner">
                        </div>
                      </div>
                </div>
				
				
				
				<!--<div class="row">
                  	  <div class="col-md-6">
                      	<label class="chkdate col-md-4" for="">Cancelation Before <span class="strred">*</span></label>
                      	<div class="form-group col-md-6">
                                <input type="text"  id="checkout_hour" name="checkout_hour" value=""  class="form-control roundcorner">
								
                        </div>
						<label class="chkdate col-md-2" for="">days</label>
                      </div>
                     <div class="col-md-6">
                      	<label class="chkdate col-md-4" for="">Terms & Conditions   <span class="strred">*</span></label>
                      	<div class="form-group col-md-8">
                              <textarea name="terms_n_cond" id="terms_n_cond"  class="form-control roundcorner">
</textarea>
                        </div>
                      </div>
                </div>-->
                
                <div class="row">
                  	  <div class="col-md-6 col-md-offset-3">
                      	<label class="chkdate col-md-4" for="">&nbsp;</label>
                      	<div class="form-group col-md-8">
                      	<!--<input type="hidden" name="state" value="" />-->
                             <input type="hidden" name="status" value="0" />
                <input type="submit" name="submit" id="submit" value="<?php echo SAVE;?>" class="form-control searchbtn"/>
                        </div>
                      </div>
                      
                </div>

</form>
               
                  
                  
                  <br />
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

<script src="js/jquery.min.js"></script>
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


<script type="text/javascript">

$(document).ready(function(){
		//update client profile
		
		if($("#country_code").val() != ' '){
			   generateCity();
		  }
		$("#country_code").change(function(){
			  generateCity();
			
			});
			
			function generateCity(){ 
				var querystr = 'actioncode=15&country_code='+$('#country_code').val();
				//alert(querystr);
				$.post("ajax-processor.php", querystr, function(data)
				 // $.post("../admin/admin_ajax_processor.php", querystr, function(data)
				  {
					  
					    if(data.errorcode == 0){
							//alert(data.strmsg);
							$('#city_name').html(data.strmsg);
						}
				    }, "json");		
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

<script type="text/javascript">

	$(document).ready(function() {

	$("#submit").click(function(){
		
	if($("#hotel_name").val()=="" ){
	alert("Please Enter Hotel Name ");
							 return false;
							}
							else if($("#address_1").val()=="" ){
							alert("Please  Enter Address");
							 return false;
							}							
							else if($("#address_2").val()=="" ){
							alert("Please  Enter Address");
							 return false;
							}							
							else if($("#state").val()=="" ){
							alert("Please  Enter State");
							 return false;
							}							
							else if($("#post_code").val()=="" ){
							alert("Please  Enter PostCode");
							 return false;
							}
							else if($("#email_addr").val()=="" ){
							alert("Please  Enter Email-id");
							 return false;
							}
							else if($("#password").val()=="" ){
							alert("Please  Enter password");
							 return false;
							}
							else if($("#phone_number").val()=="" ){
							alert("Please  Enter Phone Number");
							 return false;
							}
							else if($("#star_rating").val()=="" ){
							alert("Please  Enter Star Rating");
							 return false;
							}
							else if($("#desc_short").val()=="" ){
							alert("Please  Enter Short Description ");
							 return false;
							}							
							else if($("#desc_long").val()=="" ){
							alert("Please  Enter Long Description");
							 return false;
							}
							else if($("#checking_hour").val()=="" ){
							alert("Please  Enter Check In Time ");
							 return false;
							}
							else if($("#checkout_hour").val()=="" ){
							alert("Please  Enter Check Out Time ");
							 return false;
							}
							else if($("#cancellation_before").val()=="" ){
							alert("Please  Enter Cancellation Before Field ");
							 return false;
							}
							else if($("#terms_n_cond").val()=="" ){
							alert("Please  Enter Term & Condition ");
							 return false;
							}
						else{
								return true;
								}
	});
	});
</script>


</body>
</html>