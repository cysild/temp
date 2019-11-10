<?php

require 'vendor/autoload.php';

//require 'senmail.php';


$params = ['from'=>'auth@recruiting-hub.com','name'=>'rh','to'=>'maankartaff@gmail.com','subject'=>'test','message'=>'tets','send'=>true];
echo post_async($params);

/*
 * Executes a PHP page asynchronously so the current page does not have to wait for it to     finish running.
 *  
 */
function post_async( array $params)
{
    foreach ($params as $key => &$val) {
      if (is_array($val)) $val = implode(',', $val);
        $post_params[] = $key.'='.urlencode($val);  
    }
    $post_string = implode('&', $post_params);

//var_dump($post_string);

    $parts=parse_url('http://localhost/async/senmail.php');

    $fp = fsockopen($parts['host'],
        isset($parts['port'])?$parts['port']:80,
        $errno, $errstr, 30);

    $out = "POST ".$parts['path']." HTTP/1.1\r\n";
    $out.= "Host: ".$parts['host']."\r\n";
    $out.= "Content-Type: application/x-www-form-urlencoded\r\n";
    $out.= "Content-Length: ".strlen($post_string)."\r\n";
    $out.= "Connection: Close\r\n\r\n";
    if (isset($post_string)) $out.= $post_string;

    fwrite($fp, $out);
    fclose($fp);
}

?>