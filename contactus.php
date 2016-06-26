<?php 
	session_start();
	include("includes/db.conn.php");
	include("includes/conf.class.php");
	//$Combobox   	= $bsiCore->getfrontHotelDestination();
	//$gallery     	= $bsiCore->getGallery(); 	
	

include("includes/language.php");
if(isset($_SESSION['language'])){
		$htmlCombo=$bsiCore->getbsilanguage($_SESSION['language']);
	}else{
		$htmlCombo=$bsiCore->getbsilanguage(); 
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

<link rel="stylesheet" href="css/datepicker.css">

<link rel="stylesheet" href="css/page-theme.css">

<link rel="stylesheet" href="js/cssmenu/styles.css">
<title><?=$bsiCore->config['conf_portal_name']?> : Contact Us</title>
<script src="js/jquery.min.js"></script>
<script src="js/cssmenu/script.js"></script>
 <script type="text/javascript" src="js/jquery.easing.1.3.js"></script>
<script src="src/jquery.anyslider.js"></script>
<script src="js/bootstrap.js"></script>
<script src="http://code.jquery.com/ui/1.11.2/jquery-ui.js"></script>		
<script src="js/moment-with-locales.js"></script>
<script type="text/javascript" src="js/bootstrap-datepicker.js"></script>
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
                	<!--<div class="noti">
                        <span>Hotel Shale</span>
                        Get Flat 40% OFF on Hotels. Use Promo Code VIAHOTELS to see the final price
                        <div class="closenoti"></div>
                    </div>-->
                </div>
                               
                <div class="row">
                	<div class="container-fluid">
                		<div class="row">
                        	<div class="col-md-4">
                            	<div class="container-fluid">
                					<div class="row">
                        				<div class="col-md-12 sernbox">
                                            <h2 class="sett3"><?=CUSTOMER_SERVICES?></h2>
                                            <div class="clr"></div>
                                            <div class="container-fluid" style="padding:10px 15px">
                                            	<div class="row">
                                                    <div class="col-md-12"><p class="pstl">Please don't hesitate to contact us if you need any information or if you have any questions you need answered or any suggestion you would like to make that might help us improve our service.</p></div>
                                                </div>
                                            </div>
                                            <h2 class="sett3"><span><?=CONTACT_ADDRESS?></span></h2>
                                                <div class="col-md-12" style="padding-top:10px; padding-bottom:10px">                                          
                                                    <strong><?=$bsiCore->config['conf_portal_name']?></strong><br />
                                                   <?=$bsiCore->config['conf_portal_streetaddr']?><br />
                                                    <?=$bsiCore->config['conf_portal_city']?><br />
                                                    <?=$bsiCore->config['conf_portal_state']?><br />
                                                    <?=$bsiCore->config['conf_portal_country']?>
                                                </div>
                                            <div class="clr"></div>
                                            <h2 class="sett3"><span><?=CALL_US_FOR_FREE?></span></h2>
                                            
                                            <div class="container-fluid">
                                            	<div class="clr" style="height:20px"></div>
                                                <div class="row">
                                                  <div class="col-md-3"><p class="pstl"><?=PHONE?>:</p></div>
                                                  <div class="col-md-9"><p class="pstl"><?=$bsiCore->config['conf_portal_phone']?></p></div>
                                                </div>
                                                <div class="row">
                                                  <div class="col-md-3"><p class="pstl"><?=EMAIL?>:</p></div>
                                                  <div class="col-md-9"><p class="pstl"><?=$bsiCore->config['conf_portal_email']?></p></div>
                                                </div>
                                            </div>      
                                            <div class="clr" style="height:20px"></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-8">
                            	<h2 class="sett4"><?=NEW_CONTACT_FORM?></h2>
                                <div class="container-fluid">
                					<div class="row mrb20">
                        				<div class="col-md-12 sernbox">
                                             <div class="container-fluid">
                                                <div class="row">
                                                    <div class="col-md-12 col-sm-12 ">
                                                    	
                                              <div class="container-fluid">
                                               
                                                <div class="row">
                                                    <div class="col-md-12">
                                                    
             <div class="container-fluid">
             		<br />
                  <br />
                  <!--<form action="#">-->
                  <div class="row">
                      <div class="col-md-4">
                          <div class="form-group">
                              <label class="chkdate" for="exampleInputEmail1"><?=CONTACT_REASON?><span class="strred">*</span></label>
                            </div>
                      </div>
                      <div class="col-md-8">
                          <div class="form-group">
                          		<select class="form-control roundcorner" name="subject" id="subject">
                                	<option value=""><?=SELECT_ONE?></option>
                                    <option value="booking"><?=PROBLEM_BOOKING_HOTEL?></option>
                                    <option value="cancelation"><?=CHANGING_OR_CANCELLATION_RESERVATION?></option>
                                    <option value="email_issue"><?=CONFIRMATION_EMAIL_ISSUE?></option>
                                    <option value="registration"><?=ACCOUNT_REGISTRATION?> </option>
                                    <option value="price"><?=PRICE_MATCH_GURANTEE?></option>
                                    <option value="upcoming_trip"><?=QUESTION_ABOUT_UPCOMING_TRIP?></option>
                                    <option value="completed_trip"><?=COMPLETED_TRIP?></option>
                                    <option value="web_site_problem"><?=WEB_SITE_PROBLEM?></option>
                                    <option value="call_center"><?=CALL_CENTER_EXPERIENCE?></option>
                                    <option value="other"><?=OTHER?></option>
                                </select>
                            </div>
                      </div>
                  </div>
                  <div class="row">
                      <div class="col-md-4">
                          <div class="form-group">
                              <label class="chkdate" for="exampleInputEmail1"><?=UR_NAME?><span class="strred">*</span></label>
                            </div>
                      </div>
                      <div class="col-md-8">
                          <div class="form-group">
                         
							  <input type="text" id="name" class="form-control roundcorner" value="" name="name"/>
                            </div>
                      </div>
                      
                  </div>
                  <div class="row">
                      <div class="col-md-4">
                          <div class="form-group">
                              <label class="chkdate" for="exampleInputEmail1"><?=EMAIL?><span class="strred">*</span></label>
                            </div>
                      </div>
                      <div class="col-md-8">
                          <div class="form-group">
                              
							  <input required type="email" class="form-control roundcorner" id="contactemail" value="" name="contactemail"/>
                            </div>
                      </div>
                      
                  </div>
                  <div class="row">
                      <div class="col-md-4">
                          <div class="form-group">
                              <label class="chkdate" for="exampleInputEmail1"><?=PHONE?></label>
                            </div>
                      </div>
                      <div class="col-md-8">
                          <div class="form-group">
                              <input type="text" class="form-control roundcorner" id="phone"  value="" name="phone"/>
                            </div>
                      </div>
                      
                  </div>
                  <div class="row">
                      <div class="col-md-4">
                          <div class="form-group">
                              <label class="chkdate" for="exampleInputEmail1"><?=QUESTION?><span class="strred">*</span></label>
                            </div>
                      </div>
                      <div class="col-md-8">
                          <div class="form-group">
                              <textarea class="form-control roundcorner" id="comments" name="comments"></textarea>
                            </div>
                      </div>
                      
                  </div>
                  <div class="row">
                  	  <div class="col-md-4"></div>
                      <div class="col-md-8">
                          <div class="form-group">
                             <input type="submit" class="form-control searchbtn" value="<?=SEND?>" name="submit" id="send"  name="send"  > 
                            </div>
                      </div>
                      
                  </div>
                  <br />
                  <br />
                 <!-- </form>-->
             </div>
                                                    
                                                    </div>
                                                </div>
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








<style>

/*#datepicker,

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

}*/

</style>

<!--<script src="js/jquery.min.js"></script>-->

<!--<script src="http://code.jquery.com/ui/1.11.2/jquery-ui.js"></script>

--><script>

/*$(function() {

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

});

*/

</script>

<!-- Latest compiled and minified JavaScript -->

    



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

		//close in popup modal

		$('.close').on('click',function(){

			$('div.searchbg').css('zIndex',999999);

		});

		//open popup modal signin

		$('.signin').on('click',function(){

			$('div.searchbg').css('zIndex',1);

		});

	});

