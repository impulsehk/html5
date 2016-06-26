<?php 
	include("access.php");	
	if(isset($_POST['submit'])){
		include("../includes/db.conn.php");
		include("../includes/conf.class.php");
		include("../includes/admin.class.php");
		$bsiAdminMain->agent_addedit_entry();
		if(!$_POST['agent_id']){
			include("../includes/mail.class.php");
			$bsiMail    = new bsiMail();
			$subject    = 'Your Registration with us is successful';
			$emailBody  = "Dear ".$_POST['fname']." ".$_POST['lname']." ,<br>";
			$emailBody .= "Your Registration with us is successful.<br>";
			$emailBody .= "Your Email Id : ".$_POST['email']." and Password : ".$_POST['password'];
			$emailBody .= '<br><br>Regards,<br>';
			$emailBody .= '<font style=\"color:#F00; font-size:10px;\">'.$bsiCore->config['conf_portal_name'].'</font>';
			$send       = $bsiMail->sendEMail($_POST['email'], $subject, $emailBody);
		}
		header('Location:agent_list.php');
	}
	$pageid = 41;
	include("header.php");
	if(isset($_REQUEST['agent_id']) && (base64_decode($_REQUEST['agent_id']) != 0)){
		$agent_id      = $bsiCore->ClearInput(base64_decode($_REQUEST['agent_id']));
		$row           = $bsiAdminMain->getAgent($agent_id);								
		$country_list  = $bsiAdminMain->country($row['country']);
		$status        = $bsiAdminMain->status($row['status']);
		$readonly      = 'readonly="readonly"';
		$field         = '<input type="hidden" name="agent_id" id="agent_id" value="'.$row['agent_id'].'"/>';
	}else{
		$row           = NULL;
		$status        = $bsiAdminMain->status(0);
		$country_list  = $bsiAdminMain->country("US");
		$readonly      = '';
		$temp_password = substr(uniqid(), -6, 6);
		$field         = '<input type="hidden" name="agent_id" id="agent_id" value=""/>
            			  <input type="hidden" name="password" value="'.$temp_password.'" />';
	}
?>
<script type="text/javascript" src="js/jquery.validate.js"></script>
<script>
  $(document).ready(function(){
    $("#agentFrm").validate();	
  });
  </script>

<div class="flat_area grid_16">
  <button class="button_colour" style="float:right; padding-right:0px; margin-right:0px;" onclick="javascript:window.location.href='agent_list.php'"><img height="24" width="24" alt="Bended Arrow Right" src="images/icons/small/white/bended_arrow_right.png"><span>Back</span></button>
  <h2>
    <?php if($row>0){ ?>
    Agent Details Update Form
    <?php }else{ ?>
    Agent Details Entry Form
    <?php } ?>
  </h2>
</div>
<div class="box grid_16 round_all">
  <h2 class="box_head grad_colour round_top">&nbsp;</h2>
  <a href="#" class="grabber">&nbsp;</a> <a href="#" class="toggle">&nbsp;</a>
  <div class="block no_padding">
    <form name="agentFrm" id="agentFrm" action="<?=$_SERVER['PHP_SELF']?>" method="post" enctype="multipart/form-data">
      <table cellpadding="5">
        <tr>
          <td align="left" width="150" ><strong>Company Name</strong></td>
          <td><input type="text"  id="cname" name="cname" class="required" value="<?=$row['company']?>"   style="width:200px;"/></td>
        </tr>
        <tr>
          <td align="left" ><strong>First Name</strong></td>
          <td><input   type="text"   id="fname" name="fname" value="<?=$row['fname']?>" style="width:200px;" class="required"/></td>
        </tr>
        <tr>
          <td align="left" ><strong>Last Name</strong></td>
          <td><input  type="text" id="lname" name="lname" value="<?=$row['lname']?>"  style="width:200px;" class="required"/></td>
        </tr>
        <tr>
          <td align="left" ><strong>Email Id</strong></td> 
          <td><input  type="text"  id="email" name="email" value="<?=$row['email']?>" <?=$readonly?> style="width:196px;" class="required email" /></td><?=$field?>
        </tr>
        <tr>
          <td align="left" ><strong>Phone</strong></td>
          <td><input  type="text" id="phone" name="phone" value="<?=$row['phone']?>"  style="width:200px;" class="required"/></td>
        </tr>
        <tr>
          <td align="left" ><strong>Fax</strong></td>
          <td><input type="text" id="fax" name="fax" value="<?=$row['fax']?>" style="width:200px;"/></td>
        </tr>
        <tr>
          <td valign="top" ><strong>Address</strong></td>
          <td><textarea name="address" id="address" cols="31" rows="5" class="required"><?=$row['address']?>
</textarea></td>
        </tr>
        <tr>
          <td align="left" valign="top" ><strong>City</strong></td>
          <td valign="top" ><input  type="text"  id="city" name="city" value="<?=$row['city']?>" style="width:200px;" class="required"/></td>
        </tr>
        <tr>
          <td align="left" ><strong>State</strong></td>
          <td><input  type="text"  id="state" name="state" class="required" value="<?=$row['state']?>"  style="width:200px;"/></td>
        </tr>
        <tr>
          <td align="left" ><strong>Country</strong></td>
          <td><?=$country_list?></td>
        </tr>
        <tr>
          <td align="left" ><strong>Zip Code</strong></td>
          <td><input type="text" id="zipcode" name="zipcode" value="<?=$row['zipcode']?>"   style="width:200px;" class="required"/></td>
        </tr>
        <tr>
          <td align="left" ><strong>Status</strong></td>
          <td><?=$status?></td>
        </tr>
        <tr>
          <td align="left" ><strong>Commission</strong></td>
          <td><input  type="text"  id="commission" name="commission" value="<?=$row['commission']?>" style="width:70px;" class="required number"/><span>&nbsp;%</span></td>
        </tr>
        <tr>
          <td></td>
          <td><button name="submit" id="submit" class="button_colour round_all" ><img height="24" width="24" alt="Bended Arrow Right" src="images/icons/small/white/bended_arrow_right.png"><span>Submit</span></button></td>
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