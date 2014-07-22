<div id="kothic">

    {if $navbar != null}
    <div id="navbar" class="navbar navbar-default navbar-fixed-top" role="navigation">
        <div class="container-fluid">
            {$navbar}
        </div>
    </div>
    {/if}

    {if $content != null}
    <div class="container-fluid">
        {$content}
    </div>
    {/if}

    {if $footer != null}
    <div id="push"></div>
    {/if}
</div>
{if $footer != null}
<div id="footer">
    <div class="container-fluid">
        {$footer}
    </div>
</div>
{/if}