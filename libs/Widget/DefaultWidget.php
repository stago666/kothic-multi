<?php

require_once(__DIR__."/AbstractWidget.php");

class DefaultWidget extends AbstractWidget {


    private $children = array();

    private $class = "";

    public function __construct($class=null) {
        if ($class != null) {
            $this->setClass($class);
        }
    }

    public function __destruct() {
        $this->resetChild();
    }

    public function configure($params) {
        if (array_key_exists("children", $params) && is_array($params["children"])) {
            foreach ($params["children"] as $child) {
                if ($child instanceof AbstractWidget){
                    $this->addChild($child);
                } else if (is_array($child) && array_key_exists("name", $child)){
                    $this->addChild(WidgetFactory::createWidget($child["name"], (array_key_exists("params", $child))?($child["params"]):(null)));
                }
            }
        }

        if (array_key_exists("class", $params)) {
            $this->setClass($params["class"]);
        }
    }

    public function display() {
        $childrenStr = "";
        foreach ($this->children as $child) {
            if ($child instanceof AbstractWidget){
                $childrenStr .= $child->display();
            }
        }

        return '<div '.((strlen($this->class) > 0)?('class="'.$this->class.'"'):("")).'>'.$childrenStr.'</div>';
    }

    public function setClass($class){
        $this->class = $class;
    }

    public function addChild($child){
        if ($child instanceof AbstractWidget){
            $this->children[] = $child;
        }
    }

    public function getChildren() {
        return $this->children;
    }

    public function removeChild($rmchild){
        $countChildren = count($this->children);
        for ($i=0; $i<$countChildren; $i++) {
            $child = $this->children[$i];
            if ($child == $rmchild){
                if ($child instanceof DefaultWidget) {
                    $child->resetChild();
                }
                array_slice($this->children, $i, 1);
                break;
            }
        }
    }

    public function resetChild(){
        foreach ($this->children as $child) {
            if ($child instanceof DefaultWidget){
                $child->resetChild();
            }
        }
        array_slice($this->children, 0, count($this->children));
    }
}