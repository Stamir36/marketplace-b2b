<?php
  // Курс валют
  $ch = curl_init();  
    curl_setopt($ch, CURLOPT_URL, "http://www.cbr.ru/scripts/XML_daily.asp?date_req=".date("d/m/Y"));
    curl_setopt($ch, CURLOPT_HEADER, 0); 
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);    
    curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 30);
    
    $result = curl_exec($ch);
    
    $xml = $result;
    $xml_obj = new SimpleXMLElement($xml);
    
    $xml = $xml_obj->xpath("//Valute[@ID='R01720']"); 
    $curs_rub = strval($xml[0]->Value) / strval($xml[0]->Nominal);  // получим курс руб

    $xml2 = $xml_obj->xpath("//Valute[@ID='R01235']"); 
    $curs_usd_rub = strval($xml2[0]->Value); // получим курс доллара
    $curs_usd = $curs_rub / $curs_usd_rub;

    $xml3 = $xml_obj->xpath("//Valute[@ID='R01239']"); 
    $curs_eur_rub = strval($xml3[0]->Value); // получим курс евро
    $curs_eur = $curs_rub / $curs_eur_rub;
?>
    <!-- Page content -->
    <div class="container-fluid new_mobile_p">
      <script>
        let photo = false;
      </script>
      <section class="py-2">
        <div class="container">
          <p class="subtitle text-primary mb-5"><?php echo $txt_new_post_1; ?></p>
          
          <form action="script.newpost.php" method="post" enctype="multipart/form-data" id="FormID">
            <div class="row form-block">
              <div class="col-lg-4">
                <h4><?php echo $main_txt; ?></h4>
                <p class="text-muted text-sm"><?php echo $txt_new_post_2; ?></p>
              </div>

              <div class="col-lg-7 ml-auto">
                <div class="form-group"></div>

                <div class="form-group">
                  <label for="form_name" class="form-label"><?php echo $txt_new_post_3; ?></label>
                  <input placeholder="<?php echo $txt_order_1; ?>..." style="font-family: Unecoin;" name="name" id="form_name" class="form-control" onclick="document.getElementById('error_name').style = 'display: none;';">
                  <label id="error_name" style="display: none;" for="form_street" class="form-label"><a id="error_name_text" style="color: red;"></a></label>
                </div>

                <div class="form-group">
                  <label for="exampleFormControlSelect1" class="form-label" style="margin: 0px;"><?php echo $txt_new_post_4; ?></label>
                  <select class="form-control" id="form_category" name="categories">
                    <?php foreach ($categories as $key => $value): ?>
                      <option value="<?php echo $key; ?>"><?php echo $value; ?></option>
                    <?php endforeach; ?>
                  </select>
                  <label id="error_category" style="display: none;" for="form_street" class="form-label"><a id="error_category_text" style="color: red;"></a></label>
                </div>

                <div class="form-group">
                  <label for="form_name" class="form-label"><?php echo $txt_new_post_5; ?>:</label>
                  <div class="d-flex">
                    <input type="number" onchange="curs()" pattern="[0-9]+" value="0" placeholder="Цена в гривнах" style="font-family: Unecoin; width: auto;" name="price" id="form_price" class="form-control" onclick="document.getElementById('error_price').style = 'display: none;';">
                    <div class="ml-3">
                      <p class="text-gray-400 text-sm m-0 fz-10"><?php echo $Currency; ?>:</p>
                      <p class="text-green-500 font-semibold" id="temp_curs">$0.00 | €0.00</p>
                    </div>
                  </div>
                  <label id="error_price" style="display: none;" class="form-label"><a id="error_price_text" style="color: red;"></a></label>
                </div>

                <div class="form-group">
                  <label class="form-label" style="margin: 0px;"><?php echo $txt_new_post_6; ?></label>
                  <p style="font-size: 12px;"><?php echo $txt_new_post_7; ?></p>
                  <input style="font-family: Unecoin; display: none;" name="id_store" id="id_store" class="form-control">

                  <button style="width: 100%;background: azure;border: 1px solid antiquewhite;" id="dropdownHelperRadioButton" data-dropdown-toggle="dropdownHelperRadio" class="text-white hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-4 py-2.5 text-center inline-flex items-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800" type="button">
                    <div class="mt-1 text-sm">
                      <label class="font-medium text-gray-900 dark:text-gray-300" style="cursor: pointer; display: inline-flex;">
                        <img id="img_icon_select_store" src="https://unesell.com/assets/img/polyans/ribbed-blue.svg" style="width: 40px;height: 40px;border-radius: 25px;background: aliceblue;border: 1px solid khaki;">
                        <div class="ml-3" style="display: inline;align-self: center;">
                        <p id="helper-radio-text-4" class="text-xs font-normal text-gray-500 dark:text-gray-300 m-0"><?php echo $select_store_txt; ?></p>
                        <div id="DropDownNameStore" style="text-align: left;"><?php echo $NOT_TXT; ?></div>
                        </div>
                      </label>
                    </div>
                  </button>

                  <!-- Dropdown menu -->
                  <div id="dropdownHelperRadio" class="z-10 hidden bg-white divide-y divide-gray-100 rounded-lg shadow w-60 dark:bg-gray-700 dark:divide-gray-600" data-popper-reference-hidden="" data-popper-escaped="" data-popper-placement="top" style="width: 100% !important; position: absolute; inset: auto auto 0px 0px; margin: 0px; transform: translate3d(522.5px, 6119.5px, 0px);">
                      <ul class="p-3 space-y-1 text-sm text-gray-700 dark:text-gray-200" aria-labelledby="dropdownHelperRadioButton">
                      <?php
                          $stores = $mysql_shop->query("SELECT * FROM `shop` WHERE `USER_ID` = '$cook_id'");
                          $name = Array();
                          $icon = Array();
                          $link = Array();
                          $Type = Array();

                          while($result = $stores->fetch_assoc()){
                              $name[] = $result['Name'];
                              $icon[] = $result['Icon'];
                              $link[] = $result['LINK_ID'];
                              $Type[] = $result['Type'];
                          }

                          $num_notifi = 0;


                          if(count($name) == count($icon) && count($icon) != 0 && count($link) != 0 ){
                              while($num_notifi <= (count($name) - 1)){
                                  echo('
                                  <li>
                                    <div onclick="select_store(`'.$link[$num_notifi].'`, `'.$name[$num_notifi].'`, `'.$icon[$num_notifi].'`)" class="flex p-2 rounded hover:bg-gray-100 dark:hover:bg-gray-600" style="cursor: pointer;">
                                      <div class="flex items-center h-5" style="align-self: center;right: 30px;position: absolute;">
                                          <input id="'.$link[$num_notifi].'" name="helper-radio" type="radio" value="" class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-700 dark:focus:ring-offset-gray-700 focus:ring-2 dark:bg-gray-600 dark:border-gray-500">
                                      </div>
                                      <div class="ml-2 text-sm">
                                          <label for="'.$link[$num_notifi].'" class="font-medium text-gray-900 dark:text-gray-300" style="display: inline-flex;">
                                            <img src="../datafiles/store/'.$icon[$num_notifi].'" style="width: 40px;height: 40px;border-radius: 25px;background: aliceblue;border: 1px solid khaki;">
                                            <div class="ml-3" style="display: inline;align-self: center;">
                                              <p id="helper-radio-text-4" class="text-xs font-normal text-gray-500 dark:text-gray-300 m-0">
                                              ');
                                              if($Type[$num_notifi] == "0"){
                                                echo $shop_text_b;
                                              }else{
                                                  echo $shop_text_u;
                                              }
                                              echo('</p>
                                              <div>'.$name[$num_notifi].'</div>
                                            </div>
                                          </label>
                                      </div>
                                    </div>
                                  </li>');
                                  $num_notifi = $num_notifi + 1;
                              }
                          }
                        ?>
                        

                      </ul>
                  </div>

                  <script>
                    function select_store(id, name, icon){
                      document.getElementById("error_store").style = "display: none;";
                      document.getElementById(id).click();
                      document.getElementById("id_store").value = id;
                      document.getElementById("DropDownNameStore").textContent = name;
                      document.getElementById("img_icon_select_store").src = "../datafiles/store/" + icon;
                    }
                    function curs(){
                      var usd = <? echo $curs_usd; ?>;
                      var rub = <? echo $curs_rub; ?>;
                      var eur = <? echo $curs_eur; ?>; 
                      var price = document.getElementById("form_price").value;
                      document.getElementById("temp_curs").textContent = "$" + (price * usd).toFixed(2)  + " | €" + (price * eur).toFixed(2);
                    }
                  </script>
                  <label id="error_store" style="display: none;" class="form-label"><a id="error_store_text" style="color: red;"></a></label>
                </div>

              </div>
            </div>

            <div class="row form-block" style="margin-top: 50px;">
              <div class="col-lg-4">
                <h4><?php echo $txt_new_post_8; ?></h4>
                <p class="text-muted text-sm"><?php echo $txt_new_post_9; ?>.</p>
              </div>
              <div class="col-lg-7 ml-auto">

                <div class="form-group">
                  <label for="form_street" class="form-label"><?php echo $description_txt; ?>:</label>
                  <textarea name="content" id="content" placeholder="<?php echo $input_text; ?>..." class="form-control" style="min-height: 300px;"></textarea>
                  <label id="error_content" style="display: none;" for="form_street" class="form-label"><a id="error_content_text" style="color: red;"></a></label>
                </div>
              </div>
            </div>

            <div class="row form-block" style="margin-top: 50px;">
              <div class="col-lg-4 mb-4">
                <h4><?php echo $Feature; ?></h4>
                <p class="text-muted text-sm"><?php echo $txt_new_post_10; ?>.</p>
                <input name="features" id="features" class="form-control" style="display: none;">

                <div class="flex justify-between mb-1 mt-4">
                  <span class="text-base font-medium text-blue-700 dark:text-white"><?php echo $txt_new_post_11; ?></span>
                  <span class="text-sm font-medium text-blue-700 dark:text-white"><?php echo $txt_new_post_12; ?></span>
                </div>
                <div class="w-full bg-gray-200 rounded-full h-2.5 dark:bg-gray-700">
                  <div class="bg-blue-600 h-2.5 rounded-full" style="width: 12.5%; transition: 1s;" id="restrictions"></div>
                </div>
              </div>
              <div class="col-lg-7 ml-auto">
                <label for="form_street" class="form-label"><?php echo $txt_new_post_13; ?>:</label>

                <div class="form-group" id="feature_block">
                  
                  <div class="d-flex">
                    <input onclick="off_error_features()" placeholder="<?php echo $name_txt; ?>..." style="font-family: Unecoin;" class="form-control" id="feature_name_1">
                    <div class="ml-3">
                      <input type="text" onclick="off_error_features()" placeholder="<?php echo $value_txt; ?>" style="font-family: Unecoin; width: auto;" id="feature_param_1" class="form-control">
                    </div>
                  </div>

                </div>
                <button onclick="add_feature_graf()" id="fbtnadd" type="button" class="w-100 text-gray-900 bg-white border border-gray-300 focus:outline-none hover:bg-gray-100 focus:ring-4 focus:ring-gray-200 font-medium rounded-lg text-sm px-5 py-2.5 mr-2 mb-2 dark:bg-gray-800 dark:text-white dark:border-gray-600 dark:hover:bg-gray-700 dark:hover:border-gray-600 dark:focus:ring-gray-700"><i class="fa fa-plus fa-2 mr-1" aria-hidden="true"></i> <? echo $txt_new_post_19; ?> </button>
                <label id="error_features" style="display: none;" for="form_street" class="form-label"><a id="error_features_text" style="color: red;"></a></label>

              </div>
            </div>

            <input type="file" onchange="getFiles(this.files); photo = true;" id="MultipleFile" name="uploads[]" multiple style="display: none;" accept="image/*,image/jpeg, image/gif">

            <div class="row form-block" style="margin-top: 50px;">
              <div class="col-lg-4">
                <h4><?php echo $txt_new_post_14; ?></h4>
                <p class="text-muted text-sm"><?php echo $txt_new_post_15; ?>.</p>
              </div>
              <div class="col-lg-7 ml-auto">

              <!-- Dropzone -->
                <div class="card">
                  <!-- Card header -->
                  <div class="card-header">
                    <h4 class="mb-0"><?php echo $txt_new_post_16; ?></h4>
                  </div>
                  <!-- Card body -->
                  <div class="card-body">

                    <!-- Multiple -->
                    <div class="dropzone dropzone-multiple" data-toggle="dropzone" data-dropzone-multiple data-dropzone-url="/app/">
                      <div class="dz-default dz-message" onclick="file_upload(); photo = false;"><span><?php echo $txt_new_post_17; ?></span></div>

                      <ul id="files_grid" class="dz-preview-multiple list-group list-group-lg list-group-flush" style="margin-top: 25px; max-height: 310px; overflow-x: hidden; overflow-y: auto;">
                        
                        
                      </ul>
                    </div>

                    <label id="error_photo" style="display: none;" for="form_street" class="form-label"><a id="files_error" style="color: red; cursor: default;"><? echo $error_file_img_txt; ?>.</a></label>
                  </div>
                </div>

              </div>
            </div>

            <div class="row form-block flex-column flex-sm-row" style="margin-top: 50px;">
              <div class="col text-center text-sm-left">
              </div>
              <div class="col text-center text-sm-right">
                <a class="btn btn-danger px-3" style="cursor: pointer; color: #fff;" onclick="document.location.href = '../'" ;=""><? echo $Cancel; ?></a>
                <a class="btn btn-primary px-3" style="cursor: pointer; color: #fff;" onclick="create();"><? echo $txt_new_post_18; ?> <i class="fa-chevron-right fa ml-2"></i></a>
              </div>
              <script src="../assets/js/censorship.js">
                // Проверка на цензуру
              </script>
              <script>
                // Form Create validation
                function create() {
                                         // id             id - error
                  let name     = false;  // form_name      error_name +
                  let price    = false;  // form_price     error_price  error_price_text
                  let store    = false;  // id_store       error_store  error_store_text
                  let content  = false;  // content        error_content   error_content_text
                  let features = false;  // features       error_features
                  
                  // Check: name -----------------------------------------------
                  if (document.getElementById("form_name").value.length > 4) {
                    if (Censorship(document.getElementById("form_name").value)) {
                      document.getElementById("error_name").style = "display: inline;";
                      document.getElementById("error_name_text").textContent = "<?php echo $ERROR_Censurship; ?>";
                      name = false;
                    } else {
                      name = true;
                    }
                  } else {
                    document.getElementById("error_name").style = "display: inline;";
                    document.getElementById("error_name_text").textContent = "<?php echo $cnp_txt_error_1; ?>";
                    name = false;
                  }

                  // Check: price -----------------------------------------------
                  if (document.getElementById("form_price").value.length > 0) {
                    if (document.getElementById("form_price").value < 0) {
                      document.getElementById("error_price").style = "display: inline;";
                      document.getElementById("error_price_text").textContent = "<?php echo $cnp_txt_error_2; ?>";
                      price = false;
                    } else {
                      price = true;
                    }
                  } else {
                    document.getElementById("error_price").style = "display: inline;";
                    document.getElementById("error_price_text").textContent = "<?php echo $cnp_txt_error_3; ?>";
                    price = false;
                  }

                  // Check: store -----------------------------------------------
                  if (document.getElementById("id_store").value.length > 0) {
                    store = true;
                  } else {
                    document.getElementById("error_store").style = "display: inline;";
                    document.getElementById("error_store_text").textContent = "<?php echo $cns_txt_error_4; ?>";
                    store = false;
                  }

                  // Check: content -----------------------------------------------
                  if (document.getElementById("content").value.length > 4) {
                    if (Censorship(document.getElementById("content").value)) {
                      document.getElementById("error_content").style = "display: inline;";
                      document.getElementById("error_content_text").textContent = "<?php echo $ERROR_Censurship; ?>.";
                      content = false;
                    } else {
                      content = true;
                    }
                  } else {
                    document.getElementById("error_content").style = "display: inline;";
                    document.getElementById("error_content_text").textContent = "<?php echo $cns_txt_error_2; ?>.";
                    content = false;
                  }

                  // Check: features -----------------------------------------------
                  for (let i = 1; i < count_f + 1; i++) {
                    var nf = document.getElementById("feature_name_" + i).value;
                    var pf = document.getElementById("feature_param_" + i).value;
                    if(nf != "" && pf != ""){
                      features = true;
                      document.getElementById("features").value = generate_feature();
                    }else{
                      document.getElementById("error_features").style = "display: inline;";
                      document.getElementById("error_features_text").textContent = "<?php echo $cns_txt_error_5; ?>.";
                      features = false;
                    }
                  }

                 // Check: photo ----------------------------------------------- 
                  if(photo == false){
                    document.getElementById("error_photo").style = "display: inline;";
                    document.getElementById("files_error").textContent = "<?php echo $cns_txt_error_6; ?>.";
                  }

                  if (name == true && price == true && store == true && content == true && features == true && photo == true) {
                    var form = document.getElementById("FormID");
                    document.getElementById("content").value = document.getElementById("content").value.replace(/\n/g, "!n!");
                    document.getElementById("features").value = document.getElementById("features").value.replace("<", "!n");
                    document.getElementById("features").value = document.getElementById("features").value.replace(">", "n!");
                    form.submit();
                  } else {
                    //alert("Not good! Info: " + "\nphoto = "+ photo + "\nname = " + name + "\nprice = "+ price +"\ncontent = "+ content + "\nstore = " + store + "\nfeatures = " + features);
                  }
                  
                }

                // Ect
                let count_f = 1;
                function add_feature_graf(){
                  count_f += 1;
                                    
                  let div = document.createElement('div');
                  div.className = "d-flex mt-2";
                  div.innerHTML = '<input onclick="off_error_features()" id="feature_name_' + count_f + '" placeholder="<?php echo $name_txt; ?>..." style="font-family: Unecoin;" class="form-control"><div class="ml-3"><input onclick="off_error_features()" id="feature_param_' + count_f + '" type="text" placeholder="<?php echo $value_txt; ?>" style="font-family: Unecoin; width: auto;" class="form-control"></div>';

                  document.getElementById("feature_block").append(div);

                  document.getElementById("restrictions").style.width = (12.5 * count_f) + "%";
                  if(count_f == 8){
                    document.getElementById("fbtnadd").style.display = "none";
                  }
                }

                function generate_feature(){
                  var result = "";
                  for (let i = 1; i < count_f + 1; i++) {
                    var nf = document.getElementById("feature_name_" + i).value;
                    var pf = document.getElementById("feature_param_" + i).value;
                    if(nf != "" && pf != ""){
                      result = result + nf + ":" + pf + "//";
                    }
                  }
                  return result;
                }
                function off_error_features(){
                  document.getElementById("error_features").style = "display: none;";
                }
              </script>

          
          </div>
          </form>
        </div>
      </section>
    </div>