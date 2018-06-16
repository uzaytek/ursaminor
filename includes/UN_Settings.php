<?php

/**
 * Settings table(settings saved in global table) dao
 *
 */ 
class UN_Settings extends UN_Dao
{

  /**
   * Pear Quickform ojbect
   * 
   * @var object
   */  
  public $form;

  /**
   * Construct setting
   * 
   */  
  public function __construct() {
    parent::__construct(array('table'=> DB_TBL_GLOBALS, 'pk'=>'globalid','seq'=>'global_nid_seq'),
                        array('globalid','langid','description','keywords','logo',
                              'title','sitename','slogan','welcome','address','indexlink',
                              'theme',)
                        );
  }
  
  /**
   * Load setting object with table values
   * 
   * @param integer $langid Selected language id
   */
  public function load($langid) {
    
    try {
      if(!self::$db) $this->connect();
      $result = self::$db->query("SELECT * FROM ".DB_TBL_GLOBALS." WHERE langid=".(int)$langid.
                                 " AND tag='settings' AND tagproperty='theme'");
      $row = $result->fetch(PDO::FETCH_ASSOC); 
      $this->langid = (int)$langid;
    } catch (PDOException $e) {
      $this->fatal_error($e->getMessage());
    }
    // must be set for insert if not available
    if(is_array($row)) {
      $this->globalid = $row['globalid'];
      $aArray = unserialize($row['tagvalue']);
      if (is_array($aArray)) {
        foreach($aArray as $key=>$value) {
          $this->$key = $value;
        }
        return true;
      }
    } else {
      return false;
    }
  }
  
  /**
   * Insert values to db
   *
   */  
  public function insert(&$insertid=0) {
    try {
      if(!self::$db) $this->connect();
      $defaults = $this->defaults();
      unset($defaults['globalid']);//protect globalid saved again to serialized field
      // serialize all value for text field
      $tagvalue = serialize($defaults);
      $result = self::$db->exec('INSERT INTO ' . DB_TBL_GLOBALS .
                                ' (langid, tag, tagproperty, tagvalue) VALUES ('.
                                $this->langid.',\'settings\',\'theme\',\''.$tagvalue.'\')');
      return $result;
    } catch (PDOException $e) {
      $this->fatal_error($e->getMessage());
    }
  }

  /**
   * Update values
   *
   */  
  public function update($theid) {
    try {
      if(!self::$db) $this->connect();
      $defaults = $this->defaults();
      unset($defaults['globalid']);//protect globalid
      $tagvalue = serialize($defaults);
      $result = self::$db->exec('UPDATE ' . DB_TBL_GLOBALS .
				 ' SET tagvalue = \''.$tagvalue.'\'  WHERE globalid='.(int)$this->globalid);
      return $result;
    } catch (PDOException $e) {
      $this->fatal_error($e->getMessage());
    }
  }

  /**
   * Register quickform object
   * 
   * @param string $formName The html form name 
   */
  public function registerForm($formName) {
    //$formName, $method='post', $action='', $target='', $attr=null,
    $this->form     = new UN_QuickForm($formName, 'post');
  }

  /**
   * Fill the settings form
   * 
   */
  public function fillForm() {

    // set form defaults, $defaults array will be used after update/insert process
    $defaults = $this->defaults();
    $this->form->setDefaults($defaults);
    
    // add elements

    $this->form->addElement('hidden', 'langid');

    $this->form->addElement('text', 'sitename', _('Site Name'));

    $this->form->addElement('text', 'title', _('Site Title'));

    $this->form->addElement('text', 'keywords', _('Keywords'));

    $this->form->addElement('text', 'description', _('Description'));

    $this->form->addElement('text', 'slogan', _('Slogan Text'));

    // select of theme directory
    $this->form->addElement('select', 'theme', _('Theme'), $this->getThemeDirs());

    $this->form->addElement('file', 'logo', _('Logo'));
    $this->form->addRule('logo', 
                         sprintf(_('Maximum file size is: %d KB'), fmtKB($GLOBALS['_conf']['HTML_MAX_FILE_SIZE'])), 
                         'maxfilesize', $GLOBALS['_conf']['HTML_MAX_FILE_SIZE']);
    $this->form->addRule('logo', _('File extension required in types:'),
                         'mimetype', $GLOBALS['_conf']['HTML_PERMIT_TYPES']);
    $this->form->setMaxFileSize($GLOBALS['_conf']['HTML_MAX_FILE_SIZE']);
    $this->form->setFileTemplate('logo', $defaults['logo']);

    $this->form->addElement('textarea', 'welcome', _('Welcome Content'), ' id="welcome"');
    $this->form->setRichTextTemplate('welcome');
    //$this->form->addRule('welcome', _('Welcome content must be filled!'), 'required', null,  'client');

    $this->form->addElement('textarea', 'address', _('Address'), ' id="address"');

    $this->form->addElement('checkbox', 'indexlink', null, _('Show main page link in the web site main menu'),
                            array('class'=>'checkbox'));
    $this->form->setCheckBoxTemplate('indexlink');

    $this->form->addElement('submit', 'sb', _('Save'));
  }

  /**
   * Set setting values
   * 
   * @param array $values The form values filled by panel user
   */  
  public function setValues(&$values) {
    $this->description  = filter_var($values['description']);
    $this->keywords     = filter_var($values['keywords']);
    $this->sitename     = filter_var($values['sitename']);
    $this->title        = filter_var($values['title']);
    $this->slogan       = filter_var($values['slogan']);
    $this->welcome      = filter_var($values['welcome']);
    $this->address      = filter_var($values['address']);
    $this->theme        = filter_var($values['theme']);
    $this->indexlink    = (isset($values['indexlink'])) ? 1 : 0;

    //uploaded logo file and create thumbnail
    $file =& $this->form->getElement('logo');
    if ($file->isUploadedFile()) {
      $aFile = $file->getValue();
      $file_ext = getExtension($aFile['name']);
      do {
        $newname = genRandStr(4).$file_ext;
      } while (file_exists(PT_UPLOAD . $newname));
       // move file
      if ($file->moveUploadedFile(PT_UPLOAD, $newname)) {
        $this->logo = $newname;
      } else {
        // move upload failed
        UN_Say::add(fmtError(_('Upload error: logo upload failed')));
        return false;
      }
    } // end is uploaded file
  }// end function setValues

  /**
   * Return asset/themes/ directory names in the settings page
   * 
   */  
  function getThemeDirs() {
    $out = array();
    if (is_dir(PT_THEME)) {
      if ($handle = opendir(PT_THEME)) {
        while (false !== ($fh = readdir($handle))) {
          if ($fh != "." && $fh != ".." && is_dir(PT_THEME . $fh)) {
            $out[$fh] = $fh;            
          }
        }
        closedir($handle);
      }
    }
    return $out;
  }
}


?>
