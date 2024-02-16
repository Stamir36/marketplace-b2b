<?php
session_start();
?>
<!DOCTYPE html>
<html lang="ru" >
<head>
   <meta charset="UTF-8">
   <title>Unesell Account - Завершення реєстрації</title>
   <link rel="stylesheet" href="./style.css">
   <link rel="shortcut icon" href="../../assets/img/favicon.ico" type="image/x-icon" />
   <meta name="viewport" content="width=device-width, initial-scale=1.0" />

   <script>
var step = 0;
   </script>

</head>
<body>

<?php
     if (isset($_SESSION['message']) && $_SESSION['message'])
     {
       printf('<b>%s</b>', $_SESSION['message']);
       unset($_SESSION['message']);
     }
   ?>

<!-- partial:index.partial.html -->
<div class="container">

<h4 id="banner" style="padding: 0; margin: 0; font-size: 10px; color: cornflowerblue;">Завершення реєстрації</h4>
<h2 id="banner2" style="padding: 0; margin: 0; font-size: 18px; color: darkgoldenrod;">Дані про користувача.</h2>

<div id="form-wrap">
<form action=end_reg.php method=post enctype=multipart/form-data id="FormID">
<!-- Question One -->
<div class="question">
<h1>Ваш нікнейм</h1>
<input type="text" id="name_form" name="name" placeholder="Не менше 4 символів"></input>

<a class="buttons" onclick="step++" id="step_1">
<div class="arrow-6">
<svg width="18px" height="17px" viewBox="-1 0 18 17" version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http: //www.w3.org/1999/xlink">
<g>
<polygon class="arrow-6-pl" points="16.3746667 8.33860465 7.76133333 15.3067621 6.904 14.3175671 14.2906667 8.892 6.9 76 1.43613596"></polygon>
<polygon class="arrow-6-pl-fixed" points="16.3746667 8.33860465 7.76133333 15.3067621 6.904 14.3175671 14.29066668 8.3 7.76 1.43613596"></polygon>
<path d="M-4.58892184e-16,0.56157424 L-4.58892184e-16,16.1929159 L9.708,8.33860465 L-1.64313008e-15,1848 .56157424 Z M1.33333333,3.30246869 L7. 62533333,8.34246869 L1.33333333,13.4327013 L1.33333333,3.30246869 L1.33333333,3.30246869 Z"></path>
</g>
</svg>
</div>
</a>

</div>

<!-- Question Two -->
<div class="question">
<h1>Ваша дата народження</h1>
<input type="date" id="Date_of_Birth" name="Date_of_Birth"></input>

<a class="buttons" onclick="step++" id="step_2">
<div class="arrow-6">
<svg width="18px" height="17px" viewBox="-1 0 18 17" version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http: //www.w3.org/1999/xlink">
<g>
<polygon class="arrow-6-pl" points="16.3746667 8.33860465 7.76133333 15.3067621 6.904 14.3175671 14.2906667 8.892 6.9 76 1.43613596"></polygon>
<polygon class="arrow-6-pl-fixed" points="16.3746667 8.33860465 7.76133333 15.3067621 6.904 14.3175671 14.29066668 8.3 7.76 1.43613596"></polygon>
<path d="M-4.58892184e-16,0.56157424 L-4.58892184e-16,16.1929159 L9.708,8.33860465 L-1.64313008e-15,1848 .56157424 Z M1.33333333,3.30246869 L7. 62533333,8.34246869 L1.33333333,13.4327013 L1.33333333,3.30246869 L1.33333333,3.30246869 Z"></path>
</g>
</svg>
</div>
</a>

</div>

<!-- Question Three -->
<div class="question">
<h1>Останнє - Ваш аватар.</h1>
<input type="text" value="Виберіть файл" id="selected_filename" style="background: #CDF1D7;" disabled><input type="file" name="uploadfile" class="file_upload" id="file_upload" accept="image/jpeg,image/png"></input></input>

<a class="buttons" onclick="step++" id="step_3">
<div class="arrow-6">
<svg width="18px" height="17px" viewBox="-1 0 18 17" version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http: //www.w3.org/1999/xlink">
<g>
<polygon class="arrow-6-pl" points="16.3746667 8.33860465 7.76133333 15.3067621 6.904 14.3175671 14.2906667 8.892 6.9 76 1.43613596"></polygon>
<polygon class="arrow-6-pl-fixed" points="16.3746667 8.33860465 7.76133333 15.3067621 6.904 14.3175671 14.29066668 8.3 7.76 1.43613596"></polygon>
<path d="M-4.58892184e-16,0.56157424 L-4.58892184e-16,16.1929159 L9.708,8.33860465 L-1.64313008e-15,1848 .56157424 Z M1.33333333,3.30246869 L7. 62533333,8.34246869 L1.33333333,13.4327013 L1.33333333,3.30246869 L1.33333333,3.30246869 Z"></path>
</g>
</svg>
</div>
</a>

</div>

<!-- Completion Message -->
<div class="completed">
<img src="https://media.giphy.com/media/XBumSnvroiGxUSoDkZ/giphy.gif">
<h1>Дякую, дані заповнені!<br/> Приємної роботи!</h1>
<p>Усю інформацію ви зможете переглянути у профілі.</p>
</div>
</form>
</div> <!--#form-wrap-->
</div> <!--.container-->
<!-- partial -->
   <script src='https://code.jquery.com/jquery-2.2.4.min.js'></script>
<script src='https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js'></script><script src="./script.js"></script>

<script>
var go_one = 0;
let timerId = setInterval(() => go(), 100);
let timerCheck = setInterval(() => check(), 10);

function check(){
var steps_1 = document.getElementById("name_form").value;
var steps_2 = document.getElementById("Date_of_Birth").value;
var steps_3 = document.getElementById("selected_filename").value;

if(Number(steps_1.length) < 4){
var style1 = document.getElementById("step_1");
style1.style = "z-index: -1000; background: #ff5b8c;";
}else{
var style1 = document.getElementById("step_1");
style1.style = "z-index: 0; background: #5d5bff;";
}

if(Number(steps_2.length) < 5){
var style1 = document.getElementById("step_2");
style1.style = "z-index: -1000; background: #ff5b8c;";
}else{
var style1 = document.getElementById("step_2");
style1.style = "z-index: 0; background: #5d5bff;";
}

if(steps_3 == "Виберіть файл") {
var style1 = document.getElementById("step_3");
style1.style = "z-index: -1000; background: #ff5b8c;";
}else{
var style1 = document.getElementById("step_3");
style1.style = "z-index: 0; background: #5d5bff;";
}
}

function go_php(){
var form = document.getElementById("FormID");
form.submit();
}

function go(){
if(step == 3) {
var bann = document.getElementById('banner');
var bann2 = document.getElementById('banner2');
bann.style = "display: none;";
bann2.style = "display: none;";

if(go_one == 0) {
go_one = 1;
setTimeout(go_php, 2000);
}
}
}

$(function(){
$("#file_upload").change(function(){
document.getElementById('selected_filename').value = "Файл: " + $(this).val();
});
});

var coki = document.cookie;
var cooki = coki.split('; ');

for(i = 0; i <= cooki.length; i++){
var search = cooki [i];
var result = search.split('=');
if(result[0] == "Date_of_Birth"){
login(result[1]);
}
}
function login(PDate_of_Birth){
var Date_of_Births = document.getElementById("Date_of_Birth");
Date_of_Births.value = PDate_of_Birth;
}

$('input:file').change(
     function(e){
         alert(e.target.files[0].name);
     });

</script>

</body>
</html>