<?php
	include("access.php"); 
	if(isset($_POST['c_update'])){
		include("../includes/db.conn.php");
		include("../includes/conf.class.php");
		include("../includes/admin.class.php");	
		$bsiAdminMain->updateEmailContent();
		header("location:email_confirmation.php");
	}
	$pageid = 36;
	include("header.php");
	$emaillist=$bsiAdminMain->getEmailContents();	  
?>

<script type="text/javascript" src="js/jquery.validate.js"></script>
<script type="text/javascript">
$(document).ready(function(){
	$('#update_con').validate();
	$('#email_id').change(function(){
		if($('#email_id').val()!=0){
			jQuery("#submit:button").removeAttr("disabled");
			var selectid=$('#email_id').val();
			var querystr='actioncode=16&choiceid='+$('#email_id').val();
			$.post("admin_ajax_processor.php", querystr, function(data){						 
				if(data.errorcode == 0){
					$('#email_sub').val(data.viewcontent);
					$('#c_update').val(data.viewcontent1);
					$('#email_con').val(data.viewcontent2);
				}else{
					$('#email_sub').val('');
					$('#email_con').val('');
				}
			}, "json");
		}else{
			$('#email_sub').val('');
			$('#email_con').val('');
		}
	});
});	
</script>
<div class="flat_area grid_16">
					<h2>Email Template</h2>
				</div>
				<div class="box grid_16 round_all">
					<h2 class="box_head grad_colour round_top">Select Email Type
                    <select id="email_id" name="email_id"><?=$emaillist?></select>
                    </h2>	
					<a href="#" class="grabber">&nbsp;</a>
					<a href="#" class="toggle">&nbsp;</a>
					<div class="block no_padding">
                    <form name="update_con" id="update_con" action="<?=$_SERVER['PHP_SELF']?>" method="post">
                    	<table  cellpadding="8">
                        <tr><td><input type="hidden" id="c_update" name="c_update" /></td></tr>
                            <tr>
                                    <td >
                                       <strong>Email Subject : </strong>
                                    </td>
                                    <td align="left">
                                        <input style="width:350px;" type="text" id="email_sub" name="email_sub" class="required" />
                                    </td>
                                </tr>
                                <tr>
                                    <td valign="top">
                                        <strong>Email Content : </strong>
                                    </td>
                                    <td align="left">
                                         <textarea name="email_con" id="email_con"  cols="120" class="required"  style="height:250px;"></textarea>					
                                    </td>
                                </tr>
                                 <tr><td></td>
                                    <td >
                                        <button name="submit" class="button_colour round_all" style="margin-left:270px;" id="submit" disabled><img height="24" width="24" alt="Bended Arrow Right" src="images/icons/small/white/bended_arrow_right.png"><span>Update</span></button>
                                    </td>
                                </tr>
                            </table>  
                            </form> 
					</div>
			</div>

			
		</div>
		 <div style="padding-right:8px;"><?php include("footer.php"); ?></div> 
		</body>
	</html>