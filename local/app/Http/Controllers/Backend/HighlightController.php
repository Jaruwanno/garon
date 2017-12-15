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

class HighlightController extends Controller
{
    function __construct()
    {
      $this->client = new Client('8FwQP7bmfGQAAAAAAAAFfXevjDhLxWKSiLPbw9R7S7EQAGhPtbLcb4-gh_QSREs9');

      $this->adapter = new DropboxAdapter($this->client);

      $this->filesystem = new Filesystem($this->adapter);
    }

    public function index()
    {
      $clip = Post::where('type', '=', 'highlight')
            ->orderBy('created_at', 'desc')
            ->get();

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

      $date = $this->client->listFolder('/');

      $zones = Zone::orderBy('length')->get();
//
      $aStyle = array(
        'formValidation/css/formValidation.min.css',
        'css/backend/clip/form.css'
      );

      $aScript = array(
        'js/jquery/jquery.form.min.js',
        'js/backend/tinymce/tinymce.min.js',
        'formValidation/js/validator.js',
        'formValidation/js/framework/bootstrap.js',
        'js/backend/clip/form.js'
      );

      return view('backend.highlight.form', [
        'zones' => $zones,
        'dates' => $date['entries'],
        'css' => $aStyle,
        'js' => $aScript
      ]);
    }

    public function name($name){
      $data = [];
      $list = $this->client->listFolder($name);

      if( count($list['entries']) != 0 ){
        foreach ($list['entries'] as $v) {
          $link = $this->client->rpcEndpointRequest('files/get_temporary_link', ['path' => $v['path_display']]);
          array_push($data, [
            'name' => $v['name'],
            'path_display' => $v['path_display'],
            'link' => $link['link']
          ]);
        }
      }

      return $data;
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

        $path = public_path() . '/cover';

        do{
          $filename = uniqid('cover_').".".$cover->getClientOriginalExtension();
        }while( file_exists($path.$filename) );

        $clip->path_cover = $filename;

        Storage::disk('cover')->put($filename, File::get($cover));
      }

      $clip->save();

      return $request;

    }

    public function destroy($id)
    {
      $clip = Post::findOrFail($id);
      Storage::disk('cover')->delete($clip->path_cover);
      Storage::disk('clip')->delete($clip->path_video);
      $clip->delete();

      Visitor::where('id', '=', $id)->delete();

      return redirect()->route('admin.highlight.home');
    }
}
