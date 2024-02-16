<!DOCTYPE html>
<html>
<head>
  <meta charset="UTF-8" />
  <title>Загрузка аватара</title>
</head>
<body>
    <?php
    // Каталог, в который мы будем принимать файл:
    $uploaddir = './avatar/';
    $uploadfile = $uploaddir.basename($_FILES['uploadfile']['name']);
    $names = htmlspecialchars($_COOKIE["user"]);
    $sqlname = $names . '.png';

    $max_filesize = 2097152; // Максимальный размер загружаемого файла в байтах (в данном случае он равен 2 Мб).

    if(filesize($_FILES['userfile']['tmp_name']) > $max_filesize)
    die('Файл слишком большой.');


    // Копируем файл из каталога для временного хранения файлов:
    if (copy($_FILES['uploadfile']['tmp_name'], $uploaddir . $names . '.png'))
    {
      $mysql = new mysqli('localhost', 'x73125j8_unesell', 'Stas1214', 'x73125j8_unesell');
      $result = $mysql->query("UPDATE `account_users` SET `avatar` = '$sqlname' WHERE `account_users`.`login` = '$names'");
      $mysql->close();

      setcookie('avatar', $names . '.png', time() + 3600 * 24, "/");
      header('Location: /');
    }
    else { echo "<h3>Ошибка! Не удалось загрузить файл на сервер!</h3>"; exit; }

    ?>
</body>
</html>

