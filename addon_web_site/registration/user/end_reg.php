<?php
    include "../../service/config.php";

    $name = filter_var(trim($_POST['name']), FILTER_SANITIZE_STRING);
    $date = filter_var(trim($_POST['Date_of_Birth']), FILTER_SANITIZE_STRING);
    $coki_id = htmlspecialchars($_COOKIE["id"]);

    //Загрузка аватара
    // Каталог, в который мы будем принимать файл:
    $uploaddir = '../../data/users/avatar/';
    $uploadfile = $uploaddir.basename($_FILES['uploadfile']['name']);
    $names = $coki_id;
    $sqlname = $names . '.png';

    $max_filesize = 5097152; // Максимальный размер загружаемого файла в байтах (в данном случае он равен 5 Мб).

    if(filesize($_FILES['userfile']['tmp_name']) > $max_filesize)
    die('Файл слишком большой.');


    // Копируем файл из каталога для временного хранения файлов:
    if (copy($_FILES['uploadfile']['tmp_name'], $uploaddir . $names . '.png'))
    {

    $mysql = new mysqli($Host, $User, $Password, $Database);
    $mysql->query("UPDATE `accounts_users` SET `name` = $name, `Date_of_Birth` = $date, `avatar` = $sqlname WHERE `accounts_users`.`id` = $coki_id;");
    $mysql->query("UPDATE `accounts_users` SET `name` = '$name', `Date_of_Birth` = '$date', `avatar` = '$sqlname' WHERE `accounts_users`.`id` = '$coki_id';");

    $mysql->close();

    setcookie('avatar', $coki_id . '.png', time() + 3600 * 24, "/", $dns);
    setcookie('user', $name, time() + 3600 * 24, "/", $dns);
    
    }
    else { echo "<h3>Ошибка! Не удалось загрузить файл на сервер! Попробуйте ещё раз.</h3>"; exit; }
    //Конец загрузки аватара

    header('Location: /');
?>
