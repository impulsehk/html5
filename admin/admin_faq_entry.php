<?php 
	include("access.php");	
	if(isset($_POST['submit'])){
		include("../includes/db.conn.php");
		include("../includes/conf.class.php");
		$faq_question=$bsiCore->ClearInput($_POST['faq_question']);
		$faq_answer=$bsiCore->ClearInput($_POST['faq_answer']);
		if($_POST['fid'] == 0){
			$faq_res=mysql_query("insert into bsi_faq(question,answer)values('".$faq_question."','".$faq_answer."')");
			header("location:admin_faq.php");
		}else{
			mysql_query("update bsi_faq set question='".$faq_question."', answer='".$faq_answer."' where faq_id=".$_POST['fid']);
			header("location:admin_faq.php");
		}
	}
	$pageid = 20;
	include ("header.php");
	if(isset($_GET['fid'])){
		$fid=$bsiCore->ClearInput(base64_decode($_GET['fid']));
		$query="select * from bsi_faq where faq_id=".$fid;	
		$faq_data=mysql_fetch_assoc(mysql_query($query));
		$faq_question=$faq_data['question'];
		$faq_answer=$faq_data['answer'];
	}else{
		$faq_question="";
		$faq_answer="";
		$fid=0;
	}
?>
<script type="text/javascript" src="ckeditor/ckeditor_basic.js"></script>
<script type="text/javascript" src="js/jquery.validate.js"></script>
<script type="text/javascript">
$(document).ready(function(){
		$("#addfaq").validate();
	});
</script>

<div class="flat_area grid_16">
<button name="submit" class="button_colour round_all" style="float:right;" onclick="window.location.href='<?=$_SERVER['HTTP_REFERER']?>'"><img height="24" width="24" alt="Bended Arrow Right" src="images/icons/small/white/bended_arrow_right.png"><span>Back</span></button>
  <h2>
    <?php if($fid!=0){ echo "Edit Faq Data"; }else{ echo "Add Faq Data"; }?>
  </h2>
</div>
<div class="box grid_16 round_all">
  <h2 class="box_head grad_colour round_top">&nbsp;&nbsp;</h2>
  <div class="block no_padding">
    <form name="addfaq" id="addfaq" method="post" action="<?=$_SERVER['PHP_SELF']?>" enctype="multipart/form-data" >
      <input type="hidden"  name="fid" value="<?=$fid?>" />
      <table cellpadding="5" cellspacing="0" border="0" width="100%">
        <tr>
          <td colspan="2">&nbsp;</td>
        </tr>
        <tr>
          <td align="center" ><label>Question </label></td>
          <td align="left"><input type="text" class="required" id="faq_question" name="faq_question"   style="width:100%" value="<?=$faq_question?>"/></td>
        </tr>
        <tr>
          <td colspan="2">&nbsp;</td>
        </tr>
        <tr>
          <td valign="top"><label>Answer </label></td>
          <td align="left"><textarea title="answer"  class="ckeditor" id="faq_answer" name="faq_answer"><?=$faq_answer?>
</textarea></td>
        </tr>
        <tr>
          <td></td>
          <td><button name="submit" class="button_colour round_all" style="margin-left:370px;"><img height="24" width="24" alt="Bended Arrow Right" src="images/icons/small/white/bended_arrow_right.png"><span>Submit</span></button></td>
        </tr>
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