<?php

/**
 * Translate table dao
 *
 */ 
class UN_Translate extends UN_Dao
{

  /**
   * Pear Quickform ojbect
   * 
   * @var object
   */  
  public $form;

  /**
   * Traslations of text(fkid)
   *
   * fkid database id of the text translated
   * 
   * @var array
   */  
  private $translations;

  /**
   * Construct setting
   * 
   */  
  public function __construct() {
    parent::__construct(array('table'=> DB_TBL_TRANSLATES, 'pk'=>'trid','seq'=>'_nid_seq'),
                        array('trid','fkid','langid','fktype','trtext')                              
                        );
  }
  
  /**
   * Load setting object with table values
   * 
   * @param integer $fkid   Text database id (catid for gallery categories)
   * @param string  $fktype Select translate type for releated $fkid
   */
  public function load($fkid, $fktype) {
    
    try {
      if(!self::$db) $this->connect();
      $result = self::$db->query('SELECT * FROM '.DB_TBL_TRANSLATES.
                                 ' WHERE fkid='.(int)$fkid.' AND fktype='.$this->quote($fktype));

      $rows =& $result->fetchAll(PDO::FETCH_ASSOC); 
    } catch (PDOException $e) {
      $this->fatal_error($e->getMessage());
    }

    if(is_array($rows)) {
      foreach($rows as $row) {
        $this->translations[$row['langid']] = $row['trtext'];
      }
      return true;
    } else {
      return false;
    }


  }

  /**
   * Return all text specified lang id
   * 
   * @param integer $langid Selected language
   * @return array all translated text Array[fkid][fktype] = tranlated text;
   */
  public function getAllTexts($langid) {
    
    try {
      if(!self::$db) $this->connect();
      $result = self::$db->query('SELECT * FROM '.DB_TBL_TRANSLATES.' WHERE langid='.(int)$langid);
      $rows =& $result->fetchAll(PDO::FETCH_ASSOC); 
    } catch (PDOException $e) {
      $this->fatal_error($e->getMessage());
    }
    $out = array();
    if(is_array($rows)) {
      foreach($rows as $row) {
        $out[$row['fkid']][$row['fktype']] = $row['trtext'];
      }
    }
    return $out;
  }


  
  /**
   * Insert values to db
   *
   */  
  public function insert(&$values) {
    try {
      if(!self::$db) $this->connect();
      // delete old records
      $fkid = (int)$values['id'];
      $fktype = filter_var($values['go']);
      $result = self::$db->exec('DELETE FROM ' . DB_TBL_TRANSLATES . ' WHERE fkid='.$fkid.' AND fktype='.$this->quote($fktype));

      // insert new translates
      foreach ($values['alang'] as $langid=>$langtext) {
        $result = self::$db->exec('INSERT INTO ' . DB_TBL_TRANSLATES .
                                ' (fkid, langid, fktype, trtext) VALUES ('.
                                $fkid.','.(int)$langid.','.$this->quote($fktype).','.
                                $this->quote(filter_var($langtext)).');');
      }
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
   * @param string $trText The text which will be translated
   */
  public function fillForm($fkid, $fktype, $trText) {

    // set form defaults, $defaults array will be used after update/insert process
    $defaults = $this->defaults();
    $this->form->setDefaults($defaults);
    
    // add elements

    $el = $this->form->addElement('hidden', 'id');
    $el->setValue($fkid);

    $el = $this->form->addElement('hidden', 'go');
    $el->setValue($fktype);


    $this->form->addElement('static', 'translate', _('Translate:').'&nbsp;'.$trText);

    $lang = new UN_Language;
    list($aLanguages, $defaultLanguage) = $lang->getLangTexts();   
    foreach($aLanguages as $langid=>$langtext) {
      if ($langid != $defaultLanguage) { // dont translate default language
        $el = $this->form->addElement('text', 'alang['.$langid.']', $langtext);
        // set value coming from db
        $el->setValue($this->translations[$langid]);
      }
    }

    $this->form->addElement('submit', 'sb', _('Save'), 'class="sb"');
  }

}


?>