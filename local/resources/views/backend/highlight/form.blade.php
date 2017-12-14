@extends('layouts.backend')

@include('inc.navback')

@section('content')
<div id="page-wrapper">
  <div class="row">
    <div class="col-lg-12">
      <h3 class="page-header">
        เพิ่มไฮไลท์
      </h3>
    </div>
  </div>

  <div class="row">
    <div class="col-md-12">
      <form id="form" class="form-horizontal"
      action="{{ route("admin.highlight.store") }}"
      method="post"
      enctype="multipart/form-data">
      {{ csrf_field() }}

        <div class="form-group">
          <label class="col-sm-2 control-label">ข้อความ:</label>
          <div class="col-sm-8">
            <input id="head" type="text" class="form-control" name="head"
            autofocus placeholder="ข้อความ">
          </div>
        </div>
        <div class="form-group">
          <label class="col-sm-2 control-label">ภาพหน้าปก:</label>
            <div class="col-sm-8">
                <input type="file" class="form-control" name="cover"/>
                <span class="help-block">*** ขนาดภาพ 640x360 ***</span>
                <div id="coverPreview" class="cover"></div>
            </div>
        </div>

        <div class="form-group">
          <label class="col-sm-2 control-label">วันที่ไฮไลท์: </label>
          <div class="col-sm-8">
            <select class="form-control" name="zone_id">
              <option value="">เลือก</option>

  @foreach ($dates as $date)
              <option value="{{ $zone->id }}">{{ $zone->name }}</option>
  @endforeach

            </select>
          </div>
        </div>

        <div class="form-group">
          <label class="col-sm-2 control-label">ไฮไลท์ลีก: </label>
          <div class="col-sm-8">
            <select class="form-control" name="zone_id">
              <option value="">เลือก</option>

  @foreach ($zones as $zone)
              <option value="{{ $zone->id }}">{{ $zone->name }}</option>
  @endforeach

            </select>
          </div>
        </div>

        <div class="form-group">
          <label class="col-sm-2 control-label">รายละเอียด: </label>
          <div class="col-sm-8">
            <textarea id="des" name="des"></textarea>
          </div>
        </div>
        <div class="col-sm-8 col-sm-offset-2">
          <div class="progress" style="display:none;">
            <div class="progress-bar progress-bar-success progress-bar-striped"
                 role="progressbar" aria-valuenow="0"
                 aria-valuemin="0" aria-valuemax="100"
                 style="width: 0%;">

            </div>
          </div>
        </div>
        <div class="form-group">
          <div class="col-sm-8 col-sm-offset-2">
            <button type="submit" class="btn btn-primary btn-block">
              ตกลง
            </button>
          </div>
        </div>
      </form>

      {{-- <form class="form-horizontal" method="POST" action="{{ route('admin.highlight.store') }}"
      enctype="multipart/form-data">
      {{ csrf_field() }}

        <div class="form-group{{ $errors->has('head') ? ' has-error' : '' }}">
          <div class="col-md-10">
            <input id="head" type="text" class="form-control" name="head"
            value="{{ old('head') }}" required autofocus placeholder="พาดหัว">
          @if ($errors->has('head'))
              <span class="help-block">
                  <strong>{{ $errors->first('head') }}</strong>
              </span>
          @endif
          </div>
        </div>

        <span class="text-danger">*** ขนาดภาพ 640x360 ***</span>
        <div class="input-group image-preview col-md-10 {{ $errors->has('cover') ? ' has-error' : '' }}">
          <input type="text" class="form-control filename" disabled="disabled" placeholder="เพิ่มรูป cover"> <!-- don't give a name === doesn't send on POST/GET -->
          <span class="input-group-btn">
              <!-- image-preview-clear button -->
            <button type="button" class="btn btn-default clear" style="display:none;">
              <span class=""></span> Clear
            </button>
            <!-- image-preview-input -->
            <div class="btn btn-default input">
              <span class="fa fa-folder-open-o fa-lg"></span>
              <span class="browse">เลือก</span>
              <input type="file"  name="cover"/> <!-- rename it -->
            </div>
          </span>
        </div><!-- /input-group image-preview [TO HERE]-->
        @if ($errors->has('clip'))
        <span class="help-block" style="color:#B22222;">
            <strong>{{ $errors->first('cover') }}</strong>
        </span>
        @endif
        <br>

        <span class="text-danger">*** ขนาดไฟล์ไม่เกิน {{ $__upload_int }} MB ***</span>
        <div class="input-group col-md-10{{ $errors->has('clip') ? ' has-error' : '' }}">
          <input type="text" class="form-control filename" disabled="disabled" placeholder="เพิ่มคลิปวิดีโอ"> <!-- don't give a name === doesn't send on POST/GET -->
          <span class="input-group-btn">
              <!-- image-preview-clear button -->
            <button type="button" class="btn btn-default clear" style="display:none;">
              <span class=""></span> Clear
            </button>
            <!-- image-preview-input -->
            <div class="btn btn-default input">
              <span class="fa fa-folder-open-o fa-lg"></span>
              <span class="browse">เลือก</span>
              <input type="file"  name="clip"/> <!-- rename it -->
            </div>
          </span>
        </div>
        @if ($errors->has('clip'))
        <span class="help-block" style="color:#B22222;">
            <strong>{{ $errors->first('clip') }}</strong>
        </span>
        @endif
        <br>
        <div class="form-group{{ $errors->has('zone_id') ? ' has-error' : '' }}">
          <div class="col-md-10">
            <select class="form-control" name="zone_id">
              <option value="">ไฮไลท์ลีก</option>

  @foreach ($zones as $zone)
              <option value="{{ $zone->id }}"{!! old('zone_id') == $zone->id ? ' selected' : '' !!}>{{ $zone->name }}</option>
  @endforeach

            </select>
            @if ($errors->has('zone_id'))
                <span class="help-block" style="color:#B22222;">
                    <strong>{{ $errors->first('zone_id') }}</strong>
                </span>
            @endif
          </div>
        </div>


        <br>

        <div class="form-group {{ $errors->has('des') ? ' has-error' : '' }}">
          <div class="col-md-10">
            <textarea id="des" name="des">{{ old('des') }}</textarea>
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
      </form> --}}

    </div>
  </div>
</div>
@endsection
<script type="text/javascript">
    var home = "{{ route('admin.highlight.home')}}";
</script>
