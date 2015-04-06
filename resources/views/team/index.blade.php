@extends('layouts.base')
@section('footer-scripts')
@stop
@section('body')
<div class="teams_page">
@foreach ($teams_by_division as $division => $divisionTeams)
	<div class="panel panel-default division">
		<div class="panel-heading">{{ ucfirst(strtolower($division)) }} Division</div>
		<div class="panel-body">
		@foreach ($divisionTeams as $team)
			<div class="team_line" style="background-color: c8c8c8">
			<div class="team_logo">
				<a href="{{ route('team', $team->short_name) }}">
				<img height="50" src="{{ asset('images/SVG') }}/{{ $team->short_name }}.svg"
					alt="{{ $team->city }} {{ $team->name }}" />
				</a>
			</div>
			<div class="team_name">
				{{ $team->city }} {{ $team->name }}
			</div>
			</div>
		@endforeach
		</div>
	</div>
@endforeach
</div>
@stop
