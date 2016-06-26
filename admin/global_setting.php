<?php 

include("access.php");

if(isset($_POST['act_sbmt'])){

	include("../includes/db.conn.php");

	include("../includes/conf.class.php");

	include("../includes/admin.class.php");

	$bsiAdminMain->global_setting_post();

	header("location:global_setting.php");

	exit;

}

$pageid = 21;

include("header.php");

$global_setting=$bsiAdminMain->global_setting();
if($bsiCore->config['conf_agent_hotel'] == 1){
	$str66='checked="checked"';
}else{
	$str66='';
}

if($bsiCore->config['conf_smtp_mail']=='true')	{

	$mailddselect='<option  value="false" >PHP Mail</option>

			  <option value="true" selected>SMTP Authentication Mail</option>';

}else{

	$mailddselect='<option  value="false" selected>PHP Mail</option>

			  <option value="true">SMTP Authentication Mail</option>';

}

?>

<script type="text/javascript" src="js/jquery.validate.js"></script>

<script type="text/javascript">

$(document).ready(function(){

	$("#global_form").validate();	

	<?php

		if($bsiCore->config['conf_smtp_mail']=='true')	{

			echo "$('#smtpauthenticatemail').show();";

		}else{

			echo "$('#smtpauthenticatemail').hide();";

		}

		$html = $bsiAdminMain->combobox($bsiCore->config['conf_min_night_booking']);	

	 ?>		

	$("#email_send_by").change(function() {	

	var email_value = $(this).val();

	//alert(email_value);

	if(email_value=='true'){

		$('#smtpauthenticatemail').show();

	}else{

		$('#smtpauthenticatemail').hide();

	}

	});

});

</script>

</head>

<body>

<div class="flat_area grid_16">

  <h2>Global Settings</h2>

</div>

<form name="global_form" id="global_form" action="<?=$_SERVER['PHP_SELF']?>" method="post" enctype="multipart/form-data">

  <input type="hidden" name="act_sbmt" value="1" />

  <div class="box grid_16 round_all">

    <h2 class="box_head grad_colour round_top">PORTAL DETAILS</h2>

    <a href="#" class="grabber">&nbsp;</a> <a href="#" class="toggle">&nbsp;</a>

    <div class="block no_padding">

      <fieldset>

        <legend ></legend>

        <table cellspacing="0" cellpadding="5" border="0" class="bodytext">

          <tbody>

            <tr>

              <td><strong>Portal Name</strong></td>

              <td><input type="text" class="required Name" value="<?=$bsiCore->config['conf_portal_name']?>" size="50" name="portal_name" id="portal_name"/></td>

            </tr>

            <tr>

              <td><strong>Street Address</strong></td>

              <td><input type="text" class="required" value="<?=$bsiCore->config['conf_portal_streetaddr']?>" size="40" name="str_addr" id="str_addr"/></td>

            </tr>

            <tr>

              <td><strong>City</strong></td>

              <td><input type="text" class="required" value="<?=$bsiCore->config['conf_portal_city']?>" size="30" name="city" id="city"/></td>

            </tr>

            <tr>

              <td><strong>State</strong></td>

              <td><input type="text" class="required" value="<?=$bsiCore->config['conf_portal_state']?>" size="30" name="state" id="state"/></td>

            </tr>

            <tr>

              <td><strong>Country</strong></td>

              <td><input type="text" class="required" value="<?=$bsiCore->config['conf_portal_country']?>" size="30" name="country" id="country"/></td>

            </tr>

            <tr>

              <td><strong>Zip / Post code</strong></td>

              <td><input type="text" class="required" value="<?=$bsiCore->config['conf_portal_zipcode']?>" size="10" name="zipcode" id="zipcode"/></td>

            </tr>

            <tr>

              <td><strong>Phone</strong></td>

              <td><input type="text"  class="required" value="<?=$bsiCore->config['conf_portal_phone']?>" size="15" name="phone" id="phone"/></td>

            </tr>

            <tr>

              <td><strong>Fax</strong></td>

              <td><input type="text" class="required" value="<?=$bsiCore->config['conf_portal_fax']?>" size="15" name="fax" id="fax"/></td>

            </tr>

            <tr>

              <td><strong>Email</strong></td>

              <td><input type="text" class="required" value="<?=$bsiCore->config['conf_portal_email']?>" size="30" name="email" id="email"/></td>

            </tr>

            <tr>

              <td><strong>Portal Logo</strong></td>

              <td><input type="file"   size="30" name="conf_portal_logo" id="conf_portal_logo"/>

              <?php

			  if(isset($bsiCore->config['conf_portal_logo'])){

				  if($bsiCore->config['conf_portal_signature'] !=""){

			  ?>

                <a href="../gallery/portal/<?=$bsiCore->config['conf_portal_logo']?>" target="_blank" style="padding-left:12px"> View Image</a>

                <input type="hidden" value="<?=$bsiCore->config['conf_portal_logo']?>" name="portal_logo" id="portal_logo"/>

                <?php

			  }else{

				  echo "No Image"; 

			  }

			  }

				?>

                </td>

            <tr>

              <td><strong>Portal Signature</td>

              <td><input type="file"  size="30" name="conf_portal_signature" id="conf_portal_signature"/>

              <?php

			  if(isset($bsiCore->config['conf_portal_signature'])){

				  if($bsiCore->config['conf_portal_signature'] !=""){

			  ?>

                <a href="../gallery/portal/<?=$bsiCore->config['conf_portal_signature']?>" target="_blank" style="padding-left:12px"> View Image</a>

                <input type="hidden" value="<?=$bsiCore->config['conf_portal_signature']?>" name="portal_sig" id="portal_sig"/>

                <?php

			  }else{

				   echo "No Image";

			  }

			  }

			  ?>

                <!--<a href="../gallery/portal/<?=$bsiCore->config['conf_portal_signature']?>" target="_blank" style="padding-left:12px"> View Image</a>--></td>

            </tr>
			
			
