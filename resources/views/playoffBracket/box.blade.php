<div class="game panel">
	<div class="team1" style='background-image: url("{{ asset('images/SVG') }}/{{ $g['team1']['short_name'] }}.svg")'>
		<div class="matches">
		<? $team1_vics = $team2_vics = 0 ?>
		@for ($i = 0; $i < 7 ; $i++)
			<?
			$game = [];
			$score = '';
			if (isset($g['regularSeasonGames'][$i]))
			{
				$game = $g['regularSeasonGames'][$i];
			?>
			@if ($game['team1_id'] == $g['team1']['id'])
				@if ($game['winner'] == 'team1')
				<? $class = 'winner' ?>
				@else
				<? $class = '' ?>
				@endif
				<? $score = $game['score1_T'] ?>
			@else
				@if ($game['winner'] == 'team2')
				<? $class = 'winner' ?>
				@else
				<? $class = '' ?>
				@endif
				<? $score = $game['score2_T'] ?>
			@endif
			<? } ?>

			<div class="{{ $class }}">
			{{ $score }}
			</div>
		@endfor
		</div>
		<div class="total_score">
		{{ $g['wins'][$g['team1_id']] }}
		</div>
	</div>
	<div class="team2" style='background-image: url("{{ asset('images/SVG') }}/{{ $g['team2']['short_name'] }}.svg")'>
		<div class="matches">
		<? $team1_vics = $team2_vics = 0 ?>
		@for ($i = 0; $i < 7 ; $i++)
			<?
			$game = [];
			$score = '';
			if (isset($g['regularSeasonGames'][$i]))
			{
				$game = $g['regularSeasonGames'][$i];
			?>
			@if ($game['team1_id'] == $g['team2']['id'])
				@if ($game['winner'] == 'team1')
				<? $class = 'winner' ?>
				@else
				<? $class = '' ?>
				@endif
				<? $score = $game['score1_T'] ?>
			@else
				@if ($game['winner'] == 'team2')
				<? $class = 'winner' ?>
				@else
				<? $class = '' ?>
				@endif
				<? $score = $game['score2_T'] ?>
			@endif
			<? } ?>
			<div class="{{ $class }}">
			{{ $score }}
			</div>
		@endfor
		</div>
		<div class="total_score">
		{{ $g['wins'][$g['team2_id']] }}
		</div>
	</div>
</div>
