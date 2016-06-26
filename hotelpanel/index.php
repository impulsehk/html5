<?php
session_start();
include("../includes/db.conn.php");
include("../includes/conf.class.php");
?>
<!doctype html>
<html>
<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">
<!-- Latest compiled and minified CSS -->
<link rel="stylesheet" href="../css/bootstrap.css">
<link rel="stylesheet" href="../fonts/stylesheet.css">
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css">
<link rel="stylesheet" href="../src/jquery-anyslider.css">
<!----><!--<script type="text/javascript" src="js/custom-form-elements.min.js"></script>-->
<!-- Optional theme 
<link rel="stylesheet" href="css/bootstrap-theme.css">-->
<!-- Custom Page Theme -->
<link rel="stylesheet" href="https://code.jquery.com/ui/1.11.2/themes/smoothness/jquery-ui.css">

<link rel="stylesheet" href="../css/page-theme.css">
<link rel="stylesheet" href="../js/cssmenu/styles.css">
<script src="../js/jquery.min.js"></script>
<script src="../js/cssmenu/script.js"></script>
<script type="text/javascript" src="../js/jquery.easing.1.3.js"></script>
<script src="../src/jquery.anyslider.js"></script>
<script src="../js/bootstrap.js"></script>
<script src="../js/moment-with-locales.js"></script>
<script type="text/javascript" src="../js/bootstrap-datepicker.js"></script>
<title><?=$bsiCore->config['conf_portal_name']?> : Hotel Login</title>
</head>

<body>


<header>
	<?php 
	

/*include("../includes/language.php"); 

if(isset($_SESSION['language'])){
	$htmlCombo=$bsiCore->getbsilanguage($_SESSION['language']); 
}else{
	$htmlCombo=$bsiCore->getbsilanguage(); 
	}
	*/
/*include("../header.php");*/
?>	
</header>

<br><br><br><br>

<div class="container-fluid">
    <!--<div class="row container-background">-->
        <section class="container">
        	<div class="row">
            <div class="container-fluid">
                
                
                <div class="row">
                	<div class="container-fluid">
                		<div class="row">
                        
                         <div class="col-md-3">
                         </div>
                        	
                            <div class="col-md-6">
                            	<h2 class="sett4">Hotel Login</h2>
                                <div class="container-fluid">
                					<div class="row mrb20">
                        				<div class="col-md-12 sernbox">
                                             <div class="container-fluid">
                                                <div class="row">
                                                    <div class="col-md-12 col-sm-12 ">
                                                    	
                                              <div class="container-fluid">
                                                
                                                 
                                                <br />
                                                <br />
                                                <div class="row">
                                                    <div class="col-md-12">
                                                    
<div class="container-fluid">
<div class="row">



    <!--<div id="ckd1" class="col-md-12 chekrow"> 
    <span class="rw1"></span>
    <p><?=FASTER_BOOKING_TEXT?></p>
    <input class="radiocheckbox" type="radio" name="radio1"/>
    <div class="clr"></div>
    </div>-->
                      
 <form action="authenticate.php" id="round-form" name="round-form" method="post">                     
 <input value="account" id="account_selection" name="account_selection" type="hidden">
        
<div class="row">
 <center><span style="color:red;"><?php if(isset($_SESSION['msg']))
 echo $_SESSION['msg'];
 unset($_SESSION['msg']);?></span> </center> 
 <br>
 </div>
                 
<div class="row">
    <div class="col-md-4">
    <div class="form-group">
    <label class="chkdate" for="exampleInputEmail1">Email-Id :</label>
    </div>
    </div>

    <div class="col-md-8">
    <div class="form-group">
    <input type="text" class="form-control roundcorner" name="email_id" id="email_id">
    </div>
    </div>
</div>


<div class="row">
    <div class="col-md-4">
    <div class="form-group">
    <label class="chkdate" for="exampleInputEmail1">Password :</label>
    </div>
    </div>
 
    <div class="col-md-8">
    <div class="form-group">
    <input type="password" class="form-control roundcorner" name="password" id="password">
    </div>
    </div>
</div>

<div class="row">
    <div class="col-md-4">
    </div>
    
    <div class="col-md-8">
    <div class="form-group">
    <input type="submit" class="form-control searchbtn" value="Login" id="login" name="login">
    </div>
    </div>
</div>                      
 
 
 </form>
 
 </div>
</div>
                                                    <br />
                                                	<br />
                                                    </div>
                                                </div>
                                              </div>
                                                    </div> 
                                                </div>
                                                <div class="clr"></div>
                                             </div>
                                        </div>
                                    </div>
									
									<?php
		 if(isset($_SESSION['isError']) && $_SESSION['isError']==2){ 
		 	 echo '<span style="color:red;">Email Id already exist in our client database!</span>'; 
			 unset($_SESSION['isError']);
		 }else if(isset($_SESSION['isError']) && $_SESSION['isError']==1){ 
		 	 echo '<span style="color:red;">'.EMAIL_OR_PASSWORD_INCORRECT.'</span>'; 
			 unset($_SESSION['isError']);
		 }
	 	?>
                                </div>
                            </div>
                            


<div class="col-md-3">
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


<?php //include("footer.php");?>



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
	$("#login").click(function(){
	if($("#email_id").val()=="" ){
	alert("Please Enter Emailid");
							 return false;
							}
							else if($("#password").val()=="" ){
							alert("Please Enter Password");
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