</script>

<!--<script src="js/cssmenu/script.js"></script>-->

 <script type="text/javascript" src="js/jquery.easing.1.3.js"></script>

        <script src="src/jquery.anyslider.js"></script>

		<script>

        $(function () {

            $('.slider1').anyslider({

                animation: 'fade',

                interval: 5000,

                reverse: true,

                startSlide: 1

            });

    

        });

        </script>


<script>
		$(function(){
// disabling dates
		var nowTemp = new Date();
		var now = new Date(nowTemp.getFullYear(), nowTemp.getMonth(), nowTemp.getDate(), 0, 0, 0, 0);
		
		var checkin = $('#dpd1').datepicker({
		onRender: function(date) {
		return date.valueOf() < now.valueOf() ? 'disabled' : '';
		}
		}).on('changeDate', function(ev) {
		if (ev.date.valueOf() > checkout.date.valueOf()) {
		var newDate = new Date(ev.date)
		newDate.setDate(newDate.getDate() + <?php echo  $bsiCore->config['conf_min_night_booking']; ?>);
		checkout.setValue(newDate);
		//alert(newDate);
		//alert(checkout.setValue(newDate));
		}
		checkin.hide();
		$('#dpd2')[0].focus();
		}).data('datepicker');
		var checkout = $('#dpd2').datepicker({
		onRender: function(date) {
		var checkoutdt= parseInt(checkin.date.valueOf())+(60*60*24*1000*<?php echo  ($bsiCore->config['conf_min_night_booking']-1); ?>);
		
		return date.valueOf() <= checkoutdt ? 'disabled' : '';
		
		}
		}).on('changeDate', function(ev) {
		checkout.hide();
		}).data('datepicker');
		
		});
	</script>
	
			
<script type="text/javascript">
	$(document).ready(function() {
	
	$("#submit_login").click(function(){
	var querystr = 'actioncode=12&email='+$('#inputEmail3').val()+'&password='+$('#inputPassword3').val();
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
	
	$("#send").click(function(){

	if($("#subject").val()=="" ){
	alert('<?=SELECT_REASON?>');
	 return false;

	}
		else if($("#name").val()=="" ){
		alert('<?=ENTER_UR_NAME?>');
		return false;
		}
		 else if($("#contactemail").val()=="" ){
		alert('<?=NEW_FOOTER4?>');
		return false;
		}
		 else if($("#comments").val()=="" ){
		alert('<?=COMMENT_OR_QUESTION_TEXT?>');
		return false;
		}
		else{
		var querystr='actioncode=6&subject='+$('#subject').val()+'&name='+$('#name').val()+'&contactemail='+$('#contactemail').val()+'&phone='+$('#phone').val()+'&comments='+$('#comments').val();
			//alert(querystr);die;
			$.post("ajax-processor.php", querystr, function(data){												 

				if(data.errorcode == 0){

					alert(data.strhtml);	

					location.reload();				

				}else{

				    alert(data.strmsg);

				}

			}, "json");
			
		return true;
				}
	});
	});
	</script>
	

</body>

</html>

