<?php
SESSION_START();
require_once("include/db_functions.php");

// if ($_SESSION['valid_login'] && !empty($_SESSION['valid_admin'])) {
//     echo "<script>alert('You have logged in.')</script>";
//     echo "<script>window.location.assign('mainpage.php');</script>";
//     die();
// }

$conn = db_connect();

if (isset($_POST['username']) && isset($_POST['password'])) {
    $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);
    $uname = $_POST['username'];
    $upwd = $_POST['password'];
    $upwd = md5($upwd);

    $table = "admin";
    $variable = "*";
    $condition = " WHERE username='$uname' LIMIT 1";

    $result = db_select($conn, $table, $variable, $condition);

    if ($result->num_rows > 0) {
        // check password
        if ($row = $result->fetch_assoc()) {
            if ($upwd == $row['password']) {
                $_SESSION['valid_login'] = true;
                $_SESSION['valid_admin'] = "$uname";
                $_SESSION['access_level'] = $row['level'];
                $_SESSION['access_page'] = $row['access'];
                header("Location: mainpage.php");
                die();
            } else {
                echo "<script>alert('Incorrect Username and Password')</script>";
                echo "<script>window.location.assign('index.php');</script>";
            }
        }
    } else {
        echo "<script>alert('Incorrect Username and Password')</script>";
        echo "<script>window.location.assign('index.php');</script>";
    }
}

?>