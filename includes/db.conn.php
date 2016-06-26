<?php
define("MYSQL_SERVER", "localhost");
define("MYSQL_USER", "marcouser");
define("MYSQL_PASSWORD", "PBLV9JAK8LMq4php");
define("MYSQL_DATABASE", "marcodb");

mysql_connect(MYSQL_SERVER,MYSQL_USER,MYSQL_PASSWORD) or die ('I cannot connect to the database because 1: ' . mysql_error());
mysql_select_db(MYSQL_DATABASE) or die ('I cannot connect to the database because 2: ' . mysql_error());
?>