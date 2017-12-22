<?php

namespace App\Http\Controllers\Backend;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Response;

class ImageReadController extends Controller
{
    public function cover($filename)
    {
      $file = Storage::disk('cover')->get($filename);
      return new Response($file, 200);
    }
}
