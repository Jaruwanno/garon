<nav class="navbar navbar-default navbar-static-top" role="navigation" style="margin-bottom: 0">
  <div class="navbar-header">
    <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
      <span class="sr-only">Toggle navigation</span>
      <span class="icon-bar"></span>
      <span class="icon-bar"></span>
      <span class="icon-bar"></span>
    </button>
    <a class="navbar-brand" href="index.html">Rakball Management</a>
  </div><!-- /.navbar-header -->
  <ul class="nav navbar-top-links navbar-right">
    <li class="dropdown">
      <a class="dropdown-toggle" data-toggle="dropdown" href="#">
        <i class="fa fa-user-circle-o fa-lg"></i> {{ Auth::user()->name }} <span class="caret"></span>
      </a>
      <ul class="dropdown-menu dropdown-user" role="menu">
        <li>
          <a href="{{ route('logout') }}"
              onclick="event.preventDefault();
                       document.getElementById('logout-form').submit();">
              <i class="fa fa-sign-out fa-lg"></i> ล็อกเอาท์
          </a>
          <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
              {{ csrf_field() }}
          </form>
        </li>
      </ul><!-- /.dropdown-user -->
    </li><!-- /.dropdown -->
  </ul><!-- /.navbar-top-links -->

  <div class="navbar-default sidebar" role="navigation">
    <div class="sidebar-nav navbar-collapse">
      <ul class="nav" id="side-menu">

        <li {!! ( Auth::user()->hasRole('users') ) ? "" : "style='display:none;'" !!}>
          <a href="#"><i class="fa fa-user-circle fa-lg"></i>&nbsp&nbspผู้ใช้ <span class="fa fa-angle-down fa-lg"></span></a>
          <ul class="nav nav-second-level">
            <li>
                <a href="{{ route('users') }}">ทั้งหมด</a>
            </li>

            <li>
                <a href="{{ route('register') }}">เพิ่มผู้ใช้</a>
              </li>
          </ul>
        </li>

        <li {!! ( Auth::user()->hasRole('match') ) ? "" : "style='display:none;'" !!}>
          <a href="#"><i class="fa fa-star fa-lg"></i>&nbsp&nbspคู่บิ๊กแมตช์ <span class="fa fa-angle-down fa-lg"></span></a>
          <ul class="nav nav-second-level">
            <li>
                <a href="{{ route('admin.match.index') }}">ทั้งหมด</a>
            </li>

            <li>
                <a href="{{ route('admin.match.create') }}">เพิ่มคู่บิ๊กแมตช์</a>
            </li>
          </ul>
        </li>

        <li{!! Auth::user()->hasRole('table') ? "" : " style='display:none;'" !!}>
          <a href="{{ route('admin.livescore.index') }}"><i class="fa fa-table fa-lg"></i>&nbsp&nbspตารางการแข่งขัน</a>
        </li>

        <li {!! ( Auth::user()->hasRole('category') ) ? "" : "style='display:none;'" !!}>
          <a href="{{ route('admin.zone.index') }}"><i class="fa fa-soccer-ball-o fa-lg"></i>&nbsp&nbspหมวดหมู่</a>
        </li>

        <li {!! ( Auth::user()->hasRole('news') ) ? "" : "style='display:none;'" !!}>
          <a href="#"{!! ( isset( $edit ) ? ( $edit == 'news' ? 'class=" active"' : '' ) : '' ) !!}>
            <i class="fa fa-newspaper-o fa-lg"></i>&nbsp&nbspข่าว <span class="fa fa-angle-down fa-lg"></span>
          </a>
          <ul class="nav nav-second-level">
            <li>
                <a href="{{ route('admin.news.index') }}">ทั้งหมด</a>
            </li>
            <li>
                <a href="{{ route('admin.news.create') }}">เพิ่มข่าว</a>
            </li>
          </ul>
        </li>
        <li {!! ( Auth::user()->hasRole('highlight') ) ? "" : "style='display:none;'" !!}>
          <a href="#"{!! ( isset( $edit ) ? ( $edit == 'highlight' ? 'class=" active"' : '' ) : '' ) !!}>
            <i class="fa fa-youtube-play fa-lg"></i>&nbsp&nbspไฮไลท์ <span class="fa fa-angle-down fa-lg"></span>
          </a>
          <ul class="nav nav-second-level">
            <li>
                <a href="{{ route('admin.highlight.home') }}">ทั้งหมด</a>
            </li>
            <li>
                <a href="{{ route('admin.highlight.form') }}">เพิ่มไฮไลท์</a>
            </li>
          </ul>
        </li>
        <li {!! ( Auth::user()->hasRole('game') ) ? "" : "style='display:none;'" !!}>
            <a href="index.html"><i class="fa fa-gamepad fa-lg"></i>&nbsp&nbspเกมส์</a>
        </li>
        <li {!! ( Auth::user()->hasRole('webboard') ) ? "" : "style='display:none;'" !!}>
            <a href="index.html"><i class="fa fa-edit fa-lg"></i>&nbsp&nbspเว็บบอร์ด</a>
        </li>
      </ul><!--/#side-menu-->
    </div><!-- /.sidebar-nav-->
  </div><!--/.navbar-default-->
</nav>
