<?php

    $connect = mysqli_connect('localhost', 'root', '', 'chatbox');
    mysqli_set_charset($connect, "utf8"); /* Procedural approach */
  $connect->set_charset("utf8");
    if (!$connect) {
        die('Error connect to DataBase');
    }
?>
