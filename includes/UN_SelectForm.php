<?php

/**
 * Row forms for list pages
 *
 */ 
class UN_SelectForm {

  /**
   * Array item for select box
   *
   */ 
  private $arrSelect = NULL;

  /**
   * Database row id used for modify/delete/post another page
   *
   */ 
  private $identify;

  /**
   * Set array select and row element name pageid,newsid
   *
   */ 
  public function __construct($arrSelect, $identify='id') {
    $this->arrSelect = $arrSelect;
    $this->identify  = $identify;
  }

  /**
   * Return form html for row
   *
   */ 
  public function getForm($row_id) {

    $form = new UN_QuickForm('inline_'.$row_id);

    $form->addElement('select', 'go', null, array(_('Select'))+$this->arrSelect,
                      array('onchange'=>'changeaction(this.form,this.value)'));
    $form->setInlineTemplate('go');
    
    // row id and 
    $form->addElement('hidden', $this->identify, $row_id);

    // pagination value, lost if not saved
    if (isset($_REQUEST['curpage']) && $_REQUEST['curpage'] > 0) {
      $form->addElement('hidden', 'curpage', (int)$_REQUEST['curpage']);
    }

    $form->addElement('submit', 'sb', _('Go'), 'class="si"');
    $form->setInlineTemplate('sb');    

    return array($form->toHtml());
  }

  /**
   * If form level is a block return true
   *
   */ 
  public function isBegin() {
    return false;
  }

  /**
   * If form is a inline return true
   *
   */ 
  public function isEnd() {
    return true;
  }

}

?>
