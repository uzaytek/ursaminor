<?php

include 'init.php';

$blogout = false;
$output = '';

if ($session->ifset('auth')) {
  $blogout = $session->logout();
}

if ($blogout == true) {
  $output .= fmtSuccess(_('Session closed successfuly'));
} else {
  $output .= fmtError(_('Session close failed'));
}


define('DONT_PRINT_MENU', 1);
include 'theme.php';
exit;

?>



