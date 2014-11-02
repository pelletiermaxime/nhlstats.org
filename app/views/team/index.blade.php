@extends('layouts.base')
@section('footer-scripts')
<script src="http://code.highcharts.com/highcharts.js"></script>
@stop
@section('body')
<div class="flex-container" id="graphPieAvD" style="width:100%; height:400px;">
	@include('team.graphPieAvD')
</div>
<div class="flex-container">
	<div class="flex-item">
	@include('playersStats')
	</div>
	<div class="flex-item">
	@include('playersStatsDay')
	</div>
</div>
@stop
