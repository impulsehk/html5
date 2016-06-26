<?php
date_default_timezone_set('America/Los_Angeles');
echo  $currtime=date('H:i'); 

	if($currtime >='00:00' && $currtime <='05:59'){
		echo "aesbay";
	}else{
		echo "aesbay na";
	}
$rkey=$_GET['rkey'];
echo $temp_password = substr(uniqid(), -8, 8);
//echo $rkey;
 ?>