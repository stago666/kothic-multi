<?php

require_once(__DIR__."/AbstractWidget.php");

require_once(__DIR__."/../Smarty/Smarty.class.php");

require_once(__DIR__."/../smfUtils.php");

class SectionList extends AbstractWidget {

    private $sections = null;

    public function __construct(){
        $this->computeSectionList();
    }

    private function computeSectionList() {
        global $config;

        $result = smfapi_getSectionList();

        $check = array();

        $this->sections = array();
        foreach ($result as $section) {
            $pattern = explode("-", $section["groupName"]);
            $name = trim($pattern[1]);

            if (!in_array($name, $check)){

                $check[] = $name;
                $icon = str_replace(" ", "_", strtolower($name)).".png";
                if (!file_exists(__DIR__."/../../resources/img/games/".$icon)){
                    $icon = "default.png";
                }

                $this->sections[] = array(
                    "href" => $config['baseUrl']."?page=roster&groupName=".urlencode($name),
                    "name" => $name,
                    "icon" => $icon
                );
            }
        }
    }

    public function configure($params){
        $this->computeSectionList();
    }

    public function display(){
        global $config;

        $smarty = new Smarty();
        $smarty->setTemplateDir($config['smartyTemplate']);

        $smarty->assign("sections", $this->sections);
        $smarty->assign("name", "Nos sections");

        return $smarty->fetch("sectionList.tpl");
    }

} 