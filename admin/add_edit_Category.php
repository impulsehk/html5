<?php 
	 include("access.php");
	 if(!isset($_GET['addedit']) || $_GET['addedit'] != 1){ 
	 	header("location:hotelCategoryList.php");	
	 }
	 if(!isset($_GET['category_id']) || $_GET['category_id'] == ""){
	 	header("location:hotelCategoryList.php");	
	 }
	 if(isset($_POST['sbt_addCategory'])){
		include("../includes/db.conn.php");
		include("../includes/conf.class.php");
		include("../includes/admin.class.php");
		$bsiAdminMain->hotel_category_entry();
		header("location:hotelCategoryList.php");
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


			<div class="flat_area grid_16">
             <button class="button_colour round_all" id="button" onclick="window.location.href='<?=$_SERVER['HTTP_REFERER']?>'" style="float:right;"><img height="24" width="24" alt="Bended Arrow Right" src="images/icons/small/white/bended_arrow_right.png"><span>Back</span></button>
					<h2>Category Add / Edit</h2>
				</div>
				<div class="box grid_16 round_all">
					<h2 class="box_head grad_colour round_top">&nbsp;</h2>	
					<a href="#" class="grabber">&nbsp;</a>
					<a href="#" class="toggle">&nbsp;</a>
					<div class="block no_padding">
                    <?php if((isset($_GET['addedit'])) && ($_GET['addedit'] == 1)){
							   $category_id = $bsiCore->ClearInput(base64_decode($_GET['category_id']));
							   if($category_id){
								   $row = $bsiAdminMain->getCategory($category_id);
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
                                <td style="padding-left:25px;">
                                <input type="hidden"  name="category_id" value="<?=$category_id?>" />  
                                	<select name="hotel_id" id="hotel_id" data-placeholder="Choose a hotel." class="chosen-select" style="width:250px;">
                                    	<?=$hotel_list?>
                                    </select>
                                </td>
                            </tr>
                            <tr>
                            	<td style="padding:0 0 0 15px;">
                                	<label>Category Title : </label>
                                </td>
                                <td style="padding-left:25px;">
                                <input class="required" type="text" id="category_title" name="category_title" value="<?=$row['category_title']?>" style="width:250px;">
                                </td>
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