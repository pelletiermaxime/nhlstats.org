<h2 align="center">
<?php
$menu = [
	'Players'         => route('index'),
	'Goalers'         => route('goalers'),
	'Scores'          => route('scores'),
	'Standings'       => route('standings'),
	'Playoff Bracket' => route('playoff_bracket'),
];

if (Confide::user()) //Logged-in
{
	// $menu['Pool choices'] = route('pool/me');
	$menu['Logout']       = url('user/logout');
}
else
{
	$menu['Login']  = url('user/login');
	$menu['Signup'] = url('user/create');
}

$current_page = URL::current();
?>
@foreach ($menu as $titre => $adresse)
	@if ($current_page != $adresse)
		<a href="{{ $adresse }}">{{ $titre }}</a>
	@else
		{{ $titre }}
	@endif
@endforeach
</h2>
