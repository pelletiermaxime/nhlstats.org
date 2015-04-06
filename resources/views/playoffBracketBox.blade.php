<div class="game">
	<div class="game_header">
		<div class="team_name">&nbsp;</div>
		@for ($i = 1; $i <= count($g['regularSeasonGames']); $i++)
			<div>{{ $i }}</div>
		@endfor
	</div>
	<div class="team1">
		<div class="team_name">
		<img height="45" src="{{ asset('images/SVG') }}/{{ $g['team1']['short_name'] }}.svg"
			alt="{{ $g['team1']['city'] }} {{ $g['team1']['name'] }}"
			title="{{ $g['team1']['city'] }} {{ $g['team1']['name'] }}"
		/>
		({{ $g['team1_position'] }})
		</div>
		<div class="matches">
		@foreach ($g['regularSeasonGames'] as $game)
			@if ($game['team1_id'] == $g['team1']['id'])
			<div>{{ $game['score1_T'] }}</div>
			@else
			<div>{{ $game['score2_T'] }}</div>
			@endif
		@endforeach
		</div>
	</div>
	<div class="team2">
		<div class="team_name">
		<img height="45" src="{{ asset('images/SVG') }}/{{ $g['team2']['short_name'] }}.svg"
			alt="{{ $g['team2']['city'] }} {{ $g['team2']['name'] }}"
			title="{{ $g['team2']['city'] }} {{ $g['team2']['name'] }}"
		/>
		({{ $g['team2_position'] }})
		</div>
		<div class="matches">
		@foreach ($g['regularSeasonGames'] as $game)
			@if ($game['team1_id'] == $g['team2']['id'])
			<div>{{ $game['score1_T'] }}</div>
			@else
			<div>{{ $game['score2_T'] }}</div>
			@endif
		@endforeach
		</div>
	</div>
</div>
