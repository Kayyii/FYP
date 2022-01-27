<?php

function db_connect() {
    $hn='localhost';
    $un='root';
    $pw='';
    $db='theface';
    
    $conn = new mysqli($hn, $un, $pw, $db);

    if($conn->connect_error) {
        throw new Exception('Could not connect to database server');
        exit();
    } else {
        return $conn;
    }
}

function db_select($conn, $table, $variable, $condition) {
    $query = "SELECT $variable FROM $table $condition";
    $result = $conn->query($query);
    if (!$result) die("Database Access Failed");

    return $result;
}

?>