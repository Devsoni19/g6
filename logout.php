<?php
// session_start();
unset($_SESSION['LAST_ACTIVE_TIME']);
unset($_SESSION['IS_LOGIN']);
header('location:index.php');
die();
?>