<?php

namespace App\Http\Middleware;

use League\Flysystem\Filesystem;
use Spatie\Dropbox\Client;
use Spatie\FlysystemDropbox\DropboxAdapter;

use Closure;
use Illuminate\Support\Facades\Storage;
use App\Post;
use App\Visitor;
use Carbon\Carbon;

class CheckTimePost
{
    function __construct(){
      $this->client = new Client('8FwQP7bmfGQAAAAAAAAFfXevjDhLxWKSiLPbw9R7S7EQAGhPtbLcb4-gh_QSREs9');
      $this->adapter = new DropboxAdapter($this->client);
      $this->filesystem = new Filesystem($this->adapter);
    }
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
      if($request->route()->getAction()['type'] == "highlight"){
        $list = $this->client->listFolder('/')['entries'];
        $d = Carbon::now()->timestamp;

        foreach ($list as $k => $v) {
          $str = explode("T", $v['client_modified']);
          $cli = Carbon::createFromFormat('Y-m-d', $str[0])->addDays(30)->timestamp;
          if($cli<=$d){
            $high = Post::where([
              'type' => 'highlight',
              'path_video' => $v['id']
            ])->get();

            if(count($high)){
              foreach ($high as $key => $value) {
                Post::destroy($value->id);
                Visitor::destroy($value->id);
                Storage::disk('cover')->delete($value->path_cover);
              }
            }
            $this->client->delete($v['path_display']);
          }
        }
      }elseif($request->route()->getAction()['type'] == "news"){
        $news = Post::where('type', 'news')
                    ->whereRaw("ADDDATE(created_at, 30) <= NOW()")
                    ->get();
        if(count($news)){
          foreach ($news as $v) {
            Storage::disk('cover')->delete($v->path_cover);
            Visitor::destroy($v->id);
            Post::destroy($v->id);
          }
        }
      }

      return $next($request);
    }
}
