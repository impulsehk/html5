<?php
include ("access.php");
$pageid = 14;
include ("header.php");
if($bsiCore->config['conf_enabled_discount']==1)
$discount_check="checked";
else
$discount_check="";

if($bsiCore->config['conf_enabled_deposit']==1)
$deposit_check="checked";
else
$deposit_check="";
?>
<script type="text/javascript" charset="utf-8">
$(document).ready(function() {
   if($('#chk_discount').attr('checked')==true){
   $('#showdiscount').show();
   }else{
   $('#showdiscount').hide();
   }
   
   if($('#chk_deposit').attr('checked')==true){
   $('#showdeposit').show();
   }else{
   $('#showdeposit').hide();
   }
   
   $('#update_msg').hide();
   $('#chk_discount').click(function() { 
			var querystr = 'actioncode=4&chk_discount='+$('#chk_discount').attr('checked'); 	
			$.post("admin_ajax_processor.php", querystr, function(data){												 
				if(data.errorcode == 0){ 
				$('#showdiscount').show();
				$('#update_msg').show();
				$('#update_msg').html(data.strhtml);
				}else{
				$('#showdiscount').hide();
				$('#update_msg').show();
				$('#update_msg').html(data.strhtml);
				}
				
			}, "json");
	 });
	
	
	 $('#chk_deposit').click(function() { 
			var querystr = 'actioncode=4&chk_deposit='+$('#chk_deposit').attr('checked'); 	
			$.post("admin_ajax_processor.php", querystr, function(data){						 
				if(data.errorcode == 0){
				$('#showdeposit').show();
				$('#update_msg').show();
				$('#update_msg').html(data.strhtml);
				}else{
				$('#showdeposit').hide();
				$('#update_msg').show();
				$('#update_msg').html(data.strhtml);
				}
				
			}, "json");
	 });
	 
	 $('#submit_discount').click(function() {
	        var querystr = 'actioncode=28&discount_january='+$('#discount_january').val()+'&discount_february='+$('#discount_february').val()+'&discount_march='+$('#discount_march').val()+'&discount_april='+$('#discount_april').val()+'&discount_may='+$('#discount_may').val()+'&discount_june='+$('#discount_june').val()+'&discount_july='+$('#discount_july').val()+'&discount_august='+$('#discount_august').val()+'&discount_september='+$('#discount_september').val()+'&discount_october='+$('#discount_october').val()+'&discount_november='+$('#discount_november').val()+'&discount_december='+$('#discount_december').val(); 	
			$.post("admin_ajax_processor.php", querystr, function(data){
			   if(data.errorcode == 0){
				   alert('Discount Value Updated Successfully');
				   location.reload();
			   }
			}, "json");
	 });
	 
	 $('#submit_deposit').click(function() { 
	        var querystr = 'actioncode=29&deposit_january='+$('#deposit_january').val()+'&deposit_february='+$('#deposit_february').val()+'&deposit_march='+$('#deposit_march').val()+'&deposit_april='+$('#deposit_april').val()+'&deposit_may='+$('#deposit_may').val()+'&deposit_june='+$('#deposit_june').val()+'&deposit_july='+$('#deposit_july').val()+'&deposit_august='+$('#deposit_august').val()+'&deposit_september='+$('#deposit_september').val()+'&deposit_october='+$('#deposit_october').val()+'&deposit_november='+$('#deposit_november').val()+'&deposit_december='+$('#deposit_december').val(); 	
			//alert(querystr);die;
			$.post("admin_ajax_processor.php", querystr, function(data){
			   if(data.errorcode == 0){
			   		alert('Deposit Value Updated Successfully');
					location.reload();
			   }
			}, "json");
	 });
	 
});
</script>
<div class="box grid_8">
  <h2 class="box_head grad_colour round_top">Monthly Discount Scheme</h2>
  <a href="#" class="grabber">&nbsp;</a> <a href="#" class="toggle">&nbsp;</a>
  <div class="toggle_container">
    <div class="block no_padding">
    
      <table class="static"  cellpadding="4">
        <thead>
          <tr>
            <th colspan="2" align="left"><input type="checkbox" <?=$discount_check?>  id="chk_discount" name="chk_discount" value=""/>Enabled Monthly discount scheme?</th>
           
          </tr>
        </thead>
        <tbody id="showdiscount">
    <?php
		$sql_discount=mysql_query("select * from bsi_deposit_discount");
		while($row_discount=mysql_fetch_assoc($sql_discount)){
	?>
            <tr>
              <td><strong><?=$row_discount['month']?>
                :</strong></td>
              <td><input type="text" name="discount_<?=strtolower($row_discount['month'])?>" id="discount_<?=strtolower($row_discount['month'])?>" size="5" value="<?=$row_discount['discount_percent']?>"/>
                % Total Amount</td>
            </tr>
            <?php } ?>
            <tr>
              <td></td>
              <td>
              <button name="submit_discount" value="1" id="submit_discount" class="button_colour round_all" ><img height="24" width="24" alt="Bended Arrow Right" src="images/icons/small/white/bended_arrow_right.png"><span>Submit</span></button></td>
            </tr>
        </tbody>
      </table>
      
    </div>
  </div>
</div>
<div class="box grid_8">
  <h2 class="box_head grad_colour round_top">Monthly Deposit Scheme</h2>
  <a href="#" class="grabber">&nbsp;</a> <a href="#" class="toggle">&nbsp;</a>
  <div class="toggle_container">
    <div class="block no_padding">
      <table class="static" cellpadding="4"> 
        <thead>
          <tr>
            <th colspan="2" align="left"><input type="checkbox" <?=$deposit_check?>  id="chk_deposit" name="chk_deposit" value=""/>Enabled Monthly deposit scheme?</th>
            
          </tr>
        </thead>
        <tbody id="showdeposit">
    <?php
		$sql_deposit=mysql_query("select * from bsi_deposit_discount");
		while($row_deposit=mysql_fetch_assoc($sql_deposit)){
	?>
            <tr>
              <td><strong><?=$row_deposit['month']?>
                :</strong></td>
              <td><input type="text" name="deposit_<?=strtolower($row_deposit['month'])?>" id="deposit_<?=strtolower($row_deposit['month'])?>"  size="5" value="<?=$row_deposit['deposit_percent']?>"/>
                % Total Amount</td>
            </tr>
            <?php } ?>
            <tr>
              <td></td>
              <td>
              <button name="submit_deposit" value="1" id="submit_deposit" class="button_colour round_all" ><img height="24" width="24" alt="Bended Arrow Right" src="images/icons/small/white/bended_arrow_right.png"><span>Submit</span></button></td>
            </tr>
        </tbody>
      </table>
    </div>
  </div>
</div>
</div>
<div style="padding-right:8px;"><?php include("footer.php"); ?></div> 
</body>
</html>