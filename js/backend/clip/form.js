$(function(){
  // alert('fd');
  tinymce.init({
    selector: 'textarea',
    height: 600,
    menubar: false,
    plugins: [
      'advlist autolink lists link image charmap print preview anchor textcolor',
      'searchreplace visualblocks code fullscreen',
      'insertdatetime media table contextmenu paste code help'
    ],
    toolbar: 'insert | undo redo |  styleselect | bold italic backcolor  | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | removeformat | help',
    content_css: [
      '//fonts.googleapis.com/css?family=Lato:300,300i,400,400i',
      '//www.tinymce.com/css/codepen.min.css']
  });

  $('#form').formValidation({
    framework: 'bootstrap',
    icon: {
        valid: 'fa fa-check',
        invalid: 'fa fa-remove',
        validating: 'fa fa-refresh'
    },
    fields: {
      head: {
        validators: {
          notEmpty: {
            message: 'กรุณากรอกข้อความด้วยค่ะ'
          }
        }
      },
      cover: {
        validators: {
          promise: {
            promise: function(value, validator, $field){
              var dfd   = $.Deferred(),
                files = $field.get(0).files;

                if (!files.length || typeof FileReader === 'undefined') {
                  dfd.resolve({
                    valid: false,
                    message: 'กรุณาเลือกภาพ cover ด้วยค่ะ'
                  });
                  return dfd.promise();
                }
              var img = new Image();
              img.onload = function() {
                  var w = this.width,
                      h = this.height;

                  dfd.resolve({
                      valid: (w == 640 && h == 360),
                      message: 'ขนาดต้อง 640x360 ค่ะ',
                      source: img.src,    // We will use it later to show the preview
                      width: w,
                      height: h
                  });
              };
              img.onerror = function() {
                  dfd.reject({
                      message: 'ต้องเป็นไฟล์ภาพเท่านั้นนะค่ะ อิอิ'
                  });
              };

              var reader = new FileReader();
              reader.readAsDataURL(files[0]);
              reader.onloadend = function(e) {
                  img.src = e.target.result;
              };
              return dfd.promise();
            }
          }
        }
      },
      date:{
        validators: {
          notEmpty: {
            message: "กรุณาเลือกวันที่ไฮไลท์ด้วยนะค่ะ"
          }
        }
      },
      clip: {
        validators: {
          notEmpty: {
            message: "กรุณาเลือกคลิปไฮไลท์ด้วยค่ะ"
          }
        }
      },
      zone_id: {
        validators: {
          notEmpty: {
            message: "กรุณาเลือกด้วยค่ะ"
          }
        }
      },
      des: {

      }
    }
  })
  .on('err.validator.fv', function(e, data) {
    if (data.field === 'cover' && data.validator === 'promise') {
        // Hide the preview
        $('#coverPreview').html('').hide();
    }
  })
  .on('success.validator.fv', function(e, data){
    if (data.field === 'cover' && data.validator === 'promise' && data.result.source) {
      $('#coverPreview')
        .html('')
        .append($('<img/>').attr('src', data.result.source))
        .show();
    }
  })
  .on('success.form.fv', function(e, data){
    e.preventDefault();
    var $form = $(e.target);

    $form.ajaxSubmit({
      url: $form.attr('action'),
      dataType: 'json',
      success: function(data) {
        console.log(data);
      }
    });
  });

  var clipPreview = $('#clipPreview');
  $("select[name='date']").change(function(){
    clipPreview.html('').hide();
    var form = $('#form').data('formValidation'),
        shipHighlight = ($(this).val() != ''),
        clip = $("select[name='clip']");

    clip.html(
      '<option value="">เลือก</option>'
    );
    form.resetField(clip);

    if(shipHighlight){

      clip.removeAttr('disabled');
      $.ajax({
        'url' : 'form' + $(this).val(),
        'type' : 'get',
        'dataType' : 'json',
        beforeSend : function(){

        },
        success : function(data){
          $.each(data, function(k, v){
            clip.append(
              '<option value="'+v.link+'">'+v.name+'</option>'
            );
          });
          console.log(data);
        },
        error : function(data){
          console.log(data);
        }
      });
    }else{
      clip.attr('disabled', 'disabled');
    }
    // form.enableFieldValidators('clip', shipHighlight);
  });

  $("select[name='clip']").change(function(){
    if($(this).val() != ''){
      clipPreview.html(
        '<video controls>'+
          '<source src="'+$(this).val()+'" type="video/mp4">'+
        '</video>'
      ).show();
    }else{
      clipPreview.html('').hide();
    }
  });
});
