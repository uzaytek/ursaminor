<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta name="description" content="<?php theme_description(); ?>" />
<meta name="keywords" content="<?php theme_keywords(); ?>" />
<meta name="generator" content="<?php meta_generator() ?>" />
<title><?php theme_title(); ?></title>
<meta http-equiv="content-type" content="text/html; charset=utf-8" />
<link rel="stylesheet" type="text/css" href="<?php theme_path();?>style.css" />
</head>
<body>
<div id="container">
	<div id="header">
		<h1>
   <?php theme_logo();?>  <?php theme_sitename();?>, <?php theme_slogan();?>   
		</h1>
   <div id="langselect">
   <?php theme_langs();?>
   </div>
	</div>
	<div id="navigation">
   <?php theme_menu();?>
	</div>
	<div id="content-container">
		<div id="section-navigation">
   <?php theme_news_box();?>
   <?php theme_gallery_box();?>
   <?php theme_banner('left'); ?>
		</div>
		<div id="content">
   <?php theme_banner('top'); ?>
   <?php echo $content;?>
		</div>
		<div id="aside">
   <?php theme_banner('right'); ?>
		</div>
		<div id="footer">
   &copy; Copyright <?php echo '&nbsp;'.date('Y').'&nbsp;';theme_sitename();?> 
   <p><?php theme_address();?></p>
		</div>
	</div>
</div>
</body>
</html>