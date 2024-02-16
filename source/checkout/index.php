<?php
    //Loader data
    $cook_id = htmlspecialchars($_COOKIE["id"]);

    include "../config.php";

    $mysql = new mysqli($Host, $User, $Password, $Database);
    $mysql_shop = new mysqli($Host, $User_store, $Password_store, $Database_store);
    
    $result = $mysql->query("SELECT * FROM `accounts_users` WHERE `id` = '$cook_id'");
    $user = $result->fetch_assoc();

    //Из базы данных: $user['name'];

    if(strlen($cook_id) == 0){
        header("Location: /");
    }

    // Language setup
    if(htmlspecialchars($_COOKIE["lang"]) == "ua"){
        include "languages/ua.php";
    }elseif(htmlspecialchars($_COOKIE["lang"]) == "en"){
        include "languages/en.php";
    }else{
        include "languages/ua.php";
    }
    
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, "http://www.cbr.ru/scripts/XML_daily.asp?date_req=".date("d/m/Y"));
    curl_setopt($ch, CURLOPT_HEADER, 0); 
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);    
    curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 30);
    
    $result = curl_exec($ch);
    
    $xml = $result;
    $xml_obj = new SimpleXMLElement($xml);
    
    $xml = $xml_obj->xpath("//Valute[@ID='R01720']"); 
    $curs_rub = strval($xml[0]->Value) / strval($xml[0]->Nominal);  // получим курс руб

    $xml2 = $xml_obj->xpath("//Valute[@ID='R01235']"); 
    $curs_usd_rub = strval($xml2[0]->Value); // получим курс доллара
    $curs_usd = $curs_rub / $curs_usd_rub;

    $xml3 = $xml_obj->xpath("//Valute[@ID='R01239']"); 
    $curs_eur_rub = strval($xml3[0]->Value); // получим курс евро
    $curs_eur = $curs_rub / $curs_eur_rub;
?>

<!doctype html>
<html lang="ru">

