<?php

global $user_info;

$manageSections = smfapi_getSectionManage();

if (count($manageSections) > 0){

    // Create LEFT BOARD
    $sectionList = new SectionList();
    $lstMsg = new LastMessage();

    $leftBoard = new DefaultWidget("col-xs-3");
    $leftBoard->addChild($sectionList);
    $leftBoard->addChild($lstMsg);

    // CREATE RIGHT BOARD
    $widget = new Roster("Minecraft");

    $rightBoard = new DefaultWidget("col-xs-9");
    $rightBoard->addChild($widget);

    // CREATE BOARDS
    $content = new DefaultWidget("row container-fluid");
    $content->addChild($leftBoard);
    $content->addChild($rightBoard);

    // CREATE NAVBAR
    $navbar = new NavBar("#", "K-Othic Multigaming", getNavBar());
    $containerNavbar = new DefaultWidget("container-fluid");
    $containerNavbar->addChild($navbar);

    // CREATE FOOTER
    $footer = new Footer();

    // CREATE PAGE
    $body = new Home($content, $containerNavbar, $footer);
    $page = new Html($config['title'], $body);

    // DISPLAY
    echo $page->display();

} else {
    include_once(__DIR__."/home.php");
}