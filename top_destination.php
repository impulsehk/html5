<?php  
session_start();
include("includes/db.conn.php"); 
include("includes/conf.class.php");
include("includes/language.php");  
$abs_url=$bsiCore->abs_url(dirname(__FILE__));
	if(isset($_SESSION['language'])){
		$htmlCombo=$bsiCore->getabsbsilanguage($_SESSION['language'],$abs_url);
	}else{
		$htmlCombo=$bsiCore->getabsbsilanguage(0,$abs_url); 
	}
	//echo $_REQUEST['city'];die;

$cityHtml='';	
$hotelresult = mysql_query("select * from bsi_hotels where city_name='".$_REQUEST['city']."'  and  status=1");

$countryresult = mysql_query("select * from `bsi_city`  where city_name='".$_REQUEST['city']."'  ");
$countryrow = mysql_fetch_assoc($countryresult);

$countryresult1 = mysql_query("select * from `bsi_country`  where country_code='".$countryrow['country_code']."'  ");
$countryrow1 = mysql_fetch_assoc($countryresult1);

				if(mysql_num_rows($hotelresult)){
					while($rowh = mysql_fetch_assoc($hotelresult)){
					$cityHtml .= '<div class="row mrb20">
                        				<div class="col-md-12 sernbox">
                                             <div class="container-fluid">
                                                <div class="row">
                                                    <div class="col-md-3 col-sm-3 serimg">
                                                    	<a href="'.$abs_url.'/'.$_REQUEST['city'].'/'.str_replace(" ","-",strtolower(trim($rowh['hotel_name']))).'-'.$rowh['hotel_id'].'.html"><img src="'.$abs_url.'/gallery/hotelImage/'.$rowh['default_img'].'" alt=""/></a>
                                                       
                                                    </div> 
                                                    <div class="col-md-9 col-sm-9">
                                                    	<h3 class="sertl"><a href="'.$abs_url.'/'.$_REQUEST['city'].'/'.str_replace(" ","-",strtolower(trim($rowh['hotel_name']))).'-'.$rowh['hotel_id'].'.html">'.$rowh['hotel_name'].'</a>
														'.$bsiCore->hotelStar($rowh['star_rating']).'
                                                        </h3>
                                                        <p class="sertlul">'.$rowh['address_1'].' '.$rowh['address_2'].', '.$rowh['city_name'].'</p>
                                                        <p class="settxt">'.$rowh['desc_short'].'</p>
                                                    </div>
                                                </div>
                                                
                                                
                                                <div class="clr"></div>
                                             </div>
                                        </div>
                                    </div>';
					
					}
				
				}
	
	
	//$cityHtml = $bsiCore->getCitynameHtml();
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

<link rel="stylesheet" href="<?php echo  $abs_url; ?>/css/bootstrap.css">

<link rel="stylesheet" href="<?php echo  $abs_url; ?>/fonts/stylesheet.css">

<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css">

<link rel="stylesheet" href="<?php echo  $abs_url; ?>/src/jquery-anyslider.css">

<!----><!--<script type="text/javascript" src="js/custom-form-elements.min.js"></script>-->

<!-- Optional theme 

<link rel="stylesheet" href="css/bootstrap-theme.css">-->

<!-- Custom Page Theme -->

<!--<link rel="stylesheet" href="https://code.jquery.com/ui/1.11.2/themes/smoothness/jquery-ui.css">

-->

<link rel="stylesheet" href="<?php echo  $abs_url; ?>/css/datepicker.css">
<link rel="stylesheet" href="<?php echo  $abs_url; ?>/css/page-theme.css">
<link rel="stylesheet" href="<?php echo  $abs_url; ?>/js/cssmenu/styles.css">
<script src="<?php echo  $abs_url; ?>/js/jquery.min.js"></script>

<script type="text/javascript" src="<?php echo  $abs_url; ?>/js/jquery.easing.1.3.js"></script>
<script src="<?php echo  $abs_url; ?>/src/jquery.anyslider.js"></script>
<script src="<?php echo  $abs_url; ?>/js/bootstrap.js"></script>
<script src="<?php echo  $abs_url; ?>/js/moment-with-locales.js"></script>
<script type="text/javascript" src="<?php echo  $abs_url; ?>/js/bootstrap-datepicker.js"></script>
<title><?=$bsiCore->config['conf_portal_name']?> : Top Destination</title>

</head>



<body>


<header>

<?php include("header-r.php");?>	

</header>


<div class="container-fluid">
    <div class="row container-background">
        <section class="container">
        	<div class="row">
            <div class="container-fluid">
               
                
                <div class="row">
                	<div class="container-fluid">
                		<div class="row">
                        	
                            
                           <?php /*?> <?=$cityHtml?><?php */?>
                           
                            
                            
                          <div class="col-md-12">
                          <?php if(mysql_num_rows($countryresult)==0){ ?>
                            	<h2 class="sett4"><?php echo $_REQUEST['city'];?>  not found!</h2>
                           <?php }else{ ?>
                           <h2 class="sett4"><?php echo $_REQUEST['city'];?>  ,  <?php echo $countryrow1['cou_name'];?></h2>
                           <?php } ?>
							  
                                <div class="container-fluid">
                                
                                	<?=$cityHtml?>
                					
                            
                            
                        </div>
                    </div>
                </div>
                
            </div>
            </div>
        </section>
	</div>
