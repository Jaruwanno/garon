<?php

namespace App\Http\Controllers\Backend;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use App\Http\Controllers\Controller;
use App\Match;

class MatchController extends Controller
{
    public function index()
    {
      $match = Match::orderBy('id', 'desc')->get();
      $aStyle = array(
        'css/backend/match/home_style.css'
      );
      $aScript = array(
        'js/backend/match/home_script.js'
      );
      return view('backend.match.home', [
        'match' => $match,
        'js' => $aScript,
        'css' => $aStyle
      ]);
    }

    public function create()
    {
      $aCss = array(
        'css/datepicker/datepicker.css',
        'css/backend/match/create_style.css'
      );

      $aScript = array(
        'js/datepicker/moment.js',
        'js/datepicker/datepicker.js',
        'js/datepicker/th.js',
        'js/backend/match/create_script.js'
      );
      return view('backend.match.form', [
        'css' => $aCss,
        'js' => $aScript
      ]);
    }

    public function store(Request $request)
    {
      $request->validate([
        'topic' => 'required',
        'date' => 'required',
        'home' => 'required',
        'away' => 'required',
        'home_png' => 'image|mimes:jpeg,png|required_without:รูปภาพ|dimensions:_width=300,height=300',
        'away_png' => 'image|mimes:jpeg,png|required_without:รูปภาพ|dimensions:_width=300,height=300'
      ]);

      $match = new Match();
      $match->topic = $request->topic;
      $match->kick_start = $request->date;
      $match->home = $request->home;
      $match->away = $request->away;
      $match->active = '0';

      $path = storage_path('app/public/bigmatch');

      if( $request->hasFile('home_png') ){
        $image = $request->file('home_png');
        do{
          $filename = uniqid('img_').".".$image->getClientOriginalExtension();
        }while( file_exists($path.$filename) );

        $match->home_png = $filename;

        Storage::disk('match')->put($filename, File::get($image));
      }

      if( $request->hasFile('away_png') ){
        $image = $request->file('away_png');
        do{
          $filename = uniqid('img_').".".$image->getClientOriginalExtension();
        }while( file_exists($path.$filename) );

        $match->away_png = $filename;

        Storage::disk('match')->put($filename, File::get($image));
      }

      $match->save();

      return redirect('admin/match');
    }

    public function active(Request $request, $id)
    {
      DB::update('update matches set active = "0"');

      $match = Match::find($id);
      $match->active = $request->active;
      $match->save();
    }

    public function delete($id)
    {
      $match = Match::find($id);
      Storage::disk('match')->delete([$match->home_png, $match->away_png]);
      $match->delete();
    }
}
