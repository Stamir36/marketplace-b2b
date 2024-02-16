<?php
    //Loader data
    $cook_id = htmlspecialchars($_COOKIE["id"]);
    $id = htmlspecialchars($_GET["id"]);

    include "../config.php";

    $mysql = new mysqli($Host, $User, $Password, $Database);
    $mysql_shop = new mysqli($Host, $User_store, $Password_store, $Database_store);
    
    $result = $mysql->query("SELECT * FROM `accounts_users` WHERE `id` = '$cook_id'");
    $user = $result->fetch_assoc();

    $result = $mysql_shop->query("SELECT * FROM `products` WHERE `link` = '$id'");
    $product = $result->fetch_assoc();

    $store_id = $product['store_id'];
    $store = $mysql_shop->query("SELECT * FROM `shop` WHERE `LINK_ID` = '$store_id';");
    $store = $store->fetch_assoc();

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
    $curs = strval($xml[0]->Value) / strval($xml[0]->Nominal);

    $xml2 = $xml_obj->xpath("//Valute[@ID='R01235']"); 
    $curs_usd_rub = strval($xml2[0]->Value); // $
    $curs_usd = $curs / $curs_usd_rub;

    $xml3 = $xml_obj->xpath("//Valute[@ID='R01239']"); 
    $curs_eur_rub = strval($xml3[0]->Value); // Євро
    $curs_eur = $curs / $curs_eur_rub;
?>

<!doctype html>
<html lang="ru">

