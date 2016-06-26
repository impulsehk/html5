<?php 
    include("access.php");
	if(isset($_POST['act_sbmt'])){
		include("../includes/db.conn.php");
		include("../includes/conf.class.php");
		include("../includes/admin.class.php");
		$bsiAdminMain->payment_gateway_post();
		header("location:payment_gateway.php");
	}
	$pageid = 19;
	include("header.php");
	$payment_gateway_val=$bsiAdminMain->payment_gateway();
?>
<script type="text/javascript" src="js/jquery.validate_pp.js"></script>
 <script>
  $(document).ready(function(){
    $("#paymentg").validate(); 
  });
  </script>
			<div class="flat_area grid_16">
				<h2>Payment Method</h2> 
			</div>
			<div class="box grid_16 round_all">
                <h2 class="box_head grad_colour round_top">&nbsp;</h2>
                <a href="#" class="grabber">&nbsp;</a>
                <a href="#" class="toggle">&nbsp;</a>
                <div class="block no_padding">            	
                    <form action="<?=$_SERVER['PHP_SELF']?>" id="paymentg" name="paymentg" method="post">
<table  cellpadding="8">
<thead>
     <th width="8%" style="background-color:#3e4753; color:#FFF;"><strong>Enabled</strong></th>
     <th width="6%" style="background-color:#3e4753;color:#FFF;"><strong>Order</strong></th>
     <th width="10%" style="background-color:#3e4753;color:#FFF;"><strong>Gateway</strong></th>
     <th width="20%" style="background-color:#3e4753;color:#FFF;"><strong>Title</strong></th>
     <th width="56%" style="background-color:#3e4753;color:#FFF;"><strong>Account Info</strong></th>
</thead>
<tr>
    <td><input type="checkbox" name="pp" value="pp" id="pp" <?=($payment_gateway_val['pp_enabled']) ? 'checked="checked"' : ''; ?>></td>
    <td><input name="pp_order"  id="pp_order" class="required number" type="text" value="<?=$payment_gateway_val['pp_order']?>" style="width:20px;"/></td>
    <td>Paypal</td>
    <td><input  name="pp_title" id="pp_title" class="required" value="<?=$payment_gateway_val['pp_gateway_name']?>" type="text" style="width:150px;"/></td>
    <td><input type="text" name="paypal_id" id="paypal_id" class="required email" value="<?=$payment_gateway_val['pp_account']?>" style="width:250px;"/><span style="margin-left:4px;">(enter Your Paypal Email)</span></td>
</tr>
<!--<tr>
    <td><input type="checkbox" name="2co" value="2co" id="2co" <?=($payment_gateway_val['co_enabled']) ? 'checked="checked"' : ''; ?>></td>
    <td><input name="2co_order"  id="2co_order" class="required number" type="text" value="<?=$payment_gateway_val['co_order']?>" style="width:20px;"/></td>
    <td>2Checkout</td>
    <td><input name="2co_title" id="2co_title" class="required" value="<?=$payment_gateway_val['co_gateway_name']?>" type="text" style="width:150px;"/></td>
    <td><input name="2co_id" id="2co_id" class="email" value="<?=$payment_gateway_val['co_account']?>" type="text" style="width:250px"/><span style="margin-left:4px;">(enter your 2checkout vendor id.)</span></td>
</tr>-->
<tr>
    <td><input type="checkbox" name="cc" value="cc" id="cc" <?=($payment_gateway_val['cc_enabled']) ? 'checked="checked"' : ''; ?>/></td>
    <td><input title="order" name="cc_order" class="required number" id="cc_order" type="text" value="<?=$payment_gateway_val['cc_order']?>" style="width:20px;"/></td>
    <td>Credit Card</td>
    <td><input name="cc_title" id="cc_title" class="required" value="<?=$payment_gateway_val['cc_gateway_name']?>" type="text" style="width:150px;"/></td>
    <td>&nbsp;</td>
</tr>
<tr>
    <td><input type="checkbox" name="poa" value="poa" id="poa" <?=($payment_gateway_val['poa_enabled']) ? 'checked="checked"' : ''; ?>/></td>
    <td><input name="poa_order" class="required number"  id="poa_order" type="text" value="<?=$payment_gateway_val['poa_order']?>" style="width:20px;"/></td>
    <td>Manual</td>
    <td><input name="poa_title" id="poa_title" class="required" value="<?=$payment_gateway_val['poa_gateway_name']?>" type="text" style="width:150px;"/></td>
    <td>&nbsp;</td>
</tr>
<!--<tr>
    <td><input type="checkbox" name="an" value="an" id="an" <?=($payment_gateway_val['an_enabled']) ? 'checked="checked"' : ''; ?>></td>
    <td><input name="an_order" class="required number"  id="an_order" type="text" value="<?=$payment_gateway_val['an_order']?>" style="width:20px;"/></td>
    <td>Authorize.Net</td>
    <td><input name="an_title" id="an_title" class="required" value="<?=$payment_gateway_val['an_gateway_name']?>" type="text" style="width:150px;"/></td>
    <td>
   API Login ID:<span style="margin-left:8px;"><input type="text" class="email" name="an_loginid" size="15" value="<?=$payment_gateway_val['an_login']?>" style="width:120px;"/></span>
            <span style="margin-left:8px;">Transaction Key:</span>
            <span style="margin-left:8px;"><input type="text" class="required" name="an_txnkey" size="15" value="<?=$payment_gateway_val['an_txnkey']?>" style="width:110px;"/></span>
    </td>
</tr>-->
<input type="hidden" name="act_sbmt" value="1" />
<tr><td></td><td><button class="button_colour"><img width="24" height="24" src="images/icons/small/white/bended_arrow_right.png" alt="Bended Arrow Right"/><span>Submit</span></button></td></tr>
<tr><td><font color="#FF0000">*</font><td  colspan="4">Required</td></tr>
<tr><td><font color="#FF0000">**</font><td  colspan="4">Only Number</td></tr>
<tr><td><font color="#FF0000">***</font><td  colspan="4">Must Be Valid Email Id</td></tr>
</table>
                    </form>
        		</div>
			</div>
		</div>
		<div id="loading_overlay">
			<div class="loading_message round_bottom">Loading...</div>
		</div>
        <div style="padding-right:8px;"><?php include("footer.php"); ?></div> 
        </body>
	</html>