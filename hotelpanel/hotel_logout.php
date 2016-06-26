<?php 
session_start();
if(isset($_SESSION['hpass'])){
	unset($_SESSION['hpass']);
	unset($_SESSION['hhid']);
}
sleep(3);
 header('Location: index.php?msg=logout_successfully');
exit;
?> 