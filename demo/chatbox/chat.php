<?php
Function controle($lapagemagique)
{
    $lapagemagique = htmlspecialchars($lapagemagique);
    $lapagemagique = nl2br($lapagemagique);
    $lapagemagique = str_replace("/1/", "<img src=images/1.gif border=0 align=absmiddle>", $lapagemagique);
    $lapagemagique = str_replace("/2/", "<img src=images/2.gif border=0 align=absmiddle>", $lapagemagique);
    $lapagemagique = str_replace("/3/", "<img src=images/3.gif border=0 align=absmiddle>", $lapagemagique);
    $lapagemagique = str_replace("/4/", "<img src=images/4.gif border=0 align=absmiddle>", $lapagemagique);
    $lapagemagique = str_replace("/5/", "<img src=images/5.gif border=0 align=absmiddle>", $lapagemagique);
    $lapagemagique = str_replace("/6/", "<img src=images/6.gif border=0 align=absmiddle>", $lapagemagique);
    $lapagemagique = str_replace("/7/", "<img src=images/7.gif border=0 align=absmiddle>", $lapagemagique);
    $lapagemagique = str_replace("/8/", "<img src=images/8.gif border=0 align=absmiddle>", $lapagemagique);
    $lapagemagique = str_replace("/9/", "<img src=images/9.gif border=0 align=absmiddle>", $lapagemagique);
    $lapagemagique = str_replace("/10/", "<img src=images/10.gif border=0 align=absmiddle>", $lapagemagique);
    $lapagemagique = str_replace("/11/", "<img src=images/11.gif border=0 align=absmiddle>", $lapagemagique);
    $lapagemagique = str_replace("/12/", "<img src=images/12.gif border=0 align=absmiddle>", $lapagemagique);
    $lapagemagique = str_replace("/13/", "<img src=images/13.gif border=0 align=absmiddle>", $lapagemagique);
    $lapagemagique = str_replace("/14/", "<img src=images/14.gif border=0 align=absmiddle>", $lapagemagique);
    $lapagemagique = str_replace("/15/", "<img src=images/15.gif border=0 align=absmiddle>", $lapagemagique);
    $lapagemagique = str_replace("/16/", "<img src=images/16.gif border=0 align=absmiddle>", $lapagemagique);
    $lapagemagique = str_replace("/17/", "<img src=images/17.gif border=0 align=absmiddle>", $lapagemagique);
    $lapagemagique = str_replace("/18/", "<img src=images/18.gif border=0 align=absmiddle>", $lapagemagique);
    $lapagemagique = str_replace("/19", "<img src=images/19.gif border=0 align=absmiddle>", $lapagemagique);
    $lapagemagique = str_replace("/20/", "<img src=images/20.gif border=0 align=absmiddle>", $lapagemagique);
    $lapagemagique = str_replace("/21/", "<img src=images/21.gif border=0 align=absmiddle>", $lapagemagique);
    $lapagemagique = str_replace("/22/", "<img src=images/22.gif border=0 align=absmiddle>", $lapagemagique);
    $lapagemagique = str_replace("/23/", "<img src=images/23.gif border=0 align=absmiddle>", $lapagemagique);
    $lapagemagique = str_replace("/24/", "<img src=images/24.gif border=0 align=absmiddle>", $lapagemagique);
    $lapagemagique = str_replace("/25/", "<img src=images/25.gif border=0 align=absmiddle>", $lapagemagique);
    $lapagemagique = str_replace("/26/", "<img src=images/26.gif border=0 align=absmiddle>", $lapagemagique);
    $lapagemagique = str_replace("/27/", "<img src=images/27.gif border=0 align=absmiddle>", $lapagemagique);
    $lapagemagique = str_replace("/28/", "<img src=images/28.gif border=0 align=absmiddle>", $lapagemagique);
    $lapagemagique = str_replace("/29/", "<img src=images/29.gif border=0 align=absmiddle>", $lapagemagique);
    $lapagemagique = str_replace("/30/", "<img src=images/30.gif border=0 align=absmiddle>", $lapagemagique);
    $lapagemagique = str_replace("/31/", "<img src=images/31.gif border=0 align=absmiddle>", $lapagemagique);
    $lapagemagique = str_replace("/32/", "<img src=images/32.gif border=0 align=absmiddle>", $lapagemagique);
    $lapagemagique = str_replace("/33/", "<img src=images/33.gif border=0 align=absmiddle>", $lapagemagique);
    $lapagemagique = str_replace("/34/", "<img src=images/34.gif border=0 align=absmiddle>", $lapagemagique);
    $lapagemagique = str_replace("/35/", "<img src=images/35.gif border=0 align=absmiddle>", $lapagemagique);
    $lapagemagique = eregi_replace("&lt;([[:alnum:]]+)://([^[:space:]]*)([[:alnum:]#?/&=])&gt;", "<A HREF=\"\\1://\\2\\3\" TARGET=\"_blank\">\\1://\\2\\3</A>", $lapagemagique);
    $lapagemagique = eregi_replace("\[([[:alnum:]]+)://([^[:space:]]*)([[:alnum:]#?/&=])\]", "<center><img src=\"\\1://\\2\\3\" border=0 align=absmiddle></center>", $lapagemagique);
    $lapagemagique = eregi_replace("(([a-z0-9_]|\\-|\\.)+@([^[:space:]]*)([[:alnum:]-])\.([^[:space:]]*)([[:alnum:]-]))", "<a href=\"mailto:\\1\">\\1</a>", $lapagemagique);
    return $lapagemagique;
}

if ($msg != "") {
    Function lapagemagique2($contenu)
    {
        $fp = fopen("chat.txt", "w");
        $r = fwrite($fp, "$contenu");
        fclose($fp);
    }

    Function lapagemagique3()
    {
        $max = 20;
        $fcontents = file("chat.txt");
        $lines = count($fcontents);
        if ($lines < $max) {
            $startline = 0;
        } else {
            $startline = $lines - $max;
        }
        for ($i = 0; $i <= $max; $i++) {
            $contenu .= $fcontents[$i + $startline];
        }
        return $contenu;
    }

    lapagemagique2(lapagemagique3() . "<font class=lapagemagique1>" . date("H:i") . " : <font class=lapagemagique2>" . $name . "
<font size=-2 color=$color> : " . controle(stripslashes($msg)) . "<br>");
}
include("principale.php");
?>

