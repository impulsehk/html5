<?php
function encryptCard($creditno){
$key = 'sdj*sadt63423h&%$@c34234c346v4c43czxcx'; //Change the key here
$td = mcrypt_module_open('tripledes', '', 'cfb', '');
srand((double) microtime() * 1000000);
$iv = mcrypt_create_iv(mcrypt_enc_get_iv_size($td), MCRYPT_RAND);
$okey = substr(md5($key.rand(0, 9)), 0, mcrypt_enc_get_key_size($td));
mcrypt_generic_init($td, $okey, $iv);
$encrypted = mcrypt_generic($td, $creditno.chr(194));
$code = $encrypted.$iv;
$code = eregi_replace("'", "\'", $code);
return $code;
}

function decryptCard($code){
$key = 'sdj*sadt63423h&%$@c34234c346v4c43czxcx'; // use the same key used for encrypting the data
$td = mcrypt_module_open('tripledes', '', 'cfb', '');
$iv = substr($code, -8);
$encrypted = substr($code, 0, -8);
for ($i = 0; $i < 10; $i++) {
$okey = substr(md5($key.$i), 0, mcrypt_enc_get_key_size($td));
mcrypt_generic_init($td, $okey, $iv);
$decrypted = trim(mdecrypt_generic($td, $encrypted));
mcrypt_generic_deinit($td);
$txt = substr($decrypted, 0, -1);
if (ord(substr($decrypted, -1)) == 194 && is_numeric($txt)) break;
}
mcrypt_module_close($td);
return $txt;
}
?>