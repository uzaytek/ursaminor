<?php

/**
 * Lang table dao object 
 * 
 */  
class UN_Language extends UN_Dao
{

  /**
   * Pear Quickform ojbect
   * 
   * @var object
   */  
  public $form;

  /**
   * Construct content
   * 
   */  
  public function __construct() {
    parent::__construct(array('table'=> DB_TBL_LANGS, 'pk'=>'langid','seq'=>'_nid_seq'),
                        array('langid','langcode','browsercodes',
                              'langflag','langtext','isdefault','isdeleted','dtcreated')
                        );
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
   * Fill the language form
   * 
   */
  public function fillForm() {

    // set form defaults, $defaults array will be used after update/insert process
    $defaults = $this->defaults();
    $this->form->setDefaults($defaults);
    
    // add hidden element to session for controller purpose
    if ($this->langid > 0) {
      $this->form->addElement('hidden', 'id', $this->langid);
    }

    if (isset($_REQUEST['currentpage'])) {
      $this->form->addElement('hidden', 'currentpage', intval($_REQUEST['currentpage']));
    }

    // add elements
    $this->form->addElement('text', 'langcode', _('Language Code(s)')); 
    $this->form->setAddNoteTemplate('langcode',
                                    _('Language code must be available in your system, please see help documents'), true); 
    $this->form->addRule('langcode', _('Language code must be filled!'), 'required', null, 'client');

    $this->form->addElement('text', 'browsercodes', _('Browser Code(s)'));
    $this->form->addRule('browsercodes', _('Browser codes must be filled!'), 'required', null,  'client');

    $this->form->addElement('text', 'langflag', _('Language Flag'),'maxlength="10"'); 
    $this->form->addRule('langflag', _('Maximum flag value 10 characters'), 'maxlength', 10, 'client');

    $this->form->addElement('text', 'langtext', _('Language Text'), ' id="langtext"');
    $this->form->addRule('langtext', _('Language text must be filled!'), 'required', null,  'client');

    $this->form->addElement('submit', 'sb', _('Save'));
  }

  /**
   * Select available languages in a html select element
   * 
   * @param integer $default Selected language id from user
   * @return string form html
   */
  public function selectLanguageForm($default=0) {
    $form     = new UN_QuickForm('SelectLanguage', 'post');
    // set form defaults
    list($aLanguages, $defaultLanguage) = $this->getLangTexts(); 
    $defaultLanguage = ($default > 0) ? $default : $defaultLanguage;
    $defaults['langid'] = $defaultLanguage;
    $form->setDefaults($defaults);

    // add elements
    $form->addElement('html','<tr><td>');
    $form->addElement('select', 'langid', _('Select Language'), $aLanguages);
    $form->setInlineTemplate('langid');
    $form->addElement('submit', 'sb', _('Go'),'class="si"');
    $form->setInlineTemplate('sb');
    $form->addElement('html','</td></tr>');
    return $form->toHtml();
  }


  /**
   * Fill the content menu order form for settings/menuorder
   * 
   */
  public function fillDefaultLangForm() {

    // set form defaults
    list($aLanguages, $defaultLanguage) = $this->getLangTexts(); 
    $defaults['defaultLanguage'] = $defaultLanguage;
    $this->form->setDefaults($defaults);

    // add elements
    $this->form->addElement('select', 'defaultLanguage', _('Default Language'), $aLanguages);
    $this->form->addElement('submit', 'sb', _('Save'));
  }

  /**
   * Return language table fields according to parameter
   * 
   * @param string $field Desired table field name
   * @return array(all language data, default language id)
   */
  public function getLangTexts($field = 'langtext') {
    $this->setWhere('(isdeleted=0 OR isdeleted IS NULL)');
    $rows = parent::getAll();
    $out = array();
    if (is_array($rows)) {      
      foreach($rows as $row) {
        if (isset($row[$field])) {
          $out[$row['langid']] = $row[$field];
        } else {
          throw new Exception(_('Field not found in the language rows'));
        }
        if ($row['isdefault'] > 0) {
          $default = $row['langid']; // default lang id
        }
      }
    }
    return array($out,$default);
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
   * Set language values
   * 
   * @param array $values The form values filled by panel user
   */  
  public function setValues(&$values) {
    $this->langcode     = filter_var($values['langcode']);
    $this->browsercodes = UN_Filter($values['browsercodes']);
    $this->langtext     = filter_var($values['langtext']);
    $this->langflag     = filter_var($values['langflag']);
  }

}


?>