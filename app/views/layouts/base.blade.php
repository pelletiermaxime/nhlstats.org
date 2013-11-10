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
<link rel="stylesheet" media="all" type="text/css" href="includes/general.css" />
@show
</head>
<body>
<div align="center"><a href="{{ route('index') }}">
	<img src="{{ asset('images/banner.png') }}" alt="NhlStats" border="0" width="550" /></a>
</div>
@include('layouts/menu')
@yield('body')
</body>
</html>