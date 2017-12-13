$(function(){
  //console.log("test");
  $(".roles").change(function() {
    $(this).parent().parent().parent().parent().submit();
  });
});
