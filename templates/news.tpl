<div id="news" class="row">
    <div class="container-fluid">
        {section name=n loop=$news}
            <div id="news_{$news[n].id}" class="newsBoard container-fluid wg-block">
                {include file="widget/header.tpl" title=$news[n].title}
                <div class="newsContent container-fluid">
                    <span>{$news[n].body}</span>
                </div>
                <div class="newsFooter container-fluid">
                    <div class="pull-left comments">
                        {if intval($news[n].numReplies) > 0}
                        <a href="{$forumUrl}?topic={$news[n].topicId}.msg{$news[n].lastMsgId}#msg{$news[n].lastMsgId}">{$news[n].numReplies} commentaires</a>
                        {else}
                        <a href="{$forumUrl}?topic={$news[n].topicId}.msg{$news[n].lastMsgId}#msg{$news[n].lastMsgId}">Aucun commentaire</a>
                        {/if}
                    </div>
                    <div class="pull-right author" style="position:relative;">
                        <div class="avatar">
                            <img src="{if strlen($news[n].author.avatar) > 0}{$news[n].author.avatar}{else}http://placekitten.com/g/99/99{/if}"/>
                        </div>
                        <div class="authorData">
                            <div class="newsAuthorName">
                                <a href="{$forumUrl}?action=profile&u={$news[n].author.id}">{$news[n].author.name}</a>
                            </div>
                            <div class="newsCreateDate">
                                <span>le {$news[n].date}</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        {/section}
    </div>
</div>