<tr>
<td><strong>Portal Pdf Logo</strong></td>
<td><input type="file"  size="30" name="conf_pdf_logo" id="conf_pdf_logo"/>
<?php
if(isset($bsiCore->config['conf_pdf_logo'])){
if($bsiCore->config['conf_pdf_logo'] !=""){
?>
<a href="../gallery/portal/<?=$bsiCore->config['conf_pdf_logo']?>" target="_blank" style="padding-left:12px"> View Image</a>
<input type="hidden" value="<?=$bsiCore->config['conf_pdf_logo']?>" name="pdf_logo" id="pdf_logo"/>
<?php
}else{
echo "No Image";
}
}
?>
</td>
</tr>
			
<tr> 
<td><strong>Logo For Mail </strong></td>
 <td><input type="file"  size="30" name="conf_mail_logo" id="conf_mail_logo"/>
<?php
if(isset($bsiCore->config['conf_mail_logo'])){
if($bsiCore->config['conf_mail_logo'] !=""){
?>
<a href="../gallery/portal/<?=$bsiCore->config['conf_mail_logo']?>" target="_blank" style="padding-left:12px"> View Image</a>
<input type="hidden" value="<?=$bsiCore->config['conf_mail_logo']?>" name="mail_logo" id="mail_logo"/>
<?php
}else{
echo "No Image";
}
}
?>
</td>
</tr>
           

          </tbody>

        </table>

      </fieldset>

    </div>

  </div>

  <div class="box grid_16 round_all">

    <h2 class="box_head grad_colour round_top">SEO DETAILS</h2>

    <a href="#" class="grabber">&nbsp;</a> <a href="#" class="toggle">&nbsp;</a>

    <div class="block no_padding">

      <fieldset>

        <legend></legend>

        <table cellspacing="0" cellpadding="8" border="0" class="bodytext">

          <tbody>

            <tr>

              <td><strong>Website Title</strong></td>

              <td><input type="text"  class="required" value="<?=$bsiCore->config['conf_portal_sitetitle']?>" size="50" name="title" id="title"/></td>

            </tr>

            <tr>

              <td valign="top"><strong>Website Description</strong></td>

              <td><textarea name="desc" class="required" rows="3" cols="40" id="desc"><?=$bsiCore->config['conf_portal_sitedesc']?>

</textarea></td>

            </tr>

            <tr>

              <td valign="top"><strong>Website Keyword</strong></td>

              <td><textarea name="keywords" class="required" rows="3" cols="40" id="keywords"><?=$bsiCore->config['conf_portal_sitekeywords']?>

</textarea></td>

            </tr>
			
			
			 <tr>

              <td valign="top"><strong>Sponsored Ads</strong></td>

              <td><textarea name="sponsored_ads" class="required" rows="3" cols="40" id="sponsored_ads"><?=$bsiCore->config['conf-google-ads']?>

