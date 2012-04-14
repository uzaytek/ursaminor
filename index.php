<?php

include 'init.php';

$content = isset($_REQUEST['t']) ? theme_content($_REQUEST['t']) : theme_welcome();

theme($content);
?>