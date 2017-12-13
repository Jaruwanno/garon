$(function(){
  /*Menu-toggle*/
  $("#menu-toggle").click(function(e) {
      e.preventDefault();
      $("#wrapper").toggleClass("active");
  });
  /*Scroll Spy*/
  $('body').scrollspy({ target: '#spy', offset:80});
// -----------------------------------
  var league_id, match_id;

  callTable();

  $(document).on('click', 'a.country', function(e){
    e.preventDefault();
    var country_id = $(this).attr('country-id');
    callTable(country_id);
  });

  $(document).on('click', 'button.detail', function(e){
    var load = $(this).button('loading');
    league_id = $(this).attr('league_id');
    match_id = $(this).attr('match_id');
    callDetail( match_id, league_id, load );
  });

  $('#myModal').on('shown.bs.modal', function (e) {
    $('.nav-pills a:first').tab('show');
  });

  $('#myModal').on('hide.bs.modal', function (e) {
    $('.modal-body').html(
      '<ul class="nav nav-pills" role="tablist"></ul>'+
      '<div class="tab-content"></div>'
    );
  });
});

function time_in_table(time){
  var t;
  switch(time){

    case 'FT' || 'HT':
      t = time;
      break;
    case 'Canc.':
      t = 'ยกเลิก';
      break;
    case 'Postp.':
      t = 'เลื่อน';
      break;
    case 'AET':
      t = 'ต่อเวลา';
      break;
    default:
      var arr = time.split(":");
      var mo = moment();
      mo.set({
          'hour': parseInt(arr[0])+6,
          'minute': parseInt(arr[1])
      });
      t = mo.format("HH:mm")+' น.';
      break;
  }
  return t;
}

function highlight(time){
  if(time=='FT' || time=='HT'){
    return time;
  }else{
    return '<p class="red">'+ time +'</p>'
  }
}

