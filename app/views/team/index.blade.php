@extends('layouts.base')
@section('footer-scripts')
@stop
@section('body')
<?php
	$prevDivision = '';
?>
<div class="teams_page">
	<div class="game">
	@foreach ($teams as $team)
	@if ($prevDivision != '' && $team->division != $prevDivision)
	</div>
	<div class="game">
	@endif
	<div class="team_line">
	<div class="team_logo">
		<a href="{{ route('team', $team->short_name) }}">
		<img height="50" src="{{ asset('images/SVG') }}/{{ $team->short_name }}.svg"
			alt="{{ $team->city }} {{ $team->name }}" />
		</a>
	</div>
	<div class="team_name">
		{{ $team->city }}
		{{ $team->name }}
	</div>
	</div>
	<?php $prevDivision = $team->division?>
	@endforeach
</div>
@stop
