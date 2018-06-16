<?php

/**
 * Manage the text of process messages
 * 
 */
class UN_Say
{

  /**
   * Add a message to session message variable
   * 
   * @param string $sText The text message
   * @param boolean $bCleanBefore if true cleans session messages
   * @return void
   */	
  public static function add($sText, $bCleanBefore = false) {
    if ($bCleanBefore) {
      UN_Say::shutUP();
    }
    $session =& UN_Session::instance();
    $session->set('aMessages', $sText, false);
  }
  
  /**
   * Return all messages
   * 
   * @return array messages
   */	
  private static function getAll() {
    $session = UN_Session::instance();
    if ($session->ifset('aMessages')) {
      return $session->get('aMessages');
    }
  }
  
  /**
   * Unset session messages
   * 
   * @return void
   */	
  private static function shutUP() {
    $session = UN_Session::instance();
    $session->clear('aMessages');
  }
  
  /**
   * Returns process messages
   *
   * @param string $mess The printed message string
   * @return string Messages
   * @see application theme file
   */
  public static function get($message='') {
    $output = "";
    if ($message) UN_Say::add($message);
    $aMessages = UN_Say::getAll();
    if(is_array($aMessages)) {
      foreach ($aMessages as $ndx=>$value) {
        $output .= $value;
      }
    } else {
      $output = $aMessages;
    }
    UN_Say::shutUP();
    return $output;
  }
}



?>