<head>

    <!-- Basic Page Needs
    ================================================== -->
    <title> <?php echo $Product_About." ".$product['name']; ?> </title>
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
    <!-- Тіло сторінки -->
    <div id="wrapper">
        <?php include '../component/gallary.php'; ?>

        <!-- sidebar -->
       <?php include '../component/sidebar.php'; ?>

       <!-- Головний контент сторінки -->
       <div class="main_content">

            <!-- header -->
            <?php include '../component/header.php'; ?>

            <div class="main_content_inner">

            <div class="antialiased">
                <div class="product_info">
                    <!-- Breadcrumbs -->
                    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                    <div class="flex items-center space-x-2 text-gray-400 text-sm">
                        <a href="../" class="hover:underline hover:text-gray-600"><?php echo $home_txt; ?></a>
                        <span>
                        <svg class="h-5 w-5 leading-none text-gray-300" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                        </svg>
                        </span>
                        <a href="../search/?category=<? echo $product['categories']; ?>" class="hover:underline hover:text-gray-600"><? echo $categories[$product['categories']]; ?></a>
                        <span>
                        <svg class="h-5 w-5 leading-none text-gray-300" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                        </svg>
                        </span>
                        <?php
                            $shortText = mb_substr($product['name'], 0, 15, "UTF-8");
                            if (mb_strlen($product['name'], "UTF-8") >= 15) {
                                $shortText .= "...";
                            }
                            echo "<span>".$shortText."</span>";
                        ?>
                        
                    </div>
                    </div>
                    <!-- ./ Breadcrumbs -->

                    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mt-6 p-not-mobile">
                    <div class="flex flex-col md:flex-row -mx-4">
                        <div class="md:flex-1 px-4">
                        <div x-data="{ image: 0 }" x-cloak>
                            <div class="h-64 md:h-80 rounded-lg bg-gray-100 mb-4">
                                <a uk-toggle="target: body ; cls: is-open" class="opts_icon img-zoom-btn m-3" uk-tooltip="title: <?php echo $IMG_ZOOM_txt; ?> ; pos: bottom ;offset:7" title="" aria-expanded="false">
                                    <i class="fa fa-search-plus fa-2" style="width: 20px;height: 20px;margin-left: 3px;"></i>
                                </a>
                                
                                <?php
                                    $img_post_link = "";
                                    $directory = "../datafiles/post/".$product['link']."/";    // Папка с изображениями
                                    $allowed_types=array("jpg", "jpeg", "png", "gif");  //разрешеные типы изображений
                                    $file_parts = array(); $ext=""; $title=""; $i=0;
                                    //пробуем открыть папку
                                    $dir_handle = @opendir($directory) or die("Ошибка при открытии папки !!!");
                                    while ($file = readdir($dir_handle))    //поиск по файлам
                                    {
                                        if($file=="." || $file == "..") continue;  //пропустить ссылки на другие папки
                                        $file_parts = explode(".",$file);          //разделить имя файла и поместить его в массив
                                        $ext = strtolower(array_pop($file_parts));   //последний элеменет - это расширение

                                        if(in_array($ext,$allowed_types)){
                                            if($i == 0){ $img_post_link = $product['link']."/".$file; }
                                            echo '
                                            <div x-show="image === '.$i.' " class="h-64 md:h-80 rounded-lg bg-gray-100 mb-4 flex items-center justify-center">
                                                <img src="'.$directory.'/'.$file.'" title="'.$file.'" class="product_main_img">
                                            </div>';
                                            $i++;
                                        }
                                    }
                                    echo('</div><div class="flex -mx-2 mb-4">');

                                    closedir($dir_handle);  //закрыть папку

                                    $file_parts = array(); $ext=""; $title=""; $i=0;
                                    //пробуем открыть папку
                                    $dir_handle = @opendir($directory) or die("Ошибка при открытии папки !!!");
                                    while ($file = readdir($dir_handle))    //поиск по файлам
                                    {
                                        if($file=="." || $file == "..") continue;  //пропустить ссылки на другие папки
                                        $file_parts = explode(".",$file);          //разделить имя файла и поместить его в массив
                                        $ext = strtolower(array_pop($file_parts));   //последний элеменет - это расширение

                                        if(in_array($ext,$allowed_types)){
                                            $temp = "{ 'ring-2 ring-indigo-300 ring-inset': image === ".$i." }";
                                            echo '
                                            <div class="flex-1 px-2">
                                                <button x-on:click="image = '.$i.' " :class="'.$temp.'" class="focus:outline-none w-full rounded-lg h-24 md:h-32 bg-gray-100 flex items-center justify-center">
                                                    <img src="'.$directory.'/'.$file.'" title="'.$file.'"  class="product_main_img">
                                                </button>
                                            </div>';
                                            $i++;
                                        }
                                    }

                                    closedir($dir_handle);  //закрыть папку
                                ?>

                            </div>
                        </div>
                        </div>
                        <div class="md:flex-1 px-4">
                        <h2 class="mb-2 leading-tight tracking-tight font-bold text-gray-800 text-2xl md:text-3xl"><?php echo $product['name']; ?></h2>
                        <p class="text-gray-500 text-sm"><? echo $Customers_txt; ?> <a href="../shop/?id=<? echo $store['LINK_ID']; ?>" class="text-indigo-600 hover:underline"><? echo $store['Name']; ?></a></p>

                        <div class="flex items-center mt-2.5 mb-3" style="margin-left: -3px;">
                            <?php
                                $rating = $product['Rating'];
                                $rating = round($rating * 2) / 2;

                                for ($i = 1; $i <= 5; $i++) {
                                    $starClass = ($rating >= $i) ? 'text-yellow-300' : 'text-gray-300 dark:text-gray-500';
                                    echo('<svg aria-hidden="true" class="w-5 h-5 ' . $starClass . '" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path></svg>');
                                }
                                echo('<span class="bg-blue-100 text-blue-800 text-xs font-semibold mr-2 px-2.5 py-0.5 rounded dark:bg-blue-200 dark:text-blue-800 ml-3">'.$product['Rating'].'</span>');
                            ?>
                        </div>

                        <div class="flex items-center space-x-4 my-4">
                            <div>
                            <div class="rounded-lg bg-gray-100 flex py-2 px-3" style="background: #e5e7eb;">
                                <span class="text-indigo-400 mr-1 mt-1">₴</span>
                                <span class="font-bold text-indigo-600 text-3xl"><?php if($product['price'] != 0){echo $product['price'];}else{ echo $free_txt; } ?></span>
                            </div>
                            </div>
                            <div class="flex-1">
                            <p class="text-gray-400 text-sm m-0"><?php echo $Currency; ?></p>
                            <p class="text-green-500 font-semibold">$<? echo round($product['price'] * $curs_usd, 2); ?> | €<? echo round($product['price'] * $curs_eur, 2); ?></p>
                            </div>
                        </div>

                        <p class="text-gray-500"><?php echo $product['description']; ?></p>

                        <div class="flex py-4 space-x-4">
                            <?php
                                $add = "block";
                                $del = "none";
                                $res = $mysql_shop->query("SELECT * FROM `cart` WHERE `product_id` = '$id' AND `user_id` = '$cook_id'  && `order_id` = 0;");
                                $row = $res->fetch_row();
                                if($row[0] > 0){
                                    $add = "none";
                                    $del = "block";
                                }
                            ?>
                            <button style="display: <? echo($add); ?>;" id="addcard" onclick="add_basket(<?php echo('`'.$id.'` , `'.$product['name'].'` , `'.$product['price'].'` , `'.$img_post_link.'`'); ?>);" type="button" class="h-14 px-6 py-2 font-semibold rounded-xl bg-indigo-600 hover:bg-indigo-500 text-white">
                                <i class="fa fa-cart-plus fa-2 mr-2" aria-hidden="true"></i>    
                                <?php echo $Add_to_Cart; ?>
                            </button>

                            <button style="display: <? echo($del); ?>;" onclick="delete_basket()" id="delcart" type="button" class="ml-0 h-14 px-6 py-2 font-semibold rounded-xl bg-yellow-600 hover:bg-yellow-500 text-white">
                                <i class="fa fa-trash fa-2 mr-2" aria-hidden="true"></i>    
                                <?php echo $Delete_from_Cart; ?>
                            </button>
                        </div>
                        </div>
                    </div>
                    </div>
                </div>
                </div>

                <!-- ABOUT PRODUCT -->
                <div class="section-small">

                    <div uk-grid="" class="uk-grid">

                        <div class="uk-width-expand ml-lg-2 uk-first-column">
                            <div class="sl_user-widget">
                                <div class="sl_user-widget-wrap-header pb-0">
                                    <div class="sl_user-widget-wrap-header-left">
                                        <h4> <?php echo $Feature; ?> </h4>
                                    </div>
                                </div>

                                <ul class="sl_right_user_info pt-2">
                                    <?php
                                        $arr = explode("//", $product['characteristics']);
                                        while ($elem = array_shift($arr)) {
                                            $parts = explode(":", $elem);
                                            $category = $parts[0];
                                            $value = $parts[1];

                                            echo('                                    
                                            <li class="list-group-item feature-fix">
                                                <span>'.$category.'</span>
                                                <hr class="feature_hr">
                                                <span class="nowrap">'.$value.'</span>
                                            </li>
                                            ');
                                        }
                                    ?>
                                </ul>
                            </div>
                        </div>

                        <div class="uk-width-2-3@m fead-area uk-first-column">
                            <div class="post">
                                <div class="post-heading">
                                    <h4 class="mb-0"> <?php echo $Review_Product; ?> </h4>
                                </div>
                                <div class="post-add-comment">
                                    <p><?php echo $Add_Review; ?></p>
                                </div>
    
                                <?
                                    $result = $mysql_shop->query("SELECT * FROM `comments` WHERE `product_id` = '$id'");

                                    // Проверка наличия комментариев
                                    if ($result->num_rows > 0) {
                                        while ($row = $result->fetch_assoc()) {
                                            // Получение информации о комментаторе
                                            $user_id_comm = $row['user_id'];
                                            $user_result = $mysql->query("SELECT * FROM `accounts_users` WHERE `id` = '$user_id_comm'");
                                            $commentator = $user_result->fetch_assoc();
                                            
                                            echo('
                                                <div class="post-comments">
                                                    <div class="post-comments-single">
                                                        <div class="post-comment-avatar">
                                                            <img src="https://unesell.com/data/users/avatar/'.$commentator['avatar'].'" alt="">
                                                        </div>
                                                        <div class="post-comment-text">
                                                            <div class="post-comment-text-inner">
                                                                <h6>'.$commentator['name'].'</h6>
                                                                <p>'.$row['comments'].'</p>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            ');
                                        }
                                    } else {
                                        echo "<p class='p-3 pt-0'>".$No_Comments."</p>";
                                    }

                                ?>

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
    <script>
          function add_basket(id, name, price, img){
            $.ajax({
                url: 'add_cart.php',
                type: 'POST',
                data:{product_id: "<?php echo($id);?>"},
                success: function(data) {
                    var list_cart = document.getElementById("list_cart");
                    document.getElementById("preloader_cart").style.display = "none";
                    document.getElementById("review_card").style.display = "contents";
                    let card = document.createElement('a');
                    card.href = "../product/?id=" + id;
                    card.id = "<?php echo($id);?>";
                    card.innerHTML = "<div class='contact-list'><div class='card-img-product'><img src='../datafiles/post/" + img + "' class='img_fit' alt=''></div><div class='ml-3'><h5 class='fsmall'>" + name + "</h5><p class='m-0 text-blue-600'>₴" + price + "</p></div></div>";
                    list_cart.append(card);
                    document.getElementById("delcart").style.display = "block"; 
                    document.getElementById("addcard").style.display = "none";
                    document.getElementById("cart_price").textContent =  Number(document.getElementById("cart_price").textContent) + Number(<?php echo $product['price']; ?>);
                }
            });
        }

        function delete_basket(){
            $.ajax({
                url: 'del_cart.php',
                type: 'POST',
                data:{product_id: "<?php echo($id);?>"},
                success: function(data) {
                    document.getElementById("<?php echo($id);?>").remove();
                    document.getElementById("delcart").style.display = "none";
                    document.getElementById("addcard").style.display = "block";
                    document.getElementById("cart_price").textContent =  Number(document.getElementById("cart_price").textContent) - Number(<?php echo $product['price']; ?>);
                    <?php echo($onecards);?>
                }
            });
        }
    </script>
    <script src="../assets/js/jquery-3.6.3.min.js"></script>
    <script src="../assets/js/dropzone.min.js"></script>
    <script src="../assets/js/js.cookie.js"></script>
    <script src="../assets/js/uikit.js"></script>
    <script src="../assets/js/simplebar.js"></script>
    <script src="../assets/js/main.js"></script>
    <script src='https://cdn.jsdelivr.net/gh/alpinejs/alpine@v2.7.3/dist/alpine.min.js'></script>
</body>

</html>