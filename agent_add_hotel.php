<?php
include("access.php");
if(isset($_POST['submit'])){
	include("includes/db.conn.php");
	include("includes/conf.class.php");
	include("includes/admin.class.php");
	include("includes/mail.class.php");
	$bsiAdminMain->hotel_addedit_entry($front=true);
	header('Location:agenthotel_list.php');
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
$cname=0;
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
<title><?=$bsiCore->config['conf_portal_name']?> : Agent Add Hotel</title>
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
                            				<h2 class="sett3"><span><?=HI?>, <?=$_SESSION['Myname2012']?></span><?=MY_ACCOUNT_MY_BOOKINGS?></h2>
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
                                              <li class="list-group-item"><a href="agent_managebooking.php"><?=MANAGE_MY_BOOKINGS?> » </a></li>
                                                <li class="list-group-item"><a href="agent_editAccount.php"><?=UPDATE_UR_PROFILE?> » </a></li>
												<li class="list-group-item active"><a href="agenthotel_list.php"><?=NEW_ADD_NEW_HOTEL?> »  </a></li>
                                                <li class="list-group-item"><a href="agent_changepass.php"><?=CHANGE_PASSWORD?> » </a></li>
												<li class="list-group-item"><a href="agent_logout.php"><?=LOG_OUT?> </a></li>
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
                                                <div class="row">
                                                    <div class="col-md-12">
<br />
<h2 class="sett4"><?php echo NEW_HOTEL_ADD;?></h2>
<br />
<form name="hotelDetails-entry" id="hotelDetails-entry" method="post" action="<?=$_SERVER['PHP_SELF']?>" enctype="multipart/form-data" >
<input type="hidden"  name="hotel_id" value="0" />
<input type="hidden"  name="agent_id" value="<?php echo $_SESSION['client_id2012'];?>" />
<div class="container-fluid">
                  <div class="row">
                  	  <div class="col-md-4">
                          <div class="form-group ">
                              <label class="chkdate" for="exampleInputEmail1"><?php echo HOTEL_NAME;?><span class="strred">*</span></label>
                          </div>
                      </div>
                      <div class="col-md-8">
                          <div class="form-group ">
                              <input type="text" id="hotel_name" class="form-control roundcorner" value="" name="hotel_name" />
                          </div>
                      </div>
                  </div>
                  <div class="row">
                      <div class="col-md-4">
                          <div class="form-group ">
                              <label class="chkdate" for="exampleInputEmail1"><?php echo ADDRESS_FIRST;?><span class="strred">*</span></label>
                            </div>
                      </div>
                      <div class="col-md-8">
                          <div class="form-group ">
                              <input type="text" id="address_1" class="form-control roundcorner" value="" name="address_1"/>
                            </div>
                      </div>
                  </div>
                  <div class="row">
                      <div class="col-md-4">
                          <div class="form-group ">
                              <label class="chkdate" for="exampleInputEmail1"><?php echo ADDRESS_SECOND;?><span class="strred">*</span></label>
                            </div>
                      </div>
                      <div class="col-md-8">
                          <div class="form-group ">
                             <input type="text" id="address_2" class="form-control roundcorner" value="" name="address_2" />
                            </div>
                      </div>
                  </div>  
                  <div class="row">
                      <div class="col-md-4">
                          <div class="form-group">
                              <label class="chkdate" for="exampleInputEmail1"><?php echo POSTAL_CODE;?><span class="strred">*</span></label>
                            </div>
                      </div>
                      <div class="col-md-8">
                          <div class="form-group">
                              <input name="post_code" id="post_code" value="" class="form-control roundcorner">
                            </div>
                      </div>
                  </div> 
                  
                  <div class="row">
                      <div class="col-md-4">
                          <div class="form-group">
                              <label class="chkdate" for="exampleInputEmail1"><?php echo COUNTRY;?><span class="strred">*</span></label>
                            </div>
                      </div>
                      <div class="col-md-8">
                          <div class="form-group">
                             <select name="country_code" id="country_code" class="form-control roundcorner">
                    <?=$getCountry?>
                  </select>
                            </div>
                      </div>
                  </div> 
				  
				  <div class="row">
                      <div class="col-md-4">
                          <div class="form-group ">
                              <label class="chkdate" for="exampleInputEmail1"><?php echo STATE;?><span class="strred">*</span></label>
                            </div>
                      </div>
                      <div class="col-md-8">
                          <div class="form-group ">
                              <!--<input type="text" class="form-control roundcorner">-->
							  <input type="text" id="state" class="form-control roundcorner" value="" name="state" />
                            </div>
                      </div>
                  </div>
				  
                  <div class="row">
                      <div class="col-md-4">
                          <div class="form-group">
                              <label class="chkdate" for="exampleInputEmail1"><?php echo CITY;?><span class="strred">*</span></label>
                            </div>
                      </div>
                      <div class="col-md-8">
                          <div class="form-group">
                             <select class="form-control roundcorner"  id="city_name" name="city_name">
                            </select>
                            </div>
                      </div>
                  </div>
                  <div class="row">
                      <div class="col-md-4">
                          <div class="form-group">
                              <label class="chkdate" for="exampleInputEmail1"><?php echo EMAIL_ID;?><span class="strred">*</span></label>
                            </div>
                      </div>
                      <div class="col-md-8">
                          <div class="form-group">
                              <input type="text" id="email_addr" class="form-control roundcorner" value="" name="email_addr"/>
                            </div>
                      </div>
                  </div> 
                  <div class="row">
                      <div class="col-md-4">
                          <div class="form-group">
                              <label class="chkdate" for="exampleInputEmail1"><?php echo PASSWORD;?><span class="strred">*</span></label>
                            </div>
                      </div>
                      <div class="col-md-8">
                          <div class="form-group">
                             <input type="password" id="password" class="form-control roundcorner" value="" name="password" />
                            </div>
                      </div>
                  </div>
                  <div class="row">
                      <div class="col-md-4">
                          <div class="form-group">
                              <label class="chkdate" for="exampleInputEmail1"><?php echo HOTEL_IMAGE;?><span class="strred">*</span></label>
                            </div>
                      </div>
                      <div class="col-md-8">
                          <div class="form-group">
                              <input type="file" name="default_img" id="default_img" class="" value=""/>
                            </div>
                      </div>
                  </div>
                  <div class="row">
                      <div class="col-md-4">
                          <div class="form-group">
                              <label class="chkdate" for="exampleInputEmail1"><?php echo STAR_RATING;?><span class="strred">*</span></label>
                            </div>
                      </div>
                      <div class="col-md-8">
                          <div class="form-group">
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
                  </div>
                  
                  <div class="row">
                      <div class="col-md-4">
                          <div class="form-group">
                              <label class="chkdate" for="exampleInputEmail1"><?php echo PHONE_NUMBER;?> <span class="strred">*</span></label>
                            </div>
                      </div>
                      <div class="col-md-8">
                          <div class="form-group">
                               <input type="text" name="phone_number" id="phone_number" class="form-control roundcorner" value=""/>
                            </div>
                      </div>
                  </div>
                  <div class="row">
                      <div class="col-md-4">
                          <div class="form-group">
                              <label class="chkdate" for="exampleInputEmail1"><?php echo FAX_NUMBER;?></label>
                            </div>
                      </div>
                      <div class="col-md-8">
                          <div class="form-group">
                               <input type="text" name="fax_number" id="fax_number" class="form-control roundcorner" value=""/>
                            </div>
                      </div>
                  </div>
                  <div class="row">
                      <div class="col-md-4">
                          <div class="form-group">
                              <label class="chkdate" for="exampleInputEmail1"><?php echo SHORT_DESCRIPTION;?><span class="strred">*</span></label>
                            </div>
                      </div>
                      <div class="col-md-8">
                          <div class="form-group">
                          	<textarea name="desc_short" id="desc_short"  class="form-control roundcorner">
</textarea>
                            </div>
                      </div>
                  </div>
                  <div class="row">
                      <div class="col-md-4">
                          <div class="form-group">
                              <label class="chkdate" for="exampleInputEmail1"><?php echo LONG_DESCRIPTION;?><span class="strred">*</span></label>
                            </div>
                      </div>
                      <div class="col-md-8">
                          <div class="form-group">
                          	<textarea name="desc_long" id="desc_long"  class="form-control roundcorner">
</textarea>
                            </div>
                      </div>
                  </div>
                  
                  <div class="row">
                      <div class="col-md-4">
                          <div class="form-group">
                              <label class="chkdate" for="exampleInputEmail1"><?php echo CHECKIN_TIME;?><span class="strred">*</span></label>
                            </div>
                      </div>
                      <div class="col-md-8" style="padding-bottom:15px;">
                          <div class="form-group">
                              <input type="text"  id="checking_hour" name="checking_hour" value=""  class="form-control roundcorner">
                            </div>
                      </div>
                  </div>
                  <div class="row">
                      <div class="col-md-4">
                          <div class="form-group">
                              <label class="chkdate" for="exampleInputEmail1"><?php echo CHECKOUT_TIME;?><span class="strred">*</span></label>
                            </div>
                      </div>
                      <div class="col-md-8" style="padding-bottom:15px;">
                          <div class="form-group">
                              <input type="text"  id="checkout_hour" name="checkout_hour" value=""  class="form-control roundcorner">
                            </div>
                      </div>
                  </div>
                  <div class="row">
                      <div class="col-md-4">
                          <div class="form-group">
                              <label class="chkdate" for="exampleInputEmail1"><?php echo PETS_ALLOWED;?></label>
                            </div>
                      </div>
                      <div class="col-md-8">
                          <div class="form-group">
                              <select name="pets_status" id="pets_status" class="form-control roundcorner">
							  <option value="0" selected="selected">No</option>
							  <option value="1">Yes</option>
							  </select>
                            </div>
                      </div>
                  </div>
                  <div class="row">
                      <div class="col-md-4">
                          <div class="form-group">
                              <label class="chkdate" for="exampleInputEmail1"><?php echo TERMS_CONDITION;?> <span class="strred">*</span></label>
                            </div>
                      </div>
                      <div class="col-md-8">
                          <div class="form-group">
                          	<textarea name="terms_n_cond" id="terms_n_cond"  class="form-control roundcorner">
</textarea>
                            </div>
                      </div>
                  </div>
    	
   	
   	
   	
               
                  
                  <div class="row">
                  		<div class="col-md-4"></div>
                      <div class="col-md-8">
                          <div class="form-group">
                              <input type="hidden" name="status" value="0" />
                <input type="submit" name="submit" id="submit" value="<?php echo SAVE;?>" class="form-control searchbtn"/>
                            </div>
                      </div>
                      
                  </div>
                  <br />
              </div>
			   </form>
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

	$("#submit").click(function(){
		
	if($("#hotel_name").val()=="" ){
	alert("Please Enter Hotel Name ");
							 return false;
							}
							else if($("#address_1").val()=="" ){
							alert("Please  Enter Address Line 1");
							 return false;
							}							
							else if($("#address_2").val()=="" ){
							alert("Please  Enter Address Line 2");
							 return false;
							}		
							
							else if($("#post_code").val()=="" ){
							alert("Please  Enter PostCode");
							 return false;
							}
												
							else if($("#state").val()=="" ){
							alert("Please  Enter State");
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
							
							else if($("#star_rating").val()=="" ){
							alert("Please  Enter Star Rating");
							 return false;
							}
							
							else if($("#phone_number").val()=="" ){
							alert("Please  Enter Phone Number");
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
