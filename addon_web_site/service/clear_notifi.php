<?php
    $id = htmlspecialchars($_COOKIE["id"]);

    include "config.php";

    $mysql = new mysqli($Host, $User, $Password, $Database);
    $result = $mysql->query("DELETE FROM `notifications` WHERE `notifications`.`user_id` = '$id'");
    $mysql->close();
?>