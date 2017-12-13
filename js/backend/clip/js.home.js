

$(function(){
  $('.lightgallery').lightGallery();

  $('.del').click(function(){
    if(!confirm('ท่านต้องการลบใช้หรือไหม')){
      return false;
    }
  });
});
