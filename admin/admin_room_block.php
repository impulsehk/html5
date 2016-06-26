<?php
	include("access.php"); 
	
	if(isset($_POST['search_available'])){
		include("../includes/admin.class.php");
		include("../includes/conf.class.php");
	}
	$pageid = 27;
	include("header.php");
	$destination = $bsiCore->getHotelDestination(); 
	$rooms       = $bsiAdminMain->combobox_room();
	$adults      = $bsiAdminMain->combobox_adult();
?>
<script type="text/javascript" src="js/jquery.validate_pp.js"></script>
<script type="text/javascript">
$(document).ready(function(){
	$('#submit').attr("disabled", "disabled");
	$('#admin_booking').validate();
	$("#destination").change(function(){
		if($("#destination").val() != 0){
			$('#submit').removeAttr("disabled");
		}else{
			$('#submit').attr("disabled", "disabled");
		}
	});
});
</script>
<script type="text/javascript">
$(document).ready(function(){
	$.datepicker.setDefaults({ dateFormat: '<?=$bsiCore->config['conf_dateformat']?>' });
    $("#txtFromDate").datepicker({
        minDate: 0,
        maxDate: "+365D",
        numberOfMonths: 2,
        onSelect: function(selected) {
			var date = $(this).datepicker('getDate');
      	    if(date){
                date.setDate(date.getDate() + <?=$bsiCore->config['conf_min_night_booking']?>);
            }
            $("#txtToDate").datepicker("option","minDate", date)
        }
    });
	
    $("#txtToDate").datepicker({ 
        minDate: 0,
        maxDate:"+365D",
        numberOfMonths: 2,
        onSelect: function(selected) {
           $("#txtFromDate").datepicker("option","maxDate", selected)
        }
    }); 
	$("#datepickerImage").click(function() { 
		$("#txtFromDate").datepicker("show");
	});  
	$("#datepickerImage1").click(function() { 
		$("#txtToDate").datepicker("show");
	});
});
</script>
<script type="text/javascript">
	$(document).ready(function(){
		generateRoom();
		//Generate Rooms Start here
		$('#rooms').change(function() { 
			if($('#rooms').val() > $('#adults').val()){
				alert('must be equal or less than Adults'); 
				$('#rooms').val($('#adults').val());
				generateRoom();
			}else{
				generateRoom();
			}
		});
		
		$("#adults").change(function(){
			if($('#adults').val() < $('#rooms').val()){
				alert("must be equal or greater Rooms");
				$('#adults').val($('#rooms').val()); 
				generateRoom();
			}else{
				generateRoom();
			}
		});		
		function generateRoom(){
			var querystr = 'actioncode=23&room='+$('#rooms').val()+'&adult='+$('#adults').val();
			$.post("admin_ajax_processor.php", querystr, function(data){										 
				if(data.errorcode == 0){
					$('#getCapacity').html(data.searchCapacity);
				}else{
					$('#getCapacity').html('No Room Capacity Found');
				}
			}, "json");	
		}
		//Generate Rooms End here
	});
</script> 
<div class="flat_area grid_16">
  <h2>Booking By Administrator
  </h2>
</div>
<div class="box grid_16 round_all">
  <h2 class="box_head grad_colour round_top">&nbsp;</h2>
  <a href="#" class="grabber">&nbsp;</a> <a href="#" class="toggle">&nbsp;</a>
  <div class="block no_padding">
    <form action="admin_bookingSearch.php" method="post" name="admin_booking" id="admin_booking">
	<input type="hidden" name="currency" id="currency" value="<?php echo $bsiCore->currency_code();?>" />
	<input type="hidden" name="children" id="children" value=0 />
	
      <table  cellpadding="4" border="0">
        <tr>
          <td><strong>Destination</strong></td>
          <td><?=$destination?></td>
        </tr>
        <tr>
          <td><strong>Check In Date</strong></td>
          <td style="width:80px;"><table><tr><td><input type="text" readonly="readonly" name="check_in" id="txtFromDate" style="width:70px; margin-right:0px;" class="required"/></td><td>&nbsp;<a id="datepickerImage" href="javascript:;"><img src="../img/month.png" width="18px" height="18px"/></a></td></tr></table></td>
        </tr>
        <tr>
          <td><strong>Check Out Date</strong></td>
          <td style="width:80px;"><table><tr><td><input type="text" readonly="readonly" name="check_out" id="txtToDate" style="width:70px; margin-right:0px;" class="required"/></td><td>&nbsp;<a id="datepickerImage1" href="javascript:;"><img src="../img/month.png" width="18px" height="18px"/></a></td></tr></table></td>
        </tr>
        <tr>
          <td><strong>No Of Rooms</strong></td>
          <td><?=$rooms?></td>
        </tr>
        <tr>
          <td><strong>No Of Adults</strong></td>
          <td><?=$adults?></td>
        </tr>
        <tr>
          <td>&nbsp;</td>
          <td>&nbsp;</td>
        </tr>
        <tr>
          <td colspan="2" id="getCapacity"></td>
        </tr>
        <tr>
          <td>&nbsp;</td>
          <td>&nbsp;</td>
        </tr>
        <tr>
          <td></td>
          <input type="hidden" name="search_available" value="1">
          <td><button class="button_colour" id="submit"><img width="24" height="24" src="images/icons/small/white/bended_arrow_right.png" alt="Bended Arrow Right"/><span>SEARCH</span></button></td>
        </tr>
        <tr><td colspan="2"><font color="#FF0000">*</font> Means Required</td></tr>
      </table>
    </form>
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