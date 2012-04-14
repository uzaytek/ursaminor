<?php

/**
 * Gallery table dao object 
 * 
 */  
class UN_Gallery extends UN_Dao
{

  /**
   * Pear Quickform ojbect
   * 
   * @var object
   */  
  public $form;

  /**
   * Construct gallery
   * 
   */  
  public function __construct()
  {
    parent::__construct(array('table'=> DB_TBL_GALLERY, 'pk'=>'imgid','seq'=>'_nid_seq'),
                        array('imgid','catid','filename','origname','imgwh',
                              'isdeleted',
                              'dtcreated')
                        );
  }
  

  /**
   * Register quickform object
   * 
   * @param string $formName The html form name 
   */
  public function registerForm($formName='register') {
    //$formName, $method='post', $action='', $target='', $attr=null,
    $this->form     = new UN_QuickForm($formName, 'post');
  }


  /**
   * Fill the gallery form
   * 
   */
  public function fillForm() {

    // set form defaults, $defaults array will be used after update/insert process
    $defaults = $this->defaults();
    $this->form->setDefaults($defaults);

    // add hidden element to session for controller purpose
    if ($this->imgid > 0) {
      $this->form->addElement('hidden', 'id', $this->imgid);
    }

    if (isset($_REQUEST['currentpage'])) {
      $this->form->addElement('hidden', 'currentpage', intval($_REQUEST['currentpage']));
    }

    $this->form->addElement('file', 'galleryfile', _('File'), array('size'=>51));
    $this->form->addRule('galleryfile', 
                         sprintf(_('Maximum file size is: %d KB'), fmtKB($GLOBALS['_conf']['HTML_MAX_FILE_SIZE'])), 
                         'maxfilesize', $GLOBALS['_conf']['HTML_MAX_FILE_SIZE']);
    $this->form->addRule('galleryfile', _('File extension required in types:'),
                         'mimetype', $GLOBALS['_conf']['HTML_PERMIT_TYPES']);
    // Tell well-behaved browsers not to allow upload of a file larger than max file size
    $this->form->setMaxFileSize($GLOBALS['_conf']['HTML_MAX_FILE_SIZE']);
    
    // gallery categories
    $cat = new UN_GalleryCat();
    $aCats = $cat->getGalleryCats();
    if (is_array($aCats) && count($aCats)) {
      $this->form->addElement('select', 'catid', _('Category'), $aCats);
    } else {
      $this->form->addElement('static', 'catid', _('Category'), _('Please create gallery category!'));      
    }
    $this->form->addRule('catid',_('Gallery category is a required field'), 'required', null, 'client');


    $this->form->addElement('submit', 'sb', _('Save'));
 }


  /**
   * Set gallery values
   * 
   * @param array $values The form values filled by panel user
   * @path string $path Gallery upload path
   * @return boolean true if successfull, an error die
   */  
  public function setValues(&$values, $path) {
    //uploaded logo file and create thumbnail
    $file =& $this->form->getElement('galleryfile');
    if ($file->isUploadedFile()) {
      $aFile = $file->getValue();
      $file_ext = getExtension($aFile['name']);
      do {
        $newname = genRandStr(32).$file_ext;
      } while (file_exists($path . $newname));

      // move file
      if ($file->moveUploadedFile($path, $newname)) {
        $this->filename  = $newname;
        $this->origname  = filter_var($aFile['name']);
        $this->imgwh     = $this->imgwh($path.$this->filename);
        $thumb = new UN_Thumbnail($this->filename);
        $thumb->save();
      } else {
        // move upload failed
        UN_Say::add(fmtError(_('Upload error: Image upload failed')));
        return false;
      }
    } // end is uploaded file
    $this->catid = intval($values['catid']);
    return true;
  }

  /**
   * Insert values to db
   * 
   * @param integer $theid The database row id
   */  
  public function insert(&$theid) {
    $this->dtcreated  = $this->getDate('il');
    $this->isdeleted  = 0;
    return parent::insert($theid);
  }

  /**
   * Return image file width,height informations
   *
   * @param string $addr The file physical address
   * @return string width,height information
   */
  private function imgwh($addr) {
    $tmp = getimagesize($addr);
    if ($tmp != false && is_array($tmp)) {
      return $tmp[0].",".$tmp[1];
    }
  }
  
}

?>
