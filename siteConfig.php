<?php
/**  
 * @author David Curras
 * @version		June 10 2011
 */

// Report all errors
error_reporting(E_ALL);
ini_set('error_reporting',E_ALL);
ini_set('display_errors', 'On');
ini_set('display_startup_errors', 'On');

ini_set("memory_limit","256M");
define('DIR_SEPARATOR', '/');
$rootFolder = str_replace('\\', DIR_SEPARATOR, dirname(__FILE__) . DIR_SEPARATOR);
define('ROOT_FOLDER', $rootFolder);

// Set include paths
set_include_path(dirname(__FILE__) . DIR_SEPARATOR);

// Just in case it hasn't been specified in the PHP ini: 86400 = 24 hours in seconds
ini_set('max_execution_time', 86400);

// Database configuration
define('MYSQL_HOST', 'localhost');
define('MYSQL_USER', 'root');
define('MYSQL_PASS', '');
define('MYSQL_DB', 'xmle_dev');

date_default_timezone_set('America/Argentina/Buenos_Aires');

// Server info
define('LOCAL_HARD_DISK', '/dev/sda1');

//Partner names
define('FCS', 'fcs');
define('ITUNES', 'itunes');
define('SONY', 'sony');
define('STARHUB', 'starhub');
define('XBOX', 'xbox');

//Process types
define('MERGE_PROCESS_ID', '1');
define('CONVERSION_PROCESS_ID', '2');
define('TRANSPORTATION_PROCESS_ID', '3');
define('IMPORTATION_PROCESS_ID', '4');

//Process states
define('NON_STARTED', '1');
define('STARTED', '2');
define('INCOMPLETE', '3');
define('SUCCESS', '4');
define('FAILED', '5');

//Folders
define('LOCAL_INBOX', ROOT_FOLDER . 'inbox/');
define('LOCAL_OUTBOX', ROOT_FOLDER . 'outbox/');
define('LOCAL_RENAME', ROOT_FOLDER . 'rename/');
define('LOCAL_INBOX_MERGE', ROOT_FOLDER . 'inbox/merge/');
define('LOCAL_OUTBOX_MERGE', ROOT_FOLDER . 'outbox/merge/');
define('LOCAL_RENAME_MERGE', ROOT_FOLDER . 'rename/merge/');
define('LOCAL_INBOX_CONVERSION', ROOT_FOLDER . 'inbox/conversion/');
define('LOCAL_OUTBOX_CONVERSION', ROOT_FOLDER . 'inbox/transportation/');
define('LOCAL_RENAME_CONVERSION', ROOT_FOLDER . 'rename/transportation/');
define('LOCAL_INBOX_TRANSPORTATION', ROOT_FOLDER . 'inbox/transportation/');
define('LOCAL_OUTBOX_TRANSPORTATION', ROOT_FOLDER . 'outbox/transportation/');
define('LOCAL_RENAME_TRANSPORTATION', ROOT_FOLDER . 'rename/transportation/');
define('LOCAL_INBOX_IMPORTATION', ROOT_FOLDER . 'inbox/importation/');
define('LOCAL_OUTBOX_IMPORTATION', ROOT_FOLDER . 'outbox/importation/');
define('LOCAL_RENAME_IMPORTATION', ROOT_FOLDER . 'rename/importation/');
define('LOGS', ROOT_FOLDER . '/logs/');

//File extensions
$VideoFileExtensions = array('mp4','avi','mpg','mpeg', 'mov');
define('VIDEO_FILE_EXTENSIONS', serialize($VideoFileExtensions));

//Valid Networks
$networs = array('BET', 'COMEDY', 'COMEDYCENTRAL', 'GAMEONEFRANCE', 'MTV', 'MTVFRANCE', 'MTVGERMANY', 'MTVNETWORK', 'MTVUK', 'NICK', 'NICKELODEON', 'NICKFRANCE', 'NICKJR', 'WEBISODE');
define('VALID_NETWORKS', serialize($networs));

//Chars to remove from fcs xml fields
$charsToRemove = array('.', ' ', '-', '_', '(', ')');
define('CHARS_TO_REMOVE', serialize($charsToRemove));

// Remote server configuration
define('REMOTE_SERVER_IP', '166.77.22.27');
define('REMOTE_SERVER_USER', 'fcsvradmin');
define('REMOTE_SERVER_PASS', 'unicornbacon');
define('REMOTE_INBOX', '/Volumes/VoigtKampff/DTO/XmlEngine_Assets/inbox/');
define('REMOTE_OUTBOX', '/Volumes/VoigtKampff/DTO/XmlEngine_Assets/outbox/');