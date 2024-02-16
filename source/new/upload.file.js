function file_upload(){
    document.getElementById("MultipleFile").click();
    document.getElementById("error_photo").style.display = "none";
    document.getElementById("files_grid").innerHTML = "";
  }

  $("input[type=file]").on("change", function(e) {
    var imgId = 0;
    var nav = $("temp").empty();
    var file = this.files
    $.when.apply($, $.map(file, function(img, i) {    
      return new $.Deferred(function(dfd) {
        var image = new Image();
        $(image).on("load", i, function(e) {
          var canvas = document.createElement("canvas")
          , context = canvas.getContext("2d");   
          canvas.height = this.height;
          canvas.width = this.width;    
          context.drawImage(this, 0, 0);
          document.getElementById("imgUpload_" + imgId).src = canvas.toDataURL();
          imgId = imgId + 1;
          dfd.resolve()
          URL.revokeObjectURL(this.src);
        });
        image.src = URL.createObjectURL(img);
        return dfd.promise()
      })
    })).then(function() {
      nav.find("a").each(function() {
        console.log("ERROR " + this.href + "\n");
      })
    })
  });

  function getFiles(files) {
    document.getElementById("error_photo").style = "display: none;";
    for(var i = 0; i <= files.length; i++){
      if (files[i].size <= 200000000) {
              photo = true;
              var idImg = "imgUpload_" + i;
              document.getElementById("files_grid").innerHTML +=
              `  <li class="list-group-item px-0">
                    <div class="row align-items-center">
                      <div class="col-auto">
                        <div class="avatar">
                          <img class="avatar-img rounded" id="` + idImg + `" src="" alt="..." data-dz-thumbnail>
                        </div>
                      </div>
                      <div class="col ml--3">
                        <h4 class="mb-1" data-dz-name>` + files[i].name + `</h4>
                        <p class="small text-muted mb-0" data-dz-size>` + (files[i].size / 1000000).toFixed(2) + `Мб</p>
                      </div>
                    </div>
                  </li>`;
        } else {
          document.getElementById("error_photo").style = "display: inline;";
          document.getElementById("files_error").textContent = "Вес некоторых файлов не может быть больше 25 мб.";
        }
    }
}