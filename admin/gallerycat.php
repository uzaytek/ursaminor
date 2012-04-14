<?php

include 'init.php';

$cat = new UN_GalleryCat();
$catid = (isset($_REQUEST['id'])) ? intval($_REQUEST['id']) : 0;

// delete
if (isset($_POST['go'])) {
  if (strstr($_POST['go'], 'delete_page') && isset($catid)) {
    $bupdate = $cat->load($catid);
    if($bupdate) {        
      $result = $cat->isupdate('isdeleted=1', $catid);
      if ($result) {
        UN_Say::add(fmtSuccess(_('Category deleted successfuly')));
        $catid=0;// if $catid>0 input form displays deleted gallerycat
      }
    }
  }
}

$cat = new UN_GalleryCat();
$defaults = $cat->defaults();
$cat->registerForm('register');

$bupdate = false;
if ($catid) {
  $bupdate = $cat->load($catid);
}

// fill form with elements
$cat->fillForm();

$output = '';
if ($cat->form->isSubmitted() && $cat->form->validate()) {
  
  $values =& $cat->form->exportValues();
  $cat->setValues($values);
  
  if (isset($bupdate) && $bupdate==true) {
    $res = $cat->update($catid);
    if ($res) {
      UN_Say::add(fmtSuccess(_('Category modified successfuly')));
    } else {
      UN_Say::add(fmtError(_('Database error: Category update failed')));
    }
  } else {
    $res = $cat->insert($catid);
    if ($res) {
      UN_Say::add(fmtSuccess(_('Category saved successfuly')));  
      $cat->form->resetDefaults($defaults);
    } else {
      UN_Say::add(fmtError(_('Database error: Category save failed')));
    }
  }
}

$output .= $cat->form->toHtml();

$cat->setOrder('cattitle');

$res = $cat->pager($pager, $numrows);

if ($res) {
  $output .= "<br />";
  
  $inline_form = new UN_SelectForm(array('gallerycat.php'                =>_('Modify'), 
                                         'translate.php?t=gallerycat'    =>_('Translate'), 
                                         'gallerycat.php#delete_page'    =>_('Delete')));
  $t = new UN_Table($inline_form);
  $t->title(array(_('Category')));
  
  while($row = $res->fetch()) {
    $t->tr(array($row['cattitle'], ), $row['catid']);
  }
  $t->addRow($pager->display()._('Total Category Count:').$numrows);
  $output .= $t->display();
}


include 'theme.php';

?>