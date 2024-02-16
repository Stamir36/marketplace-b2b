<?php
    $q = $_GET["q"];

    include "../config.php";

    $mysql_shop = new mysqli($Host, $User_store, $Password_store, $Database_store);
    $searchResults = $mysql_shop->query("SELECT * FROM products WHERE `name` LIKE '%$q%' ORDER BY `id` DESC LIMIT 5;");

    $results = array();

    if ($searchResults->num_rows > 0) {
        while ($row = $searchResults->fetch_assoc()) {
            $path = '../datafiles/post/'.$row['link'].'/';
            $files = scandir($path);
            $image_files = array_filter($files, function($file) {
                return preg_match('/\.(jpg|jpeg|png|gif)$/', $file);
            });
            $first_image = reset($image_files);
            $temp_id = $row['store_id'];
            $store = $mysql_shop->query("SELECT * FROM `shop` WHERE `LINK_ID` = '$temp_id';");
            $store = $store->fetch_assoc();

            $result = array(
                'link' => $row['link'],
                'name' => $row['name'],
                'icon' => "/datafiles/post/".$row['link']."/".$first_image,
                'store' => $store['Name']
            );

            $results[] = $result;
        }
    }

    echo json_encode($results);
?>
