@extends('layouts.base')
@section('body')
{{ Form::open(array('route' => 'index', 'method' => 'GET')) }}
<table border="0" align="center" cellspacing="3" cellpadding="3">
	<tr>
		<td align="right">{{ Form::label('player', 'Player name :') }}</td>
		<td align="right" style="width:180px">
			{{ Form::text('player', Input::get('player'), array('style'=>"width:155px")) }}
		</td>
	</tr>
	<tr>
		<td align="right">Team :</td>
		<td align="right" style="width:180px">
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