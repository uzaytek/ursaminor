<?php

include 'init.php';

$page = new UN_Content();
$pageid = (isset($_REQUEST['id'])) ? intval($_REQUEST['id']) : 0;

if (isset($_POST['go'])) {
  if (strstr($_POST['go'], 'delete_page') && isset($pageid)) {
    $bupdate = $page->load($pageid);
    if($bupdate) {        
      $result = $page->isupdate('isdeleted=1', $pageid);
      if ($result) {
        UN_Say::add(fmtSuccess(_('Content deleted successfuly')));
        $pageid=0;// if $pageid>0 input form displays deleted content
      }
    }
  }
}

$page = new UN_Content();
$defaults = $page->defaults();
$page->registerForm();

$bupdate = false;
if ($pageid) {
  $bupdate = $page->load($pageid);
}

// fill form with elements
$page->fillForm();

$output = '';
if ($page->form->isSubmitted() && $page->form->validate()) {
  
  $values =& $page->form->exportValues();
  $page->setValues($values);
  if (isset($bupdate) && $bupdate==true) {
    $res = $page->update($pageid);
    if ($res) {
      UN_Say::add(fmtSuccess(_('Content modified successfuly')));
    } else {
      UN_Say::add(fmtError(_('Database error: content update failed')));
    }
  } else {
    $res = $page->insert($pageid);
    if ($res) {
      UN_Say::add(fmtSuccess(_('Content saved successfuly')));  
      $page->form->resetDefaults($defaults);
    } else {
      UN_Say::add(fmtError(_('Database error: content save faield')));
    }
  }
}

$output .= $page->form->toHtml();

$page->setOrder('langid ASC,pagetitle');
$res = $page->pager($pager, $numrows);

if ($res) {
  $output .= "<br />";
  
  $inline_form = new UN_SelectForm(array('content.php'                =>_('Modify'), 
                                         'content.php#delete_page'    =>_('Delete')));
  $t = new UN_Table($inline_form);
  $t->title(array(_('Title'), _('Content'), _('Language')));
  $lang = new UN_Language();
  list($aLang,) = $lang->getLangTexts();   
  while($row = $res->fetch()) {
    $t->tr(array($row['pagetitle'], truncate(clearCodes($row['pagedetail'])), $aLang[$row['langid']]), $row['pageid']);
  }
  $t->addRow($pager->display()._('Total Page Count:').$numrows);
  $output .= $t->display();
}

include 'theme.php';

?>