<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Storage;
use App\Post;
use App\Visitor;

class CheckTimePost
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
      $del = Post::whereRaw("ADDDATE(created_at, 30) <= NOW()")->get();

      foreach ($del as $v) {
        Storage::disk('cover')->delete($v->path_cover);
        Storage::disk('clip')->delete($v->path_video);

        Visitor::where('id', '=', $v->id)->delete();

        Post::destroy($v->id);
      }

      return $next($request);
    }
}
