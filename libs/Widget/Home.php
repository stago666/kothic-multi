<?php

require_once(__DIR__."/AbstractWidget.php");
require_once(__DIR__."/NavBar.php");
require_once(__DIR__."/Footer.php");

require_once(__DIR__."/../Smarty/Smarty.class.php");

class Home extends AbstractWidget {

    private $navbar = null;
    private $content = null;
    private $footer = null;

    public function __construct($content=null, $navbar=null, $footer=null) {
        $this->setContent($content);
        $this->setNavBar($navbar);
        $this->setFooter($footer);
    }

    public function setNavBar($navbar) {
        if ($navbar instanceof AbstractWidget) {
            $this->navbar = $navbar;
        }
    }

    public function setFooter($footer) {
        if ($footer instanceof AbstractWidget) {
            $this->footer = $footer;
        }
    }

    public function setContent($content) {
        if ($content instanceof AbstractWidget) {
            $this->content = $content;
        }
    }

    public function configure($params){
        if (array_key_exists("navbar", $params) && is_array($params["navbar"])) {
            $navbar = $params["navbar"];
            if ($navbar instanceof AbstractWidget){
                $this->setNavBar($navbar);
            } else if (is_array($navbar) && array_key_exists("name", $navbar)){
                $this->setNavBar(WidgetFactory::createWidget($navbar["name"], (array_key_exists("params", $navbar))?($navbar["params"]):(null)));
            }
        }
        if (array_key_exists("content", $params) && is_array($params["content"])) {
            $content = $params["content"];
            if ($content instanceof AbstractWidget){
                $this->setContent($content);
            } else if (is_array($content) && array_key_exists("name", $content)){
                $this->setContent(WidgetFactory::createWidget($content["name"], (array_key_exists("params", $content))?($content["params"]):(null)));
            }
        }
        if (array_key_exists("footer", $params) && is_array($params["footer"])) {
            $footer = $params["footer"];
            if ($footer instanceof AbstractWidget){
                $this->setFooter($footer);
            } else if (is_array($footer) && array_key_exists("name", $footer)){
                $this->setFooter(WidgetFactory::createWidget($footer["name"], (array_key_exists("params", $footer))?($footer["params"]):(null)));
            }
        }
    }

    public function display() {
        global $config;

        $smarty = new Smarty();
        $smarty->setTemplateDir($config['smartyTemplate']);

        $smarty->assign("content", ($this->content instanceof AbstractWidget)?($this->content->display()):(null));
        $smarty->assign("navbar", ($this->content instanceof AbstractWidget)?($this->navbar->display()):(null));
        $smarty->assign("footer", ($this->content instanceof AbstractWidget)?($this->footer->display()):(null));

        return $smarty->fetch("home.tpl");
    }
}