$(document).ready(function(){

  (function(d, s, id) {
    var js, fjs = d.getElementsByTagName(s)[0];
    if (d.getElementById(id)) return;
    js = d.createElement(s); js.id = id;
    js.src = "//connect.facebook.net/th_TH/sdk.js#xfbml=1&version=v2.10&appId=1758381751148365";
    fjs.parentNode.insertBefore(js, fjs);
  }(document, 'script', 'facebook-jssdk'));

  $(window).bind("load resize", function() {
    var width = (this.window.innerWidth > 0) ? this.window.innerWidth : this.screen.width;
    if (width > 768) {
        $(".sidebar-collapse").removeClass('collapse');
    } else{

        $(".sidebar-collapse").addClass('collapse');
    }
  });

  $('#datetimepicker1').datetimepicker({
    inline:true,
    format:'MM/dd/YYYY',
    icons:{
      previous: 'fa fa-angle-left',
      next: 'fa fa-angle-right'
    }
  });

  $('.zone').click(function(){
    $(this).next().submit();
  });



});
