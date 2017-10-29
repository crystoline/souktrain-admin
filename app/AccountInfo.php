<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class AccountInfo extends Model
{
	protected $table = 'account_info';
	protected $primaryKey  ='id';


	public function profile(){
		return $this->belongsTo(Profile::class);
	}

}
