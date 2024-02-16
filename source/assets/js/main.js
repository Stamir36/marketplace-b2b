function claer_notify(){
    $.ajax({
        url: '/component/clear_notifi.php',
        success: function(data) {
            clears_notifi();
        }
    });
  }
  
  function clears_notifi(){
    var texts = document.getElementById("none_notify");
    texts.style = "color: #db6724;cursor: default;text-align: center;margin: 60px;width: 100%; display: table-caption;height: 100%;margin-top: 80%;";
    
    var notifi_blocks = document.getElementById("notifi_clear");
    notifi_blocks.style = "display: none;";
  
    var notifi_clear_btn = document.getElementById("notifi_clear_btn");
    notifi_clear_btn.style = "display: none;";

    document.getElementById("notify_count").remove();
  }

  //console.log(Cookies.get("lang") == undefined);

  if(Cookies.get("lang") == undefined){
    var language = navigator.language || navigator.userLanguage; 
    language = language.substr(0, 2).toLowerCase();
    if(language != "undefined"){
      Cookies.set('lang', language, { expires: 365 });
    }
    document.location.reload();
  }else{
    console.log("Мова інтерфейсу: " + Cookies.get("lang"));
  }

  function srtLang(lang){
    Cookies.set('lang', lang, { expires: 365 });
    document.location.reload();
  }

  function open_cursus(){
    document.getElementById("cursus").style.display = "contents";
    document.getElementById("basket").style.display = "none";
  }

  function open_basket(){
    document.getElementById("cursus").style.display = "none";
    document.getElementById("basket").style.display = "contents";
  }