<?php
include 'init.php';

$fileid = (isset($_REQUEST['id'])) ? filter_var($_REQUEST['id']) : 0;

$gallery    = new UN_Gallery();
$defaults = $gallery->defaults();

// delete
if (isset($_POST['go'])) {
  if (strstr($_POST['go'], 'delete_image') && isset($fileid)) {
    $bupdate = $gallery->load($fileid);
    if($bupdate) {        
      $result = $gallery->isupdate('isdeleted=1', $fileid);
      if ($result) {
        UN_Say::add(fmtSuccess(_('File deleted successfuly')));
        $fileid=0; // dont load deleted file again
      }
    }
  }//delete_gallery
}

$gallery->registerForm();

$bupdate = false;

// load selected file
if ($fileid) {
  $bupdate = $gallery->load($fileid);
}

// fill form with elements
$gallery->fillForm();

$output = '<a href="gallerycat.php">'._('Manage Categories').'</a><br /><br />';

// process forms
if ($gallery->form->isSubmitted() && $gallery->form->validate()) {
  
  $values =& $gallery->form->exportValues();
  $gallery->setValues($values, PT_UPLOAD);
  
  if (isset($bupdate) && $bupdate==true) {
    $res = $gallery->update($fileid);
    if ($res) {
      UN_Say::add(fmtSuccess(_('Gallery modified successfuly')));
    } else {
      UN_Say::add(fmtError(_('Database error: gallery update failed')));
    }
  } else {
    $res = $gallery->insert($fileid);
    if ($res) {
      UN_Say::add(fmtSuccess(_('Gallery inserted successfuly')));  
      $gallery->form->resetDefaults($defaults);
    } else {
      UN_Say::add(fmtError(_('Database error: gallery insert failed')));
    }
  }
}

$output .= $gallery->form->toHtml();
$res = $gallery->pager($pager, $numrows);

if ($res) {
  $output .= "<br />";
  
  $inline_form = new UN_SelectForm(array('gallery.php'      => _('Modify'), 
                                         'gallery.php#delete_image'        => _('Delete')));
  $t = new UN_Table($inline_form);
  $t->title(array(_('Name'), _('Category'), _('Upload Date')));
  $cat = new UN_GalleryCat();
  $aCats = $cat->getGalleryCats();
  while($row = $res->fetch()) {
    $t->tr(array($row['origname'], $aCats[$row['catid']], $gallery->getDate('o', $row['dtcreated'])),
           $row['imgid']);
  }
  $t->addRow($pager->display()._('Total File Count:').$numrows);
  $output .= $t->display();
}  


include 'theme.php';

?>