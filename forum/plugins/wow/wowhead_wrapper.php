<?php

/*


Author: Matt Mayers http://mattmayers.com/
Update by Garou http://custom.simplemachines.org/mods/index.php?mod=1633

*/

/*
Check to see if libcurl is available, if not fopen is used. If you don't have either, you're SOL.
*/


$wowhead_use_fopen = !function_exists('curl_init');

header("Content-type: text/xml");
ini_set ('user_agent', $_SERVER['HTTP_USER_AGENT']);

$url = "http://www.wowhead.com/item=" . urlencode(addslashes($_GET['item'])) . "&xml";

if ($wowhead_use_fopen) {

    $f = fopen($url, "rb");

    while (!feof($f)) {
        print fread($f, 512);
    }

    fclose($f);
} else {
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_HEADER, 0);
    curl_setopt($ch, CURLOPT_USERAGENT, $_SERVER['HTTP_USER_AGENT']);
    curl_exec($ch);
    curl_close($ch);
}