<?php

// Report all PHP errors except deprecated
error_reporting(E_ALL & ~E_DEPRECATED);
ini_set('display_errors','On'); 

if(!defined('ENVIRONMENT')) {
  define('ENVIRONMENT', 'PRODUCTION');//'DEVELOPMENT');
}


/* ---[ PROJECT ]------------------------------- */
define('UN_VERSION',         '0.2');
define('UN_PROJECT_NAME',    'Ursaminor');
define('UN_SESSION_NAME',    'Ursaminor');

/* ---[ PATH & URL VARIABLES; prefix PT:path,LC:locations ]------------------------------- */
define('PT_PROJECT', '/ursaminor'); // project path
define('PHP_SELF', basename(filter_var($_SERVER['PHP_SELF'])));
define('PT_SITE', '/var/www/ursaminor/');

if (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] == 'on') {
  define('LC_SITE', 'https://' . $_SERVER['SERVER_NAME'] . PT_PROJECT . '/');
} else {
  define('LC_SITE', 'http://' . $_SERVER['SERVER_NAME']. PT_PROJECT. '/');
}

define('LC_SSITE',     'http://' . $_SERVER['SERVER_NAME'] . PT_PROJECT . '/');
define('PT_ADMIN',     PT_SITE . 'admin/');
define('LC_ADMIN',     LC_SITE . 'admin/');
define('PT_INCLUDE',   PT_SITE . 'includes/');
define('LC_INCLUDE',   LC_SITE . 'includes/');
define('PT_LOCALE',    PT_SITE . 'locale/');
define('PT_THEME',     PT_SITE . 'assets/themes/');
define('LC_THEME',     LC_SITE . 'assets/themes/');

//chmod 777
define('PT_UPLOAD',    PT_SITE . 'uploads/');
define('LC_UPLOAD',    LC_SITE . 'uploads/');

/* ---[ DATABASE & EMAIL; prefix DB for database, EM for email  ]------------------------------- */
define('DB_DBASE',    'database');
define('DB_HOST',     'localhost');
define('DB_USER',     'dbuser');
define('DB_PASSWORD', 'dbpass');
define('EM_ADMIN',    'admin@');// admin email

$prefix = '';
// tables
define('DB_TBL_ADMINS',       $prefix . 'admins');
define('DB_TBL_BANNERS',      $prefix . 'banners');
define('DB_TBL_GALLERY',      $prefix . 'gallery');
define('DB_TBL_GALLERY_CATS', $prefix . 'gallerycats');
define('DB_TBL_GLOBALS',      $prefix . 'globals');
define('DB_TBL_LANGS',        $prefix . 'languages');
define('DB_TBL_LOGS',         $prefix . 'logs');
define('DB_TBL_NEWS',         $prefix . 'news');
define('DB_TBL_PAGES',        $prefix . 'pages');
define('DB_TBL_SESSIONS',     $prefix . 'sessions');
define('DB_TBL_TRANSLATES',   $prefix . 'translates');

/* ---[ FILE UPLOADS ]------------------------------- */
// max file size as 2MB, for
$_conf['HTML_MAX_FILE_SIZE'] = 2097152;

$_conf['HTML_PERMIT_TYPES'] = array('image/jpeg','image/gif','image/pjpeg','image/png','application/zip');
// 'text/plain', 'application/octet-stream','application/vnd.ms-excel'

/* ---[ INCLUDE FILES ]------------------------------- */
require_once PT_INCLUDE . 'UN_Dao.php';
require_once PT_INCLUDE . 'UN_Utils.php';
require_once PT_INCLUDE . 'UN_Theme.php';

/* ---[ SESSION ]------------------------------- */

$session =& UN_Session::instance();

/* ---[ LANGUAGE ]------------------------------- */

$langid = (isset($_REQUEST['langid'])) ? intval($_REQUEST['langid']) : 0;
$lang = new UN_Language;

$default = getDefaultLanguage(); // from browser
list($aLanguages, $defaultLanguage) = $lang->getLangTexts('browsercodes'); 
if ($langid == 0) {
  $langid = array_find($default, $aLanguages);
  if ($langid > 0) {
    $_REQUEST['langid'] = $langid;
  } else {
    $langid = $defaultLanguage;
  }
}

$lang->load($langid);

putenv("LANGUAGE=".$lang->langcode);
  
// Set the text domain as 'messages'
$domain = 'messages';
setlocale(LC_ALL, $lang->langcode);// comment for tests
bind_textdomain_codeset($domain, 'utf8');
bindtextdomain($domain, PT_LOCALE);
textdomain($domain);
  
date_default_timezone_set('Europe/Istanbul'); 

?>
