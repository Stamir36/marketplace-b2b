<?php
    //Loader data
    $cook_id = htmlspecialchars($_COOKIE["id"]);
    $id = htmlspecialchars($_GET["id"]);

    include "../config.php";

    $mysql = new mysqli($Host, $User, $Password, $Database);
    $mysql_shop = new mysqli($Host, $User_store, $Password_store, $Database_store);
    
    $result = $mysql->query("SELECT * FROM `accounts_users` WHERE `id` = '$cook_id'");
    $user = $result->fetch_assoc();

    // Language setup
    if(htmlspecialchars($_COOKIE["lang"]) == "ua"){
        include "languages/ua.php";
    }elseif(htmlspecialchars($_COOKIE["lang"]) == "en"){
        include "languages/en.php";
    }else{
        include "languages/ua.php";
    }
?>

<!doctype html>
<html lang="ru">

<head>

    <!-- Basic Page Needs
    ================================================== -->
    <title>uStore - <?php echo $my_page_txt; ?> </title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="<? echo $description ?>">
    <link rel="icon" href="../assets/images/favicon.png">

    <!-- CSS
    ================================================== -->
    <link rel='stylesheet' href='https://cdn.jsdelivr.net/npm/tailwindcss@2.0.1/dist/tailwind.min.css'>
    <link rel='stylesheet' href='https://fonts.googleapis.com/css2?family=Rubik:ital,wght@0,400;0,600;0,700;1,400&amp;display=swap'>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-Zenh87qX5JnK2Jl0vWa8Ck2rdkQ2Bzep5IDxbcnCeuOxjzrPF/et3URy9Bv1WTRi" crossorigin="anonymous">
    <link rel="stylesheet" href="../assets/css/argon.css">
    <link rel="stylesheet" href="../assets/css/style.css">
    <link rel="stylesheet" href="../assets/css/uikit.css">
    <link rel="stylesheet" href="../assets/css/components.css">
    <link rel="stylesheet" href="../assets/css/text.css">

    <!-- icons
    ================================================== -->
    <link rel="stylesheet" href="../assets/css/icons.css">

</head>

