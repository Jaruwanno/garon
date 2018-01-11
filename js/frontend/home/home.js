$(function(){
  alert('fd');
  // var league_id;
  // var match_id;
  $.ajax({
    'url' : 'bigmatch',
    'dataType' : 'json',
    'type' : 'get',
    success : function(d){
      if(d.length == 0){
        return;
      }
      $('.bigmatch').html("");
      $('.bigmatch').append(
        '<span>'+
          '<h1 class="match-text">'+d[0].topic+'</h1>'+
          '<div class="logo-team">'+
            '<img src="'+match_path+'/'+d[0].home_png+'">'+
            ' vs '+
            '<img src="'+match_path+'/'+d[0].away_png+'">'+
          '</div>'+
          '<span><p id="day"></p>วัน</span>'+
          '<span><p id="hours"></p>ชั่วโมง</span>'+
          '<span><p id="minutes"></p>นาที</span>'+
          '<span><p id="seconds"></p>วินาที</span>'+
        '</span>'
      );
      countDown( d[0].kick_start );
    },
    error : function(d){
      console.log(d);
    }
  });
  // callTable();
 //  var setVal = function(){
 //    callTable();
 //  }
 // setInterval(setVal, 30000);

  // $(document).on('click', 'button.detail', function(e){
  //   var load = $(this).button('loading');
  //   league_id = $(this).attr('league_id');
  //   match_id = $(this).attr('match_id');
  //   // $('#myModal').modal('show');
  //   callDetail(match_id, league_id, load);
  // });
  //
  // $('#myModal').on('shown.bs.modal', function (e) {
  //   $('.nav-pills a:first').tab('show');
  // });
  //
  // $('#myModal').on('hide.bs.modal', function (e) {
  //   $('.modal-body').html(
  //     '<ul class="nav nav-pills" role="tablist"></ul>'+
  //     '<div class="tab-content"></div>'
  //   );
  // });

});

