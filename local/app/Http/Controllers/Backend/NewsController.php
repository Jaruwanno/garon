<?php

namespace App\Http\Controllers\backend;

use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Illuminate\Routing\Redirector;
use App\Http\Controllers\Controller;
use App\Zone;
use App\Post;
use App\Visitor;

class NewsController extends Controller
{
    public function index()
    {
      $news = Post::where('type','=','news')
                    ->orderBy('created_at', 'desc')
                    ->paginate(10);

      return view('backend.news.home', [
        'news' => $news
      ]);
    }

    public function create()
    {
      $zones = Zone::orderBy('length')->get();
      $aScript = array(
        'js/backend/tinymce/tinymce.min.js',
        'js/backend/news/js.js'
      );

      $aStyle = array(
        'css/backend/news/css.css'
      );

      return view('backend.news.form', [
        'zones' => $zones,
        'js' => $aScript,
        'css' => $aStyle
      ]);
    }

    public function edit($id)
    {
      if($id != ""){
        $news = Post::findOrFail($id);

        $zones = Zone::orderBy('length')->get();

        $aScript = array(
          'js/backend/tinymce/tinymce.min.js',
          'js/backend/news/js.js'
        );

        $aStyle = array(
          'css/backend/news/css.css'
        );

        return view('backend.news.form', [
          'news' => $news,
          'zones' => $zones,
          'js' => $aScript,
          'css' => $aStyle,
          'edit' => 'news'
        ]);
      }
    }

    public function store(Request $request){
      $request->validate([
        'head' => 'required',
        'zone_id' => 'required',
        'input-file-preview' => 'image|max:5000|dimensions:width=640,height=360',
        'des' => 'required'
      ]);

      $news = new Post();
      $news->zone_id = $request->zone_id;
      $news->headline = $request->head;
      $news->des = $request->des;
      $news->type = 'news';

      if( $request->hasFile('input-file-preview') ){
        $image = $request->file('input-file-preview');

        $path = storage_path('public/cover');

        do{
          $filename = uniqid('cover_').".".$image->getClientOriginalExtension();
        }while( file_exists($path.$filename) );

        $news->path_cover = $filename;

        Storage::disk('cover')->put($filename, File::get($image));
      }

      $news->save();

      return redirect()->route('admin.news.index');
    }

    public function update(Request $request, $id)
    {
      $request->validate([
        'head' => 'required',
        'zone_id' => 'required',
        'input-file-preview' => 'image|mimes:jpeg,png|max:5000|dimensions:_width=640,height=360',
        'des' => 'required',
        'type' => 'news'
      ]);

      $news = Post::findOrFail($id);
      $news->zone_id = $request->zone_id;
      $news->headline = $request->head;
      $news->des = $request->des;
      $news->type = 'news';

      if( $request->hasFile('input-file-preview') ){
        $image = $request->file('input-file-preview');

        $path = public_path() . '/cover';

        do{
          $filename = uniqid('img_').".".$image->getClientOriginalExtension();
        }while( file_exists($path.$filename) );

        $oldFileName = $news->path_cover;
        $news->path_cover = $filename;

        Storage::disk('cover')->delete($oldFileName);

        Storage::disk('cover')->put($filename, File::get($image));
      }

      $news->save();

      return redirect()->route('admin.news.index');
    }

    public function destroy($id)
    {
      $news = Post::findOrFail($id);
      Storage::disk('cover')->delete($news->path_cover);
      $news->delete();

      Visitor::destroy($id);

      return redirect()->route('admin.news.index');
    }
}
