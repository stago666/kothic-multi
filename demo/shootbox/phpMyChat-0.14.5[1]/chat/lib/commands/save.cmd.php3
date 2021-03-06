<?php

// ** Check for messages to be saved **

// Define the SQL query (depends on values for ignored users list and on whether to display
// notification messages or not)

$CondForQuery = "";
$IgnoreList = "'SYS enter','SYS exit','SYS delreg','SYS promote'";
if (isset($Ign) && $Ign != "") $IgnoreList = ",'".str_replace(",","','",addslashes(urldecode($Ign)))."'";
if ($IgnoreList != "") $CondForQuery = "username NOT IN (${IgnoreList}) AND ";
$CondForQuery .= "(address IN ('$U',' *') OR (room = '$R' AND (address = '' OR username = '$U')))";

$DbLink->query("SELECT Count(*) FROM ".C_MSG_TBL." WHERE ".$CondForQuery." LIMIT 1");
list($Count) = $DbLink->next_record();
$DbLink->clean_results();

if ($Count != "0")
{
	$IsCommand = true;
	$Save_URL_Query = isset($Ign) ? "&Ign=".urlencode(stripslashes($Ign)) : "";
	if (C_SAVE != "*" && ($Cmd[2] > C_SAVE || $Cmd[2] == "")) $Cmd[2] = C_SAVE;
	if ($Cmd[2] != "") $Save_URL_Query .= "&Limit=$Cmd[2]";

	// Define a table that contains JavaScript instructions to be ran
	$jsTbl = array(
		"<SCRIPT TYPE=\"text/javascript\" LANGUAGE=\"JavaScript\">",
		"<!--",
		"// Save messages to a file",
		"window.open(\"export.php3?L=$L&U=".urlencode(stripslashes($U))."&R=".urlencode(stripslashes($R))."&ST=$ST".$Save_URL_Query."\",\"save_popup\",\"width=0,height=0,scrollbars=no,resizable=no\");",
		"// -->",
		"</SCRIPT>"
	);
}
else
{
	$Error = L_NO_SAVE;
};

?>