<?
    include "../config.php";
    $order = $_POST['order'];
    $card_id = $_POST['card_id'];
    $user_id = $_POST['user_id'];
    $review = $_POST['review'];
    $id_product = $_POST['id_product'];

    $order_sql = new mysqli($Host, $User_store, $Password_store, $Database_store);
    $order_sql->query("UPDATE `cart` SET `review` = 'yes' WHERE `cart`.`user_id` = '$user_id' AND `cart`.`order_id` = '$order';");
    $order_sql->query("INSERT INTO `comments` (`id`, `product_id`, `user_id`, `comments`) VALUES (NULL, '$id_product', '$user_id', '$review')");

    $order_sql->close();
?>