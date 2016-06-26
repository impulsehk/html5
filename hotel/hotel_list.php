<?php


include ("access.php");


if(isset($_POST['submit'])){


	include("../includes/db.conn.php");


	include("../includes/conf.class.php");


	include("../includes/admin.class.php");


	$bsiAdminMain->hotel_addedit_entry();


	header('Location:hotel_list.php');


}


include ("header.php");


$row = $bsiAdminMain->getHotelDetails($_SESSION['hhid']);
$cname= $row['city_name'];

$country_code=$row['country_code'];



$getCountry = $bsiAdminMain->getCountrydropdown($country_code);


$petsallowed=$bsiAdminMain->pets_status($row['pets_status']);


$hotel_status= $bsiAdminMain->status($row['status']);


?>
<script type="text/javascript" src="../admin/js/jquery.validate.js"></script>
<script src="//cdn.ckeditor.com/4.5.1/standard/ckeditor.js"></script>
<script>


	$(document).ready(function(){


		$("#hotelDetails-entry").validate();
		if($("#country_code").val() != ' '){
			   generateCity();
		  }

		$("#country_code").change(function(){
			  generateCity();
			
			});
			
			function generateCity(){
				var querystr = 'actioncode=27&country_code='+$('#country_code').val()+'&cname=<?php echo $cname;?>';
				  $.post("../admin/admin_ajax_processor.php", querystr, function(data){
					  
					    if(data.errorcode == 0){
							//alert(data.strmsg);
							$('#city_name').html(data.strmsg);
						}
				    }, "json");		
			}



	});


</script>
<script type='text/javascript'>


CharacterCount = function(TextArea,FieldToCount){


	var desc_short = document.getElementById(TextArea);


	var myLabel = document.getElementById(FieldToCount); 


	if(!desc_short || !myLabel){return false}; // catches errors


	var MaxChars =  desc_short.maxLengh;


	if(!MaxChars){MaxChars =  desc_short.getAttribute('maxlength') ; }; 	if(!MaxChars){return false};


	var remainingChars =   MaxChars - desc_short.value.length


	myLabel.innerHTML = remainingChars+" Characters Remaining of Maximum "+MaxChars


}





//SETUP!!


setInterval(function(){CharacterCount('desc_short','CharCountLabel1')},55);


</script>

<div class="flat_area grid_16">
  <h2>Hotel Details</h2>
