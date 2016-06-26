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
<title><?=$bsiCore->config['conf_portal_name']?> : Agent Profile Edit</title>
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
                                                <li class="list-group-item active"><a href="agent_editAccount.php"><?=UPDATE_UR_PROFILE?> » </a></li>
												<li class="list-group-item"><a href="agenthotel_list.php"><?=NEW_ADD_NEW_HOTEL?> »  </a></li>
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
<h2 class="sett4"><?=UPDATE_UR_PROFILE?></h2>
<br />
<?php 	$row = $bsiCore->getAgentrow($_SESSION['client_id2012']); 			?>

<div class="container-fluid">
                  <div class="row">
                  	  <div class="col-md-4">
                          <div class="form-group ">
                              <label class="chkdate" for="exampleInputEmail1"><?=EMMAIL_ADDRESS?><span class="strred">*</span></label>
                          </div>
                      </div>
                      <div class="col-md-8">
                          <div class="form-group ">
                             <input type="text" id="email" class="form-control roundcorner" value="<?=$row['email']?>" name="email" />
                          </div>
                      </div>
                  </div>
                  <!--<div class="row">
                      <div class="col-md-4">
                          <div class="form-group ">
                              <label class="chkdate" for="exampleInputEmail1">Password <span class="strred">*</span></label>
                            </div>
                      </div>
                      <div class="col-md-8">
                          <div class="form-group ">
                              <input type="text" class="form-control roundcorner">
                            </div>
                      </div>
                  </div>-->
                  <!--<div class="row">
                      <div class="col-md-4">
                          <div class="form-group ">
                              <label class="chkdate" for="exampleInputEmail1">Title <span class="strred">*</span></label>
                            </div>
                      </div>
                      <div class="col-md-8">
                          <div class="form-group ">
                              <select class="form-control roundcorner">
                              	<option>Mr.</option>
                              </select>
                            </div>
                      </div>
                  </div>-->  
                  <div class="row">
                      <div class="col-md-4">
                          <div class="form-group">
                              <label class="chkdate" for="exampleInputEmail1"><?=FIRSTNAME?><span class="strred">*</span></label>
                            </div>
                      </div>
                      <div class="col-md-8">
                          <div class="form-group">
                              <input type="text" id="firstname" class="form-control roundcorner" value="<?=$row['fname']?>" name="firstname"/>
                            </div>
                      </div>
                  </div> 
                  
                  <!--<div class="row">
                      <div class="col-md-4">
                          <div class="form-group">
                              <label class="chkdate" for="exampleInputEmail1">FirstName <span class="strred">*</span></label>
                            </div>
                      </div>
                      <div class="col-md-8">
                          <div class="form-group">
                              <input type="text" class="form-control roundcorner">
                            </div>
                      </div>
                  </div>--> 
                  <div class="row">
                      <div class="col-md-4">
                          <div class="form-group">
                              <label class="chkdate" for="exampleInputEmail1"><?=LASTNAME?><span class="strred">*</span></label>
                            </div>
                      </div>
                      <div class="col-md-8">
                          <div class="form-group">
                              <input type="text" id="lastname" class="form-control roundcorner" value="<?=$row['lname']?>" name="lastname"/>
                            </div>
                      </div>
                  </div>
                  <div class="row">
                      <div class="col-md-4">
                          <div class="form-group">
                              <label class="chkdate" for="exampleInputEmail1"><?=ADDRESS?><span class="strred">*</span></label>
                            </div>
                      </div>
                      <div class="col-md-8">
                          <div class="form-group">
                             <input type="text" id="address" class="form-control roundcorner" value="<?=$row['address']?>" name="address"/>
                            </div>
                      </div>
                  </div> 
                  <!--<div class="row">
                      <div class="col-md-4">
                          <div class="form-group">
                              <label class="chkdate" for="exampleInputEmail1">Address2 </label>
                            </div>
                      </div>
                      <div class="col-md-8">
                          <div class="form-group">
                              <input type="text" class="form-control roundcorner">
                            </div>
                      </div>
                  </div>-->
                  <div class="row">
                      <div class="col-md-4">
                          <div class="form-group">
                              <label class="chkdate" for="exampleInputEmail1"><?=CITY?><span class="strred">*</span></label>
                            </div>
                      </div>
                      <div class="col-md-8">
                          <div class="form-group">
                             <input type="text" id="city" class="form-control roundcorner" value="<?=$row['city']?>" name="city"/>
                            </div>
                      </div>
                  </div>
                  <div class="row">
                      <div class="col-md-4">
                          <div class="form-group">
                              <label class="chkdate" for="exampleInputEmail1"><?=STATE?></label>
                            </div>
                      </div>
                      <div class="col-md-8">
                          <div class="form-group">
                               <input type="text" id="state" class="form-control roundcorner" value="<?=$row['state']?>" name="state"/>
                            </div>
                      </div>
                  </div>
                  <div class="row">
                      <div class="col-md-4">
                          <div class="form-group">
                              <label class="chkdate" for="exampleInputEmail1"><?=ZIP?><span class="strred">*</span></label>
                            </div>
                      </div>
                      <div class="col-md-8">
                          <div class="form-group">
                             <input type="text" id="zip" class="form-control roundcorner" value="<?=$row['zipcode']?>" name="zip"/>
                            </div>
                      </div>
                  </div>
                  <div class="row">
                      <div class="col-md-4">
                          <div class="form-group">
                              <label class="chkdate" for="exampleInputEmail1"><?=COUNTRY?> <span class="strred">*</span></label>
                            </div>
                      </div>
                      <div class="col-md-8">
                          <div class="form-group">
                              <select class="form-control roundcorner" name="country" id="country">
                              <!--	<option>India</option>-->
								
								<?php

						  $sql_country=mysql_query("select * from bsi_country");

						  $optionvalue='';

						  while($row_county=mysql_fetch_assoc($sql_country)){

							  if($row_county['country_code'] == $row['country']){

							  $optionvalue.="<option value=".$row_county['country_code']." selected=\"selected\">".$row_county['name']."</option>";

							  }else{

							  $optionvalue.="<option value=".$row_county['country_code'].">".$row_county['name']."</option>";  

							  }

						  }

					  ?>

                    <?=$optionvalue?>
                              </select>
                            </div>
                      </div>
                  </div>
                  <div class="row">
                      <div class="col-md-4">
                          <div class="form-group">
                              <label class="chkdate" for="exampleInputEmail1"><?=PHONE?> <span class="strred">*</span></label>
                            </div>
                      </div>
                      <div class="col-md-8">
                          <div class="form-group">
                              <input type="text" id="phone" class="form-control roundcorner" value="<?=$row['phone']?>" name="phone"/>
                            </div>
                      </div>
                  </div>
				  
				  <div class="row">
                      <div class="col-md-4">
                          <div class="form-group">
                              <label class="chkdate" for="exampleInputEmail1"><?=COMMISSION?><span class="strred">*</span></label>
                            </div>
                      </div>
                      <div class="col-md-8">
                          <div class="form-group">
                              <!--<input type="text" class="form-control roundcorner">-->
							  <?=number_format($row['commission'])."%"?>
							  <!--<input type="text" id="phone" class="form-control roundcorner" value="<?=$row['phone']?>" name="phone"/>-->
                            </div>
                      </div>
                  </div>
				  
                  <div class="row">
                  		<div class="col-md-4"></div>
                      <div class="col-md-8">
                          <div class="form-group">
							  <input type="submit" name="updatebtn" id="updatebtn" value="<?=UPDATE?>" class="form-control searchbtn" />
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


<!--<script src="js/jquery.min.js"></script>
<script src="js/bootstrap.js"></script>
<script src="js/cssmenu/script.js"></script>-->

<script type="text/javascript">
$(document).ready(function(){

		//update client profile

		$('#updatebtn').click(function(){
			
			if($('#firstname').val()!=''&& $('#lastname').val()!='' && $('#address').val()!='' && $('#city').val()!='' && $('#state').val()!='' && $('#zip').val()!='' && $('#phone').val()!='')
			{

			var querystr = 'actioncode=9&email='+$('#email').val()+'&firstname='+$('#firstname').val()+'&lastname='+$('#lastname').val()+'&address='+$('#address').val()+'&city='+$('#city').val()+'&state='+$('#state').val()+'&zip='+$('#zip').val()+'&country='+$('#country').val()+'&phone='+$('#phone').val();

			$.post("ajax-processor.php", querystr, function(data){												 

				if(data.errorcode == 0){

					alert(data.strhtml);	

					location.reload();				

				}else{

				    alert(data.strmsg);

				}

			}, "json");
			}else{
			alert("<?php echo NEW_PLEASE_SELECT;?>");
			}

		});		

	});

	//]]>

	</script>

</body>
</html>
