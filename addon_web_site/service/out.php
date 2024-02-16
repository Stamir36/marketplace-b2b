<?php
    setcookie('user', $user['login'], time() - 3600 * 24, "/");
    setcookie('mail', $user['email'], time() - 3600 * 24, "/");
    setcookie('avatar', $user['avatar'], time() - 3600 * 24, "/");
    setcookie('avatar', $user['avatar'], time() - 3600 * 24, "/");
    setcookie('id', $user['id'], time() - 3600 * 24, "/");

    header('Location: /');
?>