<div id="roster" class="row">
    <div class="container-fluid">
        <div class="roster-content wg-block">
            {include file="widget/header.tpl" title=$sectionName}
            <div class="container-fluid">
                {section name=u loop=$userList}
                <div class="roster-member row">
                    <div class="avatar">
                        <img src="{if strlen($userList[u].avatar) > 0}{$userList[u].avatar}{else}http://placekitten.com/g/99/99{/if}"/>
                    </div>
                    <div class="roster-member-nfo">
                        <div class="container-fluid">
                            <div class="row">
                                <div class="col-xs-3">
                                    <span class="member-name">{$userList[u].name}</span>
                                </div>
                                <div class="col-xs-4">
                                    <span class="member-rank">{$userList[u].rank}</span>
                                </div>
                                <div class="col-xs-3">
                                    <span class="member-activity">{$userList[u].activity}</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                {/section}
            </div>
        </div>
    </div>
</div>