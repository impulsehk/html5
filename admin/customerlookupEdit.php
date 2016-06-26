<?php
include ("access.php"); 
if(isset($_POST['act'])){
	include("../includes/db.conn.php");
	include("../includes/admin.class.php");
	$bsiAdminMain->updateCustomerLookup();
	header("location:customerlookup.php"); 
	exit;
}
$update=base64_decode($_GET['update']);
$pageid = 29;
include("header.php");
if(isset($update)){
	//include("../includes/admin.class.php");
	$row   = $bsiAdminMain->getCustomerLookup($update);
	$title = $bsiAdminMain->getTitle($row['title']);
	$conty = $bsiAdminMain->country($row['country']);
}else{
	header("location:customerlookup.php");
}
?>
<script type="text/javascript" src="js/jquery.validate.js"></script>
<script>
$(document).ready(function() {
	 $("#customerFrm").validate();
     });
</script>
<div class="flat_area grid_16">
  <button name="button" onclick="javascript:window.location.href='<?=$_SERVER['HTTP_REFERER']?>'" id="button" class="button_colour round_all" style="float:right;"><img height="24" width="24" alt="Bended Arrow Right" src="images/icons/small/white/bended_arrow_right.png"><span>Back</span></button><h2>Customer Lookup Edit</h2>
</div>
<div class="box grid_16 round_all">
  <h2 class="box_head grad_colour round_top">&nbsp;</h2>
  <a href="#" class="grabber">&nbsp;</a> <a href="#" class="toggle">&nbsp;</a>
  <div class="toggle_container">
  <div class="block no_padding">
    <form method="post" action="<?=$_SERVER['PHP_SELF']?>" name="customerFrm" id="customerFrm">
      <table cellpadding="6" border="0">
      <!--<tr><td align="left" width="100px"><strong>Title:</strong></td>
      <td><?=$title?>
      </td>
      </tr>-->
        <tr>
          <td align="left" width="100px"><strong>Name:</strong></td>
          <td><input type="text" class="required" value="<?=$row['first_name']?>" style="width:200px;" name="fname" id="fname"/></td>
        </tr>
        <!--<tr>
          <td align="left"><strong>Sur Name:</strong></td>
          <td><input type="text" class="required" value="<?=$row['surname']?>" style="width:200px;" name="sname" id="sname"/></td>
        </tr>-->
         <!--<tr>
          <td align="left"><strong>Street Address:</strong></td>
          <td><input type="text" class="required" value="<?=$row['street_addr']?>" style="width:250px;" name="sadd" id="sadd"/></td>
        </tr>
        <tr>
          <td align="left"><strong>City:</strong></td>
          <td><input type="text" class="required" value="<?=$row['city']?>"  name="city" id="city"/></td>
        </tr>
        <tr>
          <td align="left"><strong>Province:</strong></td>
          <td><input type="text" class="required" value="<?=$row['province']?>"  name="province" id="province"/></td>
        </tr>
        <tr>
          <td align="left"><strong>Zip:</strong></td>
          <td><input type="text" class="required" value="<?=$row['zip']?>"  name="zip" id="zip"/></td>
        </tr>
        <tr>
          <td align="left"><strong>Country:</strong></td>
          <td><?=$conty?></td>
        </tr>-->
        <tr>
          <td align="left"><strong>Phone:</strong></td>
          <td><input type="text" class="required" value="<?=$row['phone']?>"  name="phone" id="phone"/></td>
        </tr>
        <!--<tr>
          <td align="left"><strong>Fax:</strong></td>
          <td><input type="text" class="" value="<?=$row['fax']?>"  name="fax" id="fax"/></td>
        </tr>-->
        <tr>
          <td align="left"><strong>Email:</strong></td>
          <td><input type="text" value="<?=$row['email']?>"  name="email" id="email" style="width:250px;" readonly/><input type="hidden" name="httpreffer" value="<?=$_SERVER['HTTP_REFERER']?>" /></td>
        </tr>
         
       <input type="hidden" name="cid" value="<?=$row['client_id']?>">
       <input type="hidden" name="act" value="1">
   <tr><td  width="100px"></td><td align="left"><button class="button_colour round_all" type="submit"  name="submit"><img height="24" width="24" alt="Bended Arrow Right" src="images/icons/small/white/bended_arrow_right.png"><span>Submit</span></button></td></tr>
    </table>
    </form>
  				</div>
			</div>
		</div></div><div style="padding-right:8px;"><?php include("footer.php"); ?></div>
	</body>
</html>