@extends('layouts.base')
@section('body')

<div class="playoff_bracket">
<?php
?>
@foreach ($games_east as $game)
	@include('playoffBracketBox', ['conference' => 'East', 'g' => $game])
@endforeach
</div>
<div class="playoff_bracket">
@foreach ($games_west as $game)
	@include('playoffBracketBox', ['conference' => 'West', 'g' => $game])
@endforeach
<?
?>
</div>

@foreach ($games_east as $game)
	<img height="35" src="images/SVG/{{ $game['team1']['short_name'] }}.svg"
		alt="{{ $game['team1']['city'] }} {{ $game['team1']['name'] }}" />
	({{ $game['team1_position'] }})
	vs
	<img height="35" src="images/SVG/{{ $game['team2']['short_name'] }}.svg"
		alt="{{ $game['team2']['city'] }} {{ $game['team2']['name'] }}" />
	({{ $game['team2_position'] }})
	<br />
@endforeach

@foreach ($games_west as $game)
	<img height="35" src="images/SVG/{{ $game['team1']['short_name'] }}.svg"
		alt="{{ $game['team1']['city'] }} {{ $game['team1']['name'] }}" />
	({{ $game['team1_position'] }})
	vs
	<img height="35" src="images/SVG/{{ $game['team2']['short_name'] }}.svg"
		alt="{{ $game['team2']['city'] }} {{ $game['team2']['name'] }}" />
	({{ $game['team2_position'] }})
	<br />
@endforeach

@stop
