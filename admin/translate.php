<?php

include 'init.php';


$id = (isset($_REQUEST['id'])) ? intval($_REQUEST['id']) : 0;

// delete
if (isset($_POST['go'])) {
  if (strstr($_POST['go'], 'gallerycat')) {
    $cat = new UN_GalleryCat();
    $cat->load($id);
    $trText = $cat->cattitle;
    $type = 'gallerycat';
  }
}

$tr = new UN_Translate();

$bupdate = false;
if ($id) {
  $bupdate = $tr->load($id, $type);
}


$tr->registerForm('register');

// fill form with elements
$tr->fillForm($id, $type, $trText);

$output = '';
if ($tr->form->isSubmitted() && $tr->form->validate()) {
  
  $values =& $tr->form->exportValues();
  $res = $tr->insert($values);
  if ($res) {
    UN_Say::add(fmtSuccess(_('Translations inserted successfuly')));  
  } else {
    UN_Say::add(fmtError(_('Database error: translations insert failed')));
  }
} else {
  $output .= $tr->form->toHtml();
}

include 'theme.php';


?>