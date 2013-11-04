<?php

class PlayerController extends BaseController
{
	public function getListFiltered()
	{
		$data = [
			'name'     => Input::get('name'),
			'team'     => Input::get('team'),
			'position' => Input::get('position'),
			'count'    => Input::get('count'),
		];

		$possible_counts = [
			'50'  => '50',
			'100' => '100',
			'500' => '500',
			'All' => 'All'
		];
		$data['possible_counts'] = $possible_counts;

		//Default to 50 if not a possible count
		if (!isset($possible_counts[$data['count']]))
		{
			$data['count'] = '50';
		}

		// $rules = array(
		// 	'player' => 'alpha_num',
		// );

		// $validator = Validator::make($data, $rules);
		// if ($validator->fails()) {
		// 	$data['errors'] = $validator->messages();
		// }
		// return Redirect::to('index')->withErrors($validator)->withInput();
		// $data = array('name' => $name);
		// return Redirect::to('index')->flash($data);
		return View::make('players',  $data);
	}
}