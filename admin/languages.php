<?php
include 'init.php';

$lang = new UN_Language();
$langid = (isset($_REQUEST['id'])) ? intval($_REQUEST['id']) : 0;

// delete
if (isset($_POST['go'])) {
  if (strstr($_POST['go'], 'delete_lang') && isset($langid)) {
    $bupdate = $lang->load($langid);
    if($bupdate) {        
      $result = $lang->isupdate('isdeleted=1', $langid);
      if ($result) {
        UN_Say::add(fmtSuccess(_('Language deleted successfuly')));
        $langid=0;// dont load deleted lang
      }
    }
  }
}

$lang = new UN_Language();
$defaults = $lang->defaults();
$lang->registerForm('register');

$bupdate = false;
if ($langid) {
  $bupdate = $lang->load($langid);
}

// fill form with elements
$lang->fillForm();

$output = '';
if ($lang->form->isSubmitted() && $lang->form->validate()) {
  
  $values =& $lang->form->exportValues();
  $lang->setValues($values);
  
  if (isset($bupdate) && $bupdate==true) {
    $res = $lang->update($langid);
    if ($res) {
      UN_Say::add(fmtSuccess(_('Language modified successfuly')));
    } else {
      UN_Say::add(fmtError(_('Database error: language update failed')));
    }
  } else {
    $res = $lang->insert($langid);
    if ($res) {
      UN_Say::add(fmtSuccess(_('Language inserted successfuly')));  
      $lang->form->resetDefaults($defaults);
    } else {
      UN_Say::add(fmtError(_('Database error: language insert failed')));
    }
  }
}

$output .= $lang->form->toHtml();

$lang->setOrder('dtcreated DESC');
$res = $lang->pager($pager, $numrows);

if ($res) {
  $output .= "<br />";
  
  $inline_form = new UN_SelectForm(array('languages.php'                =>_('Modify'), 
                                         'languages.php#delete_lang'    =>_('Delete')));
  $t = new UN_Table($inline_form);
  $t->title(array(_('Language Code'), _('Browser Codes'), _('Language Text')));
  
  while($row = $res->fetch()) {
    $t->tr(array($row['langcode'], $row['browsercodes'], truncate(clearCodes($row['langtext']))),
           $row['langid']);
  }
  $t->addRow($pager->display()._('Total Language Count:') . $numrows);
  $output .= $t->display();
}

include 'theme.php';

?>