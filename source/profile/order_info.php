<?
    include "../config.php";
    $order = $_POST['order'];

    $order_sql = new mysqli($Host, $User_store, $Password_store, $Database_store);
    
    $result = $order_sql->query("SELECT * FROM `orders` WHERE `order_number` = '$order'");
    $result = $result->fetch_assoc();

    echo json_encode($result);

    $order_sql->close();
?>