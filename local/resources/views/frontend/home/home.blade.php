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
@for ($i=0; $i < 6 ; $i++)
      <a href="{{ route('news.show', ['id' => $news[$i]->id]) }}">
        <div class="{{ $i==0?'col-sm-8 col-xs-8':'col-sm-4 col-xs-4' }} news">
          <h3 class="col-xs-7">{{ $news[$i]->headline }}</h3>
          <img src="{!! $i % 2 == 1 ? asset('pic/black.png') : asset('pic/red.png') !!}">
@if ( Storage::disk('cover')->has($news[$i]->path_cover) )
          <img class="img-responsive" src="{{ route('image', ['filename' => $news[$i]->path_cover]) }}">
@else
          <img class="img-responsive" src="{{ asset('pic/file_error.png') }}">
@endif
        </div>
      </a>
      {!! $i==2?'<div class="clearfix"></div>':'' !!}
@endfor
    </div><!--/.col-sm-10-->
    <div class="clearfix"></div>
    <br>
  </div><!-- /.row-->
  <br>
@for ($i=6; $i < 14; $i++)

  {!! $i%4==2?'<div class="row news-second"><div class="col-sm-10 col-sm-offset-1">':'' !!}
    <div class="col-sm-3 col-xs-6">
@if ( Storage::disk('cover')->has($news[$i]->path_cover) )
      <a href="{{ route('news.show', ['id' => $news[$i]->id]) }}"><img class="img-responsive" src="{{ route('image', ['filename' => $news[$i]->path_cover]) }}"></a>
@else
      <a href="{{ route('news.show', ['id' => $news[$i]->id]) }}"><img class="img-responsive" src="{{ asset('pic/file_error.png') }}"></a>
@endif
      <a href="{{ route('news.show', ['id' => $news[$i]->id]) }}"><h3>{{ $news[$i]->headline }}</h3></a>
      <span class="pull-left">{{ $news[$i]->zone->name }}</span>
      <span class="pull-right">{{ $news[$i]->created_at->diffForHumans() }}</span>
    </div>
  {!! $i%4==1?'</div></div>':'' !!}
@endfor
<div class="col-sm-4 col-sm-offset-4">
  <br>
  <a href="{{ route('news') }}" type="button" class="btn btn-lg btn-default btn-block">ดูทั้งหมด</a>
</div>
<hr class="col-sm-10 col-sm-offset-1 hr-danger" />
</div><!-- /.container-fluid-->

<section class="section-white">
  <div class="container-fluid" style="background-color:#1a0000;">
    <br>
    <div class="row">
      <div class="col-sm-7 col-sm-offset-1">
        <div id="carousel-example-generic" class="carousel slide" data-ride="carousel">
          <!-- Indicators -->
          <ol class="carousel-indicators">
            <li data-target="#carousel-example-generic" data-slide-to="0" class="active"></li>
            <li data-target="#carousel-example-generic" data-slide-to="1"></li>
            <li data-target="#carousel-example-generic" data-slide-to="2"></li>
            <li data-target="#carousel-example-generic" data-slide-to="3"></li>
          </ol>

          <!-- Wrapper for slides -->
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
                  <img src="https://sachinchoolur.github.io/lightGallery/static/img/play-button.png">
                </div>
              </a>
              <div class="carousel-caption">
                <h2>{{ $value->headline }}</h2>
              </div>
            </div>
@if ($i==3) @break @endif
@php $i++; @endphp
@empty

@endforelse
          </div>

          <!-- Controls -->
          <a class="left carousel-control" href="#carousel-example-generic" data-slide="prev">
            <span class="fa fa-2x fa-chevron-left"></span>
          </a>
          <a class="right carousel-control" href="#carousel-example-generic" data-slide="next">
            <span class="fa fa-2x fa-chevron-right"></span>
          </a>
        </div>
      </div>
      <div class="col-sm-3">
  			<ul class="media-list main-list">
@php
  $i=0;
@endphp
@forelse ($clip as $key => $value)
@php $i++; @endphp
@if ($i < 5) @continue @endif
          <li class="media">
            <a href="#">
@if ( Storage::disk('cover')->has($value->path_cover) )
              <img class="media-object" src="{{ route('image', ['filename' => $value->path_cover]) }}">

@else
              <img class="media-object" src="{{ asset('pic/file_error.png') }}">
@endif
              <div class="play">
                <img src="https://sachinchoolur.github.io/lightGallery/static/img/play-button.png">
              </div>
            </a>
            <div class="media-body">
              <a href="{{ route('highlight.show', ['id' => $value->id]) }}"><h3 class="media-heading">{{ $value->headline }}</h3></a>              {{-- <p class="by-author">By Jhon Doe</p> --}}
            </div>
          </li>
@empty
@endforelse

  			</ul>
      </div>
    </div>
    <br>
  </div>
</section>
{{-- <section class="clip">
  <div class="container">
    <div class="row">
      <div class="col-md-4">
        <p id="text">ไฮไลท์ฟุตบอล <span style="color:	#7FFFD4;">ยอดนิยม</span></p>
      </div>
    </div>
  </div>
  <div class="container-fluid">
    <div class="row">
      <section class="regular slider">

        @forelse ($clip as $c)
          <a href="{{ route('highlight.show', ['id' => $c->id]) }}">
            @if ( Storage::disk('cover')->has($c->path_cover) )
              <img class="img-responsive" src="{{ route('image', ['filename' => $c->path_cover]) }}">
            @else
              <img class="img-responsive" src="{{ asset('pic/file_error.png') }}">
            @endif
            <div class="play">
              <img src="https://sachinchoolur.github.io/lightGallery/static/img/play-button.png">
            </div>
          </a>
        @empty

        @endforelse
      </section>
    </div>
  </div>
</section> --}}

{{-- <section class="board">
  <div class="container">
    <div class="row">
      <div class="col-md-12">
        <h2 style="margin-top:20px;">ตารางบอลวันนี้</h2>
        <img style="display:block; margin:auto; width:15%;"
        id="loader" src="{{ asset('gif/loader.gif') }}" alt="">
        <div class="table-responsive">
          <table id="table" class="table table-condesed" border="0"></table>
        </div>
        <br>
        <div class="col-sm-6 col-sm-offset-3">
          <a href="{{ route('table') }}" type="button" class="btn btn-lg btn-default btn-block">ดูผลบอลย้อนหลัง</a>
        </div>
      </div>
    </div>
  </div>
</section> --}}

<br><br><br><br><br><br><br><br><br>

<!-- Modal -->
<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
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
      {{-- .modal-body --}}
    </div>
    {{-- .modal-content --}}
  </div>
  {{-- .modal-dialog --}}
</div>
@endsection
