<?php
    //Файл конфігурації
    //mySQL
    //ini_set('display_errors', 1);
    //ini_set('display_startup_errors', 1);
    //error_reporting(E_ALL);
    // LOCALHOST DEVELOP

    if($_SERVER['SERVER_NAME'] == "localhost" || $_SERVER['SERVER_NAME'] == "192.168.0.18"){
        $Host = 'localhost';
        $User = 'root';
        $Password = 'root';
        $Database = 'unesell';

        $User_store = 'root';
        $Password_store = 'root';
        $Database_store = 'store';
        $dns = $_SERVER['SERVER_NAME'];
        $dns_store = "http://localhost/app/store/";
        $dns_local_root == false; // Если проект не в корне сайта
        if(!$dns_local_root){
            $dns_store = "http://".$_SERVER['SERVER_NAME']."/";
        }
    }else{
        // Очень важно указать домен проекта для его работоспособности
        $dns_store = "https://store.unesell.com/"; 
    }

    // @2023 Мірошніченко Станіслав
?>