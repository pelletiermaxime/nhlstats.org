<ul class="errors">
@foreach($errors->all() as $message)
	<li>{{ $message }}</li>
@endforeach
</ul>
{{ Form::open(array('route' => 'goalers', 'method' => 'GET')) }}
<div class="row">
	<ul class="errors">
	@foreach($errors->get('name') as $message)
		<li>{{ $message }}</li>
	@endforeach
	</ul>
</div>
<!--
<div class="row">
	<div class="col-xs-4 col-xs-offset-2 text-right">{{ Form::label('name', 'Player name :') }}</div>
	<div class="col-xs-6">
		{{ Form::text('name', Input::get('name'), array('style'=>"width:155px")) }}
	</div>
</div>
-->
<div class="row">
	<div class="col-xs-4 col-xs-offset-2 text-right">Team :</div>
	<div class="col-xs-6">
		{{ Form::select('team', $all_teams, $team, array('style'=>"width:155px")) }}
	</div>
</div>
<div class="row">
	<div class="col-xs-7 col-xs-offset-5">
	<button type="submit" class="btn btn-default btn-lg">Search</button>
	</div>
</div>
{{ Form::close() }}