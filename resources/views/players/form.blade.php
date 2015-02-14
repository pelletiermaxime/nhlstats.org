<ul class="errors">
@foreach($errors->all() as $message)
	<li>{{ $message }}</li>
@endforeach
</ul>
{!! Form::open(array('route' => 'players_filtered', 'method' => 'GET')) !!}
<div class="row">
	<ul class="errors">
	@foreach($errors->get('name') as $message)
		<li>{{ $message }}</li>
	@endforeach
	</ul>
</div>

<div class="form-group">
	<div class="col-xs-4 col-xs-offset-2 text-right">{!! Form::label('name', 'Player name :') !!}</div>
	<div class="col-xs-6">
		{!! Form::text('name', Input::get('name'), ['class'=>"form-control player-form-input-text"]) !!}
	</div>
</div>

<div class="form-group">
	<div class="col-xs-4 col-xs-offset-2 text-right">{!! Form::label('team', 'Team :') !!}</div>
	<div class="col-xs-6">
		{!!
			Form::select('team', $all_teams, $team, [
				'class' => 'form-control player-form-input-list chosen-select',
				'data-placeholder' => 'Filter by team...'
			])
		!!}
	</div>
</div>

<div class="form-group">
	<div class="col-xs-4 col-xs-offset-2 text-right">{!! Form::label('position', 'Position :') !!}</div>
	<div class="col-xs-6">
		{!! Form::select('position', $all_positions, $position, ['class'=>"form-control player-form-input-list"]) !!}
	</div>
</div>

<div class="form-group">
	<div class="col-xs-4 col-xs-offset-2 text-right">{!! Form::label('count', 'Count :') !!}</div>
	<div class="col-xs-6">
		{!! Form::select('count', $all_counts, $count, ['class'=>"form-control player-form-input-list"]) !!}
	</div>
</div>

<div class="row">
	<div class="col-xs-7 col-xs-offset-5">
	<button type="submit" class="btn btn-default btn-lg">Search</button>
	</div>
</div>
{!! Form::close() !!}
