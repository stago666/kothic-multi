<div id="sections" class="row">
    <div class="sectionContent wg-block">
        {include file="widget/header.tpl" title=$name}
        {section loop=$sections name=s}
        <div class="sectionLine container-fluid">
            <a href="{$sections[s].href}" class="row">
                <span class="sectionImg">
                    <img src="resources/img/section_left.png" />
                    <span class="sectionIcon">
                        <img src="resources/img/games/{$sections[s].icon}" />
                    </span>
                </span>
                <span class="sectionText">
                    <span>{$sections[s].name}</span>
                </span>
            </a>
        </div>
        {/section}
    </div>
</div>