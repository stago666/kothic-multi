<div class="navbar-header">
    <a class="navbar-brand" href="{$homeHref}">{$homeName}</a>
</div>
<div class="navbar-collapse collapse">
    {if count($navbar) > 0}
    <ul class="nav navbar-nav">
        {section  name=nav loop=$navbar}
        <li class="{if $navbar[nav].active}active{/if} {if count($navbar[nav].submenu)>0}dropdown{/if}">
            <a href="{$navbar[nav].href}" {if count($navbar[nav].submenu)>0}class="dropdown-toggle" data-toggle="dropdown"{/if}>
                <span class="links">{$navbar[nav].name}</span>
                {if count($navbar[nav].submenu)>0}<span class="caret"></span>{/if}
            </a>
            {if count($navbar[nav].submenu) > 0}
            <ul class="dropdown-menu">
                {section name=subnav loop=$navbar[nav].submenu}
                <li {if $navbar[nav].submenu[subnav].active}class="active"{/if}>
                    <a href="{$navbar[nav].submenu[subnav].href}">
                        <span class="links">{$navbar[nav].submenu[subnav].name}</span>
                    </a>
                </li>
                {/section}
            </ul>
            {/if}
        </li>
        {/section}
    </ul>
    {/if}
    <ul class="nav navbar-nav navbar-right">
        {if not $user.isGuest}
        <li>
            <a class="user-shortcuts links" href="{$forumUrl}?action=profile&u={$user.id}">
                <span>{$user.name}</span>
                <img src="{if strlen($user.avatar) > 0}{$user.avatar}{else}http://placekitten.com/g/40/40{/if}"/>
            </a>
        </li>
        {else}
        <li>
            <a class="links" href="{$forumUrl}?action=login">Connexion</a>
        </li>
        <li>
            <a class="links" href="{$forumUrl}?action=register">Inscription</a>
        </li>
        {/if}
    </ul>
</div>