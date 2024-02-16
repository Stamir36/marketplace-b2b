<?
    include "../config.php";
    $mail = $_POST['mail'];
    $post = $_POST['post'];
    $order = $_POST['order'];

    $order_sql = new mysqli($Host, $User_store, $Password_store, $Database_store);
    $order_sql->query("UPDATE `cart` SET `Mail` = '$mail', `Tracking` = '$post' WHERE `cart`.`order_id` = $order;");
    $order_sql->query("UPDATE `orders` SET `status` = 'send' WHERE `orders`.`order_number` = $order");

    $order_sql->close();
?>