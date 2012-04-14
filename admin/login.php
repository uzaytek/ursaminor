<?php

define('LOGIN_START', true);

include 'init.php';

unset($username,$password,$login);
// get values from post
if (isset($_POST['username']) && isset($_POST['password']) && isset($_POST['login'])) {

  $username = filter_var($_POST['username']);
  $password = filter_var($_POST['password']);
  if ($session->controlUser($username, $password)) {
    //ok reload to dashboard
    header('Location: ' . LC_ADMIN . 'dashboard.php');
    exit;
  } else {
    $login = UN_LOGIN_FAIL;
  }
}

if (isset($_REQUEST['r'])) { // session expried
  $login = (int)$_REQUEST['r'];
}


$output = '<form action="login.php" method="post">
    <table width="98%" height="600" valign="center" border="0"><tr><td>
	<table width="500" border="0" cellspacing="0" cellpadding="4" align="center">
        <tr><td align="center"><img src="./images/UrsaMinor.jpg"><br><br><br></td>
		<td align="center">';
  
if (isset($login)) {  
  switch ($login) {
  case UN_LOGIN_FAIL:
    $output .= fmtError(_('Please control your username/password'));
    break;
  case UN_LOGIN_EXPIRED:
    $output .= fmtError(_('Session expired'));
    break;
  }  
} else {
  $output .= _('Please enter your username/password');
}

  $output .= '
        <table width="400" height="100%" valign="center" border="0">
        <tr>
            <td align="left" width="120"><b>'._('Username').' :</b></td>
            <td><input type="text" name="username" class="minput" maxlength="255"></td>
        </tr>
        <tr>
            <td align="left"><b>'.('Password').' :</b></td>
            <td><input type="password" autocomplete="off" class="minput" name="password"  maxlength="255"></td>
        </tr>
        <tr>
            <td align="center" colspan="2"><br><input name="login" class="minput" type="submit" value="'._('Login').'"></td>
        </tr>
        </td>
        </tr>
        </table>
    </td>
    </tr>
    </table></td></tr></table></form>';

define('DONT_PRINT_MENU', 1);
include 'theme.php';
exit;


?>
