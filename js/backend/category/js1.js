$(function(){
  //alert('fe');
  var url = "zone";

  $("#add").click(function(){
    $('.modal-title').text('เพิ่มข้อมูล');
    $("[name='name']").val('');
    $("[name='length']").val('');
    $('#btn-save').val("add");
  });

  $(".edit").click(function(){
    var text = $(this).parent().prev().prev().prev().text();
    var length = $(this).parent().prev().prev().prev().prev().text();
    var id = $(this).val();
    $('#btn-save').val("update");


    $('.modal-title').text('แก้ไข');
    $("[name='id']").val(id);
    $("[name='length']").val(length);
    $("[name='name']").val(text);
  });



  $("#btn-save").click(function(){
    var req = $(".form-control");
    req.each(function (i) {
        if ($(this).val() === "") {
            $(".form-control").parent().addClass('has-error');
            req.error = true;
        }
    });

    if(req.error){
      return false;
    }

    $.ajaxSetup({
      headers:{
        'X-CSRF-TOKEN': $("meta[name='csrf-token']").attr('content')
      }
    });
    var data = {
      'name': $("[name='name']").val(),
      'length': $("[name='length']").val()
    }
    var state = $("#btn-save").val();
    var type = "POST";
    myUrl = url;

    if(state == "update"){
      type = "PUT";
      myUrl += "/" + $("[name='id']").val();
    }

    //$.post('zone', {'name': text, '_token': $("input[name='_token']").val()}, function(data){});
    $.ajax({
      type: type,
      url: myUrl,
      data: data,
      success:function(data){
        if(data == 'success'){
          $('#myModal').modal('hide');
          location.reload();
        }
      },
      error: function(data){
        console.log('Error:', data);
      }

    });
  });


  $(".del").click(function(){
    if(confirm('ยืนยันการลบ')){
      var id = $(this).val();
      var data = {
        'id': $(this).val()
      }
      $.ajaxSetup({
        headers:{
          'X-CSRF-TOKEN': $("meta[name='csrf-token']").attr('content')
        }
      });

      $.ajax({
        type: "DELETE",
        url: url + '/' + id,
        data: data,
        success: function(data){
          if(data == "success"){
            alert('ลบข้อมูลสำเร็จ');
            location.reload();
          }
        },
        error: function(data){
          console.log(data);
        }
      });
    }
  });

  $('#myModal').on('hidden.bs.modal', function (e) {
    $("#myModal").find('.has-error').removeClass("has-error");
  });

});
