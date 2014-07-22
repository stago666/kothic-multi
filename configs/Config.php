<?php

global $config, $navItems, $boardurl;

$config = array();

// WebSite title
$config['title'] = "K-Othic Multigaming";

$config['baseUrl'] = "index.php";
$config['forumUrl'] = $boardurl."/index.php";

// News name board
$config['newsBoardName'] = 'Actualités / News';

// Smarty template directory
$config['smartyTemplate'] = "./templates";

// Time in second to increment count for spam protection
$config['intToBan'] = 2;
// Total count before ban for spam
$config['countToBan'] = 10;
