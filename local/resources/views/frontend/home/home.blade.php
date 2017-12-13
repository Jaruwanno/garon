@extends('layouts.frontend')

@section('header-text')
  <p>home</p>
  <h1>หน้าแรก</h1>
@endsection

@section('content')
<div class="container">
  <div class="row">
    <div class="col-md-12">
      <p style="font-size:25px;margin-top:10px;">รวบรวม <span style="color:green;">ข่าวเด่น</span></p>
    </div>
  </div>
</div>
<div class="container-fluid">
  <div class="row" style="background:#800000;">
@php
$i = 0;
@endphp
@forelse ($news as $new)
@php
$i++;
@endphp
    <a href="{{ route('news.show', ['id' => $new->id]) }}">
      <div class="col-md-3 col-xs-6 news">
        <h3 class="col-xs-7">{{ $new->headline }}</h3>
        <img src="{!! $i % 2 == 1 ? asset('pic/black.png') : asset('pic/red.png') !!}">
@if ( Storage::disk('cover')->has($new->path_cover) )
  <img class="img-responsive" src="{{ asset('cover/'.$new->path_cover) }}">
@else
  <img class="img-responsive" src="{{ asset('pic/file_error.png') }}">
@endif
      </div>
    </a>
@empty
    <a href="#">
      <div class="col-md-12 news">
        <h3 class="col-xs-7">"งูใหญ่"สะดุด! "อิการ์ดี้" ซัดโทษบุกเจ๊าโบโลญญ่า 1-1 หยุดสถิติชนะรวด</h3>
        <img src="{{ asset('pic/black.png') }}">
        <img src="http://static.siamsport.co.th/news/2017/09/21/news201709211231947.jpg" alt="">
      </div>
    </a>
@endforelse

  </div><!-- /.row-->
</div><!-- /.container-fluid-->

<section class="clip">
  <div class="container">
    <div class="row">
      <div class="col-md-4">
        <p id="text">ไฮไลท์ฟุตบอล <span style="color:	#7FFFD4;">ยอดนิยม</span></p>
      </div>
    </div>
  </div><!-- /.container-->
  <div class="container-fluid">
    <div class="row">
      <section class="regular slider">

        @forelse ($clip as $c)
          <a href="{{ route('highlight.show', ['id' => $c->id]) }}">
            @if ( Storage::disk('cover')->has($c->path_cover) )
              <img class="img-responsive" src="{{ asset('cover/'.$c->path_cover) }}">
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
  </div><!-- /.container-fluid-->
</section>{{--  /section--}}

<section class="board">
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
      {{-- .col --}}
    </div>
    {{-- .row --}}
  </div>
  {{-- .container --}}
</section>

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
