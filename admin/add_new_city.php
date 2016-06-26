<?php 

	 include("access.php");
	 if(isset($_POST['sbt_addCategory'])){


		include("../includes/db.conn.php");


		include("../includes/conf.class.php");


		include("../includes/admin.class.php");


		$bsiAdminMain->addCity();


		header("location:city_list.php");


	 }

	 $pageid = 17;
	 include("header.php");
	 $image='';
	 $cid=mysql_real_escape_string(base64_decode($_GET['cid']));
	 if($cid != 0){
		 $row445=mysql_fetch_assoc(mysql_query("select * from bsi_city where cid=".$cid));
		 $drophtml=$bsiAdminMain->getCountrydropdown($row445['country_code']);
		 
		  if($row445['default_img'] != "" || $row445['default_img'] != NULL){
			$image        = '<span style="padding-left:50px;"><a rel="collection" href="../gallery/cityImage/'.$row445['default_img'].'" target="_blank">View Image</a></span>';
			}else{
			$image        = '&nbsp;&nbsp;&nbsp;&nbsp; <b>No Image</b>';
			}
		 
	 }else{
		 $row445=NULL;
		 $drophtml=$bsiAdminMain->getCountrydropdown();
	 }
	 


?>

<script type="text/javascript" src="js/jquery.validate.js"></script>


<script>


  $(document).ready(function(){


    $("#city-frm").validate();
	});


</script>


			<div class="flat_area grid_16">


             <button class="button_colour round_all" id="button" onclick="window.location.href='city_list.php'" style="float:right;"><img height="24" width="24" alt="Bended Arrow Right" src="images/icons/small/white/bended_arrow_right.png"><span>Back</span></button>


					<h2>City Add / Edit</h2>


				</div>


				<div class="box grid_16 round_all">


					<h2 class="box_head grad_colour round_top">&nbsp;</h2>	


					<a href="#" class="grabber">&nbsp;</a>


					<a href="#" class="toggle">&nbsp;</a>


					<div class="block no_padding">


                    	<form name="city-frm" id="city-frm" method="post" action="<?=$_SERVER['PHP_SELF']?>"  enctype="multipart/form-data" > 
                          <input type="hidden" name="cid" value="<?php echo $cid;?>"/>

                        	<table cellpadding="8" border="0">

                            <tr>


                            	<td style="padding:0 0 0 15px;">


                                	<label>Select Country Code : </label>


                                </td>


                                <td style="padding-left:25px;">
                                  <select name="c_cod" id="c_cod">
                                  <?php echo $drophtml;?>
                                  </select>
                                </td>


                            </tr>
                            <tr>


                            	<td style="padding:0 0 0 15px;">


                                	<label>City Name : </label>


                                </td>


                                <td style="padding-left:25px;">


                                <input class="required" type="text" id="city_name" name="city_name" value="<?php echo $row445['city_name'];?>" style="width:200px;">


                                </td>


                            </tr>
							
							
							<tr>
							<td style="padding:0 0 0 15px;">
        				   <label>City Image : </label>
		  					</td>
							<td style="padding-left:25px;">
          <input type="hidden" name="pre_img" value="<?=$row_1['default_img']?>"  />
         <input type="file" name="default_img" id="default_img" />
            <?=$image?></td>
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


        <div style="padding-right:8px;"><?php include("footer.php"); ?></div>


        </body>


	</html>