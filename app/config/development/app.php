<?php

return [
	'debug' => true,
	'url'   => 'http://nhlstats/'
	'providers' => append_config([
		'Barryvdh\LaravelIdeHelper\IdeHelperServiceProvider',
		'Way\Generators\GeneratorsServiceProvider',
	]),
];
