<?php
set_time_limit(0);
include("../includes/db.conn.php");
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Untitled Document</title>
</head>

<body>
<?php
include("english.php");

$bb=( get_defined_constants(true));
$cc=$bb['user'];

$sql_lang_select=mysql_query("select * from bsi_language where lang_code != 'en'");
while($row_lang_select=mysql_fetch_assoc($sql_lang_select)){
	$filename2=$row_lang_select['lang_file_name'];
	echo $filename2."<br>";
$fp = fopen($filename2, 'w');
fwrite($fp, '<?php ');
foreach($cc as $key=>$val){
$text=urlencode($val);
$aaa=file_get_contents('http://api.microsofttranslator.com/V2/Http.svc/Translate?appId=FE345E5DE648285BC278902E265503D18C311BBF&from=en&to='.$row_lang_select['lang_code'].'&text='.$text);

$textconverted = new SimpleXMLElement($aaa);
$finaltxt="define('".$key."','".$textconverted ."');\n";
fwrite($fp, $finaltxt);
}
fwrite($fp, '?>');
fclose($fp);
}
?>
</body>
</html>