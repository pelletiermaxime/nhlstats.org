<h2 align="center">
<?php
$menu = [
	'Players'         => route('index'),
	'Goalers'         => route('goalers'),
	'Scores'          => route('scores'),
	'Standings'       => route('standings'),
	'Playoff Bracket' => route('playoff_bracket'),
	'Pool Players'    => route('pool_index'),
];

if (Confide::user()) //Logged-in
{
	$menu['Pool choices'] = route('pool_me');
	$menu['Logout']       = url('user/logout');
}
else
{
	$menu['Login']  = url('user/login');
	$menu['Signup'] = url('user/create');
}

$current_page = URL::current();
$route_name = Route::currentRouteName();
?>
@foreach ($menu as $title => $adresse)
	{{-- Don't show link for active pages/subpages --}}
	@if ($current_page != $adresse)
		<a href="{{ $adresse }}">{{ $title }}</a>
	@else
		{{ $title }}
	@endif
@endforeach
</h2>
