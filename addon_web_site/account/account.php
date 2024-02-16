<?php
    //Loader data
    $cook_id = htmlspecialchars($_COOKIE["id"]);
    setcookie('site_page', 'main', time() + 3600 * 24, "/");

    include "../service/config.php";

    $mysql = new mysqli($Host, $User, $Password, $Database);

    $result = $mysql->query("SELECT * FROM `accounts_users` WHERE `id` = '$cook_id'");
    $user = $result->fetch_assoc();

    //Из базы данных: $user['name'];

    include "../api/connect/config.web.php";

    $mysql_mydevice = new mysqli($Host, $User, $Password, $Database);

    $resultPC = $mysql_mydevice->query("SELECT * FROM `pc_device` WHERE `user_id` = '$cook_id'");
    $my_device_pc = $resultPC->fetch_assoc();
  
    $result = $mysql_mydevice->query("SELECT * FROM `mobile_device` WHERE `user_id` = '$cook_id'");
    $my_device_android = $result->fetch_assoc();
    
?>


<!DOCTYPE html>
<html lang="ru">

<head>
  <meta charset="UTF-8" />
  <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge" />
  <meta http-equiv="X-UA-Compatible" content="ie=edge" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />


  <title>Unesell Account - Обліковий запис</title>
  <link rel="stylesheet" href="../assets/css/unedashboard.css" type="text/css" />
  <link rel="stylesheet" href="../assets/css/uneapp.css" type="text/css" />

  <?php
        include '../app/connect.assets.css.php';
  ?>
  <!-- favicon -->
  <link rel="shortcut icon" href="../assets/img/favicon.ico" type="image/x-icon" />
  <!-- Bootstrap 4.5 -->
  <link rel="stylesheet" href="../assets/css/main/bootstrap.min.css" type="text/css" />
  <!-- icons -->
  <link rel="stylesheet" href="../assets/css/main/icons.css" type="text/css" />
  <!-- aos -->
  <link rel="stylesheet" href="../assets/css/main/aos.css" type="text/css" />
  <!-- main css -->
  <link rel="stylesheet" href="../assets/css/main/main.css" type="text/css" />
  <!-- normalize -->
  <link rel="stylesheet" href="../assets/css/main/normalize.css" type="text/css" />
  <!--New Style Unesell-->
  <link rel="stylesheet" href="../assets/css/main/new_style.css" type="text/css" />
  <script src="/assets/js/jquery-3.6.0.min.js"></script>
</head>

