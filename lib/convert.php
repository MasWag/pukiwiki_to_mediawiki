<?php
function exist_plugin_convert($text)
{
    return in_array($text, array('comment', 'ls2','bl2', 'br', 'contents', 'ref', 'pcomment'));
}


function do_plugin_convert($name, $param)
{
    switch ($name) {
    case 'br':
        return '<br />';
    case 'comment':
        return '<comments />';
	case 'pcomment':
		return '<comments />';
    case 'ls2':
        if($param == '')
            return '{{Special:PrefixIndex/{{PAGENAME}}/}}';
        else
            return '{{Special:PrefixIndex/' . $param . '/}}';
    case 'contents':
        return '';
    case 'ref':
        global $title;
        $path = preg_replace(':/:', '_', $title);
        $param = preg_replace(array('/"/', ':^./:'), array('',''), $param);
        
        if (in_array(end(explode('.', $param)), array('png', 'bmp', 'gif', 'jpg', 'jpeg' ))) {
            if(is_url($param))
                return '[[Image:' . $param . ']]';
            else
                return '[[Image:' . $path . '_' . $param . ']]';
        } else {
            if(is_url($param))
                return '[[File:' . $param . ']]';
            else
                return '[[File:' . $path . '_' . $param . ']]';
        }
        
    }
}

function exist_plugin_inline($text)
{
    return in_array($text, array('ref', 'new', 'size', 'ruby', 'br'));
}

function do_plugin_inline($name, $args, $body)
{
    //echo("name: $name, param: $param, body: $body\n");

    if ($args !== '') {
		$aryargs = csv_explode(',', $args);
	} else {
		$aryargs = array();
	}

    switch ($name) {
    case 'ref':
        global $title;
        $path = preg_replace(':/:', '_', $title);

        if(is_url($aryargs[0])) {
            return '[[File:' . $aryargs[0] . ']]';
        } else {
            return '[[Image:' . $path . '_' . preg_replace(array('/"/', ':^./:'), array('',''), $aryargs[0]) . ']]';
        }
        break;
    case 'size':
        return '<font style="font-size:' . $aryargs[0]. 'px"> ' . $body .' </font>';
    case 'ruby':
        return '<ruby><rb>' . $body . '</rb><rp>(</rp><rt>' . $aryargs[0] . '</rt><rp>)</rp></ruby>';
    case 'br':
        return '<br/>';
    }
}

include('html.php');
include('convert_html.php');
include ('make_link.php');
include ('func.php');

$line_rules = "";
$line_rules = array( "\r" => '<br />' . "\n",);

if($argc < 2) {
    echo("usage php convert.php [title]\n");
    exit(1);
}
$title = $argv[1];

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
