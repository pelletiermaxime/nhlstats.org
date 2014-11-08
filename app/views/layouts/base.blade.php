<!DOCTYPE html>
<html>
<head>
@section('head')
<title>NHLStats</title>
<meta charset="UTF-8" />
<meta name="keywords" content="nhl stats nhlstats" />
<meta name="robots" content="index,nofollow" />
<meta name="Author" content="Maxime Pelletier" />
<meta name="description" content=""/>
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<link rel="stylesheet" href="//maxcdn.bootstrapcdn.com/bootstrap/3.3.0/css/bootstrap.min.css">
<link rel="stylesheet" media="all" type="text/css" href="{{ asset('css/general.css') }}" />
@show
</head>
<body>
<div class="container">
<div align="center"><a href="{{ route('index') }}">
	<img src="{{ asset('images/banner.png') }}" alt="NhlStats" border="0" width="550" /></a>
</div>
@include('layouts/menu')
</div>
@yield('body')
@if (App::environment('development'))
	<script src="{{ asset("components/jquery/jquery.min.js") }}"></script>
	<script src="{{ asset("components/bootstrap/js/bootstrap.min.js") }}"></script>
	<script src="{{ asset("components/datatables/media/js/jquery.dataTables.min.js") }}"></script>
@else
<script type="text/javascript" src="//code.jquery.com/jquery-2.1.1.min.js" data-no-instant></script>
<script src="//netdna.bootstrapcdn.com/bootstrap/3.3.0/js/bootstrap.min.js" data-no-instant></script>
<script type="text/javascript" src="//cdn.datatables.net/1.10.4/js/jquery.dataTables.min.js"></script>
@endif
@yield('footer-scripts')
</body>
</html>
