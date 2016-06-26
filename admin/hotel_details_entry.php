<?php 
//echo $_SERVER['SERVER_NAME'];die;

include("access.php");


if(isset($_POST['submit'])){

//print_r($_POST);die;
	include("../includes/db.conn.php");


	include("../includes/conf.class.php");


	include("../includes/admin.class.php");
	
	include("../includes/mail.class.php");

    $bsimail=new bsiMail();
	
	$bsiAdminMain->hotel_addedit_entry(); 

    $bsiAdminMain->create_map_json();
	header('Location:hotel_list.php');


}


if(!isset($_GET['addedit']) || $_GET['addedit'] != 1){


  header("location:hotel_list.php");


}


if(!isset($_GET['hotel_id']) || $_GET['hotel_id'] == ""){


  header("location:hotel_list.php");	


}


$pageid = 9;


include("header.php");


?>
<?php 


	if(isset($_REQUEST['addedit'])){	


	$hotel_id=$bsiCore->ClearInput(base64_decode($_REQUEST['hotel_id']));


	if($hotel_id){


		$row_1        = $bsiCore->getHotelName($hotel_id);


		$country_code = $row_1['country_code'];
		
		$cname= $row_1['city_name'];


		$getCountry   = $bsiAdminMain->getCountrydropdown($country_code);


		$star_rating  = $bsiAdminMain->star_rating($row_1['star_rating']);


		$petsallowed  = $bsiAdminMain->pets_status($row_1['pets_status']);


		$hotel_status = $bsiAdminMain->status($row_1['status']);


		$class        = '';


		$text         = '<span style="color:#900;">&nbsp;&nbsp;(Leave Blank For Previous Password)</span>';


		if($row_1['default_img'] != "" || $row_1['default_img'] != NULL){


			$image        = '<span style="padding-left:50px;"><a rel="collection" href="../gallery/hotelImage/'.$row_1['default_img'].'" target="_blank">View Image</a></span>';


		}else{


			$image        = '&nbsp;&nbsp;&nbsp;&nbsp; <b>No Image</b>';


		}


	}else{


		$row_1=NULL;


		$star_rating  = $bsiAdminMain->star_rating(0);


		$petsallowed  = $bsiAdminMain->pets_status(0);
         $cname=' ';

		$getCountry   = $bsiAdminMain->getCountrydropdown("US");


		$hotel_status = $bsiAdminMain->status(0);


		$class        = 'class="required"';


		$text         = '';


		$image        = '';


	}


?>
<script type="text/javascript" src="js/jquery.validate.js"></script>
<script src="//cdn.ckeditor.com/4.5.1/standard/ckeditor.js"></script>
<script>


	$(document).ready(function(){


		$("#hotelDetails-entry").validate();


		$("#email_addr").blur(function(){


			//alert($("#email_addr").val());


			if($("#email_addr").val() != "" || $("#email_addr").val() != null){


				var querystr = 'actioncode=25&email='+$('#email_addr').val();


				//alert(querystr);


				$.post("admin_ajax_processor.php", querystr, function(data){										 


				if(data.errorcode == 0){


					$('#checkemail').html(data.strmsg);


					$('#button').attr('disabled', 'disabled');


				}else{


					//$('#checkemail').html(data.strmsg);


					$('#button').removeAttr('disabled');


				}


			  }, "json");	


				


			}


			


		});
          
		  if($("#country_code").val() != ' '){
			   generateCity();
		  }

		$("#country_code").change(function(){
			  generateCity();
			
			});
			
			function generateCity(){
				var querystr = 'actioncode=27&country_code='+$('#country_code').val()+'&cname=<?php echo $cname;?>';
				  $.post("admin_ajax_processor.php", querystr, function(data){
					  
					    if(data.errorcode == 0){
							//alert(data.strmsg);
							$('#city_name').html(data.strmsg);
						}
				    }, "json");		
			}


		$("#email_addr").focus(function(){


			  $('#checkemail').html("");


		});


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
  <button class="button_colour" style="float:right; padding-right:0px; margin-right:0px;" onclick="javascript:window.location.href='<?=$_SERVER['HTTP_REFERER']?>'"><img height="24" width="24" alt="Bended Arrow Right" src="images/icons/small/white/bended_arrow_right.png"><span>back</span></button>
  <h2>Hotel Add / Edit</h2>
</div>
<div class="box grid_16 round_all">
  <h2 class="box_head grad_colour round_top">&nbsp;</h2>
  <a href="#" class="grabber">&nbsp;</a> <a href="#" class="toggle">&nbsp;</a>
  <div class="block no_padding">
    <form name="hotelDetails-entry" id="hotelDetails-entry" method="post" action="<?=$_SERVER['PHP_SELF']?>" enctype="multipart/form-data" >
      <table cellpadding="5" cellspacing="0" border="0" width="100%">
        <input type="hidden"  name="hotel_id" value="<?=$hotel_id?>" />
        <tr>
          <td></td>
          <td></td>
        </tr>
        <tr>
          <td  ><label>Hotel Name : </label></td>
          <td align="left"><input style="width:250px;" type="text" class="required" id="hotel_name" name="hotel_name" value="<?=$row_1['hotel_name']?>"></td>
        </tr>
        <tr>
          <td ><label>Address 1 : </label></td>
          <td align="left"><input style="width:250px;"type="text" class="required" id="address1" name="address_1"  value="<?=$row_1['address_1']?>"></td>
        </tr>
        <tr>
          <td  ><label>Address 2 : </label></td>
          <td align="left"><input style="width:250px;" type="text" id="address2" name="address_2"  value="<?=$row_1['address_2']?>"></td>
        </tr>
        <tr>
          <td ><label>State : </label></td>
          <td align="left"><input style="width:250px;" type="text" id="state" name="state" value="<?=$row_1['state']?>"></td>
        </tr>
        <tr>
          <td  ><label>Postal Code : </label></td>
          <td align="left"><input style="width:60px;" type="text" class="required" id="post_code" name="post_code"  value="<?=$row_1['post_code']?>"></td>
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
<td  ><label>Latitude : </label></td>
<td align="left"><input style="width:92px;" type="text" id="latitude" name="latitude"  value="<?=$row_1['latitude']?>"></td>
</tr>
        
<tr>
<td  ><label>Longitude : </label></td>
<td align="left"><input style="width:92px;" type="text" id="longitude" name="longitude"  value="<?=$row_1['longitude']?>"></td> 
</tr>
        
        <tr>
          <td ><label>Email Id : </label></td>
          <td align="left"><input style="width:245px;" type="text" class="required email" id="email_addr" name="email_addr"  value="<?=$row_1['email_addr']?>">
            &nbsp;&nbsp;<span id="checkemail"></span></td>
        </tr>
        <tr>
          <td ><label>Password : </label></td>
          <td align="left"><input style="width:250px;" type="password" <?=$class?> id="password" name="password"  value="">
            <input type="hidden" value="<?=$row_1['password']?>" name="pre_pass" />
            <?=$text?></td>
        </tr>
        <tr>
          <td  ><label>Hotel Image : </label></td>
          <input type="hidden" name="pre_img" value="<?=$row_1['default_img']?>" />
          <td align="left"><input type="file" name="default_img" id="default_img" />
            <?=$image?></td>
        </tr>
        <tr>
          <td  ><label>Star Rating : </label></td>
          <td align="left"><?=$star_rating?></td>
        </tr>
        <tr>
          <td ><label>Phone Number : </label></td>
          <td align="left"><input style="width:92px;" type="text" class="required" id="phone_number" name="phone_number"  value="<?=$row_1['phone_number']?>"></td>
        </tr>
        <tr>
          <td  ><label>Fax Number : </label></td>
          <td align="left"><input style="width:92px;" type="text" id="fax_number" name="fax_number" value="<?=$row_1['fax_number']?>"></td>
        </tr>
        <tr>
          <td  valign="top"><label>Short Description : </label></td>
          <td align="left"><textarea name="desc_short" id="desc_short" cols="100" maxlength='300'  style="height:60px;"><?=$row_1['desc_short']?>


</textarea>
            <div id='CharCountLabel1'></div></td>
        </tr>
        <tr>
          <td valign="top"><label>Long Description : </label></td>
          <td align="left"><textarea id="editor2" class="ckeditor" name="desc_long"><?=$row_1['desc_long']?>


</textarea></td>
        </tr>
       <!-- <tr>
          <td><label>CheckIn Time : </label></td>
          <td align="left"><input style="width:92px;" type="text" class="required" id="checking_hour" name="checking_hour" value="<?=$row_1['checking_hour']?>"></td>
        </tr>
        <tr>
          <td><label>CheckOut Time : </label></td>
          <td align="left"><input style="width:92px;" type="text" class="required" id="checkout_hour" name="checkout_hour" value="<?=$row_1['checkout_hour']?>"></td>
        </tr>
        <tr>
          <td><label>Pets Allowed : </label></td>
          <td align="left"><?=$petsallowed?></td>
        </tr>-->
         <tr>
          <td  valign="top"><label>Hotel Policies: </label></td>
          <td align="left"><textarea id="editor3" class="ckeditor" name="hotel_policies"><?=$row_1['hotel_policies']?>


</textarea></td>
        </tr>
        <tr>
          <td  valign="top"><label>Customer Note's: </label></td>
          <td align="left"><textarea id="editor3" class="ckeditor" name="customer_notes"><?=$row_1['customer_notes']?>


</textarea></td>
        </tr>
        
        <tr>
          <td  valign="top"><label>Terms & Conditions: </label></td>
          <td align="left"><textarea id="editor3" class="ckeditor" name="terms_n_cond"><?=$row_1['terms_n_cond']?>


</textarea></td>
        </tr>
        
        <tr>
          <td><label>Status : </label></td>
          <td align="left"><?=$hotel_status?></td>
        </tr>
        <tr>
          <td></td>
          <td ><button name="submit" id="button" class="button_colour round_all"><img height="24" width="24" alt="Bended Arrow Right" src="images/icons/small/white/bended_arrow_right.png"><span>Submit</span></button></td>
        </tr>
      </table>
    </form>
    <?php } ?>
  </div>
</div>
</div>
<div id="loading_overlay">
  <div class="loading_message round_bottom">Loading...</div>
</div>
<div style="padding-right:8px;">
  <?php include("footer.php"); ?>
</div>
</body></html>