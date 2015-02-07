@extends('standings.base')
@section('standings')
<table width="80%" id="tableOverall" class="table table-condensed table-striped">
<thead>
<tr>
	<th colspan="12">&nbsp;</th>
	<th colspan="3" style="border:1px solid black;border-bottom:none;">Powerplay</th>
	<th colspan="3" style="border:1px solid black;border-bottom:none;">Penalty kill</th>
	<th colspan="4">&nbsp;</th>
</tr>
<tr>
	<th>Position</th>
	<th>Team</th>
	<th>Division</th>
	<th>Conference</th>
	<th>GP</th>
	<th>W</th>
	<th>L</th>
	<th>OTL</th>
	<th>PTS</th>
	<th>GF</th>
	<th>GA</th>
	<th>Diff</th>
	<th style="border-left:1px solid black;border-top:none;" title="Goals">G</th>
	<th style="border-top:none;" title="Opportunities">O</th>
	<th style="border-right:1px solid black;border-top:none;" title="Percent">P</th>
	<th style="border-left:1px solid black;border-top:none;" title="Goals Against">G</th>
	<th style="border-top:none;" title="Opportunities against">O</th>
	<th style="border-right:1px solid black;border-top:none;" title="Penalty Kill Percent">P</th>
	<th>Home</th>
	<th>Away</th>
	<th>L10</th>
	<th>Streak</th>
</tr>
</thead>
<tbody>
@foreach ($standings as $position => $s)
<tr>
	@if ($s->conference == 'EAST')
	<td style="background:#b9112d;color:white;font-size:1.8em;">{{ ++$position }}</td>
	@else
	<td style="background:#003872;color:white;font-size:1.8em;">{{ ++$position }}</td>
	@endif
	<td>
		<a href="{{ route('team', $s->short_name) }}">
		<img height="35" src="{{ asset('images/SVG') }}/{{ $s->short_name }}.svg"
			alt="{{ $s->city }} {{ $s->name }}" />
		</a>
	</td>
	<td>{{ $s->division }}</td>
	<td>{{ $s->conference }}</td>
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
@stop
