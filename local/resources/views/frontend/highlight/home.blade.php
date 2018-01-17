@extends('layouts.frontend')

@section('header-text')
  <p>highlight</p>
  <h1>ไฮไลท์ฟุตบอล</h1>
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
        <h1>ไฮไลท์ลีก</h1> 
        <div class="leagues-list">
          <ul class="nav">
            <li class="
            @isset($active)
              {{ ($active == 'all') ? 'active' : '' }}
            @endisset>">
              <a href="{{ route('highlight') }}">
                ทั้งหมด
              </a>
            </li>

      @forelse ($zone as $z)
            <li class="{{ $z->id == $active ? 'active' : '' }}">
              <a class="zone">{{ $z->name }}</a>
              <form action="{{ route('highlight.find') }}" method="POST" style="display:none;">
                {!! csrf_field() !!}
                <input type="text" name="zone" value="{{ $z->id }}">
              </form>
            </li>
      @empty
            <li>ยังไม่มีข้อมูล</li>
      @endforelse
          </ul>
        </div><br>
          {{--  /.leagues-list--}}
        <div class="search-leages">
          <div class="form-group">
            <label for="news-text"><h1>ค้นหา</h1></label>
            <form action="{{ route('highlight.find') }}" method="POST">
              {!! csrf_field() !!}
              <input type="text" class="form-control" placeholder="ค้นหา" name="text"
              value="{{ isset($_POST['text']) ? $_POST['text'] : '' }}">
              <button type="submit" class="btn-circle btn-default" type="button">
                <i class="fa fa-search"></i>
              </button>
            </form>
          </div>
        </div><br>
        <!-- /.search-leagues-->
        <div class="date">
          <h1>ปฏทิน</h1>
          <div id='datetimepicker1'></div>
        </div><br>
        {{--  /.date--}}
      </div>
      {{--  /.sidebar-collapse--}}
    </div>
    {{--  /.col-md-3--}}
    <div class="col-md-9 highlight">
@php
  $n = 0;
@endphp

@forelse ($highlight as $h)
{!! $n%2==0?'<div class="row">':'' !!}

    <div class="col-md-6">
      <div class="panel panel-default panelD">
        <div class="panel-image">
          <a href="{{ route('highlight.show', ['id'=>$h->id]) }}">
            <img src="{{ Storage::disk('cover')->has($h->path_cover) ? route('image', ['filename' => $h->path_cover]) : asset( 'pic/file_error.png' ) }}" class="panel-image-preview" />
            <div class="play">
              <img src="https://sachinchoolur.github.io/lightGallery/static/img/play-button.png">
            </div>
          </a>
        </div>
        <div class="panel-body">
          <a href="{{ route('highlight.show', ['id'=>$h->id]) }}">
            <h3>{{ $h->headline }}</h3>
          </a>
        </div>
        <div class="panel-footer">
          <ul class="list-inline clearfix">
            <li class="col-xs-4 level-line-up">
              <span><i class="fa fa-soccer-ball-o" aria-hidden="true"></i>&nbsp&nbsp{{ $h->zone->name }}</span>
            </li>

            <li class="text-center col-xs-4">
              <span><i class="fa fa-eye" aria-hidden="true"></i>&nbsp&nbsp{{ $h->visit_count }}</span>
            </li>

            <li class="text-right col-xs-4">
              <span><i class="fa fa-clock-o" aria-hidden="true"></i>&nbsp&nbsp{{ $h->created_at->diffForHumans() }}</span>
            </li>
          </ul>
        </div>
      </div>
    </div>
{!! $n%2==1?'</div>':'' !!}
@php
  $n++;
@endphp
@empty
  <div class="alert alert-info"><h1 class="text-center">ไม่พบข้อมูล</h1></div>
@endforelse

<div class="col-md-12 text-center">
  {!! $highlight->links() !!}
</div>
    </div>
    {{--  /.highlight--}}

  </div>
  {{--  /.row--}}
</div>
{{--  /.container--}}
@endsection
