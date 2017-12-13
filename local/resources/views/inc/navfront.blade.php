<header id="header">
  {{-- <nav id="social" class="navbar navbar-default">
    <div class="container">
      <div class="row">
        <div class="navbar-header">
          <a class="navbar-brand fa fa-facebook-square fa-lg" href="#"></a>
          <a class="navbar-brand fa fa-google-plus fa-lg" href="#"></a>
          <a class="navbar-brand fa fa-twitter fa-lg" href="#"></a>
          <a class="navbar-brand fa fa-youtube-play fa-lg" href="#"></a>
          <a class="navbar-brand fa fa-phone fa-lg" href="#"> xxx-xxx-xxxx</a>
          <a class="navbar-brand fa fa-envelope-o fa-lg" href="#"> support@rakball@gamil.com</a>
        </div>
      </div>
    </div>
  </nav> --}}

  <nav id="main-menu" class="navbar navbar-inverse" role="banner">
    <div class="container">
      <div class="row">
        <div class="navbar-header">
          <button type="button" class="navbar-toggle pull-left" data-toggle="collapse" data-target=".navbar-collapse">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </button>
          <a href="{{ url('/') }}" class="navbar-brand">
            <img src="{{ asset('pic/balllife-logo.png') }}" id="brand">
          </a>
        </div>

        <div class="collapse navbar-collapse navbar-right">
          <ul class="nav navbar-nav">
            <li class="{{ Request::is('/') ? 'active' : '' }}"><a href="{{ route('home') }}">หน้าแรก</a></li>
            <li class="{{ Request::is('news*') ? 'active' : '' }}"><a href="{{ route('news') }}">ข่าวสาร</a></li>
            <li class="{{ Request::is('highlight*') ? 'active' : '' }}"><a href="{{ route('highlight') }}">ไฮไลท์ฟุตบอล</a></li>
            <li class="{{ Request::is('table') ? 'active' : '' }}"><a href="{{ route('table') }}">ผลบอล</a></li>

          </ul>
        </div>

      </div><!--/row-->
    </div><!--/container-->
  </nav><!--/nav-->

  <section class="image-header">
    <div class="container">
      <div class="row">
        <div class="col-md-3 col-xs-7 bigmatch text-center">
          @yield('header-text')
        </div>
      </div>
    </div>
  </section>

</header><!--/header-->
