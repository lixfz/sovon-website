<?php
error_reporting(0);

$txt = date('Y-m-d H:i:s',time());
$txt .= ' '.$_SERVER['REMOTE_ADDR'];
$txt .= ' '.$_SERVER['REQUEST_METHOD'];
$txt .= ' '.$_SERVER['REQUEST_URI'];
$txt .= ' '.$_SERVER['SERVER_PROTOCOL'];
$txt .= ' '.$_SERVER['HTTP_CONNECTION'];
$txt .= ' '.$_SERVER['HTTP_ACCEPT_LANGUAGE'];
$txt .= ' '.$_SERVER['HTTP_ACCEPT_ENCODING'];
$txt .= ' '.$_SERVER['HTTP_USER_AGENT'];
$txt .= "\r\n"; 

$myfile = fopen("access.log", "a+") or die("Unable to open file!");
fwrite($myfile, $txt);
//记得关闭流
fclose($myfile);

echo $txt;
/*
foreach($_SERVER as $key => $value) { 
    echo $key.': '.$value."\r\n"; 
} 
*/
?>