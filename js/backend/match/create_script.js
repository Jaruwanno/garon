$(document).ready( function() {
  // alert('fe');
  $('#date').datetimepicker({
    icons: {
      time: 'fa fa-clock-o',
      date: 'fa fa-calendar',
      up: 'fa fa-chevron-up',
      down: 'fa fa-chevron-down',
      previous: 'fa fa-chevron-left',
      next: 'fa fa-chevron-right',
      close: 'fa fa-remove'
    },
    locale:'th',
    format: 'YYYY-MM-DD HH:mm:ss'
  }).data("DateTimePicker").minDate(new Date());

  $(document).on('change', '.btn-file :file', function() {
	var input = $(this),
		label = input.val().replace(/\\/g, '/').replace(/.*\//, '');
	input.trigger('fileselect', [label]);
	});

	$('.btn-file :file').on('fileselect', function(event, label) {

    var input = $(this).parents('.input-group').find(':text'),
      log = label;

    if( input.length ) {
      input.val(log);
    } else {
      if( log ) alert(log);
    }

	});
	function readURL(input) {
	    if (input.files && input.files[0]) {
	        var reader = new FileReader();

	        reader.onload = function (e) {
	            $(input).parents('.input-group').next().attr('src', e.target.result);
	        }

	        reader.readAsDataURL(input.files[0]);
	    }
	}

	$(".imgInp").change(function(){
	    readURL(this);
	});

  $('.clear').click(function(){
      $(this).parent().find('.imgInp').val("");
      $(this).parent().next().val("");
      $(this).parents('.input-group').next().attr("src", imgUpload);
  });
	});
