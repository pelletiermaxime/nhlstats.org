<?php namespace App\Http\Models;

use Illuminate\Database\Eloquent\Model;

class Player extends Model
{
	protected $guarded = array();

	public static $rules = array();

	public function team()
	{
		return $this->belongsTo('App\Http\Models\Team');
	}
}
