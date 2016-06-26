<?php 
	include("access.php");
	/*if(!isset($_GET['id']) || $_GET['id'] == ""){
	  	header("location:content.list.php");	
	}*/
	$pageid = 26;
	include("header.php");
?>

<script src="//cdn.ckeditor.com/4.5.1/standard/ckeditor.js"></script>
<script type="text/javascript" src="js/jquery.validate.js"></script>
<script type="text/javascript">
$(document).ready(function(){
	$("#bsi_contents").validate();
	
	});
</script>

			<div class="flat_area grid_16">
            <button class="button_colour round_all" style="float:right;" onclick="window.location.href='<?=$_SERVER['HTTP_REFERER']?>'"><img height="24" width="24" alt="Bended Arrow Right" src="images/icons/small/white/bended_arrow_right.png"><span>Back</span></button>
					<h2>CONTENT MANAGEMENT</h2>
				</div>
				<div class="box grid_16 round_all">
					<h2 class="box_head grad_colour round_top">&nbsp;&nbsp;</h2>	
					<a href="#" class="grabber">&nbsp;</a>
					<a href="#" class="toggle">&nbsp;</a>
					<div class="block no_padding">
                   <?php

if(isset($_POST['cnt_sbmt'])):

    // contents..........
   	if(isset($_POST['contents']))
	$contents = $_POST['contents'];
	else
	$contents = "";
	// contents..........
	
	// contents title..........
	if(isset($_POST['cont_title']))
	$cont_title = $_POST['cont_title'];
	else
	$cont_title = "";
	// contents title..........
	
	// header ..........
	if(isset($_POST['header_type']))
	$header_type = $_POST['header_type'];
	else
	$header_type = 0;
	// header..........
	
	// footer ..........
	if(isset($_POST['footer_type']))
	$footer_type = $_POST['footer_type'];
	else
	$footer_type = 0;
	//  footer..........
	
	
	
   	 if($_REQUEST['id']):
	 
	 //echo "update bsi_site_contents set cont_title='".mysql_real_escape_string($cont_title)."', ord=".$bsiCore->ClearInput($_POST['ord']).", parent_id=".$bsiCore->ClearInput($_POST['parent_id']).", status='".$bsiCore->ClearInput($_POST['status'])."', url='".$bsiCore->ClearInput($_POST['url'])."', contents='".$contents."'  , header_type='".$bsiCore->ClearInput($_POST['header_type'])."' where id=" . $bsiCore->ClearInput($_REQUEST['id']);die;
	 
	     $r=mysql_query("update bsi_site_contents set cont_title='".mysql_real_escape_string($cont_title)."', ord=".$bsiCore->ClearInput($_POST['ord']).", parent_id=".$bsiCore->ClearInput($_POST['parent_id']).", status='".$bsiCore->ClearInput($_POST['status'])."', url='".$bsiCore->ClearInput($_POST['url'])."', contents='".$contents."'  , header_type='".mysql_real_escape_string($header_type)."'  , footer_type='".mysql_real_escape_string($footer_type)."' where id=" . $bsiCore->ClearInput($_REQUEST['id']));		
   	    
	 else:
	
	     $n1234=mysql_num_rows(mysql_query("select * from bsi_site_contents where parent_id=0"));
		 if($_POST['parent_id'] != 0){
	      $r=mysql_query("insert into bsi_site_contents(cont_title, ord, parent_id, status, url, contents, header_type , footer_type) values('".mysql_real_escape_string($cont_title)."', ".$bsiCore->ClearInput($_POST['ord']).",".$bsiCore->ClearInput($_POST['parent_id']).", '".$bsiCore->ClearInput($_POST['status'])."', '".$bsiCore->ClearInput($_POST['url'])."', '".$contents."' , '".mysql_real_escape_string($header_type)."' , '".mysql_real_escape_string($footer_type)."')"); 
		 }else{
		  if($n1234 < 7 ){
		    $r=mysql_query("insert into bsi_site_contents(cont_title, ord, parent_id, status, url, contents ,header_type ,footer_type) values('".mysql_real_escape_string($cont_title)."', ".$bsiCore->ClearInput($_POST['ord']).",".$bsiCore->ClearInput($_POST['parent_id']).", '".$bsiCore->ClearInput($_POST['status'])."', '".$bsiCore->ClearInput($_POST['url'])."', '".$contents."' , '".mysql_real_escape_string($header_type)."' ,'".mysql_real_escape_string($footer_type)."')");
		  }else{
		 	$msg="<font face='verdana' size='2' color='#FF3300'><b>Error: You can't add more than 7 root level menu.</b></font>";
			$_SESSION['msg_'] = $msg;	
		 } 
		 }
	     
		 $_REQUEST['id']=mysql_insert_id();
	 endif;
	 if(isset($r)):	 
		 $msg="<font face='verdana' size='2' color='#111111'><b>Update successful.</b></font>";	  
	 endif;	

