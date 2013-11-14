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
<link rel="stylesheet" media="all" type="text/css" href="{{ asset('css/general.css') }}" />
<script type="text/javascript" src="{{ asset('javascript/DataTables/media/jquery.js') }}"></script>
<script type="text/javascript" src="{{ asset('javascript/DataTables/media/jquery.dataTables.min.js') }}"></script>
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