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
	<th title="Regular or Overtime Wins">ROW</th>
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
@include('standings/wildcard-header', ['titre' => 'Atlantic'])
@include('standings/standingBlock', ['standings' => $standings['conference']['ATLANTIC']])
@include('standings/wildcard-header', ['titre' => 'Metropolitan'])
@include('standings/standingBlock', ['standings' => $standings['conference']['METROPOLITAN']])
@include('standings/wildcard-header', ['titre' => 'Wild Card'])
@include('standings/standingBlock', ['standings' => $standings['wildcard']['EAST']])
@include('standings/wildcard-header', ['titre' => 'Central'])
@include('standings/standingBlock', ['standings' => $standings['conference']['CENTRAL']])
@include('standings/wildcard-header', ['titre' => 'Pacific'])
@include('standings/standingBlock', ['standings' => $standings['conference']['PACIFIC']])
@include('standings/wildcard-header', ['titre' => 'Wild Card'])
@include('standings/standingBlock', ['standings' => $standings['wildcard']['WEST']])
</tbody>
</table>
@stop
