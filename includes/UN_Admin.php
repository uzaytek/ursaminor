<?php

/**
 * Admin panel users dao
 * 
 */  
class UN_Admin extends UN_Dao
{

  /**
   * Pear Quickform ojbect
   * 
   * @var object
   */  
  public $form;

  /**
   * Construct user, delete old session data
   * 
   */  
  public function __construct()
  {
    parent::__construct(array('table'=> DB_TBL_ADMINS, 'pk'=>'adminid'),
                        array('adminid','adminemail','adminname','adminpasswd','adminsid')
                        );
  }

  /**
   * Return default values table[field]=values
   * 
   * @return array fields
   */  
  public function defaults() {
    $fields = parent::defaults();
    unset($fields['adminpasswd']); // password md5 value
    return $fields;
  }

  /**
   * Return all user names
   * 
   * @return array Admin panel user names
   */  
  public function getNames() {
    $all = $this->getAll();
    $out = array();
    foreach($all as $a) {
      $out[$a['adminid']] = $a['adminname'];
    }
    return $out;
  }  
  
  
  /**
   * Update admin informations
   * 
   */  
  public function update_form() {
    
    $this->form     = new UN_QuickForm('update'); 
    
    // set form defaults, $defaults array will be used after update/insert process
    $defaults = $this->defaults();
    
    $this->form->setDefaults($defaults);
    
    if ($this->adminid > 0) {
      $this->form->addElement('hidden', 'adminid'); 
    }
    
    $this->form->addElement('static', 'adminname', _('Username')); 
    
    $this->form->addElement('text', 'adminemail', _('E-mail')); 
    $this->form->addRule('adminemail',  _('E-mail address regular expression failed'), 'email', null, 'client');
    
    $this->form->addElement('password', 'adminpasswd', _('Password')); 
    
    $this->form->addElement('submit', 'sb', _('Save'));    
  }
  
  /**
   * Set admin information values 
   * 
   * @param array $values The form values filled by panel user
   */  
  public function setValues(&$values) {
    $this->adminemail   = filter_var($values['adminemail']);
    $this->adminpasswd  = ($values['adminpasswd'] != '') ? md5(filter_var($values['adminpasswd'])) : $this->adminpasswd;
  }
}




?>