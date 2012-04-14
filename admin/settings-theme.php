<?php

include 'init.php';
$output = '';

$lang = new UN_Language();
$langid = (isset($_REQUEST['langid'])) ? intval($_REQUEST['langid']) : 0;

if ($langid == 0) {
  $output .= $lang->selectLanguageForm();
} else {
  $setup = new UN_Settings();
  $setup->load($langid);

  $setup->registerForm('setup');


  // fill form with elements
  $setup->fillForm();

  // process forms if posted
  if ($setup->form->isSubmitted() && $setup->form->validate()) {
    $values =& $setup->form->exportValues();
    $setup->setValues($values);
  
    if($setup->globalid > 0) {
      $res = $setup->update();
      if ($res) {
        UN_Say::add(fmtSuccess(_('Settings updated successfuly')));
      } else {
        UN_Say::add(fmtError(_('Database error: settings update failed')));
      }
    } else {
      $res = $setup->insert();
      if ($res) {
        UN_Say::add(fmtSuccess(_('Settings inserted successfuly')));  
      } else {
        UN_Say::add(fmtError(_('Database error: settings insert failed')));
      }
    }
  } //end post process
  $output .= $setup->form->toHtml();
} // end else lang


include 'theme.php';

?>