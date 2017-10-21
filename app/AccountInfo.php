<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class AccountInfo extends Model
{
	protected $table = 'account_info';

	public function profile(){
		return $this->belongsTo(Profile::class);
	}

}
