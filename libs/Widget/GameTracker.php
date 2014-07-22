<?php

require_once(__DIR__."/AbstractWidget.php");

require_once(__DIR__."/../Smarty/Smarty.class.php");

//require_once(__DIR__."/../smfUtils.php");

// Load.php for censorText()
//require_once(__DIR__."/../../forum/Sources/Load.php");
// Subs.php for parse_bbc(), timeformat()
//require_once(__DIR__."/../../forum/Sources/Subs.php");

class GameTracker extends AbstractWidget {

    private $msgList = array();

    public function __construct() {}

    public function configure($params) {}

    public function display() {
        global $config;

        $smarty = new Smarty();
        $smarty->setTemplateDir($config['smartyTemplate']);

        $smarty->assign("name", "Serveur Teamspeak3");

        return $smarty->fetch("gameTracker.tpl");
    }
}