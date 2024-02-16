        <!-- Chat sidebar -->
        <a class="chat-plus-btn messenger-btn" href="#sidebar-chat" uk-toggle onclick="open_cursus(); document.getElementById('window_bc_name').textContent = '<?php echo $chat ?>';">
            <i class="fa fa fa-comments fa-2 mr-3" aria-hidden="true"></i>
        </a>

        <a class="chat-plus-btn" href="#sidebar-chat" uk-toggle onclick="open_basket(); document.getElementById('window_bc_name').textContent = '<?php echo $mess_text ?>';">
            <i class="fa fa-shopping-cart mr-3" aria-hidden="true"></i>
            <?php echo $mess_text ?>
        </a>

        <div id="sidebar-chat" class="sidebar-chat px-3" uk-offcanvas="flip: true; overlay: true">
            <div class="uk-offcanvas-bar">

                <div class="sidebar-chat-head mb-2">

                    <div class="btn-actions">
                        <a href="#" uk-tooltip="title: <?php echo $Search ?> ;offset:7"
                            uk-toggle="target: .sidebar-chat-search; animation: uk-animation-slide-top-small"> <i
                                class="icon-feather-search"></i> </a>
                        <a href="#" class="uk-hidden@s"> <button class="uk-offcanvas-close uk-close" type="button"
                                uk-close> </button> </a>
                    </div>

                    <h2 id="window_bc_name"></h2>
                </div>

                <div class="sidebar-chat-search" hidden>
                    <input type="text" class="uk-input" placeholder="<?php echo $Search ?>...">
                    <span class="btn-close"
                        uk-toggle="target: .sidebar-chat-search; animation: uk-animation-slide-top-small"> <i
                            class="icon-feather-x"></i> </span>
                </div>

                <div id="cursus">
                    <iframe src="https://unesell.com/app/cursus/users.php" class="messenger-frame" id="chatFrame" name="iframe">
                        Загрузка приложения не удалась.
                    </iframe>
                </div>
                <div id="basket">
                    <div class="list_cart" id="list_cart" style="width: -webkit-fill-available;">
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

                                echo('<a href="'.$path_product.'?id='.$link.'" id="'.$link.'">
                                <div class="contact-list"><div class="card-img-product">
                                <img src="'.$dns_store.'datafiles/post/'.$link.'/'.$first_file.'" class="img_fit" alt=""></div>
                                <div class="ml-3 mr-3"><h5 class="fsmall">'.$t_name.'</h5>
                                <p class="m-0 text-blue-600">₴'.$t_price.'</p></div></div></a>');
                                $cards_num = $cards_num + 1;
                            }
                            if($cards_num == 1 || $cards_num == 0){
                                $onecards = "document.getElementById('preloader_cart').style.display = ''; document.getElementById('review_card').style.display = 'none';";
                            }
                        }else{
                            $not_cart = false;
                        }
                    ?>
                    </div>

                    <div class="preloader_cart" id="preloader_cart" style="<?php if($not_cart){ echo('display: none;'); } ?>">
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
                            <p class="preloader__msg"> <?php echo $cart_clear ?> </p>
                            <p class="preloader__msg preloader__msg--last"> <?php echo $cart_clear_subtext ?> </p>
                        </div>
                    </div>

                    <div class="relative d-contents" id="review_card" style="<?php if(!$not_cart){ echo('display: none;'); } ?>">
                        <!-- Список элементов здесь -->
                        <div class="b-aliceblue absolute bottom-0 left-0 w-full bg-white py-4 px-6 flex justify-between items-center">
                            <div class="rounded-lg bg-gray-100 flex">
                                <span class="text-indigo-400 mr-1 mt-1">₴</span>
                                <span class="font-bold text-indigo-600 text-3xl" id="cart_price"><? echo($all_price); ?></span>
                            </div>
                            <button type="button" onclick="location.href = '<?php echo($checkout); ?>';" class="h-11 text-white bg-gradient-to-br from-purple-600 to-blue-500 hover:bg-gradient-to-bl focus:ring-4 focus:outline-none focus:ring-blue-300 dark:focus:ring-blue-800 font-medium rounded-lg text-sm px-5 py-2.5 text-center mb-2"><? echo $checkout_text_card; ?></button>
                        </div>
                    </div>

                    <div>

                    </div>
                </div>
                
            </div>
        </div>