<?php
    $product_id = $_POST['product_id'];
    $user_id = htmlspecialchars($_COOKIE["id"]);

    include "../config.php";

    $mysql_shop = new mysqli($Host, $User_store, $Password_store, $Database_store);
    $result = $mysql_shop->query("DELETE FROM `cart` WHERE `product_id` = '$product_id' AND `user_id` = '$user_id' && `order_id` = 0;");
    $mysql_shop->close();
?>