<h3>Select choices for round {{ $round }}</h3>
{!! Form::open(['route' => 'pool_save']) !!}
@foreach ($playoffTeams as $game)
<div class="row" style="padding:5px;">
	<div class="col-xs-2 col-xs-offset-4 text-right">
	<select name="WinningTeamId[{{ $game['id'] }}]" class="form-control">
		<option value="{{ $game['team1']['id'] }}">
			{{ $game['team1']['city'] }} {{ $game['team1']['name'] }}
		</option>
		<option value="{{ $game['team2']['id'] }}">
			{{ $game['team2']['city'] }} {{ $game['team2']['name'] }}
		</option>
	</select>
	</div>
	<div class="col-xs-1">
	<select name="NbGames[{{ $game['id'] }}]" class="form-control">
		<option value="4">4</option>
		<option value="5">5</option>
		<option value="6">6</option>
		<option value="7">7</option>
	</select>
	</div>
</div>
@endforeach
<input type="hidden" name="round" value="{{ $round }}">
<div class="row" style="padding:5px;">
	<button type="submit" class="btn btn-default btn-lg">Save</button>
</div>
{!! Form::close() !!}
