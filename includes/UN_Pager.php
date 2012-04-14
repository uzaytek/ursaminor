<?php

require_once 'Pager/Pager.php';

/**
 * Pagination class for ursaminor extends Pear/Pager
 *
 */ 
class UN_Pager extends Pager
{

  /**
   * Pagination object
   *
   */ 
  private $_pager = null;  

  /**
   * Constructor of pager
   *
   * @param integer $numrows The table numrows count for query
   * @param array $alimit Limit and Offset values
   * @param array $pagerOptions Pagination options(mode,perpage,total)
   */ 
  public function UN_Pager($numrows, &$alimit, $pagerOptions=null) {

    $_options = array(
                           'mode'       => 'Sliding',
                           'perPage'    => 30,
                           'delta'      => 2,
                           'totalItems' => $numrows,
                           'urlVar'     => 'currentpage',
			              );


    if (is_array($pagerOptions)) {
      $_options = array_merge($_options, $pagerOptions);
    } 
    
    $this->_pager =& Pager::factory($_options);

    //then we fetch the relevant records for the current page
    list($from, $to) = $this->_pager->getOffsetByPageId();
    //set the OFFSET and LIMIT clauses for the following query
    $alimit['limit'] = $_options['perPage'];
    $alimit['offset'] = $from - 1;
  }

  /**
   * Return page links
   *
   * @return Return pagination links
   */ 
  public function display() {
    return $this->_pager->links;
  }

  
}

?>