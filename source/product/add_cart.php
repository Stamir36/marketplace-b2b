<?php
    $product_id = $_POST['product_id'];
    $user_id = htmlspecialchars($_COOKIE["id"]);

    include "../config.php";

    $mysql_shop = new mysqli($Host, $User_store, $Password_store, $Database_store);
    $result = $mysql_shop->query("INSERT INTO `cart` (`id`, `product_id`, `user_id`) VALUES (NULL, '$product_id', '$user_id')");
    $mysql_shop->close();
?>