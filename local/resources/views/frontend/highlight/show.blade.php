@extends('layouts.frontend')

@section('header-text')
  <p>highlight</p>
  <h1>ไฮไลท์ฟุตบอล</h1>
@endsection

@section('content')

<br>
<div class="container">
  <div class="row">
    <div class="col-md-8" id="main" data-id="{{ $highlight->id }}" data-ip="{{ User::user_ip() }}">
      <p>{{ $highlight->headline }}</p>
      <span><i class="fa fa-soccer-ball-o"></i> {{$highlight->zone->name}}</span>
      <span><i class="fa fa-clock-o" aria-hidden="true"></i> {{ $highlight->created_at->diffForHumans() }}</span>
      <span><i class="fa fa-eye"></i> <span id="count"></span></span>
      <span class="facebook-button">
        {{-- <div id="fb-root"></div> --}}
        <script>(function(d, s, id) {
          var js, fjs = d.getElementsByTagName(s)[0];
          if (d.getElementById(id)) return;
          js = d.createElement(s); js.id = id;
          js.src = "//connect.facebook.net/th_TH/sdk.js#xfbml=1&version=v2.10&appId=1758381751148365";
          fjs.parentNode.insertBefore(js, fjs);
        }(document, 'script', 'facebook-jssdk'));</script>
        <span>
          <div class="fb-like"
            data-href="https://developers.facebook.com/docs/plugins/"
            data-layout="button_count"
            data-action="like"
            data-size="small"
            data-show-faces="false"
            data-share="false">
          </div>
        </span>
        <span>
          <div class="fb-share-button"
            data-href="http://localhost/project/public/news/{{$highlight->id}}"
            data-layout="button"
            data-size="small"
            data-mobile-iframe="true">
            <a class="fb-xfbml-parse-ignore" target="_blank" href="https://www.facebook.com/sharer/sharer.php?u=http%3A%2F%2Flocalhost%2Fproject%2Fpublic%2Fnews%2F15&amp;src=sdkpreparse">แชร์</a>
          </div>
        </span>
      </span>
      <div class="clearfix"></div>
      {{-- <video src="{{ $highlight[0]->link }}"
         type='video/mp4'
         controls
         width="100%"
         poster="{{ Storage::disk('cover')->has($highlight[0]->path_cover) ? route('image', ['filename' => $highlight[0]->path_cover]) : '' }}">
      </video> --}}
      <video class="video-js vjs-16-9 vjs-big-play-centered" preload="auto"
          data-setup='{
              "poster": "{{ Storage::disk('cover')->has($highlight->path_cover) ? route('image', ['filename' => $highlight->path_cover]) : '' }}",
              "controls":true
          }'>
        {{-- <source src="{{ $highlight[0]->link }}" type="video/mp4"> --}}
        {{-- <source src="https://www.dropbox.com/s/zejmttrki2e4jd5/_E0_B9_80_E0_B8_8A_E0_B8_A5_E0_B8_8B_E0_B8_B5_vs_E.mov?raw=1" type="video/quicktime"> --}}
        <source src="{{ $highlight->shared_links }}" type="video/mp4">
      </video>
      <br><br>
      <div id="descriptions">
        @php echo $highlight->des; @endphp
      </div>
      {{-- <div class="fb-comments" data-href="http://www.rakball24.com/news/{{$highlight[0]->id}}" data-width="100%" data-numposts="5"></div> --}}
    </div>
    {{--  /col-md-8--}}
    <div class="col-md-4">
      <ul class="other">
        <li><img src="{{ asset('pic/correct.png') }}"><a href="{{ route('news') }}"> &nbsp ข่าวเด่น</a></li>
        <li><img src="{{ asset('pic/correct.png') }}"><a href="{{ route('highlight') }}"> &nbsp ไฮไลท์ฟุตบอล</a></li>
        <li><img src="{{ asset('pic/correct.png') }}"><a href=""> &nbsp ราคาบอล</a></li>
        <li><img src="{{ asset('pic/correct.png') }}"><a href=""> &nbsp ผลบอล</a></li>
      </ul><br>
      <div class="panel panel-default hot-highlight">
        <div class="panel-heading">ไฮไลท์ยอดนิยม</div>
        <div class="panel-body">
          <div class="row">
@foreach ($hot as $h)
    @php
    $pat = "/(<.*?>)|(&.*?;)/";
    $replace = "";
    $str = preg_replace($pat, $replace, $h->des);

    $des = mb_substr($str, 0, 80, 'utf-8');

    @endphp
          <div class="col-sm-5">
            <div class="row">
              <a href="{{ route('highlight.show', ['id' => $h->id]) }}">
@if ( Storage::disk('cover')->has($h->path_cover) )
                <img src="{{ route('image', ['filename' => $h->path_cover]) }}">
@else
                <img src="{{ asset( 'pic/file_error.png' ) }}">
@endif
              </a>
            </div>
          </div>
          {{--  /.col-sm-5--}}
          <div class="header-text col-sm-7">
              <a href="{{ route('highlight.show', ['id'=>$h->id]) }}"><h3>{{ $h->headline }}</h3></a>
          </div>
          <div class="clearfix"></div><br>
@endforeach
          </div>
          {{--  /.row--}}
        </div>
        {{--  /.panel-body--}}
      </div>
    </div>
  </div>
</div>
@endsection