<body>
    <!-- Wrapper -->
    <div id="wrapper">
        <?php include '../component/gallary.php'; ?>

        <!-- sidebar -->
       <?php include '../component/sidebar.php'; ?>

       <!-- contents -->
       <div class="main_content">

            <!-- header -->
            <?php include '../component/header.php'; ?>

            <div id="myModal" class="hidden fixed inset-0 flex items-center justify-center z-50">
                <div class="fixed inset-0 bg-gray-900 opacity-50"></div>
                <div class="modal" style="display: contents;">
                    <div class="modal-content" style="max-width: 35rem;">
                    <div class="modal-header">
                        <h3 class="modal-title mt-2"><? echo $order_modal_send; ?></h3>
                        <button class="modal-close" data-modal-hide="modal"></button>
                    </div>
                    <div class="modal-body pt-2 pb-1">
                        <h6 class="text-muted mb-1 f-12"><? echo $Input_order_mail; ?></h6>
                        <input placeholder="<? echo $Input_order_mail_place; ?>" style="font-family: Unecoin;" name="mail" id="form_mail" class="form-control" onclick="document.getElementById('error_mail').style = 'display: none;';">
                        <p style="display: none;" id="error_mail" class="mt-2 m-0 text-sm text-red-600 dark:text-red-500" style="font-family: system-ui;"><span class="font-medium"><? echo $Validation_Error_txt; ?></span>.</p> 
                    </div>
                    <div class="modal-body pt-2 pb-1">
                        <h6 class="text-muted mb-1 f-12"><? echo $Input_order_post; ?></h6>
                        <input placeholder="<? echo $Input_order_post_place; ?>" style="font-family: Unecoin;" name="post" id="form_post" class="form-control" onclick="document.getElementById('error_post').style = 'display: none;';">
                        <p style="display: none;" id="error_post" class="mt-2 m-0 text-sm text-red-600 dark:text-red-500" style="font-family: system-ui;"><span class="font-medium"><? echo $Validation_Error_txt; ?></span>.</p> 
                    </div>
                    <div class="modal-footer">
                        <button onclick="sendData_send()" type="button" class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800"><? echo $Save_Data_txt; ?></button>
                        <button onclick="closeModal()" type="button" class="text-gray-500 bg-white hover:bg-gray-100 focus:ring-4 focus:outline-none focus:ring-blue-300 rounded-lg border border-gray-200 text-sm font-medium px-4 py-2.5 hover:text-gray-900 focus:z-10 dark:bg-gray-700 dark:text-gray-300 dark:border-gray-500 dark:hover:text-white dark:hover:bg-gray-600 dark:focus:ring-gray-600"><? echo $cloase_txt; ?></button>
                    </div>
                    </div>
                </div> 
            </div>

            <div id="ModalConfirm" class="hidden fixed inset-0 flex items-center justify-center z-50">
                <div class="fixed inset-0 bg-gray-900 opacity-50"></div>
                <div class="modal" style="display: contents;">
                    <div class="modal-content" style="max-width: 35rem;">
                    <div class="modal-header">
                        <h3 class="modal-title mt-2"><? echo $orders_action_received_btn; ?></h3>
                        <button class="modal-close" data-modal-hide="modal"></button>
                    </div>
                    <div class="modal-body pt-2 pb-1">
                        <h6 class="text-muted mb-1 f-12"><? echo $order_modal_received; ?></h6>
                    </div>
                    <div class="modal-footer">
                        <button onclick="sendData_received()" type="button" class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800"><? echo $confirm; ?></button>
                        <button onclick="closeModal2()" type="button" class="text-gray-500 bg-white hover:bg-gray-100 focus:ring-4 focus:outline-none focus:ring-blue-300 rounded-lg border border-gray-200 text-sm font-medium px-4 py-2.5 hover:text-gray-900 focus:z-10 dark:bg-gray-700 dark:text-gray-300 dark:border-gray-500 dark:hover:text-white dark:hover:bg-gray-600 dark:focus:ring-gray-600"><? echo $cloase_txt; ?></button>
                    </div>
                    </div>
                </div> 
            </div>

            <div id="ModalReview" class="hidden fixed inset-0 flex items-center justify-center z-50">
                <div class="fixed inset-0 bg-gray-900 opacity-50"></div>
                <div class="modal" style="display: contents;">
                    <div class="modal-content" style="max-width: 35rem;">
                    <div class="modal-header">
                        <h3 class="modal-title mt-2"><? echo $create_review; ?></h3>
                        <button class="modal-close" data-modal-hide="modal"></button>
                    </div>

                    <div class="modal-body pt-2 pb-1">
                        <h6 class="text-muted mb-1 f-12"><? echo $order_review_txt ?></h6>
                        <input placeholder="<? echo $create_review; ?>" style="font-family: Unecoin;" name="review" id="form_review" class="form-control" onclick="document.getElementById('error_mail').style = 'display: none;';">
                        <p style="display: none;" id="error_review" class="mt-2 m-0 text-sm text-red-600 dark:text-red-500" style="font-family: system-ui;"><span class="font-medium"><? echo $Validation_Error_txt; ?></span>.</p> 
                    </div>

                    <div class="modal-footer">
                        <button onclick="sendData_review()" type="button" class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800"><? echo $Save_Data_txt; ?></button>
                        <button onclick="closeModal_review()" type="button" class="text-gray-500 bg-white hover:bg-gray-100 focus:ring-4 focus:outline-none focus:ring-blue-300 rounded-lg border border-gray-200 text-sm font-medium px-4 py-2.5 hover:text-gray-900 focus:z-10 dark:bg-gray-700 dark:text-gray-300 dark:border-gray-500 dark:hover:text-white dark:hover:bg-gray-600 dark:focus:ring-gray-600"><? echo $cloase_txt; ?></button>
                    </div>
                    </div>
                </div> 
            </div>

            <div id="ModalInfo" class="hidden fixed inset-0 flex items-center justify-center z-50">
                <div class="fixed inset-0 bg-gray-900 opacity-50"></div>
                <div class="modal" style="display: contents;">
                    <div class="modal-content" style="max-width: 35rem;">
                    <div class="modal-header">
                        <h3 class="modal-title mt-2"><? echo $Order_txt_details; ?></h3>
                        <button class="modal-close" data-modal-hide="modal"></button>
                    </div>

                    <div class="modal-body pt-2 pb-1">

                        <div class="flex items-center mb-4">
                            <h6 class="text-lg font-bold dark:text-white m-0"><? echo $checkout_step2_title_1; ?></h6></br>
                            <svg class="w-6 h-6 text-gray-400" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"></path></svg>
                        </div>
                        <div class="grid gap-6 mb-6 md:grid-cols-2">
                            <div>
                                <h6 class="text-muted mb-1 f-12"><? echo $checkout_data_1 ?></h6>
                                <label id="first_name" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white"><? echo $Loading_Txt; ?></label>
                            </div>
                            <div>
                                <h6 class="text-muted mb-1 f-12"><? echo $checkout_data_2 ?></h6>
                                <label id="last_name" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white"><? echo $Loading_Txt; ?></label>
                            </div>
                            <div>
                                <h6 class="text-muted mb-1 f-12"><? echo $checkout_data_3 ?></h6>
                                <label id="email" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white"><? echo $Loading_Txt; ?></label>
                            </div>
                            <div>
                                <h6 class="text-muted mb-1 f-12"><? echo $checkout_data_4 ?></h6>
                                <label id="phone" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white"><? echo $Loading_Txt; ?></label>
                            </div>
                        </div>

                        <div class="flex items-center mb-4">
                            <h6 class="text-lg font-bold dark:text-white m-0"><? echo $checkout_step2_title_2; ?></h6></br>
                            <svg class="w-6 h-6 text-gray-400" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"></path></svg>
                        </div>
                        <div class="grid gap-6 mb-6 md:grid-cols-2">
                            <div>
                                <h6 class="text-muted mb-1 f-12"><? echo $checkout_data_5 ?></h6>
                                <label id="country" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white"><? echo $Loading_Txt; ?></label>
                            </div>
                            <div>
                                <h6 class="text-muted mb-1 f-12"><? echo $checkout_data_7 ?></h6>
                                <label id="post_code" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white"><? echo $Loading_Txt; ?></label>
                            </div>
                        </div>
                        <div>
                            <h6 class="text-muted mb-1 f-12"><? echo $checkout_data_6 ?></h6>
                            <label id="address" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white"><? echo $Loading_Txt; ?></label>
                        </div>
                    </div>

                    <div class="modal-footer">
                        <button onclick="SeeOrder()" type="button" class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800"><? echo $See_order_text; ?></button>
                        <button onclick="closeModal_Info()" type="button" class="text-gray-500 bg-white hover:bg-gray-100 focus:ring-4 focus:outline-none focus:ring-blue-300 rounded-lg border border-gray-200 text-sm font-medium px-4 py-2.5 hover:text-gray-900 focus:z-10 dark:bg-gray-700 dark:text-gray-300 dark:border-gray-500 dark:hover:text-white dark:hover:bg-gray-600 dark:focus:ring-gray-600"><? echo $cloase_txt; ?></button>
                    </div>
                    </div>
                </div> 
            </div>

            <div class="main_content_inner">
                <div class="uk-grid mt-0">
                    <div class="uk-width-2-3@m fead-area uk-first-column" style="align-self: center;">
                        <h3 id="Title" class="TextAnim font-extrabold text-gray-500 dark:text-gray-500 md:text-5xl lg:text-6xl m-2" style="font-size: 30px;"> <mark class="px-2 text-white bg-blue-600 rounded dark:bg-blue-500"><?echo $order_title_one; ?></mark> <?echo $order_title_two; ?></h3>
                    </div>
                </div>

                <!-- Заказчик -->
                <div class="m-3">
                    <div class="flex items-center">
                        <h6 class="text-lg font-bold dark:text-white m-0"><? echo $ToMeOrders; ?></h6><br>
                        <svg class="w-6 h-6 text-gray-400" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"></path></svg>
                    </div>
                    <div class="bg-white shadow-md rounded mt-3">
                        <table class="table-auto">
                            <thead>
                                <tr class="bg-gray-200 text-gray-600 uppercase text-sm leading-normal">
                                    <th class="py-3 px-6 text-left"><? echo $orders_table_1; ?></th>
                                    <th class="py-3 px-6 text-left"><? echo $orders_table_2; ?></th>
                                    <th class="py-3 px-6 text-left"><? echo $orders_table_3; ?></th>
                                    <th class="py-3 px-6 text-left"><? echo $orders_table_4; ?></th>
                                    <th class="py-3 px-6 text-left"><? echo $orders_table_5; ?></th>
                                    <th class="py-3 px-6 text-left"><? echo $orders_table_6; ?></th>
                                </tr>
                            </thead>
                            <tbody class="text-gray-600 text-sm font-light">
                            <?php
                                $order_c = $mysql_shop->query("SELECT * FROM `cart` WHERE `user_id` = '$cook_id' && `order_id` != 0;");
                                $product_id = Array();
                                while($result = $order_c->fetch_assoc()){
                                    $product_id[] = $result['product_id'];
                                }

                                $order_c_num = 0;
                                $not_cart = true;
                                $all_price = 0;
                                if(count($product_id) > 0){
                                    while($order_c_num <= (count($product_id) - 1)){
                                        $p_id = $product_id[$order_c_num];
                                        $temp = $mysql_shop->query("SELECT * FROM `products` WHERE `link` = '$p_id'");
                                        $data = $temp->fetch_assoc();
                                        $link = $data["link"];
                                        $t_name = $data["name"];
                                        $t_price = $data["price"];
                                        $all_price = $all_price + $t_price;

                                        // Определяем абсолютный путь к папке "datafiles"
                                        if($dns == "localhost" && $dns_local_root == true){
                                            $base_path = $_SERVER['DOCUMENT_ROOT'] . '/app/store/datafiles';
                                            $path_product = parse_url($_SERVER['HTTP_HOST'], PHP_URL_HOST).'/app/store/product/';
                                            $checkout = parse_url($_SERVER['HTTP_HOST'], PHP_URL_HOST).'/app/store/checkout/';
                                        }else{
                                            $base_path = $_SERVER['DOCUMENT_ROOT'] . '/datafiles';
                                            $path_product = parse_url($_SERVER['HTTP_HOST'], PHP_URL_HOST).'/product/';
                                            $checkout = parse_url($_SERVER['HTTP_HOST'], PHP_URL_HOST).'/checkout/';
                                        }
                                    
                                        // Путь к папке, содержащей нужный файл, относительно папки "datafiles"
                                        $sub_path = 'post/' . $link;
                                        // Полный путь к нужному файлу
                                        $file_path = $base_path . '/' . $sub_path;
                                        // Получаем список файлов в папке
                                        $files = scandir($file_path);
                                        $files = array_filter($files, function($file) {
                                            return !in_array($file, array(".", ".."));
                                        });
                                        // Сортируем файлы по имени
                                        sort($files);
                                        // Получаем имя первого файла
                                        $first_file = reset($files);

                                        $order = $mysql_shop->query("SELECT * FROM `cart` WHERE `user_id` = '$cook_id' && `product_id` = '$link';");
                                        $order = $order->fetch_assoc();

                                        $Mail = $order["Mail"];
                                        $Tracking = $order["Tracking"];

                                        if($Mail == "null"){ $Mail = $mail_no_send; }
                                        if($Tracking == "null"){ $Tracking = $mail_no_send; }

                                        $status_order = $order["order_id"];
                                        $orders = $mysql_shop->query("SELECT * FROM `orders` WHERE `order_number` = '$status_order';");
                                        $orders = $orders->fetch_assoc();
                                        
                                        if($orders['status'] == "wait" && $order["Received"] == "No"){
                                            $action = $order_status_start;
                                        }elseif($orders['status'] == "send" && $order["Received"] == "No"){
                                            $action = '<button onclick="product_confirm(`'.$order["order_id"].'`, `'.$order["id"].'`)" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">'.$orders_action_received_btn.'</button>';
                                        }elseif($order["Received"] == "Yes"){
                                            $action = $orders_action_received;
                                        }else{
                                            $action = "Error order";
                                        }

                                        echo('
                                            <tr class="border-b border-gray-200 hover:bg-gray-100" onclick="product_info(`'.$order["order_id"].'`)" style="cursor: pointer;">
                                                <td class="py-3 px-6 text-left">
                                                    <img src="'.$dns_store.'datafiles/post/'.$link.'/'.$first_file.'" alt="" class="w-full" style="height: 40px;border-radius: 5px;margin-right: 13px;max-width: 70px;object-fit: cover;">
                                                </td>
                                                <td class="py-3 px-6 text-left">'.$t_name.'</td>
                                                <td class="py-3 px-6 text-left">'.$order["order_id"].'</td>
                                                <td class="py-3 px-6 text-left">'.$Mail.'</td>
                                                <td class="py-3 px-6 text-left">'.$Tracking.'</td>
                                                <td class="py-3 px-6 text-left">
                                                    '.$action);
                                                    if($order["Received"] == "Yes" && $order["review"] == "no"){
                                                        echo('
                                                            <button type="button" onclick="product_review(`'.$order["order_id"].'`, `'.$order["id"].'`, `'.$order["product_id"].'`)" class="w-full text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium text-sm px-5 py-2.5 mt-2 dark:bg-blue-600 dark:hover:bg-blue-700 focus:outline-none dark:focus:ring-blue-800">'.$create_review.'</button>
                                                        ');
                                                    }
                                                echo('</td>
                                            </tr>
                                        ');
                                        $order_c_num = $order_c_num + 1;
                                    }
                                    if($order_c_num == 1 || $order_c_num == 0){
                                        $oneorder_c = "document.getElementById('preloader_cart').style.display = ''; document.getElementById('review_card').style.display = 'none';";
                                    }
                                }else{
                                    $not_cart = false;
                                }
                            ?>

                            </tbody>
                        </table>
                    </div>
                </div>

                <!-- Отправитель -->
                <div class="m-3 mt-5">
                    <div class="flex items-center">
                        <h6 class="text-lg font-bold dark:text-white m-0"><? echo $FromMeOrders; ?></h6><br>
                        <svg class="w-6 h-6 text-gray-400" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"></path></svg>
                    </div>
                    <div class="bg-white shadow-md rounded mt-3">
                        <table class="table-auto">
                            <thead>
                                <tr class="bg-gray-200 text-gray-600 uppercase text-sm leading-normal">
                                    <th class="py-3 px-6 text-left"><? echo $orders_table_1; ?></th>
                                    <th class="py-3 px-6 text-left"><? echo $orders_table_2; ?></th>
                                    <th class="py-3 px-6 text-left"><? echo $orders_table_3; ?></th>
                                    <th class="py-3 px-6 text-left"><? echo $orders_table_4; ?></th>
                                    <th class="py-3 px-6 text-left"><? echo $orders_table_5; ?></th>
                                    <th class="py-3 px-6 text-left"><? echo $orders_table_6; ?></th>
                                </tr>
                            </thead>
                            <tbody class="text-gray-600 text-sm font-light">
                            <?php
                                // Получение магазинов продавца
                                $shopQuery = $mysql_shop->query("SELECT * FROM `shop` WHERE `USER_ID` = '$cook_id';");

                                while ($shop = $shopQuery->fetch_assoc()) {
                                    $store_id = $shop['LINK_ID'];

                                    // Получение всех товаров, заказанных у данного магазина
                                    $orderQuery = $mysql_shop->query("SELECT * FROM `cart` WHERE `product_id` IN (
                                        SELECT `link` FROM `products` WHERE `store_id` = '$store_id'
                                    ) AND `cart`.`order_id` != 0;");

                                    while ($order = $orderQuery->fetch_assoc()) {
                                        $product_id = $order['product_id'];

                                        // Получение информации о товаре
                                        $productQuery = $mysql_shop->query("SELECT * FROM `products` WHERE `link` = '$product_id';");
                                        $product = $productQuery->fetch_assoc();

                                        $link = $product['link'];
                                        $name = $product['name'];
                                        $price = $product['price'];

                                        // Определяем абсолютный путь к папке "datafiles"
                                        if($dns == "localhost" && $dns_local_root == true){
                                            $base_path = $_SERVER['DOCUMENT_ROOT'] . '/app/store/datafiles';
                                            $path_product = parse_url($_SERVER['HTTP_HOST'], PHP_URL_HOST).'/app/store/product/';
                                            $checkout = parse_url($_SERVER['HTTP_HOST'], PHP_URL_HOST).'/app/store/checkout/';
                                        }else{
                                            $base_path = $_SERVER['DOCUMENT_ROOT'] . '/datafiles';
                                            $path_product = parse_url($_SERVER['HTTP_HOST'], PHP_URL_HOST).'/product/';
                                            $checkout = parse_url($_SERVER['HTTP_HOST'], PHP_URL_HOST).'/checkout/';
                                        }
                                    
                                        // Путь к папке, содержащей нужный файл, относительно папки "datafiles"
                                        $sub_path = 'post/' . $link;
                                        // Полный путь к нужному файлу
                                        $file_path = $base_path . '/' . $sub_path;
                                        // Получаем список файлов в папке
                                        $files = scandir($file_path);
                                        $files = array_filter($files, function($file) {
                                            return !in_array($file, array(".", ".."));
                                        });
                                        // Сортируем файлы по имени
                                        sort($files);
                                        // Получаем имя первого файла
                                        $first_file = reset($files);

                                        $order = $mysql_shop->query("SELECT * FROM `cart` WHERE `product_id` = '$link';");
                                        $order = $order->fetch_assoc();

                                        $Mail = $order["Mail"];
                                        $Tracking = $order["Tracking"];

                                        if($Mail == "null"){ $Mail = $mail_no_send; }
                                        if($Tracking == "null"){ $Tracking = $mail_no_send; }

                                        $status_order = $order["order_id"];
                                        $orders = $mysql_shop->query("SELECT * FROM `orders` WHERE `order_number` = '$status_order';");
                                        $orders = $orders->fetch_assoc();
                                        // complete
                                        if($orders['status'] == "wait"  && $order["Received"] == "No"){
                                            $action2 = '<button onclick="product_send(`'.$order["order_id"].'`)" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">'.$orders_action_send.'</button>';
                                        }elseif($orders['status'] == "send" && $order["Received"] == "No"){
                                            $action2 = $orders_action_send;
                                        }elseif($order["Received"] == "Yes" || $orders['status'] == "complete"){
                                            $action2 = $orders_action_received;
                                        }else{
                                            $action2 = "Error Order";
                                        }

                                        echo('
                                            <tr class="border-b border-gray-200 hover:bg-gray-100" onclick="product_info(`'.$order["order_id"].'`)" style="cursor: pointer;">
                                                <td class="py-3 px-6 text-left">
                                                    <img src="'.$dns_store.'datafiles/post/'.$link.'/'.$first_file.'" alt="" class="w-full" style="height: 40px;border-radius: 5px;margin-right: 13px;max-width: 70px;object-fit: cover;">
                                                </td>
                                                <td class="py-3 px-6 text-left">'.$name.'</td>
                                                <td class="py-3 px-6 text-left">'.$order["order_id"].'</td>
                                                <td class="py-3 px-6 text-left">'.$Mail.'</td>
                                                <td class="py-3 px-6 text-left">'.$Tracking.'</td>
                                                <td class="py-3 px-6 text-left">
                                                    '.$action2.'
                                                </td>
                                            </tr>
                                        ');
                                    }
                                }
                                ?>
                            </tbody>
                        </table>
                    </div>
                </div>
                
            </div>

        </div>

        <div class="temp" id="temp" style="display: none;"></div>
        <a data-toggle="modal" data-target="#modal-default" id="openmoal" style="display: none;"></a>

        <?php include '../component/chat.php'; ?>
    </div>
    <script>
        var selected_order = "";
        var id_card_product = "";
        var id_product = "";
        var order_get = "";

        function SeeOrder(){
            var url = "../checkout/order/";
            var newWindow = window.open(url + order_get, '', 'height=720,width=1280');

            if (newWindow) {
                newWindow.onload = function() {
                    newWindow.clear_get();
                };
            }
        }

        function product_info(orderId) {
            var modal = document.getElementById('ModalInfo');
            modal.classList.add('block');
            modal.classList.remove('hidden');
            selected_order = orderId;
            $.ajax({
                url: 'order_info.php',
                type: 'POST',
                data: { order: orderId },
                dataType: 'json',
                success: function(response) {
                    // Виводимо значення на екран
                    $("#order_number").text(response.order_number);
                    $("#first_name").text(response.first_name);
                    $("#last_name").text(response.last_name);
                    $("#email").text(response.email);
                    $("#phone").text(response.phone);
                    $("#country").text(response.country);
                    $("#post_code").text(response.post_code);
                    $("#address").text(response.address);
                    order_get = "?card=no&order=" + orderId + "&name=" + response.first_name + " " + response.last_name + "&email=" + response.email + "&street1=" + response.address + "&street2=" + response.post_code + " " + response.country;
                }
            });
        }

        function product_send(orderId) {
            var modal = document.getElementById('myModal');
            modal.classList.add('block');
            modal.classList.remove('hidden');
            selected_order = orderId;
        }

        function product_confirm(orderId, id_card) {
            var modal = document.getElementById('ModalConfirm');
            modal.classList.add('block');
            modal.classList.remove('hidden');
            selected_order = orderId;
            id_card_product = id_card;
        }

        function product_review(orderId, id_card, product) {
            var modal = document.getElementById('ModalReview');
            modal.classList.add('block');
            modal.classList.remove('hidden');
            selected_order = orderId;
            id_card_product = id_card;
            id_product = product;
        }

        function closeModal_review(){
            var modal = document.getElementById('ModalReview');
            modal.classList.remove('block');
            modal.classList.add('hidden');
        }

        function closeModal(){
            var modal = document.getElementById('myModal');
            modal.classList.remove('block');
            modal.classList.add('hidden');
        }

        function closeModal2(){
            var modal = document.getElementById('ModalConfirm');
            modal.classList.remove('block');
            modal.classList.add('hidden');
        }
        
        function closeModal_Info(){
            var modal = document.getElementById('ModalInfo');
            modal.classList.remove('block');
            modal.classList.add('hidden');
        }

        function sendData_review(){
            const mailreview = document.getElementById('form_review');
            const errorreview = document.getElementById('error_review');
            if (mailreview.value.trim() === '') {
                errorreview.style.display = 'block';
                return;
            }

            const formData = new FormData();
            formData.append('order', selected_order);
            formData.append('card_id', id_card_product);
            formData.append('user_id', "<? echo $cook_id; ?>");
            formData.append('review', mailreview.value.trim());
            formData.append('id_product', id_product);

            fetch('new_review.php', {
                method: 'POST',
                body: formData
            })
            .then(response => response.text())
            .then(data => {
                document.location.reload();
            })
            .catch(error => {
                console.error(error);
            });
        }

        function sendData_received(){
            const formData = new FormData();
            formData.append('order', selected_order);
            formData.append('card_id', id_card_product);

            fetch('compleate_order.php', {
                method: 'POST',
                body: formData
            })
            .then(response => response.text())
            .then(data => {
                document.location.reload();
            })
            .catch(error => {
                console.error(error);
            });
        }

        function sendData_send() {
            const mailInput = document.getElementById('form_mail');
            const postInput = document.getElementById('form_post');
            const errorMail = document.getElementById('error_mail');
            const errorPost = document.getElementById('error_post');
            
            if (mailInput.value.trim() === '') {
                errorMail.style.display = 'block';
                return;
            }
            
            if (postInput.value.trim() === '') {
                errorPost.style.display = 'block';
                return;
            }
            
            const formData = new FormData();
            formData.append('mail', mailInput.value.trim());
            formData.append('post', postInput.value.trim());
            formData.append('order', selected_order);

            fetch('update_send_order.php', {
                method: 'POST',
                body: formData
            })
            .then(response => response.text())
            .then(data => {
                document.location.reload();
            })
            .catch(error => {
                console.error(error);
            });
        }
    </script>
    <!-- javaScripts 
    ================================================== -->
    <script src="../assets/js/jquery-3.6.3.min.js"></script>
    <script src="../assets/js/dropzone.min.js"></script>
    <script src="../assets/js/js.cookie.js"></script>
    <script src="../assets/js/uikit.js"></script>
    <script src="../assets/js/simplebar.js"></script>
    <script src="../assets/js/main.js"></script>
    <script src='https://cdn.jsdelivr.net/gh/alpinejs/alpine@v2.7.3/dist/alpine.min.js'></script>
</body>

</html>