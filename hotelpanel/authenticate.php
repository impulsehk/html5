<?php


session_start();


include("../includes/db.conn.php");

if(isset($_POST['password']) && isset($_POST['email_id'])){


$password=$_POST['password'];


$email=$_POST['email_id'];


//$res=mysql_query("select * from bsi_hotels where password='".md5($password)."' and  email_addr='".$email."'") or die(mysql_error());

$res=mysql_query("select * from bsi_hotels where email_addr='".$email."' ") or die(mysql_error());




						if(mysql_num_rows($res)){


									$row = mysql_fetch_assoc($res);


									$_SESSION['hpass']=$row['password'];


									$_SESSION['hhid']=$row['hotel_id'];


									header("location:hotel-home.php");


							}else{


								$_SESSION['msg']="Email or Password is incorrect";


								header("location:index.php");


							}


							


}


?>