<?php

require_once 'HTML/Table.php';

/**
 * Html table
 *
 */ 
class UN_Table extends HTML_Table
{

  /**
   * Quickform ojbect
   *
   */ 
  public $form;  

  /**
   * Construct setting
   * 
   */  
  public function UN_Table(&$form=null) {
    parent::__construct('border=0 cellpadding=0 cellspacing=0');
    $this->form =& $form;
  }

  /**
   * Add title row
   * 
   */  
  public function title($titles) {
    // form column counts
    if ($this->form) {
      $a = array_fill(0, 1, '');
      if($this->form->isBegin()) { // form html location
        $titles = array_merge($a,$titles);
      } else {
        $titles = array_merge($titles,$a); 
      }
    }
    // add titles
    $this->addRow($titles);
  }

  /**
   * Call parent addrow
   * 
   */  
  function addRow($row) {
    if (!is_array($row)) {
      $row = array($row);
    }
    parent::addRow($row);
  }

  /**
   * Add a row, add form html begin or end to row
   * 
   */  
  public function tr($row, $row_id=0) {
    if ($this->form) {
      $abegin = ($this->form->isBegin()) ? $this->form->getForm($row_id) : array();
      $aend   = ($this->form->isEnd()) ? $this->form->getForm($row_id) : array();    
      $this->addRow(array_merge($abegin, $row, $aend));
    } else {
      $this->addRow($row);
    }
  }

  /**
   * Display form
   * 
   */  
  public function display() {
    $this->setRowAttributes(0, 'class="title"', true);
    $this->altRowAttributes(1, 'class="row"', 'class="altrow"', true);
    $output = $this->toHTML();
    return $output;
  }
}

?>
