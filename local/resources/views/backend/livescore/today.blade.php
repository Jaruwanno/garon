@extends('layouts.backend')

@include('inc.navback')

@section('content')
<div id="page-wrapper">
  <div class="row">
    <div class="col-lg-12">
      <h3 class="page-header">ตารางการแข่งขัน</h3>
    </div><!-- /.col-lg-12 -->
  </div>
    <div class="row">
      <div class="col-sm-12">
        <div style="background:#F6F6F6;" id='datepicker'></div>
      </div>
      <div class="col-sm-12">
        <br><br>
        <img style="display:block; margin:0 auto 0; width:15%;"
        id="loader" src="{{ asset('gif/loader.gif') }}" alt="">
        <button id="submit" type="button" class="btn btn-success btn-block">
          <i class="fa fa-floppy-o" aria-hidden="true"></i>&nbsp&nbspบันทึก
        </button>
        <br>
        <div class="table-responsive">
          <table id="livescore" class="table table-condensed"></table>
        </div>
      </div>
    </div>
</div>
@endsection
