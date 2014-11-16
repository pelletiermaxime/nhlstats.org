<h2 align="center">
<?php
$menu = [
	'Players'         => 'index',
	'Goalers'         => 'goalers',
	'Scores'          => 'scores',
	'Standings'       => 'standings',
	'Teams'           => 'teams',
	// 'Playoff Bracket' => route('playoff_bracket'),
	// 'Pool Players'    => route('pool_index'),
];

$menuAliases = [
	'players_filtered'   => 'index',
	'standings_division' => 'standings',
	'standings_wildcard' => 'standings',
];

if (Confide::user()) //Logged-in
{
	// $menu['Pool choices'] = 'pool_me';
	$menu['Logout']       = 'user_logout';
}
else
{
	$menu['Login']  = 'user_login';
	$menu['Signup'] = 'user_create';
}

$currentRouteName = Route::currentRouteName();
?>
@foreach ($menu as $title => $adresse)
	{{-- Don't show link for active pages/subpages --}}
	@if ($currentRouteName != $adresse &&
		(!isset($menuAliases[$currentRouteName]) || $menuAliases[$currentRouteName] != $adresse))
		<a href="{{ route($adresse) }}">{{ $title }}</a>
	@else
		{{ $title }}
	@endif
@endforeach
</h2>
