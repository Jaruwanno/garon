@extends('layouts.frontend')

@section('header-text')
  <p>table</p>
  <h1>ผลบอล</h1>
@endsection

@section('content')
  <div id="wrapper"> 
    <div id="sidebar-wrapper">
      <nav id="spy">
        <ul class="sidebar-nav nav">
          <li class="active">
            <a country-id="all" href="" class="country"><i class="fa fa-futbol-o" aria-hidden="true"></i>&nbsp&nbspทั้งหมด</a>
          </li>
@foreach ($country as $k => $v)
          <li>
            <a country-id="{{ $v['id'] }}"
                href="" class="country"><img width="30px"
                src="{{ User::checkFlags($v['name']) ? asset('flags/'.$v['name'].'.png') :
                        'https://apifootball.com/widget/img/flags/'.$v['name'].'.png' }}">
               &nbsp&nbsp{{ $v['name'] }}
            </a>
          </li>
@endforeach
        </ul>
      </nav>
    </div>
    <div class="container-fluid">
      <div class="row">
        <div class="col-md-12">

@php
// echo ini_get("upload_max_filesize")."  ".ini_get('post_max_size') ;
$date = new DateTime('now');
$date->modify('-1 day');
$td = User::thai_date($date->format('Y-m-d'));
@endphp
          <h2 style="margin:20px 0 10px 0;font-size:5vmin;">
            <button id="menu-toggle" type="button" class="btn btn-default btn-lg btn3d"><span class="fa fa-power-off"></span></button>
            ผลบอล วัน{{$td['day']}}ที่ {{$td['date']}} {{$td['month']}} พ.ศ. {{$td['year']}}
          </h2>
          <img style="display:block; margin:30px auto 0; width:15%;"
          id="loader" src="{{ asset('gif/loader.gif') }}" alt="">
          <div class="table-responsive">
            <table id="table" class="table table-bordred">

            </table>
          </div>
          <br>
        </div>
        {{-- .col --}}
      </div>
      {{-- /.row --}}
    </div>
    {{-- /.container --}}
  </div>

@endsection
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