function callTable(country="all"){
  var c = country;
  $.ajax({
    'url' : 'table/score/'+c,
    'type' : 'get',
    'dataType' : 'json',
    beforeSend: function(){
      $('#table').html('');
      $('#loader').show();
    },
    success : function(data){
      // console.log(data);
      // alert('gar');
      $('#loader').hide();
{
      $.each(data['leagues'], function(index, value){
        $('#table').append(
            '<thead>'+
              '<tr class="head">'+
                '<th colspan=8>'+
                '<img src="https://apifootball.com/widget/img/flags/'+value['country_name']+'.png" '+
                'style="float:left; margin-top:5px; margin-right:5px;">'+
                'โปรแกรมบอล ราคาบอล ผลบอล '+
                value['country_name']+' '+
                value['league_name']+
                '</th>'+
              '</tr>'+
              '<tr class="second">'+
                '<th class="text-center">เวลา</th>'+
                '<th class="text-center">ธง</th>'+
                '<th class="text-center">สด</th>'+
                '<th class="text-right">เจ้าบ้าน</th>'+
                '<th class="text-center">ผลบอล</th>'+
                '<th class="text-left">ทีมเยือน</th>'+
                '<th class="text-center">ครึ่งแรก</th>'+
                '<th class="text-center">รายละเอียด</th>'+
              '</tr>'+
            '</thead>'
        );

        $.each(data['data'], function(i, v){
          if(v['league_id'] == index){
            $('#table').append(
              '<tbody>'+
                '<tr>'+
                  '<td class="text-center">'+time_in_table(v['match_time'])+'</td>'+
                  '<td class="text-center">'+
                    '<img src="https://apifootball.com/widget/img/flags/'+value['country_name']+'.png">'+
                  '</td>'+
                  '<td class="text-center">'+highlight(v['match_status'])+'</td>'+
                  '<td class="text-right">'+v['match_hometeam_name']+'</td>'+
                  '<td class="text-center">'+v['match_hometeam_score']+
                    '-'+v['match_awayteam_score']+
                  '</td>'+
                  '<td class="text-left">'+v['match_awayteam_name']+'</td>'+
                  '<td class="text-center">'+v['match_hometeam_halftime_score']+
                    '-'+v['match_awayteam_halftime_score']+
                  '</td>'+
                  '<td class="text-center">'+
                    '<button type="button" class="detail btn btn-default btn-sm" league_id="'+v['league_id']+'" match_id="'+v['match_id']+'" '+
                    'id="load" data-loading-text="<i class=\'fa fa-lg fa-circle-o-notch fa-spin\'></i>">'+
                      '<i class="fa fa-lg fa-bar-chart"></i>'+
                    '</button>'+
                  '</td>'+
                '</tr>'+
              '</tbody>'
            );
          }
        });
      });
}
    },
    error : function(data){
      console.log(data);
    }
  });
}
function callDetail( match_id, league_id, load ){
  $.ajax({
    headers:{
      'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    },
    type: 'POST',
    data: {'match_id':match_id, 'league_id':league_id},
    url: 'table/details',
    dataType:'json',
    success:function(data){
      console.log(data);
      load.button('reset');

      if( data.hasOwnProperty('match_details') ){
        $('.nav-pills').append(
          '<li role="presentation">'+
            '<a data-name="match_details" href="#match_details" aria-controls="standing" role="tab" data-toggle="tab">เหตุการณ์</a>'+
          '</li>'
        );

        $('.tab-content').append(
          '<div role="tabpanel" class="tab-pane" id="match_details">'+
            '<br>'+
            '<div class="text-center col-xs-6">'+
              '<h2>เหย้า</h2>'+
            '</div>'+
            '<div class="text-center col-xs-6">'+
              '<h2>เยือน</h2>'+
            '</div>'+
            '<div class="clearfix"></div>'+
            '<ul class="timeline"></ul>'+
          '</div>'
        );
        $.each(data.match_details, function(i, v){
          var n = parseInt(i);
          $('div#match_details > ul.timeline').append(
            '<li class="'+n+'">'+
              '<div class="timeline-badge">'+i+'</div>'+
            '</li>'
          );
          if(v.hasOwnProperty('home')){
            $('div#match_details > ul.timeline > li.'+n).append(
              '<div class="timeline-panel">'+
                '<div class="timeline-body"></div>'+
              '</div>'
            );
            var str = 'div#match_details > ul.timeline > li.'+n+
                      ' > div.timeline-panel > div.timeline-body';

            if(v.home.hasOwnProperty('goals')){
              $.each(v.home.goals, function(index, value){
                $(str).append(
                  '<p><i class="fa fa-futbol-o"></i>&nbsp&nbsp'+value.score+'&nbsp&nbsp&nbsp&nbsp&nbsp( '+value.player+' )</p>'
                );
              });
            }
            if(v.home.hasOwnProperty('cards')){
              $.each(v.home.cards, function(index, value){
                $(str).append(
                  '<p><img width="20px" src="pic/'+(value.card=='yellowcard'?'yellow_card':'red_card')+'.png">&nbsp&nbsp&nbsp&nbsp'+value.player+'</p>'
                );
              });
            }
          }
          if(v.hasOwnProperty('away')){
            $('div#match_details > ul.timeline > li.'+n).append(
              '<div class="timeline-panel right">'+
                '<div class="timeline-body"></div>'+
              '</div>'
            );
            var str = 'div#match_details > ul.timeline > li.'+n+
                      ' > div.right > div.timeline-body';
            if(v.away.hasOwnProperty('goals')){
              $.each(v.away.goals, function(index, value){
                $(str).append(
                  '<p><i class="fa fa-futbol-o"></i> '+value.score+'&nbsp&nbsp&nbsp&nbsp( '+value.player+' )</p>'
                );
              });
            }
            if(v.away.hasOwnProperty('cards')){
              $.each(v.away.cards, function(index, value){
                $(str).append(
                  '<p><img width="20px" src="pic/'+(value.card=='yellowcard'?'yellow_card':'red_card')+'.png">&nbsp&nbsp&nbsp&nbsp'+value.player+'</p>'
                );
              });
            }
          }
        });
      }

      if( data.hasOwnProperty('standing') ){
        var n = 1;
        $('.nav-pills').append(
          '<li role="presentation">'+
            '<a data-name="standing" href="#standing" aria-controls="standing" role="tab" data-toggle="tab">ลำดับ-คะแนน</a>'+
          '</li>'
        );

        $('.tab-content').append(
          '<div role="tabpanel" class="tab-pane" id="standing">'+
            '<br>'+
            '<div class="table-responsive">'+
              '<table class="table table-condensed"></table>'+
            '</div>'+
          '</div>'
        );

        $('div.tab-content > div#standing > div > table').append(
          '<thead>'+
            '<tr class="head">'+
              '<th class="text-right">ลำดับ</th>'+
              '<th>ชื่อทีม</th>'+
              '<th class="text-right">แข่ง</th>'+
              '<th class="text-right">ชนะ</th>'+
              '<th class="text-right">เสมอ</th>'+
              '<th class="text-right">แพ้</th>'+
              '<th class="text-right">ได้</th>'+
              '<th class="text-right">เสีย</th>'+
              '<th class="text-right">+/-</th>'+
              '<th class="text-right">คะแนน</th>'+
            '</tr>'+
          '</thead>'
        );

        $.each(data.standing, function(i, v){
          $('div.tab-content > div#standing > div > table').append(
            '<tbody>'+
              '<tr>'+
                '<td class="text-right">'+n+'</td>'+
                '<td>'+v.team_name+'</td>'+
                '<td class="text-right">'+v.overall_league_payed+'</td>'+
                '<td class="text-right">'+v.overall_league_W+'</td>'+
                '<td class="text-right">'+v.overall_league_D+'</td>'+
                '<td class="text-right">'+v.overall_league_L+'</td>'+
                '<td class="text-right">'+v.overall_league_GF+'</td>'+
                '<td class="text-right">'+v.overall_league_GA+'</td>'+
                '<td class="text-right">'+v.overall_league_GD+'</td>'+
                '<td class="text-right">'+v.overall_league_PTS+'</td>'+
              '</tr>'+
            '</tbody>'
          );
          n++;
        });
      }

      if( data.hasOwnProperty('1x2') ){
        $('.nav-pills').append(
          '<li role="presentation">'+
            '<a data-name="1x2" href="#1x2" aria-controls="1x2" role="tab" data-toggle="tab">ราคาพูล</a>'+
          '</li>'
        );

        $('.tab-content').append(
          '<div role="tabpanel" class="tab-pane" id="1x2">'+
            '<br>'+
            '<div class="table-responsive">'+
              '<table class="table table-condensed"></table>'+
            '</div>'+
          '</div>'
        );

        $('div.tab-content > div#1x2 > div > table').append(
          '<thead>'+
            '<tr class="head">'+
              '<th class="text-center">แบนเนอร์</th>'+
              '<th>ผู้บริการ</th>'+
              '<th class="text-right">เหย้า</th>'+
              '<th class="text-right">เสมอ</th>'+
              '<th class="text-right">เยือน</th>'+
            '</tr>'+
          '</thead>'
        );

        $.each(data['1x2'], function(i, v){
          $('div.tab-content > div#1x2 > div > table').append(
            '<tbody>'+
              '<tr>'+
                '<td class="text-center">'+
                  '<img width="180px" src="'+
                  (v.odd_bookmakers=='Chance.cz'||v.odd_bookmakers=='Asianodds' ?
                  checkBookmakers( v.odd_bookmakers, "banner" ) : checkBanner( v.odd_bookmakers ))+
                  '">'+
                '</td>'+
                '<td>'+
                  (v.odd_bookmakers=='Chance.cz'||v.odd_bookmakers=='Asianodds' ? checkBookmakers( v.odd_bookmakers ) :
                  v.odd_bookmakers)+
                '</td>'+
                '<td class="text-right">'+v.odd_1+'</td>'+
                '<td class="text-right">'+v.odd_x+'</td>'+
                '<td class="text-right">'+v.odd_2+'</td>'+
              '</tr>'+
            '</tbody>'
          );
        });
      }
      if( data.hasOwnProperty( 'asian' ) ){
        var id = 1;
        $('.nav-pills').append(
          '<li role="presentation">'+
            '<a data-name="asian" href="#asian" aria-controls="asian" role="tab" data-toggle="tab">อัตราต่อรอง เอเชีย</a>'+
          '</li>'
        );

        $('.tab-content').append(
          '<div role="tabpanel" class="tab-pane" id="asian">'+
            '<br>'+
            '<div class="table-responsive">'+
              '<table class="table table-condensed">'+
              '</table>'+
            '</div>'+
          '</div>'
        );

        $.each(data.asian, function(k, v){
          $('div.tab-content > div#asian > div > table').append(
            '<thead>'+
              '<tr class="second" data-toggle="collapse" data-target=".ah'+id+'">'+
                '<th class="text-center" colspan="4">'+k+
                  '&nbsp&nbsp&nbsp<i class="fa fa-caret-down" aria-hidden="true"></i>'+
                '</th>'+
              '</tr>'+
              '<tr class="head collapse ah'+id+'">'+
                '<th class="text-center">แบนเนอร์</th>'+
                '<th>ผู้ให้บริการ</th>'+
                '<th class="text-right">เหย้า</th>'+
                '<th class="text-right">เยือน</th>'+
              '</tr>'+
            '</thead>'
          );

          $.each(v, function(key, value){
            $('div.tab-content > div#asian > div > table').append(
              '<tbody>'+
                '<tr class="collapse ah'+id+'">'+
                  '<td class="text-center">'+
                    '<img width="180px" src="'+
                    (value.odd_bookmakers=='Chance.cz'||value.odd_bookmakers=='Asianodds' ?
                    checkBookmakers( value.odd_bookmakers, "banner" ) : checkBanner( value.odd_bookmakers ))+
                    '">'+
                  '</td>'+
                  '<td>'+
                    (value.odd_bookmakers=='Chance.cz'||value.odd_bookmakers=='Asianodds' ? checkBookmakers( value.odd_bookmakers ) :
                    value.odd_bookmakers)+
                  '</td>'+
                  '<td class="text-right">'+value.ah_1+'</td>'+
                  '<td class="text-right">'+value.ah_2+'</td>'+
                '</tr>'+
              '</tbody>'
            );
          });
          id++;
        });
      }
      if( data.hasOwnProperty( 'ou' ) ){
        var id = 1;
        $('.nav-pills').append(
          '<li role="presentation">'+
            '<a data-name="ou" href="#ou" aria-controls="ou" role="tab" data-toggle="tab">สูงต่ำ</a>'+
          '</li>'
        );
        $('.tab-content').append(
          '<div role="tabpanel" class="tab-pane" id="ou">'+
            '<br>'+
            '<div class="table-responsive">'+
              '<table class="table table-condensed"></table>'+
            '</div>'+
          '</div>'
        );

        $.each(data.ou, function(k, v){
          $('div.tab-content> div#ou > div > table').append(
            '<thead>'+
              '<tr class="second" data-toggle="collapse" data-target=".ou'+id+'">'+
                '<th class="text-center" colspan="4">'+k+
                  '&nbsp&nbsp&nbsp<i class="fa fa-caret-down" aria-hidden="true"></i>'+
                '</th>'+
              '</tr>'+
              '<tr class="head collapse ou'+id+'">'+
                '<th class="text-center">แบนเนอร์</th>'+
                '<th>ผู้ให้บริการ</th>'+
                '<th class="text-right">สูง</th>'+
                '<th class="text-right">ต่ำ</th>'+
              '</tr>'+
            '</thead>'
          );

          $.each(v, function(k, v){
            $('div.tab-content > div#ou > div > table').append(
              '<tbody>'+
                '<tr class="collapse ou'+id+'">'+
                  '<td class="text-center">'+
                    '<img width="180px" src="'+(v.odd_bookmakers=='Chance.cz'?'pic/vegus24hr.jpg':'https://mybet.tips/images/bookmakers/'+v.odd_bookmakers+'.png')+'">'+
                  '</td>'+
                  '<td>'+(v.odd_bookmakers=='Chance.cz'?'<a class="red" target="_blank" href="http://vegus24hr.com/">Vegus24hr (สนใจเดิมพันคลิกเลย!)</a>':v.odd_bookmakers)+'</td>'+
                  '<td class="text-right">'+v.o+'</td>'+
                  '<td class="text-right">'+v.u+'</td>'+
                '</tr>'+
              '</tbody>'
            );
          });
          id++;
        });
      }
      $('#myModal').modal('show');
    },
    error: function(data){
      console.log(data);
    }
  });
}

function checkBanner(banner){
  var str = banner.toLowerCase();
  var aBanner = [
    "dotabet",
    "betcity",
    "william hill",
    "island casino",
    "betfair",
    "ifortuna.cz",
    "tipsport.cz",
    "france pari",
    "bet365.it",
    "sazkabet.cz",
    "betclic.it",
    "bwin.it"
  ];
  if( jQuery.inArray( str, aBanner ) != -1){
    return 'banner/'+banner+'.png';
  }else{
    return 'https://mybet.tips/images/bookmakers/'+banner+'.png'
  }
}

function checkBookmakers(bookmakers, type=false){
  if( bookmakers == "Chance.cz" ){
    if(type == "banner"){
      return 'pic/vegus24hr.jpg';
    }else{
      return '<a class="red" target="_blank" href="http://vegus24hr.com/">Vegus24hr (สนใจเดิมพันคลิกเลย!)</a>';
    }
  }else if( bookmakers == "Asianodds" ){
    if(type == "banner"){
      return 'pic/vegus168sure.jpg';
    }else{
      return '<a class="red" target="_blank" href="http://www.vegus168sure.com/">vegus168sure (สนใจเดิมพันคลิกเลย!)</a>';
    }
  }
}
