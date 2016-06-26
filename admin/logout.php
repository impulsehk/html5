<?php 
session_start();
if(isset($_SESSION['cppass'])){
	unset($_SESSION['cppass']);
	unset($_SESSION['cpuser']);
	unset($_SESSION['cpid']);
	unset($_SESSION['cpaccessid']);
	unset($_SESSION['adultperrrom']);
}
sleep(2);
header('Location: index.php?msglog=logout_complete');
exit;
?> 