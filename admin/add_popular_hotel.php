<?php
	include("access.php"); 
	if(isset($_POST['submit'])){
	//print_r($_POST);die;  
		include("../includes/db.conn.php");
		include("../includes/conf.class.php");
		include("../includes/admin.class.php");	
		$bsiAdminMain->updatePopularHotel();
		header("location:add_popular_hotel.php");
	}
	$pageid = 56;
	include("header.php");
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
					<!--<h2>Email Template</h2>-->
				</div>
				<div class="box grid_16 round_all">
					<h2 class="box_head grad_colour round_top">Popular Hotel 
                    <!--<select id="email_id" name="email_id"><?=$emaillist?></select>-->
                    </h2>	
					<a href="#" class="grabber">&nbsp;</a>
					<a href="#" class="toggle">&nbsp;</a>
					<div class="block no_padding">
                    <form name="update_con" id="update_con" action="<?=$_SERVER['PHP_SELF']?>" method="post">
                    	<table  cellpadding="8">
						<br>
						<?php
						$gethtml885='';
		    $cres=mysql_query("select * from bsi_hotels where  status=1");
			 while($row77=mysql_fetch_assoc($cres)){
				 
					
				$sql=mysql_query("select `hotel_id` from bsi_popular_hotel where hotel_id=".$row77['hotel_id']);
				
				if(mysql_num_rows($sql))
				{
					$gethtml885.='<option value="'.$row77['hotel_id'].'" selected="selected">'.$row77['hotel_name'].'</option>';
				}
				else
				{
					$gethtml885.='<option value="'.$row77['hotel_id'].'">'.$row77['hotel_name'].'</option>';
				}
				
				
						//if(mysql_num_rows($sql2))
						
						//if($rows[]==$row77[])
					//	$gethtml885.='<option value="'.$row77['hotel_id'].'" selected="selected">'.$row77['hotel_name'].'</option>';
					//	else
				
				
				 
			 }
		
						
		?>				
						
		 <tr>
          <td  valign="top"><label>Select Hotel : </label></td>
          <td align="left"> <select multiple="multiple" name="popularhotel[]" style="width:200px" id="popularhotel" class="required">
		  <?=$gethtml885?>
            </select></td>
        </tr>  
                       
								
								
								<tr>
          <td></td>
          <td ><button name="submit" id="button" class="button_colour round_all"><img height="24" width="24" alt="Bended Arrow Right" src="images/icons/small/white/bended_arrow_right.png"><span>Submit</span></button></td>
        </tr>
                                 
                            </table>  
                            </form> 
					</div>
			</div>

			
		</div>
		 <div style="padding-right:8px;"><?php include("footer.php"); ?></div> 
		</body>
	</html>