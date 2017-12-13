@extends('layouts.backend')

@include( 'inc.navback' )

@section('content')
<div id="page-wrapper">

  <div class="row">
      <div class="col-lg-12">
          <h3 class="page-header">
@if ( isset($news) )
            แก้ไขข่าว
@else
            เพิ่มข่าว
@endif
          </h3>
      </div><!-- /.col-lg-12 -->
  </div><!-- /.row-->

  <div class="row">
    <div class="col-md-12">
@if ( isset($news) )
      <form class="form-horizontal" method="POST" action="{{ route('admin.news.update', ['id' => $news->id]) }}"
      enctype="multipart/form-data">
      <input type="hidden" name="_method" value="PUT">
      <input type="hidden" name="_token" value="{{ csrf_token() }}">
@else
      <form class="form-horizontal" method="POST" action="{{ route('admin.news.store') }}"
      enctype="multipart/form-data">
      {{ csrf_field() }}
@endif


        <div class="form-group{{ $errors->has('head') ? ' has-error' : '' }}">
          <div class="col-md-10">
            <input id="head" type="text" class="form-control" name="head"
            value="{{ ( isset($news) ? $news->headline : old('head') ) }}" required autofocus placeholder="พาดหัวข่าว">
            @if ($errors->has('head'))
                <span class="help-block">
                    <strong>{{ $errors->first('head') }}</strong>
                </span>
            @endif
          </div>
        </div>
        <span class="text-danger">*** ขนาดภาพ 640x360 ***</span>
        <div class="input-group image-preview col-md-10 {{ $errors->has('input-file-preview') ? ' has-error' : '' }}">
            <input type="text" class="form-control image-preview-filename" disabled="disabled" placeholder="เพิ่มรูป cover"> <!-- don't give a name === doesn't send on POST/GET -->
            <span class="input-group-btn">
                <!-- image-preview-clear button -->
              <button type="button" class="btn btn-default image-preview-clear" style="display:none;">
                <span class=""></span> Clear
              </button>
              <!-- image-preview-input -->
              <div class="btn btn-default image-preview-input">
                <span class="fa fa-folder-open-o fa-lg"></span>
                <span class="image-preview-input-title">เลือก</span>
                <input type="file" accept="image/png, image/jpeg" name="input-file-preview"/> <!-- rename it -->
              </div>
            </span>
        </div><!-- /input-group image-preview [TO HERE]-->
        @if ($errors->has('input-file-preview'))
            <span class="help-block" style="color:#B22222;">
                <strong>{{ $errors->first('input-file-preview') }}</strong>
            </span>
        @endif
        <br>

        <div class="form-group{{ $errors->has('zone_id') ? ' has-error' : '' }}">
          <div class="col-md-10">
            <select class="form-control" name="zone_id" required> 
              <option value="">เลือกโซนข่าว</option>

  @foreach ($zones as $zone)
              <option value="{{ $zone->id }}"{!! ( isset($news) ? ($news->zone_id == $zone->id ? 'selected' : '') : '' ) !!}>{{ $zone->name }}</option>
  @endforeach

            </select>
            @if ($errors->has('zone_id'))
                <span class="help-block" style="color:#B22222;">
                    <strong>{{ $errors->first('zone_id') }}</strong>
                </span>
            @endif
          </div>
        </div>

        <div class="form-group {{ $errors->has('des') ? ' has-error' : '' }}">
          <div class="col-md-10">
            <textarea id="des" name="des">{{ isset($news) ? $news->des : old('des') }}</textarea>
          </div>
        </div>
        @if ($errors->has('des'))
            <span class="help-block" style="color:#B22222;">
                <strong>{{ $errors->first('des') }}</strong>
            </span>
        @endif

        <div class="form-group">
            <div class="col-md-10">
                <button type="submit" class="btn btn-primary btn-block">
                    ตกลง
                </button>
            </div>
        </div>

      </form>
    </div><!-- col-md-12-->
  </div>

</div>

@endsection
