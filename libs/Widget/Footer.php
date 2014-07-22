<?php

require_once(__DIR__."/AbstractWidget.php");

require_once(__DIR__."/../Smarty/Smarty.class.php");

class Footer extends AbstractWidget {

    public function __construct() {}

    public function configure($params){

    }

    public function display() {
        global $config;

        $smarty = new Smarty();
        $smarty->setTemplateDir($config['smartyTemplate']);

//        $smarty->assign("class", $this->class);
//        $smarty->assign("children", $childrenStr);

        return $smarty->fetch("footer.tpl");
    }
}