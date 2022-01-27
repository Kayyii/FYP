<?php
SESSION_START();
require_once("include/db_functions.php");

// if ($_SESSION['valid_login'] && !empty($_SESSION['valid_admin'])) {
//     echo "<script>alert('You have logged in.')</script>";
//     echo "<script>window.location.assign('mainpage.php');</script>";
//     die();
// }

$conn = db_connect();

if (isset($_POST['username']) && isset($_POST['password']) && isset($_POST['pages'])) {
    $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);
    $uname = $_POST['username'];
    $upwd = $_POST['password'];
    $cpwd = $_POST['cpassword'];
    $upwd = md5($upwd);
    $cpwd = md5($cpwd);
    $level = $_SESSION['access_level'];
    $level = $level + 1;
    $access = implode(",", $_POST['pages']);

    $sql = "SELECT username FROM admin WHERE username='$uname' LIMIT 1";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        echo "<script>alert('Username already exists.')</script>";
        echo "<script>window.location.assign('addadmin.php');</script>";
        die();
    }

    if ($upwd == $cpwd) {
        $sql = "INSERT INTO admin (username, password, level, access) VALUES ('$uname', '$upwd', '$level', '$access')";
    
        $result = $conn->query($sql);
        if ($result) {
            echo "<script>alert('Add Success.')</script>";
            echo "<script>window.location.assign('admin.php');</script>";
        } else {
            echo "<script>alert('Database Access Failed.')</script>";
            echo "<script>window.location.assign('admin.php');</script>";
        }
    } else {
        echo "<script>alert('Please enter correct confirm password.')</script>";
        echo "<script>window.location.assign('addadmin.php');</script>";
    }
}

?>