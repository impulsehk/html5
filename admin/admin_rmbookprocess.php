<?php
include("access.php");
if(!isset($_SESSION['hotel_id']) || !isset($_SESSION['RoomType_Capacity_Qty'])){
	header("location:admin_room_block.php");
	exit;
}
include("../includes/db.conn.php");
include("../includes/conf.class.php");
include("../includes/admin.class.php");
include("../includes/booking-process.class.php");
include("../includes/mail.class.php");
$pageid     = 27;
$user_id    = $_SESSION['cpid'];
$bsiAdminMain->pageAccess($user_id, $pageid); 
$pass       = md5($_POST['pass']);
$state      = $bsiCore->ClearInput($_POST['state']);
$title      = $bsiCore->ClearInput($_POST['title']);
$firstname  = $bsiCore->ClearInput($_POST['fname']);
$lastname   = $bsiCore->ClearInput($_POST['lname']);
$email      = $bsiCore->ClearInput($_POST['email']);
$address1   = $bsiCore->ClearInput($_POST['address1']);
$city       = $bsiCore->ClearInput($_POST['city']);
$zip        = $bsiCore->ClearInput($_POST['zipcode']);
$country    = $bsiCore->ClearInput($_POST['country_code']);
$phone      = $bsiCore->ClearInput($_POST['phone']);
$message    = $bsiCore->ClearInput($_POST['message']);
$status     = username_available($email);
						
if($status == false){
	$result = mysql_query("INSERT INTO bsi_clients(first_name, surname, title, street_addr, city, province, zip, country, phone, email, password, ip) VALUES ('".$firstname."','".$lastname."', '".$title."', '".$address1."', '".$city."', '".$state."', '".$zip."', '".$country."', '".$phone."', '".$email."', '".$pass."', '".$_SERVER['REMOTE_ADDR']."')");
	
	$_SESSION['Myname2012']      = $title." ".$firstname." ".$lastname;
	$_SESSION['log_msg']         = "Welcome";
	$_SESSION['myemail2012']     = $email;
	$_SESSION['password_2012']   = $pass;
	$_SESSION['client_id2012']   = mysql_insert_id();
	$_SESSION['payment_gateway'] = $_POST['payment_gateway'];
	//mail function
	$bsiMail    = new bsiMail();
	$emailBody  = "Dear ".$_SESSION['Myname2012']." ,<br><br>";
	$emailBody .= "Your Registration with us is successful.<br>";
	$emailBody .= "Your Email Id : ".$email." and Password : ".$bsiCore->ClearInput($_POST['pass']);;
	$emailBody .= '<br><br>Regards,<br>';
	$emailBody .= '<font style=\"color:#F00; font-size:10px;\">'.$bsiCore->config['conf_portal_name'].'</font>';
	
	$emailSubject = "New Account Creation";				
	$returnMsg = $bsiMail->sendEMail($email, $emailSubject, $emailBody);
	header("location: admin_room_bookingProcess.php"); 
	exit;
}else{
	$row = mysql_fetch_assoc(mysql_query("select * from bsi_clients where email='".$email."'"));
	mysql_query("UPDATE bsi_clients SET first_name = '".$firstname."', surname = '".$lastname."', title = '".$title."', street_addr = '".$address1."', city = '".$city."' , province = '".$state."', zip = '".$zip."', country = '".$country."', phone = '".$phone."', password = '".$pass."', ip = '".$_SERVER['REMOTE_ADDR']."' WHERE client_id = '".$row['client_id']."'");
	
	$_SESSION['Myname2012']      = $title." ".$firstname." ".$lastname;
	$_SESSION['log_msg']         = "Welcome";
	$_SESSION['myemail2012']     = $email;
	$_SESSION['password_2012']   = $pass;
	$_SESSION['client_id2012']   = $row['client_id'];
	$_SESSION['payment_gateway'] = $_POST['payment_gateway'];
	
	header("location: admin_room_bookingProcess.php");
	exit;
}
		
function username_available($email){
	$row = mysql_num_rows(mysql_query("select * from bsi_clients where email='".$email."'"));
	if($row){
		return true;
	}else{
		return false;
	}
}
?>
