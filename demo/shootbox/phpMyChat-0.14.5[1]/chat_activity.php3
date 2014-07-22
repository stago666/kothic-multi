<?php
// This script is an example of display, in another page of your website,
// the list or number of users connected to the chat

// Lines below must be at the top of your file and completed according
// to your settings

// relative path from this page to your chat directory
$ChatPath = "chat/";

// HTML link to launch the chat (used by constants below)
$ChatLaunch = "<A HREF=\"phpMyChat.php3\" TARGET=\"_self\">chatting</A>";

$ShowPrivate = "0";     // 1 to display users even if they are in a private room,
						// 0 else

$DisplayUsers = "1";    // 0 to display only the number of connected users
                        // 1 to display a list of users

define("NB_USERS_IN","users are ".$ChatLaunch." at this time.");	// used if $DisplayUsers = 0
define("USERS_LOGIN","User ".$ChatLaunch." at this time:");			// used if $DisplayUsers = 1
define("NO_USER","Nobody is ".$ChatLaunch." at this time.");

require("./${ChatPath}/lib/connected_users.lib.php3");
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.0 Transitional//EN">
<HTML>

<HEAD>
<TITLE>Integration of chat activity into your own web page</TITLE>
</HEAD>

<BODY>
<TABLE BORDER=3 CELLPADDING=5>
<TR>
	<TD>
		<?php
		display_connected($ShowPrivate,$DisplayUsers,($DisplayUsers ? USERS_LOGIN : NB_USERS_IN),NO_USER);
		?>
	</TD>
</TR>
</TABLE>
</BODY>

</HTML>