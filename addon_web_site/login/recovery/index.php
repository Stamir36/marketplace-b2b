<?php 
    $var_err = htmlspecialchars($_COOKIE["error"]);
    

    if(strlen(htmlspecialchars($_COOKIE["id"])) > 0){
      header('Location: /account/');
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
     content="Відновлення пароля Unesell Account" />
   <meta name="keywords"
     content="HTML, CSS, JavaScript, Bootstrap, jQuery, Rakon, Themeforest, Template, envato, SASS, SCSS, HTML5, landing page, SaaS Product, SaaS Modern, MultiPurpose, Crypto, Currency, ICO, Hosting, Agency, Mobile, App, Interior, Charity" />
   <meta name="author" content="Unesell Studio" />

   <title>Unesell Account - Відновлення пароля</title>
   <link href="https://cdnjs.cloudflare.com/ajax/libs/flowbite/1.6.4/flowbite.min.css" rel="stylesheet" />
   <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/tailwindcss@2.0.1/dist/tailwind.min.css">
   <!-- favicon -->
   <link rel="shortcut icon" href="../../assets/img/favicon.ico" type="image/x-icon" />
   <!-- Bootstrap 4.5 -->
   <link rel="stylesheet" href="../../assets/css/main/bootstrap.min.css" type="text/css" />
   <!-- animate -->
   <link rel="stylesheet" href="../../assets/css/main/animate.css" type="text/css" />
   <!-- Swiper -->
   <link rel="stylesheet" href="../../assets/css/main/swiper.min.css" />
   <!-- icons -->
   <link rel="stylesheet" href="../../assets/css/main/icons.css" type="text/css" />
   <!-- aos -->
   <link rel="stylesheet" href="../../assets/css/main/aos.css" type="text/css" />
   <!-- main css -->
   <link rel="stylesheet" href="../../assets/css/main/main.css" type="text/css" />
   <link rel="stylesheet" href="../../assets/css/main/main_add.css" type="text/css" />
   <!-- normalize -->
   <link rel="stylesheet" href="../../assets/css/main/normalize.css" type="text/css" />
   <link rel="stylesheet" href="../../assets/css/main/new_style.css" type="text/css" />
</head>

<body>
   <div id="wrapper">
     <div id="content">
       <section class="section_account">
         <div class="container-fluid">
           <div class="row">
             <div class="col-md-6 col-lg-4 pc">
               <div class="fixed_side_data" style="background: #4e46dc; background-size: cover; background-repeat: no-repeat;">
                 <div class="head_nav">
                   <a class="btn btn_logo">
                     <img src="../../assets/img/icon.png" style="width: 40xp; height: 40px;"/>
                   </a>
                   <h3 class="title_nav">Один обліковий запис<br />Весь світ Unesell.</h3><br/><br/>
                   <h5 style='color: white;'>Відновлення пароля</h5><a style='color: white; font-size: 14px;'>Unesell Studio</a>
                 </div>
               </div>
             </div>

             <div class="col-md-6 col-lg-5 mx-auto">
               <div class="have_account">
                 <a href="../">
                   <button type="button" class="text-gray-900 bg-white hover:bg-gray-100 border border-gray-200 focus:ring-4 focus:outline-none focus:ring-gray-100 font- medium rounded-lg text-sm px-5 py-2.5 text-center inline-flex items-center dark:focus:ring-gray-600 dark:bg-gray-800 dark:border-gray-700 dark:text-white dark:hover:bg-gray-700 mr-2 mb-2">
                     Повернутися на вхід до облікового запису
                   </button>
                 </a>
               </div>

               <div class="box--signup" style="padding-bottom: 90px;">
                 <div class="title">
                   <p class="m-0 mt-5 title-f-25">Відновлення пароля</p>
                   <a class="mt-1" style="font-size: 12px; color: currentcolor;" id="info_text">Щоб відновити пароль, вкажіть свою адресу електронної пошти, яку ви вказували при реєстрації.</a>
                 </div>

                 <div class="other_login">

                 <div style="padding-top: 50px; display: none;" id="loader">
                   <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" style="margin:auto;background:#fff; display:block;" width="100px" height="100px" viewBox="0 0 100 100" preserveAspectRatio="xMidYMid">
                   <circle cx="50" cy="50" r="30" stroke="#46dff0" stroke-width="10" fill="none"></circle>
                   <circle cx="50" cy="50" r="30" stroke="#e90c59" stroke-width="8" stroke-linecap="round" fill="none">
                     <animateTransform attributeName="transform" type="rotate" repeatCount="indefinite" dur="1s" values="0 50 50;180 50 50;720 50 50" keyTimes="0;0.5;1"></animateTransform >
                     <animate attributeName="Stroke-dasharray" repeatCount="indefinite" dur="1s" 153876 169.64600329384882" keyTimes="0;0.5;1"></animate>
                   </circle>
                   </svg>
                 </div><!-- STEP 1 -->

                <form class="row" style="padding-top: 30px;" id="mail_account">

                  <div class="col-12">
                    <div class="form-group">
                      <label>Email адреса</label>
                      <input type="email" name="email" id="email" class="form-control" placeholder="Ваша пошта при реєстрації">
                    </div>
                  </div>

                  <div class="col-12" id="error_block" style="display: none;">
                    <div class="alert alert-danger" role="alert">
                      <a style="font-size: 14px; cursor:default;">Така пошта не знайдена в системі.</a>
                    </div>
                  </div>

                    <div class="col-12">
                      <a onclick="sendMail()" class="btn margin-t-3 btn_md_primary btn_account bg-blue c-white rounded-8">Надіслати код відновлення<a>
                    </div>

                </form>

                  <!-- STEP 2 -->

                  <form class="row" style="padding-top: 30px; display: none;" id="code_input">

                    <div class="col-12">
                      <div class="form-group">
                        <label>Код відновлення пароля:</label>
                        <input id="codes" type="text" class="form-control" placeholder="Код: 000000">
                      </div>
                    </div>

                    <div class="col-12" id="error_block_code" style="display: none;">
                      <div class="alert alert-danger" role="alert">
                        <a style="font-size: 14px; cursor:default;">Код неправильний.</a>
                      </div>
                    </div>

                      <div class="col-12">
                        <a onclick="checkcode()" class="btn margin-t-3 btn_md_primary btn_account bg-blue c-white rounded-8">Перевірити код<a>
                      </div>

                    </form>
                  
                  <!-- STEP 3 -->

                  <form class="row" style="padding-top: 30px; display: none;" id="new_password">

                    <div class="col-12">
                      <div class="form-group">
                        <label>Введіть новий пароль:</label>
                        <input id="pass" type="text" class="form-control" placeholder="Від 8 символів.">
                      </div>
                    </div>

                    <div class="col-12" id="error_block_password" style="display: none;">
                      <div class="alert alert-danger" role="alert">
                        <a style="font-size: 14px; cursor:default;">Пароль не відповідає правилам безпеки.</a>
                      </div>
                    </div>

                    <div class="col-12">
                      <a onclick="savepassword()" class="btn margin-t-3 btn_md_primary btn_account bg-blue c-white rounded-8">Зберегти новий пароль<a>
                    </div>

                  </form>

                <!-- STEP 4 -->

                  <form class="row" style="padding-top: 30px; display: none;" id="fast_login">
                  
                    <div class="col-12">
                      <div class="form-group">
                        <label>Пароль успішно змінено. Бажаєте відразу увійти до системи?</label>
                      </div>
                    </div>
                      <div class="col-12">
                        <a onclick="document.location.href = '/login/';" class="btn btn_md_primary btn_account bg-orange c-white rounded-8">Ні<a>
                        <a onclick="fastlogin()" class="btn btn_md_primary btn_account bg-blue c-white rounded-8">Увійти до системи<a>
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
                <script src="/assets/js/jquery-3.5.0.js" type="text/javascript"></script>
                <script src="recovery.js"></script>

                </body>

</html>