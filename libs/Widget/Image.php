<?php
/**
 * Created by IntelliJ IDEA.
 * User: trouby
 * Date: 20/02/14
 * Time: 11:45
 */

require_once(__DIR__."/AbstractWidget.php");

class Image extends AbstractWidget {

    private $irmSrc = "";

    public function __construct($url) {
        $this->imgSrc = $url;
    }

    public function configure($params) {
        if (array_key_exists("src", $params)) {
            $this->$irmSrc = $params["src"];
        }
    }

    public function display() {
        return '<img src="'.$this->imgSrc.'" />';
    }
}