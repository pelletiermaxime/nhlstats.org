<?php use Carbon\Carbon; ?>
@extends('layouts.base')
@section('footer-scripts')
@stop
@section('body')
<table border="1" width="65%" cellspacing="0" align="center">
<tr>
	<td rowspan="4" width="120" style="border:none">
		<img width="120" src="{{ asset('images/SVG') }}/{{ $player->team->short_name }}.svg"
			alt="{{ $player->team->city }} {{ $player->team->name }}"
			title="{{ $player->team->city }} {{ $player->team->name }}" border="0" />
	</td>
	<td colspan="5" align="center" class="thead" style="font-size:20px">
		{{ $player->full_name }}
	</td>
</tr>
<tr>
	<td>Position:</td><td>{{ $player->position }}</td><td>&nbsp;</td>
	<td>Shoots:</td><td>{{ $player->shoots }}</td>
</tr>
<tr>
	<td>Height:</td><td>{{ $player->height }}</td><td>&nbsp;</td>
	<td>Weight:</td><td>{{ $player->weight }}</td>
</tr>
<tr>
	<td>Born:</td><td>{{ $player->birthdate }}</td><td>&nbsp;</td>
	<td>Origin:</td><td>{{ $player->city }}, {{ $player->country }}</td>
</tr>
</table>
<br />
<table width="75%" cellspacing="0" align="center" id="tableSummary" border="0" style="text-align:center">
<thead>
<tr style="font-weight:bold">
	<th colspan="2">Season</th>
	<th>GP</th>
	<th>Goals</th>
	<th>Assists</th>
	<th>Points</th>
	<th>Plus/minus</th>
	<th>PIM</th>
	<th>PP</th>
	<th>SH</th>
	<th>GW</th>
	<th>OT</th>
	<th>S</th>
	<th>S%</th>
	<th>TOI/G</th>
	<th>Sft/G</th>
	<th>FO%</th>
</tr>
</thead>
<tr>
	<td colspan="2">2014-2015</td>
	<td>{{ $stats_year->games }}</td>
	<td>{{ $stats_year->goals }}</td>
	<td>{{ $stats_year->assists }}</td>
	<td>{{ $stats_year->points }}</td>
	<td>{{ $stats_year->plusminus }}</td>
	<td>{{ $stats_year->pim }}</td>
	<td>{{ $stats_year->pp }}</td>
	<td>{{ $stats_year->sh }}</td>
	<td>{{ $stats_year->gw }}</td>
	<td>{{ $stats_year->ot }}</td>
	<td>{{ $stats_year->s }}</td>
	<td>{{ $stats_year->spourcent }}</td>
	<td>{{ $stats_year->TOIG }}</td>
	<td>{{ $stats_year->SftG }}</td>
	<td>{{ $stats_year->FOPourcent }}</td>
</tr>
</table>
<table width="75%" cellspacing="0" align="center" id="tableGameByGame" style="text-align:center">
<thead>
<tr>
	<td>Date</td>
	<td>Adversaire</td>
	<td>Goals</td>
	<td>Pass</td>
	<td>Points</td>
	<td>Plus/Moins</td>
</tr>
</thead>
@foreach ($stats_days as $stats)
	<tr>
		<td>{{ $stats->day }}</td>
		<td>
		<?php $yesterday = Carbon::createFromFormat('Y-m-d', $stats->day)->subDay()->format('Y-m-d'); ?>
		@if (isset($enemies[$yesterday]))
			<img width="25" src="{{ asset('images/SVG') }}/{{ $enemies[$yesterday]->short_name }}.svg"
				alt="{{ $enemies[$yesterday]->city }} {{ $enemies[$yesterday]->name }}"
				title="{{ $enemies[$yesterday]->city }} {{ $enemies[$yesterday]->name }}" border="0" />
		@endif
		</td>
		<td>{{ $stats->goals }}</td>
		<td>{{ $stats->assists }}</td>
		<td>{{ $stats->points }}</td>
		<td>{{ $stats->plusminus }}</td>
	</tr>
@endforeach
@stop
