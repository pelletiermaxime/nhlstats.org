<div class="game panel">
	<div class="team1" style='background-image: url("{{ asset('images/SVG') }}/{{ $g['team1']['short_name'] }}.svg")'>
		<div class="matches">
		<? $team1_vics = $team2_vics = 0 ?>
		@foreach ($g['regularSeasonGames'] as $noGame => $game)
			@if ($game['team1_id'] == $g['team1']['id'])
				@if ($game['winner'] == 'team1')
				<div class="winner">
				@else
				<div>
				@endif
				{{ $game['score1_T'] }}
			</div>
			@else
				@if ($game['winner'] == 'team2')
				<div class="winner">
				@else
				<div>
				@endif
				{{ $game['score2_T'] }}
			</div>
			@endif
		@endforeach
		</div>
		<div class="total_score">
		{{ $g['wins'][$g['team1_id']] }}
		</div>
	</div>
	<div class="team2" style='background-image: url("{{ asset('images/SVG') }}/{{ $g['team2']['short_name'] }}.svg")'>
		<div class="matches">
		@foreach ($g['regularSeasonGames'] as $noGame => $game)
			@if ($game['team1_id'] == $g['team2']['id'])
			@if ($game['winner'] == 'team1')
			<div class="winner">
			@else
			<div>
			@endif
				{{ $game['score1_T'] }}
			</div>
			@else
			@if ($game['winner'] == 'team2')
			<div class="winner">
			@else
			<div>
			@endif
				{{ $game['score2_T'] }}
			</div>
			@endif
		@endforeach
		</div>
		<div class="total_score">
		{{ $g['wins'][$g['team2_id']] }}
		</div>
	</div>
</div>
