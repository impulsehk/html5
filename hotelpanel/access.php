<?php
session_start();
if(!isset($_SESSION['hpass'])) {
   header('Location: index.php?msg=requires_login');
}
?>