<?php
session_start();

$_SESSION = array();
unset($_SESSION);

session_destroy();
echo '<meta http-equiv="refresh" content="0; url=login.php">';
?>