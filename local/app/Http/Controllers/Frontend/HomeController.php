<?php

namespace App\Http\Controllers\Frontend;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Match;
use App\Post;
use App\LiveScore;

// date_default_timezone_set('Asia/Bangkok');

class HomeController extends Controller
{

    public function index()
    {
      $aScript = array(
        'js/datepicker/moment.js',
        'js/frontend/home/home.js'
      );

      $aStyle = array(
        'css/frontend/home/style.css'
      );

      $news = Post::where('type', 'news')->orderBy('created_at', 'desc')
                    ->limit(14)
                    ->get();

      $clip = Post::where('type', 'highlight')->orderBy('created_at', 'desc')
                    ->limit(10)
                    ->get();

      // $curl_options = array(
      //   CURLOPT_URL => "http://78.46.64.77:1337/service/storage/201710/59e4fb5d1e142247148b4567/event.json",
      //   CURLOPT_URL => "http://inplay.goalserve.com/inplay.json",
      //   CURLOPT_RETURNTRANSFER => true,
      //   CURLOPT_HEADER => false
      // );
      //
      // $curl = curl_init();
      // curl_setopt_array( $curl, $curl_options );
      // $result = curl_exec( $curl );
      //
      // $result = (array) json_decode($result);
      // dd($result);


      return view('frontend.home.home', [
        'news' => $news,
        'clip' => $clip,
        'js' => $aScript,
        'css' => $aStyle
      ]);
    }

    public function bigmatch()
    {
      $match = Match::where('kick_start', '<=', NOW('Asia/Bangkok'))->get();
      // return $match;
      $match = Match::where('active', '=', 1)->get();

      return $match;
    }

    public function table()
    {
      $i = 0;
      $leagues = [];
      $data = [];
      $APIkey='a52a7c9ca7b9790d5f418448d64c717556d346f6458c9bc789312c9a268981ff';
      $from = date('Y-m-d');
      $to = date('Y-m-d');
      $curl_options = array(
      CURLOPT_URL => "https://apifootball.com/api/?action=get_events&from=$from&to=$to&APIkey=$APIkey",
      CURLOPT_RETURNTRANSFER => true,
      CURLOPT_HEADER => false
      );

      $curl = curl_init();
      curl_setopt_array( $curl, $curl_options );
      $result = curl_exec( $curl );

      $result = (array) json_decode($result);

      $live = LiveScore::where('match_date', $from)->get();

      foreach ($result as $key => $value) {
        foreach ($live as $k => $v) {
          if( $value->match_id == $v->match_id ){
            $value->tded = $v->tded;
            $value->link = $v->link;
            array_push( $data, $value );
          }
        }
      }

      foreach ($data as $r) {
        $leagues[$r->league_id] = [
                    'league_name' => $r->league_name,
                    'country_name' => $r->country_name
                  ];
      }

      return response()->json([
          'data' => $data,
          'leagues' => $leagues
      ]);
    }

    public function array_orderby()
    {
      $args = func_get_args();

      $data = array_shift($args);

      foreach ($args as $n => $field) {
        if (is_string($field)) {
          $tmp = array();
          foreach ($data as $key => $row){
            $tmp[$key] = $row->$field;
            $args[$n] = $tmp;
          }
        }
      }

      $args[] = &$data;
      call_user_func_array('array_multisort', $args);
      return array_pop($args);
    }

    public function detail(Request $request)
    {
      $league_id = $request->league_id;
      $match_id = $request->match_id;
      $i = 0;
      $data = [];
      $APIkey='a52a7c9ca7b9790d5f418448d64c717556d346f6458c9bc789312c9a268981ff';
      $from = date('Y-m-d');
      $to = date('Y-m-d');
//curl_standing
      $curl_options = array(
        CURLOPT_URL => "https://apifootball.com/api/?action=get_standings&league_id=$league_id&APIkey=$APIkey",
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_HEADER => false
      );

      $curl = curl_init();
      curl_setopt_array( $curl, $curl_options );
      $standing = curl_exec( $curl );
      $standing = (array) json_decode($standing);

//curl_handicap
      $curl_options = array(
        CURLOPT_URL => "https://apifootball.com/api/?action=get_odds&from=$from&to=$to&match_id=$match_id&APIkey=$APIkey",
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_HEADER => false
      );
      $curl = curl_init();
      curl_setopt_array( $curl, $curl_options );
      $handicap = curl_exec( $curl );
      $handicap = (array) json_decode($handicap, true);


//check error
      if( !array_key_exists( 'error', $standing ) ){
        $s = $standing;
        foreach ($standing as $key => $value) {
          $s[$key]->overall_league_GD = $value->overall_league_GF - $value->overall_league_GA;
          $i++;
        }
        $sorted = $this->array_orderby($s, 'overall_league_PTS', SORT_DESC, 'overall_league_GD', SORT_DESC);
        $data['standing'] = $sorted;
      }

      if( !array_key_exists( 'error', $handicap ) ){
        $_1x2 = [];
        foreach ($handicap as $key => $value) {
          $_1x2[$key] = [
            'odd_bookmakers' => $value['odd_bookmakers'],
            'odd_1' => $value['odd_1'],
            'odd_x' => $value['odd_x'],
            'odd_2' => $value['odd_2']
          ];
        }
        $data['1x2'] = $_1x2;

        $pat = "/^(ah)/";
        $asian = [];
        foreach ($handicap as $v) {
          unset( $v['ah+0.5_1'] );
          foreach ($v as $key => $value) {
            if( preg_match( $pat, $key ) ){
              if( !empty($value) ){
                $str = preg_replace($pat, 'อัตราต่อรอง เอเชีย ', $key);
                $str1 = explode("_", $str);
                $asian[$str1[0]] = array();
              }
            }
          }
        }

        foreach ($asian as $k => $v) {
          $str = explode(" ", $k);
          foreach ($handicap as $key => $value) {

            if($value['ah'.$str[2].'_1'] != ''){
              $asian[$k][$key] = [
                'odd_bookmakers' => $value['odd_bookmakers'],
                'ah_1' => $value['ah'.$str[2].'_1'],
                'ah_2' => $value['ah'.$str[2].'_2']
              ];
            }
          }
        }
        if( count($asian) != 0 ){
          $data['asian'] = $asian;
        }

        $ou = [];
        $pat = "/^[ou]\+/";
        foreach ($handicap as $v) {
          foreach ($v as $key => $value) {
            if( preg_match( $pat, $key ) ){
              if( !empty($value) ){
                $str = preg_replace($pat, 'สูง/ต่ำ +', $key);
                $ou[$str] = array();
              }
            }
          }
        }

        foreach ($ou as $k => $v) {
          $str = explode(" ", $k);
          foreach ($handicap as $key => $value) {
            if($value['o'.$str[1]] != ''){
              $ou[$k][$key] = [
                'odd_bookmakers' => $value['odd_bookmakers'],
                'o' => $value['o'.$str[1]],
                'u' => $value['u'.$str[1]]
              ];
            }
          }
        }
        if( count($ou) != 0 ){
          $data['ou'] = $ou;
          $data['handicap'] = $handicap;
        }

      }

      return response()->json($data);
    }
}
