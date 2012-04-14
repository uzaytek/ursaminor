<?php
include 'init.php';

$news = new UN_News();
$newsid = (isset($_REQUEST['id'])) ? intval($_REQUEST['id']) : 0;

// delete
if (isset($_POST['go'])) {
  if (strstr($_POST['go'], 'delete_news') && isset($newsid)) {
    $bupdate = $news->load($newsid);
    if($bupdate) {        
      $result = $news->isupdate('isdeleted=1', $newsid);
      if ($result) {
        UN_Say::add(fmtSuccess(_('News deleted successfuly')));
        $newsid=0;// dont load deleted news
      }
    }
  }
}

$news = new UN_News();
$defaults = $news->defaults();
$news->registerForm('register');

$bupdate = false;
if ($newsid) {
  $bupdate = $news->load($newsid);
}

// fill form with elements
$news->fillForm();

$output = '';
if ($news->form->isSubmitted() && $news->form->validate()) {
  
  $values =& $news->form->exportValues();
  $news->setValues($values);
  
  if (isset($bupdate) && $bupdate==true) {
    $res = $news->update($newsid);
    if ($res) {
      UN_Say::add(fmtSuccess(_('News modified successfuly')));
    } else {
      UN_Say::add(fmtError(_('Database error: news update failed')));
    }
  } else {
    $res = $news->insert($newsid);
    if ($res) {
      UN_Say::add(fmtSuccess(_('News inserted successfuly')));  
      $news->form->resetDefaults($defaults);
    } else {
      UN_Say::add(fmtError(_('Database error: news insert failed')));
    }
  }
}

$output .= $news->form->toHtml();

$news->setOrder('dtcreated DESC');
$res = $news->pager($pager, $numrows);

if ($res) {
  $output .= "<br />";
  
  $inline_form = new UN_SelectForm(array('news.php'                =>_('Modify'), 
                                         'news.php#delete_news'    =>_('Delete')));
  $t = new UN_Table($inline_form);
  $t->title(array(_('News Title'), _('News Content'), _('Language')));
  $lang = new UN_Language();
  list($aLang,) = $lang->getLangTexts();   
  
  while($row = $res->fetch()) {
    $t->tr(array($row['newstitle'], truncate(clearCodes($row['newsdetail'])), $aLang[$row['langid']]),
           $row['newsid']);
  }
  $t->addRow($pager->display()._('Total News Count:') . $numrows);
  $output .= $t->display();
}

include 'theme.php';

?>