<body>
    <!-- Контент -->
    <div id="wrapper">
        <div id="content">

            <!-- Модальное окно -->
            <div class="col-md-4">
                <div class="modal fade" id="modal-default" tabindex="-1" role="dialog" aria-labelledby="modal-default" style="display: none; background: rgba(0, 0, 0, 0.4);" aria-hidden="true">
                <div id="qrmodal" class="modal-dialog modal- modal-dialog-centered modal-" role="document">
                    <div class="modal-content" style="padding: 1rem; min-width: 370px !important; margin-left: 5px;">
                        <div class="modal-header">
                            <h6 class="modal-title" id="modal.name">Авторизация по QR Коду</h6>
                        </div>
                        <div class="modal-body" style="padding-bottom: 0px; padding-top: 0px; display: flex;">
                            <div id="qrCodeOutput" class="text-center" style="width: 100%;">
                                Здесь будет сгенерированный QR-код
                            </div>
                            <p id="modal.text" style="font-size: 13px; align-self: center;">Отсканируйте код на устройстве, чтобы войти аккаунт. <br><br><a href="/login/qr/">unesell.com/login/qr/</a></p>
                        </div>
                        <div class="modal-footer">
                        <button type="button" class="btn btn-link ml-auto" data-dismiss="modal"
                        onclick="document.getElementById('modal-default').style.display = 'none';
                        document.getElementById('qrmodal').classList.remove('modalAnim'); document.getElementById('modal-default').classList.add('fade');">Закрыть</button>

                        </div>
                    </div>
                </div>
                </div>
            </div>

            <div class="col-md-4">
                <div class="modal fade" id="modal-back" tabindex="-1" role="dialog" aria-labelledby="modal-default" style="display: none;background: rgba(0, 0, 0, 0.4);" aria-hidden="true">
                    <div class="modal-dialog modal- modal-dialog-centered modal-" role="document" id="formImgSelect" style="height: 100%; margin-right: 0px;  margin-top: 0px; margin-bottom: 0px;">
                        <div class="modal-content" style="padding: 1rem;min-width: 370px !important;height: 100%; border-radius: 20px 0px 0px 20px;">
                            <div class="modal-header">
                                <h6 class="modal-title" id="modal.name">Смена фона</h6>
                            </div>

                            <iframe src="widget/index.html" style="height: 100%;">
                                Загрузка приложения не удалась.
                            </iframe>

                            <script>
                                function AccountBackImgSetup(url){
                                    document.getElementById("user_avatar_background").src = "";
                                    document.getElementById("user_avatar_background").src = url;

                                    $.ajax({
                                        url: '../api/edit.background.php',
                                        type: 'GET',
                                        data:{id: '<?php echo($cook_id); ?>', url: url },
                                        success: function(data) {
                                            console.log("success");
                                        }, error: function(data){
                                            console.log("error");
                                        }
                                    });
                                }
                            </script>
                            
                            <div class="modal-footer">
                                <button type="button" class="btn btn-link ml-auto" data-dismiss="modal" onclick="document.getElementById('modal-back').style.display = 'none';
                                document.getElementById('modal-back').classList.add('fade'); document.getElementById('formImgSelect').classList.remove('animForm');">Закрыть</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-4">
                <div class="modal fade" id="modal-chat" tabindex="-1" role="dialog" aria-labelledby="modal-default" style="display: none; background: rgba(0, 0, 0, 0.4);" aria-hidden="true">
                    <div class="modal-dialog modal- modal-dialog-centered modal-" role="document" id="formMess" style="height: 100%; margin-right: 0px;  margin-top: 0px; margin-bottom: 0px;">
                        <div class="modal-content" style="padding: 1rem;min-width: 370px !important;height: 100%; border-radius: 20px 0px 0px 20px;">
                            <div class="modal-header">
                                <h6 class="modal-title" id="modal.name">Сообщения</h6>
                            </div>

                            <iframe src="/app/cursus/login.php" style="height: 100%; border-radius: 20px;">
                                Загрузка приложения не удалась.
                            </iframe>
                            
                            <div class="modal-footer">
                                <button type="button" class="btn btn-link ml-auto" data-dismiss="modal" onclick="document.location.href = '/app/cursus/';">Открыть мессенджер Cursus</button>

                                <button type="button" class="btn btn-link ml-auto" data-dismiss="modal" onclick="document.getElementById('modal-chat').style.display = 'none';
                                document.getElementById('modal-chat').classList.add('fade'); document.getElementById('formMess').classList.remove('animForm');">Закрыть</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
          <!-- Start header -->
          <header class="header-nav-center no_blur header_software active-green2" id="myNavbar" style="background-color: white;">
            <div class="container">
              <!-- navbar -->
              <nav class="navbar navbar-expand-lg navbar-light px-sm-0" style="background-color: transparent;">
                <a class="navbar-brand">
                  <img class="logo" src="../assets/img/logo-account.png" alt="logo" style="width: 200px !important;" />
                </a>

                <div class="brand-start">
                    <div class="navbar-burger" id="icon_navbars" onclick="navopen();">
                        <span></span>
                        <span></span>
                        <span></span>
                    </div>
                </div>
              
                <div class="navbar-collapse" id="navbarSupportedContent">

                    <ul class="navbar-nav mx-auto nav-pills">
                      <li class="nav-item">
                        <a class="nav-link selected">Профиль</a>
                      </li>
      
                      <li class="nav-item dropdown dropdown-hover dropdown_full position-static">
                        <a class="nav-link dropdown-toggle dropdown_menu" href="settings/" id="navbarDropdown" role="button"
                          data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                          Настройки
                        </a>
                      </li>
      
                    </ul>
                    <div class="nav_account btn_demo3">
                        <button type="button" data-toggle="modal" data-target="#mdllLogin"
                            class="btn btn_sm_primary opacity-1 sweep_letter scale sweep_top rounded-8">
                            <div class='inside_item'>
                            <span data-hover='К сервисам' onclick="location.href= '/';">Главная страница</span>
                            </div>
                        </button>
                    </div>
                  </div>
              </nav>
              <script>
                  if (/Android|webOS|iPhone|iPad|iPod|BlackBerry|BB|PlayBook|IEMobile|Windows Phone|Kindle|Silk|Opera Mini/i.test(navigator.userAgent)) {
                    document.getElementById("icon_navbars").classList.remove("is-active");
                    document.getElementById("navbarSupportedContent").style.display = "none";
                  }
                  
                  let active_nav = false;
                  function navopen(){
                    if (/Android|webOS|iPhone|iPad|iPod|BlackBerry|BB|PlayBook|IEMobile|Windows Phone|Kindle|Silk|Opera Mini/i.test(navigator.userAgent)) {
                        if(active_nav){
                            document.getElementById("icon_navbars").classList.remove("is-active");
                            document.getElementById("navbarSupportedContent").style.display = "none";
                            active_nav = false;
                        }else{
                            document.getElementById("icon_navbars").classList.add("is-active");
                            document.getElementById("navbarSupportedContent").style.display = "block";
                            active_nav = true;
                        }
                    }
                  }
              </script>
              <!-- End Navbar -->
            </div>
            <!-- end container -->
          </header>
          <!-- End header -->
    
          <!-- Stat main -->
          <main data-spy="scroll" data-target="#navbar-example2" data-offset="0">

            <div id="app-hr" style="padding-top: 100px;" data-naver-offset="150" data-menu-item="#home-sidebar-menu" data-mobile-item="#home-sidebar-menu-mobile">

                <div class="page-content-wrapper" style="max-width: 1400px;">
                    <div class="page-content is-relative">
    
                        <div class="page-content-inner">

                            <!--Business Dashboard V3-->
                            <div class="business-dashboard hr-dashboard">
    
                                <div class="columns">
    
                                    <div class="column is-8">
    
                                        <div class="profile" style="margin-bottom: 50px; margin-top: 0px;">
                                            <div class="profile-cover" style="border-radius: 15px 15px 0px 0px;">
                                            <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" style="margin:auto;display:block;margin-top: 80px;" width="100px" height="100px" viewBox="0 0 100 100" preserveAspectRatio="xMidYMid">            
                                                <circle cx="50" cy="50" r="30" stroke="#46dff0" stroke-width="10" fill="none"></circle>
                                                <circle cx="50" cy="50" r="30" stroke="#e90c59" stroke-width="8" stroke-linecap="round" fill="none">
                                                <animateTransform attributeName="transform" type="rotate" repeatCount="indefinite" dur="1s" values="0 50 50;180 50 50;720 50 50" keyTimes="0;0.5;1"></animateTransform>
                                                <animate attributeName="stroke-dasharray" repeatCount="indefinite" dur="1s" values="18.84955592153876 169.64600329384882;94.2477796076938 94.24777960769377;18.84955592153876 169.64600329384882" keyTimes="0;0.5;1"></animate>
                                                </circle>
                                            </svg>                  
                                                <!-- profile cover -->
                                                <img src="<?php echo $user['imgBackground'];?>" id="user_avatar_background">
                                                <!-- 
                                                    <video playsinline="" autoplay="" muted="" poster="https://cdn.cloudflare.steamstatic.com/steamcommunity/public/images/items/1299120/8ad3e27bff8de6f6c23b98ecb5512afbae3925e7.jpg" loop="">
                                                            <source src="https://cdn.cloudflare.steamstatic.com/steamcommunity/public/images/items/1299120/7b165fc05e754dfdc31740025d6a55101db8b4b1.webm" type="video/webm">
                                                            <source src="https://cdn.cloudflare.steamstatic.com/steamcommunity/public/images/items/1299120/8fa8b63d22b476a312c91231947cb17be92f6b5e.mp4" type="video/mp4">
                                                    </video>
                                                -->
                                                <a onclick="document.getElementById('formImgSelect').classList.add('animForm'); document.getElementById('modal-back').style.display = '-webkit-inline-box';  document.getElementById('modal-back').classList.remove('fade');"> Изменить </a>
                
                                            </div>
                
                                            <div class="profile-details" style="text-align: left; margin-left: 30px;">
                                                <div class="profile-image" style="background: #fff; width: fit-content; border-radius: 60px 60px 0px 0px;">
                                                    <img src="/data/users/avatar/<?php echo $user['avatar'];?>" alt="">
                                                </div>
                                                <div class="profile-details-info" style="margin-left: 15px;">
                                                    <p class="TextAnim"> Привет, </p>
                                                    <h1 class="TextAnim" style="margin: 0px; margin-bottom: 15px;"> <?php echo $user['name'];?> </h1>
                                                </div>
                
                                            </div>
                
                
                                            <div class="nav-profile uk-sticky" uk-sticky="media : @s">
                                                <div class="py-md-2 uk-flex-last" style="margin-left: 15px;">
                                                    <a class="button h-button is-bold is-fullwidth is-dark-outlined mr-3" onclick="document.getElementById('formMess').classList.add('animForm'); document.getElementById('modal-chat').style.display = 'block';  document.getElementById('modal-chat').classList.remove('fade');">Сообщения</a>
                                                    <a class="button h-button is-bold is-fullwidth is-dark-outlined mr-3" style="color: #000;" href="/service/all/">Все приложения</a>
                                                </div>
                                                <div>
                                                    <nav class="responsive-tab ml-lg-3">
                                                        <ul>
                                                            <li class="uk-active" id="info_page" ><a onclick="InfoOpen()">Информация</a></li>
                                                            <li id="frands_page"><a  onclick="frendsOpen()">Друзья</a></li>
                                                        </ul>
                                                    </nav>
                                                </div>
                                            </div><div class="uk-sticky-placeholder" hidden="" style="height: 62px; margin: 0px;"></div>
                
                                        </div>

                                        <div style="padding: 10px;">
                                            <div class="incoming" id="infoIncoming">
                                                <div class="side-text">
                                                    <h3 class="dark-inverted">О себе</h3>
                                                </div>

                                                <p><?php echo $user['about_me'];?></p>

                                                <br>

                                                <div class="side-text">
                                                    <h3 class="dark-inverted">Сервисы</h3>
                                                </div>
                                                
                                                <div class="flex-table">


                                                    <div style="overflow-y: auto; max-height: 300px; display: inline-flex; width: 100%;">
                                                        <!--Table item-->
                                                        

                                                        <?php
                                                        $service = $mysql->query("SELECT * FROM `service_connect` WHERE `user_id` = '$cook_id'");
                                                        
                                                        $img = Array();
                                                        $Title = Array();
                                                        $Subtitle = Array();
                                                        $Data = Array();
                                                        $Status = Array();


                                                        while($result = $service->fetch_assoc()){
                                                            $img[] = $result['img'];
                                                            $Title[] = $result['Title'];
                                                            $Subtitle[] = $result['Subtitle'];
                                                            $Data[] = $result['Data'];
                                                            $Status[] = $result['Status'];
                                                        }
                              
                                                        $num_notifi = 0;
                              
                                                        
                                                          if(count($img) == count($Title) && count($img) != 0 && count($Title) != 0 ){
                                                            while($num_notifi <= (count($img) - 1)){
                                                                echo("
                                                                
                                                                <div class='flex-table-item' style='margin-right: 10px; max-width: 280px; max-height: 120px;'>
                                                                    <div class='flex-table-cell is-media is-grow-lg' data-th=''>
                                                                        <div class='h-icon' style='padding: 5px;'>
                                                                            <img src='".$img[$num_notifi]."' class='lnil lnil-envelope-alt' alt=''>
                                                                        </div>
                                                                        <div>
                                                                            <span class='item-name dark-inverted'>".$Title[$num_notifi]."</span>
                                                                            <span class='item-meta'>
                                                                            <span>".$Subtitle[$num_notifi]."</span>
                                                                            </span>
                                                                        </div>
                                                                    </div>
                                                                    <div class='flex-table-cell cell-center'>
                                                                        <span class='light-text'>".$Data[$num_notifi]."</span>
                                                                    </div>
                                                                </div>
                              
                                                                ");
                                                                $num_notifi = $num_notifi + 1;
                                                            }
                                                        }else{
                                                            echo("<a style='color: #322EFF; text-align: center; padding-top: 10px;'>Нет подключённых сервисов</a>");
                                                        }
                                                    ?>

                                                    </div>

                                                </div>
                                                
                                                <br>

                                                <div class="section-header">
                                                    <div class="side-text">
                                                        <h3 class="dark-inverted">Мои устройства</h3>
                                                    </div>
                                                </div>
                                                
                                                <div uk-slider="finite: true" class="uk-slider uk-slider-container">
                                                    <ul class="uk-slider-items uk-child-width-1-3@m uk-child-width-1-3@s uk-child-width-1-2 uk-grid-small uk-grid" style="transform: translate3d(0px, 0px, 0px);">   
                                                    <?php                     
                                                        if(count($my_device_pc['ID_PC']) > 0){
                                                            echo("
                                                            <li tabindex='-1' class='uk-active'>
                                                                <div class='product'>
                                                                    <div class='product_info'>
                                                                        <div class='produc_info'>
                                                                            <div class='product-by'>
                                                                                <a> Персональный компьютер</a>
                                                                            </div>
                                                                            <div>
                                                                                <a>".$my_device_pc['SystemInfo']."</a>
                                                                            </div>
                                                                            <div class='product-price' style='bottom: 35px;'> ".$my_device_pc['BATTETY']."% </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </li>
                                                            ");
                                                        }

                                                        if(count($my_device_android['MOBILE']) > 0){
                                                            echo("
                                                            <li tabindex='-1' class='uk-active'>
                                                                <div class='product'>
                                                                    <div class='product_info'>
                                                                        <div class='produc_info'>
                                                                            <div class='product-by'>
                                                                                <a> Мобильное устройство </a>
                                                                            </div>
                                                                            <div>
                                                                                <a>".$my_device_android['System']."</a>
                                                                            </div>
                                                                            <div class='product-price' style='bottom: 35px;'> ".$my_device_android['BATTETY']."% </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </li>
                                                            ");
                                                        }
                                                      ?>

                                                            <li tabindex='-1' class='uk-active' onclick="document.location.href = '/app/mydevice/';">
                                                                <div class="product button h-button is-bold is-fullwidth is-dark-outlined mr-3" style="height: auto; place-content: normal; background: rgba(245, 245, 245, 0.6);">
                                                                    <div style="text-align: left;">
                                                                        <div class="produc_info">
                                                                            <div class="product-by">
                                                                                <a> Открыть </a>
                                                                            </div>
                                                                            <div>
                                                                                <a>Сервис MyDevice</a>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </li>
                                                    </ul>


                                                </div>

                                            </div>
                                            <div class="incoming" id="frendsIncoming" style="display: none;">
                                                <div class="section-header">
                                                    <div class="side-text">
                                                        <h3 class="dark-inverted">Избранные аккаунты</h3>
                                                    </div>
                                                </div>
                                                <ul class="uk-slider-items uk-child-width-1-5@m uk-child-width-1-3@s uk-child-width-1-2 uk-grid-small uk-grid" style="transform: translate3d(0px, 0px, 0px);">
                                                <li tabindex="-1" class="uk-active">
                                                    <div class="product">
                                                        <div class="product_info">
                                                            <div class="product-image">
                                                                <a href="#">
                                                                    <img src="/assets/img/default.png" alt="">
                                                                </a>
                                                            </div>
                                                            <div class="produc_info">
                                                                <div class="product-title">
                                                                    <a href="#">  Имя друга </a>
                                                                </div>
                                                                <button type="button" class="button small product-price">
                                                                    <span> Написать </span>
                                                                </button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </li>

                                            </ul>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="column is-4">
    
                                        <div class="uk-width-expand">
                                            <ul class="sl_user-widget sidebar-conatnier sl_user-widget_text" id="sidebar-group-list-container">

                                                <div class="sl_user-widget-wrap-header">
                                                    <div class="sl_user-widget-wrap-header-left">
                                                        <h4 style="text-transform: inherit;"> Информация профиля </h4>
                                                    </div>
                                                </div>
                
                                                <div class="sidebar-group-may-know-container">
                
                                                    <div class="sl_sidebar_sugs" style="padding: 10px;">
                                                        <div style="margin-right: 15px; width: 30px;">
                                                            <img src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAADAAAAAwCAYAAABXAvmHAAAABmJLR0QA/wD/AP+gvaeTAAAFCElEQVRoge1Y224bVRRd+5y5eOKkEYoqpSVUBAoCIVDhAQnxCbzxEX3ld+hf8ESFBG3FRaqQEkobxanTKAlJc3HiOE7i21zO5sGe8ZmbL72ESnhJscdrzp5Ze+29z2gCTDDBBBNM8H8G6T++3edvmHGHgbf/K0FDsAvC7R+u0d2QEPpZxfj+DRYPAAtg3NEJkVrw5uMd/UcsAVaqfrlaxocK1Jn+O5bA0982/M7ZxaPLlTQ6mtXzo7X7z6Z0zoitsGfnni1V5t66Wn107ZMbHxBR8VIV5kAFivdX9+hot3VVONOxc/EZIIKcmkG9Jm+Vfy23vYtm6TKFZqFx0kDpfpmODzyIQhEc3zgTFeiBLBsqkHPlh7tzc9cLy/MfLXwMIZxLUdyDUgoHq/uobJ2Cpq4AwgAD6H70kdyFIpA0IIqzqB74X6w9WKu7F62nr1dyH81aA2v3yqjsNCGmZgFhAAxw709HbgJgAESgQhEBFedLv29+eLS+9xeY3dclnBXjcP0Q5T+24CkbVCiCheyKDzUlSpDZQvG1BFgOpJC0t3H++ck/pwc3v36/JQv24qsU3z5rY2tpG62mgijMAIYZuR6KSboP5FSgG8RargxIE9KZQVtZ809+Lr97vL7/BEDwssKZgcpGBaUHZXQ6AlSY7otHWnwyiXQFwoDeMTNHVWMhIKwiFEvaKVU/rT4/Pbj51XtK2vb1FxHfaXSwvbSNRt2FsKcBywZBZLseJRTPIFWBKOu+7jhHBLIdkDODxgXN/313bb66dfgYgBpH/PHWMUr31tC44K7rtgNA5Loeik92UawCqdZhjtyI2F5VyLBAJMAdIbaWDz473qx1Fr9ctK2iPVC423SxvbyN82oLwnJAVgEkzKGuZ22hQKoCeuvobJoDABIGyJ4COdM4rwf2yk+rONo8zhVfe15D6ZcSLmouRKHYjRXmaK5H/KBdiKFl2XdfVx7OBIdXJQEYBZAClCew+ec2TnZquHFrAc6V7rOvfdbC7soezirnIMvpVs+wwUQjux7db9AQR9fQB7d3wFoi4WeUIAGwCgBJEBHqlSYe/7gCyzFhGAKeG3RF20WQaYNkvuvhQZbrWdtoqgLRxcKPMThIE0QEJgmSNlw/gBsQLNsBGRJkWGAhIzfHcT1vBjIeZBmDG7oQFSZeFf15wSRBpgOWAYgVmAFXCUgYMIR4cddDPQNbKNk6jHTraDtTn0OaIwHu7REMhucGCLwAhi0hBMVc14XmuZ7XRqkKxNpkKBevSn+d5nC4gIFAMYKmD8OUMCwxtutDZyBvz4+1jlYV1gMz2i6ZYPjldXwEPsG0JEjQ6K4nr59MoH/jjGyHcJzkeDAX+Azf92GaAoYlhrrOqRtlJcDawjAoEpkYXE1dJE6PRUYsErHMcDsBfE/B7M3GuG0U/69EQqR+69ijPpGgXtooVp+XMDaHCwJGu+HB6wQxkczcNyLiB7VQsiV4RC4rNuLiRuhV0WeIGd1q+AqWJbvW5rWRhpz3gfTwZe75Wa3zMm3HjMBTaDY8+K6KuT7SDKT3fK3Ugzi8Oi480Wn5EK6AVRAgSj83Qgx5H4gPn16V/rrsPT/58Iv4RCwSsbqJga/QOu/ORnidZBPFh5h5N9Y6mhi9X5MJ6nxmgpE5emyWYRkcA247QKfpQykAjJ3cBJSg2wB2xxvS+M1H5/JflpLzB3Sr4bZ8l0HfYYIJJphgggl6+BdmX1edj7oN/AAAAABJRU5ErkJggg==" alt=""> 
                                                        </div>
                                                        <div class="sl_sidebar_sugs_text">
                                                            <span>Почта</span>
                                                            <a class="wow_user_link_name"> <?php echo $user['email'];?> </a>
                                                        </div>
                                                    </div>

                                                    <div class="sl_sidebar_sugs" style="padding: 10px;">
                                                        <div style="margin-right: 15px; width: 30px;">
                                                            <img src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAADAAAAAwCAYAAABXAvmHAAAABmJLR0QA/wD/AP+gvaeTAAAFBElEQVRoge1Xz4tcRRD++r3J7IRFSHLSODGGoGtQPAvqP+BZFCEEEVzxHFAED170L1BkgyiiYf0DBP8HV5A1xB8oajK7Ri8zQjbZ2Z15rzy86e6q7q6eeVlED9OH3d7uftVfVX31VS+wHMuxHAuPZ7/Ze++Zrb29p7duv/t/sV20OUyEywBWDczlVuj+Rdsddeet755DRRuG6j6mh8D4b767Uqx/SaZ7H1B2AKphiACiZg4/B9FsrwbA5na9OgTGt4Xt489vkOmuAkUBEO0AtH736sWvUjD1DNTYAKjv/iYS28ZvsFViv4idi9fFSCwBZNf7huoNDWaGQgx8+gZ+SXwm8YmJ1jN23ZQAmDMaSt0BCqJnDKiqAQB1VYPnwEQ4tIgr64a87WkFY/z52OlFHeAfFiVQlNi9NkA1qfDH9s2Gn0XpD1o/Q8DJDJF32hjAlPhz63tUh1P89fV1wJRgXmQ9MOrOG9tkZsUGEMxkDEzuAFUFGAPT6QHlsaMVsF2fHgKTu0A9BVDAlN2ZOPhzdzYvJbHqKhTysNNtIl5PYWAa36mOzy9cwGy9PAaYVaBm9pxoZPiDhfoAu8gYoOgApsgDW6iA+SfU2CxKGE4dyoMHMhl47KnTICKHj4gsm9i8+U2zQ27u1gmOUXyO1HrCPth8M41TzQBhHvgmoGRPR+AhAcOeV5yi4F7Iu7SRlVGwS8CA2IvAQIKBt55zAbLORXN3GbcT3Juhkp4BEZVc5DwQX3ZKxhhg72ecPR8wMKstHXBQRFSAZOTA1lNRdJARnCE55wEInVOGWsRqUTHAPHLbLz6AEytNPEYHNZ64uuvPE+GHS32/P66x9vFAOPfzq2dxstfsD8cVzn94QzinjXwNIOC94CVEFC04ADi5UkQZE/u9wlm2dix4ADjVKx3v59RwToUUrrOiyrKTO5raDmmknqHsRQuokDcSK4an0ejAd9HRQe0Lf3Z2NPb7w3HtqenWKrZfJfpMeqhvofNf3PK1mWs2HIhYV3qD6xmZ7Fqmsnv33nw0iTWrQslmE0ROb3gMMHz2oibH7bMcp5pcKweSjccB8YCTjUcUvkOk8t5ZDim7QA3or1GPBwDh2xfux4mul8knN2+JyF2/+KCQyQuf7ogo/vTKQ0wmazxy5YbI2K+vn/P7+xXOvv8bZPbSI/sW4oVswQMzmeRxpoRMBoUvZbKIsif2j5dRxlo7EHI02g6LOf5cNLykfUi6pQzk3kFZB2wB2p+hTCJwjsvkaCaTPIpDIaOVc84GarjPZHS/EtS5Jxl9+PNdSsqgnbOim9vw5klmUoblfP/ttXYymlaMe38iq87ZkxnwKs1yDkgVyhhPOpeQTHJmA+d4ALx9YTVDIf01am+YGb/20mnx2nz8s13feAj48eUzbn84rrH20U3R8H55Tb42z33wu6RmIJlhxrSRyYCMYvzalNTh+6d6hc/HDEj42pSBVTLGnGvtgIuEwkBR1IqBrAw7EdB5z7PR2gEhkxTIqJNErx7hazPkvXht7lcx72U+ZD1kHFBltP/JDnmOeq6rMsgjlyz24JUKNufrKfsAJu9caPsaldRQJZOCL8LIBVGcq1TuKPuZ4dDcPnCkJzILQ4OTpB1uH4z3gl76f2xZB0DYOfITWcsYa2LeZpwx66gBBq0dqIB1AAMXxYj3iCMHJWPCOR/lpGQK5wgGGFBB6xrO5ViO5ViO/3b8A5jmWFrpFSZSAAAAAElFTkSuQmCC" alt=""> 
                                                        </div>
                                                        <div class="sl_sidebar_sugs_text">
                                                            <span>Дата регистрации</span>
                                                            <a class="wow_user_link_name"> <?php echo date("d.m.Y", strtotime($user['Reg_Date']));?> </a>
                                                        </div>
                                                    </div>

                                                    <div class="sl_sidebar_sugs" style="padding: 10px;">
                                                        <div style="margin-right: 15px; width: 30px;">
                                                            <img src="/assets/img/GLogo.png" alt=""> 
                                                        </div>
                                                        <div class="sl_sidebar_sugs_text">
                                                            <span>Вход через Google</span>
                                                            <a class="wow_user_link_name"> <?php
                                                                if($user['googleAuth'] == "YES"){
                                                                    echo("<a style='color: cornflowerblue;'>Выполнен</a>");
                                                                }else{
                                                                    echo("Не выполнен");
                                                                }
                                                            ?> </a>
                                                        </div>
                                                    </div>

                                                </div>
                                            </ul>
                                        </div>

                                        <div class="uk-width-expand">
                                            <ul class="sl_user-widget sidebar-conatnier sl_user-widget_text" id="sidebar-group-list-container">

                                                <div class="sl_user-widget-wrap-header">
                                                    <div class="sl_user-widget-wrap-header-left">
                                                        <h4 style="text-transform: inherit;"> QR-Авторизация </h4>
                                                    </div>
                                                </div>
                                                
                                                <div class="sidebar-group-may-know-container">

                                                    <div class="sl_sidebar_sugs" style="padding: 10px;">
                                                        <div style="margin-right: 15px; width: 30px;">
                                                            <img src="/assets/img/icons/QR.png" alt=""> 
                                                        </div>

                                                        <div class="sl_sidebar_sugs_text">
                                                            <a class="wow_user_link_name">Авторизация приложения</a>
                                                            <span>Войдите в свой аккаунт с помощью QR-кода авторизации</span>
                                                        </div>

                                                        <div class="user-follow-button sl_sidebar_sugs_btns" style="padding-left: 5px;">
                                                            <div class="user-follow-button sl_sidebar_sugs_btns">
                                                                <button type="button" class="button small" onclick="QRCodeGenerate()">
                                                                    <span> Генерация </span>
                                                                </button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                            </ul>
                                        </div>
                                              
                                        
                                        <div class="uk-width-expand">
                                            <ul class="sl_user-widget sidebar-conatnier sl_user-widget_text" id="sidebar-group-list-container">

                                                <div class="sl_user-widget-wrap-header">
                                                    <div class="sl_user-widget-wrap-header-left">
                                                        <h4 style="text-transform: inherit;"> Уведомления </h4>
                                                    </div>
                                                    <div class="user-follow-button sl_sidebar_sugs_btns" style="padding-left: 5px;">
                                                        <div class="user-follow-button sl_sidebar_sugs_btns">
                                                            <button type="button" class="button small" onclick="claer_now_notify();" id="notifi_clear2">
                                                                <span> Очистить </span>
                                                            </button>
                                                        </div>
                                                        <script>
                                                            function claer_now_notify(){
                                                                $.ajax({
                                                                    url: 'clear_notifi.php',
                                                                    success: function(data) {
                                                                        clears_notifi();
                                                                    }
                                                                });
                                                            }
                                                            function clears_notifi(){
                                                                var texts = document.getElementById("none_notify");
                                                                texts.style = "color: #db6724; cursor: default; display: block;";
                                                                
                                                                var notifi_blocks = document.getElementById("notify_count");
                                                                notifi_blocks.textContent = "0";
                                                                var notifi_blocks = document.getElementById("notifi_clear");
                                                                notifi_blocks.style = "display: none;";
                                                            }
                                                        </script>
                                                    </div>
                                                </div>
                                                
                                                <div class="sidebar-group-may-know-container">
                                                    <div id="notifi_clear" style="max-height: 250px; overflow-y: auto;">
                                                        <?php
                                                            $notifi = $mysql->query("SELECT * FROM `notifications` WHERE `user_id` = '$cook_id'");
                                                            $mess = Array();
                                                            $href = Array();
                                                            $data = Array();
                                                            
                                                            while($result = $notifi->fetch_assoc()){
                                                                $mess[] = $result['text'];
                                                                $href[] = $result['href'];
                                                                $data[] = $result['data'];
                                                            }

                                                            $num_notifi = 0;

                                                                if(count($mess) == count($href) && count($mess) != 0 && count($href) != 0 ){
                                                                while($num_notifi <= (count($mess) - 1)){
                                                                    echo("
                                                                        <a href='".$href[$num_notifi]."'>                               
                                                                            <div class='sl_sidebar_sugs' style='padding: 10px;'>
                                                                                <div style='margin-right: 15px; width: 30px;'>
                                                                                    <img src='https://img.icons8.com/windows/512/notification-center--v2.png' alt=''> 
                                                                                </div>

                                                                                <div class='sl_sidebar_sugs_text'>
                                                                                    <a class='wow_user_link_name'>".$mess[$num_notifi]."</a>
                                                                                    <span>");
                                                                                    if($mess[$num_notifi] == "В ваш аккаунт был произведён вход."){
                                                                                        echo("Время: ".date("H:m - d.m.Y", strtotime($data[$num_notifi])));
                                                                                    }else{
                                                                                        echo(date("d.m.Y", strtotime($data[$num_notifi])));
                                                                                    }
                                                                                    echo("</span>
                                                                                </div>

                                                                            </div>
                                                                        </a>
                                                                        
                                                                    ");
                                                                    $num_notifi = $num_notifi + 1;
                                                                }
                                                            }else{
                                                                echo("<a style='color: #db6724; cursor: default; text-align: center; display: block; padding: 50px;'>Уведомлений нет</a>");
                                                            }
                                                        ?>
                                                </div>
                                                <a style='color: #db6724; cursor: default; text-align: center; display: none;' id="none_notify">Уведомлений нет</a>
                                                </div>

                                            </ul>
                                        </div> 
    
                                        <div class="footer-wrapper-sidebar mt-4">
                                            <hr>
                
                                            <ul class="list-inline">
                                                <li><a href="https://api.unesell.com/">API</a></li>
                                            </ul>
                                            <br>
                                        </div>
                                </div>
    
                            </div>
    
                        </div>
                    </div>
    
                </div>
            </div>
    
          </main>
        </div>
        <!-- [id] content -->
    
        <?php
            include '../assets/component/footer.php';
        ?>

        <!-- Back to top with progress indicator-->
        <div class="prgoress_indicator">
          <svg class="progress-circle svg-content" width="100%" height="100%" viewBox="-1 -1 102 102">
            <path d="M50,1 a49,49 0 0,1 0,98 a49,49 0 0,1 0,-98" />
          </svg>
        </div>
    
    
      </div>
    <!-- Контент -->

    <script src="/assets/js/QRCode.js"></script>
    <script>
        const el = (selector) => document.querySelector(selector);

        function QRCodeGenerate(){
            document.getElementById("modal-default").style.display = "block";
            document.getElementById("modal-default").classList.remove("fade");
            document.getElementById('qrmodal').classList.add('modalAnim');

            let hash = pass_gen(32);

            $.ajax({
                url: '../api/qr_auth.php',
                type: 'GET',
                data:{id: '<?php echo($cook_id); ?>', hash: hash },
                success: function(data) {
                    console.log("success");
                    console.log(data);
                }, error: function(data){
                    console.log("error");
                    console.log(data);
                }
            });

            let qrCodeOutput = el('#qrCodeOutput');
            let text = hash;
            qrCodeOutput.innerHTML = "";
            qrCodeOutput.append(QRCode.generateHTML(text, {}));
        }

        function pass_gen(len) {
            chrs = 'abdehkmnpswxzABDEFGHKMNPQRSTWXZ123456789';
            var str = '';
            for (var i = 0; i < len; i++) {
                var pos = Math.floor(Math.random() * chrs.length);
                str += chrs.substring(pos,pos+1);
            }
            return str;
        }

        function frendsOpen(){
            document.getElementById("frands_page").classList.add("uk-active");
            document.getElementById("info_page").classList.remove("uk-active");

            document.getElementById("infoIncoming").style.display = "none";
            document.getElementById("frendsIncoming").style.display = "block";
        }

        function InfoOpen(){
            document.getElementById("info_page").classList.add("uk-active");
            document.getElementById("frands_page").classList.remove("uk-active");

            document.getElementById("infoIncoming").style.display = "block";
            document.getElementById("frendsIncoming").style.display = "none";
        }
    </script>
    <!-- particles -->
    <script src="../assets/js/vendor/particles.min.js" type="text/javascript"></script>
    <!-- TweenMax -->
    <script src="../assets/js/vendor/TweenMax.min.js" type="text/javascript"></script>
    <!-- ScrollMagic -->
    <script src="../assets/js/vendor/ScrollMagic.js" type="text/javascript"></script>
    <!-- animation.gsap -->
    <script src="../assets/js/vendor/animation.gsap.js" type="text/javascript"></script>
    <!-- addIndicators -->
    <script src="../assets/js/vendor/debug.addIndicators.min.js" type="text/javascript"></script>
    <!-- Swiper js -->
    <script src="../assets/js/vendor/swiper.min.js" type="text/javascript"></script>
    <!-- countdown -->
    <script src="../assets/js/vendor/countdown.js" type="text/javascript"></script>
    <!-- simpleParallax -->
    <script src="../assets/js/vendor/simpleParallax.min.js" type="text/javascript"></script>
    <!-- waypoints -->
    <script src="../assets/js/vendor/waypoints.min.js" type="text/javascript"></script>
    <!-- counterup -->
    <script src="../assets/js/vendor/jquery.counterup.min.js" type="text/javascript"></script>
    <!-- charming -->
    <script src="../assets/js/vendor/charming.min.js" type="text/javascript"></script>
    <!-- imagesloaded -->
    <script src="../assets/js/vendor/imagesloaded.pkgd.min.js" type="text/javascript"></script>
    <!-- BX-Slider -->
    <script src="../assets/js/vendor/jquery.bxslider.min.js" type="text/javascript"></script>
    <!-- Sharer -->
    <script src="../assets/js/vendor/sharer.js" type="text/javascript"></script>
    <!-- sticky -->
    <script src="../assets/js/vendor/sticky.min.js" type="text/javascript"></script>
    <!-- Aos -->
    <script src="../assets/js/vendor/aos.js" type="text/javascript"></script>
    <!-- main file -->
    <script src="../assets/js/main.js" type="text/javascript"></script>

</body>

</html>