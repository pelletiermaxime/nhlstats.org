<?php

class Team extends Eloquent
{
	public function division()
	{
		return $this->hasOne('Division');
	}
}

?>