<?php

/**
 * Theme functions 
 * 
 */  

/**
 * Get selected theme
 * 
 * @param string $content Web Site Main Content
 */  
function theme(&$content) {
  global $theme;
  $t = PT_THEME . $theme->theme . '/index.php';
  if(file_exists($t)){
    include $t;
  }
}

/**
 * Get selected theme
 * 
 */  
function theme_popup() {
  global $theme;
  $t = PT_THEME . $theme->theme . '/popup.php';
  if(file_exists($t)){
    include $t;
  }
}


/**
 * Echo meta description
 * 
 */  
function theme_description() {
  global $theme;
  echo $theme->description;
}

/**
 * Echo meta keywords
 * 
 */  
function theme_keywords() {
  global $theme;
  echo $theme->keywords;
}

/**
 * Echo site title
 * 
 */  
function theme_title() {
  global $theme;
  echo $theme->title;
}

/**
 * Echo site logo
 * 
 */  
function theme_logo() {
  global $theme;
  echo '<img src="'.LC_UPLOAD . $theme->logo.'">';
}

/**
 * Echo site slogan
 * 
 */  
function theme_slogan() {
  global $theme;
  echo $theme->slogan;
}

/**
 * Echo welcome text
 * 
 */  
function theme_welcome() {
  global $theme;
  return $theme->welcome;
}

/**
 * Echo gallery box
 * 
 */  
function theme_gallery_box() {
  $gallery = new UN_Gallery();

  $pagerOptions = array('perPage' => 1);
  $res = $gallery->pager($pager, $numrows, $pagerOptions);  
  $output = '';  
  if ($res) {
    $output .= '<h2>'._('Last Picture').'</h2>';
    while($row = $res->fetch()) {

      $url = 'popup.php?t=image&amp;id='.$row['imgid'].theme_global_url();
      $output .= '<a href="'.$url.'"'.
          ' target="_blank" onClick="openWindow(\''.$url.'\');return false"><img alt="'.$row['origname'] .'" '.
          ' src="'. LC_UPLOAD . 'thumb_'. $row['filename'].'" border="0" /></a></p>';            
    }
    $output .= '<p><a href="index.php?t=categories'.theme_global_url().'">'._('All Gallery').'</a></p>';
    echo $output;
  }  
}

/**
 * Echo banner in the selected location
 * 
 */  
function theme_banner($location) {
  $banner    = new UN_Banner();
  $banner->setWhere(' (isdeleted=0 OR isdeleted IS NULL) AND location='.$banner->quote(filter_var($location)));
  $aAll = $banner->getAll();
  $output = '';
  foreach($aAll as $k=>$f) {
    $output .= '<p>'.url($f['url'], '<img alt="'.$f['origname'] . '" border="0" src="'. LC_UPLOAD . $f['filename'].'"/>').'</p>';            
  }
  echo $output;
}


/**
 * Echo news box
 * 
 */  
function theme_news_box() {
  $news = new UN_News();
  $pagerOptions = array('perPage' => 5);
  $langid = (isset($_REQUEST['langid'])) ? intval($_REQUEST['langid']) : 0;
  $lang = new UN_Language;
  list($aLanguages, $defaultLanguage) = $lang->getLangTexts(); 
  $where = ($langid > 0) ? ' langid='.$langid : 'langid='.$defaultLanguage;
  $res = $news->pager($pager, $numrows, $pagerOptions, $where);
  $output = '';  
  if ($res) {
    $output .= '<h2>'._('News').'</h2>';
    while($row = $res->fetch()) {
      $output .= '<p><a href="index.php?t=news&amp;id='. $row['newsid'].theme_global_url().'">'.$row['newstitle'].'</a></p><p>' .
        truncate(clearCodes($row['newsdetail'])) .'</p>';
            
    }
    $output .= '<p><a href="index.php?t=news'.theme_global_url().'">'._('All News').'</a></p>';
    echo $output;
  }  
}

/**
 * Echo site address
 * 
 */  
function theme_address() {
  global $theme;
  echo $theme->address;
}

/**
 * Echo site name
 * 
 */  
function theme_sitename() {
  global $theme;
  echo $theme->sitename;
}

/**
 * Echo theme path
 * 
 */  
function theme_path() {
  global $theme;
  echo LC_THEME.$theme->theme.'/';
}

/**
 * Echo theme content according to selected type and id
 * 
 * @param string $type Content type
 */  
