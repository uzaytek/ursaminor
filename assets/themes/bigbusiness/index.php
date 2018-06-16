<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<!--
Design by Free CSS Templates
http://www.freecsstemplates.org
Released for free under a Creative Commons Attribution 3.0 License

Name       : Big Business
Description: A two-column, fixed-width design with a bright color scheme.
Version    : 1.0
Released   : 20120210
-->
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta name="description" content="<?php theme_description(); ?>" />
<meta name="keywords" content="<?php theme_keywords(); ?>" />
<meta name="generator" content="<?php meta_generator() ?>" />
<title><?php theme_title(); ?></title>
<meta http-equiv="content-type" content="text/html; charset=utf-8" />
<link rel="stylesheet" type="text/css" href="<?php theme_path();?>style.css" />
<script src="<?php echo LC_SITE;?>assets/javascripts.js"></script>
</head>
<body>
<div id="wrapper">
	<div id="header">
		<div id="logo">
   <h1><?php theme_logo();?>&nbsp;<?php theme_sitename();?></h1>
		</div>
		<div id="slogan">
   <h2><?php theme_slogan();?></h2>
		</div>
	</div>
	<div id="menu">
   <?php theme_menu();?>
   <br class="clearfix" />   
	</div>
	<div id="splash">
		<img class="pic" src="<?php theme_path();?>images/pic01.jpg" width="870" height="230" alt="" />
	</div>
	<div id="page">
		<div id="content">
			<div class="box">
   <?php echo $content;?>
			</div>
			<br class="clearfix" />
		</div>
		<div id="sidebar">
         <p><a href="admin/">Admin Panel</a></p>
			<div class="box">
   <?php theme_news_box();?>
			</div>
   <?php theme_banner('right'); ?>
			<div class="box">
   <?php theme_gallery_box();?>
			</div>
         <div id="box">
   <?php theme_langs();?>
         </div>
		</div>
		<br class="clearfix" />
	</div>
	<div id="page-bottom">
		<div id="page-bottom-content">
   <?php theme_address();?>
		</div>
		<br class="clearfix" />
	</div>
</div>
<div id="footer">
	Copyright <?php echo '&nbsp;'.date('Y').'&nbsp;';theme_sitename();?> All rights reserved. <a href="http://www.uzaytek.com/ursaminor/"><?php echo meta_generator(); ?></a> Design by <a href="http://www.freecsstemplates.org/">Free CSS Templates</a>.
</div>
<script type="text/javascript">

  var _gaq = _gaq || [];
  _gaq.push(['_setAccount', 'UA-1008429-1']);
  _gaq.push(['_trackPageview']);

  (function() {
    var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
    ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
    var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
  })();

</script>
</body>
</html>