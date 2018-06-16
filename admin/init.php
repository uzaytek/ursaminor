<?php

define('IS_ADMIN_PANEL', TRUE);

include '../config.php';

// admin theme upper menu
$_menu_arr = array(
                   array('dashboard.php', _('Dashboard')),
                   array('content.php',   _('Content')),
                   array('news.php',      _('News')),
                   array('gallery.php',   _('Gallery')),
                   array('advert-file.php',    _('Banner')),
                   array('settings-theme.php',  _('Theme')),
                   array('settings.php',  _('Settings')),
                   array('myinfo.php',    _('Admin')),
                   array('logout.php',    _('Logout')),
                   );


define('UN_LOGIN_OK',       1);
define('UN_LOGIN_FAIL',     2);
define('UN_LOGIN_EXPIRED',  3);


if (!defined('LOGIN_START')) {
  include 'auth.php';
}


?>