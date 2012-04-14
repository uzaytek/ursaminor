<?php

/**
 * Content table dao object 
 * 
 */  
class UN_Content extends UN_Dao
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
    parent::__construct(array('table'=> DB_TBL_PAGES, 'pk'=>'pageid','seq'=>'_nid_seq'),
                        array('pageid','langid','pagetitle','pagelink','pagedetail','menuorder','isdeleted','dtcreated')
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
   * Fill the content form
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
    if ($this->pageid > 0) {
      $this->form->addElement('hidden', 'id', $this->pageid);
    }

    if (isset($_REQUEST['currentpage'])) {
      $this->form->addElement('hidden', 'currentpage', intval($_REQUEST['currentpage']));
    }

    // add elements
    $this->form->addElement('text', 'pagetitle', _('Title')); 
    $this->form->addRule('pagetitle', _('Title must be filled'), 'required', null, 'client');

    $this->form->addElement('checkbox', 'menuorder', null, _('Show in the web site menu'), array('class'=>'checkbox'));
    $this->form->setCheckBoxTemplate('menuorder');


    $this->form->addElement('textarea', 'pagedetail', _('Content'), 'id="pagedetail"');
    $this->form->setRichTextTemplate('pagedetail');
    $this->form->addRule('pagedetail', _('Content must be filled!'), 'required', null, 'client');

    $this->form->addElement('select', 'langid', _('Language'), $aLanguages);

    $this->form->addElement('text', 'pagelink', _('Link'));
    $this->form->setAddNoteTemplate('pagelink', _('If you add a url, content will be displayed as link title'), true); 


    $this->form->addElement('submit', 'sb', _('Save'));
  }

  /**
   * Fill the content menu order form for settings/menuorder
   * 
   */
  public function fillMenuOrderForm() {

    // add elements

    $cAll = $this->getMenuContent(0);
    $box = array();
    if (is_array($cAll)) {
      foreach ($cAll as $c) {
        $box[$c['pageid']] = $c['pagetitle'];
      }
    } 
    $this->form->addElement('select', 'orderbox', _('Menu Order'), $box, array('id'=>'orderbox','size'=>10,'multiple'=>1)); 
    $this->form->setUpDownSelectTemplate('orderbox');
    $this->form->addElement('button', 'sb', _('Save'),'onclick="selectAll(\'menuorder\',\'orderbox\',true);"');
  }

  /**
   * Return all menu content
   *
   * @param integer langid language id if zero fetch all languages @see admin/settings menu order
   * @return array All content values
   */
  public function getMenuContent($langid) {
    if ($langid > 0) {
      $this->setWhere('langid = '. (int)$langid);
    }
    $this->setWhere('menuorder > 0 AND (isdeleted=0 OR isdeleted IS NULL)');
    $this->setOrder('langid DESC, menuorder ASC');
    return $this->getAll();
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
   * Update menu order values according to selectbox order in settings/menuorder
   * 
   * @param array $values menuorder Array key=>order value, Array value=>pageid
   */  
  public function updateMenuOrder($values) {
    try {
      if(!self::$db) $this->connect();
      if (is_array($values['orderbox'])) {
        foreach($values['orderbox'] as $k=>$v) {
          $result = self::$db->exec('UPDATE ' . DB_TBL_PAGES .
                                    ' SET menuorder = '.intval(++$k).'  WHERE pageid='.(int)$v);
        }
        return $result;
      }
    } catch (PDOException $e) {
      $this->fatal_error($e->getMessage());
    }
  }
  
  /**
   * Set content values
   * 
   * @param array $values The form values filled by panel user
   */  
  public function setValues(&$values) {
    $this->pagetitle   = filter_var($values['pagetitle']);
    $this->pagedetail  = filter_var($values['pagedetail']);
    $this->menuorder   = (isset($values['menuorder'])) ? intval($values['menuorder']) : 0;
    $this->langid      = (int)$values['langid'];
    $this->pagelink    = filter_var($values['pagelink']);
  }

}


?>