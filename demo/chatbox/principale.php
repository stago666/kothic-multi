<html>
<head>
    <title>chat</title>
    <link href=style.css rel=stylesheet type=text/css>
    <script language=JavaScript1.2>
        function smiley(remplacer) {
            document.send.msg.value = document.send.msg.value + remplacer
        }
    </script>
</head>
<body topmargin=2>
<center>
    <img src=images/haut.png align=top>
    <table width=780 cellpadding=0 cellspacing=0 class=tableaux>
        <tr>
            <td>
                <iframe id=messages width=770 height=403 frameborder=0 align=absmiddle scrolling=no
                        src=rafraichir.php></iframe>
                <form name=send method=post action=messages.php>
                    <input type=hidden name=name value="<?php echo controle($name); ?>">
                    <input type=text name=msg size=100 class=pseudo maxlength=85><img src=images/palette.gif
                                                                                      align=middle><? include 'couleurs.php' ?>
                    <input type=submit value=envoyer class=boutons><a href="images/smileys.htm" target="aide"
                                                                      onClick="window.open('','aide','width=330,height=688,left=0,top=0,scrollbars=0,toolbar=no,resizable=no')">
                        <img src=images/aide.gif align=middle border=0 alt="aide rapide"></a>
                    <script language=javascript>document.send.msg.focus();</script>

            </td>
        </tr>
        <td align=center><font class=lapagemagique>L'ajout de lien ou d'adresses E-mail se fait automatiquement.
                Ex : Entrez http://www.votre-site.fr ou encore webmaster@votre-site.fr
                <tr>
                    <td align=center>
                        <br>
                        <a href="JavaScript:smiley('/1/')"><img src=images/1.gif border=0 align=absmiddle alt="/1/"></a>
                        <a href="JavaScript:smiley('/2/')"><img src=images/2.gif border=0 align=absmiddle alt="/2/"></a>
                        <a href="JavaScript:smiley('/3/')"><img src=images/3.gif border=0 align=absmiddle alt="/3/"></a>
                        <a href="JavaScript:smiley('/4/')"><img src=images/4.gif border=0 align=absmiddle alt="/4/"></a>
                        <a href="JavaScript:smiley('/5/')"><img src=images/5.gif border=0 align=absmiddle alt="/5/"></a>
                        <a href="JavaScript:smiley('/6/')"><img src=images/6.gif border=0 align=absmiddle alt="/6/"></a>
                        <a href="JavaScript:smiley('/7/')"><img src=images/7.gif border=0 align=absmiddle alt="/7/"></a>
                        <a href="JavaScript:smiley('/8/')"><img src=images/8.gif border=0 align=absmiddle alt="/8/"></a>
                        <a href="JavaScript:smiley('/9/')"><img src=images/9.gif border=0 align=absmiddle alt="/9/"></a>
                        <a href="JavaScript:smiley('/10/')"><img src=images/10.gif border=0 align=absmiddle alt="/10/"></a>
                        <a href="JavaScript:smiley('/11/')"><img src=images/11.gif border=0 align=absmiddle alt="/11/"></a>
                        <a href="JavaScript:smiley('/12/')"><img src=images/12.gif border=0 align=absmiddle alt="/12/"></a>
                        <a href="JavaScript:smiley('/13/')"><img src=images/13.gif border=0 align=absmiddle alt="/13/"></a>
                        <a href="JavaScript:smiley('/14/')"><img src=images/14.gif border=0 align=absmiddle alt="/14/"></a>
                        <a href="JavaScript:smiley('/15/')"><img src=images/15.gif border=0 align=absmiddle alt="/15/"></a>
                        <a href="JavaScript:smiley('/16/')"><img src=images/16.gif border=0 align=absmiddle alt="/16/"></a>
                        <a href="JavaScript:smiley('/17/')"><img src=images/17.gif border=0 align=absmiddle alt="/17/"></a>
                        <a href="JavaScript:smiley('/18/')"><img src=images/18.gif border=0 align=absmiddle alt="/18/"></a>
                        <a href="JavaScript:smiley('/19/')"><img src=images/19.gif border=0 align=absmiddle alt="/19/"></a>
                        <a href="JavaScript:smiley('/20/')"><img src=images/20.gif border=0 align=absmiddle alt="/20/"></a>
                        <a href="JavaScript:smiley('/21/')"><img src=images/21.gif border=0 align=absmiddle alt="/21/"></a>
                        <a href="JavaScript:smiley('/22/')"><img src=images/22.gif border=0 align=absmiddle alt="/22/"></a>
                        <a href="JavaScript:smiley('/23/')"><img src=images/23.gif border=0 align=absmiddle alt="/23/"></a>
                        <a href="JavaScript:smiley('/24/')"><img src=images/24.gif border=0 align=absmiddle alt="/24/"></a>
                        <a href="JavaScript:smiley('/25/')"><img src=images/25.gif border=0 align=absmiddle alt="/25/"></a>
                        <a href="JavaScript:smiley('/26/')"><img src=images/26.gif border=0 align=absmiddle alt="/26/"></a>
                        <a href="JavaScript:smiley('/27/')"><img src=images/27.gif border=0 align=absmiddle alt="/27/"></a>
                        <a href="JavaScript:smiley('/28/')"><img src=images/28.gif border=0 align=absmiddle alt="/28/"></a>
                        <a href="JavaScript:smiley('/29/')"><img src=images/29.gif border=0 align=absmiddle alt="/29/"></a>
                        <a href="JavaScript:smiley('/30/')"><img src=images/30.gif border=0 align=absmiddle alt="/30/"></a>
                        <a href="JavaScript:smiley('/31/')"><img src=images/31.gif border=0 align=absmiddle alt="/31/"></a>
                        <a href="JavaScript:smiley('/32/')"><img src=images/32.gif border=0 align=absmiddle alt="/32/"></a>
                        <a href="JavaScript:smiley('/33/')"><img src=images/33.gif border=0 align=absmiddle alt="/33/"></a>
                        <a href="JavaScript:smiley('/34/')"><img src=images/34.gif border=0 align=absmiddle alt="/34/"></a>
                        <a href="JavaScript:smiley('/35/')"><img src=images/35.gif border=0 align=absmiddle alt="/35/"></a>
                        <a href="JavaScript:smiley('/36/')"><img src=images/36.gif border=0 align=absmiddle alt="/36/"></a>
                    </td>
                </tr>
    </table>
    <img src=images/bas.png align=top>
    </form>
</body>
</html>