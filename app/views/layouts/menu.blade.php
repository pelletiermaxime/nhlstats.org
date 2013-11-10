<h2 align="center">
<?php
$menu = array(
	'Players'         => route('index'),
	// GARDIENS          => P_GARDIENS,
	// 'Scores'          => P_EQUIPES,
	'Standings'       => route('standings'),
	//NOUVELLES         => P_NOUVELLES,
	// 'Playoff Bracket' => P_POBRACKET,
	// 'Pool Players' => 'index.php?q=Pool/showPlayers',
	);
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
foreach ($menu as $titre => $adresse)
{
	if ($current_page != $adresse) :
	?>
		<a href="{{ $adresse }}"><?=$titre?></a>
	<?php else :?>
		<?=$titre?>
	<?php
	endif;
}
?>
</h2>
