<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
  <meta charset="utf-8">
  <!-- CSRF Token -->
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <meta name="viewport" content="initial-scale=1, maximum-scale=1, user-scalable=no, width=device-width">
  <meta name="apple-mobile-web-app-capable" content="yes">
  <meta name="apple-mobile-web-app-status-bar-style" content="black-translucent">
  @if (Request::is('news/*'))
    <meta property="og:url"         content="http://www.balllife24.com/news/{{$news->id}}" />
    <meta property="og:type"        content="website" />
    <meta property="og:title"       content="{{ $news->headline }}" />
    <meta property="og:description" content="{{ $news->des }} "/>
    <meta property="og:image"       content="{{ ( Storage::disk('cover')->has($news->path_cover) ? asset('local/storage/app/public/cover/'.$news->path_cover):asset('pic/file_error.png')  ) }}" />
  @else
    <meta property="og:url"         content="http://www.balllife24.com" />
    <meta property="og:type"        content="website" />
    <meta property="og:title"       content="เอาใจคนรักบอล" />
    <meta property="og:description" content="เชิญร่วมสนุกกันได้ที่ balllife24 กันนะครับ" />
    <meta property="og:image"       content="{{ asset('pic/cover-balllife24.png') }}" />
  @endif


  {{-- <title>เอาใจคนรักบอล</title> --}}

  <!-- Styles -->
  <link rel="stylesheet" href="{{ asset( 'css/bootstrap/bootstrap.min.css' ) }}">
  <link rel="stylesheet" href="{{ asset( 'css/font awesome/css/font-awesome.min.css' ) }}">
  <link rel="stylesheet" href="{{ asset( 'css/frontend/main_style.css' ) }}">

  @if ( isset( $css ) )
    @foreach ($css as $style)
      <link rel="stylesheet" href="{{ asset($style) }}">
    @endforeach
  @endif
</head>
<body>
  @include('inc.navfront')

  @yield('content')

  <!-- Modal -->
  <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog modal-md" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
          <img src="{{ asset('pic/balllife-logo.png') }}">
        </div>
        <div class="modal-body">
          <fieldset>
            <legend>เข้าสู่ระบบ</legend>
            <br><br>
          </fieldset>
        </div>
      </div>
    </div>
  </div>

  <!-- Scripts -->
  <script src="{{ asset( 'js/jquery/jquery.min.js' ) }}"></script>
  <script src="{{ asset( 'js/bootstrap/bootstrap.min.js' ) }}"></script>
  <script src="{{ asset( 'js/frontend/main.script.js' ) }}"></script>
  <script>
        var match_path = '{{ url('/local/storage/app/public/bigmatch') }}';
  </script>
  @if ( isset( $js ) )
    @foreach ($js as $script)
      <script src="{{ asset( $script ) }}"></script>
    @endforeach
  @endif
</body>
</html>
