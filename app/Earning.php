<?php

namespace App;

use Illuminate\Database\Eloquent\Model;


class Earning extends Model {

	public function planId() {
		return $this->plan();
	}

	public function plan() {
		return $this->belongsTo( Plan::class );
	}

	public function userAccountType() {
		return $this->belongsTo( UserAccountType::class );
	}

	public function userAccountTypeId() {
		return $this->belongsTo( UserAccountType::class );
	}

}
