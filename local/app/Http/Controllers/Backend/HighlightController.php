<?php

namespace App\Http\Controllers\backend;

use League\Flysystem\Filesystem;
use Spatie\Dropbox\Client;
use Spatie\FlysystemDropbox\DropboxAdapter;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;
use App\Post;
use App\Visitor;
use App\Zone;
use User;

class HighlightController extends Controller
{
    function __construct()
    {
      $this->client = new Client('pg5ZKjhH9PAAAAAAAAGgTkl_FJbzndvvwR60Eou4092ppEIP5GeKHg0SlRYOyV1R');
      $this->adapter = new DropboxAdapter($this->client);
      $this->filesystem = new Filesystem($this->adapter);
    }

    public function index()
    {
      $data = Post::where('type', '=', 'highlight')
            ->orderBy('created_at', 'desc')
            ->paginate(10);
      $clip = $data;
      $link = $this->client->listSharedLinks();

      foreach ($link as $key => $value) {
        foreach($data as $k => $v){
          if(array_search($v->path_video, $value) == "id"){
            $shared_links = User::shared_links($value['url']);
            $clip[$k]->shared_links = $shared_links;
          }
        }
        // $clip[$key]->link = $link;
      }
      $aStyle = array(
        'lightgallery/css/lightgallery.min.css',
        'css/backend/clip/style_home.css'
      );

      $aScript = array(
        'lightgallery/js/lightgallery-all.min.js',
        'js/backend/clip/js.home.js'
      );

      return view('backend.highlight.home', [
        'clip' => $clip,
        'js' => $aScript,
        'css' => $aStyle
      ]);
    }

    public function form()
    {
      $clip = [];
      $data = $this->client->listSharedLinks();
      $clip = $data;
      foreach ($data as $key => $value) {
        $url = User::shared_links($value['url']);
        $clip[$key]['shared_links'] = $url;
      }
      // dd($clip);
      $zones = Zone::orderBy('length')->get();
//
      $aStyle = array(
        'bootstrapSelect/css/bootstrap-select.min.css',
        'formValidation/css/formValidation.min.css',
        'css/backend/clip/form.css'
      );

      $aScript = array(
        'bootstrapSelect/js/bootstrap-select.min.js',
        'js/jquery/jquery.form.min.js',
        'js/backend/tinymce/tinymce.min.js',
        'formValidation/js/validator.js',
        'formValidation/js/framework/bootstrap.js',
        'js/backend/clip/formscript.js'
      );

      return view('backend.highlight.form', [
        'zones' => $zones,
        'clips' => $clip,
        'css' => $aStyle,
        'js' => $aScript
      ]);
    }

    public function store(Request $request)
    {
      $clip = new Post();
      $clip->headline = $request->head;
      $clip->zone_id = $request->zone_id;
      $clip->des = $request->des;
      $clip->type = 'highlight';
      $clip->path_video = $request->clip;

      // cover
      if( $request->hasFile('cover') ){
        $cover = $request->file('cover');

        $path = storage_path('app/public/cover');

        do{
          $filename = uniqid('cover_').".".$cover->getClientOriginalExtension();
        }while( file_exists($path.$filename) );

        $clip->path_cover = $filename;

        Storage::disk('cover')->put($filename, File::get($cover));
      }
      $clip->save();
      return;
    }

    public function destroy($id)
    {
      $clip = Post::findOrFail($id);
      Storage::disk('cover')->delete($clip->path_cover);
      Visitor::where('id', $id)->delete();
      $clip->delete();


      return redirect()->route('admin.highlight.home');
    }
}
