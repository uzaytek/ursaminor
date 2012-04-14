<?php

/**
 * Return version info for meta tag
 *
 */
function meta_generator() {
  echo UN_PROJECT_NAME . ' ' . UN_VERSION;
}


/**
 * Return file extension
 *
 */
function getExtension($name) {
  if (strstr($name, ".")) {
    return strtolower(substr($name, strrpos($name, ".")));
  }
}

/**
 * Return substring of the var
 * 
 * @param string $var The truncated string
 * @param integer $len The max length of string returned
 */
function truncate($var, $len = 40) {
   if (empty ($var)) { return ''; }
   if (strlen ($var) < $len) { return $var; }
   if (preg_match ("?(.{1,$len})\s.?ms", $var, $match)) { return $match [1] . '...'; }
   else { return substr ($var, 0, $len) . '...'; }
}

/**
 * Strip tags
 *
 */
function clearCodes($val) {
  //return $val;
  return strip_tags($val);
}


/**
 * Make a url link
 *
 * @param string $url The url href
 * @param string $title Url title
 * @return string Formatted Url link
 */
function url($url, $title=null) {
  $url = str_replace(array('http://','www.',), '', $url); // strip if exists
  return '<a href="http://www.'.$url.'" target="_blank">'.
    (($title != null) ? $title : $url).'</a>';
}


/**
 * Echo admin panel menu according to user
 *
 * @return void
 */
function print_menu() {
  $menu = $GLOBALS['_menu_arr'];

  echo "<div id='navcontainer'><ul>";
  if (is_array($menu)) {
    foreach($menu as $menu_id => $sub_menu){
      echo "<li><a href='".$sub_menu[0]."'>".$sub_menu[1]."</a></li>";
    }
  }
  echo "</ul>";
  $session = UN_Session::instance();
  $auth = $session->get('auth');

  echo "<p id='utimeinfo'>".$auth['adminname']."</p>";	
  echo "</div><br clear='both'>";
}

/**
 * Return user ip
 *
 * @return string ip information
 */
function ipCheck() {
  if (getenv('HTTP_CLIENT_IP')) {
    $ip = getenv('HTTP_CLIENT_IP');
  } elseif (getenv('HTTP_X_FORWARDED_FOR')) {
    $ip = getenv('HTTP_X_FORWARDED_FOR');
  } elseif (getenv('HTTP_X_FORWARDED')) {
    $ip = getenv('HTTP_X_FORWARDED');
  } elseif (getenv('HTTP_FORWARDED_FOR')) {
    $ip = getenv('HTTP_FORWARDED_FOR');
  } elseif (getenv('HTTP_FORWARDED')) {
    $ip = getenv('HTTP_FORWARDED');
  } else {
    $ip = $_SERVER['REMOTE_ADDR'];
  }
  if (filter_var($ip, FILTER_VALIDATE_IP) === false) {
    return 'not found';// db field is 15 character length.
  } else {
    return $ip;
  }
}

/**
 * autoload class file
 *
 * @param string $className Class name
 */
function __autoload($className) {
  if (file_exists(PT_INCLUDE . $className . ".php")) {
    include_once PT_INCLUDE . $className . ".php";
  }
}

/**
 * Filter parameter
 *
 * @param mixed $val Filter variable
 * @return mixed
 */
function UN_Filter($val) {
  if (is_array($val)) {
    return filter_var_array($val);
  } else {
    return filter_var($val);
  }
}

/**
 * Generate Random string
 *
 * @param integer $iLength Length of string
 * @param string $lowercase The Case of string
 * @return string
 */
function genRandStr($iLength = 5, $lowercase = false) {
  // exclude same characters like l,o,1,0
  $allchars = 'abcdefhknmprstuvwxyzABCDEFHKNMPRSTUVWXYZ23456789'; 
  if ($lowercase) {
    $allchars = strtolower($allchars);
  }
  $string = ''; 
  $len = strlen($allchars)-1;
  mt_srand((double) microtime() * 1000000); 
  for ($i = 0; $i < $iLength; $i++) { 
    $string .= $allchars{mt_rand(0, $len)};
  }
  return $string;
}

/**
 * Format to kilobyte
 *
 * @param integer $byte Byte value
 * @return integer
 */
function fmtKB($byte) {
  return intval($byte/1024);
}

/**
 * Format error messages
 *
 * @param string $sErrorText The error text
 * @return void
 */
function fmtError($sErrorText, $class='error')
{
  if ($sErrorText != "") {
    return "<div class='$class'>$sErrorText</div>";
  }
}

/**
 * Format success messages
 *
 * @param string $sSuccessText The success text
 * @return void
 */
function fmtSuccess($sSuccessText)
{
  if ($sSuccessText != "") {
    return "<div class='success'>$sSuccessText</div>";
  }
}

?>