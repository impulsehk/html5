<?php
session_start();
include("../includes/db.conn.php");
if(empty($_SESSION['6_letters_code'] ) || strcasecmp($_SESSION['6_letters_code'], $_POST['6_letters_code']) != 0){
	$_SESSION['msglog']="capcha code is incorrect!"; 
	header("location:login.php");
	exit;
}else{
if(isset($_POST['password']) && isset($_POST['username'])){
	$password=mysql_real_escape_string($_POST['password']);
	$username=mysql_real_escape_string($_POST['username']);
	$res=mysql_query("select * from bsi_admin where pass='".md5($password)."' and  username='".$username."'") or die(mysql_error());
	if(mysql_num_rows($res)){
		$row=mysql_fetch_assoc($res);
		$_SESSION['cppass']=$row['pass'];
		$_SESSION['cpuser']=$row['username'];
		$_SESSION['cpid']=$row['id'];
		$_SESSION['cpaccessid']=$row['access_id'];
		header("location:admin-home.php");
		exit;
  	}else{
		$_SESSION['msg']="username or password is incorrect";
		header("location:login.php");
		exit;
  	}
}
}
?>