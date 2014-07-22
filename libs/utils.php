<?php
require_once(__DIR__."/../configs/Config.php");

require_once(__DIR__."/IpTree.php");

require_once(__DIR__."/smfUtils.php");


/**
 * Global constants
 */
$IPLOCK_FILE = __DIR__.'/../resources/manager/lock_ip_list.txt';
$IPFREE_FILE = __DIR__.'/../resources/manager/free_ip_list.txt';
$IPTEMP_FILE = __DIR__.'/../resources/manager/temp_ip_list.txt';

/**
 * Utilitary function
 * @param $str_txt
 * @param bool $b_isPrint
 */
function preprint($str_txt, $b_isPrint=false) {
    if ($b_isPrint){
        print_r('<pre>'.print_r($str_txt,true).'</pre>');
    } else {
        echo '<pre>'.print_r($str_txt,true).'</pre>';
    }
}

/**
 * Default ip is current ip
 */
function isBannedUser($ip=""){
    if ($ip=="") {
        $ip = $_SERVER['REMOTE_ADDR'];
    }

    global $config, $user_info, $IPLOCK_FILE, $IPFREE_FILE, $IPTEMP_FILE;

    $banList = new IpTree($IPLOCK_FILE);
    $freeList = new IpTree($IPFREE_FILE);
    $tmpList = new IpTree($IPTEMP_FILE);

    if (!$freeList->isIpKnow($ip)){
        // If this ip is already in the black list
        if ($banList->isIpKnow($ip)){
            $reason = $banList->getInfoOf($ip, IpTree::KEY_REASON);
            return $reason;
        }

        // Try to find this ip on botscout database
        $botScout = requestBotScout($ip);
        if ($botScout == "Y") {
            // Find this ip on the database, bad bot
            $banList->addIp($ip,IpTree::REASON_BOTSCOUT);
            return IpTree::REASON_BOTSCOUT;
        } else if ($botScout == "N") {
            // Don't find on botscout, perhaps a good person...
            $freeList->addIp($ip,IpTree::REASON_BOTSCOUT);
        } else {
            // Bot scout error
            trigger_error($botScout, E_USER_NOTICE);
        }
    }

//    if ($user_info['is_guest']===1 || true) {
        if (!$tmpList->isIpKnow($ip)){
            // This ip is new, it's not a spam
            $tmpList->addIp($ip,
                ($user_info['possibly_robot']!==1)?(IpTree::REASON_NO):("possibly_robot"),
                time(),
                1);
            return false;
        }

        $time = $tmpList->getInfoOf($ip, IpTree::KEY_TIME);

        if ($time!==false && (microtime(true)-$time)<$config['intToBan']) {
            $count = $tmpList->getInfoOf($ip, IpTree::KEY_COUNT);
            if ($count!==false && $count>$config['countToBan']){
                // The limit is reached, perhaps a spammer
                $tmpList->removeIp($ip);
                $freeList->removeIp($ip);
                $banList->addIp($ip, IpTree::REASON_SPAM, time(),1);

                return IpTree::REASON_SPAM;
            } else {
                // The limit is not reached again, so just increment and return
                $tmpList->addInfoFor($ip, array(
                    IpTree::KEY_REASON  =>  ($user_info['possibly_robot']!==1)?(IpTree::REASON_NO):("possibly_robot"),
                    IpTree::KEY_TIME    =>  time(),
                    IpTree::KEY_COUNT   =>  (!$count)?(1):($count+1)
                ));

                return false;
            }
        } else {
            // It's not a spammer, so stay count to 1
            $tmpList->addInfoFor($ip, array(
                IpTree::KEY_TIME    => time(),
                IpTree::KEY_COUNT   => 1
            ));

            return false;
        }
//    }
//    return false;
}

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

function startsWith($haystack,$needle,$case=true) {
    if($case)
        return strpos($haystack, $needle, 0) === 0;

    return stripos($haystack, $needle, 0) === 0;
}

function endsWith($haystack,$needle,$case=true) {
    $expectedPosition = strlen($haystack) - strlen($needle);

    if($case)
        return strrpos($haystack, $needle, 0) === $expectedPosition;

    return strripos($haystack, $needle, 0) === $expectedPosition;
}

function computeNavBarSection(){
    global $config;

    $submenu = array();

    $result = smfapi_getSectionList();

    $check = array();

    foreach ($result as $section) {

        $pattern = explode("-", $section["groupName"]);

        $name = trim($pattern[1]);

        if (!in_array($name, $check)){

            $check[] = $name;
            $active = array_key_exists("page", $_REQUEST) && $_REQUEST["page"] == "roster" && urldecode($_REQUEST["groupName"]) == $name;

            $submenu[] = array(
                "active" => $active,
                "href" => $config['baseUrl']."?page=roster&groupName=".urlencode($name),
                "name" => $name,
                "submenu" => array()
            );
        }
    }

    return $submenu;
}

function getNavBar() {
    global $config;

    $hasPage = array_key_exists("page", $_REQUEST);

    // Navigation bar items
    $navbar = array(
        array(
            "active" => !$hasPage,
            "href" => $config["baseUrl"],
            "name" => "Accueil",
            "submenu" => array()
        ),
        array(
            "active" => $hasPage && $_REQUEST["page"] == "roster",
            "href" => "#",
            "name" => "Nos sections",
            "submenu" => computeNavBarSection()
        ),
        array(
            "active" => false,
            "href" => "forum/index.php",
            "name" => "Forum",
            "submenu" => array()
        )
    );
    return $navbar;
}

function getDefaultPage($content){

}

// Check if is ban
$isBan = isBannedUser($_SERVER['REMOTE_ADDR']);
if ($isBan!==false){
    die('Vous etes banni de ce serveur suite a une detection de '.$isBan.'.<br/>
        Si vous souhaitez contester cela, veuillez nous contacter sur <a href="mailto:contact@k-othic.com">contact@k-othic.com</a>.<br/>
        Votre requete sera etudie dans les plus brefs delais.<br/>
        <br/>
        You are banned from this server by '.$isBan.' detection.<br/>
        If you want to contest this, you can contact us on <a href="mailto:contact@k-othic.com">contact@k-othic.com</a>.<br/>
        Your request will be study in shorter delay.<br/>');
}