function theme_content($type) {
  global $theme;

  $id = (isset($_REQUEST['id'])) ? intval($_REQUEST['id']) : 0;
  $type = filter_var($type);
  $output = '';

  switch ($type) {

  case 'image'; // gallery image
  $image = new UN_Gallery();
  $bload = $image->load($id);
  if ($bload) {
    $output .= '<img alt="'.$image->origname . '" src="'. LC_UPLOAD . $image->filename.'"/>';            
  }
  break;

  case 'gallery': // gallery thumbnails
    $gallery = new UN_Gallery();
    $where = ' a.catid = '. $id;
    $res = $gallery->pager($pager, $numrows, null, $where);

    if ($res) {
      $output .= '<p>';
      while($row = $res->fetch()) {
        $url = 'popup.php?t=image&amp;id='.$row['imgid'].theme_global_url();
        $output .= '<a href="'.$url.'"'.
          ' target="_blank" onClick="openWindow(\''.$url.'\');return false"><img alt="'.$row['origname'] .
          '" src="'. LC_UPLOAD . 'thumb_'. $row['filename'].'" border="0" vspace="6" hspace="6"/></a>';            
      } 
      $output .= '</p>';
    }
    $output .= $pager->display();
    break;

  case 'categories': // gallery categories
    $cat = new UN_GalleryCat();
    $aCats = $cat->getGalleryCats();
    $aTranslations = array();
    $langid = 0;
    if(isset($_REQUEST['langid'])) {
      $langid = (int)$_REQUEST['langid'];
      $tr = new UN_Translate();
      $aTranslations = $tr->getAllTexts($langid);
    }
    foreach($aCats as $catid=>$cattitle) {
      $cattitle = ($langid > 0 && isset($aTranslations[$catid]['gallerycat'])) ? 
        $aTranslations[$catid]['gallerycat'] :
        $cattitle;
      $output .= '<p><a href="index.php?t=gallery&amp;id='. $catid . theme_global_url(). '"> ' . $cattitle . '</a></p>';
    }
    break;
  case 'page':// content
    $page = new UN_Content();
    $bload = $page->load($id);    
    if ($bload) {
      $output .= '<h2 id="title">'.$page->pagetitle.'</h2>'.$page->pagedetail;
    }
    break;
  case 'news':// news
    $news = new UN_News();
    if ($id > 0) { // load specific news
      $bload = $news->load($id);    
      if ($bload) {
        $output .= '<h2 id="title">'.$news->newstitle.'</h2>'.$news->newsdetail;
      }
    } else {
      // load all news with paginate
      $langid = (isset($_REQUEST['langid'])) ? intval($_REQUEST['langid']) : 0;
      $where = ($langid > 0) ? ' langid='.$langid : '';
      $res = $news->pager($pager, $numrows, null, $where);  
      if ($res) {
        $output .= '<h2 id="title">'._('News').'</h2>';
        while($row = $res->fetch()) {
          $output .= '<p><a href="index.php?t=news&amp;id='. 
            $row['newsid'].theme_global_url().'">'.$row['newstitle'].'</a></p><p>' .
            truncate(clearCodes($row['newsdetail']),400) .'</p>';            
        }
        $output .= $pager->display();
      }// end res
    } // end else
    break;
  }
  return $output;
}


/**
 * Print available languages
 *
 */
function theme_langs() {
  $lang = new UN_Language;
  $langid = (isset($_REQUEST['langid'])) ? intval($_REQUEST['langid']) : 0;
  echo $lang->selectLanguageForm($langid);
}

/**
 * Print available language flags
 *
 */
function theme_flags() {
  global $theme;
  $lang = new UN_Language;
  $lang->setWhere('(isdeleted=0 OR isdeleted IS NULL)');
  $rows = $lang->getAll();
  $out = '';
  if (is_array($rows)) {      
    foreach($rows as $row) {
      $out .= '<a href="?langid='.$row['langid'].'" border="0" title="'.$row['langtext'].'">'.
        '<img src="'.LC_THEME.$theme->theme.'/img/'.$row['langflag'].'" alt="'.$row['langtext'].'" hspace="2" /></a>&nbsp;';
    }
  }
  echo $out;
}


/**
 * Print web site menu
 *
 */
function theme_menu() {
  global $theme;
  $content = new UN_Content();
  $cAll = $content->getMenuContent($theme->langid);
  if (is_array($cAll)) {
    $out = '<ul>';
    if ($theme->indexlink == 1) {
      $out .= '<li><a href="index.php'.theme_global_url(true).'"><span>'._('Main Page').'</span></a></li>';
    }
    foreach($cAll as $c) {
      $link  = ($c['pagelink']!="") ? $c['pagelink'] : 'index.php?t=page&amp;id='.$c['pageid'];
      $title = ($c['pagelink']!="") ? $c['pagedetail'] : $c['pagetitle'];
      $out .= '<li><a href="'.$link.theme_global_url().'" title="'.strip_tags($title).'"><span>'.$c['pagetitle'].'</span></a></li>';
    }
    $out .= '</ul>';
  }
  echo $out;
}

/**
 * Add global parameters to url
 *
 * @param boolean $bQuestion If true add question mark to url
 * @return string url parameters
 */
function theme_global_url($bQuestion=false) {
  global $theme;
  $langid = (isset($_REQUEST['langid'])) ? intval($_REQUEST['langid']) : 0;
  $out = '';
  if ($bQuestion) {
    $out .= '?';
  }
  if ($langid > 0) {
    $out .= '&amp;langid=' . $langid;
  }
  return $out;
}

?>