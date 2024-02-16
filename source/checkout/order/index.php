<?php
    //Loader data
    $cook_id = htmlspecialchars($_COOKIE["id"]);

    include "../../config.php";

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
        include "../../languages/ua.php";
    }elseif(htmlspecialchars($_COOKIE["lang"]) == "ru"){
        include "../../languages/ru.php";
    }elseif(htmlspecialchars($_COOKIE["lang"]) == "en"){
        include "../../languages/en.php";
    }else{
        include "../../languages/ua.php";
    }
?>
<html>
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <title>Orders</title>
        <!--Core CSS -->
        <link rel="stylesheet" href="https://nephos.cssninja.io/assets/css/app.css">
        <link rel="stylesheet" href="css.css">
    </head>
    <body style="height: auto;">
        <div id="invoice-page" class="section">

            <div class="container">
                <div class="columns account-header">
                    <div class="column invoice-column invoice-wrap is-invoice-landscape-padded">

                        <div class="invoice">
                            <div class="columns is-flex-mobile">
                                <!-- Invoice Brand -->
                                <div class="column is-7">
                                    <img src="../../assets/images/logo.png" class="logo" style="width: 170px;" alt="logo">
                                </div>
                                <!-- Invoice Meta -->
                                <div class="column is-5">
                                    <p class="invoice-meta has-text-right">
                                        <span>Invoice N° <small><? echo date('Y')."/".$cook_id;?></small></span>
                                        <br>
                                        <span> <? echo $Order_txt; ?> <small> <? echo $_GET["order"]; ?> </small></span>
                                    </p>
                                </div>
                            </div>
                            <div class="columns">
                                <!-- Supplier Info -->
                                <div class="column is-7">
                                    <p class="seller">
                                        <span><? echo $title; ?></span><br>
                                        <? echo $Order_txt_details; ?><br>
                                    </p>
                                    <br>
                                    <!-- Invoice date -->
                                    <p class="invoice-meta has-text-left">
                                        <span><? echo $FormDate; ?><small class="date"><? echo date("d.m.Y"); ?></small></span>
                                    </p>
                                </div>
                                <!-- Customer Info -->
                                <div class="column is-5">
                                    <p class="buyer has-text-right">
                                        <span><? echo $_GET["name"]; ?></span><br>
                                              <? echo $_GET["email"]; ?><br>
                                              <? echo $_GET["street1"]; ?><br>
                                              <? echo $_GET["street2"]; ?>
                                    </p>
                                </div>
                            </div>
                            <br>
                            <br>
                            <!-- Row -->
                            <div class="columns">
                                <div class="column">
                                    <!-- Purchased Products -->
                                    <table class="table table-striped responsive-table">
                                        <!-- Header -->
                                        <thead>
                                            <tr>
                                                <th><? echo $txt_order_1; ?></th>
                                                <th class="has-text-centered"><? echo $txt_order_2; ?></th>
                                                <th><? echo $txt_order_3; ?></th>
                                                <th><? echo $txt_order_4; ?></th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                        <?php
                                            if($_GET["card"] == "no"){
                                                $order_number = $_GET["order"];
                                                $cards = $mysql_shop->query("SELECT * FROM `cart` WHERE `order_id` = '$order_number'; ");
                                            }else{
                                                $cards = $mysql_shop->query("SELECT * FROM `cart` WHERE `user_id` = '$cook_id' && `order_id` = 0; ");
                                            }

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
                                                    $counts = 1;

                                                    echo('
                                                        <tr>
                                                            <td>
                                                                <span class="product">'.$t_name.'</span>
                                                                <br>
                                                                <span class="sku">'.$id_stores.'</span>
                                                            </td>
                                                            <td class="has-text-centered">
                                                                <span class="quantity">'.$counts.'</span>
                                                            </td>
                                                            <td class="text-right">
                                                                <span class="unit-price">'.$t_price.'</span>
                                                            </td>
                                                            <td class="text-right">
                                                                <span class="total-price">'.$t_price * $counts.'</span>
                                                            </td>
                                                        </tr>
                                                    ');
                                                    $cards_num = $cards_num + 1;
                                                }
                                            }else{
                                                $not_cart = false;
                                            }
                                        ?>

                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <div class="columns">
                                <div class="column is-7">
                                </div>
                                <!-- Total subtable -->
                                <div class="column is-5">
                                    <table class="table table-sm sub-table text-right">
                                        <tbody><tr>
                                            <td><span class="subtotal"><? echo $txt_order_4; ?></span></td>
                                            <td class="text-right"><span class="subtotal-value"><? echo $all_price; ?></span></td>
                                        </tr>
                                        <tr>
                                            <td><span class="vat"><? echo $txt_order_6; ?> (20%)</span></td>
                                            <td class="text-right"><span class="vat-value"><? echo $all_price * 0.2; ?></span></td>
                                        </tr>
                                        <tr>
                                            <td><span class="total"><? echo $txt_order_5; ?></span></td>
                                            <td class="text-right"><span class="total-value"><? echo $all_price + ($all_price * 0.2); ?></span></td>
                                        </tr>
                                    </tbody></table>
                                </div>
                            </div>
                            <br>
                            <!-- Company Bank Account Info -->
                            <p class="bottom-page has-text-right">
                                <span class="company">uStore</span> <br>
                                <span class="id">Unesell Studio | Marketplace B2B</span><br>
                                <span class="url"><? echo $dns_store; ?></span><br>
                                <span class="code">Autor: Stanislav Miroshnichenko</span>
                            </p>
                        </div>
                    </div>
                </div>
            </div>
            
        </div>
        <script src="https://html2canvas.hertzen.com/dist/html2canvas.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/1.5.3/jspdf.min.js"></script>
        <script>
            function saveAsPDF() {
                // Открываем текущую страницу в новом окне с заданными размерами
                var newWin = window.open(window.location.href, '', 'height=720,width=1280');                
                // Ждем загрузки страницы в новом окне
                newWin.addEventListener('load', function() {
                    newWin.history.replaceState({}, document.title, window.location.href.split('?')[0]);
                    // Получаем canvas из текущей страницы
                    html2canvas(newWin.document.body).then(function(canvas) {
                        // Присваиваем canvas новому окну
                        newWin.document.body.innerHTML = '';
                        newWin.document.body.appendChild(canvas);

                        /*
                        // Создаем PDF документ с размерами, соответствующими размерам нового окна
                        var doc = new jsPDF({
                            orientation: 'landscape',
                            unit: 'px',
                            format: [canvas.width, canvas.height]
                        });

                        // Конвертируем canvas в изображение base64
                        var imgData = canvas.toDataURL('image/png');

                        // Добавляем изображение в PDF документ
                        doc.addImage(imgData, 'PNG', 0, 0, canvas.width, canvas.height);

                        // Сохраняем PDF документ
                        doc.save('document.pdf');
                        newWin.close();
                        */
                    });
                });
            }

            function clear_get(){
                history.replaceState({}, document.title, window.location.href.split('?')[0]);
            }
        </script>


    </body>
</html>