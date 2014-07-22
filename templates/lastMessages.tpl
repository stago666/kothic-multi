<div id="lastMsgs" class="row">
    <div class="lstMsgContent wg-block">
        {include file="widget/header.tpl" title=$name}
        {section loop=$msgList name=msg}
        <div class="container-fluid lstMsgLine">
            <div class="row">
                <span class="lstMsgText">
                    <a href="{$forumUrl}?topic={$msgList[msg].topicId}.msg{$msgList[msg].msgId}#msg{$msgList[msg].msgId}">{$msgList[msg].title}</a> par <a href="{$forumUrl}?action=profile&u={$msgList[msg].authorId}">{$msgList[msg].authorName}</a>
                </span>
            </div>
            <div class="row">
                <span class="lstMsgText">
                    le {$msgList[msg].dateCreated}
                </span>
            </div>
        </div>
        {/section}
    </div>
</div>