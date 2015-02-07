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

@if (App::environment('development'))
<script src="{{ asset("components/jquery/jquery.min.js") }}"></script>
<link href="{{ asset("css/slate-bootstrap.min.css") }}" rel="stylesheet">
@else
<link rel="stylesheet" href="//maxcdn.bootstrapcdn.com/bootswatch/3.3.0/slate/bootstrap.min.css">
<script type="text/javascript" src="//code.jquery.com/jquery-2.1.1.min.js"></script>
@endif

<link rel="stylesheet" media="all" type="text/css" href="{{ asset('components/chosen/css/chosen.min.css') }}" />
<link rel="stylesheet" media="all" type="text/css" href="{{ asset('css/general.css') }}" />

@show
</head>
<body>
@include('layouts/menu')
@yield('body')

@if (App::environment('development'))
	<script src="{{ asset("components/bootstrap/js/bootstrap.min.js") }}"></script>
	<script src="{{ asset("components/datatables/media/js/jquery.dataTables.min.js") }}"></script>
@else
	<script src="//netdna.bootstrapcdn.com/bootstrap/3.3.0/js/bootstrap.min.js"></script>
	<script type="text/javascript" src="//cdn.datatables.net/1.10.4/js/jquery.dataTables.min.js"></script>
@endif

<script src="{{ asset("components/chosen/js/chosen.jquery.min.js") }}"></script>
<script src="//cdnjs.cloudflare.com/ajax/libs/history.js/1.8/bundled/html5/jquery.history.js"></script>

@yield('footer-scripts')
</body>
</html>
