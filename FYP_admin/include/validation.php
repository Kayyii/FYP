<?php

// function input_text_validation($input) {

//     if(preg_match("/([%\$#\*]+)/", $input)) {
//         echo "Invalid input";
//     } else {
//         echo $input;
//     }
// }

function input_text_validation($input) {

    if(preg_match("/([%\$#\*]+)/", $input)) {
        echo "Invalid input";
    } else {
        echo $input;
    }
}

// if logged in, no need to run again db.
function check_logged_in() {
    if ($_SESSION['valid_login']) {
        echo "<script>alert('You are logged in.')</script>";
        echo "<script>window.location.assign('mainpage.php');</script>";
        die();
    }
}

// check if user are not logged in
function check_logout() {
    if (!isset($_SESSION['valid_login'])) {
        echo "<script>alert('You need to log in first.')</script>";
        echo "<script>window.location.assign('index.php');</script>";
        die();
    } else if (isset($_SESSION['valid_login']) && !$_SESSION['valid_login']) {
        echo "<script>alert('You need to log in first.')</script>";
        echo "<script>window.location.assign('index.php');</script>";
        die();
    }
}

function check_access($access_code) {
    $access_code = $access_code;
    $access = $_SESSION['access_page'];
    $access = explode(",", trim($access));
    if (!in_array($access_code, $access)) {
        echo "<script>alert('Cannot Access This Page')</script>";
        echo "<script>window.location.assign('mainpage.php');</script>";
    } 
}

?>