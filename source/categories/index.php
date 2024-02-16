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
?>

<!doctype html>
<html lang="ru">

<head>

    <!-- Basic Page Needs
    ================================================== -->
    <title>uStore - <?php echo $Title_Catalog; ?> </title>
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
                        <h3 id="Title" class="TextAnim font-extrabold text-gray-500 dark:text-gray-500 md:text-5xl lg:text-6xl m-2" style="font-size: 30px;"><span class="text-transparent bg-clip-text bg-gradient-to-r to-emerald-600 from-sky-400"><?echo $categories_pc_title_1; ?></span> <?echo $categories_pc_title_2; ?></h3>
                    </div>
                </div>

                <div class="p-3">
                    <div class="flex items-center mb-4">
                        <h6 class="text-lg font-bold dark:text-white m-0"><? echo $Product_text; ?></h6></br>
                        <svg class="w-6 h-6 text-gray-400" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"></path></svg>
                    </div>
                    <div>
                        <?php foreach ($categories as $key => $value): ?>
                            <button type="button" class="py-2.5 px-5 mr-2 mb-2 text-sm font-medium text-gray-900 focus:outline-none bg-white rounded-lg border border-gray-200 hover:bg-gray-100 hover:text-blue-700 focus:z-10 focus:ring-4 focus:ring-gray-200 dark:focus:ring-gray-700 dark:bg-gray-800 dark:text-gray-400 dark:border-gray-600 dark:hover:text-white dark:hover:bg-gray-700" onclick="selectCategory('<?php echo $key; ?>')" id="<?php echo $key; ?>"><?php echo $value; ?></button>
                        <?php endforeach; ?>
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