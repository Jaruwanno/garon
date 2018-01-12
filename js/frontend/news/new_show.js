$(function(){
  alert();
  var id = $('.head-news-show').attr('data-id');
  var ip = $('.head-news-show').attr('data-ip');

  $.ajax({
    headers: {
      'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    },
    url: id,
    type: 'PUT',
    dataType: 'text',
    data: {'ip':ip},
    success: function(data){
      $('#count').html(data);
    },
    error: function(data){
      console.log('Error:', data);
    }
  });

});
