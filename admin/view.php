<?php

include 'init.php';

$type = filter_var($_REQUEST['t']);

switch ($type) {
case 'logo':
  $fileName = filter_var($_REQUEST['f']);
  if(file_exists(PT_UPLOAD.$fileName)) {
    $output = '<p align="center"><img src="' . LC_UPLOAD . $fileName . '" /></p>';
  } else {
    $output = _('Logo file not found or permission denied from filesytem');    
  }
  break;
}


define('DONT_PRINT_MENU', true);
include 'theme.php';

?>
