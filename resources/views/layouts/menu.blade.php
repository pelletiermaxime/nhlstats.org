<?php
$menu = [
	'Players'         => 'index',
	'Goalers'         => 'goalers',
	'Scores'          => 'scores',
	'Standings'       => 'standings',
	'Teams'           => 'teams',
	'Playoff Bracket' => 'playoff_bracket',
	'Pool Players'    => 'pool_index',
];

$menuAliases = [
	'players_filtered'   => 'index',
	'standings_division' => 'standings',
	'standings_wildcard' => 'standings',
];

if (\Auth::user()) //Logged-in
{
	$menu['Pool choices'] = 'pool_me';
	$menu['Logout']       = 'user_logout';
}
else
{
	$menu['Login']  = 'user_login';
}

$currentRouteName = Route::currentRouteName();
?>
<nav class="navbar navbar-default navbar-fixed-top" role="navigation">
	<div class="navbar-header">
		<button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
			<span class="sr-only">Toggle navigation</span>
			<span class="icon-bar"></span>
			<span class="icon-bar"></span>
			<span class="icon-bar"></span>
		</button>
		<a class="navbar-brand" href="{{ route('index') }}">Nhlstats</a>
	</div>
	<div class="container-fluid">
		<div class="collapse navbar-collapse">
			<ul class="nav navbar-nav">
			@foreach ($menu as $title => $adresse)
				{{-- Don't show link for active pages/subpages --}}
				@if ($currentRouteName != $adresse &&
					(!isset($menuAliases[$currentRouteName]) || $menuAliases[$currentRouteName] != $adresse))
					<?php $active = 'active'?>
				@else
					<?php $active = ''?>
				@endif
				<li class="{{ $active }}">
					<a href="{{ route($adresse) }}">{{ $title }}</a>
				</li>
			@endforeach
			</ul>
		</div>
	</div>
</nav>
