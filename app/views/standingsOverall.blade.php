<table width="80%" style="text-align:center;" id="tableOverall" align="center" cellspacing="0" cellpadding="2">
<thead>
<tr>
	<th colspan="11">&nbsp;</th>
	<th colspan="3" style="border:1px solid black;border-bottom:none;">Powerplay</th>
	<th colspan="3" style="border:1px solid black;border-bottom:none;">Penalty kill</th>
	<th colspan="4">&nbsp;</th>
</tr>
<tr>
	<th>Position</th>
	<th>Team</th>
	<th>Division</th>
	<th>GP</th>
	<th>W</th>
	<th>L</th>
	<th>OTL</th>
	<th>PTS</th>
	<th>GF</th>
	<th>GA</th>
	<th>Diff</th>
	<th style="border-left:1px solid black;" title="Goals">G</th>
	<th title="Opportunities">O</th>
	<th style="border-right:1px solid black;" title="Percent">P</th>
	<th style="border-left:1px solid black;" title="Goals Against">G</th>
	<th title="Opportunities against">O</th>
	<th style="border-right:1px solid black;" title="Penalty Kill Percent">P</th>
	<th>Home</th>
	<th>Away</th>
	<th>L10</th>
	<th>Streak</th>
</tr>
</thead>
<tbody>
@foreach ($standings as $position => $s)
<tr>
	@if ($s->team->division->conference == 'EAST')
	<td style="background:#b9112d;color:white;font-size:1.8em;">{{ ++$position }}</td>
	@else
	<td style="background:#003872;color:white;font-size:1.8em;">{{ ++$position }}</td>
	@endif
	<td>
		<img height="35" src="{{ asset('images/SVG') }}/{{ $s->team->short_name }}.svg" alt="{{ $s->team->city }} {{ $s->team->name }}" />
	</td>
	<td>{{ $s->team->division->division }}</td>
	<td>{{ $s->gp }}</td>
	<td>{{ $s->w }}</td>
	<td>{{ $s->l }}</td>
	<td>{{ $s->otl }}</td>
	<td>{{ $s->pts }}</td>
	<td>{{ $s->gf }}</td>
	<td>{{ $s->ga }}</td>
	<td>{{ $s->diff }}</td>
	<td>{{ $s->ppg }}</td>
	<td>{{ $s->ppo }}</td>
	<td>{{ sprintf ("%6.2f", $s->ppp) }}</td>
	<td>{{ $s->ppga }}</td>
	<td>{{ $s->ppoa }}</td>
	<td>{{ sprintf ("%6.2f", $s->pkp) }}</td>
	<td>{{ $s->home }}</td>
	<td>{{ $s->away }}</td>
	<td>{{ $s->l10 }}</td>
	<td>{{ $s->streak }}</td>
</tr>
@endforeach
</tbody>
</table>