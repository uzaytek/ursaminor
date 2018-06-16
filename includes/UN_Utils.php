<?php

/**
 * array_search with partial matches and optional search by key
 *
 */
function array_find($needle, $haystack, $search_keys = false) {
  if(!is_array($haystack)) return false;
  foreach($haystack as $key=>$value) {
    $what = ($search_keys) ? $key : $value;
    if(strpos($what, $needle)!==false) return $key;
  }
  return false;
}
   
/**
 * array_search with recursive searching, optional partial matches and optional search by key
 *
 */
function array_find_r($needle, $haystack, $partial_matches = false, $search_keys = false) {
  if(!is_array($haystack)) return false;
  foreach($haystack as $key=>$value) {
    $what = ($search_keys) ? $key : $value;
    if($needle===$what) return $key;
    else if($partial_matches && @strpos($what, $needle)!==false) return $key;
    else if(is_array($value) && array_find_r($needle, $value, $partial_matches, $search_keys)!==false) return $key;
  }
  return false;
}

/**
 * get default language, comes from php manual
 *
 * Copyright © 2008 Darrin Yeager                        
 * http://www.dyeager.org/                               
 * Licensed under BSD license.                           
 * http://www.dyeager.org/downloads/license-bsd.php    
 */
function getDefaultLanguage() {
  if (isset($_SERVER["HTTP_ACCEPT_LANGUAGE"])) {
      return parseDefaultLanguage($_SERVER["HTTP_ACCEPT_LANGUAGE"]);
  } else {
      return parseDefaultLanguage(NULL);
  }
}

/**
 * Parse default language, comes from php manual
 *
 */
function parseDefaultLanguage($http_accept, $deflang = "en") {
   if(isset($http_accept) && strlen($http_accept) > 1)  {
      # Split possible languages into array
      $x = explode(",",$http_accept);
      foreach ($x as $val) {
         #check for q-value and create associative array. No q-value means 1 by rule
         if(preg_match("/(.*);q=([0-1]{0,1}\.\d{0,4})/i",$val,$matches))
            $lang[$matches[1]] = (float)$matches[2];
         else
            $lang[$val] = 1.0;
      }

      #return default language (highest q-value)
      $qval = 0.0;
      foreach ($lang as $key => $value) {
         if ($value > $qval) {
            $qval = (float)$value;
            $deflang = $key;
         }
      }
   }
   return strtolower($deflang);
}

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

  echo '<div id="navcontainer"><ul><li><a href="../index.php" alt="home" target="_blank"><img src="images/home.png" border="0" hspace="10" /></a></li>';
  if (is_array($menu)) {
    foreach($menu as $menu_id => $sub_menu){
      echo "<li><a href='".$sub_menu[0]."'>".$sub_menu[1]."</a></li>";
    }
  }
  echo "</ul>";
  $session = UN_Session::instance();
  $auth = $session->get('auth');

  echo '<p id="utimeinfo">'.$auth['adminname'].'</p>';	
  echo '</div><br clear="both">';
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