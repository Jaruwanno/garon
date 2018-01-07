<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
  <meta charset="utf-8">
  <!-- CSRF Token -->
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <meta name="viewport" content="initial-scale=1, maximum-scale=1, user-scalable=no, width=device-width">
  <meta name="apple-mobile-web-app-capable" content="yes">
  <meta name="apple-mobile-web-app-status-bar-style" content="black-translucent">

  <title>เอาใจคนรักบอล</title>

  <!-- Styles -->
  <link rel="stylesheet" href="{{ asset( 'css/bootstrap/bootstrap.min.css' ) }}">
  <link rel="stylesheet" href="{{ asset( 'css/font awesome/css/font-awesome.min.css' ) }}">
  <link rel="stylesheet" href="{{ asset( 'css/frontend/main_style.css' ) }}">

  @if ( isset( $css ) )
    @foreach ($css as $style)
      <link rel="stylesheet" href="{{ asset($style) }}">
    @endforeach
  @endif
</head>
<body>
  @include('inc.navfront')

  @yield('content')
  <!-- Scripts -->
  <script src="{{ asset( 'js/jquery/jquery.min.js' ) }}"></script>
  <script src="{{ asset( 'js/bootstrap/bootstrap.min.js' ) }}"></script>
  <script src="{{ asset( 'js/frontend/main.js' ) }}""></script>
  <script>
        var match_path = '{{ url('/local/storage/app/public/bigmatch') }}';
  </script>
  @if ( isset( $js ) )
    @foreach ($js as $script)
      <script src="{{ asset( $script ) }}"></script>
    @endforeach
  @endif
</body>
</html>
