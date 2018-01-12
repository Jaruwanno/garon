@extends('layouts.backend')

@include( 'inc.navback' )

@section('content')
<div id="page-wrapper">
  <div class="row">
    <div class="col-lg-12">
      <h3 class="page-header">ไฮไลท์ทั้งหมด</h3>
    </div><!-- /.col-lg-12 -->
  </div><!-- /.row-->
  <div class="row">
@forelse ($clip as $c)
    <div class="col-md-10 col-md-offset-1">
      <div class="well">
        <div class="media">
          <ul class="lightgallery pull-left">
            <li class="video" data-html="{{ '#'.$c->id }}"
    data-poster="{{ Storage::disk('cover')->has($c->path_cover) ? route('image', ['filename' => $c->path_cover]) : asset('pic/file_error.png') }}">
              <a href="">
              @if ( Storage::disk('cover')->has($c->path_cover) )
                <img class="img-responsive" src="{{ route('image', ['filename' => $c->path_cover]) }}">
              @else
                <img class="img-responsive" src="{{ asset('pic/file_error.png') }}">
              @endif
                <div class="demo-gallery-poster">
                  <img src="https://sachinchoolur.github.io/lightGallery/static/img/play-button.png">
                </div>
              </a>
            </li>
          </ul>
          <div style="display:none;" id="{{ $c->id }}">
            <video class="lg-video-object lg-html5" controls preload="none">
              <source src="{{ $c->shared_links }}" type="video/mp4">
            </video>
          </div>

          <div class="media-body">
            <h4 class="media-heading pull-left">{{ $c->headline }}</h4>
            <span class="pull-right">
              <form action="{{ route('admin.highlight.destroy', [ 'id' => $c->id ]) }}" method="post" style="display:inline">
                {{ method_field('DELETE') }}
                {{ csrf_field() }}
                <button class="btn btn-danger btn-sm del" type="submit">ลบ</button>
              </form>
            </span>
            <div class="clearfix"></div><br>
@php

$pat = "/(<.*?>)|(&.*?;)/";
$replace = "";
$str = preg_replace($pat, $replace, $c->des);

$des = mb_substr($str, 0, 300, 'utf-8');

@endphp
          <p>{{ $des }}</p>
          <ul class="list-inline list-unstyled">
            <li><span><i class="fa fa-clock-o fa-lg"></i> {{ $c->created_at->diffForHumans() }}</span></li>
            <li>|</li>
            <span><i class="fa fa-comments fa-lg"></i> 2 comments</span>
            <li>|</li>
            <li>
              <span><i class="fa fa-facebook-square"></i></span>
              <span><i class="fa fa-twitter-square"></i></span>
              <span><i class="fa fa-google-plus-square"></i></span>
            </li>
          </ul>
          </div>
          {{--  /media-body--}}
        </div>
        {{--  /.media--}}

      </div>
      {{--  /.well--}}
    </div>
    {{--  /.col--}}
@empty
    <div class="col-md-12">
      <div class="alert alert-warning text-center" role="alert">
        <h3 class="alert-link">ยังไม่ได้เพิ่มข้อมูล</h3>
      </div>
    </div>
@endforelse
  </div><!-- /.row-->
</div><!-- /#page-wrapper -->

@endsection