// function callTable(){
//   $.ajax({
//     type:'get',
//     url: 'home/table',
//     dataType: 'json',
//     success: function (data) {
//       console.log(data);
//       $('#loader').hide();
//       $('#table').html("");
//       $.each(data['leagues'], function(index,value){
//         $('#table').append(
//           '<tr class="head">'+
//             '<td colspan=10>'+
//             '<img src="https://apifootball.com/widget/img/flags/'+value['country_name']+'.png" '+
//             'style="float:left; margin-top:5px; margin-right:5px;">'+
//             'โปรแกรมบอล ราคาบอล ผลบอล '+
//             value['country_name']+' '+
//             value['league_name']+'</td></tr>'+
//           '<tr class="second">'+
//             '<td class="text-center">เวลา</td>'+
//             '<td class="text-center">ธง</td>'+
//             '<td class="text-center">สด</td>'+
//             '<td class="text-right">เจ้าบ้าน</td>'+
//             '<td class="text-center">ผลบอล</td>'+
//             '<td class="text-left">ทีมเยือน</td>'+
//             '<td class="text-center">ครึ่งแรก</td>'+
//             '<td class="text-center">ทรรศนะ</td>'+
//             '<td class="text-center">ถ่ายทอดสด</td>'+
//             '<td class="text-center">รายละเอียด</td>'+
//           '</tr>'
//         );
//         $.each(data['data'], function(i, v){
//           if(v['league_id'] == index){
//             $('#table').append(
//               '<tr>'+
//                 '<td class="text-center">'+time_in_table(v['match_time'])+'</td>'+
//                 '<td class="text-center">'+
//                   '<img src="https://apifootball.com/widget/img/flags/'+value['country_name']+'.png">'+
//                 '</td>'+
//                 '<td class="text-center">'+highlight(v['match_status'])+'</td>'+
//                 '<td class="text-right">'+v['match_hometeam_name']+'</td>'+
//                 '<td class="text-center">'+v['match_hometeam_score']+
//                   '-'+v['match_awayteam_score']+
//                 '</td>'+
//                 '<td class="text-left">'+v['match_awayteam_name']+'</td>'+
//                 '<td class="text-center">'+v['match_hometeam_halftime_score']+
//                   '-'+v['match_awayteam_halftime_score']+
//                 '</td>'+
//                 '<td class="text-center">'+(v['tded']?v['tded']:'')+'</td>'+
//                 '<td class="text-center">'+
//                 (v['link']?'<a target="_blank" href="'+v['link']+'">BallLive365</a>':'')+
//                 '</td>'+
//                 '<td class="text-center">'+
//                   '<button type="button" class="detail btn btn-default btn-xs" league_id="'+v['league_id']+'" match_id="'+v['match_id']+'" '+
//                   'id="load" data-loading-text="<i class=\'fa fa-lg fa-circle-o-notch fa-spin\'></i>">'+
//                     '<i class="fa fa-lg fa-bar-chart"></i>'+
//                   '</button>'+
//                 '</td>'+
//               '</tr>'
//             );
//           }
//         });
//       });
//     },
//     error: function (data) {
//       console.log('Error:', data);
//     }
//   });
// }
//
// function callDetail(match_id, league_id, load){
//   $.ajax({
//     headers: {
//       'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
//     },
//     type:'POST',
//     data: {'match_id':match_id, 'league_id':league_id},
//     url: 'home/table/detail',
//     dataType: 'json',
//     success: function(data){
//       load.button('reset');
//       console.log(data);
//
//       if(data.length == 0){
//         $('.modal-body').append(
//           '<h1 class="text-center bg-warning">ไม่พบข้อมูลค่ะ</h1>'
//         );
//       }
//
//       if( data.hasOwnProperty('standing') ){
//         var n = 1;
//         $('.nav-pills').append(
//           '<li role="presentation">'+
//             '<a data-name="standing" href="#standing" aria-controls="standing" role="tab" data-toggle="tab">ลำดับ-คะแนน</a>'+
//           '</li>'
//         );
//
//         $('.tab-content').append(
//           '<div role="tabpanel" class="tab-pane" id="standing">'+
//             '<br>'+
//             '<div class="table-responsive">'+
//               '<table class="table table-condensed"></table>'+
//             '</div>'+
//           '</div>'
//         );
//
//         $('div.tab-content > div#standing > div > table').append(
//           '<tr class="head">'+
//             '<td class="text-right">ลำดับ</td>'+
//             '<td>ชื่อทีม</td>'+
//             '<td class="text-right">แข่ง</td>'+
//             '<td class="text-right">ชนะ</td>'+
//             '<td class="text-right">เสมอ</td>'+
//             '<td class="text-right">แพ้</td>'+
//             '<td class="text-right">ได้</td>'+
//             '<td class="text-right">เสีย</td>'+
//             '<td class="text-right">+/-</td>'+
//             '<td class="text-right">คะแนน</td>'+
//           '</tr>'
//         );
//
//         $.each(data.standing, function(i, v){
//           $('div.tab-content > div#standing > div > table').append(
//             '<tr>'+
//               '<td class="text-right">'+n+'</td>'+
//               '<td>'+v.team_name+'</td>'+
//               '<td class="text-right">'+v.overall_league_payed+'</td>'+
//               '<td class="text-right">'+v.overall_league_W+'</td>'+
//               '<td class="text-right">'+v.overall_league_D+'</td>'+
//               '<td class="text-right">'+v.overall_league_L+'</td>'+
//               '<td class="text-right">'+v.overall_league_GF+'</td>'+
//               '<td class="text-right">'+v.overall_league_GA+'</td>'+
//               '<td class="text-right">'+v.overall_league_GD+'</td>'+
//               '<td class="text-right">'+v.overall_league_PTS+'</td>'+
//             '</tr>'
//           );
//           n++;
//         });
//       }
//
//       if( data.hasOwnProperty('1x2') ){
//         $('.nav-pills').append(
//           '<li role="presentation">'+
//             '<a data-name="1x2" href="#1x2" aria-controls="1x2" role="tab" data-toggle="tab">ราคาพูล</a>'+
//           '</li>'
//         );
//
//         $('.tab-content').append(
//           '<div role="tabpanel" class="tab-pane" id="1x2">'+
//             '<br>'+
//             '<div class="table-responsive">'+
//               '<table class="table table-condensed"></table>'+
//             '</div>'+
//           '</div>'
//         );
//
//         $('div.tab-content > div#1x2 > div > table').append(
//           '<tr class="head">'+
//             '<td class="text-center">แบนเนอร์</td>'+
//             '<td>โต๊ะพนัน</td>'+
//             '<td class="text-right">เจ้าบ้าน</td>'+
//             '<td class="text-right">เสมอ</td>'+
//             '<td class="text-right">ทีมเยือน</td>'+
//           '</tr>'
//         );
//
//         $.each(data['1x2'], function(i, v){
//           $('div.tab-content > div#1x2 > div > table').append(
//             '<tr>'+
//               '<td class="text-center">'+
//                 '<img width="180px" src="'+(v.odd_bookmakers=='bet365'?'pic/vegus24hr.jpg':'https://mybet.tips/images/bookmakers/'+v.odd_bookmakers+'.png')+'">'+
//               '</td>'+
//               '<td>'+(v.odd_bookmakers=='bet365'?'<a class="red" target="_blank" href="http://vegus24hr.com/">Vegus24hr</a>':v.odd_bookmakers)+'</td>'+
//               '<td class="text-right">'+v.odd_1+'</td>'+
//               '<td class="text-right">'+v.odd_x+'</td>'+
//               '<td class="text-right">'+v.odd_2+'</td>'+
//             '</tr>'
//           );
//         });
//       }
//
//       if( data.hasOwnProperty( 'asian' ) ){
//         var sec = true,
//             id = 1;
//
//         $('.nav-pills').append(
//           '<li role="presentation">'+
//             '<a data-name="asian" href="#asian" aria-controls="asian" role="tab" data-toggle="tab">อัตราต่อรอง เอเชีย</a>'+
//           '</li>'
//         );
//
//         $('.tab-content').append(
//           '<div role="tabpanel" class="tab-pane" id="asian">'+
//             '<br>'+
//             '<div class="table-responsive">'+
//               '<table class="table table-condensed">'+
//               '</table>'+
//             '</div>'+
//           '</div>'
//         );
//
//         $.each(data.asian, function(k, v){
//           sec = true;
//           $('div.tab-content> div#asian > div > table').append(
//             '<tr class="second" data-toggle="collapse" data-target=".ah'+id+'">'+
//               '<td class="text-center" colspan="4">'+k+
//                 '&nbsp&nbsp&nbsp<i class="fa fa-caret-down" aria-hidden="true"></i>'+
//               '</td>'+
//             '</tr>'
//           );
//
//           $.each(v, function(key, value){
//             if(sec){
//               $('div.tab-content > div#asian > div > table').append(
//                 '<tr class="head collapse ah'+id+'">'+
//                   '<td class="text-center">แบนเนอร์</td>'+
//                   '<td>โต๊ะพนัน</td>'+
//                   '<td class="text-right">เหย้า</td>'+
//                   '<td class="text-right">เยือน</td>'+
//                 '</tr>'
//               );
//               sec = false;
//             }
//
//             $('div.tab-content > div#asian > div > table').append(
//               '<tr class="collapse ah'+id+'">'+
//                 '<td class="text-center">'+
//                   '<img width="180px" src="'+(value.odd_bookmakers=='bet365'?'pic/vegus24hr.jpg':'https://mybet.tips/images/bookmakers/'+value.odd_bookmakers+'.png')+'">'+
//                 '</td>'+
//                 '<td>'+(value.odd_bookmakers=='bet365'?'<a class="red" target="_blank" href="http://vegus24hr.com/">Vegus24hr</a>':value.odd_bookmakers)+'</td>'+
//                 '<td class="text-right">'+value.ah_1+'</td>'+
//                 '<td class="text-right">'+value.ah_2+'</td>'+
//               '</tr>'
//             );
//
//           });
//
//           id++;
//         });
//       }
//
//       if( data.hasOwnProperty( 'ou' ) ){
//         var id = 0,
//             sec;
//         $('.nav-pills').append(
//           '<li role="presentation">'+
//             '<a data-name="ou" href="#ou" aria-controls="ou" role="tab" data-toggle="tab">สูงต่ำ</a>'+
//           '</li>'
//         );
//
//         $('.tab-content').append(
//           '<div role="tabpanel" class="tab-pane" id="ou">'+
//             '<br>'+
//             '<div class="table-responsive">'+
//               '<table class="table table-condensed"></table>'+
//             '</div>'+
//           '</div>'
//         );
//         $.each(data.ou, function(k, v){
//           sec = true;
//           $('div.tab-content> div#ou > div > table').append(
//             '<tr class="second" data-toggle="collapse" data-target=".ou'+id+'">'+
//               '<td class="text-center" colspan="4">'+k+
//                 '&nbsp&nbsp&nbsp<i class="fa fa-caret-down" aria-hidden="true"></i>'+
//               '</td>'+
//             '</tr>'
//           );
//
//           $.each(v, function(k, v){
//             if(sec){
//               $('div.tab-content > div#ou > div > table').append(
//                 '<tr class="head collapse ou'+id+'">'+
//                   '<td class="text-center">แบนเนอร์</td>'+
//                   '<td>โต๊ะพนัน</td>'+
//                   '<td class="text-right">สูง</td>'+
//                   '<td class="text-right">ต่ำ</td>'+
//                 '</tr>'
//               );
//               sec = false;
//             }
//             $('div.tab-content > div#ou > div > table').append(
//               '<tr class="collapse ou'+id+'">'+
//                 '<td class="text-center">'+
//                   '<img width="180px" src="'+(v.odd_bookmakers=='bet365'?'pic/vegus24hr.jpg':'https://mybet.tips/images/bookmakers/'+v.odd_bookmakers+'.png')+'">'+
//                 '</td>'+
//                 '<td>'+(v.odd_bookmakers=='bet365'?'<a class="red" target="_blank" href="http://vegus24hr.com/">Vegus24hr</a>':v.odd_bookmakers)+'</td>'+
//                 '<td class="text-right">'+v.o+'</td>'+
//                 '<td class="text-right">'+v.u+'</td>'+
//               '</tr>'
//             );
//           });
//           id++;
//         });
//       }
//
//       $('#myModal').modal('show');
//     },
//     error:function(data){
//       console.log(data);
//     }
//   });
//
//
// }
//
// function time_in_table(time){
//   var t;
//   switch(time){
//     default:
//       var arr = time.split(":");
//       var mo = moment();
//       mo.set({
//           'hour': parseInt(arr[0])+6,
//           'minute': parseInt(arr[1])
//       });
//       t = mo.format("HH:mm")+' น.';
//       break;
//     case 'FT' || 'HT':
//       t = time;
//       break;
//     case 'Canc.':
//       t = 'ยกเลิก';
//       break;
//     case 'Postp.':
//       t = 'เลื่อน';
//       break;
//
//   }
//   return t;
// }
//
// function highlight(time){
//   if(time=='FT' || time=='HT'){
//     return time;
//   }else{
//     return '<p class="red">'+ time +'</p>'
//   }
// }

function countDown(time){
  var kick = time;
  var countDownDate = new Date(kick).getTime();

  // Update the count down every 1 second
  var x = setInterval(function() {

    // Get todays date and time
    var now = new Date().getTime();

    // Find the distance between now an the count down date
    var distance = countDownDate - now;

    if (distance < 0) {
      clearInterval(x);
      $('.bigmatch').html(
        "<span>"+
          "<p>home</p>"+
          "<h1>หน้าแรก</h1>"+
        "</span>"
      );
    }

    // Time calculations for days, hours, minutes and seconds
    var days = Math.floor(distance / (1000 * 60 * 60 * 24));
    var hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
    var minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
    var seconds = Math.floor((distance % (1000 * 60)) / 1000);

    // Display the result in the element with id="demo"
    $("#day").html('30');
    document.getElementById("hours").innerHTML = hours;
    document.getElementById("minutes").innerHTML = minutes;
    document.getElementById("seconds").innerHTML = seconds;


    // If the count down is finished, write some text

  }, 1000);
}
