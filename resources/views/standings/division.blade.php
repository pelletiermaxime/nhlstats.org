@extends('standings.base')
@section('standings')
<table width="80%" id="tableOverall" class="table table-condensed table-striped">
<thead>
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
	<th>ROW</th>
	<th>GF</th>
	<th>GA</th>
	<th>Diff</th>
	<th>Home</th>
	<th>Away</th>
	<th>L10</th>
	<th>Streak</th>
</tr>
</thead>
<tbody>
<?php
	$prevDivision = '';
	$position = 1;
?>
@foreach ($standings as $s)
@if ($prevDivision != '' && $s->division != $prevDivision)
	<?php $position = 1; ?>
	<tr>
		<td >&nbsp;</td>
	</tr>
@endif
<tr>
	@if ($s->conference == 'EAST')
	<td style="background:#b9112d;color:white;font-size:1.8em;">{{ $position++ }}</td>
	@else
	<td style="background:#003872;color:white;font-size:1.8em;">{{ $position++ }}</td>
	@endif
	<td>
		<a href="{{ route('team', $s->short_name) }}">
		<img height="35" src="{{ asset('images/SVG') }}/{{ $s->short_name }}.svg"
			alt="{{ $s->city }} {{ $s->name }}" title="{{ $s->city }} {{ $s->name }}" />
		</a>
	</td>
	<td>{{ $s->division }}</td>
	<td>{{ $s->conference }}</td>
	<td>{{ $s->gp }}</td>
	<td>{{ $s->w }}</td>
	<td>{{ $s->l }}</td>
	<td>{{ $s->otl }}</td>
	<td>{{ $s->pts }}</td>
	<td>{{ $s->row }}</td>
	<td>{{ $s->gf }}</td>
	<td>{{ $s->ga }}</td>
	<td>{{ $s->diff }}</td>
	<td>{{ $s->home }}</td>
	<td>{{ $s->away }}</td>
	<td>{{ $s->l10 }}</td>
	<td>{{ $s->streak }}</td>
</tr>
<?php $prevDivision = $s->division?>
@endforeach
</tbody>
</table>
@stop
