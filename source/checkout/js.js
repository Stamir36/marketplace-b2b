function user_details(){
    document.getElementById("step_menu_1").classList.add("slide-out");
    document.getElementById("step_menu_2").classList.add("slide-in");
    document.getElementById("step_2").classList.add("active");
    document.getElementById("step_menu_2").classList.remove("step_menu_hide");
}

var first_name;
var last_name;
var email;
var phone;
var country;
var post_code;
var address;
var order_number = randomInteger(1000000, 9999999);

function order_ganerate(){
    // Получаем все поля формы
    first_name = document.getElementById("first_name").value;
    last_name = document.getElementById("last_name").value;
    email = document.getElementById("email").value;
    phone = document.getElementById("phone").value;
    country = document.getElementById("country").value;
    post_code = document.getElementById("post_code").value;
    address = document.getElementById("address").value;

    var error_forms = document.getElementById("error_forms");
    // Инициализируем переменную, которая будет отвечать за валидность формы
    var form_valid = true;

    // Проверяем каждое поле на пустоту
    if (first_name == "" && first_name.length < 2) {
        form_valid = false;
        error_forms.style.display = "block";
    }
    if (last_name == "" && last_name.length < 4) {
        form_valid = false;
        error_forms.style.display = "block";
    }
    if (email == "" && email.length < 4) {
        form_valid = false;
        error_forms.style.display = "block";
    }
    if (phone == "" && phone.length < 4) {
        form_valid = false;
        error_forms.style.display = "block";
    }
    if (country == "" && country.length < 4) {
        form_valid = false;
        error_forms.style.display = "block";
    }
    if (post_code == "" && post_code.length < 4) {
        form_valid = false;
        error_forms.style.display = "block";
    }
    if (address == "" && address.length < 4) {
        form_valid = false;
        error_forms.style.display = "block";
    }

    // Если форма валидна, продолжаем выполнение кода
    if (form_valid) {  
        if(document.getElementById("remember").checked){
            document.getElementById("step_menu_2").classList.add("slide-out");
            document.getElementById("step_menu_2").classList.remove("slide-in");
    
            document.getElementById("step_menu_3").classList.add("slide-in");
            document.getElementById("step_3").classList.add("active");
            document.getElementById("step_menu_3").classList.remove("step_menu_hide");
            
            document.getElementById("order_id").textContent = order_number;
            document.getElementById("order_document").src = "order/?order=" + order_number + "&name=" + first_name + " " + last_name + "&email=" + email + "&street1=" + address + "&street2=" + post_code + " " + country;    
        }else{
            error_forms.textContent = "Ви не погодились з умовами.";
            error_forms.style.display = "block";
        }
    }

}

function confirm_order(){
    document.getElementById("step_menu_3").classList.add("slide-out");
    document.getElementById("step_menu_3").classList.remove("slide-in");
    document.getElementById("step_4").classList.add("active");

    document.getElementById("step_menu_4_loading").style = "display: flex;width: 100%;padding-top: 100px;height: 100%;";

    // Формируем объект с данными
    var data = {
        first_name: first_name,
        last_name: last_name,
        email: email,
        phone: phone,
        country: country,
        post_code: post_code,
        address: address,
        order_number: order_number
    };
  
    // Определяем параметры запроса
    var url = 'create_order.php';
    var params = {
        method: 'POST',
        body: JSON.stringify(data),
        headers: {
        'Content-Type': 'application/json'
        }
    };
    
    // Отправляем запрос на сервер
    fetch(url, params)
        .then(function(response) {
        // Обрабатываем ответ от сервера
        if (response.ok) {
            order_complete();
        } else {
            // Обработка ошибки
            document.getElementById("error_order").style.display = "flex";
        }
        })
        .catch(function(error) {
        // Обработка ошибки
        document.getElementById("error_order").style.display = "flex";
    });
}

function order_complete(){
    document.getElementById("step_menu_1").classList.add("slide-out");
    document.getElementById("step_menu_1").classList.remove("slide-in");
    document.getElementById("step_menu_2").classList.add("slide-out");
    document.getElementById("step_menu_2").classList.remove("slide-in");
    document.getElementById("step_menu_3").classList.add("slide-out");
    document.getElementById("step_menu_3").classList.remove("slide-in");
    document.getElementById("step_menu_4_loading").classList.remove("slide-in");
    document.getElementById("step_menu_4_loading").style = "display: none;width: 100%;padding-top: 100px;height: 100%;";

    document.getElementById("step_menu_4_compliate").style = "display: flax; width: 100%;padding-top: 100px;height: 100%;";
}

function printOrder() {
    var frame = document.getElementById("order_document");
    var contentWindow = frame.contentWindow;
    contentWindow.focus();
    contentWindow.print();
}

function printPDF() {
    var frame = document.getElementById("order_document");
    var contentWindow = frame.contentWindow;
    contentWindow.focus();
    contentWindow.saveAsPDF();
}

function randomInteger(min, max) {
    let rand = min + Math.random() * (max + 1 - min);
    return Math.floor(rand);
}