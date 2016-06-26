<?php
	session_start();
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
<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.5.1/jquery.min.js"></script>
<!-- Load JQuery UI -->
<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.8/jquery-ui.min.js"></script>

<!-- Load Interface Plugins -->
<script type="text/javascript" src="js/uniform/jquery.uniform.js"></script>
<script type="text/javascript" src="js/iPhone/jquery.iphoneui.js"></script>
<script type="text/javascript" src="js/uitotop/js/jquery.ui.totop.js"></script>
<!-- This file configures the various jQuery plugins for Adminica. Contains links to help pages for each plugin. -->
<script type="text/javascript" src="js/adminica/adminica_ui.js"></script>
</head>
<body>
<form action="authenticate.php" method="post">
  <div id="login_box" class="round_all clearfix">
    <div align="center" style="color:#C03">
    
    <?php
		if(isset($_SESSION['msglog']) && $_SESSION['msglog']){
			echo $_SESSION['msglog'];
			unset($_SESSION['msglog']);
		}
		
		if(isset($_SESSION['msg'])){
			echo $_SESSION['msg'];
			unset($_SESSION['msg']);
		}
		?>
    </div>
    <label class="fields"><strong>Username</strong>
      <input type="text" id="username" name="username" class="indent round_all">
    </label>
    <label class="fields"><strong>Password</strong>
      <input type="password" id="password" name="password" class="indent round_all">
    </label>
    
    
    <label class="fields"><strong>Enter code </strong><input id="6_letters_code" name="6_letters_code" type="text" class="indent round_all">
    </label>
     <label class="fields"><strong>&nbsp;</strong><img src="captcha_code_file.php?rand=<?php echo rand(); ?>" id='captchaimg' ><br>
<span style="float:right">Can't read the image? click <a href='javascript: refreshCaptcha();' >here</a> to refresh</span>
       </label>
      
    <button class="button_colour round_all" ><img width="24" height="24" alt="Locked 2" src="images/icons/small/white/locked_2.png"><span>Login</span></button>
    <a href="#" id="login_logo"><span>Adminica</span></a> </div>
</form>
<div id="loading_overlay">
  <div class="loading_message round_bottom">Loading...</div>
</div>
<script type="text/javascript" src="js/livevalidation/livevalidation_standalone.js"></script> 
<script type="text/javascript"> 
// Validation
        var username = new LiveValidation('username');
		username.add( Validate.Presence );
		
        var password = new LiveValidation('password');
		password.add( Validate.Presence );
</script>

<script language='JavaScript' type='text/javascript'>
function refreshCaptcha()
{
	var img = document.images['captchaimg'];
	img.src = img.src.substring(0,img.src.lastIndexOf("?"))+"?rand="+Math.random()*1000;
}
</script>
</body>
</html>