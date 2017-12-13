@extends('layouts.backend')

@include( 'inc.navback' )

@section('content')
<div id="page-wrapper">
  <div class="row">
    <div class="col-lg-12">
      <h3 class="page-header">รายชื่อคู่บิ๊กแมตช์</h3>
    </div><!-- /.col-lg-12 -->
  </div><!-- /.row-->

  <div class="row">
    <div class="table-responsive">
      <table class="table table-condensed">
        <thead>
          <tr>
            <th>#</th>
            <th>หัวข้อ</th>
            <th>เจ้าบ้าน</th>
            <th>ทีมเยือน</th>
            <th>กำหนดเตะ</th>
            <th class="text-center">เปิดใช้งาน</th>
            <th class="text-center">ตัวเลือก</th>
          </tr>
        </thead>
        <tbody>
  @php
    $n = 1;
  @endphp
  @forelse ($match as $m)
  @php
    $td = User::thai_date($m->kick_start);
  @endphp
          <tr>
            <td>{{ $n }}</td>
            <td>{{ $m->topic }}</td>
            <td>{{ $m->home }}</td>
            <td>{{ $m->away }}</td>
            <td>{{ $td['day']." ที่ ".$td['date']." ".$td['month']." ".$td['year']." ".$td['time']}}</td>
            <td class="text-center">
              <input class="action" id="{{ $m->id }}" name="action"
              {{ ($m->active == 1 ? 'checked' : '') }} type="checkbox"/>
              <label for="{{ $m->id }}" class="label-success"></label>
            </td>
            <td class="text-center">
              <button data-id="{{ $m->id }}" class="del btn btn-danger btn-sm" type="submit">ลบ</button>
            </td>
          </tr>
  @php
    $n++;
  @endphp
  @empty
          <tr>
            <td colspan='7' class="warning">ไม่พบข้อมูล</td>
          </tr>
  @endforelse
        </tbody>
      </table>
    </div>
  </div><!-- /.row-->
</div><!-- /#page-wrapper -->

@endsection
