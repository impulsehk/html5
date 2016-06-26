<?php 
session_start();
if(isset($_POST['act_sbmt'])){
	include("../includes/db.conn.php");
	include("../includes/conf.class.php");
	include("../includes/admin.class.php");
	$_SESSION['msg']=$bsiAdminMain->change_password();
	header("location:change_password.php");
	exit;
}
    $pageid = 22;
	include("header.php");
?>

<script type="text/javascript" src="js/jquery.validate.js"></script>

<script type="text/javascript">

$(document).ready(function(){

	 //$("#chng_password").validate();

   $("#chng_password").validate({

	  

	    rules: {

  			myPass: {

				required: true,

				minlength: 5

			},

			myPass2: {

				required: true,

				minlength: 5,

				equalTo: "#myPass"

			}

		},

		messages: {

			myPass: {

				required: " Please provide a password",

				minlength: " Your password must be at least 5 characters long"

			},

			myPass2: {

				required: " Please provide a password",

				minlength: " Your password must be at least 5 characters long",

				equalTo: " Please enter the same password as above"

			}

		}

  });

  });

</script>

			<div class="flat_area grid_16">

					<h2>Change Password</h2>  

			</div>



                <div class="box grid_16 round_all">

                <h2 class="box_head grad_colour round_top"><?php if(isset($_SESSION['msg'])){

						echo "<span style=\"padding-left:10px;\">".$_SESSION['msg']."</span>";

						unset($_SESSION['msg']);

					}

					?>&nbsp;</h2>

                <a href="#" class="grabber">&nbsp;</a> <a href="#" class="toggle">&nbsp;</a>

                <div class="block no_padding">

<form name="chng_password" id="chng_password" action="<?=$_SERVER['PHP_SELF']?>" method="post">

    <table cellpadding="8" >

            

            <tr><td><strong>Old Password :</strong></td><td><input class="required" type="password" value="" size="25" name="old_pass" id="old_pass"/></td></tr>

            <tr><td><strong>New Password :</strong></td><td><input type="password"  size="25" name="myPass" id="myPass"/></td></tr>

            <tr><td><strong>ReType New Password :</strong></td><td><input type="password"  size="25" name="myPass2" id="myPass2"/></td></tr>

           <tr><td></td><td><button name="act_sbmt" class="button_colour round_all"><img height="24" width="24" alt="Bended Arrow Right" src="images/icons/small/white/bended_arrow_right.png"><span>Update</span>

</button></td></tr>

   </table>

 </form>

 </div>

 </div>

  </div>

 <div style="padding-right:8px;"><?php include("footer.php"); ?></div> 

</body>

</html>