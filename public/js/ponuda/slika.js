var sifraPonude;

$(".slikaPonude").click(function(){
  sifraPonude=$(this).attr("id").split("_")[1];
      $("#image").attr("src",$(this).attr("src"));
      $("#slikaPonudeModal").foundation("open");
      definirajCropper();

      return false;
  });

  $("#spremiSliku").click(function(){
    var opcije = { "width": 400, "height": 400 };
    var result = $image.cropper("getCroppedCanvas", opcije, opcije);


    $.ajax({
        type: "POST",
        url:  "/ponuda/spremiSlikuPonude", 
        data: "id=" + sifraPonude + "&slika=" + result.toDataURL(),
        success: function(vratioServer){
          if(vratioServer==="OK"){
            $("#p_"+sifraPonude).attr("src",result.toDataURL());
            $("#slikaPonudeModal").foundation("close");
          }else{
            alert(vratioServer);
          }
        }
      });


    return false;
  });
  
  var $image;

  function definirajCropper(){


    var URL = window.URL || window.webkitURL;
    $image = $('#image');
    var options = {aspectRatio: 1 / 1 };
    
    // Cropper
    $image.on({}).cropper(options);
    
    var uploadedImageURL;
    
    
    // Import image
    var $inputImage = $('#inputImage');
    
    if (URL) {
      $inputImage.change(function () {
        var files = this.files;
        var file;
    
        if (!$image.data('cropper')) {
          return;
        }
    
        if (files && files.length) {
          file = files[0];
    
          if (/^image\/\w+$/.test(file.type)) {
           
    
            if (uploadedImageURL) {
              URL.revokeObjectURL(uploadedImageURL);
            }
    
            uploadedImageURL = URL.createObjectURL(file);
            $image.cropper('destroy').attr('src', uploadedImageURL).cropper(options);
            $inputImage.val('');
          } else {
            window.alert('Datoteka nije u formatu slike');
          }
        }
      });
    } else {
      $inputImage.prop('disabled', true).parent().addClass('disabled');
    }
    
    }
