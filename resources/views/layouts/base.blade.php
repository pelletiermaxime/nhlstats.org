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

<script src="/javascript/vendors/jquery.min.js"></script>

<link rel="stylesheet" type="text/css" href="/css/slate-bootstrap.min.css">
<link rel="stylesheet" type="text/css" href="/css/app.css" />
<link rel="stylesheet" type="text/css" href="/css/vendors.css" />

@show
</head>
<body>
@include('layouts/menu')
@yield('body')

<script src="/javascript/vendors/bootstrap.min.js"></script>
<script src="/javascript/vendors/jquery.dataTables.min.js"></script>
<script src="/javascript/vendors/selectize.min.js"></script>
<script src="//cdnjs.cloudflare.com/ajax/libs/history.js/1.8/bundled/html5/jquery.history.js"></script>

@yield('footer-scripts')
</body>
</html>
