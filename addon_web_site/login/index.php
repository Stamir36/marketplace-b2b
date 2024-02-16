<?php
//   http://localhost/login/?auth=yes &
    // http://localhost/login/?auth=yes&app=ModernNotify&service=%D0%9F%D1%80%D0%B8%D0%BB%D0%BE%D0%B6%D0%B5%D0%BD%D0%B8%D0%B5&data=2&icon=http://localhost/assets/img/icons/mnlogo.png
      
    $var_err = htmlspecialchars($_COOKIE["error"]);
    $auth = $_GET["auth"];
    $go = $_GET["go"];
    

    if(strlen(htmlspecialchars($_COOKIE["id"])) > 0){
      if($auth == "yes"){
        header('Location: /auth/?user='.htmlspecialchars($_COOKIE["id"]).'&'."app=".$_GET["app"]."&service=".$_GET["service"]."&data=".$_GET["data"]."&icon=".$_GET["icon"]."&out=".$_GET["out"]);
      }else{
        
        if($_GET["go"] == "mydevice"){
          header('Location: /app/mydevice/');
        }else if($_GET["go"] == "lipari"){
          header('Location: /app/lipari/');
        }else if($_GET["go"] == "cursus"){
          header('Location: /app/cursus/');
        }else if($_GET["go"] == "uStore"){
          header('Location: https://store.unesell.com');
        }else{
          header('Location: /account/');
        }

      } 
    }

    if( isset( $_POST['login_chek'] ) )
    {
      $email = filter_var(trim($_POST['email']), FILTER_SANITIZE_STRING);
      $pass = filter_var(trim($_POST['pass']), FILTER_SANITIZE_STRING);
      
      include "../service/config.php";

      $mysql = new mysqli($Host, $User, $Password, $Database);

      $result = $mysql->query("SELECT * FROM `accounts_users` WHERE `email` = '$email' AND `password` = '$pass'");
      $user = $result->fetch_assoc();
      
      if(count($user) == 0){
        setcookie('error', 1, time() + 10, "/");

        if($auth == "yes"){
          header('Location: /login/?auth=yes&'."app=".$_GET["app"]."&service=".$_GET["service"]."&data=".$_GET["data"]."&icon=".$_GET["icon"]."&out=".$_GET["out"]);
        }else{
          if(!empty($go)){
            header('Location: /login/?go=' + $go);
          }else{
            header('Location: /login/');
          }
        } 
      }else{
        setcookie('error', 1, time() - 10, "/");
        if($user['name'] == "User"){
          setcookie('id', $user['id'], time() + 3600 * 24, "/", $dns);
          header('Location: /registration/user/');
        }else{
          setcookie('mail', $user['email'], time() + 3600 * 24, "/", $dns);
          setcookie('name', $user['name'], time() + 3600 * 24, "/", $dns);
          setcookie('id', $user['id'], time() + 3600 * 24, "/", $dns);

          $iduser = $user['id'];

          if($auth == "yes"){
            $mysql->close();
            header('Location: /auth/?user='.$user['id'].'&'."app=".$_GET["app"]."&service=".$_GET["service"]."&data=".$_GET["data"]."&icon=".$_GET["icon"]."&out=".$_GET["out"]);
          }else{
            if($user['notify_singin'] == "checked"){
              $mysql->query("INSERT INTO `notifications` (`user_id`, `text`, `href`, `data`) VALUES ('$iduser', 'В ваш аккаунт был произведён вход.', '', CURRENT_TIMESTAMP)");  
            }
            $mysql->close();
            if($_GET["go"] == "mydevice"){
              header('Location: /app/mydevice/');
            }else if($_GET["go"] == "lipari"){
              header('Location: /app/lipari/');
            }else if($_GET["go"] == "cursus"){
              header('Location: /app/cursus/');
            }else if($_GET["go"] == "uStore"){
              header('Location: https://store.unesell.com');
            }else{
              header('Location: /');
            }
          }
        }
      }
    }
?>


<!DOCTYPE html>
<html lang="ru">

