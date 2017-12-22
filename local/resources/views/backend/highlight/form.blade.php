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
          <label class="col-sm-2 control-label">ไฮไลท์: </label>
          <div class="col-sm-8">
            <select class="form-control selectpicker" name="clip" data-live-search="true">
              <option value="">เลือก</option>
@foreach ($clips as $clip)
              <option data-link="{{ $clip['link'] }}" value="{{ $clip['id'] }}">{{ $clip['name'] }}</option>
@endforeach
            </select>
            <div id="clipPreview" class="clip"></div>
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

    </div>
  </div>
</div>
@endsection
<script type="text/javascript">
    var home = "{{ route('admin.highlight.home')}}";
</script>
