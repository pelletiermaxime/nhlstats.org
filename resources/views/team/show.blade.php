@extends('layouts.base')
@section('footer-scripts')
<script src="//code.highcharts.com/highcharts.js"></script>
@stop
@section('body')
<div class="flex-container" id="graphPieAvD" style="width:100%; height:400px;">
	@include('team.graphPieAvD')
</div>
<div class="flex-container">
	<div class="flex-item">
	@include('playersStats')
	@include('goalers/goalersStats')
	</div>
	<div class="flex-item">
	@include('playersStatsDay')
	</div>
</div>
@if ($position != 'all')
<script type="text/javascript">
	$(function () {
		$('#tableOverall').DataTable().column(2).search('{{ $position }}').draw();
		<?php
		$index = 0;
		foreach ($pointsByPosition as $points) {
			if ($points->position == $position) {
				$selectedPosition = $index;
			}
			$index++;
		}
		?>
		var chart = $('#graphPieAvD').highcharts();
		chart.series[0].data[{{ $selectedPosition }}].select();
		chart.series[0].data[{{ $selectedPosition }}].update();
	});
</script>
@endif
@stop
