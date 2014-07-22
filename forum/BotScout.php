<?php 

global $IPBLOCK_FILE, $IPFREE_FILE;

// The file where ip block are store
$IPLOCK_FILE = dirname(__FILE__).'/lock_ip_list.txt';
$IPFREE_FILE = dirname(__FILE__).'/free_ip_list.txt';

// testing for an IP
function requestBotScout($ip) {

	$APIKEY = "7Ed2HumMVN6yIoP";
	$apiquery = "http://botscout.com/test/?multi&ip=$ip&key=$APIKEY";

	////////////////////////
	// Use cURL or file_get_contents()?
	// Use file_get_contents() unless not available
	if(function_exists('file_get_contents')){
		// Use file_get_contents
		$returned_data = file_get_contents($apiquery);
	} else {
		$ch = curl_init($apiquery);
		curl_setopt($ch, CURLOPT_HEADER, 0);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		$returned_data = curl_exec($ch);
		curl_close($ch);
	}

	// take the returned value and parse it (standard API, not XML)
	$botdata = explode('|', $returned_data); 

	// sample 'MULTI' return string (standard API, not XML)
	// Y|MULTI|IP|4|MAIL|26|NAME|30
	return $botdata[0];
}

function trimArray(&$array){
	for ($i=0; $i<count($array); $i++){
		$array[$i] = trim($array[$i]);
	}
}

function getListFreeIP(){
	global $IPFREE_FILE;
	if (!file_exists($IPFREE_FILE)) {
		return false;
	}
	$ipString = file_get_contents($IPFREE_FILE);
	
	if ($ipString !== false) {
		$ipArray = explode(PHP_EOL, $ipString);
		natsort($ipArray);
		return $ipArray;
	}
	return false;
}

function getListLockIP(){
	global $IPLOCK_FILE;
	if (!file_exists($IPLOCK_FILE)) {
		return false;
	}
	$ipString = file_get_contents($IPLOCK_FILE);
	
	if ($ipString !== false) {
		$ipArray = explode(PHP_EOL, $ipString);
		natsort($ipArray);
		return $ipArray;
	}
	return false;
}

function createIpTree($ipArray){
	$tree = array();
	for ($i=0; is_array($ipArray) && $i<count($ipArray); $i++) {
		$split = explode('.', $ipArray[$i]);
		if (count($split) == 4) {
			trimArray($split);
			if (!array_key_exists($split[0], $tree)) {
				$tree[$split[0]] = array();
			}
			if (!array_key_exists($split[1], $tree[$split[0]])) {
				$tree[$split[0]][$split[1]] = array();
			}
			if (!array_key_exists($split[2], $tree[$split[0]][$split[1]])) {
				$tree[$split[0]][$split[1]][$split[2]] = array();
			}
			if (!array_key_exists($split[3], $tree[$split[0]][$split[1]][$split[2]])) {
				$tree[$split[0]][$split[1]][$split[2]][$split[3]] = true;
			}
		}
	}
	return $tree;
}

function ipIsFree($ip, $tree) {
	$arIp = explode('.', $ip);
	trimArray($arIp);
	return 	   array_key_exists($arIp[0], $tree) 
			&& array_key_exists($arIp[1], $tree[$arIp[0]])
			&& array_key_exists($arIp[2], $tree[$arIp[0]][$arIp[1]])
			&& array_key_exists($arIp[3], $tree[$arIp[0]][$arIp[1]][$arIp[2]])
			&& $tree[$arIp[0]][$arIp[1]][$arIp[2]][$arIp[3]];
}

function ipIsLock($ip, $tree) {
	$arIp = explode('.', $ip);
	trimArray($arIp);
	return 	   array_key_exists($arIp[0], $tree) 
			&& array_key_exists($arIp[1], $tree[$arIp[0]])
			&& array_key_exists($arIp[2], $tree[$arIp[0]][$arIp[1]])
			&& array_key_exists($arIp[3], $tree[$arIp[0]][$arIp[1]][$arIp[2]])
			&& $tree[$arIp[0]][$arIp[1]][$arIp[2]][$arIp[3]];
}

// get the IP address
$XIP = $_SERVER['REMOTE_ADDR']; 

if (!ipIsFree($XIP, createIpTree(getListFreeIP()))){
	if (ipIsLock($XIP, createIpTree(getListLockIP()))){
		die("This IP is banned from the server");
	}
	$botScout = requestBotScout($XIP);
	if ($botScout == "Y") {
		file_put_contents($IPLOCK_FILE, $XIP.PHP_EOL, FILE_APPEND | LOCK_EX);
		die("This IP is banned from the server");
	} else if ($botScout == "N") {
		file_put_contents($IPFREE_FILE, $XIP.PHP_EOL, FILE_APPEND | LOCK_EX);
	} else {
		// Bot scout error
		// TODO : log this error in SMF journal log
	}
}

?>
