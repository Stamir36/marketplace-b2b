<?php
    //Loader data
    $cook_id = htmlspecialchars($_COOKIE["id"]);

    include "config.php";

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
    <title><?php echo $title ?></title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="<? echo $description ?>">
    <link rel="icon" href="assets/images/favicon.png">

    <!-- CSS 
    ================================================== -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/flowbite/1.6.4/flowbite.min.css" rel="stylesheet" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-Zenh87qX5JnK2Jl0vWa8Ck2rdkQ2Bzep5IDxbcnCeuOxjzrPF/et3URy9Bv1WTRi" crossorigin="anonymous">
    <link rel="stylesheet" href="assets/css/argon.css">
    <link rel="stylesheet" href="assets/css/style.css">
    <link rel="stylesheet" href="assets/css/uikit.css">
    <link rel="stylesheet" href="assets/css/components.css">
    <link rel="stylesheet" href="assets/css/text.css">

    <!-- icons
    ================================================== -->
    <link rel="stylesheet" href="assets/css/icons.css">

</head>

<body onload="loadScript()">    
    
    <div id="login-banner" class="banner_login fixed z-50 flex flex-col md:flex-row justify-between w-[calc(100%-2rem)] p-4 -translate-x-1/2 bg-white border border-gray-100 rounded-lg shadow-sm lg:max-w-7xl left-1/2 dark:bg-gray-700 dark:border-gray-600">
        <div class="flex flex-col items-start mb-3 mr-4 md:items-center md:flex-row md:mb-0" style="margin-top: 8px;">
            <a class="flex items-center mb-2 border-gray-200 md:pr-4 md:mr-4 md:border-r md:mb-0 dark:border-gray-600">
            <img src="assets/images/favicon.png" class="h-6 mr-2" alt="Flowbite Logo">
                <span class="self-center text-lg font-semibold whitespace-nowrap dark:text-white">uStore</span>
            </a>
        <p class="flex items-center text-sm font-normal text-gray-500 dark:text-gray-400"><?php echo $banner_first_text; ?></p>
        </div>
            <div class="flex items-center flex-shrink-0">
            <a class="px-5 py-2 mr-2 text-xs font-medium text-white bg-blue-700 rounded-lg hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 dark:bg-blue-600 dark:hover:bg-blue-700 focus:outline-none dark:focus:ring-blue-800" onclick="document.getElementById('login_btn').click();"><?php echo $logins; ?></a>
            <a href="https://unesell.com/service/rule/" class="px-5 py-2 mr-2 text-xs font-medium text-white bg-blue-700 rounded-lg hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 dark:bg-blue-600 dark:hover:bg-blue-700 focus:outline-none dark:focus:ring-blue-800"><?php echo $polisy_text; ?></a>
            <button style="position: unset;" data-dismiss-target="#marketing-banner" type="button" class="absolute top-2.5 right-2.5 md:relative md:top-auto md:right-auto flex-shrink-0 inline-flex justify-center items-center text-gray-400 hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm p-1.5 dark:hover:bg-gray-600 dark:hover:text-white" onclick="document.getElementById('login-banner').classList.remove('bunner_up_animation');">
                <svg aria-hidden="true" class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path></svg>
                <span class="sr-only">Закрыть баннер</span>
            </button>
        </div>
    </div>
        <!-- Wrapper -->
    <div id="wrapper">

        <!-- sidebar -->
       <?php
       
        include 'component/sidebar.php';
       
       ?>

       <!-- contents -->
       <div class="main_content">

            <!-- header -->
            <?php
            
            include 'component/header.php';
            
            ?>


            <div class="main_content_inner">


            
            <div class="section-small pt-0">
                <div class="uk-grid-match uk-grid" uk-grid="">
                    <div class=" w100 uk-first-column">
                            <div class="uk-background-cover rounded p-5 uk-light uk-flex uk-flex-middle" data-src="https://unesell.com/assets/img/background/Abstract.jpg" uk-img="">
                                <div class="uk-width-2-3@m">
                                    <h2 class="mb-0">uStore</h2>
                                    <h2 class="my-2"><? echo $m_text_banner_one; ?></h2>
                                    <p> <? echo $m_text_banner_two; ?> </p>
                                    <a href="categories/" class="button outline-white circle mt-4"> <? echo $lock_catalog; ?> </a>
                                </div>
                            </div>
                    </div>
                </div>
            </div>

            <div class="section-header">
                <div class="section-header-left">
                    <h3> <? echo $Categories; ?> </h3>
                    <p style="font-family: system-ui;"><? echo $Categories_info; ?></p>
                </div>
                <div class="section-header-right">
                    <a href="categories/" class="see-all"> <? echo $See_all; ?> </a>
                </div>
            </div>

            <div class="uk-position-relative uk-slider" uk-slider="finite: true">

                <div class="uk-slider-container pb-3">

                    <ul class="uk-slider-items uk-child-width-1-6@m uk-child-width-1-3@s uk-child-width-1-2 uk-grid-small uk-grid" style="transform: translate3d(0px, 0px, 0px);">

                        <li tabindex="-1" class="uk-active">
                            <a href="search/?category=grocery">
                                <div class="group-catagroy-card" style="background-image: url(&quot;assets/images/category/category_1.jpg&quot;);">
                                    <div class="group-catagroy-card-content">
                                        <h4> <?php echo $category_1;?> </h4>
                                    </div>
                                </div>
                            </a>
                        </li>

                        <li tabindex="-1" class="uk-active">
                            <a href="search/?category=clothing_accessories">
                                <div class="group-catagroy-card" style="background-image: url(&quot;assets/images/category/category_2.jpg&quot;);">
                                    <div class="group-catagroy-card-content">
                                        <h4> <?php echo $category_2;?> </h4>
                                    </div>
                                </div>
                            </a>
                        </li>

                        <li tabindex="-1" class="uk-active">
                            <a href="search/?category=electronics">
                                <div class="group-catagroy-card" style="background-image: url(&quot;assets/images/category/category_3.jpg&quot;);">
                                    <div class="group-catagroy-card-content">
                                        <h4> <?php echo $category_3;?> </h4>
                                    </div>
                                </div>
                            </a>
                        </li>

                        <li tabindex="-1" class="uk-active">
                            <a href="search/?category=pharmacy">
                                <div class="group-catagroy-card" style="background-image: url(&quot;assets/images/category/category_4.jpg&quot;);">
                                    <div class="group-catagroy-card-content">
                                        <h4> <?php echo $category_4;?> </h4>
                                    </div>
                                </div>
                            </a>
                        </li>

                        <li tabindex="-1" class="uk-active">
                            <a href="search/?category=hobbies">
                                <div class="group-catagroy-card" style="background-image: url(&quot;assets/images/category/category_5.jpg&quot;);">
                                    <div class="group-catagroy-card-content">
                                        <h4> <?php echo $category_5;?> </h4>
                                    </div>
                                </div>
                            </a>
                        </li>
                        
                        <li tabindex="-1" class="uk-active">
                            <a href="search/?category=ect">
                                <div class="group-catagroy-card" style="background-image: url(&quot;assets/images/category/category_6.jpg&quot;);">
                                    <div class="group-catagroy-card-content">
                                        <h4> <?php echo $category_6;?> </h4>
                                    </div>
                                </div>
                            </a>
                        </li>
                    </ul>
                </div>
            </div>

            <hr class="my-3 my-sm-2">

            <div uk-slider="finite: true" class="uk-slider uk-slider-container">

                <div class="grid-slider-header">
                    <div>
                        <h3> <? echo $Main_new_product; ?> </h3>
                    </div>
                    <div class="grid-slider-header-link">

                        <div class="section-header-right">
                            <a href="#" class="see-all"> <? echo $See_all; ?> </a>
                        </div>                        
                        <a href="#" class="slide-nav-prev uk-invisible" uk-slider-item="previous"></a>
                        <a href="#" class="slide-nav-next" uk-slider-item="next"></a>
                    </div>
                </div>

                <ul class="uk-slider-items uk-child-width-1-5@m uk-child-width-1-3@s uk-child-width-1-2 uk-grid-small uk-grid" style="transform: translate3d(0px, 0px, 0px);">
                    
                    <?php
                        $result_product = $mysql_shop->query("SELECT * FROM products ORDER BY `id` DESC LIMIT 30");
                        $link = Array();
                        $name = Array();
                        $price = Array();
                        $store_id = Array();


                        while($result = $result_product->fetch_assoc()){
                            $link[] = $result['link'];
                            $name[] = $result['name'];
                            $price[] = $result['price'];
                            $store_id[] = $result['store_id'];
                        }

                        $new_product_count = 0;

                        if(count($link) == count($name) && count($link) != 0 && count($name) != 0 ){
                            while($new_product_count <= (count($link) - 1)){
                                $path = 'datafiles/post/'.$link[$new_product_count].'/';
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
                                                    <a href="product/?id='.$link[$new_product_count].'">
                                                        <img src="datafiles/post/'.$link[$new_product_count].'/'.$first_image.'" alt="">
                                                    </a>
                                                </div>
                                                <div class="produc_info">
                                                    <div class="product-by">
                                                        <a href="shop/?id='.$store['LINK_ID'].'">'.$store['Name'].'</a>
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
                            echo("<a style='color: #db6724;cursor: default;text-align: center;margin: 60px;width: 100%; display: table-caption;height: 100%;margin-top: 80%;' id='none_notify'>".$none_product."</a>");
                        }
                    ?>

                </ul>

            </div>

            <hr class="my-3 my-sm-2">

            </div>

        </div>


        <?php
            
            include 'component/chat.php';
        
        ?>
    </div>

     

    <!-- javaScripts 
    ================================================== -->
    <script src="assets/js/jquery-3.6.3.min.js"></script>
    <script src="assets/js/js.cookie.js"></script>
    <script src="assets/js/uikit.js"></script>
    <script src="assets/js/simplebar.js"></script>
    <script src="assets/js/main.js"></script>
    <?php
        if(strlen($cook_id) == 0){
            echo('
            <script>
                function loadScript(){
                    document.getElementById("login-banner").classList.add("bunner_up_animation");
                }
            </script>
            ');
        }
    ?>
</body>

</html>