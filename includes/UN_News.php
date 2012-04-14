<?php

/**
 * News table dao object 
 * 
 */  
class UN_News extends UN_Dao
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
    parent::__construct(array('table'=> DB_TBL_NEWS, 'pk'=>'newsid','seq'=>'_nid_seq'),
                        array('newsid','langid','newstitle','newsdetail','isdeleted','dtcreated')
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
   * Fill the news form
   * 
   */
  public function fillForm() {

    // set form defaults, $defaults array will be used after update/insert process
    $defaults = $this->defaults();

    $lang = new UN_Language();
    list($aLanguages, $defaultLanguage) = $lang->getLangTexts(); 
    if ($defaults['langid'] == 0) {
      $defaults['langid'] = $defaultLanguage;
    }


    $this->form->setDefaults($defaults);
    
    // add hidden element to session for controller purpose
    if ($this->newsid > 0) {
      $this->form->addElement('hidden', 'id', $this->newsid);
    }

    if (isset($_REQUEST['currentpage'])) {
      $this->form->addElement('hidden', 'currentpage', intval($_REQUEST['currentpage']));
    }

    // add elements
    $this->form->addElement('text', 'newstitle', _('News Title')); 
    $this->form->addRule('newstitle', _('News title must be filled!'), 'required', null, 'client');

    $this->form->addElement('textarea', 'newsdetail', _('News Content'), ' id="newsdetail"');
    $this->form->setRichTextTemplate('newsdetail');
    $this->form->addRule('newsdetail', _('News content must be filled!'), 'required', null,  'client');

    $this->form->addElement('select', 'langid', _('Language'), $aLanguages);

    $this->form->addElement('submit', 'sb', _('Save'));
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
   * Set news values
   * 
   * @param array $values The form values filled by panel user
   */  
  public function setValues(&$values) {
    $this->newstitle   = filter_var($values['newstitle']);
    $this->newsdetail  = filter_var($values['newsdetail']);
    $this->langid      = (int)$values['langid'];
  }

}


?>