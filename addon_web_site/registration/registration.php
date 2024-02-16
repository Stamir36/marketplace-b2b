<?php
    $mail = filter_var(trim($_POST['mail']), FILTER_SANITIZE_STRING);
    $password = filter_var(trim($_POST['password']), FILTER_SANITIZE_STRING);

    include "../service/config.php";

    // Регистрация
    $mysql = new mysqli($Host, $User, $Password, $Database);
    $mysql->query("INSERT INTO `accounts_users` (`email`, `password`) VALUES('$mail', '$password')");

    // Добавление уведомления с благодарностью за регистрацию.
    $result = $mysql->query("SELECT `id` FROM `accounts_users` WHERE `email` = '$mail'");
    $user = $result->fetch_assoc();

    $id = $user['id'];
    setcookie('id', $id, time() + 3600 * 24, "/", $dns);

    $mysql->query("INSERT INTO `service_connect` (`id`, `user_id`, `img`, `Title`, `Subtitle`, `Data`, `Status`) VALUES (NULL, '$id', '/assets/img/icons/files.png', 'Файлы', 'Хранилище', '25мб', 'Подключено')");
    $mysql->query("INSERT INTO `notifications` (`user_id`, `text`, `href`, `data`) VALUES ('$id', 'Спасибо за регистрацию! С уважением - Администрация.', '#', CURRENT_TIMESTAMP)");
    $mysql->close();

    // Продолжение регистрации
    header('Location: /registration/user/');
    
?>