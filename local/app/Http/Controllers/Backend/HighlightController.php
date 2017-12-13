<?php

namespace App\Http\Controllers\backend;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;
use App\Post;
use App\Visitor;
use App\Zone;

class HighlightController extends Controller
{
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
      $zones = Zone::orderBy('length')->get();

      $aStyle = array(
        'formValidation/css/formValidation.min.css',
        'css/backend/clip/formstyle.css'
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

      //clip

      $video = $request->file('clip');

      $path = public_path() . '/clip';

      do{
        $filename = uniqid('clip_').".".$video->getClientOriginalExtension();
      }while( file_exists($path.$filename) );

      $clip->path_video = $filename;

      Storage::disk('clip')->put($filename, File::get($video));

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

      return "เรียบร้อย";

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