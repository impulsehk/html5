<?php
	include("access.php");
	if(!isset($_GET['agent_id'])){
		header("location:agent_list.php");
	}
	$pageid = 41;
	include("header.php"); 
?>
			<div class="flat_area grid_16">
            <button class="button_colour" style="float:right; padding-right:0px; margin-right:0px;" onclick="javascript:window.location.href='agent_list.php'"><img height="24" width="24" alt="Bended Arrow Right" src="images/icons/small/white/bended_arrow_right.png"><span>Back</span></button>
					<h2>Agent Details</h2>
				</div>
				<div class="box grid_16 round_all">
					<h2 class="box_head grad_colour round_top">&nbsp;&nbsp;</h2>	
					<a href="#" class="grabber">&nbsp;</a>
					<a href="#" class="toggle">&nbsp;</a>
					<div class="block no_padding">
<?php $agent_id=$bsiCore->ClearInput(base64_decode($_GET['agent_id']));
	  $row=$bsiCore->getAgentrow($agent_id); ?>
                    	<table class="static" cellpadding="8">
                             <tbody id="getFaqform"><?php $agent_id=base64_encode($row['agent_id']);?>
                                <tr><td  width="20%"><b>Company Name</b></td><td ><?=$row['company']?></td></tr>
                             	<tr><td  width="20%"><b>First Name</b></td><td ><?=$row['fname']?></td></tr>
                                <tr><td  width="20%"><b>Last Name</b></td><td ><?=$row['lname']?></td></tr>
                                <tr><td  width="20%"><b>Email Id</b></td><td ><?=$row['email']?></td></tr>
                                <tr><td  width="20%"><b>Phone</b></td><td ><?=$row['phone']?></td></tr>
                                <tr><td  width="20%"><b>Fax</b></td><td ><?=$row['fax']?></td></tr>
                                <tr><td  width="20%"><b>Address</b></td><td ><?=$row['address']?></td></tr>
                                <tr><td  width="20%"><b>City</b></td><td ><?=$row['city']?></td></tr>
                                <tr><td  width="20%"><b>State</b></td><td ><?=$row['state']?></td></tr>
                                <tr><td  width="20%"><b>Country</b></td><td ><?=$bsiCore->getCountryName($row['country'])?></td></tr>
                                <tr><td  width="20%"><b>Zip Code</b></td><td ><?=$row['zipcode']?></td></tr>
                                <tr><td  width="20%"><b>Status</b></td><td ><?php if($row['status']==0){echo '<font color="#990000"><b>Disabled</b></font';}else{echo '<font color="#006600"><b>Enabled</b>';}?></td></tr>
                                <tr><td  width="20%"><b>Commission</b></td><td ><?=$row['commission']?><span>&nbsp;%</span></td></tr>
                                <tr><td  ><b>Register Date</b></td><td ><?php $date=$row['register_date']; $date=explode("-",$date); echo $date[2]."/".$date[1]."/".$date[0]; ?></td></tr>
                             </tbody>
                            </table>   
					</div>
			</div>

			
		</div>
		
		</body>
	</html>