<head>
   <meta charset="UTF-8" />
   <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
   <meta http-equiv="X-UA-Compatible" content="IE=edge" />
   <meta http-equiv="X-UA-Compatible" content="ie=edge" />
   <meta name="viewport" content="width=device-width, initial-scale=1.0" />
   <meta name="viewport" content="width=device-width, initial-scale=1.0" />
   <meta name="description"
     content="Вхід до облікового запису Unesell Studio для доступу до всіх сервісів." />
   <meta name="keywords"
     content="HTML, CSS, JavaScript, Bootstrap, jQuery, Rakon, Themeforest, Template, envato, SASS, SCSS, HTML5, landing page, SaaS Product, SaaS Modern, MultiPurpose, Crypto, Currency, ICO, Hosting, Agency, Mobile, App, Interior, Charity" />
   <meta name="author" content="Unesell Studio" />



   <title>Unesell Account - Вхід до облікового запису</title>
   <link href="https://cdnjs.cloudflare.com/ajax/libs/flowbite/1.6.4/flowbite.min.css" rel="stylesheet" />
   <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/tailwindcss@2.0.1/dist/tailwind.min.css">

   <!-- favicon -->
   <link rel="shortcut icon" href="../assets/img/favicon.ico" type="image/x-icon" />
   <!-- Bootstrap 4.5 -->
   <link rel="stylesheet" href="../assets/css/main/bootstrap.min.css" type="text/css" />
   <!-- animate -->
   <link rel="stylesheet" href="../assets/css/main/animate.css" type="text/css" />
   <!-- Swiper -->
   <link rel="stylesheet" href="../assets/css/main/swiper.min.css" />
   <!-- icons -->
   <link rel="stylesheet" href="../assets/css/main/icons.css" type="text/css" />
   <!-- aos -->
   <link rel="stylesheet" href="../assets/css/main/aos.css" type="text/css" />
   <!-- main css -->
   <link rel="stylesheet" href="../assets/css/main/main.css" type="text/css" />
   <link rel="stylesheet" href="../assets/css/main/main_add.css" type="text/css" />
   <!-- normalize -->
   <link rel="stylesheet" href="../assets/css/main/normalize.css" type="text/css" />
   <!--New Style Beekeeper portal-->
   <link rel="stylesheet" href="../assets/css/main/new_style.css" type="text/css" />

   <style>
     #credential_picker_container {
       bottom: 0px !important;
       top: auto !important;
     }
   </style>
   <script src="/assets/js/jquery-3.5.0.js" type="text/javascript"></script>
</head>

