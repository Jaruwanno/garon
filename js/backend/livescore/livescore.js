$(function(){
  var d = $('#datepicker').datetimepicker({
    inline: true,
    format:'MM/DD/YYYY',
    // defaultDate : "12/3/2017",
    defaultDate : moment().utc().format('M/D/YYYY'),
    useCurrent: false,
    icons: {
      time: "fa fa-clock-o",
      previous: "fa fa-chevron-left",
      next: "fa fa-chevron-right"
    }
  })
  .on("dp.change",function (e) {
    // alert($(e.target).data("DateTimePicker").date());
  });
  callTable(moment().utc().format('YYYY-MM-DD'));

  $("#submit").click(function(){
    var d = [];
    $.each( $("#livescore > tbody input[type='checkbox']:checked"),function(i, v){
      var tr = $(this).closest('tr'),
        tded = tr.find("input").eq(1).val(),
        link = tr.find("input").eq(2).val();
      d.push(
        {
          "match_id" : v.value,
          "match_date" : $(this).attr('data-date'),
          "tded" : tded,
          "link" : link
        }
      );
    });
    $.ajax({
      'headers' : {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      },
      'url' : 'livescore',
      'data' : {'data' : d},
      'type' : 'post',
      success : function(data){
        location.reload();
      },
      error : function(data){
        console.log(data);
      }
    });
  });

  // $(document).on('dblclick', '#livescore td > button', function () {
  //   alert('garon');
  //   // var html = $(this).text()
  //   // var input = $('<input type="text" />');
  //   // input.val(html);
  //   // $(this).replaceWith(input);
  //   // $('#livescore td input').focus();
  // });

  // $(document).on('blur', '#assets input', function(){
  //   $(this).replaceWith('<td class="asset_value"><span>'+this.value+'</span></td>');
  // });

});
function callTable(date){
  $.ajax({
    url: 'livescore/'+date,
    type: 'get',
    dataType: 'json',
    beforSend: function(){

    },
    success: function(data){
      console.log(data);
      $('#loader').hide();
      $('#table').html("");

      $.each(data['leagues'], function(index,value){
        $('#livescore').append(
          '<thead>'+
            '<tr class="primary">'+
              '<td colspan="9">'+
                '<img src="https://apifootball.com/widget/img/flags/'+value['country_name']+'.png" '+
                'style="float:left; margin-top:5px; margin-right:5px;">'+
                'โปรแกรมบอล ราคาบอล ผลบอล '+
                value['country_name']+' '+
                value['league_name']+
              '</td>'+
              '<td><label class="pull-right"><input type="checkbox"> ทั้งหมด</label></td>'+
            '</tr>'+
            '<tr class="info">'+
              '<td class="text-center">เลือก</td>'+
              '<td class="text-center">เวลา</td>'+
              '<td class="text-center">ธง</td>'+
              '<td class="text-center">สด</td>'+
              '<td class="text-right">เจ้าบ้าน</td>'+
              '<td class="text-center">ผลบอล</td>'+
              '<td class="text-left">ทีมเยือน</td>'+
              '<td class="text-center">ครึ่งแรก</td>'+
              '<td class="text-center">ทีเด็ด</td>'+
              '<td class="text-center">ลิงค์ดูบอล</td>'+
            '</tr>'+
          '</thead>'
        );

        $.each(data['data'], function(i, v){
          if(v['league_id'] == index){
            $('#livescore').append(
              '<tbody>'+
                '<tr>'+
                  '<td class="text-center">'+
                    '<input type="checkbox" data-date="'+v['match_date']+'" value="'+v['match_id']+'"'+
                    (data['live'].hasOwnProperty(v['match_id']) ? ' checked' : '')+'>'+
                  '</td>'+
                  '<td class="text-center">'+CheckTime(v['match_time'])+'</td>'+
                  '<td class="text-center">'+
                    '<img style="margin-top:6px;" src="https://apifootball.com/widget/img/flags/'+value['country_name']+'.png">'+
                  '</td>'+
                  '<td class="text-center">'+v['match_status']+'</td>'+
                  '<td class="text-right">'+v['match_hometeam_name']+'</td>'+
                  '<td class="text-center">'+v['match_hometeam_score']+
                    '-'+v['match_awayteam_score']+
                  '</td>'+
                  '<td class="text-left">'+v['match_awayteam_name']+'</td>'+
                  '<td class="text-center">'+v['match_hometeam_halftime_score']+
                    '-'+v['match_awayteam_halftime_score']+
                  '</td>'+
                  '<td class="text-center">'+
                    '<input type="text" class="form-control" placeholder="ทีเด็ด" value="'+
                    (data['live'].hasOwnProperty(v['match_id']) ? (data['live'][v['match_id']]['tded'] ? data['live'][v['match_id']]['tded']:'') : '')+'">'+
                  '</td>'+
                  '<td class="text-center">'+
                    '<input type="text" class="form-control" placeholder="ลิงค์ดูบอล" value='+
                    (data['live'].hasOwnProperty(v['match_id']) ? (data['live'][v['match_id']]['link'] ? data['live'][v['match_id']]['link']:'') : '')+'>'+
                  '</td>'+
                '</tr>'+
              '</tbody>'
            );
          }
        });
      });
    },
    error: function(data){
      console.log(data);
    }
  });
}

function CheckTime(time)
{
  switch(time){
    case "FT":
      return "จบ";
      break;
    case "HT":
      return "พักครึ่ง";
      break;
    case "Postp.":
      return "เลื่อน";
      break;
    default:
      return moment(time+" +0100", "HH:mm Z").format('HH:mm');
  }
}
// function CheckMatchId(id)
// {
//
// }
