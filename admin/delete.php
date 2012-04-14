<?php

include 'init.php';

// request type variable used for process type
$type = filter_var($_REQUEST['t']);

switch ($type) {
case 'logo':
  $fileName = filter_var($_REQUEST['f']);
  if(file_exists(PT_UPLOAD.$fileName) && unlink(PT_UPLOAD.$fileName)) {
    $output = _('Logo file deleted successfully');    
  } else {
    $output = _('Logo file not found or permission denied from filesytem');    
  }
  break;
}

define('DONT_PRINT_MENU', true);
include 'theme.php';

?>
