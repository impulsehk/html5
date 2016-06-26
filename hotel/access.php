<?php
session_start();
if(!isset($_SESSION['hpass'])) {
   header('Location: login.php?msg=requires_login');
}
?>