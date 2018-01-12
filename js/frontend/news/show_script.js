$(function(){
  var url = $(".fb-like").attr('data-href'),
      title = $("div.head-news-show > h1").text(),
      des = $("div#descriptions").text(),
      image = $("div.head-news-show > img").attr('src');
  console.log(image);

  $("meta[property='og:url']").attr('content', url);
  $("meta[property='og:title']").attr('content', title);
  $("meta[property='og:description']").attr('content', des);

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
