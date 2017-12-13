<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Rakball Management</title>

    <!-- BOOTSTRAP-->
    <link href="{{ asset( 'css/bootstrap/bootstrap.min.css' ) }}" rel="stylesheet">

    <!-- METISMENU-->
    <link rel="stylesheet" href="{{ asset( 'css/backend/metisMenu/metisMenu.min.css' ) }}">

    <!-- FONT-AWESOME-->
    <link rel="stylesheet" href="{{ asset('css/font awesome/css/font-awesome.min.css') }}">

    <!-- MAIN CSS-->
    <link rel="stylesheet" href="{{ asset('css/backend/main0.css') }}">

    @if ( isset( $css ) )
      @foreach ($css as $style) 
        <link rel="stylesheet" href="{{ asset($style) }}">
      @endforeach
    @endif

</head>
<body>

<div id="wrapper">

@yield( 'content' )

</div><!-- /#wrapper-->

  <script src="{{ asset( 'js/jquery/jquery.min.js' ) }}"></script>
  <script src="{{ asset( 'js/bootstrap/bootstrap.min.js' ) }}"></script>
  <script src="{{ asset( 'js/backend/metisMenu/metisMenu.min.js' ) }}"></script>
  <script src="{{ asset( 'js/backend/main.js' ) }}"></script>
@if ( isset( $js ) )
  @foreach ($js as $script)
    <script src="{{ asset( $script ) }}"></script>
  @endforeach
@endif

</body>
</html>
