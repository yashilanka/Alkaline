<?php

//
// MODIFY THE DEFINITIONS BELOW
//

// Server type
$server_type = '';

// Folder base
$folder_base = '';

// Database data source name (DSN including protocol)
$db_dsn = 'mysql:host=localhost;dbname=alkaline';

// Database type (DSN protocol)
$db_type = 'mysql';

// Database user username (leave empty for SQLite)
$db_user = 'alkaline';

// Database user password (leave empty for SQLite)
$db_pass = 'm902j2JK91kaO';

// Database table prefix
$table_prefix = '';

// Alkaline subdirectory prefix
$folder_prefix = '';

// URL rewriting (supports Apache mod_rewrite, Microsoft URL Rewrite 2, and compatible)
$url_rewrite = false;


//
// DO NOT MODIFY BELOW THIS LINE
//

// Valid extensions, separate by |
$img_ext = 'gif|GIF|jpg|JPG|jpeg|JPEG|png|PNG';

// Length, an integer in seconds, to remember a user's previous login
$user_remember = 1209600;

// Template extension
$temp_ext = '.html';

// Default query limit (can be overwritten)
$limit = 20;

// Date formatting
$date_format = 'M j, Y \a\t g:i a';

// Palette size
$palette_size = 8;

// Color tolerance (higher numbers varies colors more)
$color_tolerance = 60;


if($url_rewrite){
	define('URL_CAP', '/');
	define('URL_ID', '/');
	define('URL_ACT', '/');
	define('URL_AID', '/');
	define('URL_RW', '/');
}
else{
	define('URL_CAP', '.php');
	define('URL_ID', '.php?id=');
	define('URL_ACT', '.php?act=');
	define('URL_AID', '&id=');
	define('URL_RW', '');
}

if($server_type == 'win'){
	define('PATH', $_SERVER['DOCUMENT_ROOT'] . '\\');
}
else{
	define('PATH', $_SERVER['DOCUMENT_ROOT'] . '/');
}

define('BASE', '/' . $folder_base);
define('DOMAIN', $_SERVER['SERVER_NAME']);
define('LOCATION', 'http://' . DOMAIN);

define('SERVER_TYPE', $server_type);
define('DB_DSN', $db_dsn);
define('DB_TYPE', $db_type);
@define('DB_USER', $db_user);
@define('DB_PASS', $db_pass);
define('TABLE_PREFIX', $table_prefix);
define('FOLDER_PREFIX', $folder_prefix);
define('IMG_EXT', $img_ext);
define('USER_REMEMBER', $user_remember);
define('TEMP_EXT', $temp_ext);
define('LIMIT', $limit);
define('DATE_FORMAT', $date_format);
define('PALETTE_SIZE', $palette_size);
define('COLOR_TOLERANCE', $color_tolerance);

define('ADMIN', FOLDER_PREFIX . 'admin/');
define('BLOCKS', FOLDER_PREFIX . 'blocks/');
define('CLASSES', FOLDER_PREFIX . 'classes/');
define('CSS', FOLDER_PREFIX . 'css/');
define('EXTENSIONS', FOLDER_PREFIX . 'extensions/');
define('FUNCTIONS', FOLDER_PREFIX . 'functions/');
define('JS', FOLDER_PREFIX . 'js/');
define('IMAGES', FOLDER_PREFIX . 'images/');
define('INSTALL', FOLDER_PREFIX . 'install/');
define('PHOTOS', FOLDER_PREFIX . 'photos/');
define('SHOEBOX', FOLDER_PREFIX . 'shoebox/');
define('THEMES', FOLDER_PREFIX . 'themes/');

?>