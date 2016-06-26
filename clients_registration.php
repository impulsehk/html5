<?php
session_start();
include("includes/db.conn.php");
include("includes/conf.class.php");
include("includes/mail.class.php");

global $bsiCore;
$account_selection=$_POST['account_selection'];

//echo $account_selection;die;
switch ($account_selection) {
	
	case 'account':
		
		
		$customer_name = $bsiCore->ClearInput($_POST['customer_name']);
		$customer_email     = $bsiCore->ClearInput($_POST['customer_email']);
		$customer_phone     = $bsiCore->ClearInput($_POST['customer_phone']);
		
		//$status = username_available($email);				
		
		//echo "INSERT INTO bsi_clients(first_name,phone, email,ip) VALUES ('".$customer_name."', '".$customer_phone."', '".$customer_email."', '".$_SERVER['REMOTE_ADDR']."')";die;
			mysql_query("INSERT INTO bsi_clients(first_name,phone, email,ip) VALUES ('".$customer_name."', '".$customer_phone."', '".$customer_email."', '".$_SERVER['REMOTE_ADDR']."')");
			
			$_SESSION['Myname2012']    = $customer_name;
			$_SESSION['myemail2012']   = $customer_email;
			$_SESSION['client_id2012'] = mysql_insert_id();
			/*$_SESSION['Myname2012']    = $title." ".$firstname." ".$lastname;
			$_SESSION['log_msg']       = "Welcome";
			$_SESSION['myemail2012']   = $email;
			$_SESSION['password_2012'] = $pass;
			$_SESSION['client_id2012'] = mysql_insert_id();
			$_SESSION['agent']         = 0;
			$_SESSION['client']         = 1;*/
//************************************mail function
			/*$bsiMail    = new bsiMail(); 
			$emailBody  = "Dear ".$_SESSION['Myname2012']." ,<br><br>";
			$emailBody .= "Your Registration with us is successful.<br>";
			$emailBody .= "Your Email Id : ".$email." and Password : ".$bsiCore->ClearInput($_POST['pass']);;
			$emailBody .= '<br><br>Regards,<br>';
			$emailBody .= '<font style=\"color:#F00; font-size:10px;\">'.$bsiCore->config['conf_portal_name'].'</font>';
			$emailSubject = "New Account Creation";				
	 		$returnMsg = $bsiMail->sendEMail($email, $emailSubject, $emailBody);*/
			header("location: checkout_step2.php"); 
			exit;
		
		
        break;
	
    case 'signup':
		
		$pass      = md5($_POST['pass']);
		$state     = $bsiCore->ClearInput($_POST['state']);
		$title     = $bsiCore->ClearInput($_POST['title']);
		$firstname = $bsiCore->ClearInput($_POST['firstname']);
		$lastname  = $bsiCore->ClearInput($_POST['lastname']);
		$email     = $bsiCore->ClearInput($_POST['email']);
		$address1  = $bsiCore->ClearInput($_POST['address1']);
		$address2  = $bsiCore->ClearInput($_POST['address2']);
		$city      = $bsiCore->ClearInput($_POST['city']);
		$zip       = $bsiCore->ClearInput($_POST['zip']);
		$country   = $bsiCore->ClearInput($_POST['country']);
		$phone     = $bsiCore->ClearInput($_POST['phone']);
		
		$status = username_available($email);				
		if($status == false){
		
		//echo "INSERT INTO bsi_clients(first_name, surname, title, street_addr, street_addr2, city, province, zip, country, phone, email, password, ip) VALUES ('".$firstname."','".$lastname."', '".$title."', '".$address1."','".$address2."', '".$city."', '".$state."', '".$zip."', '".$country."', '".$phone."', '".$email."', '".$pass."', '".$_SERVER['REMOTE_ADDR']."')";
		//die;
			mysql_query("INSERT INTO bsi_clients(first_name, surname, title, street_addr, street_addr2, city, province, zip, country, phone, email, password, ip) VALUES ('".$firstname."','".$lastname."', '".$title."', '".$address1."','".$address2."', '".$city."', '".$state."', '".$zip."', '".$country."', '".$phone."', '".$email."', '".$pass."', '".$_SERVER['REMOTE_ADDR']."')");
			
			$_SESSION['Myname2012']    = $title." ".$firstname." ".$lastname;
			$_SESSION['log_msg']       = "Welcome";
			$_SESSION['myemail2012']   = $email;
			$_SESSION['password_2012'] = $pass;
			$_SESSION['client_id2012'] = mysql_insert_id();
			$_SESSION['agent']         = 0;
			$_SESSION['client']         = 1;
			//mail function
			$bsiMail    = new bsiMail(); 
			$emailBody  = "Dear ".$_SESSION['Myname2012']." ,<br><br>";
			$emailBody .= "Your Registration with us is successful.<br>";
			$emailBody .= "Your Email Id : ".$email." and Password : ".$bsiCore->ClearInput($_POST['pass']);;
			$emailBody .= '<br><br>Regards,<br>';
			$emailBody .= '<font style=\"color:#F00; font-size:10px;\">'.$bsiCore->config['conf_portal_name'].'</font>';
			$emailSubject = "New Account Creation";				
	 		$returnMsg = $bsiMail->sendEMail($email, $emailSubject, $emailBody);
			header("location: checkout_step2.php"); 
			exit;
		}else{
			$_SESSION['isError']=2;
			header("location: checkout_step1.php");
			exit;
		}
		
        break;
			 
    case 'signin':
			 $login_email     = $bsiCore->ClearInput($_POST['login_email']);
			 $login_password  = md5($bsiCore->ClearInput($_POST['login_password']));
			 if(isset($_POST['agent']) && $_POST['agent'] == true){
				 $login = $bsiCore->loginAgent($login_email, $login_password);
			 }else{
				 $login = $bsiCore->login($login_email,$login_password);
			 }
			 
			 if(isset($_SESSION['agent']) && $_SESSION['agent'] == true){
				 if($login == true){
					 header("location: checkout_step2.php");
				 }else{
					 header("location: checkout_step1.php?err3=1"); 
				 }
			 }else{
				 if($login == true){
					 header("location: checkout_step2.php");
					 exit;
				 }else{
					 $_SESSION['isError']=1;
					 header("location: checkout_step1.php");
					 exit;
				 }
			 }
    break;
}

function username_available($email){
	$row = mysql_num_rows(mysql_query("select * from bsi_clients where email='".$email."' and agent=0")); 
	if($row){
		return true;
	}else{
		return false;
	}
}

?>