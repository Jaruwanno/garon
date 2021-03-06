@extends('layouts.frontend')

@section('header-text')
  <p>news</p>
  <h1>ข่าวสาร</h1>
@endsection

@section('content')
<br>
<div class="container">
  <div class="row">
    <div class="col-md-3">
      <button type="button" class="detail button-toggle btn-block btn btn-danger" data-toggle="collapse" data-target=".sidebar-collapse">
        <span class="sr-only">Toggle navigation</span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <h3>เมนู</h3>
      </button>
      <div class="sidebar-collapse">
        <h1>รายชื่อลีก</h1>
        <div class="leagues-list">
          <ul class="nav">
            <li class="
            @isset($active)
              {{ ($active == 'all') ? 'active' : '' }}
            @endisset>">
              <a href="{{ route('news') }}"><i class="fa fa-soccer-ball-o fa-lg"></i>
                ทั้งหมด
              </a>
            </li>

      @forelse ($zone as $z)
            <li class="{{  $z->id == $active ? 'active' : ''  }}">
              <a class="zone">{{ $z->name }}</a>
              <form action="{{ route('news.find') }}" method="POST" style="display:none;">
                {!! csrf_field() !!}
                <input type="text" name="zone" value="{{ $z->id }}">
              </form>
            </li>
      @empty
            <li>ยังไม่มีข้อมูล</li>
      @endforelse

          </ul>
        </div><!-- /.leagues-list-->
        <br>
        <div class="search-leagues">
          <div class="form-group">
            <label for="news-text"><h1>ค้นหาข่าว</h1></label>
            <form action="{{ route('news.find') }}" method="POST">
              {!! csrf_field() !!}
              <input type="text" class="form-control" placeholder="ค้นหาข่าว" name="text">
              <button type="submit" class="btn-circle btn-default" type="button">
                <i class="fa fa-search"></i>
              </button>
            </form>
          </div>
        </div><!-- /.search-leagues-->
        <br>
        <div class="date">
          <h1>ปฏทิน</h1>
          <div id='datetimepicker1'></div>
        </div><br>
      </div><!-- /collapse-->
    </div><!-- /.col-md-3-->

    <div class="col-md-9">
      <div class="row">
@forelse ($news as $n)
        <div class='col-md-12'>
          <div class="well well-sm">
            <div class="row">
              <div class="col-sm-4 text-center">
@if ( Storage::disk('cover')->has($n->path_cover) )
                <a href="{{ route('news.show', ['id'=>$n->id]) }}">
                  <img class="img-rounded img-responsive" src="{{ route('image', ['filename' => $n->path_cover]) }}">
                </a>
@else
                <a href="{{ route('news.show', ['id'=>$n->id]) }}">
                  <img class="img-rounded img-responsive" src="{{ asset( 'pic/file_error.png' ) }}">
                </a>
@endif
              </div>
              {{-- image --}}
              <div class="col-sm-8 section-box">
                <h3>
                  <a href="{{ route('news.show', ['id'=>$n->id]) }}">{{ $n->headline }}</a>
                </h3>
                <p>
                  {{ User::short_text($n->des, 160) }}<a href="{{ route('news.show', ['id'=>$n->id]) }}"> &nbspอ่านเพิ่มเติม...</a>
                </p>
                <hr />
                <div class="row rating-desc">
                  <div class="col-md-12">
                    <div id="fb-root"></div>
                    <script>
                      (function(d, s, id) {
                        var js, fjs = d.getElementsByTagName(s)[0];
                        if (d.getElementById(id)) return;
                        js = d.createElement(s); js.id = id;
                        js.src = 'https://connect.facebook.net/th_TH/sdk.js#xfbml=1&version=v2.11&appId=2052941631609007';
                        fjs.parentNode.insertBefore(js, fjs);
                      }(document, 'script', 'facebook-jssdk'));
                    </script>
                    <span><i class="fa fa-soccer-ball-o" aria-hidden="true"></i>&nbsp&nbsp{{ $n->zone->name }}</span>&nbsp&nbsp|
                    <span><i class="fa fa-clock-o" aria-hidden="true"></i>&nbsp&nbsp{{ $n->created_at->diffForHumans() }}</span>&nbsp&nbsp|
                    <span><i class="fa fa-eye" aria-hidden="true"></i>&nbsp&nbsp{{ $n->visit_count }}</span>

                    <span>
                      <div class="fb-like"
                           data-href="https://www.balllife24.com/news/{{$n->id}}"
                           data-layout="button_count"
                           data-action="like"
                           data-size="small"
                           data-show-faces="true"
                           data-share="false">
                      </div>
                    </span>
                  </div>
                </div>
              </div>
            </div>
            {{-- .row --}}
          </div>
          {{-- .well --}}
        </div>
        {{-- .col-md-12 --}}
@empty

@endforelse
      </div>
      {{-- .row --}}
      <div class="text-center">
        {{ $news->links() }}
      </div>
    </div>
  </div><!-- /.row-->
</div><!-- /.container-->

@endsection
