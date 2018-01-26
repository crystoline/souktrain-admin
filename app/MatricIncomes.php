<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class MatricIncomes extends Model
{
	protected $table = 'matrix_incomes';
    protected $fillable = [
	    'user_id',
	    'upline_id',
	    'plan_condition_id',
	    'amount',
	    'action',
	    'status'
    ];

	public function user(){
		return $this->hasOne(User::class);
	}

	public function upline(){
		return $this->hasOne(User::class, 'id', 'upline_id');
	}

	public function planConndition(){
		return $this->hasOne(PlanCondition::class);
	}
}
