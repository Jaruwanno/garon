@extends('layouts.backend')

@include('inc.navback')

@section('content')
<div id="page-wrapper">
  <div class="row">
    <div class="col-lg-12">
      <h3 class="page-header">ผู้ใช้ทั้งหมด</h3>
    </div><!-- /.col-lg-12 -->
  </div>
    <div class="row">
        <div class="col-md-12">
          <div class="table-responsive">
            <table class="table table-condensed">
              <thead>
                <tr>
                  <th>ชื่อ</th>
                  <th>อีเมล</th>
                  <th>ประเภท</th>
                  <th class="text-center">สิทธิ์การจัดการ</th>
                  <th class="text-center">ตัวเลือก</th>
                </tr>
              </thead>
              <tbody>
@forelse ($users as $user)
                <tr>
                  <td>{{ $user->name }}</td>
                  <td>{{ $user->email }}</td>
                  <td>{{ $user->role_name }}</td>
                  <td class="text-center">
                    <form action="{{ route('users') }}" method="post">
                      {{ csrf_field() }}
                      <input type="hidden" name="id" value="{{ $user->id }}">
                      <ul class="list-inline">
                        <li>
                          <label class="checkbox-inline">
                            <input type="checkbox" name="role_user" class="roles"
                            {{ $user->hasRole('users') ? "checked" : "" }}> ผู้ใช้
                          </label>
                        </li>

                        <li> 
                          <label class="checkbox-inline">
                            <input type="checkbox" name="role_match" class="roles"
                            {{ $user->hasRole('match') ? "checked" : "" }}> บิ๊กแมทข์
                          </label>
                        </li>

                        <li>
                          <label class="checkbox-inline">
                            <input type="checkbox" name="role_table" class="roles"
                            {{ $user->hasRole('table') ? "checked" : "" }}> ตารางการแข่งขัน
                          </label>
                        </li>

                        <li>
                          <label class="checkbox-inline">
                            <input type="checkbox" name="role_category" class="roles"
                            {{ $user->hasRole('category') ? "checked" : "" }}> หมวดหมู่
                          </label>
                        </li>

                        <li>
                          <label class="checkbox-inline">
                            <input type="checkbox" name="role_news" class="roles"
                            {{ $user->hasRole('news') ? "checked" : "" }}> ข่าว
                          </label>
                        </li>

                        <li>
                          <label class="checkbox-inline">
                            <input type="checkbox" name="role_highlight" class="roles"
                            {{ $user->hasRole('highlight') ? "checked" : "" }}> ไฮไลท์
                          </label>
                        </li>

                        <li>
                          <label class="checkbox-inline">
                            <input type="checkbox" name="role_webboard" class="roles"
                            {{ $user->hasRole('webboard') ? "checked" : "" }}> เว็บบอร์ด
                          </label>
                        </li>
                      </ul>
                    </form>
                  </td>
                  <td class="text-center">
                    <button class="btn btn-default btn-sm edit" value="{{ $user->id }}" data-toggle="modal" data-target="#myModal">แก้ไข</button>
                    <button class="btn btn-danger btn-sm del" value="{{ $user->id }}">ลบ</button>
                  </td>
                </tr>
@empty

@endforelse
              </tbody>
            </table>
          </div>
        </div>
    </div>
</div>
@endsection
