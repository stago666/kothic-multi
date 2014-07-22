<?php

require_once(__DIR__."/AbstractWidget.php");

require_once(__DIR__."/../Smarty/Smarty.class.php");

require_once(__DIR__."/../smfUtils.php");

// Load.php for censorText()
require_once(__DIR__."/../../forum/Sources/Load.php");
// Subs.php for parse_bbc(), timeformat()
require_once(__DIR__."/../../forum/Sources/Subs.php");

class News extends AbstractWidget {

    private $newsList = array();

    public function __construct($newsBoardName) {
        $this->computeNewsList($newsBoardName);
    }

    private function computeNewsList($newsBoardName, $limit=5) {

        global $config;

        $countNews = count($this->newsList);
        if ($countNews > 0){
            array_slice($this->newsList, 0, $countNews);
        }

        $newsQueryResults = smfapi_getTopicNewsList($newsBoardName, $limit);

        foreach ($newsQueryResults as $nqr) {
            $title = censorText($nqr["title"]);
            $body = parse_bbc(censorText($nqr["body"]), $nqr["smileysEnabled"]);


            $avatarUrl = $nqr["authorAvatarUrl"];
            if (strlen($avatarUrl) <= 0 && $nqr["authorAvatarId"] != null && $nqr["authorAvatarId"] != 0){
                $avatarUrl = $config["forumUrl"]."?action=dlattach&attach=".$nqr["authorAvatarId"]."&type=avatar";
            }

            $this->newsList[] = array(
                "id" => $nqr["newsId"],
                "title" => $title,
                "body" => $body,
                "author" => array(
                    "id" => $nqr["authorId"],
                    "name" => $nqr["authorName"],
                    "avatar" => $avatarUrl
                ),
                "date" => timeformat($nqr["createdTime"]),
                "lastMsgId" => $nqr["lastMsgId"],
                "topicId" => $nqr["topicId"],
                "numReplies" => $nqr["numReplies"]
            );
        }
    }

    public function configure($params){
        if (array_key_exists("newsBoardName", $params)){
            $this->computeNewsList($params["newsBoardName"]);
        }
    }

    public function display() {
        global $config;

        $smarty = new Smarty();
        $smarty->setTemplateDir($config['smartyTemplate']);

        // <a href="{$forumUrl}?topic={$msgList[msg].topicId}.msg{$msgList[msg].msgId}#msg{$msgList[msg].msgId}">{$msgList[msg].title}</a>

        $smarty->assign("forumUrl", $config["forumUrl"]);
        $smarty->assign("news", $this->newsList);

        return $smarty->fetch("news.tpl");
    }
}