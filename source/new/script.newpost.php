<?php
    include "../config.php";
    
    // Data input user
    $product_name = filter_var(trim($_POST['name']), FILTER_SANITIZE_STRING);
    $content = filter_var(trim($_POST['content']), FILTER_SANITIZE_STRING);
    $content = str_replace("!n!","<br/>", $content);
    $categories = filter_var(trim($_POST['categories']), FILTER_SANITIZE_STRING);
    $price = filter_var(trim($_POST['price']), FILTER_SANITIZE_STRING);
    $store = filter_var(trim($_POST['id_store']), FILTER_SANITIZE_STRING);
    $features = filter_var(trim($_POST['features']), FILTER_SANITIZE_STRING);
    $features = str_replace("!n","<", $features);
    $features = str_replace("n!",">", $features);
    $cook_id = htmlspecialchars($_COOKIE["id"]);

    echo("Название: ".$product_name."  |  ");
    echo("Описание: ".$content."  |  ");
    echo("Цена: ".$price."  |  ");
    echo("ИД магазина: ".$store."  |  ");
    echo("Характеристики: ".$features."  |  ");

    // Link Generation
    $permitted_chars = '0123456789abcdefghijklmnopqrstuvwxyz';
    $link = substr(str_shuffle($permitted_chars), 0, 15);
    echo("link : ".$link."  |  ");

    // File Upload
    $structure = "../datafiles/post/".$link."/";
    if (mkdir($structure, 0777, true)) {
        echo("Директории созданы.");
    }else{
        echo('Не удалось создать директории...');
    }
    
    if($_FILES)
    {
        foreach ($_FILES["uploads"]["error"] as $key => $error) {
            if ($error == UPLOAD_ERR_OK) {
                $tmp_name = $_FILES["uploads"]["tmp_name"][$key];
                $name = $_FILES["uploads"]["name"][$key];
                move_uploaded_file($tmp_name, "../datafiles/post/".$link."/".$name);
            }
        }
        echo "Файлы загружены";
    }

    $conn = new mysqli($Host, $User_store, $Password_store, $Database_store);
    // Проверка соединения
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }
    // SQL запрос для вставки данных
    $sql = "INSERT INTO products (link, name, price, store_id, description, characteristics, categories) VALUES ('$link', '$product_name', '$price', '$store', '$content', '$features', '$categories')";
    echo($sql);
    if ($conn->query($sql) === TRUE) {
        echo "New record created successfully";
        // Закрываем соединение
        $conn->close();
        header('Location: ../product/?id='.$link);
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
        $conn->close();
        header('Location: ../new/');
    }
?>