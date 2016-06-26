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
	$Combobox   	= $bsiCore->getfrontHotelDestination();
	$gallery     	= $bsiCore->getGallery(); 	
	$suggestion  	= $bsiCore->getDestination();
	$dateForm=$bsiCore->UserDateFormat();
	
	
	//date_default_timezone_set('America/Los_Angeles');
	$currtime=date('H:i'); 
	if($currtime >='00:00' && $currtime <='05:59'){
		
		$chkin=date($dateForm,strtotime("-1 days"));
		$datformat=date('Y-m-d',strtotime("-1 days"));
		$chkout=date($dateForm, strtotime('+1 days', strtotime($datformat)));
	}else{
		$chkin=date($dateForm, strtotime(' +0 day'));
		$chkout=date($dateForm, strtotime(' +1 day'));
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
	<link rel="stylesheet" type="text/css" href="css/pluginStyle.css">
    <link rel="stylesheet" href="//code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.css">
	<title><?php echo $bsiCore->config['conf_portal_sitetitle'];?></title>
	<script src="js/jquery.min.js"></script>
	<script src="js/cssmenu/script.js"></script>
	<script type="text/javascript" src="js/jquery.easing.1.3.js"></script>
	<script src="src/jquery.anyslider.js"></script>
	<script src="js/bootstrap.js"></script>
	<script src="http://code.jquery.com/ui/1.11.2/jquery-ui.js"></script>
	<script src="js/moment-with-locales.js"></script>
	<script type="text/javascript" src="js/bootstrap-datepicker.js"></script>
	<script type="text/javascript" src="https://maps.googleapis.com/maps/api/js?libraries=places,geometry&language=<?php echo $_SESSION['language'];?>"></script>
	<script src="js/shop-locator.js"></script>
	<script type="application/javascript">
	(function ($) {
    "use strict";
    $(document).ready(function () { 
		
		  $(".secondExample").ShopLocator({
            pluginStyle: "modern",
            json: "data/json/homepagemap.json",
            infoBubble: {
                visible: true,
                arrowPosition: 50,
                minHeight: 112,
                maxHeight: null,
                minWidth: 170,
                maxWidth: 250
            },
			  map:{
                mapStyle: [{"featureType":"administrative","elementType":"labels.text.fill","stylers":[{"color":"#444444"}]},{"featureType":"landscape","elementType":"all","stylers":[{"color":"#f2f2f2"}]},{"featureType":"poi","elementType":"all","stylers":[{"visibility":"off"}]},{"featureType":"road","elementType":"all","stylers":[{"saturation":-100},{"lightness":45}]},{"featureType":"road.highway","elementType":"all","stylers":[{"visibility":"simplified"}]},{"featureType":"road.arterial","elementType":"labels.icon","stylers":[{"visibility":"off"}]},{"featureType":"transit","elementType":"all","stylers":[{"visibility":"off"}]},{"featureType":"water","elementType":"all","stylers":[{"color":"#B4D1FF"},{"visibility":"on"}]}]
            }, 
            cluster:{
                enable: true,
                gridSize: 60,
                style:{
                    textColor: '#ffffff',
                    textSize: 18,
                    heightSM: 60,
                    widthSM: 60,
                    heightMD: 70,
                    widthMD: 70,
                    heightBIG: 80,
                    widthBIG: 80,
                    iconSmall: "css/material/images/clusterSmall.png",
                    iconMedium: "css/material/images/clusterMedium.png",
                    iconBig: "css/material/images/clusterBig.png"
                }
            }
        });
		  
		
	});
	}(jQuery));
	</script>
    
   
	</head>
	<body>
    
<header>
      <?php include("header.php");?>
    </header>
<div class="container-fluid">
      <div class="row serbanner">
    <div class="col-md-12 padmarzero serbanner">
          <div class="slidercon">
        <div class="sliderinside slider1"> <?php echo $gallery;?> </div>
      </div>
          <div class="container sd">
        <div class="col-md-12">
        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
              <div class="searchbox"> 
              <div class="form-box-bg">
            <div class="searchbox-tl"><?php echo NEW_SEARCH_NOW;?></div>
            <div class="form-box-bg-cont">
                  <form action="search.php" method="post">
                <div class="form-group">
                      <label for="exampleInputEmail1"> <?php echo GOING_DESTINATION;?></label>
                      <?php 
							echo $Combobox;  ?>
      			</div>
                <div class="row">
                      <div class="col-md-12 col-sm-12 col-xs-12">
                    <div class="form-group">
                    	<label for=""> <?php echo CHECK_IN;?></label>
                          <div class='input-group date' >
                        <input type='text'  value="<?php echo $chkin;?>" readonly     class="form-control roundcornerleft" data-date-format="<?php echo $bsiCore->bt_date_format(); ?>" name="check_in"/>
                        <span class="input-group-addon roundcornerright" > <span class="glyphicon glyphicon-calendar"></span> </span> </div>
                        </div>
                  </div>
<?php /*
                    <div class="col-md-6 col-sm-6 col-xs-6">
                    <div class="form-group">
                          <label for=""> <?php echo CHECK_OUT;?></label>
                          <div class='input-group date' >
                        <input type='text'  value="<?php echo date($dateForm, strtotime(' +1 day'));?>" readonly    class="form-control roundcornerleft" data-date-format="<?php echo $bsiCore->bt_date_format(); ?>"  name="check_out"/>
                        <span class="input-group-addon roundcornerright"> <span class="glyphicon glyphicon-calendar"></span> </span> </div>
                        </div>
                  </div>
*/?>
                   <input type='hidden'  value="<?php echo $chkout;?>" readonly     data-date-format="<?php echo $bsiCore->bt_date_format(); ?>"  name="check_out"/> 
                    </div>
 <?php /*        <label for=""><?php echo NO_OF_PEOPLE;?></label>		*/?>
                <div class="row">
                      <div class="col-md-6 col-sm-6 col-xs-6">
                    <div class="form-group">
                          <label for=""><?php echo ROOOM;?>:</label> 1
                         
                          <input type="hidden" value="1" name="rooms"/>
                        </div>
                  </div>
                      <div class="col-md-6 col-sm-6 col-xs-6">
                    <div class="form-group">
                          <label for=""><?php echo ADULT;?>:</label> 2
                         
                          <input type="hidden" value="2" name="adults[]" />
                        </div>
                  </div>
                  
                      <!--<div class="col-md-43 col-sm-4 col-xs-4">
                    <div class="form-group">
                          <label for=""><?php echo CHILD;?></label>
                          <div class="inpselset" id="child" data-min="0" data-max="<?php echo $bsiCore->get_max_child(); ?>"  >
                        <div class="leftb"> - </div>
                        <div class="midb">0</div>
                        <div class="rightb"> + </div>
                      </div>
                          <input type="hidden" value="0" name="children[]"/>
                        </div>
                  </div>--> 
                  <input type="hidden" value="0" name="children[]"/>
                    </div>
                <script>
  $(document).ready(function(){
    $('.leftb').on('click', function(){
      var id = $(this).parent().attr('id');
      var min = $('#'+id).data('min');
      //var max = $('#'+id).data('max');
      var currentCount = parseInt($(this).next().text());
      if(currentCount > min){
        $(this).next().text(currentCount-1);
        $('#'+id).next().val(currentCount-1);
      }
    });
    $('.rightb').on('click', function(){
      var id = $(this).parent().attr('id');
      //var min = $('#'+id).data('min');
      var max = $('#'+id).data('max');
      var currentCount = parseInt($(this).prev().text());
      if(currentCount < max ){
        $(this).prev().text(currentCount+1);
        $('#'+id).next().val(currentCount+1);
      }
    });
  });
</script>
                <div class="row">
 <?php /*            <div class="col-md-8 col-sm-8 col-xs-8">
                    <div class="form-group">
                          <label for="exampleInputEmail1"><?php echo SORTED_BY;?></label>
                          <select class="form-control roundcorner" id="exampleInputEmail1" name="sortOrder">
                        <option value="STAR_RATING_ASC" title="Sort by star rating - low to high"><?php echo STAR_RATING_LOW_TO_HIGH;?> </option>
                        <option value="STAR_RATING_DESC" title="Sort by star rating - high to low"><?php echo STAR_RATING_HIGH_TO_LOW;?></option>
                      </select>
                        </div>
                  </div>
*/ ?>
                  <input type="hidden" name="sortOrder" value="STAR_RATING_ASC">
                  
                      <div class="col-md-12 col-sm-12 col-xs-12">
                    <div class="form-group">
                          <div class="clr"></div>
                          <input type="submit" class="btn btn-default search-btn" value="<?php echo SEARCH;?>"  id="search_submit" />
                        </div>
                  </div>
                    </div>
              </form>
                </div>
                </div>
          </div>
          </div>
<div class="col-lg-6 col-md-6 col-sm-6 col-xs-12"></div>
            </div>
      </div>
        </div>
  </div>
    </div>
<div class="container-fluid mapbg padmarzero">
      <p class="maptitle"><?php echo NEW_HOTELS_BY_LOCATON;?></p>
      <div class="secondExample"></div>
    </div>
<!--New Design-->
<div class="container-fluid">
      <div class="row container-background">
    <section class="container">
          <div class="row">
        <div class="container-fluid">
              <div class="row">
            <div class="container-fluid">
                  <div class="row">
                <div class="col-md-6">
                      <div class="row">
                    <div class="container-fluid">
                          <div class="row">
                        <div class="col-md-12">
                              <h2 class="settl selt2"><?php echo NEW_POPULAR_HOTEL;?></h2>
                            </div>
                      </div>
                        </div>
                  </div>
                      <div class="row">
                    <div class="container-fluid">
                          <div class="row"> <?php echo $bsiCore->getPopularHotel();?> 
                        
                        
                      </div>
                        </div>
                  </div>
                    </div>
                <div class="col-md-6">
                      <div class="row">
                    <div class="container-fluid">
                          <div class="row">
                        <div class="col-md-12">
                              <h2 class="settl selt2"><?php echo NEW_NEW_LISTING;?></h2>
                            </div>
                      </div>
                        </div>
                  </div>
                      <div class="row">
                    <div class="container-fluid">
                          <div class="row"> <?php echo $bsiCore->getNewListing();?> </div>
                        </div>
                  </div>
                    </div>
              </div>
                </div>
          </div>
              <div class="row">
            <div class="container-fluid">
                  <div class="row">
                <div class="col-md-12">
                      <h2 class="settl selt2"><?php echo HOTPICK;?></h2>
                    </div>
              </div>
                </div>
          </div>
              <div class="row">
            <div class="container-fluid">
                  <div class="row"> <?php echo $bsiCore->getTopDestination();?> </div>
                </div>
          </div>
            </div>
      </div>
        </section>
  </div>
    </div>
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
            <div class="col-md-12 derror" id="error"> </div>
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
                <div class="col-sm-offset-2 col-sm-10"> </div>
              </div>
                  <div class="form-group">
                <div class="col-sm-offset-2 col-sm-10"> <br />
                      <input type="submit" class="form-control searchbtn logbtn" value="<?php echo NEW_LOGIN;?>" id="submit_login" name="submit_login" >
                      <a href="javascript:void(0)" data-toggle="modal" data-target="#forpass" data-dismiss="modal" class="forpass"><?php echo NEW_FORGET_PASSWORD?></a> </div>
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
            <div class="col-md-12 derror" id="errorforget"> </div>
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
                <div class="col-sm-offset-2 col-sm-10"> <br />
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
            <div class="col-md-12 derror" id="agenterror"> </div>
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
                <div class="col-sm-offset-2 col-sm-10"> </div>
              </div>
                  <div class="form-group">
                <div class="col-sm-offset-2 col-sm-10"> <br />
                      <input type="submit" class="form-control searchbtn logbtn" value="<?php echo NEW_LOGIN;?>" id="submit_agentlogin" name="submit_agentlogin" >
                      <a href="javascript:void(0)" data-toggle="modal" data-target="#agentforpass" data-dismiss="modal" class="forpass"><?php echo NEW_FORGET_PASSWORD?></a> </div>
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
            <div class="col-md-12 derror" id="agenterrorforget"> </div>
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
                <div class="col-sm-offset-2 col-sm-10"> <br />
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
<link rel="stylesheet" href="https://code.jquery.com/ui/1.11.2/themes/smoothness/jquery-ui.css">
<style>
.ui-autocomplete{ z-index:9999}
</style>
<style>
</style>
<script>
</script> 
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
<script>
        $(function () {
            $('.slider1').anyslider({
                animation: 'fade',
				speed: 4000,
                interval: 6500,
                reverse: false,
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
		//$('#dpi2')[0].focus();
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
	$("#search_submit").click(function(){
	if($("#dpd1").val()=="" ){
	alert('<?php echo CHECK_IN_ALERT;?>');
							 return false;
							}
							else if($("#dpd2").val()=="" ){
							alert('<?php echo CHECK_OUT_ALERT;?>');
							 return false;
							}
						else{
								return true;
								}
	});
	
	});
	</script> 
<script type="text/javascript">
	$(document).ready(function(){
	//alert("hi");
		$('#newsSubmit').click(function(){
			var email = $("input#newsletter").val();
			if(isValidEmailAddress(email)) { 
				var querystr = 'actioncode=7&email='+email;
				//alert(querystr);die;
				$.post("ajax-processor.php", querystr, function(data){						 
				if(data.errorcode == 0){
    			$("#newsletter").val('');
				$('#showmsg').html("<label class='error'>"+data.strhtml+"</label>");
				}else{
				$('#showmsg').html("<label class='error'>"+data.strhtml+"</label>");
				}
				}, "json");	
			} else {
    			$('#showmsg').html("<label class='error'>Email is not valid!</label>").focus(); 
    		}
		});
   });	
  
   function isValidEmailAddress(emailAddress) {
 		var pattern = new RegExp(/^(("[\w-\s]+")|([\w-]+(?:\.[\w-]+)*)|("[\w-\s]+")([\w-]+(?:\.[\w-]+)*))(@((?:[\w-]+\.)*\w[\w-]{0,66})\.([a-z]{2,6}(?:\.[a-z]{2})?)$)|(@\[?((25[0-5]\.|2[0-4][0-9]\.|1[0-9]{2}\.|[0-9]{1,2}\.))((25[0-5]|2[0-4][0-9]|1[0-9]{2}|[0-9]{1,2})\.){2}(25[0-5]|2[0-4][0-9]|1[0-9]{2}|[0-9]{1,2})\]?$)/i);
   return pattern.test(emailAddress);
   }
   </script> 
<script>
  $(function() {
 
    $( "#destination" ).autocomplete({
	 source: [<?php echo $suggestion; ?>]
    });
  });
  </script>  
  <!-- <style>
  .ui-autocomplete-category {
    font-weight: bold;
	font-size:13px;
    padding: 2px 5px;
	border-bottom:#9C9797 solid 2px;
  }
  .list_item_32{
	  font-size:11px;
	  border-bottom:#EDE8E9 solid 1px;
	  
  }
  </style>
  <script>
  $.widget( "custom.catcomplete", $.ui.autocomplete, {
    _create: function() {
      this._super();
      this.widget().menu( "option", "items", "> :not(.ui-autocomplete-category)" );
    },
    _renderMenu: function( ul, items ) {		
      var that = this,
        currentCategory = "";
      $.each( items, function( index, item ) {
        var li;
        if ( item.category != currentCategory ) {
          ul.append( "<li class='ui-autocomplete-category'>" + item.category + "</li>" );
          currentCategory = item.category;
        }
	
        li = that._renderItemData( ul, item );
        if ( item.category ) {
          li.attr( "aria-label", item.category + " : " + item.label );
		  //li.attr( "class", "list_item_32");
        }
		
      });
    }
  });
  </script>
  <script>
  $(function() {
    $( "#search" ).catcomplete({
      delay: 0,
     // source: "ajax-processor.php?actioncode=19",
	  source:  function( request, respond ) {
        $.post( "ajax-processor.php", { query: request.term, actioncode: 19  },
            function( response ) {
                respond(response);
        }, "json");	
    },
	  minLength: 1,
	  select: function(event, ui) {
                $('#type').val(ui.item.type);
				$('#hotel_id').val(ui.item.id);
				$('#dpd1')[0].focus();
            }
    }).data("custom-catcomplete")._renderItem = function (ul, item) {
		if(item.category == "Cities"){
			var counth="<strong>"+item.label+", "+item.country+"</strong>  ( " + item.count + " Hotels )";
		}else{
			var counth=item.label+", "+item.city+", "+item.country;
		}
		
         return $("<li class='list_item_32'>")
        .data("ui-autocomplete-item", item)
        .append(counth)
        .appendTo(ul);
		
};
  });
  </script>-->
</body>
</html>
