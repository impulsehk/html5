<?php
session_start();
// Sends the user to the login-page if not logged in
if(!$_SESSION['password_2012']) :
   header('Location:index.php?msg=requires_login_tseting');
endif;
?>