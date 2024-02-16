<?php
    //Конфигурация сервиса
    //mySQL

    // LOCALHOST DEVELOP

    if($_SERVER['SERVER_NAME'] == "localhost" || $_SERVER['SERVER_NAME'] == "192.168.0.18"){
        $Host = 'localhost';
        $User = 'root';
        $Password = 'root';
        $Database = 'unesell';
    }else{

    }

    //Настройки системы.
    $ads = false;
    $forum_rating_mess = true;

    // @2024 Unesell Studio 
?>