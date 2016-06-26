<?php
include ("access.php");
if(isset($_POST['sbt_lang'])){
	include("../includes/db.conn.php");
	include("../includes/admin.class.php");
	$bsiAdminMain->langauge_setting();
	header('location:admin_language.php');
}
$pageid = 46;
include ("header.php");
$lang_sql = mysql_query("select * from bsi_language order by lang_order");
?>
<script type="text/javascript" src="js/jquery.validate.js"></script>
<script type="text/javascript"> 
$(document).ready(function(){
   $("#lang").validate();
   $('input[type="radio"]').change(function(){   
	    var the_value;
  		the_value = jQuery('#lang input:radio:checked').val();
   }); 
});
</script>

<div class="flat_area grid_16">
  <h2>Language Setting&nbsp;</h2>
</div>
<div class="box grid_16 round_all">
  <h2 class="box_head grad_colour round_top">&nbsp;&nbsp;</h2>
  <a href="#" class="grabber">&nbsp;</a> <a href="#" class="toggle">&nbsp;</a>
  <div class="block no_padding">
    <form action="<?=$_SERVER['PHP_SELF']?>" method="post" id="lang" name="lang">
      <table cellpadding="3" class="static">
        <thead>
          <tr>
            <th>Language</th>
            <th>Default</th>
            <th>Enabled</th>
            <th>Order</th>
          </tr>
        </thead>
  <?php
	while($lang_row = mysql_fetch_assoc($lang_sql)){
	if($lang_row['default']==true){
  ?>
        <tr>
          <td><?=$lang_row['language']?></td>
          <td><input type="radio" value="<?=$lang_row['lang_code']?>" name="lang_default" id="lang_default" checked="checked" /></td>
          <td>Yes</td>
          <td><input type="text" name="order_<?=$lang_row['lang_code']?>" value="<?=$lang_row['lang_order']?>" size="5" class="required number" /></td>
        </tr>
        <?php 
	}else{ 
	$lang_enabled=(($lang_row['status']==false) ? '' : 'checked="checked"')
	?>
        <tr>
          <td><?=$lang_row['language']?></td>
          <td><input type="radio" value="<?=$lang_row['lang_code']?>" name="lang_default"/></td>
          <td><input type="checkbox" value="<?=$lang_row['lang_code']?>" name="lang_<?=$lang_row['lang_code']?>" <?=$lang_enabled?> /></td>
          <td><input type="text" name="order_<?=$lang_row['lang_code']?>" value="<?=$lang_row['lang_order']?>" size="5" class="required number"/></td>
        </tr>
        <?php } } ?> 
      </table>
      <br/>
      <input  type="hidden" value="11" name="sbt_lang" />
      <button class="button_colour round_all" name="SBMT_REG" id="lang_submit"><img height="24" width="24" alt="Bended Arrow Right" src="images/icons/small/white/bended_arrow_right.png"><span>Update</span></button>
    </form>
  </div>
</div>
</body></html>