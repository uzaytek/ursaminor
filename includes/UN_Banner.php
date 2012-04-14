<?php

/**
 * Banner table dao object 
 * 
 */  
class UN_Banner extends UN_Dao
{

  /**
   * Pear Quickform ojbect
   * 
   * @var object
   */  
  public $form;

  /**
   * Construct banner
   * 
   */  
  public function __construct()
  {
    parent::__construct(array('table'=> DB_TBL_BANNERS, 'pk'=>'fileid','seq'=>'_nid_seq'),
                        array('fileid','filename','origname','location','url',
                              'isonline','isdeleted',
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
   * Fill the banner form
   * 
   */
  public function fillForm() {
    
    // set form defaults, $defaults array will be used after update/insert process
    $defaults = $this->defaults();
    $this->form->setDefaults($defaults);
    
    // add hidden element to session for controller purpose
    if ($this->fileid > 0) {
      $this->form->addElement('hidden', 'id', $this->fileid);
    }
    
    if (isset($_REQUEST['currentpage'])) {
      $this->form->addElement('hidden', 'currentpage', intval($_REQUEST['currentpage']));
    }
    
    $this->form->addElement('file', 'bannerfile', _('File'), array('size'=>51));
    $this->form->addRule('bannerfile', 
                         sprintf(_('Maximum file size is: %d KB'), fmtKB($GLOBALS['_conf']['HTML_MAX_FILE_SIZE'])), 
                         'maxfilesize', $GLOBALS['_conf']['HTML_MAX_FILE_SIZE']);
    $this->form->addRule('bannerfile', _('File extension required in types:'),
                         'mimetype', $GLOBALS['_conf']['HTML_PERMIT_TYPES']);
    // Tell well-behaved browsers not to allow upload of a file larger than max file size
    $this->form->setMaxFileSize($GLOBALS['_conf']['HTML_MAX_FILE_SIZE']);
    
    // select of banner location
    $this->form->addElement('select', 'location', _('Banner Location'), $this->getLocations());
    
    $this->form->addElement('text', 'url', _('Url')); 
    $this->form->addRule('url', _('Url must be filled!'), 'required', null, 'client');
    
    $this->form->addElement('submit', 'sb', _('Save'));
  }

  /**
   * Return locations of banner
   *
   * @return array Banner locations 
   */
  public static function getLocations() {
    $out = array(
                 'top' =>  _('top banner (max 468 x 60)'),
                 'left' => _('left banner (max 180 x 150)'),
                 'right' => _('right banner (max 160 x 600)'),
                 );
    return $out;
  }

  /**
   * Set banner values
   *
   * @param array $values The form values filled by panel user
   * @path string $path Banner upload path
   * @return boolean true if successfull, an error die
   */  
  public function setValues(&$values, $path) {
    //uploaded banner file and create thumbnail
    $file =& $this->form->getElement('bannerfile');
    if ($file->isUploadedFile()) {
      $aFile = $file->getValue();
      $file_ext = getExtension($aFile['name']);
      do {
        $newname = genRandStr(32).$file_ext;
      } while (file_exists($path . $newname));
      
      // move file
      if ($file->moveUploadedFile($path, $newname)) {
        $this->filename = $newname;
        $this->origname = filter_var($aFile['name']);
      } else {
        // move upload failed
        UN_Say::add(fmtError(_('Upload error: banner upload failed')));
        return false;
      }
    } // end is uploaded file
    $this->location = filter_var($values['location']);
    $this->url      = filter_var($values['url']);    
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

}

?>
