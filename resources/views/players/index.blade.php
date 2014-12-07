@extends('layouts.base')
@section('body')
@include('players.form')
<div class="flex-container">
	<div class="flex-item">
	@include('playersStats')
	</div>
	<div class="flex-item">
	@include('playersStatsDay')
	</div>
</div>
@stop
@section('footer-scripts')
<script src="{{ asset('javascript/players.js') }}"></script>
@stop