</textarea></td>

            </tr>
			
			

          </tbody>

        </table>

      </fieldset>

    </div>

  </div>
  
  
  
  <div class="box grid_16 round_all">

    <h2 class="box_head grad_colour round_top">SOCIAL LINKS</h2>

    <a href="#" class="grabber">&nbsp;</a> <a href="#" class="toggle">&nbsp;</a>

    <div class="block no_padding">

      <fieldset>

        <legend></legend>

        <table cellspacing="0" cellpadding="8" border="0" >

          <tbody>

           <tr>

              <td><strong>Twitter</strong></td>

              <td><input type="text"  class="required" value="<?=$bsiCore->config['conf_portal_twitter_link']?>" size="50" name="twitter" id="twitter"/></td>

            </tr>

            <tr>

              <td><strong>Facebook</strong></td>

              <td><input type="text"  class="required" value="<?=$bsiCore->config['conf_portal_facebook_link']?>" size="50" name="facebook" id="facebook"/></td>

            </tr>
			
			<tr>

              <td><strong>Linkedin</strong></td>

              <td><input type="text"  class="required" value="<?=$bsiCore->config['conf_portal_linkedin_link']?>" size="50" name="linkedin" id="linkedin"/></td>

            </tr>
			
			<tr>

              <td><strong>Pinterest</strong></td>

              <td><input type="text"  class="required" value="<?=$bsiCore->config['conf_portal_pinterest_link']?>" size="50" name="pinterest" id="pinterest"/></td>

            </tr>
			
			<tr>

              <td><strong>Googleplus</strong></td>

              <td><input type="text"  class="required" value="<?=$bsiCore->config['conf_portal_googleplus_link']?>" size="50" name="googleplus" id="googleplus"/></td>

            </tr>

          </tbody>

        </table>

      </fieldset>

    </div>

  </div>
  
  
  

  <div class="box grid_16 round_all">

    <h2 class="box_head grad_colour round_top"><strong>EMAIL SETTING </strong></h2>

    <a href="#" class="grabber">&nbsp;</a> <a href="#" class="toggle">&nbsp;</a>

    <div class="block no_padding">

      <fieldset>

        <legend ></legend>

        <table cellspacing="0" cellpadding="8" border="0" class="bodytext">

          <tbody>

            <tr>

              <td align="left" style="padding-left:13px" width="80px"><strong>Email Send By</strong></td>

              <td style="padding-left:10px"><select id="email_send_by" name="email_send_by">

                  <?=$mailddselect?>

                </select></td>

            </tr>

            <tr>

              <td colspan="2"><div id="smtpauthenticatemail">

                  <table cellspacing="0" cellpadding="4" border="0">

                    <tbody>

                      <tr>

                        <td><strong>SMTP Host</strong></td>

                        <td><input type="text" class="required" style="width:200px" value="<?=$bsiCore->config['conf_smtp_host']?>" name="smtphost" id="smtphost"/></td>

                      </tr>

                      <tr>

                        <td><strong>SMTP Port</strong></td>

                        <td><input type="text" class="required number" style="width:50px" value="<?=$bsiCore->config['conf_smtp_port']?>" name="smtpport" id="smtpport"/></td>

                      </tr>

                      <tr>

                        <td><strong>SMTP Username</strong></td>

                        <td><input type="text" class="required" style="width:200px" value="<?=$bsiCore->config['conf_smtp_username']?>" name="smtpuser" id="smtpuser"/></td>

                      </tr>

                      <tr>

                        <td><strong>SMTP Password</strong></td>

                        <td><input type="password"  value="<?=$bsiCore->config['conf_smtp_password']?>" name="smtppass" id="smtppass"/></td>

                      </tr>

                    </tbody>

                  </table>

                </div></td>

            </tr>

          </tbody>

        </table>

      </fieldset>

    </div>

  </div>

  <div class="box grid_16 round_all">

    <h2 class="box_head grad_colour round_top">CURRENCY SETTING</h2>

    <a href="#" class="grabber">&nbsp;</a> <a href="#" class="toggle">&nbsp;</a>

    <div class="block no_padding">

      <fieldset>

        <legend></legend>

        <table cellspacing="0" cellpadding="8" border="0" >

          <tbody>

            <tr>

              <td><strong>Currency Code</strong></td>

              <td><input type="text" class="required" size="10" value="<?=$bsiCore->config['conf_currency_code']?>" name="currency_code" id="currency_code"/></td>

            </tr>

            <tr>

              <td><strong>Currency Symbol</strong></td>

              <td><input type="text" class="required" size="4" value="<?=$bsiCore->config['conf_currency_symbol']?>" name="currency_symbol" id="currency_symbol"/></td>

            </tr>

          </tbody>

        </table>

      </fieldset>

    </div>

  </div>

  <div class="box grid_16 round_all">

  <h2 class="box_head grad_colour round_top">OTHERS SETTING</h2>

  <a href="#" class="grabber">&nbsp;</a> <a href="#" class="toggle">&nbsp;</a>

  <div class="block no_padding">

  <fieldset>

  <legend ></legend>

  <table cellspacing="0" cellpadding="8" border="0">

    <tbody>

    <tr><td>Server OS:</td><td>

    <select name="server_os" id="server_os">

    

    <?php

	if($bsiCore->config['conf_server_os']==1){

		

		?>

        

	   <option value="1" selected="selected">Windows</option>

		<option value="2">Linux/Unix</option>	

	 <?php

     }else{

		 ?>

		 <option value="1" >Windows</option>

		<option value="2" selected="selected">Linux/Unix</option>	

		

	<?php

	 }

	?>

    

    

