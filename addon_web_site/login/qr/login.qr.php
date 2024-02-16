<?
   include "../../service/config.php";
    $mysql = new mysqli($Host, $User, $Password, $Database);

    $hash = $_GET["hash"];

    $result = $mysql->query("SELECT * FROM `accounts_users` WHERE `auth_hash` = '$hash'");
    $result = $result->fetch_assoc();

    echo json_encode($result);  
    
    $mysql->close();
?>