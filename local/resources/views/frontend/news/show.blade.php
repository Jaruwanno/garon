@extends('layouts.frontend')

@section('header-text')
  <p>news</p>
  <h1>ข่าวเด่น</h1>
@endsection

@section('content')
<br>
<div class="container">
  <div class="row">
    <div class="col-md-8 head-news-show" data-id="{{ $news->id }}" data-ip="{{ User::fake_ip() }}">
      <h1>{{ $news->headline }}</h1>
      <span><i class="fa fa-soccer-ball-o"></i> {{ $news->zone->name }}</span>&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp
      <span><i class="fa fa-clock-o fa-lg"></i> {{ $news->created_at->diffForHumans() }}</span>&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp
      <span><i class="fa fa-eye fa-lg"></i> <span id="count"></span></span>
      <span class="facebook-button">
        <div id="fb-root"></div>
        <script>(function(d, s, id) {
          var js, fjs = d.getElementsByTagName(s)[0];
          if (d.getElementById(id)) return;
          js = d.createElement(s); js.id = id;
          js.src = "//connect.facebook.net/th_TH/sdk.js#xfbml=1&version=v2.10&appId=1758381751148365";
          fjs.parentNode.insertBefore(js, fjs);
        }(document, 'script', 'facebook-jssdk'));</script>
        <div class="fb-like"
            data-href="https://developers.facebook.com/docs/plugins/"
            data-layout="button_count"
            data-action="like"
            data-size="small"
            data-show-faces="false"
            data-share="false">
        </div>
        <div class="fb-share-button"
            data-href="http://localhost/project/public/news/{{$news->id}}"
            data-layout="button_count"
            data-size="small"
            data-mobile-iframe="true">
          <a class="fb-xfbml-parse-ignore" target="_blank" href="https://www.facebook.com/sharer/sharer.php?u=http%3A%2F%2Flocalhost%2Fproject%2Fpublic%2Fnews%2F15&amp;src=sdkpreparse">แชร์</a>
        </div>
      </span>
@if ( Storage::disk('cover')->has($news->path_cover) )
      <img src="{{ asset( 'cover/'.$news->path_cover ) }}">
@else
      <img src="{{ asset( 'pic/file_error.png' ) }}">
@endif
      <br><br>
      @php echo $news->des; @endphp
      <div class="fb-comments" data-href="http://www.rakball24.com/news/{{$news->id}}" data-width="100%" data-numposts="5"></div>
    </div>

    <div class="col-md-4">
      <ul class="other">
        <li><img src="{{ asset('pic/correct.png') }}"><a href="{{ route('news') }}"> &nbsp ข่าวเด่น</a></li>
        <li><img src="{{ asset('pic/correct.png') }}"><a href=""> &nbsp เกมทายผล</a></li>
        <li><img src="{{ asset('pic/correct.png') }}"><a href=""> &nbsp ราคาบอล</a></li>
        <li><img src="{{ asset('pic/correct.png') }}"><a href=""> &nbsp ผลบอล</a></li>
      </ul>
      <br>

      <div class="panel panel-default hot-news">
        <div class="panel-heading">ข่าวเด่น</div>
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
              <a href="{{ route('news.show', ['id' => $h->id]) }}">
@if ( Storage::disk('cover')->has($h->path_cover) )
                <img src="{{ asset( 'cover/'.$h->path_cover ) }}">
@else
                <img src="{{ asset( 'pic/file_error.png' ) }}">
@endif
              </a>
            </div>
          </div>
          <div class="col-sm-7">
              <h1>{{ $h->headline }}</h1>
              <p>{{ $des }} <a href="{{ route('news.show', ['id' => $h->id]) }}">อ่านเพิ่มเติม...</a></p>

          </div>
          <div class="clearfix"></div><br>
@endforeach
        </div>
        </div>
      </div><!-- /.hot-news-->

    </div>
  </div>
</div>
@endsection