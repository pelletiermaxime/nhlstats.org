@extends('layouts.base')
@section('body')

<?php
$standingPages = [
	route('standings')          => 'Overall',
	route('standings_division') => 'Division',
	route('standings_wildcard') => 'Wildcard',
];
$currentPage = URL::current();
$routeName = Route::currentRouteName();
?>
@if ($routeName == 'standings')
@section('footer-scripts')
<script src="{{ asset('javascript/standings.js') }}"></script>
@stop
@endif
<div style="width:80%; margin:auto;">
<ul class="nav nav-tabs">
@foreach ($standingPages as $page => $pageName)
	@if ($page == $currentPage )
	<li class="active">
	@else
	<li>
	@endif
		<a href="{{ $page }}">{{ $pageName }}</a>
	</li>
@endforeach
</ul>
</div>

@yield('standings')

@stop
