@extends('layouts.base')
@section('body')
@include('playersForm')
<div class="flex-container">
	<div class="flex-item">
	@include('playersStats')
	</div>
	<div class="flex-item">
	@include('playersStatsDay')
	</div>
</div>
@stop