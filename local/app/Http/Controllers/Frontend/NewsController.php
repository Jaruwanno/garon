<?php

namespace App\Http\Controllers\Frontend;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Response;
use App\Zone;
use App\Post;
use App\Visitor;

class NewsController extends Controller
{
    public function index()
    {
      $zone = Zone::orderBy('length')->get();

      $news = Post::withCount(['visit' => function($query){
        $query->where('type', '=', 'news');
      }])->where('type', '=', 'news')
         ->orderBy('created_at', 'desc')
         ->paginate(6);
      $aCss = array(
        'css/frontend/datepicker/datepicker.css',
        'css/frontend/news/style.css'
      );
      $aJs = array(
        'js/frontend/datepicker/moment.js',
        'js/frontend/datepicker/datepicker.js',
        'js/frontend/news/home_script.js'
      );
      $active = 'all';
      return view('frontend.news.home',[
        'zone' => $zone,
        'news' => $news,
        'css' => $aCss,
        'js' => $aJs,
        'active' => $active
      ]);
    }

    public function find(Request $request)
    {
      $zone = Zone::orderBy('length')->get();
      $news = Post::where('type', '=', 'news')
                    ->orderBy('created_at', 'desc')
                    ->paginate(6);

      $active = 'all';

      if( isset($request->zone) ){
        $news = Post::where('type', '=', 'news')
                      ->where('zone_id', '=', $request->zone)
                      ->orderBy('created_at', 'desc')->paginate(6);
        $active = $request->zone;

      }else if( isset($request->text) ){
        $news = Post::where('type', '=', 'news')
                    ->where('headline', 'like', '%'.$request->text.'%')
                    ->orderBy('created_at', 'desc')->paginate(6);
        $active = 'all';
      }

      $aCss = array(
        'css/frontend/datepicker/datepicker.css',
        'css/frontend/news/style.css'
      );
      $aJs = array(
        'js/frontend/datepicker/moment.js',
        'js/frontend/datepicker/datepicker.js',
        'js/frontend/news/js.js'
      );

      return view('frontend.news.home',[
        'zone' => $zone,
        'news' => $news,
        'css' => $aCss,
        'js' => $aJs,
        'active' => $active
      ]);

    }

    public function show($id){
      $news = Post::findOrFail($id);

      $hot = Post::withCount(['visit' => function($query){
        $query->where('type', '=', 'news');
      }])->orderBy('visit_count', 'desc')->limit(4)->get();

      $aCss = array(
        'css/frontend/news/style.css'
      );
      $aJs = array(
        'js/frontend/news/new_show.js'
      );

      return view('frontend.news.show',[
        'news' => $news,
        'hot' => $hot,
        'css' => $aCss,
        'js' => $aJs
      ]);
    }

    public function visitor(Request $request, $id)
    {
      Visitor::updateOrCreate([
        'id' => $id,
        'ip' => $request->ip,
        'type' => 'news'
      ]);

      $count = Visitor::where('id', '=', $id)
                      ->where('type', '=', 'news')
                      ->count();
      return $count;
    }


}
