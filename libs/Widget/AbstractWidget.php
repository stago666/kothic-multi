<?php

abstract class AbstractWidget {

    public function __construct(){}

    public function __destruct(){}

    abstract public function configure($params);

    abstract public function display();
} 