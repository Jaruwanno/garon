@extends('layouts.backend')

@include( 'inc.navback' )

@section('content')
<div id="page-wrapper">
  <div class="row">
    <div class="col-lg-12">
      <h3 class="page-header">ข่าวทั้งหมด</h3>
    </div><!-- /.col-lg-12 -->
  </div><!-- /.row-->

  <div class="row">
@forelse ($news as $new)
    <div class="col-md-10 col-md-offset-1">
      <div class="well">
        <div class="media">
          <a class="pull-left" href="#">
@if (Storage::disk('cover')->has($new->path_cover))
            <img width="200" src="{{ asset( 'cover/'.$new->path_cover) }}">
@else
            <img width="200" src="{{ asset( 'pic/file_error.png' ) }}">
@endif
          </a>
          <div class="media-body">
            <h4 class="media-heading pull-left">{{ $new->headline }}</h4>&nbsp;<span>{{ '('.$new->zone->name.')' }}</span>
            <span class="pull-right">
              <a class="btn btn-warning btn-sm" href="{{ route('admin.news.edit', ['id' => $new->id]) }}">แก้ไข</a>
              <form action="{{ route('admin.news.destroy', [ 'id' => $new->id ]) }}" method="post" style="display:inline">
                {{ method_field('DELETE') }}
                {{ csrf_field() }}
                <button class="btn btn-danger btn-sm" type="submit">ลบ</button>
              </form>
            </span>
            <div class="clearfix"></div><br>
@php
//$pat = "/(<[a-zA-Z0-9]+)([ ]+[a-zA-Z0-9=\'\"\-\:\/\.\_;\S]+)*(>)|(<\/[a-z0-9]+>)/";

$pat = "/(<.*?>)|(&.*?;)/";
$replace = "";
$str = preg_replace($pat, $replace, $new->des);

$des = mb_substr($str, 0, 300, 'utf-8');

@endphp
            <p>{{ $des }}</p>
            <ul class="list-inline list-unstyled">
              <li><span><i class="fa fa-clock-o fa-lg"></i> {{ $new->created_at->diffForHumans() }}</span></li>
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
        </div>
      </div>
    </div>

@empty

@endforelse
  </div><!-- /.row-->
</div><!-- /#page-wrapper -->

@endsection