<head>

    <!-- Basic Page Needs
    ================================================== -->
    <title> <?php echo $checkout_title; ?> </title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="<? echo $description ?>">
    <link rel="icon" href="../assets/images/favicon.png">

    <!-- CSS 
    ================================================== -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/flowbite/1.6.4/flowbite.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/tailwindcss@2.0.1/dist/tailwind.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-Zenh87qX5JnK2Jl0vWa8Ck2rdkQ2Bzep5IDxbcnCeuOxjzrPF/et3URy9Bv1WTRi" crossorigin="anonymous">
    
    <!-- Checkout CSS -->
    <link rel="stylesheet" href="https://nephos.cssninja.io/assets/css/main.css">

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

        <!-- sidebar -->
       <?php include '../component/sidebar.php'; ?>

       <!-- contents -->
       <div class="main_content">

            <!-- header -->
            <?php include '../component/header.php'; ?>


            <div class="main_content_inner">

                <div class="uk-grid mt-0">
                    <div class="uk-width-2-3@m fead-area uk-first-column" style="align-self: center;">
                        <h3 id="Title" class="no-mobile TextAnim font-extrabold text-gray-500 dark:text-gray-500 md:text-5xl lg:text-6xl m-2" style="font-size: 30px;"><span class="text-transparent bg-clip-text bg-gradient-to-r to-emerald-600 from-sky-400"><?echo $checkout_pc_title_1; ?></span> <?echo $checkout_pc_title_2; ?></h3>
                    </div>
                    <div class="uk-width-expand">
                        <div>
                            <div class="steps-wrapper w100 pt-3">
                                <ol class="step-list pl-0">
                                <li class="active" id="step_1"></li>
                                <li id="step_2"></li>
                                <li id="step_3"></li>
                                <li id="step_4"></li>
                                </ol>
                            </div>
                        </div>
                    </div>
                </div>

                <div id="error_order" style="display: none;" class="flex p-4 mb-4 text-sm text-red-800 rounded-lg bg-red-50 dark:bg-gray-800 dark:text-red-400" role="alert">
                    <svg aria-hidden="true" class="flex-shrink-0 inline w-5 h-5 mr-3" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"></path></svg>
                    <span class="sr-only">Info</span>
                    <div>
                        <span class="font-medium"><? echo $Order_Error; ?></span>
                    </div>
                </div>

                <div class="container_checkout p-2" style="z-index: 0; position: inherit;">
                    <div class="uk-grid" id="step_menu_1">

                        <div class="uk-width-2-3@m fead-area uk-first-column pt-4">
                            
                            <div class="w-full p-4 bg-white border border-gray-200 rounded-lg shadow sm:p-8 dark:bg-gray-800 dark:border-gray-700">
                                <div class="flex items-center justify-between">
                                    <h5 class="mb-4 text-xl font-medium text-gray-500 dark:text-gray-400"><? echo $title_card_product; ?></h5>
                                </div>
                                <div class="flow-root">
                                    <ul role="list" class="p-0 divide-y divide-gray-200 dark:divide-gray-700">

                                        <?php
                                        $cards = $mysql_shop->query("SELECT * FROM `cart` WHERE `user_id` = '$cook_id' && `order_id` = 0;");
                                        $product_id = Array();
                                        while($result = $cards->fetch_assoc()){
                                            $product_id[] = $result['product_id'];
                                        }

                                        $cards_num = 0;
                                        $not_cart = true;
                                        $all_price = 0;
                                        if(count($product_id) > 0){
                                            while($cards_num <= (count($product_id) - 1)){
                                                $p_id = $product_id[$cards_num];
                                                $temp = $mysql_shop->query("SELECT * FROM `products` WHERE `link` = '$p_id'");
                                                $data = $temp->fetch_assoc();
                                                $link = $data["link"];
                                                $t_name = $data["name"];
                                                $t_price = $data["price"];
                                                $id_stores = $data["store_id"];
                                                $all_price = $all_price + $t_price;
                                                $temp2 = $mysql_shop->query("SELECT * FROM `shop` WHERE `LINK_ID` = '$id_stores'");
                                                $data2 = $temp2->fetch_assoc();
                                                $id_stores = $data2["Name"];

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

                                                echo('
                                                    <li class="py-3 sm:py-4"> <a href="'.$path_product.'?id='.$link.'" id="'.$link.'">
                                                        <div class="flex items-center space-x-4">
                                                            <div class="card-img-product h55px">
                                                                <img src="'.$dns_store.'datafiles/post/'.$link.'/'.$first_file.'" class="img_fit" alt="">
                                                            </div>
                                                            <div class="flex-1 min-w-0">
                                                                <p class="m-0 font-medium text-gray-900 truncate dark:text-white">
                                                                    '.$t_name.'
                                                                </p>
                                                                <p class="m-0 text-sm text-gray-500 truncate dark:text-gray-400">
                                                                    '.$id_stores.'
                                                                </p>
                                                            </div>
                                                            <p class="m-0 text-blue-600">₴'.$t_price.'</p>
                                                        </div>
                                                    </a> </li>
                                                ');
                                                $cards_num = $cards_num + 1;
                                            }
                                            if($cards_num == 1 || $cards_num == 0){
                                                $onecards = "document.getElementById('preloader_cart').style.display = ''; document.getElementById('review_card').style.display = 'none';";
                                            }
                                        }else{
                                            $not_cart = false;
                                            echo('
                                                <div class="is-auto empty-cart-card">
                                                    <div class="empty-cart has-text-centered">
                                                        <img src="https://beesportal.online/shop/assets/images/icons/shop.svg" alt="" style="max-height: 250px; max-width: 250px;">
                                                        <h2 class="mt-4">'.$cart_clear.'</h2>
                                                        <small>'.$cart_clear_subtext.'</small>
                                                    </div>
                                                </div>   
                                            ');
                                        }
                                    ?>
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <div class="uk-width-expand pt-4">                        
                            <div class="w-full p-4 bg-white border border-gray-200 rounded-lg shadow sm:p-8 dark:bg-gray-800 dark:border-gray-700">
                                <h5 class="mb-4 text-xl font-medium text-gray-500 dark:text-gray-400"><?php echo $checkout_text_details; ?></h5>
                                <div class="flex items-center space-x-4">
                                    <div class="rounded-lg bg-gray-100 flex py-2 px-3" style="background: #e5e7eb;">
                                        <span class="text-indigo-400 mr-1 mt-1">₴</span>
                                        <span class="font-bold text-indigo-600 text-3xl"><? echo($all_price); ?></span>
                                    </div>
                                    <div class="flex-1">
                                        <p class="text-gray-400 text-sm m-0"><?php echo $Currency; ?></p>
                                        <p class="text-green-500 font-semibold">$<? echo round($all_price * $curs_usd, 2); ?> | €<? echo round($all_price * $curs_eur, 2); ?></p>
                                    </div>
                                </div>
                                <!-- List -->
                                <?php if($not_cart){ echo('<button onclick="user_details();" type="button" class="mt-4 w100 text-white bg-gradient-to-r from-cyan-500 to-blue-500 hover:bg-gradient-to-bl focus:ring-4 focus:outline-none focus:ring-cyan-300 dark:focus:ring-cyan-800 font-medium rounded-lg text-sm px-5 py-2.5 text-center mr-2 mb-2">'.$Create_Invoice.'</button>'); }?>
                            </div>
                        </div>
                    </div>

                    <div class="uk-grid mt-0 step_menu_hide" id="step_menu_2">

                        <div class="uk-width-2-3@m fead-area uk-first-column pt-4">  
                            <form>
                                <div class="flex items-center mb-4">
                                    <h6 class="text-lg font-bold dark:text-white m-0"><? echo $checkout_step2_title_1; ?></h6></br>
                                    <svg class="w-6 h-6 text-gray-400" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"></path></svg>
                                </div>
                                <div class="grid gap-6 mb-6 md:grid-cols-2">
                                    <div>
                                        <label for="first_name" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white"><? echo $checkout_data_1; ?></label>
                                        <input type="text" id="first_name" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="<? echo $checkout_data_1; ?>" required>
                                    </div>
                                    <div>
                                        <label for="last_name" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white"><? echo $checkout_data_2; ?></label>
                                        <input type="text" id="last_name" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="<? echo $checkout_data_2; ?>" required>
                                    </div>
                                    <div>
                                        <label for="email" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white"><? echo $checkout_data_3; ?></label>
                                        <input for="email" id="email" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="<? echo $checkout_data_3; ?>" required>
                                    </div>  
                                    <div>
                                        <label for="phone" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white"><? echo $checkout_data_4; ?></label>
                                        <input type="tel" id="phone" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="123-45-678" pattern="[0-9]{3}-[0-9]{2}-[0-9]{3}" required>
                                    </div>
                                </div>

                                <div class="flex items-center mb-4">
                                    <h6 class="text-lg font-bold dark:text-white m-0"><? echo $checkout_step2_title_2; ?></h6></br>
                                    <svg class="w-6 h-6 text-gray-400" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"></path></svg>
                                </div>
                                <div class="grid gap-6 mb-6 md:grid-cols-2">
                                    <div>
                                        <label for="country" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white"><? echo $checkout_data_5; ?></label>
                                        <input type="country" id="country" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="<? echo $checkout_data_5; ?>" required>
                                    </div>
                                    <div>
                                        <label for="post_code" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white"><? echo $checkout_data_7; ?></label>
                                        <input type="number" id="post_code" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="00000" required>
                                    </div>
                                </div>
                                <div class="mb-6">
                                    <label for="address" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white"><? echo $checkout_data_6; ?></label>
                                    <input type="address" id="address" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="<? echo $checkout_data_6; ?>" required>
                                </div>


                                <div class="flex items-start mb-6">
                                    <div class="flex items-center h-5">
                                    <input id="remember" type="checkbox" value="" class="w-4 h-4 border border-gray-300 rounded bg-gray-50 focus:ring-3 focus:ring-blue-300 dark:bg-gray-700 dark:border-gray-600 dark:focus:ring-blue-600 dark:ring-offset-gray-800" required>
                                    </div>
                                    <label for="remember" class="ml-2 text-sm font-medium text-gray-900 dark:text-gray-300"><? echo $rule_text_agree; ?> <a href="https://unesell.com/service/rule/" class="text-blue-600 hover:underline dark:text-blue-500"><? echo $rule_text; ?></a>.</label>
                                </div>
                            </form>


                        </div>
                        <div class="uk-width-expand pt-4">                        
                            <div class="w-full p-4 bg-white border border-gray-200 rounded-lg shadow sm:p-8 dark:bg-gray-800 dark:border-gray-700">
                                <h5 class="mb-4 text-xl font-medium text-gray-500 dark:text-gray-400"> Оформление на аккаунт </h5>
                                
                                <label class="font-medium text-gray-900 dark:text-gray-300" style="display: inline-flex;">
                                    <img src="https://unesell.com/data/users/avatar/<?php echo $user['avatar'];?>" style="width: 40px;height: 40px;border-radius: 25px;background: aliceblue;border: 2px solid #00bdff;">
                                    <div class="ml-3" style="display: inline;align-self: center;">
                                    <p   class="text-xs font-normal text-gray-500 dark:text-gray-300 m-0"><?php echo $Account_txt; ?></p>
                                    <div style="text-align: left;"><?php echo $user['name'];?></div>
                                    </div>
                                </label>

                                <!-- List -->
                                <button onclick="order_ganerate();" type="button" class="mt-4 w100 text-white bg-gradient-to-r from-cyan-500 to-blue-500 hover:bg-gradient-to-bl focus:ring-4 focus:outline-none focus:ring-cyan-300 dark:focus:ring-cyan-800 font-medium rounded-lg text-sm px-5 py-2.5 text-center mr-2 mb-2"> Продолжить оформление </button>
                                <p id="error_forms" style="display: none;" class="mt-2 text-sm text-red-600 dark:text-red-500"><span class="font-medium"><? echo $Error_order_form; ?></p>

                            </div>
                        </div>
                    </div>

                    <div class="uk-grid mt-0 w-100 step_menu_hide" id="step_menu_3">

                        <div class="uk-width-2-3@m fead-area uk-first-column pt-4">  
                            
                            <div class="w-full p-4 bg-white border border-gray-200 rounded-lg shadow sm:p-8 dark:bg-gray-800 dark:border-gray-700">
                                    <div class="flex items-center justify-between">
                                        <h5 class="mb-4 text-xl font-medium text-gray-500 dark:text-gray-400"><? echo $INVOICE_TXT; ?></h5>
                                    </div>
                                    
                                    <iframe id="order_document" src="" class="w-100" style="min-height: 400px; border-radius: 15px 15px 0px 0px;">
                                        Загрузка приложения не удалась.
                                    </iframe>

                                    <div class="w-full h-16 bg-white border-t border-gray-200 left-1/2 dark:bg-gray-700 dark:border-gray-600">
                                        <div class="grid h-full max-w-lg grid-cols-6 mx-auto">
                                            <button onclick="printOrder()" data-tooltip-target="tooltip-document" type="button" class="inline-flex flex-col items-center justify-center px-5 hover:bg-gray-50 dark:hover:bg-gray-800 group">
                                                <svg class="w-6 h-6 mb-1 text-gray-500 dark:text-gray-400 group-hover:text-blue-600 dark:group-hover:text-blue-500" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                                                    <path clip-rule="evenodd" fill-rule="evenodd" d="M6 2a2 2 0 00-2 2v12a2 2 0 002 2h8a2 2 0 002-2V7.414A2 2 0 0015.414 6L12 2.586A2 2 0 0010.586 2H6zm5 6a1 1 0 10-2 0v2H7a1 1 0 100 2h2v2a1 1 0 102 0v-2h2a1 1 0 100-2h-2V8z"></path>
                                                </svg>
                                                <span class="sr-only"> <? echo $Print; ?> </span>
                                            </button>
                                            <div id="tooltip-document" role="tooltip" class="absolute z-10 invisible inline-block px-3 py-2 text-sm font-medium text-white transition-opacity duration-300 bg-gray-900 rounded-lg shadow-sm opacity-0 tooltip dark:bg-gray-700">
                                                <? echo $Print; ?>
                                                <div class="tooltip-arrow" data-popper-arrow></div>
                                            </div>
                                            
                                            <button onclick="printPDF()" data-tooltip-target="tooltip-bookmark" type="button" class="inline-flex flex-col items-center justify-center px-5 hover:bg-gray-50 dark:hover:bg-gray-800 group">
                                                <svg class="w-6 h-6 mb-1 text-gray-500 dark:text-gray-400 group-hover:text-blue-600 dark:group-hover:text-blue-500" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                                                    <path d="M5 4a2 2 0 012-2h6a2 2 0 012 2v14l-5-2.5L5 18V4z"></path>
                                                </svg>
                                                <span class="sr-only"><? echo $SaveAsPDF; ?></span>
                                            </button>
                                            <div id="tooltip-bookmark" role="tooltip" class="absolute z-10 invisible inline-block px-3 py-2 text-sm font-medium text-white transition-opacity duration-300 bg-gray-900 rounded-lg shadow-sm opacity-0 tooltip dark:bg-gray-700">
                                            <? echo $SaveAsPDF; ?>
                                                <div class="tooltip-arrow" data-popper-arrow></div>
                                            </div>
                                        
                                            <div class="flex items-center justify-center col-span-2">
                                                <div class="p-1 flex items-center justify-between w-full text-gray-600 dark:text-gray-400 bg-gray-100 rounded-lg dark:bg-gray-600 max-w-[128px] mx-2">
                                                    <span class="flex-shrink-0 mx-2 text-sm font-medium" style="font-family: system-ui;"> <? echo $Order_txt; ?> <span id="order_id">0000000</span> </span>
                                                </div>
                                            </div>
                                                
                                            <div>
                                                <!-- Nothing -->
                                            </div>

                                        </div>
                                    </div>
                            </div>

                        </div>
                        <div class="uk-width-expand pt-4">                        
                            <div class="w-full p-4 bg-white border border-gray-200 rounded-lg shadow sm:p-8 dark:bg-gray-800 dark:border-gray-700">
                                <h5 class="mb-4 text-xl font-medium text-gray-500 dark:text-gray-400"> Оформление на аккаунт </h5>

                                <label class="font-medium text-gray-900 dark:text-gray-300" style="display: inline-flex;">
                                    <img src="https://unesell.com/data/users/avatar/<?php echo $user['avatar'];?>" style="width: 40px;height: 40px;border-radius: 25px;background: aliceblue;border: 2px solid #00bdff;">
                                    <div class="ml-3" style="display: inline;align-self: center;">
                                    <p   class="text-xs font-normal text-gray-500 dark:text-gray-300 m-0"><?php echo $Account_txt; ?></p>
                                    <div style="text-align: left;"><?php echo $user['name'];?></div>
                                    </div>
                                </label>

                                <!-- List -->
                                <button onclick="confirm_order();" type="button" class="mt-4 w100 text-white bg-gradient-to-r from-cyan-500 to-blue-500 hover:bg-gradient-to-bl focus:ring-4 focus:outline-none focus:ring-cyan-300 dark:focus:ring-cyan-800 font-medium rounded-lg text-sm px-5 py-2.5 text-center mr-2 mb-2"> Подтвердить заказ </button>
                            </div>
                        </div>
                    </div>
                    
                    <div id="step_menu_4_loading" style="display: none;">
                        <div class="preloader_cart" id="preloader_cart">
                            <svg class="cart" role="img" viewBox="0 0 128 128" width="128px" height="128px" xmlns="http://www.w3.org/2000/svg">
                                <g fill="none" stroke-linecap="round" stroke-linejoin="round" stroke-width="8">
                                    <g class="cart__track" stroke="hsla(0,10%,10%,0.1)">
                                        <polyline points="4,4 21,4 26,22 124,22 112,64 35,64 39,80 106,80" />
                                        <circle cx="43" cy="111" r="13" />
                                        <circle cx="102" cy="111" r="13" />
                                    </g>
                                    <g class="cart__lines" stroke="currentColor">
                                        <polyline class="cart__top" points="4,4 21,4 26,22 124,22 112,64 35,64 39,80 106,80" stroke-dasharray="338 338" stroke-dashoffset="-338" />
                                        <g class="cart__wheel1" transform="rotate(-90,43,111)">
                                            <circle class="cart__wheel-stroke" cx="43" cy="111" r="13" stroke-dasharray="81.68 81.68" stroke-dashoffset="81.68" />
                                        </g>
                                        <g class="cart__wheel2" transform="rotate(90,102,111)">
                                            <circle class="cart__wheel-stroke" cx="102" cy="111" r="13" stroke-dasharray="81.68 81.68" stroke-dashoffset="81.68" />
                                        </g>
                                    </g>
                                </g>
                            </svg>
                            <div class="preloader__text">
                                <p class="preloader__msg"> <?php echo $Loading_order_1 ?> </p>
                                <p class="preloader__msg preloader__msg--last"> <?php echo $Loading_order_2 ?> </p>
                            </div>
                        </div>
                    </div>

                    <div id="step_menu_4_compliate" style="display: none;">
                        <div class="preloader_cart" id="preloader_cart">
                            <img class="cart" src="../assets/images/icons/complete.svg" alt="">
                            <div class="preloader__text">
                                <h3 class="preloader__msg"> <?php echo $Order_compl_1 ?> </h3>
                                <p class="preloader__msg preloader__msg--last"> <?php echo $Order_compl_2 ?> </p>
                                <button onclick="document.location.href = '../profile/';" type="button" class="mt-3 text-white bg-blue-700 hover:bg-blue-800 focus:outline-none focus:ring-4 focus:ring-blue-300 font-medium rounded-full text-sm px-5 py-2.5 text-center mr-2 mb-2 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800"><?php echo $Order_compl_3 ?></button>
                            </div>
                        </div>
                    </div>

                </div>
            </div>

        </div>

        <div class="temp" id="temp" style="display: none;"></div>
        <a data-toggle="modal" data-target="#modal-default" id="openmoal" style="display: none;"></a>

        <?php include '../component/chat.php'; ?>
    </div>

     

    <!-- javaScripts 
    ================================================== -->
    <script src="js.js"></script>
    <script src="../assets/js/jquery-3.6.3.min.js"></script>
    <script src="../assets/js/dropzone.min.js"></script>
    <script src="../assets/js/js.cookie.js"></script>
    <script src="../assets/js/uikit.js"></script>
    <script src="../assets/js/simplebar.js"></script>
    <script src="../assets/js/main.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/flowbite/1.6.4/flowbite.min.js"></script>

</body>

</html>