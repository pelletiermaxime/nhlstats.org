@extends('layouts.base')
@section('body')

<div align="center">
<a href="{{ route('scores', $dates['yesterday']) }}">&lt;-- {{ $dates['yesterday'] }}</a>
&nbsp;{{ $dates['today'] }}&nbsp;
<a href="{{ route('scores', $dates['tomorrow']) }}">{{ $dates['tomorrow'] }}--&gt;</a>
</div>

<div class="scores_page">
@foreach ($scores as $s)

<div class="game panel panel-default">
	<div class="game_header">
		<div class="team_name">{{ $s['status'] }}</div>
		<div>1</div>
		<div>2</div>
		<div>3</div>
		<div>T</div>
	</div>
	<div class="team1">
		<div class="team_name">
		<img height="45" src="{{ asset('images/SVG') }}/{{ $s['team1']['short_name'] }}.svg"
			alt="{{ $s['team1']['city'] }} {{ $s['team1']['name'] }}"
			title="{{ $s['team1']['city'] }} {{ $s['team1']['name'] }}"
		/>
		</div>
		<div class="score1_1">{{ $s['score1_1'] }}</div>
		<div class="score1_2">{{ $s['score1_2'] }}</div>
		<div class="score1_3">{{ $s['score1_3'] }}</div>
		<div class="score1_T">{{ $s['score1_T'] }}</div>
	</div>
	<div class="team2">
		<div class="team_name">
		<img height="45" src="{{ asset('images/SVG') }}/{{ $s['team2']['short_name'] }}.svg"
			alt="{{ $s['team2']['city'] }} {{ $s['team2']['name'] }}"
			title="{{ $s['team2']['city'] }} {{ $s['team2']['name'] }}"
		/>
		</div>
		<div class="score2_1">{{ $s['score2_1'] }}</div>
		<div class="score2_2">{{ $s['score2_2'] }}</div>
		<div class="score2_3">{{ $s['score2_3'] }}</div>
		<div class="score2_T">{{ $s['score2_T'] }}</div>
	</div>
</div>
@endforeach
</div>

@stop
