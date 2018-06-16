<?php

include 'init.php';

$fileid = (isset($_REQUEST['id'])) ? filter_var($_REQUEST['id']) : 0;

$banner    = new UN_Banner();

if (isset($_POST['go'])) {
  // delete  
  if (strstr($_POST['go'], 'delete_banner') && isset($fileid)) {
    $bupdate = $banner->load($fileid);
    if($bupdate) {        
      $result = $banner->isupdate('isdeleted=1', $fileid);
      if ($result) {
        UN_Say::add(fmtSuccess(_('File deleted successfuly')));
        $fileid=0; // dont load delete file again
      }
    }
  }//delete_banner
}

$banner->registerForm();

$bupdate = false;
if ($fileid) {
  $bupdate = $banner->load($fileid);
}

// fill form with elements
$banner->fillHTMLBannerForm();
$output = '<a href="advert-file.php">'._('Local Banner').'</a>&nbsp;&nbsp;<a href="advert-code.php">'._('HTML Banner').'</a>';

// process forms
if ($banner->form->isSubmitted() && $banner->form->validate()) {

  $values =& $banner->form->exportValues();
  $banner->setValues($values, PT_UPLOAD);

  if (isset($bupdate) && $bupdate==true) {
    $res = $banner->update($fileid);
    if ($res) {
      UN_Say::add(fmtSuccess(_('Banner modified successfuly')));
    } else {
      UN_Say::add(fmtError(_('Database error: banner update failed')));
    }
  } else {
    $res = $banner->insert($fileid);
    if ($res) {
      UN_Say::add(fmtSuccess(_('Banner inserted successfuly')));  
      $banner->form->resetDefaults($defaults);
    } else {
      UN_Say::add(fmtError(_('Database error: banner insert failed')));
    }
  }
}

$output .= $banner->form->toHtml();
$res = $banner->pager($pager, $numrows);

if ($res) {
  $output .= "<br />";
  
  $inline_form = new UN_SelectForm(array('advert-code.php'                  => _('Modify'), 
                                         'advert-code.php#delete_banner'    => _('Delete')));
  $t = new UN_Table($inline_form);
  $t->title(array(_('Name'), _('Location'), _('HTML'), _('Create Date')));
  $aLocation = $banner->getLocations();
  while($row = $res->fetch()) {
    $t->tr(array($row['origname'], $aLocation[$row['location']], $row['url'], $banner->getDate('o', $row['dtcreated'])),
           $row['fileid']);
  }
  $t->addRow($pager->display()._('Total File Count:').$numrows);
  $output .= $t->display();
}  

include 'theme.php';

?>