</div>
<div class="box grid_16 round_all">
  <h2 class="box_head grad_colour round_top">&nbsp;</h2>
  <a href="#" class="grabber">&nbsp;</a> <a href="#" class="toggle">&nbsp;</a>
  <div class="block no_padding">
    <form name="hotelDetails-entry" id="hotelDetails-entry" method="post" action="<?=$_SERVER['PHP_SELF']?>" enctype="multipart/form-data" >
      <table cellpadding="5" cellspacing="0" border="0" width="100%">
        <tr>
          <td></td>
          <td></td>
        </tr>
        <tr>
          <td  ><label>Hotel Name : </label></td>
          <td align="left"><input style="width:250px;" type="text" class="required" id="hotel_name" name="hotel_name" value="<?=$row['hotel_name']?>"></td>
        </tr>
        <tr>
          <td ><label>Address 1 : </label></td>
          <td align="left"><input style="width:250px;"type="text" class="required" id="address1" name="address_1"  value="<?=$row['address_1']?>"></td>
        </tr>
        <tr>
          <td  ><label>Address 2 : </label></td>
          <td align="left"><input style="width:250px;" type="text" id="address2" name="address_2"  value="<?=$row['address_2']?>"></td>
        </tr>
        <tr>
          <td ><label>State : </label></td>
          <td align="left"><input style="width:250px;" type="text" id="state" name="state" class="required"  value="<?=$row['state']?>"></td>
        </tr>
        <tr>
          <td  ><label>Postal Code : </label></td>
          <td align="left"><input style="width:60px;" type="text" class="required" id="post_code" name="post_code"  value="<?=$row['post_code']?>"></td>
        </tr>
        <tr>
          <td ><label>Country : </label></td>
          <td align="left"><select name="country_code" id="country_code">
              <?=$getCountry?>
            </select></td>
        </tr>
        <tr>
          <td><label>City : </label></td>
          <td align="left" id="city_name"></td>
        </tr>
        <tr>
          <td ><label>Email Id : </label></td>
          <td align="left"><input style="width:250px;" type="text" class="required email" id="email_addr" name="email_addr" readonly="readonly" value="<?=$row['email_addr']?>"></td>
        </tr>
        
          <td ><label>Password: </label></td>
          <td><input type="password" id="password" name="password" size="30" value="" />
            <span style="color:#F00;">&nbsp;&nbsp;(Leave blank for previous password)</span></td>
          <input type="hidden" name="pre_pass" id="pre_pass" value="<?=$row['password']?>" />
        <tr>
          <td  ><label>Hotel Image : </label></td>
          <input type="hidden" name="pre_img" value="<?=$row['default_img']?>" />
          <td align="left"><input type="file" name="default_img" id="default_img" />
            <?php if($row['default_img'] != ""){?>
            <span style="padding-left:50px;"><a rel="collection" href="../gallery/hotelImage/<?=$row['default_img']?>" target="_blank">View Image</a></span>
            <?php }else{ echo "&nbsp;&nbsp;&nbsp;&nbsp; <b>No Image</b>";} ?></td>
        </tr>
        <input type="hidden" name="hotel_id" id="hotel_id" value="<?php echo $_SESSION['hhid']; ?>" />
        <input type="hidden" name="star_rating" id="star_rating" value="<?php echo $row['star_rating']; ?>" />
        <tr>
          <td ><label>Phone Number : </label></td>
          <td align="left"><input style="width:92px;" type="text" class="required" id="phone_number" name="phone_number"  value="<?=$row['phone_number']?>"></td>
        </tr>
        <tr>
          <td  ><label>Fax Number : </label></td>
          <td align="left"><input style="width:92px;" type="text" id="fax_number" name="fax_number" value="<?=$row['fax_number']?>"></td>
        </tr>
        <tr>
          <td  valign="top"><label>Short Description : </label></td>
          <td align="left"><textarea name="desc_short" id="desc_short" cols="100" maxlength='300'  style="height:60px;"><?=$row['desc_short']?>


</textarea>
            <div id='CharCountLabel1'></div></td>
        </tr>
        <tr>
          <td valign="top"><label>Long Description : </label></td>
          <td align="left"><textarea id="editor2" class="ckeditor" name="desc_long"><?=$row['desc_long']?>


</textarea></td>
        </tr>
        <tr>
          <td><label>CheckIn Time : </label></td>
          <td align="left"><input style="width:92px;" type="text" class="required" id="checking_hour" name="checking_hour" value="<?=$row['checking_hour']?>"></td>
        </tr>
        <tr>
          <td><label>CheckOut Time : </label></td>
          <td align="left"><input style="width:92px;" type="text" class="required" id="checkout_hour" name="checkout_hour" value="<?=$row['checkout_hour']?>"></td>
        </tr>
        <tr>
          <td><label>Pets Allowed : </label></td>
          <td align="left"><?=$petsallowed?></td>
        </tr>
        <tr>
          <td  valign="top"><label>Terms & Conditions: </label></td>
          <td align="left"><textarea id="editor3" class="ckeditor" name="terms_n_cond"><?=$row['terms_n_cond']?>


</textarea></td>
        </tr>
        <tr>
          <td><label>Status : </label></td>
          <td align="left"><?=$hotel_status?></td>
        </tr>
        <tr>
          <td></td>
          <td ><button name="submit" class="button_colour round_all"><img height="24" width="24" alt="Bended Arrow Right" src="../admin/images/icons/small/white/bended_arrow_right.png"><span>Submit</span></button></td>
        </tr>
      </table>
    </form>
  </div>
</div>
</div>
<div style="padding-right:8px;">
  <?php include("footer.php"); ?>
</div>
</body></html>