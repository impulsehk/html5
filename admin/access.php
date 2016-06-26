<?php
session_start();
if(!isset($_SESSION['cppass'])){
   header('Location: login.php?msg=requires_login');
   exit;
}
?>