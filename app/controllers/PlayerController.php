<?php

class PlayerController extends BaseController {

	public function getList()
	{
		return View::make('players');
	}

}