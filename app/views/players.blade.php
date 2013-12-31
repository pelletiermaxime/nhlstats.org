@extends('layouts.base')
@section('body')
<ul class="errors">
@foreach($errors->all() as $message)
	<li>{{ $message }}</li>
@endforeach
</ul>
{{ Form::open(array('route' => 'players_filtered', 'method' => 'GET')) }}
<div class="row">
	<ul class="errors">
	@foreach($errors->get('name') as $message)
		<li>{{ $message }}</li>
	@endforeach
	</ul>
</div>
<div class="row">
	<div class="col-xs-2 col-xs-offset-4">{{ Form::label('name', 'Player name :') }}</div>
	<div class="col-xs-6">
		{{ Form::text('name', Input::get('name'), array('style'=>"width:155px")) }}
	</div>
</div>
<div class="row">
	<div class="col-xs-2 col-xs-offset-4">Team :</div>
	<div class="col-xs-6">
		{{ Form::select('team', $all_teams, $team, array('style'=>"width:155px")) }}
	</div>
</div>
<div class="row">
	<div class="col-xs-2 col-xs-offset-4">Position :</div>
	<div class="col-xs-6">
	</div>
</div>
<div class="row">
	<div class="col-xs-2 col-xs-offset-4">Number to show :</div>
	<div class="col-xs-6">
		{{ Form::select('count', $all_counts, $count, array('style'=>"width:155px")) }}
	</div>
</div>
<div class="row">
	<div class="col-xs-7 col-xs-offset-5">
	<button type="submit" class="btn btn-default btn-lg">Search</button>
	</div>
</div>
{{ Form::close() }}
@stop