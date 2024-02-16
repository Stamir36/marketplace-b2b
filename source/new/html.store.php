<div class="container-fluid new_mobile_p">
      <script>
        let photo = false;
      </script>
      <section class="py-2">
        <div class="container">
          <p class="subtitle text-primary mb-5"><?php echo $cns_txt_1; ?></p>
          
          <form action="script.newstore.php" method="post" enctype="multipart/form-data" id="FormID">
            <div class="row form-block">
              <div class="col-lg-4">
                <h4><?php echo $main_txt; ?></h4>
                <p class="text-muted text-sm"><?php echo $cns_txt_3; ?></p>
              </div>

              <div class="col-lg-7 ml-auto">
                <div class="form-group"></div>

                <div class="form-group">
                  <label for="form_name" class="form-label"><?php echo $cns_txt_2; ?></label>
                  <input placeholder="<?php echo $name_txt; ?>..." style="font-family: Unecoin;" name="name" id="form_name" class="form-control" onclick="document.getElementById('error_name').style = 'display: none;';">
                  <label id="error_name" style="display: none;" for="form_street" class="form-label"><a id="error_name_text" style="color: red;"></a></label>
                </div>

                <div class="form-group">
                  <label for="exampleFormControlSelect1" class="form-label" style="margin: 0px;"><?php echo $cns_txt_4; ?></label>
                  <p style="font-size: 12px;"><?php echo $cns_txt_5; ?></p>
                  <select class="form-control" id="form_category" name="Type">
                    <option value="0"><?php echo $shop_text_b; ?></option>
                    <option value="1"><?php echo $shop_text_u; ?></option>
                  </select>
                  <label id="error_category" style="display: none;" for="form_street" class="form-label"><a id="error_category_text" style="color: red;"></a></label>
                </div>

              </div>
            </div>

            <div class="row form-block" style="margin-top: 50px;">
              <div class="col-lg-4">
                <h4><?php echo $cns_txt_6; ?></h4>
                <p class="text-muted text-sm"><?php echo $cns_txt_7; ?></p>
              </div>
              <div class="col-lg-7 ml-auto">

                <div class="form-group">
                  <label for="form_street" class="form-label"><?php echo $cns_txt_8; ?></label>
                  <textarea name="content" id="content" placeholder="<?php echo $input_text; ?>..." class="form-control" style="min-height: 300px;" onclick="document.getElementById('error_content').style = 'display: none;';"></textarea>
                  <label id="error_content" style="display: none;" for="form_street" class="form-label"><a id="error_content_text" style="color: red;"></a></label>
                </div>
              </div>
            </div>

            <input type="file" onchange="getFiles(this.files); photo = true;" id="MultipleFile" name="icon" style="display: none;" accept="image/*,image/jpeg, image/gif">

            <div class="row form-block" style="margin-top: 50px;">
              <div class="col-lg-4">
                <h4><?php echo $cns_txt_9; ?></h4>
                <p class="text-muted text-sm"><?php echo $cns_txt_10; ?></p>
              </div>
              <div class="col-lg-7 ml-auto">

              <!-- Dropzone -->
                <div class="card">
                  <!-- Card header -->
                  <div class="card-header">
                    <h4 class="mb-0"><?php echo $input_file_txt; ?></h4>
                  </div>
                  <!-- Card body -->
                  <div class="card-body">

                    <!-- Multiple -->
                    <div class="dropzone dropzone-multiple" data-toggle="dropzone" data-dropzone-multiple data-dropzone-url="/app/">

                      <ul id="files_grid" class="dz-preview-multiple list-group list-group-lg list-group-flush" style="margin-top: 25px; max-height: 310px; overflow-x: hidden; overflow-y: auto;"></ul>
                      <div class="dz-default dz-message" onclick="file_upload(); photo = false; document.getElementById('error_file').style = 'display: none;';"><span><?php echo $input_file_img_txt; ?></span></div>

                    </div>

                    <label id="error_photo" style="display: none;" for="form_street" class="form-label"><a id="files_error" style="color: red; cursor: default;"><?php echo $error_file_img_txt; ?>.</a></label>
                  </div>
                </div>
                <label id="error_file" style="display: none;" for="form_street" class="form-label"><a id="error_file_text" style="color: red;"></a></label>

              </div>
            </div>

            <div class="row form-block flex-column flex-sm-row" style="margin-top: 50px;">
              <div class="col text-center text-sm-left">
              </div>
              <div class="col text-center text-sm-right">
                <a class="btn btn-danger px-3" style="cursor: pointer; color: #fff;" onclick="document.location.href = '../'" ;=""><?php echo $Cancel; ?></a>
                <a class="btn btn-primary px-3" style="cursor: pointer; color: #fff;" onclick="create();"><?php echo $cns_txt_send;?><i class="fa-chevron-right fa ml-2"></i></a>
              </div>
              <script src="../assets/js/censorship.js">
                // Проверка на цензуру
              </script>
              <script>
                function create() {
                  
                  let name = false; // form_name   error_name +
                  let content = false; // content   error_content +
                  

                  if (document.getElementById("form_name").value.length > 4) {
                    if (Censorship(document.getElementById("form_name").value)) {
                      document.getElementById("error_name").style = "display: inline;";
                      document.getElementById("error_name_text").textContent = "<?php echo $ERROR_Censurship; ?>.";
                      name = false;
                    } else {
                      name = true;
                    }
                  } else {
                    document.getElementById("error_name").style = "display: inline;";
                    document.getElementById("error_name_text").textContent = "<?php echo $cns_txt_error_1; ?>";
                    name = false;
                  }

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

                  if(photo == false){
                    document.getElementById("error_file").style = "display: inline;";
                    document.getElementById("error_file_text").textContent = "<?php echo $cns_txt_error_3; ?>.";
                  }

                  if (name == true && content == true && photo == true) {
                    var form = document.getElementById("FormID");
                    document.getElementById("content").value = document.getElementById("content").value.replace(/\n/g, "!n!");
                    form.submit();
                  } else {
                    //alert("Not good! Info: " + "photo =="+ photo+"  name == "+name +" category == "+category+"content =="+ content);
                  }
                  
                }
              </script>

          
          </div>
          </form>
        </div>
      </section>
    </div>