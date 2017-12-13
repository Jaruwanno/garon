<?php

namespace App\Http\Controllers\frontend;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Http\Controllers\Controller;
use Carbon\Carbon;
use User;

class TableController extends Controller
{

    public function __construct(){
      $this->d = Carbon::yesterday()->toDateString();
      $this->APIkey = 'a52a7c9ca7b9790d5f418448d64c717556d346f6458c9bc789312c9a268981ff';
    }

    public function callData($option){
      $curl_options = array(
        CURLOPT_URL => $option,
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_HEADER => false
      );

      $curl = curl_init();
      curl_setopt_array( $curl, $curl_options );
      $result = curl_exec( $curl );

      return (array) json_decode($result, true);
    }

    public function index()
    {
      $option = "https://apifootball.com/api/?action=get_events&from=$this->d&to=$this->d&APIkey=$this->APIkey";
      $country = [];
      $result = $this->callData($option);

      foreach ($result as $k => $r) {
        $country[$r['country_id']] = [
          'id' => $r['country_id'],
          'name' => $r['country_name']
        ];
      }
      $sorted = $this->array_orderby($country, 'name', SORT_ASC);
      $aScript = array(
        'js/datepicker/moment.js',
        'js/frontend/table/home.js'
      );

      $aStyle = array(
        'css/frontend/table/homestyle.css'
      );

      return view('frontend.table.home', [
        'js' => $aScript,
        'css' => $aStyle,
        'country' => $sorted
      ]);
    }

    public function table($country){
      if($country == 'all'){
        $option = "https://apifootball.com/api/?action=get_events&from=$this->d&to=$this->d&APIkey=$this->APIkey";
      }else{
        $option = "https://apifootball.com/api/?action=get_events&country_id=$country&from=$this->d&to=$this->d&APIkey=$this->APIkey";
      }
      $leagues = [];
      $result = $this->callData($option);
      foreach ($result as $k => $r) {
        $leagues[$r['league_id']] = [
          'league_name' => $r['league_name'],
          'country_name' => $r['country_name']
        ];
      }

      return response()->json([
        'data' => $result,
        'leagues' => $leagues
      ]);
    }

    public function details(Request $request){
      $m_id = $request->match_id;
      $l_id = $request->league_id;
      $data = [];
      $match_details = [];

// match_details
      $option = "https://apifootball.com/api/?action=get_events&from=$this->d&to=$this->d&match_id=$m_id&APIkey=$this->APIkey";
      $result = $this->callData($option);
      foreach ($result[0]['goalscorer'] as $v) {
        if( !array_key_exists( (int) $v['time'], $match_details ) ){
          $match_details[(int) $v['time']] = [];
        }
        if( !empty( $v['home_scorer'] ) ){

          if( !isset( $match_details[(int) $v['time']]['home']['goals'] ) ){
            $match_details[(int) $v['time']]['home']['goals'] = [];
          }
          array_push($match_details[(int) $v['time']]['home']['goals'], [
            'player' => $v['home_scorer'],
            'score' => $v['score']
          ]);
        }

        if( !empty( $v['away_scorer'] ) ){

          if( !isset( $match_details[(int) $v['time']]['away']['goals'] ) ){
            $match_details[(int) $v['time']]['away']['goals'] = [];
          }
          array_push($match_details[(int) $v['time']]['away']['goals'], [
            'player' => $v['away_scorer'],
            'score' => $v['score']
          ]);
        }
      }

      foreach($result[0]['cards'] as $v){
        if( !array_key_exists( (int) $v['time'], $match_details ) ){
          // if( (int) $v->time != 0){

          // }
          $match_details[(int) $v['time']] = [];
        }
        if( !empty( $v['home_fault'] ) ){

          if( !isset( $match_details[(int) $v['time']]['home']['cards'] ) ){
            $match_details[(int) $v['time']]['home']['cards'] = [];
          }
          array_push($match_details[(int) $v['time']]['home']['cards'], [
            'player' => $v['home_fault'],
            'card' => $v['card']
          ]);
        }
        if( !empty( $v['away_fault'] ) ){

          if( !isset( $match_details[(int) $v['time']]['away']['cards'] ) ){
            $match_details[(int) $v['time']]['away']['cards'] = [];
          }
          array_push($match_details[(int) $v['time']]['away']['cards'], [
            'player' => $v['away_fault'],
            'card' => $v['card']
          ]);
        }
      }
      if( count($match_details) != 0 ){
        ksort($match_details);
        $data['match_details'] = $match_details;
      }
// ------------------
// standing
      $option = "https://apifootball.com/api/?action=get_standings&league_id=$l_id&APIkey=$this->APIkey";
      $standing = $this->callData($option);
      if( !array_key_exists( 'error', $standing ) ){
        $s = $standing;
        foreach ($standing as $key => $value) {
          $s[$key]['overall_league_GD'] = $value['overall_league_GF'] - $value['overall_league_GA'];
        }
        $sorted = $this->array_orderby($s, 'overall_league_PTS', SORT_DESC, 'overall_league_GD', SORT_DESC);
        $data['standing'] = $sorted;
      }
// ------------------

      $option = "https://apifootball.com/api/?action=get_odds&from=$this->d&to=$this->d&match_id=$m_id&APIkey=$this->APIkey";
      $handicap = $this->callData($option);
      if( !array_key_exists( 'error', $handicap ) ){
        foreach ($handicap as $key => $value) {
          if( array_search( 'WilliamHill.it', $value ) ){
            unset($handicap[$key]);
          }elseif( array_search( 'iFortuna.sk', $value ) ){
            unset($handicap[$key]);
          }elseif( array_search( 'bwin.fr', $value ) ){
            unset($handicap[$key]);
          }elseif( array_search( 'Unibet.it', $value ) ){
            unset($handicap[$key]);
          }elseif( array_search( 'Betser', $value ) ){
            unset($handicap[$key]);
          }
        }

//1x2
        $_1x2 = [];
        foreach ($handicap as $key => $value) {
          $_1x2[$key] = [
            'odd_bookmakers' => $value['odd_bookmakers'],
            'odd_1' => $value['odd_1'],
            'odd_x' => $value['odd_x'],
            'odd_2' => $value['odd_2']
          ];
        }
        if( count($_1x2) != 0 ){
          $data['1x2'] = $_1x2;
        }
// ----------------------------
//asian handicap
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
// ----------------------------------------
// สูง ต่ำ
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
        }
// ------------------------------------
      }
      return response()->json($data);
    }

    public function array_orderby()
    {
      $args = func_get_args();

      $data = array_shift($args);

      foreach ($args as $n => $field) {
        if (is_string($field)) {
          $tmp = array();
          foreach ($data as $key => $row){
            $tmp[$key] = $row[$field];
            $args[$n] = $tmp;
          }
        }
      }

      $args[] = &$data;
      call_user_func_array('array_multisort', $args);
      return array_pop($args);
    }
}
