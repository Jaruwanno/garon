<?php

namespace App\Http\Controllers\Backend;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Carbon\Carbon;
use App\LiveScore;

class LiveScoreController extends Controller
{
  public function index(){
    $aStyle = array(
      'css/datepicker/datepicker.css',
      'css/backend/livescore/livescore.css'
    );
    $aScript = array(
      'js/datepicker/moment.js',
      'js/datepicker/datepicker.js',
      'js/backend/livescore/livescore.js'
    );

    $d = Carbon::today()->toDateString();

    return view('backend.livescore.today', [
      'css' => $aStyle,
      'js' => $aScript
    ]);
  }

  public function livescore($date){
    $data = [];
    $live = [];
    $liveScore = LiveScore::where('match_date', $date)->get();
    foreach ($liveScore as $k => $v) {
      $live[$v->match_id] = [
        "tded" => $v->tded,
        "link" => $v->link
      ];
    }
    $data['live'] = $live;

    $APIkey='a52a7c9ca7b9790d5f418448d64c717556d346f6458c9bc789312c9a268981ff';
    $curl_options = array(
    CURLOPT_URL => "https://apifootball.com/api/?action=get_events&from=$date&to=$date&APIkey=$APIkey",
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_HEADER => false
    );
    $curl = curl_init();
    curl_setopt_array( $curl, $curl_options );
    $result = curl_exec( $curl );

    $result = (array) json_decode($result);

    foreach ($result as $r) {
      $leagues[$r->league_id] = [
                  'league_name' => $r->league_name,
                  'country_name' => $r->country_name
                ];
    }
    $data['data'] = $result;
    $data['leagues'] = $leagues;

    return $data;
  }

  public function store(Request $request)
  {
    date_default_timezone_set('UTC');
    LiveScore::where('match_date', date('Y-m-d'))->delete();

    if( count($request->data) != 0 ){
      foreach ($request->data as $k => $v) {
        $live = new LiveScore;
        $live->match_id = $v['match_id'];
        $live->match_date = $v['match_date'];
        $live->tded = $v['tded'];
        $live->link = $v['link'];
        $live->save();
      }
    }
  }
}
