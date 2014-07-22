<?php

require_once(__DIR__."/AbstractWidget.php");

require_once(__DIR__."/../Smarty/Smarty.class.php");

require_once(__DIR__."/../smfUtils.php");

class ManageMenuWidget extends AbstractWidget {

    private $manageList = array();

    public function configure($params) {
        // TODO: Implement configure() method.
    }

    private function computeManageList(){
        global $user_info, $config;

        if ($user_info["is_admin"] == 1){
            $this->manageList[] = array(
                "title" => "Créer une section",
                "href" => $config['baseUrl']."?page=manage&manage=createSection"
            );
        }

        $this->manageList[] = array(
            "title" => "Gestion de match",
            "href" => $config['baseUrl']."?page=manage&manage=match"
        );
    }

    public function display() {
        // TODO: Implement display() method.
    }
}