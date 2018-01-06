@extends('layouts.frontend')

@section('header-text')
    <p>home</p>
    <h1>หน้าแรก</h1>
@endsection

@section('content')
<div class="container">
  <div class="row">
    <div class="col-md-12">
      <p style="font-size:30px;margin-top:10px;">รวบรวม <span style="color:green;">ข่าวด่วน</span></p>
    </div>
  </div>
</div>
<div class="container-fluid">
  <div class="row" style="
                background:linear-gradient(
                  rgba(0, 0, 0, 0.4),
                  rgba(139, 0, 0, 0.6)
                ),url('https://images.alphacoders.com/510/thumb-1920-510026.jpg');
                background-size:cover;
                background-position: 0 100%;
                background-repeat: no-repeat;">

    <div class="col-sm-10 col-sm-offset-1">
@php $i=0 @endphp
@foreach ($news as $new)
      <a href="{{ route('news.show', ['id' => $new->id]) }}">
        <div class="{{ $i==0?'col-sm-8 col-xs-8':'col-sm-4 col-xs-4' }} news">
          <h3 class="col-sm-8">{{ $new->headline }}</h3>
          <h3 class="col-xs-9">{{ str_limit($new->headline, 25) }}</h3>
          <img src="{!! $i % 2 == 1 ? asset('pic/black.png') : asset('pic/red.png') !!}">
    @if ( Storage::disk('cover')->has($new->path_cover) )
          <img class="img-responsive" src="{{ route('image', ['filename' => $new->path_cover]) }}">
    @else
          <img class="img-responsive" src="{{ asset('pic/file_error.png') }}">
    @endif
        </div>
      </a>
  {!! $i==2?'<div class="clearfix"></div>':'' !!}
@if($i==5) @break @endif
@php $i++ @endphp
@endforeach
    </div><!--/.col-sm-10-->
    <div class="clearfix"></div>
    <br>
  </div><!-- /.row-->
  <br>

@php $i=0 @endphp
@foreach ($news as $new)
@php $i++; @endphp
@if($i<7) @continue @endif
{!! $i%4==3?'<div class="row news-second"><div class="col-sm-10 col-sm-offset-1">':'' !!}
    <div class="col-sm-3 col-xs-6">
@if ( Storage::disk('cover')->has($new->path_cover) )
      <a href="{{ route('news.show', ['id' => $new->id]) }}"><img class="img-responsive" src="{{ route('image', ['filename' => $new->path_cover]) }}"></a>
@else
      <a href="{{ route('news.show', ['id' => $new->id]) }}"><img class="img-responsive" src="{{ asset('pic/file_error.png') }}"></a>
@endif
      <a href="{{ route('news.show', ['id' => $new->id]) }}">
        {{-- <h3>{{ $new->headline }}</h3> --}}
        <h3>{{ str_limit($new->headline, 30) }}</h3>
      </a>
      <span class="pull-left"><i class="fa fa-futbol-o" aria-hidden="true"></i> {{ $new->zone->name }}</span>
      <span class="pull-right"><i class="fa fa-clock-o" aria-hidden="true"></i> {{ $new->created_at->diffForHumans() }}</span>
    </div>
{!! $i%4==2?'</div></div>':'' !!}
@endforeach
<div class="col-sm-4 col-sm-offset-4">
  <br>
  <a href="{{ route('news') }}" type="button" class="btn btn-lg btn-default btn-block">ดูทั้งหมด</a>
</div>
<hr class="col-sm-10 col-sm-offset-1 hr-danger" />
</div><!-- /.container-fluid-->

<section class="section-white" style="background-color:#1a0000;">
  <div class="container">
    <br>
    <div class="row">
      <div class="col-sm-12">
        <span class="label">ไฮไลท์มาใหม่</span>
      </div>
      <div class="col-sm-8">
        <div id="carousel-example-generic" class="carousel slide" data-ride="carousel">

          <ol class="carousel-indicators">
            <li data-target="#carousel-example-generic" data-slide-to="0" class="active"></li>
            <li data-target="#carousel-example-generic" data-slide-to="1"></li>
            <li data-target="#carousel-example-generic" data-slide-to="2"></li>
            <li data-target="#carousel-example-generic" data-slide-to="3"></li>
          </ol>

          <div class="carousel-inner">
