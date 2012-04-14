<?php

/**
 * Log table dao object 
 * 
 */  
class UN_Log extends UN_Dao
{

  /**
   * Construct logs
   * 
   */  
  public function __construct() {
    parent::__construct(array('table'=> DB_TBL_LOGS, 'pk'=>'logid','seq'=>'_nid_seq'),
                        array('logid','logvalue','dtcreated')
                        );
  }

  /**
   * Insert values to db
   * 
   * @param integer $theid The database row id
   */  
  public function insert(&$theid) {
    $this->dtcreated  = $this->getDate('il');
    return parent::insert($theid);
  }

  /**
   * Set log values
   * 
   * @param array $values The log values
   */  
  public function setValues(&$values) {
    $this->logvalue   = $values['logvalue'];
  }
}


?>