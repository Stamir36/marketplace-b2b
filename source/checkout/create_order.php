<?php
    // SELECT * FROM `cart`c JOIN `products` p ON c.product_id = p.link JOIN `shop` s ON p.store_id = s.LINK_ID WHERE c.user_id = 1;
    // Language setup
    if(htmlspecialchars($_COOKIE["lang"]) == "ua"){
        include "../languages/ua.php";
    }elseif(htmlspecialchars($_COOKIE["lang"]) == "ru"){
        include "../languages/ru.php";
    }elseif(htmlspecialchars($_COOKIE["lang"]) == "en"){
        include "../languages/en.php";
    }else{
        include "../languages/ua.php";
    }
    // Получаем данные из POST-запроса
    $data = json_decode(file_get_contents('php://input'), true);

    $cook_id = htmlspecialchars($_COOKIE["id"]);
    include "../config.php";

    // Обрабатываем данные
    $first_name = $data['first_name'];
    $last_name = $data['last_name'];
    $email = $data['email'];
    $phone = $data['phone'];
    $country = $data['country'];
    $post_code = $data['post_code'];
    $address = $data['address'];
    $order_number = $data['order_number'];

    // Создаем соединение с базой данных
    $conn = new mysqli($Host, $User_store, $Password_store, $Database_store);
    // Проверяем соединение на наличие ошибок
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Генерируем SQL-запрос на добавление данных в таблицу orders
    $sql = "INSERT INTO orders (first_name, last_name, email, phone, country, post_code, address, order_number)
    VALUES ('$first_name', '$last_name', '$email', '$phone', '$country', '$post_code', '$address', '$order_number')";

    // Проверяем, удалось ли выполнить запрос
    if ($conn->query($sql) === TRUE) {
        // Если запрос выполнен успешно, возвращаем ответ с статусом "ок"
        echo "Ордер добавлен в базу данных";
        $sql = "UPDATE cart SET `order_id` = '$order_number' WHERE `user_id` = '$cook_id'  && `order_id` = 0;";
        if ($conn->query($sql) === TRUE) {
            echo "Значения успешно изменены.";
            $sql_notify = "SELECT DISTINCT s.USER_ID FROM `cart`c JOIN `products` p ON c.product_id = p.link JOIN `shop` s ON p.store_id = s.LINK_ID WHERE c.user_id = '$cook_id' && c.order_id = '$order_number';";
            $result_notify = $conn->query($sql_notify);

            if ($result_notify->num_rows > 0) {
                $mysql = new mysqli($Host, $User, $Password, $Database);
                while ($row = mysqli_fetch_assoc($result_notify)) {
                    // Делаем что-то с каждой записью
                    $user_id = $row['USER_ID'];
                    $mysql->query("INSERT INTO `notifications` (`user_id`, `text`, `href`, `data`) VALUES ('$user_id', '$new_order_notify', 'https://store.unesell.com', CURRENT_TIMESTAMP)");  
                }
            } else {
                // Обработка ситуации, когда нет результатов запроса
            }

            http_response_code(200);
        } else {
            echo "Ошибка: " . $sql . "<br>" . $conn->error;
            http_response_code(500);
        }
    } else {
        // Если произошла ошибка при выполнении запроса, возвращаем ответ с кодом ошибки
        http_response_code(500);
        echo "Ошибка: " . $sql . "<br>" . $conn->error;
    }

    // Закрываем соединение с базой данных
    $conn->close();
?>