endif;
if(!isset($d['status'])){$d['status']="Y";}

if(isset($_REQUEST['id'])):
	$id=$_REQUEST['id'];
	$r=mysql_query("select * from bsi_site_contents where id=" .$bsiCore->ClearInput($_REQUEST['id']));
	$d=@mysql_fetch_assoc($r);  
endif;	
if(isset($msg)){echo"<div align=center>" . $msg ."</div>";}
?>
                    	<form name="bsi_contents" id="bsi_contents" method="post" action="<?=$_SERVER['PHP_SELF']?>?id=" enctype="multipart/form-data">
                        	<table class="static">  
                            	<input type="hidden" name="id" value="<?=$_REQUEST['id']?>">                           
                             <tr><td width="200px"><label>Menu Title *</label></td>
                             	 <td><input type="text" class="required" name="cont_title" id="cont_title" value="<?=$d['cont_title']?>"/></td>
                             </tr>
                             <tr><td><label>Menu Order *</label></td>
                             	 <td><input type="text" class="required" name="ord" id="ord" value="<?=$d['ord']?>"/></td>
                             </tr>
                             <tr><td colspan="2">(<font color="#CE8EA2">&nbsp;If above menu is submenu then you have to choose a parent header&nbsp;</font>)</td></tr>
                             <tr><td><label>Parent header (Optional)</label></td>
                             	 <td>
                                 	<select name="parent_id" id="parent_id">
                                    	<option value="0">---Select Header---</option>
                                       <?php
										$rr=mysql_query("select * from bsi_site_contents where parent_id=0 order by ord");
										//echo"select * from h_contents where parent_id=0 and menu=1 order by ord";
										while($dd=@mysql_fetch_array($rr)):
											if($dd[id]==$d[parent_id]):
												echo"<option value='" . $dd[id] . "' selected>" . $dd[cont_title] . "</option>\n";
											elseif($dd[id]==$_REQUEST[parent_id]):
											   echo"<option value='" . $dd[id] . "' selected>" . $dd[cont_title] . "</option>\n";
											else:
												echo"<option value='" . $dd[id] . "'>" . $dd[cont_title] . "</option>\n";
											endif;	
										$vv=mysql_query("select * from bsi_site_contents where parent_id='" . $dd[id] . "' order by ord");
										//echo"select * from h_contents where parent_id='" . $dd[id] . "' and menu='1' order by ord";
										while($c=mysql_fetch_array($vv)):
											if($c[id]==$d[parent_id]):
												echo"<option value='" . $c[id] . "' selected>|__" . $c[cont_title] . "</option>\n";
											elseif($c[id]==$_REQUEST[parent_id]):
												echo"<option value='" . $c[id] . "' selected>|__" . $c[cont_title] . "</option>\n";
											else:
												echo"<option value='" . $c[id] . "'>|__" . $c[cont_title] . "</option>\n";
											endif;	
										endwhile;
										endwhile;   
											?>
                                    </select>
                                 </td>
                             </tr>
                             <tr><td><label>Status *</label></td>
                             	 <td><input type="radio" name="status" value="Y" <?php if($d['status']=="Y"){echo"checked";}?>>
                                 Active&nbsp; &nbsp; 
                                     <input type="radio" name="status" value='N' <?php if($d['status']=="N"){echo"checked";}?>>
                                 Hidden</td>
                             </tr>
							 
							 </tr>
                             <tr><td><label>Menu Type</label></td>
                             	 <td><input type="checkbox" name="header_type" value='1' <?php if($d['header_type']=="1"){echo"checked";}?>>
                                Header&nbsp; 
                                     <input type="checkbox" name="footer_type" value='1' <?php if($d['footer_type']=="1"){echo"checked";}?>>
                                Footer&nbsp; 
								
								
								</td>
                             </tr>
							 
							 
                             <tr><td><label>Url</label></td>
                             	 <td><input type="text" class="large" name="url" value="<?=$d['url']?>"/></td>
                             </tr>
                             <tr><td colspan="2"><label>Page Contents &nbsp;(<font color="#CE8EA2">&nbsp;If url field is entered then no content below is required&nbsp;</font>)</label></td></tr>
                             <input type="hidden"  name="cnt_sbmt" value="1" /><input type="hidden"  name="SBMT_REG" value="1" />
                             <tr><td colspan="2"><textarea class="ckeditor"  name="contents"><?=$d['contents']?></textarea></td></tr>
                             <tr><td colspan="2"><button class="button_colour round_all" style="margin-left:370px;"><img height="24" width="24" alt="Bended Arrow Right" src="images/icons/small/white/bended_arrow_right.png"><span>Update</span></button></td></tr>
                        </table>
                        </form>
					</div>
			</div>

			
		</div>
		<div style="padding-right:8px;"><?php include("footer.php"); ?></div>
		</body>
	</html>