<body>
   <div id="wrapper">
     <div id="content">
     <div id="defaultModalBackdrop" class="hidden fixed inset-0 opacity-50 z-40" onclick="closeModal();"></div>
     <div id="defaultModal" class="hidden fixed inset-0 flex items-center justify-center z-50">
       <div class="relative w-full max-w-2xl max-h-full bg-white rounded-lg shadow dark:bg-gray-700">
       <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
                 <!-- Modal header -->
                 <div class="flex items-start justify-between p-4 border-b rounded-t dark:border-gray-600">
                     Як дізнатися пароль, якщо входиш через Google? </h3>
                     <button onclick="closeModal()" type="button" class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm p-1.5 ml- auto inline-flex items-center dark:hover:bg-gray-600 dark:hover:text-white" data-modal-hide="defaultModal">
                         <svg aria-hidden="true" class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"> <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4 4 1.414L10 11.414l- 4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path></svg>
                         <span class="sr-only">Закрити вікно</span>
                     </button>
                 </div>
                 <!-- Modal body -->
                 <div class="p-6 space-y-6">
                     <p class="text-base leading-relaxed text-gray-500 dark:text-gray-400">
                         При реєстрації за допомогою Google або Facebook обліковий запис не має пароля, тому увійти в обліковий запис без тимчасового цифрового пароля неможливо.
                     </p>
                     <p class="text-base leading-relaxed text-gray-500 dark:text-gray-400">
                         Щоб прив'язати пароль до свого облікового запису, виберіть "Відновити пароль" і вкажіть пошту, яка вказується на сторінці облікового запису.
                     </p>
                 </div>
                 <!-- Modal footer -->
                 <div class="flex items-center p-6 space-x-2 border-t border-gray-200 rounded-b dark:border-gray-600">
                     <button onclick="closeModal()" data-modal-hide="defaultModal" type="button" class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline- none focus:ring-blue-300 font-medium закруглений-lg текст-см px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue- 800">Зрозуміло</button>
                     <button onclick="document.location.href = 'recovery/';" data-modal-hide="defaultModal" type="button" class="text-gray-500 bg-white hover:bg-gray-100 focus:ring-4 focus:outline-none focus:ring-blue-300 rounded -lg border border-gray-200 text-sm font-medium px-5 py-2.5 hover:text-gray-900 focus:z-10 dark:bg-gray-700 dark:text-gray-300 dark:border- gray-500 dark:hover:text-white dark:hover:bg-gray-600 dark:focus:ring-gray-600">Відновити пароль</button>
                 </div>
             </div>
       </div>
     </div>
       <section class="section_account">
         <div class="container-fluid">
           <div class="row">
             <div class="col-md-6 col-lg-4 pc">
               <div class="fixed_side_data" style="background: #4e46dc; background-size: cover; background-repeat: no-repeat;">
                 <div class="head_nav">
                   <a class="btn btn_logo">
                     <img src="../assets/img/icon.png" style="width: 40xp; height: 40px;"/>
                   </a>
                   <h3 class="title_nav">Один обліковий запис<br />Весь світ Unesell.</h3><br/><br/>
                   <?php
                     if($_GET["go"] == "mydevice"){
                       echo("<h5 style='color: white;'>Авторизація у додатку MyDevice</h5><a style='color: white; font-size: 14px;'>Unesell Studio</a>");
                     }else if($_GET["go"] == "lipari"){
                       echo("<h5 style='color: white;'>Авторизація в додатку LiPari</h5><a style='color: white; font-size: 14px;'>Unesell Studio</a>");
                     }else if($_GET["go"] == "cursus"){
                       echo("<h5 style='color: white;'>Авторизація в додатку Cursus - Месенджер</h5><a style='color: white; font-size: 14px;'>Unesell Studio</a>");
                     }else if($_GET["go"] == "uStore"){
                       echo("<h5 style='color: white;'>Авторизація в додатку<br>uStore - Маркетплейс B2B</h5><a style='color: white; font-size: 14px;'>Unesell Studio</a >");
                     }else{
                       echo("<h5 style='color: white;'>Вхід до облікового запису</h5><a style='color: white; font-size: 14px;'>Unesell Studio</a>");
                     }
                   ?>
                 <br>
                
                 <div class="login_card_info w-full max-w-sm p-4 border border-gray-200 rounded-lg shadow sm:p-6 dark:bg-gray-800 dark:border-gray-700">
                     <h5 class="mb-3 text-base font-semibold text-gray-900 md:text-xl dark:text-white" style="color: white;">
                         Псс, зберігай свої паролі 🤭
                     </h5>
                     <p>Ваш один обліковий запис - доступ до всіх сервісів і сайтів, які підключені до системи. </p>

                     <div>
                         <a onclick='document.location.href = `../service/rule/`;' class="open-modal-button inline-flex items-center text-xs font-normal text-gray-500 hover:underline dark:text-gray-400" style="color: white;">
                           <svg class="w-3 h-3 mr-2" aria-hidden="true" focusable="false" data-prefix="far" data-icon="question-circle" role="img" xmlns= "http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path fill="currentColor" d="M256 8C119.043 8 8 119.083 8 256c0 136.997 124 003 248-248C504 119.083 392.957 8 256 8zm0 448c-110.532 0-200-89.431-200-200 0-110.495 89.472-2004 2004 1 200 200 0 110.53-89.431 200-200 200zm107.244-255.2c0 67.052- 72.421 68.084-72.421 92.863V300c0 6.627-5.373 12-12 12h-45.647c-6.627 0-12-5.373-12-12v-8.65935-2 -61.516 17.561-9.845 28.324-16.541 28.324-29.579 0-17.246 -21.999-28.693-39.784-28.693-23.189 0-33.894 10.977-48.942 29.969-4.057 5.12-11.46 6.071-16.682 2. 7-3.872-6.251-11.066-2.644-16.363C184.846 131.491 214.94 112 261.794 112c49.071 0 101.45 38.304 101.45 88.8zM298 368c0 23.159-18.841 42-42 42s-42-18.841-42442 41 42 42z"></path></svg>
                           Політика конфіденційності сервісу
                         </a>
                         <a onclick="openModal();" class="open-modal-button inline-flex items-center text-xs font-normal text-gray-500 hover:underline dark:text-gray-400" style="color: white;">
                           <svg class="w-3 h-3 mr-2" aria-hidden="true" focusable="false" data-prefix="far" data-icon="question-circle" role="img" xmlns= "http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path fill="currentColor" d="M256 8C119.043 8 8 119.083 8 256c0 136.997 124 003 248-248C504 119.083 392.957 8 256 8zm0 448c-110.532 0-200-89.431-200-200 0-110.495 89.472-2004 2004 1 200 200 0 110.53-89.431 200-200 200zm107.244-255.2c0 67.052- 72.421 68.084-72.421 92.863V300c0 6.627-5.373 12-12 12h-45.647c-6.627 0-12-5.373-12-12v-8.65935-2 -61.516 17.561-9.845 28.324-16.541 28.324-29.579 0-17.246 -21.999-28.693-39.784-28.693-23.189 0-33.894 10.977-48.942 29.969-4.057 5.12-11.46 6.071-16.666 2.124l-27.824-21.092-2. 2.644-16.363C184.846 131.491 214.94 112 261.794 112c49.071 0 101.45 38.304 101.45 88.8zM298 368c0 23.159-18.841 42-42 42s-42-18.841-42-42 18.841-42 42-42 42 18.841 42"></path></svg>
                           Як дізнатися пароль, якщо входиш через Google?
                         </a>
                     </div>
                 </div>
  
             </div>
               </div>
             </div>
             <div class="col-md-6 col-lg-5 mx-auto">

               <div class="have_account">
                   <a href="../registration/">
                     <button type="button" class="text-gray-900 bg-white hover:bg-gray-100 border border-gray-200 focus:ring-4 focus:outline-none focus:ring-gray-100 font- medium rounded-lg text-sm px-5 py-2.5 text-center inline-flex items-center dark:focus:ring-gray-600 dark:bg-gray-800 dark:border-gray-700 dark:text-white dark:hover:bg-gray-700 mr-2 mb-2">
                       Реєстрація облікового запису
                     </button>
                   </a>
               </div>

               <div class="box--signup" style="padding-bottom: 90px;">
                 <div class="title">
                   <p class="m-0 mt-5 title-f-25">Ласкаво просимо!</p>
                   <a style="font-size: 12px;">Unesell Акаунт</a>
                 </div>
                 <div class="other_login">
                
                
                
                 <script src="https://accounts.google.com/gsi/client" async defer>
                     document.getElementById("credential_picker_container").style = "position: sticky !important; top: auto !important; bottom: 0px !important;";
                 </script>
                
                 <div id="g_id_onload"
                      data-client_id="786154684558-9hmlps6ckjf98c83ge0flg0fo7mn1apm.apps.googleusercontent.com"
                      data-callback="handleCredentialResponse">
                 </div>

                 <a class='btn' style='padding-left: 0px;padding-right: 0px;'>
                     <div class="g_id_signin" data-type="standard"></div>
                 </a>

                 <?php
                     $params = array(
                       'client_id' => '786154684558-9hmlps6ckjf98c83ge0flg0fo7mn1apm.apps.googleusercontent.com',
                       'redirect_uri' => 'https://unesell.com/redirect/',
                       'response_type' => 'code',
                       'scope' => 'https://www.googleapis.com/auth/userinfo.email https://www.googleapis.com/auth/userinfo.profile',
                       'state' => '123'
                     );
                    
                     $url = 'https://accounts.google.com/o/oauth2/auth?' . urldecode(http_build_query($params));
                     //echo ("<a href='".$url."' class='btn scale bGoogle'> <img src='/assets/img/GLogo.png' style='width: 20px; height: 20px; margin-right: 10px;'> Вхід за допомогою Google </a>");

                     $params = array(
                       'client_id' => '788687608542815',
                       'redirect_uri' => 'https://unesell.com/redirect/facabook.php',
                       'scope' => 'email',
                       'response_type' => 'code',
                       'state' => '123'
                     );
                     
                     $url = 'https://www.facebook.com/dialog/oauth?' . urldecode(http_build_query($params));
                     echo "<a href='" . $url . "'><button type='button' class='btn scale btn_twitter' style='height: 40px;'> <i class='tio facebook'></i> </button></a>";
                 ?>

                   <a href="qr/" class='btn scale btn_twitter' style="height: 40px; width: 45px;"> <img src='/assets/img/icons/QR.png' style='width: 20px ;height: 20px;margin-right: 10px;margin-top: 3px;'></a>
                   <div class="line-or">
                     <span class="or">Або</span>
                   </div>
                 </div>

                
               <form method="POST" class="row" id="loginForm">

                 <div class="col-12">
                   <div class="form-group">
                     <label>Email адреса</label>
                     <input type="email" name="email" class="form-control" placeholder="Ваша пошта" id="mailForm">
                   </div>
                 </div>

                 <div class="col-md-12">
                   <div class="form-group --password" id="show_hide_password">
                     <label>Пароль</label>
                     <div class="input-group">
                       <input type="password" class="form-control" data-toggle="password" name="pass" placeholder="Введіть пароль"
                         required="" id="passForm"/>
                       <div class="input-group-prepend hide_show">
                         <a href=""><span class="input-group-text tio hidden_outlined"></span></a>
                       </div>
                     </div>
                   </div>
                 </div>

                 <div class="col-12" id="error_block" style="display: none;">
                   <div class="alert alert-danger" role="alert">
                     <a style="font-size: 14px; cursor:default;">Неправильно вказані дані, пошта або пароль.</a>
                   </div>
                 </div>

                   <div class="col-12">
                     <input type="submit" class="btn margin-t-1 btn_md_primary btn_account bg-blue c-white rounded-8" name="login_chek" value="Вхід до облікового запису" />
                     <a href="recovery/" class="d-flex justify-content-end font-s-13 c-blue forgot_pass">Забули пароль?</a>
                   </div>

                 </form>
                
               </div>
             </div>
           </div>
         </div>
       </section>
     </div>
     <!-- [id] content -->
   </div>
   <!-- End. Wrapper -->
     <script>
    
     // Google Authentication
     function decodeJwtResponse(token) {
         let base64Url = token.split('.')[1]
         let base64 = base64Url.replace(/-/g, '+').replace(/_/g, '/');
         let jsonPayload = decodeURIComponent(atob(base64).split('').map(function(c) {
             return '%' + ('00' + c.charCodeAt(0).toString(16)).slice(-2);
         }).join(''));
         return JSON.parse(jsonPayload)
     }
    
         window.handleCredentialResponse = (response) => {
           // decodeJwtResponse() is a custom function defined by you
           // to decode the credential response.
           responsePayload = decodeJwtResponse(response.credential);
        
           console.log("ID:" + responsePayload.sub);
           console.log('Full Name:' + responsePayload.name);
           console.log("Image URL: " + responsePayload.picture);
           console.log("Email:" + responsePayload.email);

             //google.auth.php
                 $.ajax({
                     url: '/redirect/google.auth.php',
                     type: 'GET',
                     data:{id: responsePayload.sub, name: responsePayload.name, email: responsePayload.email, picture: responsePayload.picture},
                     success: function(data) {
                         location.href = "/";
                     }
                 });
         }

       window.onload = function() {
         google.accounts.id.initialize({
           client_id: '786154684558-9hmlps6ckjf98c83ge0flg0fo7mn1apm.apps.googleusercontent.com',
           callback: handleCredentialResponse
         });
         google.accounts.id.prompt();
       };
  
  
     <?php
           if($var_err == 1){
             echo("
               errors = 1;
             ");
           }else{
             echo("
               errors = 0;
             ");
           }
     ?>
     if(errors == 1 || errors == "1"){
         var ell = document.getElementById('error_block');
         ell.style = 'display: inline';
     }

     // Отримуємо посилання на елементи модального вікна та заднього фону
     const modal = document.getElementById('defaultModal');
     const backdrop = document.getElementById('defaultModalBackdrop');

     function openModal() {
       modal.classList.add('show');
       backdrop.classList.add('show');
       modal.classList.remove('hidden');
       backdrop.classList.remove('hidden');
     }

     function closeModal() {
       modal.classList.remove('show');
       backdrop.classList.remove('show');
       modal.classList.add('hidden');
       backdrop.classList.add('hidden');
     }

   </script>

</body>

</html>