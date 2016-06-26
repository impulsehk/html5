<?php 

	session_start();
	
	include("includes/db.conn.php"); 

	include("includes/conf.class.php");

	/*include("includes/language.php");

	if(isset($_SESSION['language'])){
		$htmlCombo=$bsiCore->getbsilanguage($_SESSION['language']);
	}else{
		$htmlCombo=$bsiCore->getbsilanguage(); 
	}
*/

	
		$tac_content=mysql_fetch_assoc(mysql_query("select * from bsi_site_contents where id=18"));
		


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
<!----><!--<script type="text/javascript" src="js/custom-form-elements.min.js"></script>-->
<!-- Optional theme 
<link rel="stylesheet" href="css/bootstrap-theme.css">-->
<!-- Custom Page Theme -->

<link rel="stylesheet" href="css/page-theme.css">
<title>Terms & Conditions</title>
</head>

<body>
<div class="container-fluid">
    <div class="row container-background">
        <section class="container">
        	<div class="row">
            <div class="container-fluid">
                <!--<div class="row">
                	<div class="noti">
                        <span>Dharamshala Offer</span>
                       <?php echo $body_content['cont_title'];?>
                        <div class="closenoti"></div>
                    </div>
                </div>-->
                <br>
				<br>
                <div class="row">
                	<div class="container-fluid">
                		<div class="row">
                        	
                            <div class="col-md-12">
                            	
                                <div class="container-fluid">
                					<div class="row mrb20">
                        				<div class="col-md-12 sernbox">
                                             <br />
                                             
                                              <div class="container-fluid">
                                                <div class="row">
                                                    <div class="col-md-12">
                                                    <h2 class="sett4"> <?php echo $tac_content['cont_title'];?></h2>
                                                    </div>
                                                </div>
                                                
                                                <div class="row">
                                                    <div class="col-md-12 cmstext">
                                                    <?php echo $tac_content['contents'];?>
                                                    </div>
                                                </div>
                                                
                                                <div class="row">
                                                   
												   
												    <div class="col-md-6 cmstext">
                                                    
                                                    </div>
													
                                                    <div class="col-md-6 cmstext">
                                                    
                                                    </div>
													
                                                </div>
												
                                                <div class="row">
                                                    <div class="col-md-12 cmstext">
                                                    	<h4></h4>
                                                    </div>
                                                </div>
												
                                                <div class="row">
												
                                                    <div class="col-md-3 cmstext">
                                                    
                                                    </div>
													
                                                    <div class="col-md-3 cmstext">
                                                    
                                                    </div>
													
                                                    <div class="col-md-3 cmstext">
                                                    	
                                                    </div>
													
                                                    <div class="col-md-3 cmstext">
                                                    	 
                                                    </div>
													
                                                </div>
                                                
                                                
                                                
                                                
                                              </div>
                                             <br />
                                             <br />
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
<!-- Latest compiled and minified JavaScript -->
<script src="js/bootstrap.js"></script>


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

	


</body>
</html>
