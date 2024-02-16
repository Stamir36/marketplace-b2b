<?
    include "../config.php";

    $order = $_POST['order'];
    $card_id = $_POST['card_id'];

    $order_sql = new mysqli($Host, $User_store, $Password_store, $Database_store);
    $order_sql->query("UPDATE `cart` SET `Received` = 'Yes' WHERE `cart`.`id` = $card_id;");
    
    $result = $order_sql->query("SELECT COUNT(*) AS total FROM `cart` WHERE `order_id` = '$order' AND `Received` = 'No';");
    $row = $result->fetch_assoc();
    $total = $row['total'];

    if ($total == 0) {
        $order_sql->query("UPDATE `orders` SET `status` = 'complete' WHERE `order_number` = '$order';");
    }

    $order_sql->close();
?>