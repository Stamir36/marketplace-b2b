<?php
    //Loader data
    $cook_id = htmlspecialchars($_COOKIE["id"]);

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

    $category = isset($_GET["category"]) ? htmlspecialchars($_GET["category"]) : null;
    $q = isset($_GET["q"]) ? htmlspecialchars($_GET["q"]) : null;
    
    $search_query = "SELECT * FROM products";
    $search_txt = "";

    $categoryLabel = '';

    if (array_key_exists($category, $categories)) {
        $categoryLabel = $categories[$category];
    } elseif (array_key_exists($category, $categoriesAPP)) {
        $categoryLabel = $categoriesAPP[$category];
    }

    if ($category && $q) {
      $search_query .= " WHERE `categories` = '$category' AND `name` LIKE '%$q%'";
      $search_txt = $s_c_txt." ".$categoryLabel." ".$s_q_txt." ".$q;
    } elseif ($category) {
      $search_query .= " WHERE `categories` = '$category'";
      $search_txt = $s_c_txt." ".$categoryLabel;
    } elseif ($q) {
      $search_query .= " WHERE `name` LIKE '%$q%'";
      $search_txt = $s_q_txt." ".$q;
    }
    
    $search_query .= " ORDER BY `id` DESC LIMIT 100";

    $search_query = $mysql_shop->query($search_query);
?>

<!doctype html>
<html lang="ru">

<head>

    <!-- Basic Page Needs
    ================================================== -->
    <title>uStore - <?php echo $catalog_search_txt; ?> </title>
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


            <div class="main_content_inner">
                <div class="uk-width-2-3@m fead-area uk-first-column" style="align-self: center;">
                    <h3 id="Title" class="TextAnim font-extrabold text-gray-500 dark:text-gray-500 md:text-5xl lg:text-6xl m-2" style="font-size: 30px;"><?echo $catalog_search_txt; ?></h3>
                    <p class="m-2"><? echo $search_txt; ?></p>
                </div>

                <div class="p-2">
                    <div class="uk-position-relative mt-4 uk-slider" uk-slider="finite: true">
                        <div class="uk-slider-container pb-3">
                            <ul class="uk-child-width-1-5@m uk-child-width-1-3@s uk-child-width-1-2 uk-grid-small uk-grid">
                            <?php
                                $link = Array();
                                $name = Array();
                                $price = Array();
                                $store_id = Array();


                                while($result = $search_query->fetch_assoc()){
                                    $link[] = $result['link'];
                                    $name[] = $result['name'];
                                    $price[] = $result['price'];
                                    $store_id[] = $result['store_id'];
                                }

                                $new_product_count = 0;

                                if(count($link) == count($name) && count($link) != 0 && count($name) != 0 ){
                                    while($new_product_count <= (count($link) - 1)){
                                        $path = '../datafiles/post/'.$link[$new_product_count].'/';
                                        $files = scandir($path);
                                        $image_files = array_filter($files, function($file) {
                                            return preg_match('/\.(jpg|jpeg|png|gif)$/', $file);
                                        });
                                        $first_image = reset($image_files);
                                        $store = $mysql_shop->query("SELECT * FROM `shop` WHERE `LINK_ID` = '$store_id[$new_product_count]';");
                                        $store = $store->fetch_assoc();
                                        echo('
                                            <li tabindex="-1" class="uk-active">
                                                <div class="product">
                                                    <div class="product_info">
                                                        <div class="product-image">
                                                            <a href="../product/?id='.$link[$new_product_count].'">
                                                                <img src="../datafiles/post/'.$link[$new_product_count].'/'.$first_image.'" alt="">
                                                            </a>
                                                        </div>
                                                        <div class="produc_info">
                                                            <div class="product-by">
                                                                <a href="../shop/?id='.$store['LINK_ID'].'">'.$store['Name'].'</a>
                                                            </div>
                                                            <div class="product-title">
                                                                <a href="product/?id='.$link[$new_product_count].'">'.$name[$new_product_count].'</a>
                                                            </div>
                                                            <div class="product-price"><smal class="card_price_curret">₴</smal>'.$price[$new_product_count].'</div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </li>
                                        ');
                                        $new_product_count = $new_product_count + 1;
                                    }
                                }else{
                                    echo('
                                    <div class="w-100 text-center pt-4">
                                        <ul role="list" class="p-0 divide-y divide-gray-200 dark:divide-gray-700">
                                            <div class="is-auto empty-cart-card">
                                                <div class="empty-cart has-text-centered">
                                                    <img src="https://beesportal.online/shop/assets/images/icons/shop.svg" alt="" style="margin: auto; max-height: 250px; max-width: 250px;">
                                                    <h2 class="mt-4">'.$search_none_1_txt.'</h2>
                                                    <small>'.$search_none_2_txt.'</small>
                                                </div>
                                            </div>   
                                        </ul>
                                    </div>
                                    ');
                                }
                            ?>

                            </ul>
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
    <script src="../assets/js/jquery-3.6.3.min.js"></script>
    <script src="../assets/js/dropzone.min.js"></script>
    <script src="../assets/js/js.cookie.js"></script>
    <script src="../assets/js/uikit.js"></script>
    <script src="../assets/js/simplebar.js"></script>
    <script src="../assets/js/main.js"></script>
    <script src='https://cdn.jsdelivr.net/gh/alpinejs/alpine@v2.7.3/dist/alpine.min.js'></script>
</body>

</html>