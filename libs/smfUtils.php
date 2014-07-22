<?php

// SMF API Function and SMF logging
require_once(__DIR__."/../forum/smf_2_api.php");

// Load.php for detectBrowser(), loadUserSettings()
require_once(__DIR__."/../forum/Sources/Load.php");
// Security.php for is_not_banned(), boardsAllowedTo()
require_once(__DIR__."/../forum/Sources/Security.php");

// MISSING define in api
if (!defined('WIRELESS'))
    define('WIRELESS', isset($_REQUEST['wap']) || isset($_REQUEST['wap2']) || isset($_REQUEST['imode']));

// WebSite extra config
require_once(__DIR__."/../configs/Config.php");

function smfapi_getBoardsViewList() {
    global $smcFunc, $user_info;

    if ($user_info["is_admin"] == 1){
        return array(0);
    }

    $request = $smcFunc['db_query']('', '
        SELECT
            id_board         AS "boardId",
            member_groups    AS "membersGroups"
        FROM {db_prefix}boards
        ORDER BY id_board ASC'
    );

    $results = array();
    while ($row = $smcFunc['db_fetch_assoc']($request)){
        $memberGroups = explode(",", $row["membersGroups"]);
        if (count(array_intersect($memberGroups, $user_info["groups"])) > 0) {
            $results[] = $row["boardId"];
        }
    }

    $smcFunc['db_free_result']($request);

    return $results;
}

function smfapi_getLastMessages($limit=5) {
    global $smcFunc, $user_info;

    $boardsViewList = smfapi_getBoardsViewList();

    $request = null;

    // bp.permission IN ({array_string:permissions})
    if (count($boardsViewList) <= 0){
        return array();
    } else if ($boardsViewList == array(0)){
        $request = $smcFunc['db_query']('', '
            SELECT
                m.id_msg      AS "msgId",
                m.id_topic    AS "topicId",
                m.poster_time AS "dateCreated",
                m.subject     AS "title",
                u.real_name   AS "authorName",
                u.id_member   AS "authorId"
            FROM {db_prefix}messages m INNER JOIN {db_prefix}members u ON m.id_member=u.id_member
			ORDER BY m.poster_time DESC
            LIMIT {int:limit}',
            array(
                'limit' => $limit
            )
        );
    } else {
        $request = $smcFunc['db_query']('', '
            SELECT
                m.id_msg      AS "msgId",
                m.id_topic    AS "topicId",
                m.poster_time AS "dateCreated",
                m.subject     AS "title",
                u.real_name   AS "authorName",
                u.id_member   AS "authorId"
            FROM {db_prefix}messages m INNER JOIN {db_prefix}members u ON m.id_member=u.id_member
            WHERE id_board IN ({array_int:boards})
			ORDER BY m.poster_time DESC
            LIMIT {int:limit}',
            array(
                'limit' => $limit,
                'boards' => $boardsViewList
            )
        );
    }

    if ($request == null){
        return array();
    }

    $results = array();
    while ($row = $smcFunc['db_fetch_assoc']($request)) {
        $results[] = $row;
    }

    $smcFunc['db_free_result']($request);

    return $results;
}

function smfapi_getSectionInformation($groupId) {
    global $smcFunc;

    $request = $smcFunc['db_query']('', '
        SELECT
            id_group         AS "groupId",
            group_name       AS "groupName"
        FROM {db_prefix}membergroups
        WHERE id_group = {int:groupId}
        ORDER BY group_name ASC',
        array(
            'groupId' => $groupId
        )
    );

    $result = $smcFunc['db_fetch_assoc']($request);

    $smcFunc['db_free_result']($request);

    return $result;
}

function smfapi_getSectionMemberList($groupId) {
    global $smcFunc;

    $request = $smcFunc['db_query']('', '
        SELECT
            m.id_member     AS "id",
            m.real_name     AS "name",
            m.avatar        AS "avatarUrl",
            a.id_attach     AS "avatarId",
            m.last_login    AS "lastLogin"
        FROM {db_prefix}members m LEFT JOIN {db_prefix}attachments a ON m.id_member=a.id_member
        WHERE id_group = {int:groupId}
            OR additional_groups LIKE \'%{int:groupId}%\'
        ORDER BY m.real_name ASC',
        array(
            'groupId' => $groupId
        )
    );

    $results = array();
    while ($row = $smcFunc['db_fetch_assoc']($request)) {
        $results[] = $row;
    }

    $smcFunc['db_free_result']($request);

    return $results;
}

function smfapi_getSectionManage(){
    global $smcFunc, $user_info;

    if ($user_info["is_guest"] == 1){
        return array();
    }

    $request;
    if ($user_info["is_admin"] == 1){
        $request = $smcFunc['db_query']('', '
        SELECT
            id_group         AS "groupId",
            group_name       AS "groupName"
        FROM {db_prefix}membergroups
        WHERE group_name LIKE \'SECTION - % - Manageur\'
        ORDER BY group_name ASC'
        );
    } else {
        $request = $smcFunc['db_query']('', '
        SELECT
            id_group         AS "groupId",
            group_name       AS "groupName"
        FROM {db_prefix}membergroups
        WHERE group_name LIKE \'SECTION - % - Manageur\'
         AND id_group IN ({array_int:groups})
        ORDER BY group_name ASC',
            array(
                'groups' => $user_info["groups"]
            )
        );
    }

    $results = array();
    while ($row = $smcFunc['db_fetch_assoc']($request)) {
        $results[] = $row;
    }

    $smcFunc['db_free_result']($request);

    return $results;
}

