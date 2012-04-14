<?php
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html lang="tr" dir="ltr" xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
   <title><?php echo _('Admin Area'); ?></title>
<link type="text/css" rel="stylesheet" href="css/styles.css">
<!--[if IE]>
  <link rel="stylesheet" type="text/css" href="css/ie.css">
<![endif]-->
<script type="text/javascript" src="javascripts/javascripts.js"></script>
<script type="text/javascript" src="javascripts/selectbox.js"></script>
</head>
<body>
<?php

   if (!defined('DONT_PRINT_MENU')) {
     print_menu();
   }
?>
<div class='content'>
<?php
   echo UN_Say::get();

if (isset($output)) {
  echo $output;
}
?>
<div id="footer">
<?php

?>
</div>
</div>
</body>
</html>
