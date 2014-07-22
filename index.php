<?php

require_once(__DIR__."/forum/BotScout.php");

// SMF call
require_once(__DIR__."/libs/smfUtils.php");
require_once(__DIR__."/libs/utils.php");

// Load.php for censorText()
require_once(__DIR__."/forum/Sources/Load.php");
// Subs.php for parse_bbc(), timeformat()
require_once(__DIR__."/forum/Sources/Subs.php");

// Smarty API
require_once(__DIR__."/libs/Smarty/Smarty.class.php");

// My API
require_once(__DIR__."/libs/Widget/AbstractWidget.php");
require_once(__DIR__."/libs/Widget/DefaultWidget.php");
require_once(__DIR__."/libs/Widget/News.php");
require_once(__DIR__."/libs/Widget/NavBar.php");
require_once(__DIR__."/libs/Widget/Html.php");
require_once(__DIR__."/libs/Widget/Home.php");
require_once(__DIR__."/libs/Widget/Footer.php");
require_once(__DIR__."/libs/Widget/Roster.php");
require_once(__DIR__."/libs/Widget/LastMessage.php");
require_once(__DIR__."/libs/Widget/GameTracker.php");
require_once(__DIR__."/libs/Widget/SectionList.php");
require_once(__DIR__."/libs/Widget/Image.php");

// init function
initializeSMF();

global $config, $navItems, $modSettings, $user_info;

if (array_key_exists("page", $_REQUEST)){
    $path = __DIR__."/pages/".$_REQUEST["page"].".php";
    if (file_exists($path)){
        include_once($path);
    } else {
        include_once(__DIR__."/pages/home.php");
    }
} else {
    include_once(__DIR__."/pages/home.php");
}
