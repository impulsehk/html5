<?php

include ("access.php");

if(isset($_REQUEST['pid'])){

	include("../includes/db.conn.php");

	include("../includes/conf.class.php");

	include("../includes/admin.class.php");

	$is_delete=$bsiAdminMain->gallery_photo_delete();

	//if($is_delete)

	header("location:admin_home_slider_gallery.php"); 

	exit;

}

if(isset($_POST['sbt_lang'])){

    include("../includes/db.conn.php");

	include("../includes/conf.class.php");

	include("../includes/admin.class.php");

	$bsiAdminMain->slider_gallery_img_upload();

	header("location:admin_home_slider_gallery.php");

	exit;

}

$pageid = 38;

include ("header.php");

?>



<div class="flat_area grid_16">

  <?php if(!isset($_REQUEST['upload_photo_form'])){?>

  <a href="<?=$_SERVER['PHP_SELF']?>?upload_photo_form=1">

  <button class="button_colour round_all" style="float:right;"><img height="24" width="24" alt="Bended Arrow Right" src="images/icons/small/white/bended_arrow_right.png"><span>Upload Photo</span></button>

  </a>

  <?php } ?>

  <h2>&nbsp;</h2>

</div>

<div class="box grid_16 round_all">

  <h2 class="box_head grad_colour round_top">&nbsp;&nbsp;</h2>

  <a href="#" class="grabber">&nbsp;</a> <a href="#" class="toggle">&nbsp;</a>

  <div class="block no_padding">

    <?php

	if(isset($_REQUEST['upload_photo_form']))

	{

		if(isset($_REQUEST['eid'])){

			$eid = mysql_real_escape_string($_REQUEST['eid']);

			$row = mysql_fetch_assoc(mysql_query("select * from bsi_gallery where id='".base64_decode($eid)."'")); 

			$editHTML = '
			
			
			<br />
			<tr><td><strong>Image</strong></td><td><input type="file" name="uplimg1">

				      &nbsp;(For better image quality upload image size: 1500px X 500px )</td></tr>

    			  

    			  <tr><td colspan="2">&nbsp;</td></tr>

				  <input  type="hidden" value="'.$row['img_path'].'" name="preImg" />

				  <input  type="hidden" value="11" name="sbt_lang" /><input  type="hidden" value="'.$row['id'].'" name="eid" />';

		}else{

			$editHTML = '';	

		}

?>

    <form method="post" enctype="multipart/form-data">

      <table cellpadding="6">

        <?php

	$upload_image_limit = 2;

	$i=0;

	$form_img="";

	$htmo="";

		if($editHTML == ""){

	############################### HTML FORM

	while($i++ < $upload_image_limit){

?>



		<br />

        <tr>

          <td><strong>Image

            <?=$i?>

            </strong></td>

          <td><input type="file" name="uplimg<?=$i?>">

            &nbsp;(For better image quality upload image size: 1500px X 500px)</td>

        </tr>

        <!--<tr>

          <td><strong>Description : </strong></td>

          <td><input type="text" name="desc[]" size="100"></td>

        </tr>

        <tr>-->

          <td colspan="2">&nbsp;</td>

        </tr>

        <input  type="hidden" value="11" name="sbt_lang" />

        <?php

		}

	}else{

		echo $editHTML;

	}

?>

        <tr>

          <td align="center" colspan="2"><button class="button_colour round_all" type="submit"><img height="24" width="24" alt="Bended Arrow Right" src="images/icons/small/white/bended_arrow_right.png"><span>Upload Image</span></button></td>

        </tr>

      </table>

    </form>

    <?php

}else{

?>

    <table cellpadding="3" cellspacing="0">

      <tr>

        <td>&nbsp;</td>

      </tr>

      <?php

		$td = 0;

		$result = mysql_query("select * from bsi_gallery where gallery_type='2'");

		

		while($row = mysql_fetch_assoc($result)){
		
		echo "<tr>";

	?>

      

        <td  align="center"><img src="../gallery/<?=$row['img_path']?>" height="300px" width="900px"><br/>

          

          <!--Button Field--> 

     <a href="<?=$_SERVER['PHP_SELF']?>?pid=<?=base64_encode($row['id'])?>" >

          <button class='button_colour round_all'><img height='24' width='24' alt='Bended Arrow Right' src='images/icons/small/white/bended_arrow_right.png'><span>Delete</span></button>

          </a><a href="<?=$_SERVER['PHP_SELF']?>?upload_photo_form=1&eid=<?=base64_encode($row['id'])?>">

          <button class='button_colour round_all'><img height='24' width='24' alt='Bended Arrow Right' src='images/icons/small/white/bended_arrow_right.png'><span>Edit&nbsp;&nbsp;&nbsp;&nbsp;</span></button>

          </a>

          <!--Button Field End Here-->
		  </td>

        <?php

				/*$td++;

		if($td == 2){*/

				echo "</tr>";
/*
				$td = 0;

			}*/

		}

	?>

    </table>

    <?php

}

?>

  </div>

</div>

</div>

<div style="padding-right:8px;">

  <?php include("footer.php"); ?>

</div>

</body></html>