<?php

// control session if available else go to login php
if (!$session->ifset('sid')) {
  header('Location: ' . LC_ADMIN . 'login.php');
  exit;
} else {
  if (!$session->controlSession()) { // control session timeout
    $session->logout();
    header('Location: ' . LC_ADMIN . 'login.php?r=' . UN_LOGIN_EXPIRED);
    exit;
  }
}



?>