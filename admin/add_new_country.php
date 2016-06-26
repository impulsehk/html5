<?php 

	 include("access.php");
	 if(isset($_POST['sbt_addCategory'])){


		include("../includes/db.conn.php");


		include("../includes/conf.class.php");


		include("../includes/admin.class.php");


		$bsiAdminMain->addCountry();


		header("location:country_list.php");


	 }

	 $pageid = 17;
	 include("header.php");


?>

<script type="text/javascript" src="js/jquery.validate.js"></script>


<script>


  $(document).ready(function(){


    $("#country-frm").validate();
	});


</script>


			<div class="flat_area grid_16">


             <button class="button_colour round_all" id="button" onclick="window.location.href='country_list.php'" style="float:right;"><img height="24" width="24" alt="Bended Arrow Right" src="images/icons/small/white/bended_arrow_right.png"><span>Back</span></button>


					<h2>Country Add / Edit</h2>


				</div>


				<div class="box grid_16 round_all">


					<h2 class="box_head grad_colour round_top">&nbsp;</h2>	


					<a href="#" class="grabber">&nbsp;</a>


					<a href="#" class="toggle">&nbsp;</a>


					<div class="block no_padding">


                    <?php  
					if(isset($_GET['c_code'])){
						$code=base64_decode($_GET['c_code']);
						$ccode=mysql_real_escape_string($code);
					}
					   if($ccode == 9){

						?>


                    	<form name="country-frm" id="country-frm" method="post" action="<?=$_SERVER['PHP_SELF']?>">


                        	<table cellpadding="8" border="0">

                            <tr>


                            	<td style="padding:0 0 0 15px;">


                                	<label>Country Code : </label>


                                </td>


                                <td style="padding-left:25px;">


                                <input class="required" type="text" id="c_cod" name="c_cod" value="" style="width:35px;">


                                </td>


                            </tr>
                            <tr>


                            	<td style="padding:0 0 0 15px;">


                                	<label>Country Name : </label>


                                </td>


                                <td style="padding-left:25px;">


                                <input class="required" type="text" id="c_name" name="c_name" value="" style="width:200px;">


                                </td>


                            </tr>


                            <tr><td>&nbsp;</td><td style="padding-left:25px;">


                            <input  type="hidden" value="11" name="sbt_addCategory" />


                            <button class="button_colour round_all" id="button"><img height="24" width="24" alt="Bended Arrow Right" src="images/icons/small/white/bended_arrow_right.png"><span>Submit</span></button>


                             </td></tr>


                        </table>


                        </form>
                      <?php
					   }else{
						  $row34=mysql_fetch_assoc(mysql_query("select * from bsi_country where country_code='".$ccode."'")); 
					  ?>
                      <form name="country-frm" id="country-frm" method="post" action="<?=$_SERVER['PHP_SELF']?>">


                        	<table cellpadding="8" border="0">

                            <tr>


                            	<td style="padding:0 0 0 15px;">


                                	<label>Country Code : </label>


                                </td>


                                <td style="padding-left:25px;">


                                <input class="required" type="text" id="c_cod" name="c_cod" value="<?php echo $row34['country_code'];?>" style="width:35px;" readonly="readonly">


                                </td>


                            </tr>
                            <tr>


                            	<td style="padding:0 0 0 15px;">


                                	<label>Country Name : </label>


                                </td>


                                <td style="padding-left:25px;">


                                <input class="required" type="text" id="c_name" name="c_name" value="<?php echo $row34['cou_name'];?>" style="width:200px;">


                                </td>


                            </tr>


                            <tr><td>&nbsp;</td><td style="padding-left:25px;">


                            <input  type="hidden" value="11" name="sbt_addCategory" />


                            <button class="button_colour round_all" id="button"><img height="24" width="24" alt="Bended Arrow Right" src="images/icons/small/white/bended_arrow_right.png"><span>Submit</span></button>


                             </td></tr>


                        </table>
                        </form>
                      <?php
					   }
					  ?>

					</div>


			</div>





			


		</div>


		<div id="loading_overlay">


			<div class="loading_message round_bottom">Loading...</div>


		</div>


        <div style="padding-right:8px;"><?php include("footer.php"); ?></div>


        </body>


	</html>