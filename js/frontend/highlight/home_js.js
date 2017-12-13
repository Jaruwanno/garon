$(document).ready(function(){
  // alert('gd');

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
