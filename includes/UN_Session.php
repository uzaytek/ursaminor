<?php

/**
 * Manage session
 *
 */ 
class UN_Session extends UN_Dao {

  /**
   * forms saves some hidden values to session, under this name
   */
  private $sessionName;  

  /**
   * static property to hold singleton instansce
   * 
   */
  static $instance = false;


  /**
   * Construct session
   * 
   */  
  function __construct($name=null) {
    $name = ($name == null) ? uniqid() : $name;
    $this->sessionName = (defined('UN_SESSION_NAME')) ? UN_SESSION_NAME : $name;
    if(!headers_sent()) {
      ob_start();  
      session_cache_limiter('must-revalidate');
      session_start();
    }
    try {
      if(!self::$db) $this->connect();
      // delete old $sessions default value 1 hour
      self::$db->query('DELETE FROM '.DB_TBL_SESSIONS.' WHERE time < DATE_SUB(NOW(), INTERVAL 1 HOUR)');
    } catch (PDOException $e) {
      $this->fatal_error($e->getMessage());
    }
  }

  /**
   * checks username & password from database
   * 
   * @param string $adminname The username of admin
   * @param string $adminpasswd The password of admin
   * @return boolean False if failure otherwise true
   */
  public function controlUser($adminname, $adminpasswd) {
    try {
      if(!self::$db) $this->connect();
      $row = false;
      if ($adminname != '' && $adminpasswd != '') {
        $result = self::$db->query('SELECT * FROM '.DB_TBL_ADMINS . 
                                   ' WHERE adminname = '.$this->quote(filter_var($adminname)).
                                   ' AND adminpasswd = ' .$this->quote(md5(filter_var($adminpasswd))));
        $row = $result->fetch();
      }
      if (!is_array($row)) {// error
        return false;
      } else {
        $this->set('auth', $row);
        if (!$this->ifset('sid')) {
          srand((double)microtime()*1000000);
          $sid = md5(uniqid(rand()));
          $this->set('sid', $sid);
          // update/insert user sid values
          self::$db->query('UPDATE '.DB_TBL_ADMINS.' SET adminsid='.$this->quote($sid).
                           ' WHERE adminid='. $row['adminid']);
          self::$db->query('INSERT INTO '.DB_TBL_SESSIONS.' SET sid='.$this->quote($sid).' ,ip=' . 
                           $this->quote(filter_var($_SERVER['REMOTE_ADDR'])).' , time=NOW()');
        }
        return true;
      }
    } catch (PDOException $e) {
      $this->fatal_error($e->getMessage());
    }
  }

  /**
   * Control session sid value
   * 
   * @param string $sid The session identfication value
   * @return boolean True if successful, false otherwise
   */  
  public function controlSession() {
    try {
      if(!self::$db) $this->connect();
      // is there an uin? -> take it for authentication
      $query = 'SELECT COUNT(*) AS NUMROWS FROM ' . DB_TBL_SESSIONS . ' AS s,' . DB_TBL_ADMINS . ' AS u' .
        ' WHERE s.sid='.$this->quote(filter_var($this->get('sid'))) .
        ' AND s.sid=u.adminsid AND s.ip = '.$this->quote(filter_var($_SERVER["REMOTE_ADDR"]));
      $result = self::$db->query($query);
      $numrows = $result->fetchColumn();
      if ($numrows > 0) {
        self::$db->query('UPDATE ' . DB_TBL_SESSIONS.' SET time=NOW() WHERE sid="'.filter_var($this->get('sid')).'"');
        return true;
      } else {
        return false;
      }
    } catch (PDOException $e) {
      $this->fatal_error($e->getMessage());
    }
  }		 


  /**
   * factory method to return singleton instance
   * 
   * @return ON_User
   */
  public function instance() {
    if(!UN_Session::$instance) {
      UN_Session::$instance = new UN_Session;
    }
    return UN_Session::$instance;
  }


  /**
   * Return and unset variable value the hide in the session[formname]
   *
   * @return mixed Session variable value
   */ 
  function get($var) {
    $sessionName = $this->sessionName;
    if (isset($_SESSION[$sessionName][$var])) {
      $value = $_SESSION[$sessionName][$var];
      return $value;
    }
  }

  /**
   * Set variable to session
   *
   * @param string $k Key value of session array, variable name
   * @param mixed $v The value of variable
   * @param boolean $bOverWrite if true it over write to $k value
   */ 
  function set($k, $v, $bOverWrite=true) {
    if ($this->ifset($k) && $bOverWrite == false) {
      $_SESSION[$this->sessionName][$k] .= $v;
    } else {
      $_SESSION[$this->sessionName][$k] = $v;
    }
  }

  /**
   * If variable isset return true else false
   *
   * @param string $k The variable name
   */ 
  function ifset($k) {
    return isset($_SESSION[$this->sessionName][$k]);
  }


  /**
   * Empty or delete a session variable
   *
   * If parameter null it deletes all session data
   *
   * @param string $name variable name
   */ 
  function clear($name=null) {
    if ($name && $this->ifset($name)) {
      unset($_SESSION[$this->sessionName][$name]);
    }
  }

  /**
   * destroy session 
   * 
   * @return boolean Return true if successfull
   */  
  public function logout() {
    try {
      if(!self::$db) $this->connect();
      self::$db->query('DELETE FROM ' . DB_TBL_SESSIONS.' WHERE sid='.$this->quote($this->get('sid')));
      unset($_SESSION);
      session_destroy();      
      return true;
    } catch (PDOException $e) {
      $this->fatal_error($e->getMessage());
    }
    return false;
  }
}

?>
