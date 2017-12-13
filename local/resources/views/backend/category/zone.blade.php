@extends('layouts.backend')

@include( 'inc.navback' )

@section('content')
<div id="page-wrapper">
  <div class="row">
      <div class="col-lg-12">
          <h3 class="page-header">หัวข้อรายการ</h3>
      </div><!-- /.col-lg-12 -->
  </div><!-- /.row-->

  <div class="row">
    <div class="col-lg-10 col-lg-offset-1">
      <button type="button" id="add" class="btn btn-primary pull-right"
      data-toggle="modal" data-target="#myModal">
        เพิ่ม &nbsp<span class="fa fa-plus-circle fa-lg"></span>
      </button>
      <br><br>
      <div class="table-responsive">
        <table class="table table-condensed">
          <thead>
            <tr>
              <th class="text-center">ลำดับ</th>
              <th class="text-center">โซน</th>
              <th class="text-center">created_at</th>
              <th class="text-center">updated_at</th>
              <th class="text-center">ตัวเลือก</th>
            </tr>
          </thead>
          <tbody>
            @forelse ($zone as $z)
              <tr>
                <td class="text-center">{{ $z->length }}</td>
                <td class="text-center">{{ $z->name }}</td>
                <td class="text-center">{{ $z->created_at->diffForHumans() }}</td>
                <td class="text-center">{{ $z->updated_at->diffForHumans() }}</td>
                <td class="text-center">
                  <button class="btn btn-default btn-sm edit" value="{{ $z->id }}" data-toggle="modal" data-target="#myModal">แก้ไข</button>
                  <button class="btn btn-danger btn-sm del" value="{{ $z->id }}">ลบ</button>
                </td>
              </tr>
            @empty
              <tr>
                <td colspan="5" style="text-align:center;"><h3>ไม่พบข้อมูล</h3></td>
              </tr>
            @endforelse
          </tbody>
        </table>
      </div>
    </div>
  </div>

  <!-- Modal -->
  <div class="modal fade" id="myModal" tabindex="-1">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
          <h4 class="modal-title"></h4>
        </div>
        <div class="modal-body">
          <input type="hidden" name="id" value="">
          <div class="form-group">
            <input type="number" name="length" class="form-control"  placeholder="กรอกลำดับ">
          </div>
          <div class="form-group">
            <input type="text" name="name" class="form-control"  placeholder="กรอกข้อมูล">
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" id="btn-save" class="btn btn-primary">บันทึก</button>
          <button type="button" class="btn btn-default" data-dismiss="modal">ยกเลิก</button>
        </div>
      </div>
    </div>
  </div><!--/.Modal-->

</div>

@endsection
