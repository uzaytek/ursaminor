<?php

include 'init.php';

$output = '<a href="languages.php">'._('Manage Languages').'</a><br /><br />';

$content = new UN_Content();
$content->registerForm('menuorder');

// fill form with elements
$content->fillMenuOrderForm();

// process forms if posted
if ($content->form->isSubmitted() && $content->form->validate()) {
  $values =& $content->form->exportValues();
  
  $res = $content->updateMenuOrder($values);
  if ($res) {
    UN_Say::add(fmtSuccess(_('Menu order updated successfuly')));
  } else {
    UN_Say::add(fmtError(_('Database error: menu order update failed')));
  }  
}

$output .= $content->form->toHtml();


$lang = new UN_Language();
$lang->registerForm('defaultlang');
// fill form with elements
$lang->fillDefaultLangForm();

// process forms if posted
if ($lang->form->isSubmitted() && $lang->form->validate()) {
  $values =& $lang->form->exportValues();  
  $langid = (int)$values['defaultLanguage'];
  $res = $lang->isupdate('isdefault=1',$langid);
  if ($res) {
    UN_Say::add(fmtSuccess(_('Default language updated successfuly')));
  } else {
    UN_Say::add(fmtError(_('Database error: default language update failed')));
  }  
}

$output .= $lang->form->toHtml();


include 'theme.php';

?>