@php
  $i=0;
@endphp
@forelse ($clip as $key => $value)
            <div class="item{{ $i==0?' active':'' }}">
              <a href="{{ route('highlight.show', ['id' => $value->id]) }}">
        @if ( Storage::disk('cover')->has($value->path_cover) )
                <img class="img-responsive" src="{{ route('image', ['filename' => $value->path_cover]) }}">

        @else
                <img class="img-responsive" src="{{ asset('pic/file_error.png') }}">
        @endif
                <div class="play">
                  <i class="fa fa-3x fa-play-circle" aria-hidden="true"></i>
                </div>
              </a>
              <div class="carousel-caption">
                <h1 class="carousel-caption-header">{{ $value->headline }}</h1>
              </div>
            </div>
@if ($i==3) @break @endif
@php $i++; @endphp
@empty

@endforelse
          </div>
          <a class="left carousel-control" href="#carousel-example-generic" data-slide="prev">
            <span class="fa fa-2x fa-chevron-left"></span>
          </a>
          <a class="right carousel-control" href="#carousel-example-generic" data-slide="next">
            <span class="fa fa-2x fa-chevron-right"></span>
          </a>
        </div>
      </div>
      <div class="col-sm-4" id="highlight-right">
        <div class="row">
@php
  $i=0;
@endphp
@forelse ($clip as $key => $value)
@php $i++; @endphp
@if ($i < 5) @continue @endif
          <div class="col-sm-12 col-xs-6">
            <a class="cover" href="{{ route('highlight.show', ['id' => $value->id]) }}">
@if ( Storage::disk('cover')->has($value->path_cover) )
              <img src="{{ route('image', ['filename' => $value->path_cover]) }}">

@else
              <img src="{{ asset('pic/file_error.png') }}">
@endif
              <div class="play">
                <i class="fa fa-play-circle" aria-hidden="true"></i>
              </div>
              <div class="caption">
                <h3>{{ $value->headline }}</h3>
              </div>
            </a>
          </div>
@if ($i==6) @break @endif
@empty
@endforelse
        </div>
      </div>
    </div>
    <br>
  </div>
</section>
<div class="container" id="highlight-second">
  <br>
@php $i=0 @endphp
@foreach ($clip as $value)
@php $i++ @endphp
@if ($i<7) @continue @endif
{!! $i%4==3?'<div class="row">':''!!}
  <div class="col-sm-3 col-xs-6">
    <div class="thumbnail">
@if ( Storage::disk('cover')->has($value->path_cover) )
      <a href="{{ route('highlight.show', ['id' => $value->id]) }}">
        <img class="media-object" src="{{ route('image', ['filename' => $value->path_cover]) }}">
        <div class="play">
          <i class="fa fa-2x fa-play-circle" aria-hidden="true"></i>
        </div>
      </a>
@else
      <a href="{{ route('highlight.show', ['id' => $value->id]) }}">
        <img class="media-object" src="{{ asset('pic/file_error.png') }}">
      </a>
@endif
      <div class="caption">
        <h3>{{ $value->headline }}</h3>
        <span class="pull-left"><i class="fa fa-futbol-o" aria-hidden="true"></i> {{ $value->zone->name }}</span>
        <span class="pull-right"><i class="fa fa-clock-o" aria-hidden="true"></i> {{ $value->created_at->diffForHumans() }}</span>
        <div class="clearfix"></div>
        <p><a href="{{ route('highlight.show', ['id' => $value->id]) }}" class="btn btn-danger btn-block" role="button">ชมไฮไลท์</a></p>
      </div>
    </div>
  </div>
{!! $i%4==2?'</div>':'' !!}
@endforeach
  <div class="col-sm-6 col-sm-offset-3">
    <a href="{{ route('highlight') }}" type="button" class="btn btn-lg btn-default btn-block">ดูทั้งหมด</a>
  </div>
  <div class="clearfix"></div>
  <hr class="hr-danger" />
</div>
<br><br><br><br><br><br><br><br><br>
<!-- Modal -->
{{-- <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
      </div>
      <div class="modal-body">
        <ul class="nav nav-pills" role="tablist"></ul>
              <!-- Tab panes -->
        <div class="tab-content"></div>
      </div>
    </div>
  </div>
</div> --}}
@endsection
