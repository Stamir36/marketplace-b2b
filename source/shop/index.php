<?php
    //Loader data
    $cook_id = htmlspecialchars($_COOKIE["id"]);
    $link_id = htmlspecialchars($_GET["id"]);

    include "../config.php";

    $mysql = new mysqli($Host, $User, $Password, $Database);
    $mysql_shop = new mysqli($Host, $User_store, $Password_store, $Database_store);
    
    $result = $mysql->query("SELECT * FROM `accounts_users` WHERE `id` = '$cook_id'");
    $user = $result->fetch_assoc();

    $store = $mysql_shop->query("SELECT * FROM `shop` WHERE `LINK_ID` = '$link_id';");
    $store = $store->fetch_assoc();
    
    //Из базы данных: $user['name'];

    // Language setup
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
    <title> <?php echo $title_product; ?> </title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="<? echo $description ?>">
    <link rel="icon" href="../assets/images/favicon.png">

    <!-- CSS 
    ================================================== -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/flowbite/1.6.4/flowbite.min.css" rel="stylesheet" />

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

        <!-- sidebar -->
       <?php include '../component/sidebar.php'; ?>

       <!-- contents -->
       <div class="main_content">

            <!-- header -->
            <?php include '../component/header.php'; ?>


            <div class="main_content_inner">

                <div class="uk-background-cover rounded p-5 uk-light uk-flex uk-flex-middle" uk-img="" style="background-image: url(&quot;https://images.unsplash.com/photo-1550684376-efcbd6e3f031?ixlib=rb-4.0.3&ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&auto=format&fit=crop&w=1770&q=80&quot;);">
                    <div class="uk-width-2-3@m">
                        <div class="row mt-5">
                            <div class="w-auto">
                                <div class="profile-image" style="width: 60px; border-radius: 100%; height: 60px;">
                                    <img class="shop-icon" src='<? echo $dns_store; ?>datafiles/store/<?php echo $store['Icon']; ?>' alt="">
                                </div>
                            </div>
                            <div class="w-auto">
                                <p class="TextAnim m-0"> <?php if($store['Type'] == "0"){ echo $shop_text_b; }else{ echo $shop_text_u; }?></p>
                                <h1 class="TextAnim"> <?php echo $store['Name']; ?> </h1>
                            </div>
                        </div>
                        <p> <?php echo $store['Info']; ?> </p>
                        <p class="mb-10 mt-5"> <? echo $Last_product ?> </p>
                    </div>
                </div>

                <div class="cards_shop p-4">
                <div class="uk-position-relative uk-slider" uk-slider="finite: true; autoplay:true">

                    <div class="uk-slider-container pb-3">

                        <ul class="uk-slider-items uk-child-width-1-3@m uk-grid-small uk-grid sl_pro_users" style="transform: translate3d(-257.273px, 0px, 0px);">
                            
                        <?php
                            $result_product = $mysql_shop->query("SELECT * FROM `products` WHERE `store_id` = '$link_id' ORDER BY `id` DESC LIMIT 30");
                            
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
                                                            <a href="../product/?id='.$link[$new_product_count].'">'.$name[$new_product_count].'</a>
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

                        <a class="uk-position-center-left uk-hidden-hover slidenav-prev sl_pro_users_prev" href="#" uk-slider-item="previous"></a>
                        <a class="uk-position-center-right-out uk-position-small uk-hidden-hover slidenav-next sl_pro_users_next uk-invisible" href="#" uk-slider-item="next"></a>

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
    <script src="upload.file.js"></script>
</body>

</html>