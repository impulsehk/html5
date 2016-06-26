<footer class="container-fluid footer-bg" >

    <div class="row">

        <div class="container">

            <div class="row">

            	<div class="col-md-4 footbox">

                   <h3 class="widget-title"><?php echo CUSTOMER_SERVICES;?> </h3>

                   <div class="textwidget">

                          <p><?php  echo BOOK_ONLINE_OR_CALL;?><br/>

                            <font style="font-size:24px; color:#fff;"><?=$bsiCore->config['conf_portal_phone']?></font> </p>

                    </div>

                </div>

                <div class="col-md-4 footbox">

                    <h3 class="widget-title"><?php echo NEW_FOOTER1;?></h3>

                    <p><?php echo NEW_FOOTER2;?>	: </p>

                    <ul class="social-icons">

                      <li> <a target="_blank" href="<?=$bsiCore->config['conf_portal_twitter_link']?>"><i class="fa fa-twitter-square"></i></a> </li>

                      <li> <a target="_blank" href="<?=$bsiCore->config['conf_portal_facebook_link']?>"><i class="fa fa-facebook-square"></i>



 </a> </li>

                      <li> <a target="_blank" href="<?=$bsiCore->config['conf_portal_linkedin_link']?>"><i class="fa fa-linkedin-square"></i></a> </li>

                      <li> <a target="_blank" href="<?=$bsiCore->config['conf_portal_pinterest_link']?>"><i class="fa fa-pinterest-square"></i></a> </li>

                      <li> <a target="_blank" href="<?=$bsiCore->config['conf_portal_googleplus_link']?>"><i class="fa fa-google-plus-square"></i></a> </li>

                    </ul>

                </div>

                <div class="col-md-4 footbox">
                    <h3 class="widget-title"><?php echo NEW_FOOTER3;?></h3>
                    <p><?php echo TYPE_EMAIL_FOR_UP_TO_DATE_OUR_PROMOTION;?>: </p>
                    
                    <div class="row subscription-form">
                        <div class="col-md-10 col-sm-10 col-xs-10 padmarzero">
                          <input required type="email" name="newsletter" value="" placeholder="<?php echo NEW_FOOTER4;?>"  id="newsletter"/>
                        </div>
                        <div class="col-md-2 col-sm-2 col-xs-2 padmarzero">
                          <button type="submit" class="button submit"  name="newsSubmit" id="newsSubmit" ><i class="fa fa-envelope"></i></button>
                        </div>
                    </div>
                    
                </div>

            </div>

        </div>

    </div>

    <div class="row blackbg">

    	 <div class="container">

         	<div class="row">

            	<div class="col-md-12">

                  <div class="developed"> 
				  <?php
				  $resultMenuSql1 = mysql_query("select * from bsi_site_contents where parent_id=0 and status='Y' and footer_type='1'");
				  while($rowMenuSql = mysql_fetch_assoc($resultMenuSql1)){
					  $aaaa65=preg_replace('/[^A-Za-z0-9\-]/', '',str_replace(" ","-",strtolower(trim($rowMenuSql['cont_title'])))).'-'.$rowMenuSql['id'].'.html';
					  $url=($rowMenuSql['url']=="")? $aaaa65 : $rowMenuSql['url'];
					  echo '<a href="'.$abs_url.'/'.$url.'">'.$rowMenuSql['cont_title'].'</a> | ';
				  }
				  
				  ?>
				  

                <!--  <a href="#">Customer Services</a> | 

                    <a href="#">Faq</a> | 

                    <a href="#">Partners</a> | 

                    <a href="#">Privacy Statement </a> | 

                    <a href="#">Terms & Conditions </a>
					
					<a href="all_destination.php">All Destination</a> -->

                  </div>

                  <div class="copyright pull-right">Copyright &copy; <?=date('Y')?>&nbsp;&nbsp;<?=$bsiCore->config['conf_portal_name']?></div>

                </div>

         </div>

    </div>

</footer>

<script type="text/javascript">
//alert("aahi");
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
				alert(data.strhtml);	
				}else{
				alert(data.strhtml);	
				}
				}, "json");	
			} else {
			//alert(data.strhtml);	
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
  (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
  (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
  m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
  })(window,document,'script','//www.google-analytics.com/analytics.js','ga');

  ga('create', 'UA-74697203-1', 'auto');
  ga('send', 'pageview');

</script>

 