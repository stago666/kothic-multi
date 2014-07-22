<div id="gametracker" class="row">
    <div class="gametrackerContent wg-block">
        {include file="widget/header.tpl" title=$name}
        <div class="container-fluid gametrackerLine">
            <div class="row">
                <iframe id="gametracker" src="" frameborder="0" scrolling="no" width="0" height="348"></iframe>
            </div>
        </div>
        <script type="text/javascript">
            jQuery("document").ready(function(){
                var resizeGT = function(){
                    var gt = jQuery("#gametracker");
                    var iframe = gt.find("iframe");

                    var url = "http://cache.www.gametracker.com/components/html0/?host=ts3.k-othic.fr:51345&bgColor=333333&fontColor=CCCCCC&titleBgColor=222222&titleColor=FF9900&borderColor=555555&linkColor=FFCC00&borderLinkColor=222222&showMap=0&currentPlayersHeight=160&showCurrPlayers=1&showTopPlayers=0&showBlogs=0";
                    var width = Math.max(120, Math.min(gt.innerWidth(), 240));

                    if (iframe.prop("width")!=width) {
                        iframe.prop("src", url + "&width=" + width);
                        iframe.prop("width", width);
                    }
                };

                jQuery(window).resize(resizeGT);
                resizeGT(); // init
            });
        </script>
    </div>
</div>