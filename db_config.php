<?php
    $host = "localhost:3307";
    $uname = "selfstudy";
    $pass = "selfstudy";
    $db = "ajax_study";

    try {
        $conn = mysqli_connect($host, $uname, $pass, $db);
    } catch(Exception $e) {
        echo $e;
    }
?>