</div>

<script src="<?php echo  $abs_url; ?>/js/jquery.min.js"></script>
<script src="http://code.jquery.com/ui/1.11.2/jquery-ui.js"></script>

<?php include("footer-r.php");?>

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


<!--  ************************************************************ For logo ***********************************************************************************-->

<script>
(function($) {

  $.fn.menumaker = function(options) {
      
      var cssmenu = $(this), settings = $.extend({
        title: "Menu",
        format: "dropdown",
        sticky: false
      }, options);

      return this.each(function() {
        cssmenu.prepend('<div id="menu-button"><img src="<?php echo $abs_url; ?>/gallery/portal/<?=$bsiCore->config['conf_portal_logo']?>" alt=""/></div>');
        $(this).find("#menu-button").on('click', function(){
          $(this).toggleClass('menu-opened');
          var mainmenu = $(this).next('ul');
          if (mainmenu.hasClass('open')) { 
            mainmenu.hide().removeClass('open');
          }
          else {
            mainmenu.show().addClass('open');
            if (settings.format === "dropdown") {
              mainmenu.find('ul').show();
            }
          }
        });

        cssmenu.find('li ul').parent().addClass('has-sub');

        multiTg = function() {
          cssmenu.find(".has-sub").prepend('<span class="submenu-button"></span>');
          cssmenu.find('.submenu-button').on('click', function() {
            $(this).toggleClass('submenu-opened');
            if ($(this).siblings('ul').hasClass('open')) {
              $(this).siblings('ul').removeClass('open').hide();
            }
            else {
              $(this).siblings('ul').addClass('open').show();
            }
          });
        };

        if (settings.format === 'multitoggle') multiTg();
        else cssmenu.addClass('dropdown');

        if (settings.sticky === true) cssmenu.css('position', 'fixed');

        resizeFix = function() {
          if ($( window ).width() > 768) {
            cssmenu.find('ul').show();
          }
          if ($(window).width() <= 768) {
            cssmenu.find('ul').hide().removeClass('open');
			
          }
        };
        resizeFix();
        return $(window).on('resize', resizeFix);

      });
  };
})(jQuery);

(function($){
$(document).ready(function(){

$(document).ready(function() {
  $("#cssmenu").menumaker({
    title: "Menu",
    format: "multitoggle"
  });

  $("#cssmenu").prepend("<div id='menu-line'></div>");

var foundActive = false, activeElement, linePosition = 0, menuLine = $("#cssmenu #menu-line"), lineWidth, defaultPosition, defaultWidth;

$("#cssmenu > ul > li").each(function() {
  if ($(this).hasClass('active')) {
    activeElement = $(this);
    foundActive = true;
  }
});

if (foundActive === false) {
  activeElement = $("#cssmenu > ul > li").first();
}

defaultWidth = lineWidth = activeElement.width();

defaultPosition = linePosition = activeElement.position().left;

menuLine.css("width", lineWidth);
menuLine.css("left", linePosition);

$("#cssmenu > ul > li").hover(function() {
  activeElement = $(this);
  lineWidth = activeElement.width();
  linePosition = activeElement.position().left;
  menuLine.css("width", lineWidth);
  menuLine.css("left", linePosition);
}, 
function() {
  menuLine.css("left", defaultPosition);
  menuLine.css("width", defaultWidth);
});

});


});
})(jQuery);

</script>

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
	$.post("<?php echo $abs_url;?>/ajax-processor.php", querystr, function(data){						 
				if(data.errorcode == 0){
					//$('#error').html('<p> Succesfully Login! Please wait redirecting...</p>');
					$(location).attr('href', '<?php echo $abs_url;?>/user_managebooking.php?submenuheader=0');
				}else{
				$('#error').html('<?php echo NEW_EMAIL_NOT_MATCH;?>');
				//alert('Emailid or Password does not matched.');	
				}
			}, "json");
	});
	
	
	$("#submit_forget").click(function(){
	var querystr = 'actioncode=13&email='+$('#inputEmailforget').val();
	$.post("<?php echo $abs_url;?>/ajax-processor.php", querystr, function(data){						 
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
	$.post("<?php echo $abs_url;?>/ajax-processor.php", querystr, function(data){						 
				if(data.errorcode == 0){
					//$('#error').html('<p> Succesfully Login! Please wait redirecting...</p>');
					$(location).attr('href', '<?php echo $abs_url;?>/agent_managebooking.php?submenuheader=0');
				}else{
				$('#agenterror').html('<?php echo NEW_EMAIL_NOT_MATCH;?>.');
				//alert('Emailid or Password does not matched.');	
				}
			}, "json");
	});
	
	
	$("#submit_agentforget").click(function(){
	var querystr = 'actioncode=16&email='+$('#inputagentEmailforget').val();
	
	$.post("<?php echo $abs_url;?>/ajax-processor.php", querystr, function(data){						 
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
