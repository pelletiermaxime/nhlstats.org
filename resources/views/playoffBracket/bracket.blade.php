@extends('layouts.base')
@section('body')

<div class="row">
	<div class="playoff_bracket col-xs-2">
	@foreach ($games_east[1] as $game)
		@include('playoffBracket.box', ['conference' => 'East', 'g' => $game])
	@endforeach
	</div>
	<div class="playoff_bracket col-xs-2">
	@foreach ($games_east[2] as $game)
		@include('playoffBracket.box', ['conference' => 'East', 'g' => $game])
	@endforeach
	</div>
	<div class="playoff_bracket col-xs-2">
	@foreach ($games_east[3] as $game)
		@include('playoffBracket.box', ['conference' => 'West', 'g' => $game])
	@endforeach
	</div>
	<div class="playoff_bracket col-xs-2">
	@foreach ($games_west[3] as $game)
		@include('playoffBracket.box', ['conference' => 'East', 'g' => $game])
	@endforeach
	</div>
	<div class="playoff_bracket col-xs-2">
	@foreach ($games_west[2] as $game)
		@include('playoffBracket.box', ['conference' => 'West', 'g' => $game])
	@endforeach
	</div>
	<div class="playoff_bracket col-xs-2">
	@foreach ($games_west[1] as $game)
		@include('playoffBracket.box', ['conference' => 'West', 'g' => $game])
	@endforeach
	</div>
</div>

@stop
