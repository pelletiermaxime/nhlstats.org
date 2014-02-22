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
<link rel="stylesheet" href="//netdna.bootstrapcdn.com/bootstrap/3.0.3/css/bootstrap.min.css">
<link rel="stylesheet" media="all" type="text/css" href="{{ asset('css/general.css') }}" />
<script type="text/javascript" src="//code.jquery.com/jquery-1.11.0.min.js" data-no-instant></script>
<script src="//netdna.bootstrapcdn.com/bootstrap/3.0.0/js/bootstrap.min.js" data-no-instant></script>
<script type="text/javascript" src="{{ asset('javascript/DataTables/media/jquery.dataTables.min.js') }}" data-no-instant></script>
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
<script src="{{ asset('javascript')}}/instantclick.min.js" data-no-instant></script>
<script data-no-instant>InstantClick.init(50);</script>
</body>
</html>