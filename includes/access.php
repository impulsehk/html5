<?
session_start();
// Sends the user to the login-page if not logged in
if(!session_is_registered('password_2012')) :
   header('Location: my_account.php?msg=requires_login');
endif;
?>