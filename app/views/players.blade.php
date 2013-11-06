@extends('layouts.base')
@section('body')
{{ Form::open(array('route' => 'players_filtered', 'method' => 'GET')) }}
<ul class="errors">
@foreach($errors->all() as $message)
	<li>{{ $message }}</li>
@endforeach
</ul>
<table border="0" align="center" cellspacing="3" cellpadding="3">
	<tr>
		<td colspan="3">
			<ul class="errors">
			@foreach($errors->get('name') as $message)
				<li>{{ $message }}</li>
			@endforeach
			</ul>
		</td>
	</tr>
	<tr>
		<td align="right">{{ Form::label('name', 'Player name :') }}</td>
		<td align="right" style="width:180px">
			{{ Form::text('name', Input::get('name'), array('style'=>"width:155px")) }}
		</td>
	</tr>
	<tr>
		<td align="right">Team :</td>
		<td align="right" style="width:180px">
			{{ Form::select('team', $all_teams, $team, array('style'=>"width:155px")) }}
		</td>
	</tr>
	<tr>
		<td align="right">Position :</td>
		<td align="right" style="width:180px">
		</td>
	</tr>
	<tr>
		<td align="right">Number to show :</td>
		<td align="right" style="width:180px">
			{{ Form::select('count', $all_counts, $count, array('style'=>"width:155px")) }}
		</td>
	</tr>
	<tr>
		<td colspan="2" align="center">
		{{ Form::submit('Search') }}
		</td>
	</tr>
</table>
{{ Form::close() }}
@stop