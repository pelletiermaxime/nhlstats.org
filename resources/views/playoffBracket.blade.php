@extends('layouts.base')
@section('body')

<div class="row">
	<div class="playoff_bracket col-xs-2">
	@foreach ($games_east as $game)
		@include('playoffBracketBox', ['conference' => 'East', 'g' => $game])
	@endforeach
	</div>
	<div class="playoff_bracket col-xs-2 col-xs-offset-8">
	@foreach ($games_west as $game)
		@include('playoffBracketBox', ['conference' => 'West', 'g' => $game])
	@endforeach
	</div>
</div>

@stop
