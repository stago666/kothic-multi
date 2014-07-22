<?php

require_once(__DIR__."/AbstractWidget.php");

require_once(__DIR__."/../Smarty/Smarty.class.php");

class NavBar extends AbstractWidget {

    private $homeHref = "";
    private $homeName = "";

    private $navbar = array();

    public function __construct($homeHref, $homeName, $navbar) {

        $this->homeHref = $homeHref;
        $this->homeName = $homeName;

        foreach($navbar as $nav){
            $this->navbar[] = $this->computeLink($nav);
        }
    }

    private function computeLink($navigation) {
        $nav = array(
            "active" => false,
            "href" => "#",
            "name" => "menu",
            "submenu" => array()
        );

        if (array_key_exists("active", $navigation)) {
            $nav["active"] = $navigation["active"];
        }

        if (array_key_exists("href", $navigation)) {
            $nav["href"] = $navigation["href"];
        }

        if (array_key_exists("name", $navigation)) {
            $nav["name"] = $navigation["name"];
        }

        if (array_key_exists("submenu", $navigation)) {
            foreach($navigation["submenu"] as $subnav){
                $nav["submenu"][] = $this->computeLink($subnav);
            }
        }

        return $nav;
    }

    public function configure($params) {
        global $config;

        $this->homeHref = array_key_exists("homeHref", $params)?$params["homeHref"]:$config['baseUrl'];
        $this->homeName = array_key_exists("homeName", $params)?$params["homeName"]:"";

        if (array_key_exists("navbar", $params) && is_array($params["navbar"])) {
            foreach($params["navbar"] as $nav){
                $this->navbar[] = $this->computeLink($nav);
            }
        }
    }

    public function display() {
        global $config, $user_info;

        $avatarUrl = $user_info["avatar"]["url"];
        if (strlen($avatarUrl) <= 0 && $user_info["avatar"]["id_attach"] != null && $user_info["avatar"]["id_attach"] != 0){
            $avatarUrl = $config["forumUrl"]."?action=dlattach&attach=".$user_info["avatar"]["id_attach"]."&type=avatar";
        }

        $smarty = new Smarty();
        $smarty->setTemplateDir($config['smartyTemplate']);

        $smarty->assign("forumUrl", $config["forumUrl"]);
        $smarty->assign("homeHref", $this->homeHref);
        $smarty->assign("homeName", $this->homeName);
        $smarty->assign("navbar", $this->navbar);
        $smarty->assign("user", array(
            "id" => $user_info["id"],
            "name" => $user_info["name"],
            "avatar" => $avatarUrl,
            "isGuest" => $user_info["is_guest"]
        ));

        return $smarty->fetch("navbar.tpl");
    }
}