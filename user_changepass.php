<?php
include("access.php");
include("includes/db.conn.php");
include("includes/conf.class.php");
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
<script src="js/jquery.min.js"></script>
<script src="js/cssmenu/script.js"></script>
<script type="text/javascript" src="js/jquery.easing.1.3.js"></script>
<script src="src/jquery.anyslider.js"></script>
<script src="js/bootstrap.js"></script>
<script src="js/moment-with-locales.js"></script>
<script type="text/javascript" src="js/bootstrap-datepicker.js"></script>
<title><?=$bsiCore->config['conf_portal_name']?> : Client Change Password</title>
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
                                               <li class="list-group-item"><a href="user_managebooking.php"><?=MANAGE_MY_BOOKINGS?> » </a></li>
                                                <li class="list-group-item"><a href="user_editAccount.php"><?=UPDATE_UR_PROFILE?> » </a></li>
												<li class="list-group-item"><a href="review_submit.php"><?=SUBMIT_HOTEL_REVIEW?> » </a></li>
                                                <li class="list-group-item active"><a href="user_changepass.php"><?=CHANGE_PASSWORD?> » </a></li>
												<li class="list-group-item"><a href="user_logout.php"><?=LOG_OUT?> </a></li>
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
<h2 class="sett4"><?=CHANGE_PASSWORD?></h2>
<br />

 <?php 	 
 if(isset($_SESSION['client_id2012'])){
$client_id=$_SESSION['client_id2012'];
}else{
$client_id=0; 
}
$row=mysql_fetch_assoc(mysql_query("select * from bsi_clients where client_id='".$client_id."'"));				
?>

<div class="container-fluid">
                  <div class="row">
                  	  <div class="col-md-4">
                          <div class="form-group ">
                              <label class="chkdate" for="exampleInputEmail1"><?=CURRENT_PASSWORD?><span class="strred">*</span></label>
                          </div>
                      </div>
                      <div class="col-md-8">
                          <div class="form-group ">
                             <input id="old_pass" class="form-control roundcorner"  value="" name="old_pass" type="password">
                          </div>
                      </div>
                  </div>
                  <div class="row">
                      <div class="col-md-4">
                          <div class="form-group ">
                              <label class="chkdate" for="exampleInputEmail1"><?=NEW_PASSWORD?> <span class="strred">*</span></label>
                            </div>
                      </div>
                      <div class="col-md-8">
                          <div class="form-group ">
                              <input id="new_pass" class="form-control roundcorner" value="" name="new_pass" type="password">
                            </div>
                      </div>
                  </div>
                  <div class="row">
                      <div class="col-md-4">
                          <div class="form-group ">
                              <label class="chkdate" for="exampleInputEmail1"><?=CONFIRM_PASSWORD?><span class="strred">*</span></label>
                            </div>
                      </div>
                      <div class="col-md-8">
                          <div class="form-group ">
                               <input id="con_pass" class="form-control roundcorner" value="" name="con_pass" type="password">
                            </div>
                      </div>
                  </div>
                  
                  <div class="row">
                  		<div class="col-md-4"></div>
                      <div class="col-md-8">
                          <div class="form-group">
                              <input type="submit" class="form-control searchbtn" value="<?=UPDATE?>"  name="changebtn" id="changebtn">
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

		//change password	

		$('#changebtn').click(function(){
			if($('#new_pass').val() != "" && $('#con_pass').val() != ""){
				if($('#new_pass').val() == $('#con_pass').val()){ 
				var querystr = 'actioncode=5&old_pass='+$('#old_pass').val()+'&new_pass='+$('#new_pass').val();
				$.post("ajax-processor.php", querystr, function(data){						 
					if(data.errorcode == 0){
					//$('#change_pass').html((data.strhtml))	
					alert(data.strhtml);	
					 location.reload();	
					}else{
						
						//$('#change_pass').html((data.strmsg))
						alert(data.strhtml);
					}

					

				}, "json");

				}else{

					alert("<?=NEW_AND_CONFIRM_PASSWORD_TEXT?>");

				}

			}else{

				alert("<?=PASSWORD_NOT_BE_EMPTY_TEXT?>");

			}

		});

		

	});

	

	//]]>

	</script>

</body>
</html>
