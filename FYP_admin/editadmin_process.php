<?php
SESSION_START();
require_once("include/db_functions.php");

$conn = db_connect();

if(isset($_POST['pages'])){
    $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);
    $upwd = (isset($_POST['password'])) ? md5($_POST['password']) : '';
    $cpwd = (isset($_POST['cpassword'])) ? md5($_POST['cpassword']) : '';
    $access = implode(",", $_POST['pages']);
	$id = $_POST['serial'];

    if ($upwd == $cpwd) {
        $pwdsql = (trim($upwd) === '') ? '' : "password = '$upwd',";
        $sql = "UPDATE admin SET $pwdsql access= '$access' WHERE id='$id' LIMIT 1 ";
  
        $run = $conn->query($sql);

        if($run)
        {
            echo "<script>alert('Update Success.')</script>";
            echo "<script>window.location.href='admin.php'</script>";
        }
        else {
            echo "<script>alert('Update Fail !')</script>";
            echo "<script>window.location.href='editadmin.php?edit=$id'</script>";
        }
    } else {
        echo "<script>alert('Please enter correct confirm password.')</script>";
        echo "<script>window.location.assign('editadmin.php?edit=$id');</script>";
    }

}

?>