<?php
    include "../config.php";

    $name = filter_var(trim($_POST['name']), FILTER_SANITIZE_STRING);
    $content = filter_var(trim($_POST['content']), FILTER_SANITIZE_STRING);
    $content = str_replace("!n!","<br/>", $content);
    $Type = filter_var(trim($_POST['Type']), FILTER_SANITIZE_STRING);
    $cook_id = htmlspecialchars($_COOKIE["id"]);
    
    echo("Название : ".$name."\n");
    echo("Описание: ".$content."\n");
    echo("Фото: ".$photo."\n");

    // Каталог, в который мы будем принимать файл:
    $uploaddir = '../datafiles/store/';
    $permitted_chars = '0123456789abcdefghijklmnopqrstuvwxyz';
    $uploadfile = $uploaddir.basename($_FILES['icon']['name']);
    $names = $cook_id."-".rand(0, 999999);
    $link = substr(str_shuffle($permitted_chars), 0, 15);
    $sqlname = $names.$link.'.png';

    $max_filesize = 2000000; // Максимальный размер загружаемого файла в байтах (в данном случае он равен 2 Мб).

    if(filesize($_FILES['userfile']['tmp_name']) > $max_filesize)
    die('Файл слишком большой.');


    // Копируем файл из каталога для временного хранения файлов:
    if (copy($_FILES['icon']['tmp_name'], $uploaddir . $sqlname))
    {
        $mysql = new mysqli($Host, $User_store, $Password_store, $Database_store);
        $mysql->query("INSERT INTO `shop` (`ID`, `USER_ID`, `LINK_ID`, `Name`, `Info`, `Icon`, `Type`) VALUES (NULL, '$cook_id', '$link', '$name', '$content', '$sqlname', '$Type');");
        $mysql->close();
        header('Location: ../');
    }
    else { echo "<h3>Ошибка! Не удалось загрузить файл на сервер! Попробуйте ещё раз.</h3>"; exit; }
    //Конец загрузки аватара
?>