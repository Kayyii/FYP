<?php
SESSION_START();


// store to test if they were logged in 
// $old_user = $_SESSION['valid_admin'];
// unset($_SESSION['valid_admin']);
unset($_SESSION['valid_login']);
unset($_SESSION['valid_admin']);
session_destroy();

Header("Location: index.php");
die();

?>