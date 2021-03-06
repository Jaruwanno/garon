<?php

namespace App\Http\Controllers\Frontend;

use League\Flysystem\Filesystem;
use Spatie\Dropbox\Client;
use Spatie\FlysystemDropbox\DropboxAdapter;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Zone;
use App\Post;
use App\Visitor;
use User;

class HighlightController extends Controller
{

  function __construct()
  {
    $this->client = new Client('pg5ZKjhH9PAAAAAAAAGgTkl_FJbzndvvwR60Eou4092ppEIP5GeKHg0SlRYOyV1R');
    $this->adapter = new DropboxAdapter($this->client);
    $this->filesystem = new Filesystem($this->adapter);

    $this->active = "";
    $this->zone = Zone::orderBy('length')->get();
    $this->highlight = array();
    $this->aStyle = array();
    $this->aScript = array();
  }

  public function assetHome()
  {
    $this->aStyle = array(
      'css/datepicker/datepicker.css',
      "css/frontend/highlight/home.style.css"
    );

    $this->aScript = array(
      'js/datepicker/moment.js',
      'js/datepicker/datepicker.js',
      'js/frontend/highlight/home_js.js'
    );
  }

  public function assetShow()
  {
    $this->aStyle = array(
      'videojs/video-js.min.css',
      'css/frontend/highlight/show.style.css'
    );

    $this->aScript = array(
      'videojs/video.min.js',
      'js/frontend/highlight/show_js.js'
    );
  }

  public function index(){
    $this->assetHome();

    $this->highlight = Post::withCount(['visit' => function($query){
      $query->where('type', '=', 'highlight');
    }])
    ->where('type', '=', 'highlight')
    ->orderBy('created_at', 'desc')
    ->paginate(6);

    $this->active = "all";

    return view('frontend.highlight.home', [
      'active' => $this->active,
      'highlight' => $this->highlight,
      'zone' => $this->zone,
      'css' => $this->aStyle,
      'js' => $this->aScript
    ]);
  }

  public function find(Request $request)
  {
    $this->assetHome();

    $this->active = 'all';
    if( isset($request->zone) ){
      $this->highlight = Post::withCount(['visit' => function($query){
                      $query->where('type', '=', 'highlight');
                    }])
                    ->where('zone_id', '=', $request->zone)
                    ->where('type', '=', 'highlight')
                    ->orderBy('visit_count', 'desc')->paginate(10);

      $this->active = $request->zone;

    }else if( isset($request->text) ){
      $this->highlight = Post::withCount(['visit' => function($query){
                      $query->where('type', '=', 'highlight');
                    }])
                    ->where('des', 'like', '%'.$request->text.'%')
                    ->where('type', '=', 'highlight')
                    ->orderBy('visit_count', 'desc')->paginate(10);

      $this->active = 'all';
    }else if( $request->text == "" ){
      return redirect()->route('highlight');
    }



    return view('frontend.highlight.home', [
      'active' => $this->active,
      'highlight' => $this->highlight,
      'zone' => $this->zone,
      'css' => $this->aStyle,
      'js' => $this->aScript
    ]);
  }

  public function show($id)
  {
    $this->assetShow();

    $this->highlight = Post::withCount(['visit' => function($query){
      $query->where('type', '=', 'highlight');
    }])
    ->where('type', '=', 'highlight')
    ->where('id', '=', $id)
    ->first();
    $link = $this->client->listSharedLinks();
    foreach($link as $k => $v){
      if( array_search( $this->highlight->path_video, $v ) == "id" ){
        $this->highlight->shared_links = User::shared_links($v['url']);
      }
    }

    $hot = Post::withCount(['visit' => function($query){
                $query->where('type', '=', 'highlight');
              }])
              ->where('type', '=', 'highlight')
              ->orderBy('visit_count', 'desc')->limit(4)->get();

    return view("frontend.highlight.show", [
      'highlight' => $this->highlight,
      'hot' => $hot,
      'css' => $this->aStyle,
      'js' => $this->aScript
    ]);
  }

  public function visitor(Request $request, $id)
  {
    Visitor::updateOrCreate([
      'id' => $id,
      'ip' => $request->ip,
      'type' => 'highlight'
    ]);

    $count = Visitor::where('id', '=', $id)
                    ->where('type', '=', 'highlight')
                    ->count();
    return $count;
  }

}
