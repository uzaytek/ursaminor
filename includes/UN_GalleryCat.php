<?php

/**
 * Gallery category table dao object 
 * 
 */  
class UN_GalleryCat extends UN_Dao
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
  public function __construct() {
    parent::__construct(array('table'=> DB_TBL_GALLERY_CATS, 'pk'=>'catid','seq'=>'_nid_seq'),
                        array('catid','cattitle','isdeleted','dtcreated')
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
   * Fill the gallery category form
   * 
   */
  public function fillForm() {

    // set form defaults, $defaults array will be used after update/insert process
    $defaults = $this->defaults();
    $this->form->setDefaults($defaults);
    
    // add hidden element to session for controller purpose
    if ($this->catid > 0) {
      $this->form->addElement('hidden', 'id', $this->catid);
    }

    if (isset($_REQUEST['currentpage'])) {
      $this->form->addElement('hidden', 'currentpage', intval($_REQUEST['currentpage']));
    }

    // add elements
    $this->form->addElement('text', 'cattitle', _('Category')); 
    $this->form->addRule('cattitle', _('Category must be filled'), 'required', null, 'client');

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
   * Set gallery category values
   * 
   * @param array $values The form values filled by panel user
   */  
  public function setValues(&$values) {
    $this->cattitle   = filter_var($values['cattitle']);
  }

  /**
   * Return all gallery category values
   * 
   * @return array The gallery categories
   */  
  public function getGalleryCats() {
    $this->setWhere('(isdeleted=0 OR isdeleted IS NULL)');
    $rows = parent::getAll();
    $out = array();
    if (is_array($rows)) {      
      foreach($rows as $row) {
        $out[$row['catid']] = $row['cattitle'];
      }
    }
    return $out;
  }  
}


?>