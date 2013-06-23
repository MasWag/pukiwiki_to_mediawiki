<?php
function exist_plugin_convert($text)
{
    return in_array($text, array('comment', 'bl2'));
}


function do_plugin_convert($name, $param)
{
    switch ($name) {
    case 'comment':
        return '<comments />';
    case 'ls2':
        return '{{Special:PrefixIndex/{{PAGENAME}}/}}';
    }
}

function exist_plugin_inline($text)
{
    return 0;
}

function do_plugin_inline($name, $param, $body)
{
}

include('html.php');
include('convert_html.php');
include ('make_link.php');
include ('func.php');

$line_rules = "";
$line_rules = array( "\r" => '<br />' . "\n",);

error_reporting(E_ALL & ~E_NOTICE );

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