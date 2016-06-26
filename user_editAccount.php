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
<title><?=$bsiCore->config['conf_portal_name']?> : Client Profile Edit </title></head>

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
                            				<h2 class="sett3"><span><?php echo HI;?>, <?php echo $_SESSION['Myname2012'];?></span><?php echo MY_ACCOUNT_MY_BOOKINGS;?></h2>
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
                                               <li class="list-group-item "><a href="user_managebooking.php"><?php echo MANAGE_MY_BOOKINGS;?> » </a></li>
                                                <li class="list-group-item active"><a href="user_editAccount.php"><?php echo UPDATE_UR_PROFILE;?>» </a></li>
												<li class="list-group-item"><a href="review_submit.php"><?php echo SUBMIT_HOTEL_REVIEW;?> » </a></li>
                                                <li class="list-group-item"><a href="user_changepass.php"><?php echo CHANGE_PASSWORD;?> » </a></li>
												<li class="list-group-item"><a href="user_logout.php"><?php echo LOG_OUT;?> </a></li>
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
<h2 class="sett4"><?php echo UPDATE_UR_PROFILE;?></h2>
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
                              <label class="chkdate" for="exampleInputEmail1"><?php echo EMMAIL_ADDRESS;?> <span class="strred">*</span></label>
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
                              <input type="text" class="form-control roundcorner" value="<?=$row['title']?>" id="title" name="title" >
                            </div>
                      </div>
                  </div>-->
                  <div class="row">
                      <div class="col-md-4">
                          <div class="form-group ">
                              <label class="chkdate" for="exampleInputEmail1"><?php echo TITLE;?> <span class="strred">*</span></label>
                            </div>
                      </div>
                      <div class="col-md-8">
                          <div class="form-group ">
                               <input type="text" class="form-control roundcorner" value="<?php echo $row['title'];?>" id="title" name="title" >
                            </div>
                      </div>
                  </div>  
                  <div class="row">
                      <div class="col-md-4">
                          <div class="form-group">
                              <label class="chkdate" for="exampleInputEmail1"><?php echo FIRSTNAME;?><span class="strred">*</span></label>
                            </div>
                      </div>
                      <div class="col-md-8">
                          <div class="form-group">
                             <input type="text" id="firstname" class="form-control roundcorner" value="<?php echo $row['first_name'];?>" name="firstname"/>
                            </div>
                      </div>
                  </div> 
                  
                  <div class="row">
                      <div class="col-md-4">
                          <div class="form-group">
                              <label class="chkdate" for="exampleInputEmail1"><?php echo LASTNAME;?><span class="strred">*</span></label>
                            </div>
                      </div>
                      <div class="col-md-8">
                          <div class="form-group">
                              <input type="text" id="lastname" class="form-control roundcorner" value="<?php echo $row['surname'];?>" name="lastname"/>
                            </div>
                      </div>
                  </div> 
                  <!--<div class="row">
                      <div class="col-md-4">
                          <div class="form-group">
                              <label class="chkdate" for="exampleInputEmail1">LastName <span class="strred">*</span></label>
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
                              <label class="chkdate" for="exampleInputEmail1"><?php echo ADDRESS;?><span class="strred">*</span></label>
                            </div>
                      </div>
                      <div class="col-md-8">
                          <div class="form-group">
                               <input type="text" id="address1" class="form-control roundcorner" value="<?php echo $row['street_addr'];?>" name="address1" required/>
                            </div>
                      </div>
                  </div> 
                  <div class="row">
                      <div class="col-md-4">
                          <div class="form-group">
                              <label class="chkdate" for="exampleInputEmail1"><?php echo ADDRESS_SECOND;?></label>
                            </div>
                      </div>
                      <div class="col-md-8">
                          <div class="form-group">
                             <input type="text" id="address2" class="form-control roundcorner" value="<?php echo $row['street_addr2'];?>" name="address2" required/>
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
                               <input type="text" id="city" class="form-control roundcorner" value="<?php echo $row['city'];?>" name="city"/>
                            </div>
                      </div>
                  </div>
                  <div class="row">
                      <div class="col-md-4">
                          <div class="form-group">
                              <label class="chkdate" for="exampleInputEmail1"><?php echo STATE;?></label>
                            </div>
                      </div>
                      <div class="col-md-8">
                          <div class="form-group">
                               <input type="text" id="state" class="form-control roundcorner" value="<?php echo $row['province'];?>" name="state"/>
                            </div>
                      </div>
                  </div>
                  <div class="row">
                      <div class="col-md-4">
                          <div class="form-group">
                              <label class="chkdate" for="exampleInputEmail1"><?php echo ZIP;?><span class="strred">*</span></label>
                            </div>
                      </div>
                      <div class="col-md-8">
                          <div class="form-group">
                              <input type="text" id="zip" class="form-control roundcorner" value="<?php echo $row['zip'];?>" name="zip"/>
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

                    <?php echo $optionvalue;?>
                              </select>
                            </div>
                      </div>
                  </div>
                  <div class="row">
                      <div class="col-md-4">
                          <div class="form-group">
                              <label class="chkdate" for="exampleInputEmail1"><?php echo PHONE;?><span class="strred">*</span></label>
                            </div>
                      </div>
                      <div class="col-md-8">
                          <div class="form-group">
                              <input type="text" id="phone" class="form-control roundcorner" value="<?php echo $row['phone'];?>" name="phone"/>
                            </div>
                      </div>
                  </div>
                  <div class="row">
                  		<div class="col-md-4"></div>
                      <div class="col-md-8">
                          <div class="form-group">
                            <input type="submit" name="updatebtn" id="updatebtn" value="<?php echo UPDATE;?>" class="form-control searchbtn" />
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
			if($('#firstname').val()!=''&& $('#lastname').val()!='' && $('#address1').val()!='' && $('#address2').val()!='' && $('#city').val()!='' && $('#state').val()!='' && $('#zip').val()!='' && $('#phone').val()!='')
			{
			var querystr = 'actioncode=3&email='+$('#email').val()+'&title='+$('#title').val()+'&firstname='+$('#firstname').val()+'&lastname='+$('#lastname').val()+'&address1='+$('#address1').val()+'&address2='+$('#address2').val()+'&city='+$('#city').val()+'&state='+$('#state').val()+'&zip='+$('#zip').val()+'&country='+$('#country').val()+'&phone='+$('#phone').val();

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
