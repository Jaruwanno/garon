$(document).ready(function(){
  // alert('garon');

  $('.action').change(function(){
    if(this.checked){
      var d = {'active':1};
    }else{
      var d = {'active':0};
    }
    var id = $(this).attr('id');

    $.ajax({
      'headers' : {
        'X-CSRF-TOKEN' : $('meta[name="csrf-token"]').attr('content')
      },
      'url' : 'match/'+id,
      'data' : d,
      'type' : 'PUT',
      // 'dataType' : 'json',
      success : function(d){
        location.reload();
      },
      error : function(d){
        console.log(d);
      }
    });
  });

  $('.del').click(function(){
    if(confirm('ยืนยันการลบข้อมูล')){
      var id = $(this).attr('data-id');

      $.ajax({
        'headers' : {
          'X-CSRF-TOKEN' : $('meta[name="csrf-token"]').attr('content')
        },
        'url' : 'match/delete/'+id,
        'type' : 'DELETE',
        success : function(d){
          location.reload();
        },
        error : function(d){
          console.log(d);
        }
      });

    }
  });
});