</select></td></tr>

      <tr>

        <td><strong>Booking Engine</strong></td>

        <td><select name="booking_turn" id="booking_turn">

            <option selected="selected" value="0">Turn On</option>

            <option value="1">Turn Off</option>

          </select></td>

      </tr>

      <tr>

        <td><strong>Hotel Timezone</strong></td>

        <td><select name="timezone" id="timezone">

            <?=$global_setting['select_timezone']?>

          </select></td>

      </tr>

      <tr>

        <td><strong>Minimum Booking</strong></td>

        <td><?=$html?>

          &nbsp;&nbsp;Night(s)</td>

      </tr>

      <tr>

        <td><strong>Date Format</strong></td>

        <td><select name="date_format" id="date_format">

           <?=$global_setting['select_dt_format']?>

          </select></td>

      </tr>

      <tr>

        <td ><strong>Room Lock Time</strong></td>

        <td><select name="room_lock" id="room_lock">

            <option value="200">2 Minute</option>

            <option selected="selected" value="500">5 Minute</option>

            <option value="1000">10 Minute</option>

            <option value="2000">20 Minute</option>

            <option value="3000">30 Minute</option>

          </select></td>

      </tr>

      <tr>

        <td><strong>Booking Prefix</strong></td>

        <td><input type="text" class="required" value="<?=$bsiCore->config['conf_bookingid_prefix']?>" size="6" name="bpfix" id="bpfix"/></td>

      </tr>

      <tr>

        <td><strong>Tax</strong></td>

        <td><input type="text" class="required" value="<?=$bsiCore->config['conf_tax_amount']?>" size="6" name="tax" id="tax"/></td>

      </tr>
      <!--<tr>

        <td><strong>Enter Theme Color</strong></td>

        <td>
				<select name="theme_color" id="theme_color">
					<?php echo $global_setting['select_theme_color'];?>
				</select></td>

      </tr>
      <tr>-->

        <td><strong>Agent Hotel Add</strong></td>

        <td><input type="checkbox" name="agent_hotel" id="agent_hotel" value="1" <?php echo $str66;?>/>
				</td>

      </tr>


      <tr>

        <td><strong>Destnation Search Type</strong></td>

        <td><select name="destination_search_type" id="destination_search_type">

            <option <?php if($bsiCore->config['destination_search_type'] == 0){ ?>selected="selected"<?php } ?> value="0">Drop Down Box</option>

            <option <?php if($bsiCore->config['destination_search_type'] == 1){ ?>selected="selected"<?php } ?> value="1">Ajax Text Box</option>

          </select></td>

      </tr>

      <tr>

        <td><strong>Payment With Commission</strong></td>

        <td><select name="conf_payment_commission" id="conf_payment_commission">

            <option <?php if($bsiCore->config['conf_payment_commission'] == 0){ ?>selected="selected"<?php } ?> value="0">Yes</option>

            <option <?php if($bsiCore->config['conf_payment_commission'] == 1){ ?>selected="selected"<?php } ?> value="1">No</option> 

          </select> (Agent Payment: Yes - with commission, No - Without commission)</td>

      </tr>

      <tr>

        <td valign="top"><strong>Hotel Price Manager</strong></td>

        <td><input type="radio" name="hotel_price_listing" id="hotel_price_listing" value="1" <?php if($bsiCore->config['hotel_price_listing'] == 1){ ?>checked="checked" <?php } ?>>&nbsp;Enable<br>

        <input type="radio" name="hotel_price_listing" id="hotel_price_listing" value="0" <?php if($bsiCore->config['hotel_price_listing'] == 0){ ?>checked="checked" <?php } ?>>&nbsp;Disable</td>

      </tr>

    </tbody>

  </table>

  </div>

  </div>

  <button style="margin-left:170px"class="button_colour round_all"><img height="24" width="24" alt="Bended Arrow Right" src="images/icons/small/white/bended_arrow_right.png"><span>Update</span></button>

</form>

</div>

<div style="padding-right:8px;">

  <?php include("footer.php"); ?>

</div>

</body>

</html>