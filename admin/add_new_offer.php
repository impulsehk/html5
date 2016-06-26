<?php  
	 include("access.php");
	 /*if(!isset($_GET['addedit']) || $_GET['addedit'] != 1){ 
	 	header("location:hotelCategoryList.php");	
	 }
	 if(!isset($_GET['category_id']) || $_GET['category_id'] == ""){
	 	header("location:hotelCategoryList.php");	
	 }*/
	 if(isset($_POST['sbt_addCategory'])){
		include("../includes/db.conn.php");
		include("../includes/conf.class.php");
		include("../includes/admin.class.php");
		$bsiAdminMain->hotel_offer();
		header("location:hotel_offer.php");
	 }

	 if((isset($_GET['delete'])) && ($_GET['delete'] == 555)){ 
		include("../includes/db.conn.php");
		include("../includes/conf.class.php");
		include("../includes/admin.class.php");
		$delete_id=$bsiCore->ClearInput($_GET['category_id']);
		$row=$bsiAdminMain->getCategory($delete_id);
		$_SESSION['hotel_id']=$row['hotel_id'];
		mysql_query("delete from bsi_around_hotel_category where category_id=".$delete_id);
		mysql_query("delete from `bsi_around_hotel` where category_id=".$delete_id);
		header("location:hotelCategoryList.php");
	 }
	 $pageid = 17;
	 include("header.php");
	 $hotel_list=$bsiAdminMain->hotelname();
?>
<link rel="stylesheet" href="css/chosen.css">
<script type="text/javascript" src="js/jquery.validate.js"></script>
 <script>
  $(document).ready(function(){
    $("#category-frm").validate();
	
	$('#hotel_id').change(function() { 
		activateBtn()
    });
	
	if($('#hotel_id').val() > 0){
		 activateBtn();			
	}
	function activateBtn(){
		if($('#hotel_id').val() == 0){
			jQuery("#button:button").attr("disabled", "disabled"); 			
		}else{
			jQuery("#button:button").removeAttr("disabled");		
		}
	}
	//17/3/2012
  });
  </script>
  
  <script>
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

 

 $("#txtFromDate").datepicker();

 $("#datepickerImage").click(function() { 

  $("#txtFromDate").datepicker("show");

 });

 

 $("#txtToDate").datepicker();

 $("#datepickerImage1").click(function() { 

  $("#txtToDate").datepicker("show");

 });    

});
</script> 


			<div class="flat_area grid_16">
             <button class="button_colour round_all" id="button" onclick="window.location.href='<?=$_SERVER['HTTP_REFERER']?>'" style="float:right;"><img height="24" width="24" alt="Bended Arrow Right" src="images/icons/small/white/bended_arrow_right.png"><span>Back</span></button>
					<h2>Hotel Offer Add /Edit </h2>
				</div>
				<div class="box grid_16 round_all">
					<h2 class="box_head grad_colour round_top">&nbsp;</h2>	
					<a href="#" class="grabber">&nbsp;</a>
					<a href="#" class="toggle">&nbsp;</a>
					<div class="block no_padding">
                    <?php if((isset($_GET['addedit'])) && ($_GET['addedit'] == 1)){
					$eid = $bsiCore->ClearInput(base64_decode($_GET['eid']));
					if($eid!=0){
								    
$row=mysql_fetch_assoc(mysql_query("SELECT * , date_format(start_dt,'".$bsiCore->userDateFormat."') as 	start_dt , date_format(end_dt,'".$bsiCore->userDateFormat."') as end_dt FROM bsi_hotel_offer WHERE id='".$eid."'"));								
								  $hotel_list=$bsiAdminMain->hotelname($row['hotel_id']);
							   }else{
								   $row=NULL;
								   $hotel_list=$bsiAdminMain->hotelname();
							   }
						  }
						?>
                    	<form name="category-frm" id="category-frm" method="post" action="<?=$_SERVER['PHP_SELF']?>" enctype="multipart/form-data">
                        	<table cellpadding="8" border="0">
                        	<tr>
                            	<td style="padding:0 0 0 15px;">
                                	<label>Hotel Name : </label>
                                </td>
                                <td style="padding-left:25px;">&nbsp;&nbsp;
                               <input type="hidden"  name="eid" value="<?=$eid?>" />  
                                	<select name="hotel_id" id="hotel_id" data-placeholder="Choose a hotel." class="chosen-select" style="width:250px;">
                                    	<?=$hotel_list?>
                                    </select>
                                </td>
                            </tr>
                            
                             <tr>
                            	<td style="padding:0 0 0 15px;">
                                	<label>Offer Name : </label>
                                </td>
                                <td style="padding-left:25px;">
                                &nbsp;&nbsp;<input class="required" type="text" id="offer_name" name="offer_name" value="<?=$row['offer_name']?>" style="width:250px;">
                                </td>
                            </tr>
                            

                             <tr>

          <td style="padding:0 0 0 15px;"><strong>Start Date:</strong></td>   

          <td><table><tr><td style="padding-left:25px;"><input type="text"  name="start_dt" id="txtFromDate" style="width:70px; margin-right:0px;" class="required"  value="<?=$row['start_dt']?>"/></td><td>&nbsp;<a id="datepickerImage" href="javascript:;"><img src="../img/month.png" width="18px" height="18px"/></a></td></tr></table></td> 

        </tr>

        <tr>

          <td style="padding:0 0 0 15px;"><strong>End Date:</strong></td>

          <td><table><tr><td style="padding-left:25px;"><input type="text"  name="end_dt" id="txtToDate" style="width:70px; margin-right:0px;" class="required" value="<?=$row['end_dt']?>"/></td><td>&nbsp;<a id="datepickerImage1" href="javascript:;"><img src="../img/month.png" width="18px" height="18px"/></a></td></tr></table></td>

        </tr>
                            
                            
                           <tr>
                            	<td style="padding:0 0 0 15px;">
                                	<label>Minimum Nights : </label>
                                </td>
                                <td style="padding-left:25px;">&nbsp;&nbsp;
                                <input  type="text" id="minimum_nights" name="minimum_nights" style="width:50px;" value="<?=$row['minimum_nights']?>" style="width:250px;">
                                (Optional)</td>
                            </tr>
                            
                            <tr>
                            	<td style="padding:0 0 0 15px;">
                                	<label>Discount Percent : </label>
                                </td>
                                <td style="padding-left:25px;">&nbsp;&nbsp;
                                <input class="required" type="text" id="discount_percent" name="discount_percent" style="width:50px;" value="<?=$row['discount_percent']?>" style="width:250px;">
                                %</td>
                            </tr>
                            
                            <tr><td>&nbsp;</td><td style="padding-left:25px;">
                            <input  type="hidden" value="11" name="sbt_addCategory" />
                            <button class="button_colour round_all" id="button"><img height="24" width="24" alt="Bended Arrow Right" src="images/icons/small/white/bended_arrow_right.png"><span>Submit</span></button>
                             </td></tr>
                        </table>
                        </form>
					</div>
			</div>

			
		</div>
		<div id="loading_overlay">
			<div class="loading_message round_bottom">Loading...</div>
		</div>
        <div style="padding-right:8px;"><?php include("footer.php"); ?>
        
<script src="js/chosen.jquery.min.js" type="text/javascript"></script>
  <script type="text/javascript">
    var config = {
      '.chosen-select'           : {}
    }
    for (var selector in config) {
      $(selector).chosen(config[selector]);
    }
  </script>
        </div>
        </body>
	</html>