<?php

global $config;

// Create LEFT BOARD
$sectionList = new SectionList();
$gametracker = new GameTracker();
$lstMsg = new LastMessage();

$leftBoard = new DefaultWidget("col-xs-3");
$leftBoard->addChild($sectionList);
$leftBoard->addChild($gametracker);
$leftBoard->addChild($lstMsg);

// CREATE RIGHT BOARD
$widget = new News($config['newsBoardName']);

$rightBoard = new DefaultWidget("col-xs-9");
$rightBoard->addChild($widget);

// CREATE BOARDS
$banner = new DefaultWidget("row banner-home");
$banner->addChild(new Image("resources/img/banner.png"));

$boards = new DefaultWidget("row container-fluid");
$boards->addChild($leftBoard);
$boards->addChild($rightBoard);

$content = new DefaultWidget();
$content->addChild($banner);
$content->addChild($boards);

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