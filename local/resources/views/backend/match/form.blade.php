@extends('layouts.backend')

@include( 'inc.navback' )

@section('content')
<div id="page-wrapper">
  <div class="row">
    <div class="col-lg-12">
      <h3 class="page-header">เพิ่มคู่บิ๊กแมตช์</h3>
    </div><!-- /.col-lg-12 -->
  </div><!-- /.row-->

  <div class="row">
    <div class="col-md-12">
      <form class="form-horizontal" method="post" action="{{ route('admin.match.store') }}"
      enctype="multipart/form-data">
        {{ csrf_field() }}
        <div class="form-group{{ $errors->has('topic') ? ' has-error' : '' }}">
          <label class="col-md-2">หัวเรื่อง</label>
          <div class="col-md-7">
            <input type="text" value="{{ old('topic') }}" name="topic"
            class="form-control" placeholder="กรอกหัวเรื่อง" required>
            @if ($errors->has('topic'))
                <span class="help-block">
                    <strong>{{ $errors->first('topic') }}</strong>
                </span>
            @endif
          </div>
        </div>

        <div class="form-group{{ $errors->has('date') ? ' has-error' : '' }}">
          <label class="col-md-2">เวลาเริ่มการแข่งขัน</label>
          <div class="col-md-7">
            <div class='input-group date' id='date'>
              <input type='text' value="{{ old('date') }}" name="date" class="form-control" placeholder="กรุณาเลือกวันที่" />
              <span class="input-group-addon">
                <span class="fa fa-calendar fa-lg"></span>
              </span>
            </div>
            @if ($errors->has('date'))
                <span class="help-block">
                  <strong>{{ $errors->first('date') }}</strong>
                </span>
            @endif
          </div>

        </div>

        <br>

        <div class="col-md-4">
          <div class="form-group{{ $errors->has('home') ? ' has-error' : '' }}">
            <label>เจ้าบ้าน</label>
            <input class="form-control" type="text" name="home" value="{{ old('home') }}"
            required placeholder="กรอกชื่อทีมเจ้าบ้าน">
            @if ($errors->has('home'))
                <span class="help-block">
                  <strong>{{ $errors->first('home') }}</strong>
                </span>
            @endif
          </div>
          <div class="form-group{{ $errors->has('home_png') ? ' has-error' : '' }}">
            <span class="text-danger">** ขนาดภาพ 300x300 **</span>
            <div class="input-group">
              <span class="input-group-btn">
                <span class="btn btn-default clear">
                  <i class="fa fa-remove fa-lg"></i> ลบ
                </span>
                <span class="btn btn-default btn-file">
                  <i class="fa fa-upload fa-lg"></i> เลือก
                  <input type="file" accept="image/png" name="home_png" class="imgInp">
                </span>
              </span>
              <input type="text" class="form-control" readonly>
            </div>
            @if ($errors->has('home_png'))
                <span class="help-block">
                  <strong>{{ $errors->first('home_png') }}</strong>
                </span>
            @endif
            <img src="{{ asset('pic/upload.png') }}"/>
          </div>
        </div>

        <div class="col-md-4 col-md-offset-1">
          <div class="form-group{{ $errors->has('away') ? ' has-error' : '' }}">
            <label>ทีมเยือน</label>
            <input class="form-control" type="text" name="away" value="{{ old('away') }}"
            required placeholder="กรอกชื่อทีมเยือน">
            @if ($errors->has('away'))
                <span class="help-block">
                  <strong>{{ $errors->first('away') }}</strong>
                </span>
            @endif
          </div>
          <div class="form-group{{ $errors->has('away_png') ? ' has-error' : '' }}">
            <label>ทีมเยือน</label>&nbsp;&nbsp;<span class="text-danger">(ขนาดภาพ 300x300)</span>
            <div class="input-group">
              <span class="input-group-btn">
                <span class="btn btn-default clear">
                  <i class="fa fa-remove fa-lg"></i> ลบ
                </span>
                <span class="btn btn-default btn-file">
                  <i class="fa fa-upload fa-lg"></i> เลือก
                  <input type="file" accept="image/png" name="away_png" class="imgInp">
                </span>
              </span>
              <input type="text" class="form-control" readonly>
            </div>
            @if ($errors->has('away_png'))
                <span class="help-block">
                  <strong>{{ $errors->first('away_png') }}</strong>
                </span>
            @endif
            <img src="{{ asset('pic/upload.png') }}"/>
          </div>
        </div>

        <div class="form-group">
          <div class="col-md-9">
            <button type="submit" class="btn btn-primary btn-block">ตกลง</button>
          </div>
        </div>

      </form>
    </div><!-- /.col-12-->
  </div><!-- /.row-->
</div><!-- /#page-wrapper -->
@endsection
<script type="text/javascript">
  var imgUpload = '{{ asset('pic/upload.png') }}';
</script>
