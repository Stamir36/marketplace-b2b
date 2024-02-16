function sendMail(){
    var email = document.getElementById("email").value;
    if(email.length = 0){
      return;
    }else{
      $.ajax({
        url: 'check.mail.php',
        type: 'GET',
        data:{email: email},
        success: function(data) {
          let Info = JSON.parse(data);
          
          if(Info.count > 0){
            // почта зарегистрированна в системе
            document.getElementById('error_block').style.display = "none";
            document.getElementById('mail_account').style.display = "none";
            document.getElementById('loader').style.display = "block"; 
            
            $.ajax({
              url: '/api/mail/reset.mail.php',
              type: 'GET',
              data:{email: email},
              success: function(data) {
                document.getElementById('loader').style.display = "none"; 
                document.getElementById('info_text').textContent = "Введите проверочный код, который был отправлен на ваш электронный адрес.";
                document.getElementById('code_input').style.display = "block";
              }
          });



          }else{
            // такой почты не существует
            document.getElementById('error_block').style.display = "block";
          }

        }
    });
    }
}

function checkcode(){
  document.getElementById('code_input').style.display = "none";
  document.getElementById('error_block_code').style.display = "none";
  document.getElementById('loader').style.display = "block";

  $.ajax({
    url: 'hash.php',
    type: 'GET',
    data:{code: document.getElementById("codes").value, mail: document.getElementById("email").value},
    success: function(data) {
      if(data != "0"){
        let Info = JSON.parse(data);
        document.getElementById('loader').style.display = "none";
        document.getElementById('info_text').textContent = "Привет, " + Info.name + ", введи новый пароль для входа в систему.";
        document.getElementById('new_password').style.display = "block";
      }else{
        document.getElementById('code_input').style.display = "block";
        document.getElementById('error_block_code').style.display = "block";
        document.getElementById('loader').style.display = "none";
      }
    }
  });
}

function savepassword(){
  document.getElementById('error_block_password').style.display = "none";

  if(document.getElementById("pass").value.length >= 8){
    document.getElementById('loader').style.display = "block";
    $.ajax({
      url: 'reset.password.php',
      type: 'GET',
      data:{pass: document.getElementById("pass").value, mail: document.getElementById("email").value},
      success: function(data) {
        if(data != "0"){
          document.getElementById('fast_login').style.display = "block";
          document.getElementById('loader').style.display = "none";
          document.getElementById('new_password').style.display = "none";
          document.getElementById('info_text').textContent = "Смена пароля завершена.";
        }else{
          document.getElementById('loader').style.display = "none";
          alert("Возникла непредвиденая ошибка, убедитесь, что файлы cookies включены. Попробуйте ещё раз повторить операцию или обратитесь в поддержду. Код ошибки: 3.");
        }
      }
    });
  }else{
    document.getElementById('error_block_password').style.display = "block";
  }
}

function fastlogin(){
  document.getElementById('loader').style.display = "block";
  document.getElementById('fast_login').style.display = "none";
  $.ajax({
    url: 'fastlogin.php',
    type: 'GET',
    data:{mail: document.getElementById("email").value, pass: document.getElementById("pass").value},
    success: function(data) {
      if(data != "0"){
        location.href = "/";
      }else{
        alert("Возникла непредвиденая ошибка, убедитесь, что файлы cookies включены. Попробуйте ещё раз повторить операцию или обратитесь в поддержду. Код ошибки: 4.");
      }
    }
  });
}