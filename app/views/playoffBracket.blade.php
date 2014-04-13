@extends('layouts.base')
@section('body')

@foreach ($games_east as $game)
	<img height="35" src="images/SVG/{{ $game['team1']['short_name'] }}.svg"
		alt="{{ $game['team1']['city'] }} {{ $game['team1']['name'] }}" />
	vs
	<img height="35" src="images/SVG/{{ $game['team2']['short_name'] }}.svg"
		alt="{{ $game['team2']['city'] }} {{ $game['team2']['name'] }}" />
	<br />
@endforeach

@foreach ($games_west as $game)
	<img height="35" src="images/SVG/{{ $game['team1']['short_name'] }}.svg"
		alt="{{ $game['team1']['city'] }} {{ $game['team1']['name'] }}" />
	vs
	<img height="35" src="images/SVG/{{ $game['team2']['short_name'] }}.svg"
		alt="{{ $game['team2']['city'] }} {{ $game['team2']['name'] }}" />
	<br />
@endforeach

@stop