<?php

require_once(__DIR__."/AbstractWidget.php");

require_once(__DIR__."/../Smarty/Smarty.class.php");

require_once(__DIR__."/../smfUtils.php");

// Load.php for censorText()
require_once(__DIR__."/../../forum/Sources/Load.php");
// Subs.php for parse_bbc(), timeformat()
require_once(__DIR__."/../../forum/Sources/Subs.php");

class LastMessage extends AbstractWidget {

    private $msgList = array();

    public function __construct() {
        $this->computeLastMsgList();
    }

    private function computeLastMsgList() {

//        SELECT
//           m.id_msg      AS "msgId",
//           m.id_topic    AS "topicId",
//           m.poster_time AS "dateCreated",
//           m.subject     AS "title",
//           u.real_name   AS "authorName"
//        FROM {db_prefix}messages m INNER JOIN {db_prefix}members u ON m.id_member=u.id_member

        $results = smfapi_getLastMessages();

        foreach ($results as $msg) {

            $title = censorText($msg["title"]);

            if (strlen($title) > 30) {
                $title = substr($title, 0, 27)."...";
            }

            $this->msgList[] = array(
                "msgId" => $msg["msgId"],
                "topicId" => $msg["topicId"],
                "dateCreated" => timeformat($msg["dateCreated"]),
                "title" => $title,
                "authorName" => $msg["authorName"],
                "authorId" => $msg["authorId"]
            );
        }

    }

    public function configure($params) {
        $this->computeLastMsgList();
    }

    public function display() {
        global $config;

        $smarty = new Smarty();
        $smarty->setTemplateDir($config['smartyTemplate']);

        $smarty->assign("name", "Derniers messages forum");
        $smarty->assign("msgList", $this->msgList);
        $smarty->assign("forumUrl", $config["forumUrl"]);

        return $smarty->fetch("lastMessages.tpl");
    }
}