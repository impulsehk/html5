<?php 
include("access.php");

if(isset($_POST['submitCapacity'])){
	
	include("../includes/db.conn.php"); 
	include("../includes/conf.class.php");
	include("../includes/admin.class.php");
	$bsiAdminMain->add_edit_currency();
	
	header("location:currency_list.php");	
	exit;
}



	$pageid = 55;



	include ("header.php");



	if(isset($_GET['id']) && $_GET['id'] != ""){

	$id = $bsiCore->ClearInput($_GET['id']);
	if($id){
		$result = mysql_query("select * from bsi_currency where id=".$id);
		$row    = mysql_fetch_assoc($result);
		$dflt=($row['default_c'])? 'checked="checked"':'';
	}else{
		$row    = NULL;
		$readonly = '';
		$dflt='';

	}

}else{

	header("location:currency_list.php");

	exit;

}




?>



<script type="text/javascript" src="js/jquery.validate.js"></script>


<script type="text/javascript">

	$().ready(function() {

		$("#form1").validate();
     });

         

</script> 


<div class="flat_area grid_16">



<button name="submit" id="button" class="button_colour round_all" onclick="window.location.href='<?=$_SERVER['HTTP_REFERER']?>'" style="float:right;"><img height="24" width="24" alt="Bended Arrow Right" src="images/icons/small/white/bended_arrow_right.png"><span>Back</span></button>



  <h2>Currency Add/Edit</h2>



</div>



<div class="box grid_16 round_all">



  <h2 class="box_head grad_colour round_top">&nbsp;</h2>



  <a href="#" class="grabber">&nbsp;</a> <a href="#" class="toggle">&nbsp;</a>



  <div class="block no_padding">






    <form action="<?=$_SERVER['PHP_SELF']?>" method="post" id="form1">  



    <input type="hidden" name="addedit" value="<?=$id?>">



      <table cellpadding="8" cellspacing="0" border="0">



        <tr>



          <td align="left"><label>Currency Code : </label></td>



          <td align="left"><input type="text" name="currency_code" id="currency_code" class="required" value="<?=$row['currency_code']?>" style="width:150px;" /></td>



        </tr>



        



        <tr>



          <td align="left"><label>Currency Symbol : </label></td>



          <td align="left"><input type="text" name="currency_symbol" id="currency_symbol" value="<?=$row['currency_symbl']?>" class="required " style="width:70px;"  /></td>



        </tr>



        



        <tr>



          <td align="left"><label>Default Currency? : </label></td>



          <td align="left"><input type="checkbox" name="default_c" value="1"  <?=$dflt?>/></td>



        </tr>



        



     



        <tr>



          <td></td><td><input type="submit" value="Submit" name="submitCapacity" style="background:#e5f9bb; cursor:pointer; cursor:hand;"/><!--<button name="submit" name="submitCapacity" id="button" class="button_colour round_all"><img height="24" width="24" alt="Bended Arrow Right" src="images/icons/small/white/bended_arrow_right.png"><span>Submit</span></button>--></td>



        </tr>  



      </table>



    </form>



  


  </div>



</div>



</div>



<div id="loading_overlay">



  <div class="loading_message round_bottom">Loading...</div>



</div>



<div style="padding-right:8px;"><?php include("footer.php"); ?></div> 



</body></html>