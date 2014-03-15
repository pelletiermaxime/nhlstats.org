<h2 align="center">
<?php
$menu = [
	'Players'         => route('index'),
	'Goalers'         => route('goalers'),
	'Scores'          => route('scores'),
	'Standings'       => route('standings'),
	'Playoff Bracket' => route('playoff_bracket'),
	// 'Pool Players' => 'index.php?q=Pool/showPlayers',
];
// if (LOGGED)
// {
// 	$menu['Pool'] = "Pool";
// 	$menu['Logout'] = 'index.php?q=Login/logout';
// }
// else
// {
// 	$menu['Login'] = 'Login';
// }
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
