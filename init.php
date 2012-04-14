<?php

include 'config.php';


$theme = new UN_Settings();
$lang  = new UN_Language();
list($aLanguages, $defaultLanguageID) = $lang->getLangTexts(); 
$langid = (isset($_REQUEST['langid'])) ? intval($_REQUEST['langid']) : $defaultLanguageID;
$bThemeLoad  = $theme->load($langid);

if ($bThemeLoad != true) {
  die(_('Theme not found for selected language'));
}

?>