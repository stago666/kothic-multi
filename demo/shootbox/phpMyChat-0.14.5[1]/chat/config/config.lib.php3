<?php

// BEWARE: '," and \ characters must be slashed in the settings bellow


// ------ THESE SETTINGS MUST BE COMPLETED ------ 

// Database settings
define("C_DB_TYPE", 'mysql');					// SQL server type ("mysql", "pgsql" or "odbc")
define("C_DB_HOST", 'localhost');				// Hostname of your MySQL server
define("C_DB_NAME", 'db_name');					// Logical database name on that server
define("C_DB_USER", 'username');				// Database user
define("C_DB_PASS", 'password');				// Database user's password
define("C_MSG_TBL", 'c_messages');				// Name of the table where messages are stored
define("C_USR_TBL", 'c_users');					// Name of the table where user names are stored
define("C_REG_TBL", 'c_reg_users'); 			// Name of the table where registered users are stored
define("C_BAN_TBL", 'c_ban_users'); 			// Name of the table where banished users are stored

// Cleaning settings for messages and usernames
define("C_MSG_DEL", '96');						// Messages are deleted when there are 'xx' hours old
define("C_USR_DEL", '4');						// Usernames are deleted when its last use is 'xx' minutes old
												//	the second setting must be greater than the maximum time
												//	authorized between messages list refresh
define("C_REG_DEL", '0');						// Registered profiles are deleted when its last use is 'xx' days old
												//	'xx' should be 0 for never 


// ------ THESE SETTINGS ALLOW TO FINE TUNE phpMyChat ------

// Proposed (default) rooms and reserved names for private rooms
$DefaultChatRooms = array('Default', 'MyRoom1', 'MyRoom2');
$DefaultPrivateRooms = array('Priv1', 'Priv2');

// Language settings
define("C_LANGUAGE", 'english');				// Default language
define("C_MULTI_LANG", '1');					// Allow multi-languages/charset ? : 0 = no, 1 = yes

// Registration of users
define("C_REQUIRE_REGISTER", '0');				// Require registration ? : 0 = no, 1 = yes
define("C_EMAIL_PASWD", '0');					// Generate a password and send it to the user by e-mail ? 0 = no, 1 = yes
												// To enable this functionaly you also have to complete the settings in
												//   the 'chat/lib/mail_validation.lib.php3' script

// Security and restrictions
define("C_SHOW_ADMIN", '0');					// Show link for admin resources at startup screen ? 0 = no, 1 = yes
define("C_SHOW_DEL_PROF", '1');					// Show link that allows users to delete their own profile ? 0 = no, 1 = yes
define("C_VERSION", '2');						// Available rooms : users can access...
												//	0 : only the first room within the public default ones
												//	1 : all the public default rooms but not create a room
												//	2 : all the rooms and create new ones
define("C_BANISH", '0');						// Enable the banishment feature and define the delay for banishment
												//  0 = disabled, any positive number = number of banishment day(s)
												//  if you want all moderators (and not only yourself) to banish users
												//  forever, set C_BANISH to 2000000 (six zero)
define("C_NO_SWEAR", '0');						// Check for swear words defined in chat/lib/swearing.lib.php3 file ?
												//  0 = no, 1 = yes
define("C_SAVE", '*');							// Max number of message that an user may export with the /save command
												//	Special values: 0 = none (disable the command), * = no limit

// Messages enhancements
define("C_USE_SMILIES", '1');					// Use graphical smilies ? : 0 = no, 1 = yes
define("C_HTML_TAGS_KEEP", 'simple');			// Keep HTML tags in messages ?
												//	"simple"	: keep bold, italic and underline tags
												//	"none"		: keep none
define("C_HTML_TAGS_SHOW", '1');				// Show discarded HTML tags ? : 0 = no, 1 = yes

// Default display settings
define("C_TMZ_OFFSET", '0');					// Timezone offset in hour between the server time and your country
define("C_MSG_ORDER", '0');						// Default order : 0 = last on top, 1 = last on bottom
define("C_MSG_NB", '20');						// Default number of messages to display
define("C_MSG_REFRESH", '10');					// Default timeout between each update
define("C_SHOW_TIMESTAMP", '1');				// Show Timsestamp before messages ? : 0 = no, 1 = yes
define("C_NOTIFY", '1');						// Show nofications of user entrance/exit as default. ? : 0 = no, 1 = yes
define("C_WELCOME", '1');						// Display a welcome message (defined inside 'chat/lib/welcome.lib.php3')
												//  at user entrance
?>