<?php
include("includes/db.conn.php");
include("includes/conf.class.php");
include("includes/language.php");

$abs_url=$bsiCore->abs_url(dirname(__FILE__));

if(isset($_SESSION['language'])){
$htmlCombo=$bsiCore->getabsbsilanguage($_SESSION['language'],$abs_url);
}else{
$htmlCombo=$bsiCore->getabsbsilanguage(0,$abs_url); 
}
$reviewflag=0;
$reviewmsg=0;
$checkreviewsql=mysql_query("select * from bsi_bookings where reviewid='".$_GET['rkey']."'");
if(mysql_num_rows($checkreviewsql)){
	$reviewmsg=1;
$rowbookinginfo=mysql_fetch_assoc($checkreviewsql);

$sql		=	mysql_query("SELECT `hotel_id`, `booking_id` FROM `bsi_bookings` WHERE 
						`is_deleted`='0'  and `client_id`='".$rowbookinginfo['client_id']."' and  `booking_id` not in (select `booking_id` from `bsi_hotel_review` 
						where `client_id`='".$rowbookinginfo['client_id']."')");
						if(mysql_num_rows($sql)){
$rowclientinfo=mysql_fetch_assoc(mysql_query("select * from bsi_clients where client_id='".$rowbookinginfo['client_id']."'"));
$reviewflag=1;
						
						
						
						}
						
}

?>

<!doctype html>
<html>
<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">
<!-- Latest compiled and minified CSS -->
<link rel="stylesheet" href="<?php echo $abs_url; ?>/css/bootstrap.css">
<link rel="stylesheet" href="<?php echo $abs_url; ?>/fonts/stylesheet.css">
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css">
<link rel="stylesheet" href="<?php echo $abs_url; ?>/src/jquery-anyslider.css">
<!----><!--<script type="text/javascript" src="js/custom-form-elements.min.js"></script>-->
<!-- Optional theme 
<link rel="stylesheet" href="css/bootstrap-theme.css">-->
<!-- Custom Page Theme -->
<!--<link rel="stylesheet" href="https://code.jquery.com/ui/1.11.2/themes/smoothness/jquery-ui.css">
-->
<link rel="stylesheet" href="<?php echo $abs_url; ?>/css/datepicker.css">
<link rel="stylesheet" href="<?php echo $abs_url; ?>/css/page-theme.css">
<link rel="stylesheet" href="<?php echo $abs_url; ?>/js/cssmenu/styles.css">
<script src="<?php echo $abs_url; ?>/js/jquery.min.js"></script>
<!--<script src="<?php echo $abs_url; ?>/js/cssmenu/script.js"></script>-->
<script type="text/javascript" src="<?php echo $abs_url; ?>/js/jquery.easing.1.3.js"></script>
<script src="<?php echo $abs_url; ?>/src/jquery.anyslider.js"></script>
<script src="<?php echo $abs_url; ?>/js/bootstrap.js"></script>
<script src="<?php echo $abs_url; ?>/js/moment-with-locales.js"></script>
<script type="text/javascript" src="<?php echo $abs_url; ?>/js/bootstrap-datepicker.js"></script>
<title><?=$bsiCore->config['conf_portal_name']?></title>
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
              <?php if($reviewflag==1){?>
                <div class="row">
                	<div class="container-fluid">
                  
                    	<div class="row">
                        	<div class="col-md-12">
                            	<div class="container-fluid">
                    				<div class="row">
                        				<div class="col-md-3 sernbox">
                            				<h2 class="sett3"><?=HI?>, <?php echo $rowclientinfo['first_name'];?> </h2>
                                		</div><div class="col-md-9 sernbox">
                            				<h2 class="sett3">Tell others about this Service - write a review</h2>
                                		</div>
                                    </div>
                                 </div>
                            </div>
                        </div>
                    
                		<div class="row" style="margin-top:20px;">
                        	
                            <div class="col-md-12">
                                <div class="container-fluid">
                					<div class="row">
                        				<div class="col-md-12 sernbox">
                                             <div class="container-fluid">
                                                <div class="row">
                                                    <div class="col-md-12">
<br />
<h2 class="sett4"><?=REVIEWS?></h2>
<br />
<div class="container-fluid">
                  <div class="row">
                  	  <div class="col-md-3">
                          <div class="form-group ">
                              <label class="chkdate" for="exampleInputEmail1">Review For :</label>
                          </div>
                      </div>
                      <div class="col-md-6">
                          <div class="form-group ">
						  <?php echo $getDropDown = $bsiCore->gethotelnameDropdown($rowbookinginfo['client_id']);?>  
                              <!--<select class="form-control roundcorner">
                              	<option>Select</option>
                              </select>-->
                          </div>
                      </div>
                  </div>
                  
                  <div class="row">
                 
                      <div class="col-md-3">
                          <div class="form-group ">
                              <label class="chkdate" for="exampleInputEmail1"><?=RATING_CLEAN?> :</label>
                            </div>
                      </div>
                      <div class="col-md-3 col-sm-10 col-xs-10">
                          <div class="form-group ">
                              <div id="clean"></div><input type="hidden" id="txt_clean" />
                            </div>
                      </div>
                       <div class="col-md-1 col-sm-2 col-xs-2">
                       <div id="target_clean" ></div>
                       </div>
                     
                  </div>
                  
                  <div class="row">
                  
                      <div class="col-md-3">
                          <div class="form-group ">
                              <label class="chkdate" for="exampleInputEmail1"><?=RATING_COMFORT?> :</label>
                            </div>
                      </div>
                      <div class="col-md-3 col-sm-10 col-xs-10">
                          <div class="form-group ">
                              <div id="comfort"></div><input type="hidden" id="txt_comfort" />
                            </div>
                      </div>
                      <div class="col-md-1 col-sm-2 col-xs-2">
                       <div id="target_comfort" ></div>
                       </div>
                  </div>
                  <div class="row">
                 
                      <div class="col-md-3">
                          <div class="form-group ">
                              <label class="chkdate" for="exampleInputEmail1"><?=RATING_LOCATION?> :</label>
                            </div>
                      </div>
                      <div class="col-md-3 col-sm-10 col-xs-10">
                          <div class="form-group ">
                              <div id="location"></div><input type="hidden" id="txt_location" />
                            </div>
                      </div>
                      <div class="col-md-1 col-sm-2 col-xs-2">
                      <div id="target_location" ></div>
                       </div>
                  </div>
                  <div class="row">
                 
                      <div class="col-md-3">
                          <div class="form-group ">
                              <label class="chkdate" for="exampleInputEmail1"><?=RATING_SERVICES?> :</label>
                            </div>
                      </div>
                      <div class="col-md-3 col-sm-10 col-xs-10">
                          <div class="form-group ">
                              <div id="services"></div><input type="hidden" id="txt_services" />
                            </div>
                      </div>
                      <div class="col-md-1 col-sm-2 col-xs-2">
                     <div id="target_services" ></div>
                       </div>
                  </div>
                  <div class="row">
                 
                      <div class="col-md-3">
                          <div class="form-group ">
                              <label class="chkdate" for="exampleInputEmail1"><?=RATING_STAFF?> :</label>
                            </div>
                      </div>
                      <div class="col-md-3 col-sm-10 col-xs-10">
                          <div class="form-group ">
                              <div id="staff"></div><input type="hidden" id="txt_staff" />
                            </div>
                      </div>
                       <div class="col-md-1 col-sm-2 col-xs-2">
                      <div id="target_staff" ></div>
                      </div>
                  </div>
                  <div class="row">
                 
                      <div class="col-md-3">
                          <div class="form-group ">
                              <label class="chkdate" for="exampleInputEmail1"><?=RATING_VALUE_MONEY?> :</label>
                            </div>
                      </div>
                      <div class="col-md-3 col-sm-10 col-xs-10">
                          <div class="form-group ">
                              <div id="vfm"></div><input type="hidden" id="txt_vfm" />
                      </div> </div>
                       <div class="col-md-1 col-sm-2 col-xs-2">
                      <div id="target_vfm" ></div>
                      </div>
                  </div>
                  <div class="row">
                  
                  	  <div class="col-md-3">
                          <div class="form-group ">
                              <label class="chkdate" for="exampleInputEmail1"><?=COMMENT_POSITIVE?> :</label>
                          </div>
                      </div>
                      <div class="col-md-6">
                          <div class="form-group ">
                              <!--<textarea class="form-control roundcorner"></textarea>-->
							  <textarea class="form-control roundcorner" name="cpositive" id="cpositive" ></textarea>
                          </div>
                      </div>
                  </div>
                  <div class="row">
                  	  <div class="col-md-3">
                          <div class="form-group ">
                              <label class="chkdate" for="exampleInputEmail1"><?=COMMENT_NEGATIVE?> :</label>
                          </div>
                      </div>
                      <div class="col-md-6">
                          <div class="form-group ">
                              <!--<textarea class="form-control roundcorner"></textarea>-->
							   <textarea class="form-control roundcorner" name="cnegative" id="cnegative"></textarea>
                          </div>
                      </div>
                  </div>
                  
                  <div class="row">
                  		<div class="col-md-3"></div>
                      <div class="col-md-6">
                          <div class="form-group">
                              <!--<input type="submit" class="form-control searchbtn" value="Submit">-->
							  <input type="submit" class="form-control searchbtn" value="<?=SUBMIT?>" id="submit" disabled name="submit" >
                            </div>
                      </div>
                      
                  </div>
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
                <?php
					}else{?>
                    <div class="row">
                        	<div class="col-md-6 col-md-offset-3">
                            	<div class="container-fluid">
                					<div class="row">
                        				<div class="col-md-12 searchbg">
                                            <h2 class="sett4" style="background:none">Review Section</h2>
                                           
                                            <div class="container-fluid" style="padding:10px 15px"> 
                                            	<div class="row">
                                                    <div class="col-md-12"><p class="pstl"><?php if($reviewmsg==1) echo "Thank You For submit your review.";else{ echo "Click your proper review link.";}?><br /></p></div>
                                                    
                                                </div>
                                                
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                        </div>
                    <?php
					}?>
            </div>
            </div>
        </section>
	</div>
</div>
<br />
<br />
<br />

<?php include("footer.php");?>

<!--<script src="js/jquery.min.js"></script>
<script src="js/bootstrap.js"></script>
<script src="js/cssmenu/script.js"></script>-->
<script src="<?php echo $abs_url; ?>/js/raty-master/lib/jquery.raty.js"></script>
<script src="<?php echo $abs_url; ?>/js/raty-master/demo/javascripts/labs.js" type="text/javascript"></script>
<script type="text/javascript">
    $(document).ready(function() {
		$('#clean').raty();
		$('#comfort').raty();
		$('#location').raty();
		$('#service').raty();

		$('#stuff').raty();
		$('#money').raty();
		
		
	});
</script>

<script type="text/javascript">



$(document).ready(function(){


	if($('#review_hotel_booking').val() != ""){



		$("#submit").removeAttr("disabled");



		submitRating();



	}



		 function submitRating(){



			$('#submit').click(function(){


if( $('#txt_clean').val()==0 ){
alert('Please Put Rate For Clean !');
return false;
}	
else if( $('#txt_comfort').val()==0 ){
	alert('Please Put Rating For Comfort !');
	return false;}	
	
	else if( $('#txt_location').val()==0 ){
		alert('Please Enter Rating For Location !');
		return false;}
		
		else if( $('#txt_services').val()==0 ){
			alert('Please Put Rating For Services !');
			return false;}
				
			else if( $('#txt_staff').val()==0 ){
				alert('Please  Rate For Staff !');
				return false;}	
				
				else if( $('#txt_vfm').val()==0 ){
					alert('Please Enter Rating For Value Money  !');
					return false;}	
					
		else {

	var querystr = 'actioncode=1&hotelid_bookingid='+$('#review_hotel_booking').val()+'&rclean='+$('#txt_clean').val()+'&rcomfort='+$('#txt_comfort').val()+'&rlocation='+$('#txt_location').val()+'&rservices='+$('#txt_services').val()+'&rstaff='+$('#txt_staff').val()+'&rvm='+$('#txt_vfm').val()+'&cpositive='+$('#cpositive').val()+'&cnegative='+$('#cnegative').val()+'&clientid='+<?php echo $rowbookinginfo['client_id'];?>; 
	
	$.post("http://feelspark.com/ajax-processor.php", querystr, function(data){						
	
	if(data.errorcode == 0){
	//$('#submit_success').html(data.strhtml)
	alert(data.strhtml);	
	//alert(data.strhtml);
	location.reload();	
	}else{
	alert(data.strmsg);
	}
	}, "json"); 

}




			});



		 }



	



	 



$('#rating_test').click(function() { 







alert($('#test2').val());



});	 



ratingcalculate('clean');



ratingcalculate('comfort');



ratingcalculate('location');



ratingcalculate('services');



ratingcalculate('staff');



ratingcalculate('vfm');	



function ratingcalculate(rating_type){	



	



$('#'+rating_type).raty({	



  click: function(score, evt) {



	 $("#txt_"+rating_type).val(score);



  },



  half:       false,



  precision:  false,



  size:       24,



  number:    10,



  starHalf:   '<?php echo $abs_url; ?>/js/raty-master/lib/images/star-half.png',



  starOff:    '<?php echo $abs_url; ?>/js/raty-master/lib/images/star-off.png',



  starOn:     '<?php echo $abs_url; ?>/js/raty-master/lib/images/star-on.png',



  target:     '#target_'+rating_type,



  targetType: 'number'



});







}

});



</script>
<script>
(function($) {

  $.fn.menumaker = function(options) {
      
      var cssmenu = $(this), settings = $.extend({
        title: "Menu",
        format: "dropdown",
        sticky: false
      }, options);

      return this.each(function() {
        cssmenu.prepend('<div id="menu-button"><img src="<?php echo $abs_url; ?>/gallery/portal/1449649909_logo.jpg" alt=""/></div>');
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
</body>
</html>
