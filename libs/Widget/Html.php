<?php

require_once(__DIR__."/AbstractWidget.php");

require_once(__DIR__."/../Smarty/Smarty.class.php");

class Html extends AbstractWidget {

    private $title = null;
    private $body = null;

    public function __construct($title="", $body=null) {

        if ($body instanceof AbstractWidget) {
            $this->setBody($body);
        }
        $this->setTitle($title);
    }

    public function setBody($body) {
        if ($body instanceof AbstractWidget) {
            $this->body = $body;
        }
    }

    public function setTitle($title) {
        $this->title = $title;
    }

    public function configure($params){
        if (array_key_exists("body", $params) && is_array($params["body"])) {
            $body = $params["body"];
            if ($body instanceof AbstractWidget){
                $this->setBody($body);
            } else if (is_array($body) && array_key_exists("name", $body)){
                $this->setBody(WidgetFactory::createWidget($body["name"], (array_key_exists("params", $body))?($body["params"]):(null)));
            }
        }

        if (array_key_exists("title", $params)) {
            $this->setTitle($params["title"]);
        }
    }

    public function display() {
        global $config;

        $smarty = new Smarty();
        $smarty->setTemplateDir($config['smartyTemplate']);

        $smarty->assign("title", $this->title);
        $smarty->assign("body", ($this->body instanceof AbstractWidget)?($this->body->display()):(null));

        return $smarty->fetch("html.tpl");
    }
}