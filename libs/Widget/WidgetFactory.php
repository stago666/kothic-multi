<?php

require_once(__DIR__."/AbstractWidget.php");

class WidgetFactory {

    public static function createWidget($name, $option) {
        try {
            $params = ($option != null && is_array($option))?($option):(array());

            if (array_key_exists("path", $params)){
                require_once($params["path"].$name.".php");
            } else {
                require_once(__DIR__."/".$name.".php");
            }

            $widget = new $name();
            if ($widget instanceof AbstractWidget){
                $widget->configure($params);

                return $widget;
            } else {
                error_log("WARNING ".$name." not exist or is not a valid AbstractWidget");
            }
        } catch (Exception $ex) {
            error_log("ERROR (".$ex->getCode().") in ".$ex->getFile().":".$ex->getLine()." with ".$ex->getMessage()."\n".$ex->getTraceAsString());
        }

        return null;
    }

} 