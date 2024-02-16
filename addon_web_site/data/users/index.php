<?php
session_start(); 
?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="UTF-8" />
  <title>Загрузка аватара</title>
  <link rel="stylesheet" href="../../css/login.css">
  <link rel="stylesheet" href="../account.css">
</head>
<body>
  <?php
    if (isset($_SESSION['message']) && $_SESSION['message'])
    {
      printf('<b>%s</b>', $_SESSION['message']);
      unset($_SESSION['message']);
    }
  ?>
    <section id="section">
      <div class="container">
        <div class="user singInBx">
            <div class="formBx">
              <form action=upload.php method=post enctype=multipart/form-data>
              <input type=file name=uploadfile>
              <input type=submit value=Загрузить> <a class="new" href="../account.html">Назад</a> </form>
            </div>
          </div>
        </div>
      </section>
</body>
</html>
