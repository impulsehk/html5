<?php 
include("access.php");
 if(isset($_POST['act_sbmt'])){
	include("../includes/db.conn.php");
	$month_num=$_POST;
	for($i=1;$i<=12;$i++){
		mysql_query("update bsi_deposit_discount set discount_percent='".$month_num[$i]."' where month_num=".$i);
	}
	header("location:deposit_discount.php");
 }
 
  if(isset($_POST['act_save'])){
		include("../includes/db.conn.php");
		$month_num1=$_POST;
		for($j=1;$j<=12;$j++){
			mysql_query("update bsi_deposit_discount set deposit_percent='".$month_num1[$j]."' where month_num=".$j);
		}
		header("location:deposit_discount.php");
 }
    $pageid = 25;
	include("header.php");
	$dis_val='';
	$depo_val='';
	if($bsiCore->config['conf_enabled_discount']==1){
	$dis_val=1;
	$discount_check="checked";
	}else{
	$dis_val=0;
	$discount_check="";	
	}
	if($bsiCore->config['conf_enabled_deposit']==1){
		$depo_val=1;
	$deposit_check="checked";
	}else{
		$depo_val=0;
	$deposit_check="";
	}
?>


<script type="text/javascript">
$(document).ready(function(){
		if(<?=$dis_val?>==1){							 
			
			showDiscount();
		}
		if(<?=$depo_val?>==1){								 
			showDeposit();
		}
  		$('#chk_discount').click(function() { 
			showDiscount();		
		});
	function showDiscount(){
		 var chk_discount=$('#chk_discount').attr('checked');
			var querystr = 'actioncode=15&type=1&chk_discount='+chk_discount; 
			//alert(querystr);
			$.post("admin_ajax_processor.php", querystr, function(data){						
				//alert(data.errorcode);						  
				if(data.errorcode == 0){					 
					$('#showdiscount').html('<tr><td colspan=3 align="center"><img src="images/ajax-loader(1).gif" /></td></tr>');
					$('#showdiscount').html(data.getresult)
					//alert(data.getresult);
				}
			}, "json");
	}
		
		$('#chk_deposit').click(function() {
			showDeposit();		
		});
		
		function showDeposit(){
		 var chk_discount=$('#chk_deposit').attr('checked');
			var querystr = 'actioncode=15&type=2&chk_deposit='+chk_discount; 
			//alert(querystr);
			$.post("admin_ajax_processor.php", querystr, function(data){						
				//alert(data.errorcode);						  
				if(data.errorcode == 0){
					$('#showdeposit').html(data.getresult)
					//alert(data.getresult);

				}
				}, "json");
	}
		
		
});
			
	</script>


<div class="box grid_8">
  <h2 class="box_head grad_colour round_top">Monthly Discount Scheme</h2>
  <a href="#" class="grabber">&nbsp;</a> <a href="#" class="toggle">&nbsp;</a>
  <div class="toggle_container">
    <div class="block no_padding">
    <form action="" method="post">
      <table class="static"  cellpadding="6">
        <thead>
          <tr>
            <th colspan="2" align="left"><input type="checkbox" <?=$discount_check?>  id="chk_discount" name="chk_discount" value=""/>Enabled Monthly discount scheme?</th>
           
          </tr>
        </thead>
        <tbody id="showdiscount">
        </tbody>
      </table>
      </form>
    </div>
  </div>
</div>
<div class="box grid_8">
  <h2 class="box_head grad_colour round_top">Monthly Deposit Scheme</h2>
  <a href="#" class="grabber">&nbsp;</a> <a href="#" class="toggle">&nbsp;</a>
  <div class="toggle_container">
    <div class="block no_padding">
    <form action="" method="post">
      <table class="static" cellpadding="6">
        <thead>
          <tr>
            <th colspan="2" align="left"><input type="checkbox" <?=$deposit_check?>  id="chk_deposit" name="chk_deposit" value=""/>Enabled Monthly deposit scheme?</th>
            
          </tr>
        </thead>
        <tbody id="showdeposit">
        </tbody>
      </table>
      </form>
    </div>
  </div>
</div>
</div>
<div style="padding-right:8px;"><?php include("footer.php"); ?></div>
</body></html>