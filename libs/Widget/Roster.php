<?php

require_once(__DIR__."/AbstractWidget.php");

require_once(__DIR__."/../Smarty/Smarty.class.php");

require_once(__DIR__."/../smfUtils.php");

class Roster extends AbstractWidget {

    private $userList = array();
    private $sectionName = "";

    public function __construct($groupName) {
        $this->computeUserList($groupName);

        $this->sectionName = $groupName;
    }

    private function computeUserList($groupName) {
        global $config;

        $check = array();

        $groups = smfapi_getSectionGroups($groupName);

        foreach ($groups as $group) {

            $pattern = explode("-",$group["groupName"]);

            $results = smfapi_getSectionMemberList($group["groupId"]);

            foreach ($results as $user) {

                if (!in_array($user["id"], $check)){

                    $check[] = $user["id"];

                    $avatarUrl = $user["avatarUrl"];
                    if (strlen($avatarUrl) <= 0 && $user["avatarId"] != null){
                        $avatarUrl = $config["forumUrl"]."?action=dlattach&attach=".$user["avatarId"]."&type=avatar";
                    }

                    $activity = ((time()-$user["lastLogin"])<(1000*60*60*24*30*3))?("Actif"):("Inactif");

                    $this->userList[] = array(
                        "avatar" => $avatarUrl,
                        "name" => $user["name"],
                        "rank" => $pattern[3],
                        "activity" => $activity
                    );
                }
            }
        }
    }

    public function configure($params) {

        if (array_key_exists("groupId", $params)) {
            $groupId = $params["groupId"];

            $this->computeUserList($groupId);

            $result = smfapi_getSectionInformation($groupId);
            $this->sectionName = $result["groupName"];
        }
    }

    public function display() {
        global $config;

        $smarty = new Smarty();
        $smarty->setTemplateDir($config['smartyTemplate']);

        $smarty->assign("sectionName", $this->sectionName);
        $smarty->assign("userList", $this->userList);

        return $smarty->fetch("roster.tpl");
    }
}