function smfapi_getSectionGroups($sectionName) {
    global $smcFunc;

    $request = $smcFunc['db_query']('', '
        SELECT
            id_group         AS "groupId",
            group_name       AS "groupName"
        FROM {db_prefix}membergroups
        WHERE group_name LIKE \'SECTION - '.$sectionName.'%\'
        ORDER BY group_name ASC'
    );

    $results = array();
    while ($row = $smcFunc['db_fetch_assoc']($request)) {
        $results[] = $row;
    }

    $smcFunc['db_free_result']($request);

    return $results;
}

function smfapi_getSectionList() {
    global $smcFunc;

    $request = $smcFunc['db_query']('', '
        SELECT
            id_group         AS "groupId",
            group_name       AS "groupName"
        FROM {db_prefix}membergroups
        WHERE group_name LIKE \'SECTION - %\'
        ORDER BY group_name ASC
    ');

    $results = array();
    while ($row = $smcFunc['db_fetch_assoc']($request)) {
        $results[] = $row;
    }

    $smcFunc['db_free_result']($request);

    return $results;
}

/**
 * Get
 *
 * @return array
 */
function smfapi_getTopicNewsList($newsBoardName, $limit=5) {
    global $smcFunc, $modSettings;

    $modSettings['disableQueryCheck'] = true;

    $subrequest_1 = 'SELECT id_board FROM {db_prefix}boards WHERE name LIKE \''.$newsBoardName.'\'';

    $request = $smcFunc['db_query']('', '
        SELECT
            u.id_member         AS "authorId",
            u.real_name         AS "authorName",
            u.avatar            AS "authorAvatarUrl",
            a.id_attach         AS "authorAvatarId",
            m.poster_time       AS "createdTime",
            m.subject           AS "title",
            m.body              AS "body",
            m.smileys_enabled   AS "smileysEnabled",
            m.id_msg            AS "newsId",
            t.id_last_msg       AS "lastMsgId",
            t.id_topic          AS "topicId",
            t.num_replies       AS "numReplies"
        FROM {db_prefix}topics t INNER JOIN {db_prefix}messages m ON t.id_first_msg=m.id_msg
		                         INNER JOIN {db_prefix}members u ON m.id_member=u.id_member
		                         LEFT JOIN {db_prefix}attachments a ON u.id_member=a.id_member
        WHERE t.id_board = ('.$subrequest_1.')
        ORDER BY m.poster_time DESC
        LIMIT '.$limit.';
    ');

    $results = array();
    while ($row = $smcFunc['db_fetch_assoc']($request)) {
        $results[] = $row;
    }

    $smcFunc['db_free_result']($request);

    $modSettings['disableQueryCheck'] = false;

    return $results;
}

function initializeSMF() {

    global $user_info, $mbname, $context, $txt, $modSettings;

    findBindCheckIp();

    loadUserSettings();

    is_not_banned();

    detectBrowser_once();
    detectServer();

    // To load smileys
    $user_info['smiley_set'] = (!in_array($user_info['smiley_set'], explode(',', $modSettings['smiley_sets_known'])) && $user_info['smiley_set'] != 'none') || empty($modSettings['smiley_sets_enable']) ? (!empty($settings['smiley_sets_default']) ? $settings['smiley_sets_default'] : $modSettings['smiley_sets_default']) : $user_info['smiley_set'];

    // To load translation
    $context['forum_name'] = $mbname;
//    $txt = array();
    loadLanguage('index');
    loadLanguage('Modifications');
//    require_once("./forum/Themes/default/languages/index.".$user_info["language"].".php");
}

function findBindCheckIp() {
    // Try to calculate their most likely IP for those people behind proxies (And the like).
    $_SERVER['BAN_CHECK_IP'] = $_SERVER['REMOTE_ADDR'];

    // Find the user's IP address. (but don't let it give you 'unknown'!)
    if (!empty($_SERVER['HTTP_X_FORWARDED_FOR']) && !empty($_SERVER['HTTP_CLIENT_IP']) && (preg_match('~^((0|10|172\.(1[6-9]|2[0-9]|3[01])|192\.168|255|127)\.|unknown)~', $_SERVER['HTTP_CLIENT_IP']) == 0 || preg_match('~^((0|10|172\.(1[6-9]|2[0-9]|3[01])|192\.168|255|127)\.|unknown)~', $_SERVER['REMOTE_ADDR']) != 0))
    {
        // We have both forwarded for AND client IP... check the first forwarded for as the block - only switch if it's better that way.
        if (strtok($_SERVER['HTTP_X_FORWARDED_FOR'], '.') != strtok($_SERVER['HTTP_CLIENT_IP'], '.') && '.' . strtok($_SERVER['HTTP_X_FORWARDED_FOR'], '.') == strrchr($_SERVER['HTTP_CLIENT_IP'], '.') && (preg_match('~^((0|10|172\.(1[6-9]|2[0-9]|3[01])|192\.168|255|127)\.|unknown)~', $_SERVER['HTTP_X_FORWARDED_FOR']) == 0 || preg_match('~^((0|10|172\.(1[6-9]|2[0-9]|3[01])|192\.168|255|127)\.|unknown)~', $_SERVER['REMOTE_ADDR']) != 0))
            $_SERVER['BAN_CHECK_IP'] = implode('.', array_reverse(explode('.', $_SERVER['HTTP_CLIENT_IP'])));
        else
            $_SERVER['BAN_CHECK_IP'] = $_SERVER['HTTP_CLIENT_IP'];
    }
    if (!empty($_SERVER['HTTP_CLIENT_IP']) && (preg_match('~^((0|10|172\.(1[6-9]|2[0-9]|3[01])|192\.168|255|127)\.|unknown)~', $_SERVER['HTTP_CLIENT_IP']) == 0 || preg_match('~^((0|10|172\.(1[6-9]|2[0-9]|3[01])|192\.168|255|127)\.|unknown)~', $_SERVER['REMOTE_ADDR']) != 0))
    {
        // Since they are in different blocks, it's probably reversed.
        if (strtok($_SERVER['REMOTE_ADDR'], '.') != strtok($_SERVER['HTTP_CLIENT_IP'], '.'))
            $_SERVER['BAN_CHECK_IP'] = implode('.', array_reverse(explode('.', $_SERVER['HTTP_CLIENT_IP'])));
        else
            $_SERVER['BAN_CHECK_IP'] = $_SERVER['HTTP_CLIENT_IP'];
    }
    elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR']))
    {
        // If there are commas, get the last one.. probably.
        if (strpos($_SERVER['HTTP_X_FORWARDED_FOR'], ',') !== false)
        {
            $ips = array_reverse(explode(', ', $_SERVER['HTTP_X_FORWARDED_FOR']));

            // Go through each IP...
            foreach ($ips as $i => $ip)
            {
                // Make sure it's in a valid range...
                if (preg_match('~^((0|10|172\.(1[6-9]|2[0-9]|3[01])|192\.168|255|127)\.|unknown)~', $ip) != 0 && preg_match('~^((0|10|172\.(1[6-9]|2[0-9]|3[01])|192\.168|255|127)\.|unknown)~', $_SERVER['REMOTE_ADDR']) == 0)
                    continue;

                // Otherwise, we've got an IP!
                $_SERVER['BAN_CHECK_IP'] = trim($ip);
                break;
            }
        }
        // Otherwise just use the only one.
        elseif (preg_match('~^((0|10|172\.(1[6-9]|2[0-9]|3[01])|192\.168|255|127)\.|unknown)~', $_SERVER['HTTP_X_FORWARDED_FOR']) == 0 || preg_match('~^((0|10|172\.(1[6-9]|2[0-9]|3[01])|192\.168|255|127)\.|unknown)~', $_SERVER['REMOTE_ADDR']) != 0)
            $_SERVER['BAN_CHECK_IP'] = $_SERVER['HTTP_X_FORWARDED_FOR'];
    }
}

function detectBrowser_once() {
    global $context;

    if (!array_key_exists('browser', $context)) {
        detectBrowser();
    }
}

function detectServer() {
    global $context;

    // This determines the server... not used in many places, except for login fixing.
    $context['server'] = array(
        'is_iis' => isset($_SERVER['SERVER_SOFTWARE']) && strpos($_SERVER['SERVER_SOFTWARE'], 'Microsoft-IIS') !== false,
        'is_apache' => isset($_SERVER['SERVER_SOFTWARE']) && strpos($_SERVER['SERVER_SOFTWARE'], 'Apache') !== false,
        'is_lighttpd' => isset($_SERVER['SERVER_SOFTWARE']) && strpos($_SERVER['SERVER_SOFTWARE'], 'lighttpd') !== false,
        'is_nginx' => isset($_SERVER['SERVER_SOFTWARE']) && strpos($_SERVER['SERVER_SOFTWARE'], 'nginx') !== false,
        'is_cgi' => isset($_SERVER['SERVER_SOFTWARE']) && strpos(php_sapi_name(), 'cgi') !== false,
        'is_windows' => strpos(PHP_OS, 'WIN') === 0,
        'iso_case_folding' => ord(strtolower(chr(138))) === 154,
        'complex_preg_chars' => @version_compare(PHP_VERSION, '4.3.3') != -1,
    );
    // A bug in some versions of IIS under CGI (older ones) makes cookie setting not work with Location: headers.
    $context['server']['needs_login_fix'] = $context['server']['is_cgi'] && $context['server']['is_iis'];
}