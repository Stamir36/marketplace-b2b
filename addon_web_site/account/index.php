<?php
    $cook_id = htmlspecialchars($_COOKIE["id"]);
    setcookie('site_page', 'main', time() + 3600 * 24, "/");

    include "../service/config.php";

    $mysql = new mysqli($Host, $User, $Password, $Database);

    $result = $mysql->query("SELECT * FROM `accounts_users` WHERE `id` = '$cook_id'");
    $user = $result->fetch_assoc();

    if(count($user) == 0){
        // Нет в системе. Инфо про аккаунт.
        include 'about.php';
    }else{
        // Пользователь в системе
        include 'account.php';
    }
?>