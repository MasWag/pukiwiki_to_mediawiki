<?php
require('convert_html.php');

error_reporting(E_ALL & ~E_NOTICE);

$fp = fopen('php://stdin', 'rb');  
if(!$fp) exit;  
$stdin = '';  
do {  
    $line = fread($fp, 8192);  
    if (strlen($line) == 0) break;  
    $stdin .= $line . PHP_EOL;  
} while(true);  
fclose($fp);  

echo(convert_html($stdin));
?>